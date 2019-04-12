// Tadas Laurinaitis, IFF - 6/8, uzduoties nr. - 294, Divisors https://uva.onlinejudge.org/index.php?option=com_onlinejudge&Itemid=8&category=4&page=show_problem&problem=230

open System
open System.IO

let readDataFromFile file =
    File.ReadAllLines(file)

let writeResultToFile file L U maxNum maxCount = 
    let file = File.AppendText(file)
    Console.WriteLine("Between {0} and {1}, {2} has a maximum of {3} divisors", L, U, maxNum, maxCount)
    file.WriteLine("Between {0} and {1}, {2} has a maximum of {3} divisors", L, U, maxNum, maxCount)
    file.Close()

//let rec findDivisionsOfNumber(number : int, divisionCount : int, current : int) =
let rec findDivisionsOfNumber number divisionCount current =
    if (number % current = 0 && current <= number) then
        let temp1 = divisionCount + 1
        let temp2 = current + 1
        findDivisionsOfNumber number temp1 temp2
    else if (number % current <> 0 && current <= number) then 
        let temp2 = current + 1
        findDivisionsOfNumber number divisionCount temp2
    else
        let temp = divisionCount
        temp

let rec findNumber L U current maxNum maxCount =
    let divisionCount = findDivisionsOfNumber current 0 1
    //Console.WriteLine(divisionCount)
    if(divisionCount > maxCount && current <= U) then 
        let nextStep = current + 1
        let currentMaxNum = current
        let currentMaxCount = divisionCount
        findNumber L U nextStep currentMaxNum divisionCount
    else if (divisionCount <= maxCount && current <= U) then
        let nextStep = current + 1
        findNumber L U nextStep maxNum maxCount
    else
        let temp = maxNum
        writeResultToFile "Results.txt" L U maxNum maxCount
        temp

let rec doStuff current =
    let numbers = readDataFromFile("D:\Tadas\KALBUTEORIJA\Fsharp\Lab3\Lab3\Data.txt")
    let firstLine = numbers.[0].Split(' ')
    let NN = Int32.Parse(firstLine.[0])
    if(current > NN) then
        printf "Job is done "
    else
        let strings = numbers.[current].Split(' ')
        let L = Int32.Parse(strings.[0])
        let U = Int32.Parse(strings.[1])
        Console.WriteLine(NN)
        Console.WriteLine(current)
        Console.WriteLine(L)
        Console.WriteLine(U)
        if (U - L >= 0 && U - L <= 10000 && current <= NN) then 
            printf "Data looks fine "
            let num = findNumber L U L 0 0
            let nextStep = current + 1
            doStuff nextStep
        else if(U - L < 0 || U - L > 10000 && current <= NN) then 
            printf "The Data is incorrect "
            let nextStep = current + 1
            doStuff nextStep
    
[<EntryPoint>]
let main argv =
    let k = doStuff 1
    0