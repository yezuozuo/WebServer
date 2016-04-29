/*
自己的文件I／O函数库
*/
//#include <stdio.h>
#include <fcntl.h>
#include <unistd.h>
#include <errno.h>
#include <stdio.h>

/*
封装read()函数，增加可出错处理，参数和返回值都与read()相同
*/
ssize_t my_read(int fd,void* buffer,size_t length)
{
	//读入的字节数
	//printf("fd:%d\nlength:%d\n",fd,(int)length );
	ssize_t done = length;

	//如果因为信号中断而导致异常，则多次读取
	while(done > 0)
	{
		done = read(fd,buffer,length);
		// printf("fd:%d\n",fd );
		// printf("buffer:%s\n",(char *)buffer );
		// printf("length:%d\n",(int)length );
		// printf("done:%d\n",(int)done );
		//异常出错
		if(done == -1 )
		{
			//printf("%d\n",errno );
			//如果是信号中断导致的错误，则舍弃已读入的内容，重新读入
			if(errno == EINTR)
			{
				done = length;
			}
			else
			{
				//perror(errno);
				perror("fail to read\n");
				return -1;
			}
		}
		else
		{
			break;
		}
	}
	//返回实际读入的字节数
	return done;
}

/*
封装write()函数，增加可出错处理，参数和返回值都与write()相同
*/
ssize_t my_write(int fd,void*buffer,size_t length)
{
	//读入的字节数
	ssize_t done = length;

	//如果因为信号中断而导致异常，则多次写缓冲区
	while(done > 0)
	{
		done = write(fd,buffer,length);
		//异常出错
		if(done != length)
		{
			//如果是信号中断导致的错误，则舍弃已写入的内容，重新写
			if(errno == EINTR)
			{
				done = length;
			}
			else
			{
				perror("fail to read\n");
				return -1;
			}
		}
		else
		{
			break;
		}
	}
	//返回实际写的字节数
	return done;
}