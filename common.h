/*
common.h
包括所有函数接口的声明，全局变量的声明
以及所使用的头文件以及全局宏的声明
*/

//头文件
#include <stdio.h>
#include <string.h>
#include <netinet/in.h>
#include <stdlib.h>
#include <fcntl.h>
#include <sys/stat.h>
#include <unistd.h>
#include <signal.h>
#include <errno.h>

//自己写的读写 I／O 库函数
#include "iolib.h"

//宏
#define MAX_LINE 1024		//缓冲区的最大长度

//调试开关
#define BUG 1						//1为开调试，0为关调试

//用宏来定义调试输出语句
#ifdef BUG
#define	DEBUG_PRINT(str);	printf(str);
#endif

//函数接口声明
//到web_server.c中寻找定义
/*
参数
struct sockadd_in    	通信的地址
int * lfd		       	已经创建好的套接字描述符
int * port		端口号
char * path 		文件路径
返回值0/-1

*/
extern int init(struct sockaddr_in * sin,int * lfd,int * port,char * path);	//初始化函数
extern int error_page(int sock_fd);					//显示错误页面的函数
extern int get_path(int cfd,char * path);					//获取文件路径的函数
extern int write_page(int cfd,int fd,char * path);				//显示页面的函数