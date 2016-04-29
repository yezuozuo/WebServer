#include "common.h"
/*
configuration()读取配置文件，对端口号和根目录进行配置
成功返回0，失败返回1 
*/
static int configuration(int * port,char * path)
{
	int i;
	FILE * fp;
	char * p;
	//文件内容的缓冲区
	char buf[50];
	//打开配置文件s
	fp = fopen("./config.ini","r");

	if(fp == NULL)
	{
		perror("fail to open config.ini\n");
		return -1;
	}
	//读取数据
	while(fgets(buf,50,fp) != NULL)
	{
		printf("%s\n",buf );
		//判断文件格式
		if(buf[strlen(buf) - 1] != '\n')
		{
			DEBUG_PRINT("error in config.ini format\n");
			return -1;
		}
		//添加结束符
		else
		{
			buf[strlen(buf) - 1] = '\0';
		}

		//读取port
		/*
		strstr() 函数搜索一个字符串在另一个字符串中的第一次出现。
		找到所搜索的字符串，
		则该函数返回第一次匹配的字符串的地址；
		如果未找到所搜索的字符串，则返回NULL。
		*/
		if(strstr(buf,"port") == buf)
		{
			/*
			extern char *strchr(const char *s,char c);
			查找字符串s中首次出现字符c的位置。
			*/
			if((p = strchr(buf,':')) == NULL)
			{
				DEBUG_PRINT("config.ini expect ':'\n");
				return -1;
			}
			//跳过“：”和空格，读取port
			*port =  atoi(p + 2);
			if(*port <= 0)
			{
				DEBUG_PRINT("error port\n");
				return -1;
			}
		}
		//读取根目录
		else if(strstr(buf,"root-path") == buf)
		{
			if((p = strchr(buf,':')) == NULL)
			{
				DEBUG_PRINT("config.ini expect ':'\n");
				return -1;
			}
			//跳过“：”读取root-path
			p++;
			p++;
			strcpy(path,p);
			//将根目录复制到path缓冲区，该缓冲区在main函数中是可见的	
		}
		else
		{
			DEBUG_PRINT("error in config.ini\n");
			return -1;
		}
	}

	return 0;
}

/*
init()完成对服务器套接字的初始化
成功返回0，失败返回-1
lfd被设置成监听的socket标志符
*/
int init(struct sockaddr_in * sin,int * lfd,int * port,char * path)
{
	int tfd;
	//读取配置文件
	configuration(port,path);
	printf("%d\n%s\n",*port,path );
	//清空地址结构
	bzero(sin,sizeof(struct sockaddr_in));
	//设置IPV4
	sin->sin_family = AF_INET;
	//设置服务器可以接收任意IP
	sin->sin_addr.s_addr = INADDR_ANY;
	//设置端口
	sin->sin_port = htons(*port);
	//建立连接
	//tfd为建立的socket连接标志符
	if((tfd = socket(AF_INET,SOCK_STREAM,0)) == -1)
	{
		perror("fail to create socket/n");
		return -1;
	}
	//绑定客户端地址，没有具体地址的限制
	if((bind(tfd,(struct sockaddr *)sin,sizeof(struct sockaddr_in))) == -1)
	{
		perror("fail to bind\n");
		return -1;
	}
	//监听端口
	if((listen(tfd,20)) == -1)
	{
		perror("fail to listen\n");
		return -1;
	}
	*lfd = tfd;
	printf("lfd:%d\n",*lfd );
	DEBUG_PRINT("init done\n");
	return 0;
}

/*
get_path()分析客户端发送的HTTP协议头的第一行，分析出所需要的文件路径
成功返回0，失败返回-1
cfd	连接套接字
path 	服务器的根目录，用于和解析出的文件路径拼成服务器上的完整文件路径
*/
int get_path(int cfd,char * path)
{
	printf("getpath\n");
	printf("%d\n%s\n",cfd,path);
	char buf[MAX_LINE];
	//读取HTTP协议头的第一行
	if(my_read(cfd,buf,MAX_LINE) == -1)
	{
		DEBUG_PRINT("my_read error\n");
		return -1;
	}

	/*
	HTTP协议头的第一行的格式为 GET / HTTP/1.1
	第五个字符开始是文件路径	
	*/
	if(strstr(buf,"GET") != buf)
	{
		DEBUG_PRINT("wrong request\n");
		return -1;
	}
	//没有指定文件名，使用默认的文件
	if(buf[4] == '/' && (buf[5] == ' '))
	{
		strcat(path,"/index.html");
		//printf(",%s\n",path );
	}
	else
	{
		/*
		char *strtok(char s[], const char *delim);
		分解字符串为一组字符串。
		s为要分解的字符串，delim为分隔符字符串。
		例如：strtok("abc,def,ghi",",")，
		最后可以分割成为abc def ghi.尤其在点分十进制的IP中提取应用较多。
		*/
		strtok(&buf[4]," ");
		strcat(path,&buf[4]);
	}
	return 0;
}

/*
向客户端输出错误页面
sock_fd是连接套接字
成功返回0，错误返回-1
*/
int error_page(int sock_fd)
{
	char err_str[1024];
	#ifdef DEBUG
		// strerror()获取系统错误信息或打印用户程序错误信息。
		sprintf(err_str,"HTTP/1.1 404 %s"\r\n,strerror(errno.h));
	#else
		sprintf(err_str,"HTTP/1.1 404 not exist\r\n");
	#endif

	if(my_write(sock_fd,"Content-Type:text/html\r\n\r\n",strlen("Content-Type:text/html\r\n\r\n")) == -1)
	{
		return -1;
	}
	if(my_write(sock_fd,"<html><body>the file does not exist</body></html>",strlen("<html><body>the file does not exist</body></html>")) == -1)
	{
		return -1;
	}
	return 0;
}

/*
向客户端输出序言的页面
cfd	连接套接字
path  	需要文件的完整路径
成功返回0，失败返回-1
*/
int write_page(int cfd,int fd,char * path)
{
	int n;
	char buf[MAX_LINE];
	if(my_write(cfd,"HTTP/1.1 200 OK\r\n",strlen("HTTP/1.1 200 OK")) == -1)
	{
		return -1;
	}
	if(my_write(cfd,"Content-Type:",strlen("Content-Type:")) == -1)
	{
		return -1;
	}

	n = strlen(path);

	//以下的三个if用来写Content-type的类型
	//strcasecmp用于忽略大小写比较字符串.
	//暂时支持三种图片格式，表示图片类型
	//jpg或者jpeg
	if((strcasecmp(&path[n - 3],"jpg") == 0) || (strcasecmp(&path[n - 4],"jpeg") == 0))
	{
		if(my_write(cfd,"image/jpeg",strlen("image/jpeg")) == -1)
		{
			return -1;
		}
	}
	//gif
	else if((strcasecmp(&path[n - 3],"gif") == 0))
	{
		if(my_write(cfd,"image/gif",strlen("image/gif")) == -1)
		{
			return -1;
		}
	}
	//png
	else if((strcasecmp(&path[n - 3],"png") == 0))
	{
		if(my_write(cfd,"image/png",strlen("image/png")) == -1)
		{
			return -1;
		}
	}
	//纯文本类型
	else
	{
		if(my_write(cfd,"text/html",strlen("text/html")) == -1)
		{
			return -1;
		}
	}

	//添加协议结尾
	if(my_write(cfd,"\r\n\r\n",4) == -1)
	{
		return -1;
	}

	//传输文件内容
	while((n = read(fd,buf,MAX_LINE)) > 0)
	{
		if(my_write(cfd,buf,n) == -1)
		{
			return -1;
		}
	}
}