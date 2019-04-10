
#include "cuda_runtime.h"
#include "device_launch_parameters.h"

#include <string>
#include <iostream>
#include <iomanip>
#include <fstream>
#include <vector>
#include <locale>
#include <algorithm>
#include <cstdio>
//-------------------------------------------------
//#ifndef __CUDACC__ 
//#define __CUDACC__
//#endif
//#include "cuda_runtime.h"
//#include "device_launch_parameters.h"
//#include <cuda.h>
//#include <device_functions.h>
//#include <cuda_runtime_api.h>

const int maxWordLength = 10;
const int arrayCount = 5;
const int inArrayCount = 11;
//std::vector<std::vector<Stud>> Read(std::string fileName);

//__device__ void charCpy(int index, char *dataWord, char *name);
//__global__ void addKernel(Stud **Q, Stud *Ans);

class Stud {
public:
	char name[maxWordLength * arrayCount] = {};
	int grades;
	double average;
	Stud() {}
	Stud(char name[], int grades, double average) {
		strcpy(this->name, name);
		this->grades = grades;
		this->average = average;
	}
};

__device__ void charCpy(int index, char *dataWord, char *name) {
	int tempi = 0;
	while (dataWord[tempi] != NULL)
	{
		name[index] = dataWord[tempi];
		tempi++;
		index++;
	}
}

__global__ void addKernel(Stud **Q, Stud *Ans)
{
	int i = threadIdx.x;
	
	__shared__ char name[inArrayCount][arrayCount * maxWordLength];
	__shared__ int nmb[inArrayCount];
	__shared__ double average[inArrayCount];
	
	nmb[i] = 0;
	average[i] = 0;
	for (int j = 0; j < arrayCount * maxWordLength; j++)
	{
		name[i][j] = NULL;
	}

	for (int j = 0; j < arrayCount; j++)
	{
		for (int q = 0; q < maxWordLength * arrayCount; q++)
		{
			if (name[i][q] == NULL)
			{
				charCpy(q, Q[j][i].name, name[i]);
				break;
			}
		}
		nmb[i] += Q[j][i].grades;
		average[i] = average[i] + Q[j][i].average;
	}

	charCpy(0, name[i], Ans[i].name);
	Ans[i].grades = nmb[i];
	Ans[i].average = average[i];
	//printf("%d-%s", i, Ans[i].name);
}



std::vector<std::vector<Stud>> Read(std::string fileName/*, std::vector<std::vector<Stud>> A*/)
{
	std::vector<std::vector<Stud>> A;
	std::ifstream in;
	in.open(fileName);
	while (!in.eof())
	{

		int len;
		in >> len;
		std::vector<Stud> temp;
		for (size_t i = 0; i < len; i++)
		{
			std::string name;
			in >> name;
			int nmb;
			in >> nmb;
			double average;
			in >> average;
			char tempWord[maxWordLength] = {};
			std::transform(name.begin(), name.end(), name.begin(), ::tolower);//change string letters to lower cases
			strcpy(tempWord, name.c_str());//put string to chars
			temp.push_back(Stud(tempWord, nmb, average));
		}
		A.push_back(temp);
	}
	in.close();
	return A;
}

void Write(std::string fileName, std::vector<std::vector<Stud>> dataArray, Stud *Ans)
{
	std::ofstream out;
	out.open(fileName);

	int a = 0;
	out << "Pradiniai duomenys" << std::endl;
	for (std::vector<Stud> data : dataArray)
	{
		//out << data[a].getLessonName() << endl;
		out << "Nr. Vardas    Pazymiu_skaicius  Vidurkis" << std::endl;
		int s = 0;
		for (Stud student : data)
		{
			s++;
			out << std::left << std::setw(4) << s << std::setw(10) << student.name << std::setw(18) << student.grades << student.average << std::endl;
		}
		a++;
	}
	out << std::endl;
	out << "Rezultatas" << std::endl;
	out << std::left << std::setw(40) << "Vardai" << std::setw(10) << "Pazymiai" << "Vidurkiai" << std::endl;
	for (int i = 0; i < inArrayCount; i++)
	{
		out << std::left << std::setw(40) << Ans[i].name << std::setw(5) << Ans[i].grades << Ans[i].average << std::endl;
	}
	out << std::endl;
	out.close();
}

int main()
{
	std::vector<std::vector<Stud>> A;//data
	/*const int arrayCount = 5;
	const int inArrayCount = 11;*/

	A = Read("IFF68_LaurinaitisTadas_L4.txt");
	
	std::vector<std::vector<Stud>> dataArray;//data
	dataArray = A;
	Stud arrayA[arrayCount][inArrayCount];
	for (int i = 0; i < arrayCount; i++)
	{
		for (int j = 0; j < inArrayCount; j++)
		{
			arrayA[i][j] = A[i][j];
		}
	}
	//dataArray = arrayA;

	Stud** dev_Q;
	cudaMalloc((void**)&dev_Q, arrayCount * sizeof(Stud*));//for stud arrays 5
	for (int i = 0; i < arrayCount; i++)
	{
		Stud* temp_Q = nullptr;
		cudaMalloc((void**)&temp_Q, inArrayCount * sizeof(Stud));
		cudaMemcpy(temp_Q, &arrayA[i], inArrayCount * sizeof(Stud), cudaMemcpyHostToDevice);
		cudaMemcpy(&dev_Q[i], &temp_Q, sizeof(Stud*), cudaMemcpyHostToDevice);
	}
	Stud Ans[inArrayCount] = {};
	Stud *dev_Ans;
	cudaMalloc((void**)&dev_Ans, inArrayCount * sizeof(Stud));
	cudaMemcpy(dev_Ans, Ans, inArrayCount * sizeof(int), cudaMemcpyHostToDevice);
	//addKernel << < 1, arrayCount >> > (dev_Q, dev_Ans);
	addKernel << < 1, inArrayCount >> > (dev_Q, dev_Ans);
	cudaMemcpy(Ans, dev_Ans, inArrayCount * sizeof(Stud), cudaMemcpyDeviceToHost);
	cudaFree(dev_Q);
	cudaFree(dev_Ans);

	for (int i = 0; i < inArrayCount; i++)
	{
		std::cout << Ans[i].name << " " << Ans[i].grades << " " << Ans[i].average << " ";
		std::cout << std::endl;
	}
	Write("IFF68_LaurinaitisTadas_L4a_rez.txt", dataArray, Ans);
    return 0;
}