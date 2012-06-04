#include <stdio.h> 
#include <stdlib.h> 
#include <ctype.h> 
#include <string.h> 
#include <fcntl.h> 

struct occupy
{        
        unsigned int total;
        unsigned int memfree;
		unsigned int buffers;
		unsigned int cached;
};

int get_memoccupy (struct occupy *o)
{
        FILE *fd;
		int n,m,u;
        char buff[256];
		char name[20];
        fd = fopen ("/proc/meminfo", "r");
        fgets (buff, sizeof(buff), fd);
		sscanf (buff, "%s %u", name, &(o->total));
		fgets (buff, sizeof(buff), fd);
		sscanf (buff, "%s %u", name, &(o->memfree));
		fgets (buff, sizeof(buff), fd);
		sscanf (buff, "%s %u", name, &(o->buffers));
		fgets (buff, sizeof(buff), fd);
		sscanf (buff, "%s %u", name, &(o->cached));
        fclose(fd);
        return 0;
}


int cal_memoccupy (struct occupy *o)
{
        return (int)((o->total)-((o->memfree)+(o->buffers)+(o->cached)))*100/(o->total);
}


int GetMemUesd()
{        
        struct occupy mem;
        get_memoccupy(&mem);
        return cal_memoccupy(&mem);
} 
int main()
{
        int umem=0.0;
        umem=GetMemUesd();
        printf("Content-type: text/plain\n\n");
        printf("%d\n",umem);
        return 0;
}