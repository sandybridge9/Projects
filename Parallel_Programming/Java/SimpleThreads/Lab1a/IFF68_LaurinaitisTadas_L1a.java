//Atsakymai i klausimus: 1.tokia, kokia uzrasyti; 2.atsitiktine; 3.atsitiktini skai£iu; 4. tokia, kokia sura²yti duomenu masyve;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.FileReader;
import java.io.FileWriter;
import java.util.ArrayList;
import java.util.List;

public class IFF68_LaurinaitisTadas_L1a {
	
	public static void main(String[] args) {
		
		execute();
	}
	
	public static void execute() {
	
		String fileToReadFrom = "./IFF68_LaurinaitisTadas_L1a_dat.txt";
		String fileToWriteTo = "./IFF68_LaurinaitisTadas_L1a_rez.txt";
		Student[] students = readDataFromFile(fileToReadFrom);
		Student[] arrayToWriteTo = new Student[30];

		Student[] thread1Data = new Student[10];
		Student[] thread2Data = new Student[10];
		Student[] thread3Data = new Student[10];
		Student[] thread4Data = new Student[10];
		Student[] thread5Data = new Student[10];
		
		int count1 = 0;
		int count2 = 0;
		int count3 = 0;
		int count4 = 0;
		int count5 = 0;
		
		for(int i = 0; i < students.length; i++) {
			
			if(students[i].threadNum == 1) {
				thread1Data[count1] = students[i];
				count1++;
			}
			else if(students[i].threadNum == 2) {
				thread2Data[count2] = students[i];
				count2++;
			}
			else if(students[i].threadNum == 3) {
				thread3Data[count3] = students[i];
				count3++;
			}
			else if(students[i].threadNum == 4) {
				thread4Data[count4] = students[i];
				count4++;
			}
			else if(students[i].threadNum == 5) {
				thread5Data[count5] = students[i];
				count5++;
			}
		}
		
		MyThread thread1 = new MyThread(thread1Data, arrayToWriteTo);
		MyThread thread2 = new MyThread(thread2Data, arrayToWriteTo);
		MyThread thread3 = new MyThread(thread3Data, arrayToWriteTo);
		MyThread thread4 = new MyThread(thread4Data, arrayToWriteTo);
		MyThread thread5 = new MyThread(thread5Data, arrayToWriteTo);
		thread1.start();
		thread2.start();
		thread3.start();
		thread4.start();
		thread5.start();
		try {
			thread1.join();
			thread2.join();
			thread3.join();
			thread4.join();
			thread5.join();
		}
		catch(Exception e) {
			System.out.println("Seems like... TRAGEDY!");
		}
		
		writeDataToFile(arrayToWriteTo, fileToWriteTo);
		
	}
	
	public static Student[] readDataFromFile(String file) {
		
		List<Student> studs = new ArrayList<Student>();
		
		try {
			BufferedReader reader = new BufferedReader(new FileReader(file));
			String line = "";
			while ((line = reader.readLine()) != null) {
				if(line.contains("--")) {
					continue;
				}
				String[] values = line.split(";");
				Student temp = new Student(values[0], Integer.parseInt(values[1]), Double.parseDouble(values[2]));
				studs.add(temp);
			}
			reader.close();
		}
		catch(Exception e) {
			System.out.println("TRAGEDY!");
		}

		Student[] students =  studs.toArray(new Student[studs.size()]);
		return students;
		
	}
	
	public static void writeDataToFile(Student[] students, String file) {
		//Rezultatu spausdinimas konsoleje
		String format = "|%1$-7s|%2$-20s|%3$-5s|%4$-5s|\n";
		System.out.println("--------+--------------------+-----+------");
		System.out.format(format, "El. Nr.", "Vardas, Pavarde", "Gija", "Alga");
		System.out.println("--------+--------------------+-----+------");
		for(int i = 0; i < students.length; i++) {
			   System.out.format(format, i+1, students[i].name, students[i].threadNum, students[i].salary);
		}
		System.out.println("------------------------------------------");
		//Rezultatu irasymas i faila
		try {
			BufferedWriter writer = new BufferedWriter(new FileWriter(file));
			writer.write("--------+--------------------+-----+------");
			writer.newLine();
			writer.write(String.format(format, "El. Nr.", "Vardas, Pavarde", "Gija", "Alga"));
			writer.newLine();
			writer.write("--------+--------------------+-----+------");
			writer.newLine();
			for (int i = 0; i < students.length; i++) {
				writer.write(String.format(format, i+1, students[i].name, students[i].threadNum, students[i].salary));
				writer.newLine();
			}
			writer.write("------------------------------------------");
			writer.flush();
			writer.close(); 
		}
		catch(Exception e) {
			System.out.println("Problema Senjor");
		}
 
	}
}

class MyThread extends Thread{
	
	private Student[] students;
	private Student[] arrayToWriteTo;
	
	public MyThread(Student[] students, Student[] arrayToWriteTo) {
		this.students = students;
		this.arrayToWriteTo = arrayToWriteTo;
	}
	
	@Override
	public void run() {
		
		for(int i = 0; i < students.length; i++){
			if(students[i] != null) {
				for(int j = 0; j < arrayToWriteTo.length; j++) {
					if(arrayToWriteTo[j] == null) {
						arrayToWriteTo[j] = students[i];
						break;
					}
					continue;
				}
			}
		}	
	}
}

class Student{
	
	String name;
	int threadNum;
	double salary;
	
	public Student(String name, int threadNum, double salary) {
			this.name = name;
			this.threadNum = threadNum;
			this.salary = salary;
	}
}
