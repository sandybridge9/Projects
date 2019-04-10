//Atsakymai i klausimus: 1.tokia, kokia uzrasyti; 2.atsitiktine; 3.atsitiktini skai£iu; 4. tokia, kokia sura²yti duomenu masyve;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.Console;
import java.io.FileReader;
import java.io.FileWriter;
import java.util.ArrayList;
import java.util.List;

public class IFF68_LaurinaitisTadas_L1a {
	
	public static void main(String[] args) {
		
		execute();
		
	}
	
	public static void execute() {
	
		String fileToReadFrom1 = "./IFF68_LaurinaitisTadas_L2a_dat1.txt"; //Po skaitymo nelieka nieko
		String fileToReadFrom2 = "./IFF68_LaurinaitisTadas_L2a_dat2.txt"; //Po skaitymo niekas nepasikeicia
		String fileToReadFrom3 = "./IFF68_LaurinaitisTadas_L2a_dat3.txt"; //Po skaitymo lieka dalis
		String fileToWriteTo = "./IFF68_LaurinaitisTadas_L2a_rez.txt";
		Student[] studentsWrite = readWriter(fileToReadFrom2);
		Student[] studentsRead = readReader(fileToReadFrom2);
		
		Student[] write1 = new Student[studentsWrite.length/2];
		Student[] write2 = new Student[studentsWrite.length/2];
		Student[] read1 = new Student[studentsRead.length/4];
		Student[] read2 = new Student[studentsRead.length/4];
		Student[] read3 = new Student[studentsRead.length/4];
		Student[] read4 = new Student[studentsRead.length/4];
		
		System.arraycopy(studentsWrite, 0, write1, 0, studentsWrite.length/2);
		System.arraycopy(studentsWrite, studentsWrite.length/2, write2, 0, studentsWrite.length/2);
		System.arraycopy(studentsRead, 0, read1, 0, studentsRead.length/4);
		System.arraycopy(studentsRead, studentsRead.length/4, read2, 0, studentsRead.length/4);
		System.arraycopy(studentsRead, studentsRead.length/2, read3, 0, studentsRead.length/4);
		System.arraycopy(studentsRead, ((studentsRead.length*3)/4), read4, 0, studentsRead.length/4);
		
		DataStructure structure = new DataStructure();
		Thread writerThread1 = new Thread(new Writer(structure, write1, 1));
		Thread writerThread2 = new Thread(new Writer(structure, write2, 2));
		Thread readerThread1 = new Thread(new Reader(structure, read1));
		Thread readerThread2 = new Thread(new Reader(structure, read2));
		Thread readerThread3 = new Thread(new Reader(structure, read3));
		Thread readerThread4 = new Thread(new Reader(structure, read4));
		
		writerThread1.start();
		writerThread2.start();
		readerThread1.start();
		readerThread2.start();
		readerThread3.start();
		readerThread4.start();
		try {
			writerThread1.join();
			writerThread2.join();
			readerThread1.join();
			readerThread2.join();
			readerThread3.join();
			readerThread4.join();
		} catch(Exception e) {}
		
		Student[] students = structure.getStudents();
		writeDataToFile(students, studentsWrite, studentsRead, fileToWriteTo);
	}
	
