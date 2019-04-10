package main

import (
	"bufio"
	"fmt"
	"log"
	"os"
	"strconv"
	"strings"
	"sync"
)

//Student struktura
type Student struct {
	name   string
	age    int
	salary int
}

//DataStructure skirta talpinti dalykus kuriuos reiks salinti
type DataStructure struct {
	name      string
	itemCount int
}

//TransferMessage perdavimui is control i transfer procesa galinius duomenis
type TransferMessage struct {
	action int
	data   []DataStructure
}

//Message skirta siuntineti tarp procesu
type Message struct {
	//threadNumber int
	action        int
	student       Student
	dataStructure DataStructure
	//anyData      interface{}
	//returnChan   chan int
}

var waitGroup sync.WaitGroup

// var stillChanging = true
// var writersDone = 0
// var readersDone = 0

func main() {
	//file := "IFF_6_8_Tadas_Laurinaitis_L3a_dat1.txt" //nelieka nieko
	//file := "IFF_6_8_Tadas_Laurinaitis_L3a_dat2.txt" //lieka viskas
	file := "IFF_6_8_Tadas_Laurinaitis_L3a_dat3.txt" //lieka dalis
	students, dataStructure := readFile(file)
	//fmt.Println(students)
	//fmt.Println(dataStructure)
	//var writerChan = make(chan []Student)
	//var readerChan = make(chan []DataStructure)
	var writerChan = make([]chan []Student, 0)
	var readerChan = make([]chan []DataStructure, 0)
	var controllerChan = make(chan Message)
	var transferChan = make(chan TransferMessage)

	for i := 0; i < 5; i++ {
		writerChan = append(writerChan, make(chan []Student))
		readerChan = append(readerChan, make(chan []DataStructure))
	}
	waitGroup.Add(2)
	//go transfer(students, dataStructure, writerChan, readerChan, transferChan)
	go transfer(students, dataStructure, writerChan, readerChan, transferChan)
	go controller(controllerChan, transferChan)

	waitGroup.Add(5)
	for i := 0; i < 5; i++ {
		go writer(writerChan[i], controllerChan)
	}
	waitGroup.Add(5)
	for i := 0; i < 5; i++ {
		go reader(readerChan[i], controllerChan)
	}
	waitGroup.Wait()
}

