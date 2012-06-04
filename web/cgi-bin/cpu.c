#include <stdio.h> 
#include <stdlib.h> 
#include <ctype.h> 
#include <string.h> 
#include <fcntl.h> 

struct occupy
{        
        unsigned int user;
        unsigned int nice;
        unsigned int system;
        unsigned int idle;
};

int get_occupy (struct occupy *o)
{
        FILE *fd;        
        char buff[1024];
        char name[20];
        fd = fopen ("/proc/stat", "r");
        fgets (buff, sizeof(buff), fd);                
        fgets (buff, sizeof(buff),fd);
        sscanf (buff, "%s %u %u %u %u", name, &(o->user),
                                        &(o->nice),&(o->system), &(o->idle));        
        fclose(fd);
        return 0;
}


int cal_occupy (struct occupy *o, struct occupy *n)
{
        double od, nd;
        double id, sd;
        double scale;
        od = (double) (o->user + o->nice + o->system + o->idle);
        nd = (double) (n->user + n->nice + n->system + n->idle);
        scale = 100.0 / (float)(nd-od);
        id = (double) (n->user - o->user);
        sd = (double) (n->system - o->system);
        return (int)(((sd+id)*100.0)/(nd-od));
}


int GetCpuUesd()
{        
        struct occupy ocpu;
        struct occupy ncpu;         
        sleep(1);
        get_occupy(&ocpu);
        sleep(1);
        get_occupy(&ncpu);                
        return cal_occupy(&ocpu, &ncpu);
} 
int main()
{
	int cpu=0;
	cpu=GetCpuUesd();
	printf("Content-type: text/plain\n\n");
	printf("%d\n",cpu);
	return 0;
}