	public static Student[] readWriter(String file) {
		List<Student> studsWrite = new ArrayList<Student>();
		try {
			BufferedReader reader = new BufferedReader(new FileReader(file));
			String line = "";
			while ((line = reader.readLine()) != null) {
				if(line.equals("--Write--")) {
					line = reader.readLine();
					while (line.equals("--Read--") == false) {
						if(line.equals("--Write--")) {
							//Do nothing
						}else {
							String[] values = line.split(";");
							Student temp = new Student(values[0], Integer.parseInt(values[1]), Double.parseDouble(values[2]));
							studsWrite.add(temp);
						}
						line = reader.readLine();
					}
				}
			}
			reader.close();
		} catch(Exception e) {
			//System.out.println("Error while reading writer data");
		}
		Student[] students = studsWrite.toArray(new Student[studsWrite.size()]);
		return students;			
	}
	public static Student[] readReader(String file) {
		List<Student> studsRead = new ArrayList<Student>();
		try {
			BufferedReader reader = new BufferedReader(new FileReader(file));
			String line = "";
			while ((line = reader.readLine()) != null) {
				if(line.equals("--Read--")) {
					line = reader.readLine();
					while (line.equals("--Write--") == false) {
						if(line.equals("--Read--")) {
							//Do nothing
						}else {
							String[] values = line.split(";");
							Student temp = new Student(values[0], Integer.parseInt(values[1]));
							studsRead.add(temp);
						}
						line = reader.readLine();
					}
				}
			}
			reader.close();
		} catch(Exception e) {
			//System.out.println("Error while reading reader data");
		}
		Student[] students = studsRead.toArray(new Student[studsRead.size()]);
		return students;			
	}
	
	public static void writeDataToFile(Student[] students, Student[] studentsWrite, Student[] studentsRead, String file) {
		//Rezultatu spausdinimas konsoleje
		String format = "|%1$-7s|%2$-20s|%3$-8s|\n";
		String format2 = "|%1$-7s|%2$-20s|%3$-8s|%4$-4s|\n";
		System.out.println("--------+--------------------+--------+");
		System.out.format(format, "El. Nr.", "Vardas, Pavarde", "Skaicius");
		System.out.println("--------+--------------------+--------+");
		for(int i = 0; i < students.length; i++) {
			if(students[i] != null)
			   System.out.format(format, i+1, students[i].name, students[i].getCount());
		}
		System.out.println("---------------------------------------");
		//Rezultatu irasymas i faila
		try {
			BufferedWriter writer = new BufferedWriter(new FileWriter(file));
			writer.write("Pradiniai duomenys: ");
			writer.newLine();
			writer.write("Rasytoju duomenys vienoje lenteleje: ");
			writer.newLine();
			writer.write("--------+--------------------+--------+----+");
			writer.newLine();
			writer.write(String.format(format2, "El. Nr.", "Vardas, Pavarde", "Gija", "Alga"));
			writer.newLine();
			writer.write("--------+--------------------+--------+----+");
			writer.newLine();
			for (int i = 0; i < studentsWrite.length; i++) {
				if(studentsWrite[i] != null) {
					writer.write(String.format(format2, i+1, studentsWrite[i].name, studentsWrite[i].threadNum, studentsWrite[i].salary));
					writer.newLine();
				}
			}
			writer.write("--------------------------------------------");
			writer.newLine();
			writer.write("Skaitytoju duomenys vienoje lenteleje: ");
			writer.newLine();
			writer.write("--------+--------------------+--------+");
			writer.newLine();
			writer.write(String.format(format, "El. Nr.", "Vardas, Pavarde", "Skaicius"));
			writer.newLine();
			writer.write("--------+--------------------+--------+");
			writer.newLine();
			for (int i = 0; i < studentsRead.length; i++) {
				if(studentsRead[i] != null) {
					writer.write(String.format(format, i+1, studentsRead[i].name, studentsRead[i].getCount()));
					writer.newLine();
				}
			}
			writer.write("---------------------------------------");
			writer.newLine();
			writer.write("Rezultatai: ");
			writer.newLine();
			writer.write("--------+--------------------+--------+----+");
			writer.newLine();
			writer.write(String.format(format2, "El. Nr.", "Vardas, Pavarde", "Gija", "Alga"));
			writer.newLine();
			writer.write("--------+--------------------+--------+----+");
			writer.newLine();
			int count = 1;
			for (int i = 0; i < students.length; i++) {
				if(students[i] != null) {
					for(int j = 0; j < students[i].getCount(); j++) {
						writer.write(String.format(format2, count++, students[i].name, students[i].threadNum, students[i].salary));
						writer.newLine();
					}
				}
			}
			writer.write("-------------------------------------------");
			writer.flush();
			writer.close(); 
		}
		catch(Exception e) {
			System.out.println("Problema Senjor");
		}
	}
}