//Funkcija perskaitanti pradinius duomenis
func readFile(fileName string) ([][]Student, [][]DataStructure) {
	students := make([]Student, 30)
	dataStructure := make([]DataStructure, 30)
	count1 := 0
	count2 := 0
	file, err := os.Open(fileName)
	if err != nil {
		fmt.Println("Couldnt open file")
		log.Fatal(err)
	}
	defer file.Close()
	scanner := bufio.NewScanner(file)

	for scanner.Scan() {
		scanner.Text()
		if scanner.Text() == "-----" {
			continue
		}
		values := strings.Split(scanner.Text(), ";")
		//jeigu skaitomi studento duomenys
		if len(values) == 3 {
			name := values[0]
			age, err1 := strconv.Atoi(values[1])
			if err1 != nil {
				fmt.Println("Couldnt convert from string to int")
				log.Fatal(err)
			}
			salary, err2 := strconv.Atoi(values[2])
			if err2 != nil {
				fmt.Println("Couldnt convert from string to int")
				log.Fatal(err)
			}
			tempStudent := Student{name, age, salary}
			students[count1] = tempStudent
			count1++
		}
		//jeigu skaitomi strukturos duomenys
		if len(values) == 2 {
			found := false
			for i := 0; i < len(dataStructure); i++ {
				if values[0] == dataStructure[i].name {
					itemCountT, err1 := strconv.Atoi(values[1])
					if err1 != nil {
						fmt.Println("Couldnt convert from string to int")
						log.Fatal(err)
					}
					dataStructure[i].itemCount = dataStructure[i].itemCount + itemCountT
					found = true
					//break
				}
			}
			if found == false {
				name := values[0]
				itemCount, err1 := strconv.Atoi(values[1])
				if err1 != nil {
					fmt.Println("Couldnt convert from string to int")
					log.Fatal(err)
				}
				tempDS := DataStructure{name, itemCount}
				dataStructure[count2] = tempDS
				count2++
			}
		}
	}
	if err := scanner.Err(); err != nil {
		log.Fatal(err)
	}
	//paverciam i dvimati kad lengviau butu siuntinet tarp procesu
	studs := make([][]Student, 5)
	dataStruct := make([][]DataStructure, 5)
	count3 := 0
	count4 := 0
	for i := 0; i < 5; i++ {
		temp := make([]Student, 5)
		for j := 0; j < 5; j++ {
			temp[j] = students[count3]
			count3++
		}
		studs[i] = temp
	}
	for i := 0; i < 5; i++ {
		temp := make([]DataStructure, 5)
		for j := 0; j < 5; j++ {
			temp[j] = dataStructure[count4]
			count4++
		}
		dataStruct[i] = temp
	}
	// fmt.Println(count3)
	// for i := 0; i < len(studs); i++ {
	// 	for j := 0; j < len(studs[i]); j++ {
	// 		fmt.Println(studs[i][j].name)
	// 	}
	// }
	// fmt.Println("----------------DataStructure------------------")
	// fmt.Println(count4)
	// for i := 0; i < len(dataStruct); i++ {
	// 	for j := 0; j < len(dataStruct[i]); j++ {
	// 		fmt.Println(dataStruct[i][j].name)
	// 		fmt.Println(dataStruct[i][j].itemCount)
	// 	}
	// }
	return studs, dataStruct
}

//Funkcija irasanti galutinius duomenis i faila
func writeDataToFile(students [][]Student, dataStructures [][]DataStructure, finalData []DataStructure) {
	file, err := os.Create("IFF_6_8_Tadas_Laurinaitis_Lab3b_rez.txt")
	if err != nil {
		fmt.Println("Couldnt open file")
		log.Fatal(err)
	}
	defer file.Close()
	file.WriteString("Pradiniai duomenys: \n")
	file.WriteString("Studentu sarasas: \n")
	file.WriteString("------------------------------ \n")
	file.WriteString(fmt.Sprintf("%-4s%-15s%-7s%-6s", "Nr.", "Vardas", "Amzius", "Alga") + "\n")
	count := 0
	for i := 0; i < len(students); i++ {
		for j := 0; j < len(students[i]); j++ {
			count++
			file.WriteString(fmt.Sprintf("%-4d%-15s%-7d%-6d", count, students[i][j].name, students[i][j].age, students[i][j].salary) + "\n")
		}
		file.WriteString("------------------------------ \n")
	}
	file.WriteString("Duomenu strukturos duomenys: \n")
	file.WriteString("------------------------------ \n")
	file.WriteString(fmt.Sprintf("%-4s%-15s%-9s", "Nr.", "Vardas", "Skaicius") + "\n")
	count = 0
	for i := 0; i < len(dataStructures); i++ {
		for j := 0; j < len(dataStructures[i]); j++ {
			count++
			file.WriteString(fmt.Sprintf("%-4d%-15s%-9d", count, dataStructures[i][j].name, dataStructures[i][j].itemCount) + "\r\n")
		}
		file.WriteString("------------------------------ \n")
	}
	file.WriteString("Rezultatai: \n")
	file.WriteString("------------------------------ \n")
	file.WriteString(fmt.Sprintf("%-4s%-15s%-9s", "Nr.", "Vardas", "Skaicius") + "\n")
	for i := 0; i < len(finalData); i++ {
		file.WriteString(fmt.Sprintf("%-4d%-15s%-9d", i+1, finalData[i].name, finalData[i].itemCount) + "\r\n")
	}
	file.WriteString("------------------------------ \n")
	// f.WriteString(fmt.Sprintf("%s %s", "Rikiuojama struktura:", "\r\n"))
	// for i := 0; i < len(dataColls); i++ {
	// 	f.WriteString(fmt.Sprintf("%-4s%-18s%s", "Nr.", "Rikiavimo_laukas", "Kiekis") + "\r\n")
	// 	//fmt.Println(len(dataColls[i]))
	// 	for j := 0; j < len(dataColls[i]); j++ {
	// 		f.WriteString(fmt.Sprintf("%-4d%-18d%d", (j+1), dataColls[i][j].gradeCount, dataColls[i][j].count) + "\r\n")
	// 		//fmt.Println(dataColls[i][j].gradeCount, " ", dataColls[i][j].count)
	// 	}
	// }
	// f.WriteString(fmt.Sprintf("%s %s", "---------------------------------------------", "\r\n"))
	// f.WriteString(fmt.Sprintf("%s %s", "Rezultatai:", "\r\n"))
	// f.WriteString(fmt.Sprintf("%-4s%-18s%s", "Nr.", "Rikiavimo_laukas", "Kiekis") + "\r\n")
	// //fmt.Println("---------------------------------------------")
	// for i := 0; i < len(data); i++ {
	// 	f.WriteString(fmt.Sprintf("%-4d%-18d%d", (i+1), data[i].gradeCount, data[i].count) + "\r\n")
	// 	//fmt.Println(i, "  ", data[i].gradeCount, " ", data[i].count)
	// }
}

