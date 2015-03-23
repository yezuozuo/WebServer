#include "common.h"

int main()
{
	//服务器端和客户端的地址结构
	struct sockaddr_in sin,cin;
	//地址结构的长度
	socklen_t len = sizeof(cin);
	//套接字的标识符
	int lfd,cfd,fd;
	//进程的标志符
	pid_t pid;
	//套接字选项
	int sock_opt = 1;
	//端口号
	int port;
	//文件路径缓冲区
	char path[MAX_LINE];
	//文件的状态结构
	struct stat statbuf;
	//安装信号处理函数
	//在一个进程终止或者停止时，将SIGCHLD信号发送给其父进程。按系统默认将忽略此信号。如果父进程希望被告知其子系统的这种状态，则应捕捉此信号。信号的捕捉函数中通常调用wait函数以取得进程ID和其终止状态。
	signal(SIGCHLD,SIG_IGN);		//对SIGCHLD信号用SIG_IGN处理
	signal(SIGPIPE,SIG_IGN);			//对SIGPIPE信号用SIG_IGN处理
	printf("initializing...\n");
	if(init(&sin,&lfd,&port,path) == -1)	//初始化
	{
		DEBUG_PRINT("init error\n");
		exit(1);
	}
	
	//不断接收并且处理连接请求
	while(1)
	{
		DEBUG_PRINT("waiting connections...\n");
		//创建连接套接字
		//lfd为监听套接字
		printf("lfd:%d\n",lfd );
		cfd = accept(lfd,(struct sockaddr *)&cin,&len);
		if(cfd == -1)
		{
			perror("fail to accept\n");
			exit(1);
		}
		//创建一个新的进程，用于并发处理请求
		pid = fork();
		if(pid < 0)
		{
			perror("fail to fork\n");
			exit(1);
		}
		//用子进程来处理请求
		else if(pid == 0)
		{
			//关闭监听套接字
			close(lfd);
			//分析客户端发来的信息，得到请求文件的路径
			if(get_path(cfd,path) == -1)
			{
				DEBUG_PRINT("get filepath error\n");
				exit(1);
			}
			//printf("%d\n",fd );
			if((fd = open(path,O_RDONLY)) < 0)	//打开文件
			{
				if(error_page(cfd) == -1)
				{
					DEBUG_PRINT("waiting error-page error\n");
					exit(1);
				}
				close(cfd);
				exit(0);
			}
			//得到文件的状态
			if(fstat(fd,&statbuf) < 0)
			{
				perror("fail to get file status");
				exit(1);
			}
		

			//判断要传输的文件是不是一个普通文件
			//S_ISREG是否是一个常规文件
			if(!S_ISREG(statbuf.st_mode))	//不是普通文件的话
			{
				//输出错误页面
				if(error_page(cfd) == -1)
				{
					DEBUG_PRINT("write error-page error\n");
					close(cfd);
					exit(1);
				}
				close(cfd);
				exit(1);
			}

			//如果是可执行文件的话
			//S_IXOTH 00001 其他用户具可执行权限
			if(statbuf.st_mode & S_IXOTH)
			{
				//将连接套接字重定向到标准输出
				/*
					函数名： dup2
					功能： 复制文件句柄
					用法： int dup2(int oldhandle,int newhandle);
				*/
				
				dup2(cfd,STDOUT_FILENO);
				
				/*
				exec函数族的作用是根据指定的文件名找到可执行文件，
				并用它来取代调用进程的内容，换句话说，
				就是在调用进程内部执行一个可执行文件。
				*/

				//执行该可执行文件
				if(execl(path,path,NULL) == -1)
				{
					perror("fail to execl\n");
					exit(1);
				}
			}

			//如果不是可执行文件的话,则需要把文件内容返回到客户端
			//权限为只读
			if((fd = open(path,O_RDONLY)) < 0)	//打开文件
			{
				if(error_page(cfd) == -1)
				{
					DEBUG_PRINT("waiting error-page error\n");
					exit(1);
				}
				close(cfd);
				exit(0);
			}
			//输出页面
			if(write_page(cfd,fd,path) == -1)
			{
				DEBUG_PRINT("waiting page error");
				exit(0);
			}
			//关闭文件
			close(fd);
			//关闭连接套接字,由服务器主动关闭
			exit(0);
		}
		else
		{
			close(cfd);
		}
	}
	return 0;
}
