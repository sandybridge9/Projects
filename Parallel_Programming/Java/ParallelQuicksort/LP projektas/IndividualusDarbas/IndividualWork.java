import java.util.Arrays;
import java.util.Random;

public class IndividualWork {
	
	public static void main(String[] args) {
		int dataCount = (int) (10 * Math.pow(10, 6));
		int dataRange = 100000;
		int[] array = makeArray(dataCount, dataRange);
		int[] array2 = array;
		
		long startTime1 = System.nanoTime();
		//quickSort(array, 0, array.length);
		long endTime1 = System.nanoTime();
		long time1 = endTime1-startTime1;
		//System.out.println("Sequential QuickSort took: " +time1/1000000 +"ms to sort: " +dataCount);
		
		startTime1 = System.nanoTime();
		parallelQS(array2, 0, array.length, 2);
		endTime1 = System.nanoTime();
		long time2 = endTime1-startTime1;
		System.out.println("Parallel QuickSort took: " +time2/1000000 +"ms to sort: " +dataCount);
		
		if(Arrays.equals(array, array2)) {
			System.out.println("Arrays are equal");
		}
	}
    //paprastas QuickSort algoritmas veikiantis nuosekliai
    public static void quickSort(int[] array, int fromIndex, int toIndex) {
        while (true) {
            int rangeLength = toIndex - fromIndex;
            int distance = rangeLength / 4;          
            if (rangeLength < 2) {
                return;
            }         
            int a = array[fromIndex + distance];
            int b = array[fromIndex + (rangeLength >>> 1)];
            int c = array[toIndex - distance-1];

            int pivot = median(a, b, c);
            int leftPartitionLength = 0;
            int rightPartitionLength = 0;
            int index = fromIndex;

            while (index < toIndex - rightPartitionLength) {
                int current = array[index];

                if (current > pivot) {
                    rightPartitionLength++;
                    swap(array, toIndex - rightPartitionLength, index);
                } else if (current < pivot) {
                    swap(array, fromIndex + leftPartitionLength, index);
                    index++;
                    leftPartitionLength++;
                } else {
                    index++;
                }
            }
            if (leftPartitionLength < rightPartitionLength) {
                quickSort(array, fromIndex, fromIndex + leftPartitionLength);
                fromIndex = toIndex - rightPartitionLength;
            } else {
                quickSort(array, toIndex - rightPartitionLength, toIndex);
                toIndex = fromIndex + leftPartitionLength;
            }
        }
    }
    //QuickSort algoritmas veikiantis ant pasirinkto skaiciaus giju (threadCount)
    public static void parallelQS(int[] array, int fromIndex, int toIndex, int threadCount) {
        if (threadCount <= 1) {
            quickSort(array, fromIndex, toIndex);
            return;
        }
        int rangeLength = toIndex - fromIndex;
        int distance = rangeLength / 4;

        int a = array[fromIndex + distance];
        int b = array[fromIndex + (rangeLength >>> 1)];
        int c = array[toIndex - distance];

        int pivot = median(a, b, c);
        int leftPartitionLength = 0;
        int rightPartitionLength = 0;
        int index = fromIndex;

        while (index < toIndex - rightPartitionLength) {
            int current = array[index];
            if (current > pivot) {
                rightPartitionLength++;
                swap(array, toIndex - rightPartitionLength, index);
            } else if (current < pivot) {
                swap(array, fromIndex + leftPartitionLength, index);
                index++;
                leftPartitionLength++;
            } else {
                index++;
            }
        }
        MyThread thread1 = new MyThread(array, fromIndex, fromIndex + leftPartitionLength, threadCount / 2);
        MyThread thread2 = new MyThread(array, toIndex - rightPartitionLength, toIndex,threadCount - threadCount / 2);
        thread1.start();
        thread2.start();
        try {
        	thread1.join();
        	thread2.join();
        } catch (InterruptedException ex) {
        	System.out.println("Somethings wingwong in the thved area tfir");
        }
    } 
    //Sukuria masyva ir uzpildo ji atsistiktiniais skaiciais
    public static int[] makeArray(int count, int dataRange) {
    	int[] array = new int[count];
    	Random rng = new Random();
    	for(int i = 0; i < count; i++) {
    		int temp = rng.nextInt(dataRange);
    		array[i] = temp;
    	}
    	return array;
    }
	//Sukeicia du masyvo elementus vietomis
    public static void swap(int[] array, int i, int j) {
        int temp = array[i];
        array[i] = array[j];
        array[j] = temp;
    }
    //Randa mediana pivot'ui
    public static int median(int a, int b, int c) {
        int med = Math.max(Math.min(a,b), Math.min(Math.max(a,b),c)); 
    	return med;
    }
    
    static class MyThread extends Thread {

        private int[] array;
        private int fromIndex;
        private int toIndex;
        private int threadCount;

        public MyThread(int[] array, int fromIndex, int toIndex, int threadCount) {
            this.array = array;
            this.fromIndex = fromIndex;
            this.toIndex = toIndex;
            this.threadCount = threadCount;
        }
        @Override
        public void run() {
            parallelQS(array, fromIndex, toIndex, threadCount);
        }        
        public int[] getArray() {
        	return array;
        }
        public int getFromIndex() {
        	return fromIndex;
        }
        public int getToIndex() {
        	return toIndex;
        }
        public int getThreadCount() {
        	return threadCount;
        }
    }
}
