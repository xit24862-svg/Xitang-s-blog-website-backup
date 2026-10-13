#include<stdio.h>
#include<stdlib.h>
int main(){

    int i;
    float grade;
    float xuef;
    float fen_zi=0;
    float aver_jidian;
    float sum=0;
    printf("成绩: \n");
    printf("学分: \n");
    for(i=0;i<8;i++){
        
        scanf("%f %f",&grade,&xuef);
        fen_zi+=(grade-50)*0.1*xuef;
        sum+=xuef;
    }
    aver_jidian=fen_zi/sum;
    float zhiyu;
    zhiyu=((aver_jidian*10)+50)*0.55;
    printf("智育：%f\n",zhiyu);


    return 0;
}