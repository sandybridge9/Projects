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
#include <thrust/host_vector.h>
#include <thrust/device_vector.h>

using namespace std;

const int maxWordLength = 10;
const int arrayCount = 5;
const int inArrayCount = 11;

class Stud {
public:
	char name[maxWordLength * arrayCount] = {};
	int grades = 0;
	double average = 0;
	__host__ __device__ Stud() {}
	__host__ __device__ Stud(char name[], int grades, double average) {
		for (int i = 0; i < maxWordLength * arrayCount; i++) {
			this->name[i] = name[i];
			if (name[i] == NULL)
			{
				break;
			}
		}
		//strcpy(this->name, name);
		this->grades = grades;
		this->average = average;
	}
};

//struct is_good {
//	const int index;
//
//	is_good(int _index) : index(_index) {}
//
//	__device__
//		bool operator()() {
//		return index % inArrayCount == 0;
//	}
//	/*__device__ bool operator ()(int index) {
//		return index % inArrayCount == 0;
//	}*/
//};

struct sum_func {
	__device__ Stud operator ()(Stud accumulator, Stud item) {
		for (int i = 0; i < maxWordLength * arrayCount; i++) {
			if (accumulator.name[i] == NULL) {
				int index = i;
				int tempi = 0;
				while (item.name[tempi] != NULL)
				{
					accumulator.name[index] = item.name[tempi];
					tempi++;
					index++;
				}
				break;
			}
		}
		accumulator.grades += item.grades;
		accumulator.average += item.average;
		return accumulator;
	}
};

thrust::host_vector<Stud> Read(std::string fileName)
{
	//thrust::host_vector<thrust::host_vector<Stud>> A;
	thrust::host_vector<Stud> A;
	std::ifstream in;
	in.open(fileName);
	while (!in.eof())
	{

		int len;
		in >> len;
		//thrust::host_vector<Stud> temp;
		//std::vector<Stud> temp;
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
			A.push_back(Stud(tempWord, nmb, average));
		}
		//A.push_back(temp);
	}
	in.close();
	return A;
}

void Write(std::string fileName, thrust::host_vector<Stud> dataArray, thrust::host_vector<Stud> Ans)
{
	std::ofstream out;
	out.open(fileName);

	int a = 0;
	out << "Pradiniai duomenys" << std::endl;
	for (int i = 0; i < arrayCount; i++)//5
	{
		out << "Nr. Vardas    Pazymiu_skaicius  Vidurkis" << std::endl;
		int s = 0;
		for (int j = 0; j < inArrayCount; j++)//11
		{
			out << std::left << std::setw(4) << j + 1 << std::setw(10) << static_cast<Stud>(dataArray[j]).name << std::setw(18) << static_cast<Stud>(dataArray[j]).grades << static_cast<Stud>(dataArray[j]).average << std::endl;
		}
	}
	out << std::endl;
	out << "Rezultatas" << std::endl;
	out << std::left << std::setw(40) << "Vardai" << std::setw(10) << "Pazymiai" << "Vidurkiai" << std::endl;
	for (int i = 0; i < inArrayCount; i++)
	{
		out << std::left << std::setw(40) << static_cast<Stud>(Ans[i]).name << std::setw(10) << static_cast<Stud>(Ans[i]).grades << static_cast<Stud>(Ans[i]).average << std::endl;
	}
	out << std::endl;
	out.close();
}

// Pagrindinë programa
int main()
{
	thrust::host_vector<Stud> data;
	thrust::device_vector<Stud> dev_data;
	//thrust::device_vector<Stud> rez_temp(arrayCount);
	thrust::device_vector<Stud> dev_rez(inArrayCount);
	//dev_rez[0] = rez_temp[2];
	data = Read("IFF68_LaurinaitisTadas_L4.txt");
	//int i = 0;
	dev_data = data;
	//copy_if(dev_data.begin + i, dev_data.end, rez_temp, is_good());

	int begin = 0;
	for (int i = 0; i < inArrayCount; i++)//11
	{
		thrust::device_vector<Stud> dev_temp;
		for (int j = 0; j < inArrayCount * arrayCount; j++)//55
		{
			if ((j + begin) % inArrayCount == 0) {
				Stud tmp = static_cast<Stud>(dev_data[j]);
				dev_temp.push_back(tmp);
			}
		}
		Stud temp;
		dev_rez[i] = thrust::reduce(dev_temp.begin(), dev_temp.end(), temp, sum_func());

		begin--;
	}
	/*for (int i = 0; i < inArrayCount; i++)
	{
		std::cout << static_cast<Stud>(dev_rez[i]).name << static_cast<Stud>(dev_rez[i]).grades << static_cast<Stud>(dev_rez[i]).average << std::endl;
	}*/
	thrust::host_vector<Stud> rez;
	rez = dev_rez;
	Write("IFF68_LaurinaitisTadas_L4_rez.txt", data, rez);
	return 0;
}