//Atskiras duomenu perdavimo procesas
func transfer(students [][]Student, dataStructures [][]DataStructure, writerChan []chan []Student, readerChan []chan []DataStructure, transferChan <-chan TransferMessage) {
	defer waitGroup.Done()
	var finalData []DataStructure
	for i := 0; i < len(students); i++ {
		writerChan[i] <- students[i]
	}
	for i := 0; i < len(dataStructures); i++ {
		readerChan[i] <- dataStructures[i]
	}
	for {
		//fmt.Println("cant break free")
		finalData1 := <-transferChan
		if finalData1.action == 1 {
			finalData = finalData1.data
			fmt.Println("i just broke out")
			break
		}
	}
	//finalData := <-transferChan
	fmt.Println(finalData)
	writeDataToFile(students, dataStructures, finalData)
}

//Rasytojas procesas siunciantis studento duomenis
func writer(writerChan <-chan []Student, controllerChan chan<- Message) {
	defer waitGroup.Done()
	studentArray := <-writerChan
	for j := 0; j < len(studentArray); j++ {
		var dummyData DataStructure
		controllerChan <- Message{action: 0, student: studentArray[j], dataStructure: dummyData}
	}
	//writersDone++
	var dummyData3 DataStructure
	var dummyData2 Student
	controllerChan <- Message{action: 2, student: dummyData2, dataStructure: dummyData3}
	//fmt.Println(writersDone)
}

//Skaitytojo procesas siunciantis DataStructure duomenis pagal kuriuos vykdomas veliau trinimas
func reader(readerChan <-chan []DataStructure, controllerChan chan<- Message) {
	defer waitGroup.Done()
	dataStructureArray := <-readerChan
	for j := 0; j < len(dataStructureArray); j++ {
		var dummyStudent Student
		controllerChan <- Message{action: 1, student: dummyStudent, dataStructure: dataStructureArray[j]}
	}
	//readersDone++
	var dummyData3 DataStructure
	var dummyData2 Student
	controllerChan <- Message{action: 3, student: dummyData2, dataStructure: dummyData3}
	//fmt.Println(readersDone)
}

