#include <iostream>
#include <cstdlib>
int maxsumnoncon(int[], int, int[]);
int main(){
	int items[] = {1,3,9,4,5,3,7,9};
	int output[8];
	std::cout << maxsumnoncon(items,8,output) << std::endl;
	return 1;
}
int maxsumnoncon(int input[], int N, int output[])
{
	int sum[8];
	int k = 0;
	sum[0] = input[0];
	if(input[1] > input[0]){
		sum[1] = input[1];
		output[k++] = input[1];
	}
	else{
		sum[1] = input[0];
		output[k++] = input[0];
	}
	for(int i = 2; i < 8; i++){
		if(sum[i - 1] > input[i] + sum[i - 2]){
			sum[i] = sum[i - 1];
			output[k] = 0;
		}
		else{
			sum[i] = input[i] + sum[i - 2];
			output[k++] = input[i];
		}
	}
	return sum[N - 1];
}