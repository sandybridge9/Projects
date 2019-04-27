% Tadas Laurinaitis IFF - 6/8 suma 39, 12 ir 13
% Surasti ar du skaiciai yra kopirminiai - 12 uzduotis
coprime(X, Y, Div, Output) :-
    (X == Div ; Y == Div ->
    	write(" Finished ")
    	;(X > Div, Y > Div ->
         	write("Still going "),
        	R1 is mod(X, Y),
    		R2 is mod(Y, X),
    		(R1 \== 0, R2 \== 0 ->
            	write("3333_"),
                write(Div),
				R3 is mod(X, Div),
        		R4 is mod(Y, Div),
                write(R3),
                write(R4),
				((   R3 \== 0 ; R4 \== 0) ->
                	write("4444"),
        			Output = 'true',
                    Z is Div + 1,
            		coprime(X, Y, Z, Output)
        			;(R3 == 0, R4 == 0 -> 
                     	write("5555"),
            			Output2 = 'false',
                        coprime(100, 100, 100, Output2)
            		)
        		)
    			;(R1 == 0 ; R2 == 0 ->
                 	write("6666"),
        			Output = 'false'
        		)
    		)
		)
    ).

%Surasti ar skaicius yra pirminis - 13 uzduotis
isprime(1) :-
    write("The number 1 is prime ").

isprime(2) :-
    write("The number 2 is prime ").

isprime(X) :-
    X > 2,
    isprimee(X, 2, Output).

isprimee(X, Y, Output) :-
    (Y < X ->  
		R1 is mod(X, Y),
		(R1 \== 0 ->
        	Output = "true",
        	isprimee(X, Y+1, Output)
        ;   (R1 == 0 ->
            	write("The number is not a prime ")
            )
        )
    ;   (   Y >= X ->  
        	Output = "true",
            write("The number "),
            write(X),
            write(" is prime. ")
        )
    ). 

/*
something(X, Y) :-
    ( X > Y ; X < Y ->  
    	write("11111111"),
        write("111111111111111111"),
    	something(X - 1,Y)
    ;   ( X = Y ->  
        	write("aaa222222222"),
            write("bbb2222222222222222222"),
            something(X,Y+1)
        )
    ).

coprime(X, Y, Divider, Output) :-
    R1 is mod(X,Y),
    R2 is mod(Y,X),
    (R1 \== 0, R2 \== 0 ->  
    	R3 is mod(X, Divider),
		R4 is mod(Y, Divider),
        (R3 \== 0, R4 \== 0 ->
    		Output = "true",
    		coprime(X, Y, Divider, Output),
        ;   (R3 == 0 ; R4 == 0 ->  
                Output = "false"
            )
    	)
    ;   (R1 == 0 ; R2 == 0 ->  
        	Output = "false";
        )
    ).
coprime(X, Y, Div, Output) :-
    write("iejau"),
    (   X == Div ; Y == Div ->
    	write("as lygus esu"),
    	Output = "true",
    	coprime(X, Y, Div + 1, Output)
    )
    R1 is mod(X, Y),
    R2 is mod(Y, X),
    (R1 \== 0, R2 \== 0 ->
    	write("praslydau 1"),
		R3 is mod(X, Div),
        R4 is mod(Y, Div),
		(R3 \== 0, R4 \== 0 ->
        	write("praslydau 2"),
        	Output = "true",
            coprime(X, Y, Div+1, Output)
        ;   (R3 == 0 ; R4 == 0 -> 
            	write("nepraslydau 2"),
            	Output = "false"
            )
        )
    ;   (   R1 == 0 ; R2 == 0 ->
        	write("nepraslydau 1"),
        	Output = "false"
        )
    ).   
isprimaryy(X, Y, Output) :-
    (Y < X ->  
		R1 is mod(X, Y),
		(R1 \== 0 ->
        	Output = "true",
        	isprimaryy(X, Y+1, Output)
        ;   (R1 == 0 ->  
            	Output = "false"
            )
        )
    ;   (   Y >= X ->  
        	Output = "true",
            write("The number "),
            write(X),
            write(" is prime. ")
        )
    ).
coprimary(X, Y) :-
    isprimary(X, Output1),
    isprimary(Y, Output2),
    Output1 == "true",
    Output2 == "true",
    R1 is mod(X,Y),
    R2 is mod(Y,X),
    R1 \== 0,
    R2 \== 0,
    write("Numbers are coprime").
isprimary(1, Output) :-
    Output = "true",
    write("The number 1 is prime ").
isprimary(2, Output) :-
    Output = "true",
    write("The number 2 is prime ").
isprimary(X, Output) :-
    X > 2,
    isprimaryy(X, 2, Output).
isprimaryy(X, Y, Output) :-
    (Y < X ->  
		R1 is mod(X, Y),
		(R1 \== 0 ->
        	Output = "true",
        	isprimaryy(X, Y+1, Output)
        ;   (R1 == 0 ->  
            	Output = "false"
            )
        )
    ;   (   Y >= X ->  
        	Output = "true",
            write("The number "),
            write(X),
            write(" is prime. ")
        )
    ).   
jealous(X, Y) :-
    loves(X, Z),
    loves(Y, Z).
*/

/** <examples>

?- loves(X, mia).
?- jealous(X, Y).

*/