//Procesas kontroliuojantis duomenu irasyma, istrinima ir galutiniu duomenu perdavima
func controller(controllerChan <-chan Message, transferChan chan<- TransferMessage) {
	defer waitGroup.Done()
	count := 100
	var writersDone = make([]int, 0)
	var readersDone = make([]int, 0)
	var dataStructures = make([]DataStructure, count)
	var toRemove = make([]DataStructure, 0)
	var temp = make([]DataStructure, 0)
	count = 0
	for len(writersDone) < 5 || len(readersDone) < 5 {
		receivedData := <-controllerChan
		//fmt.Println(receivedData)
		if receivedData.action == 0 {
			dataStructures, count = addStudent(receivedData.student, dataStructures, count)
		} else if receivedData.action == 1 {
			toRemove = append(toRemove, receivedData.dataStructure)
		} else if receivedData.action == 2 {
			writersDone = append(writersDone, 1)
		} else if receivedData.action == 3 {
			readersDone = append(readersDone, 1)
		}
	}
	for i := 0; i < len(toRemove); i++ {
		dataStructures, count = removeStructure(toRemove[i], dataStructures, count)
	}
	for i := 0; i < count; i++ {
		temp = append(temp, dataStructures[i])
	}
	fmt.Println(temp)
	//stillChanging = false
	transMessage := TransferMessage{action: 1, data: temp}
	transferChan <- transMessage
}

//Salina duomenu struktura is duomenu strukturu masyvo
func removeStructure(dataStruct DataStructure, dataStructures []DataStructure, count int) ([]DataStructure, int) {
	for existsStruct(dataStruct, dataStructures, count) && dataStruct.itemCount != 0 {
		index := findIndex(dataStruct, dataStructures, count)
		if dataStructures[index].itemCount > 1 {
			dataStructures[index].itemCount--
			dataStruct.itemCount--
		} else if dataStructures[index].itemCount == 1 {
			for i := index; i < count-1; i++ {
				dataStructures[i] = dataStructures[i+1]
			}
			count--
		}
	}
	return dataStructures, count
}

//prideda studenta i duomenu strukturos masyva
func addStudent(student Student, dataStructures []DataStructure, count int) ([]DataStructure, int) {
	//Jeigu masyvas dar tuscias
	if count == 0 {
		dataStructures[0] = DataStructure{student.name, 1}
		count++
	} else {
		//jeigu jau egzistuoja toks tai padidins jo counta, jeigu ne tai ides kaip nauja
		if existsStudent(student, dataStructures, count) == true {
			for i := 0; i < count; i++ {
				if dataStructures[i].name == student.name {
					dataStructures[i].itemCount++
				}
			}
		} else {
			index := findPlace(student, dataStructures, count)
			if index == count {
				dataStructures[index] = DataStructure{
					name:      student.name,
					itemCount: 1}
				count++
			} else {
				for i := count; i > index; i-- {
					dataStructures[i] = dataStructures[i-1]
				}
				dataStructures[index] = DataStructure{student.name, 1}
				count++
			}
		}
	}
	return dataStructures, count
}

//Patikrina ar jau egzistuoja toks studentas duomenu strukturos masyve
func existsStudent(msg Student, dataColl []DataStructure, count int) bool {
	var temp bool
	temp = false
	for i := 0; i < count; i++ {
		if dataColl[i].name == msg.name {
			temp = true
		}
	}
	return temp
}

//ar egzistuoja tokia struktura strukturu masyve
func existsStruct(dataStruct DataStructure, dataStructures []DataStructure, count int) bool {
	for i := 0; i < count; i++ {
		if dataStructures[i].name == dataStruct.name {
			return true
		}
	}
	return false
}

//Surandama vieta kur reikia ideti kad liktu surikiuotas
func findPlace(student Student, dataStructures []DataStructure, count int) int {
	var index int
	index = count
	for i := 0; i < count; i++ {
		if dataStructures[i].name >= student.name {
			return i
		}
	}
	return index
}

//randamas strukturos indeksas strukturu masyve
func findIndex(dataStruct DataStructure, dataStructures []DataStructure, count int) int {
	for i := 0; i < count; i++ {
		if dataStructures[i].name == dataStruct.name {
			return i
		}
	}
	return -1
}