class DataStructure{
	Student[] students;
	int count;
	boolean isFinished1;
	boolean isFinished2;
	
	public DataStructure(){
		this.students = new Student[100];
		isFinished1 = false;
		isFinished2 = false;
	}
	
	public synchronized void write(Student[] forWriting, int threadNum) {
		while(count == students.length) {
			try {
				wait();
			}catch (Exception e) {
				
			}
		}
		for(int i = 0; i < forWriting.length; i++) {
			boolean exists = false;
			for(int j = 0; j < students.length; j++) { 
				if(students[j] != null && forWriting[i].name.equals(students[j].name)) {
					students[j].setCount(students[j].getCount()+1);
					exists = true;
					break;
				}
			}
			if(exists == false) {
				for(int j = 0; j < students.length; j++) {
					if(students[j] != null) {
						if(forWriting[i].name.compareTo(students[j].name) < 0 && (j+1) < students.length){
							//System.arraycopy(students, j, students, j+1, count-j-1);
							for(int h = j; h < students.length-1; h++) {
								students[j+1] = students[j];
							}
							students[j] = forWriting[i];
							students[j].setCount(1);
							count++;
							break;
						}
					}
					else if(students[j] == null) {
						students[j] = forWriting[i];
						students[j].setCount(1);
						count++;
						break;
					}
				}
			}
		}
		if(threadNum == 1) {
			isFinished1 = true;
		}
		else if(threadNum == 2) {
			isFinished2 = true;
		}
		notifyAll();
	}
	public synchronized void read(Student[] forReading) {
		while(isFinished1 == false || isFinished2 == false) {
			try {
				wait();
			}catch (Exception e) {
				
			}
		}
		for(int i = 0; i  < forReading.length; i++) {
			int times = forReading[i].getCount();
			for(int k = 0; k < times; k++) {
				for(int j = 0; j < students.length; j++) {
					if(students[j] != null && forReading[i] != null && forReading[i].name.equals(students[j].name)) {
						if(students[j].getCount() > 1) {
							students[j].setCount(students[j].getCount()-1);
							break;
						}
						else if(students[j].getCount() == 1) {
							students[j] = null;
							deleteGaps(j);
							break;
						}
					}
				}
			}
		}
		notifyAll();
	}
	public void deleteGaps(int index) {
		for(int i = index; i < students.length-1; i++) {
			students[i] = students[i+1];
		}
		//students[students.length-1] = null;
	}	
	public Student[] getStudents() {
		return students;
	}
}

class Writer implements Runnable{
	Student[] forWriting;
	DataStructure structure;
	int threadNum;
	
	public Writer(DataStructure structure, Student[] forWriting, int threadNum) {
		this.forWriting = forWriting;
		this.structure = structure;
		this.threadNum = threadNum;
	}
	@Override
	public void run() {
		structure.write(forWriting, threadNum);
	}
}

class Reader implements Runnable{
	Student[] forReading;
	DataStructure structure;
	
	public Reader(DataStructure structure, Student[] forReading) {
		this.forReading = forReading;
		this.structure = structure;
	}
	@Override
	public void run() {
		structure.read(forReading);
	}	
}

class Student{	
	String name;
	int threadNum = 0;
	double salary = 0;
	private int count = 0;
	
	public Student(String name, int threadNum, double salary) {
			this.name = name;
			this.threadNum = threadNum;
			this.salary = salary;
	}
	//constructor used when creating objects for Reader class
	public Student(String name, int count) {
		this.name = name;
		this.count = count;		
	}
	public Student() {}	
	
	public void setCount(int count) {
		this.count = count;	
	}
	public int getCount() {
		return this.count;
	}
}
