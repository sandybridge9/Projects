import os
import re

class Lexeme:
    def __init__(self, word, spamCount, hamCount, pWS, pWH, pSW):
        self.word = word
        self.spamCount = spamCount
        self.hamCount = hamCount
        self.pWS = pWS
        self.pWH = pWH
        self.pSW = pSW
        
    #Note to self: no need for getters and setters

#funcion responsible for reading a number of files, defined by the fileLimit
#and getting lexemes from those files and then putting them into a lexicon
#funcion returns a dictionary and two integer values - spam and ham word counts
#for later calculations
def readFilesIntoDictionary(spamDirectory, hamDirectory, fileLimit):
    #initial values
    lexicon = {}
    spamCount = 0
    hamCount = 0
    fileCount = 0
    #for loop responsible for spam lexemes
    for file in os.listdir(spamDirectory):
        if file.endswith(".txt") and fileCount <= fileLimit:
            fileName = spamDirectory + "\\" + file
            with open(fileName, encoding="Latin-1") as f:
                for line in f:
                    for word in re.split('\W+', line):
                        if len(word) > 1:
                            if word in lexicon.keys():
                                lexicon[word].spamCount += 1
                            else:
                                lexema = Lexeme(word, 1, 0, 0, 0, 0)
                                lexicon[word] = lexema
                            spamCount += 1
            fileCount += 1
    fileCount = 0
    #for loop responsible for ham lexemes
    for file in os.listdir(hamDirectory): #all files in directory
        if file.endswith(".txt") and fileCount <= fileLimit:
            fileName = hamDirectory + "\\" + file
            with open(fileName, encoding="Latin-1") as f:
                for line in f:
                    for word in re.split('\W+', line):
                        if len(word) > 1:
                            if word in lexicon.keys():
                                lexicon[word].hamCount += 1
                            else:
                                lexema = Lexeme(word, 0, 1, 0, 0, 0)
                                lexicon[word] = lexema
                            hamCount += 1
            fileCount += 1
    return [lexicon, spamCount, hamCount]

def probabilities(answerList):
    #dictionary with all lexemes
    lexicon = answerList[0]
    #total word counts from all read files
    totalSpamCount = answerList[1]
    totalHamCount = answerList[2]
    for key in lexicon.keys():
        #probability that lexeme is IN Spam
        lexicon[key].pWS = lexicon[key].spamCount / totalSpamCount
        #probability that lexeme is IN Ham
        lexicon[key].pWH = lexicon[key].hamCount / totalHamCount
        #probability that lexeme is Spam
        lexicon[key].pSW = lexicon[key].pWS / (lexicon[key].pWS + lexicon[key].pWH)
    #returns full lexicon with all probabilites  
    return lexicon

spamDirectory = "D:\Tadas\KALBUTEORIJA\Python\spam"
hamDirectory = "D:\Tadas\KALBUTEORIJA\Python\ham"
# answerList values: 0 - dictionary - lexicon, 1 - spam word count, 2 - ham word count
answerList = readFilesIntoDictionary(spamDirectory, hamDirectory, 30)
lexicon = probabilities(answerList)
for key in lexicon.keys():
    if(lexicon[key].pSW > 0 and lexicon[key].pSW < 1):
        print(lexicon[key].pWS, lexicon[key].pWH, lexicon[key].pSW)