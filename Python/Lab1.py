#Number class used to store a number and a number which shows a cumulative sum of each numbers divisors from 1 to number
class Number:
    def __init__(self, number, cumulativeSum):
        self.number = number
        self.cumulativeSum = cumulativeSum

    def get_number(self):
        return self.number
        
#finds sum of all viable divisors of number n
def findSumOfDivisors(n):
    sum = 0
    for x in range(2, int(n)):
        z = n / x #temporary result of division
        if z == int(z):
            sum = sum + z
    return sum

#finds cumulative sum of divisors for numbers 1 to Number.number
def findCumulativeSumOfDivisors(Number):
    for x in range(0, Number.number + 1):
        Number.cumulativeSum = Number.cumulativeSum + findSumOfDivisors(x)
    print("Cumulative sum of divisors of number n: " + str(Number.number) + " is: " + str(Number.cumulativeSum))
    return Number

#reads data from file into integer array
def readIntoArray(fileName):
    array = []
    with open('data.txt') as f:
        for line in f: # read all lines
            array.append(int(line))
    return array

#finds results for all integers in array
def findResults(array):
    numberArray = []
    for x in array:
        temp = Number(x, 0)
        temp = findCumulativeSumOfDivisors(temp)
        numberArray.append(temp)

array = readIntoArray("data.txt")
findResults(array)