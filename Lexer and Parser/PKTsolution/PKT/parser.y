%defines "parser.h"

%{
	#include <cmath>
	#include <cstdio>
	#include <iostream>
	#define YYERROR_VERBOSE

	#pragma warning (disable: 4005)
	
	// this function will be generated
	// by flex
	extern int yylex(); // lexical analyzer
	 
	 // we have to code this function
	extern void yyerror(const char*);
	
	FILE* pOutputFile = NULL;

	using namespace std;
%}

%define api.value.type { double }

%token NUM

%left '-' '+'
%left '*' '/'

%%		/* the grammars here */

input: %empty
	| input line
	;

line: '\n'
	| exp '\n'	{ fprintf_s(pOutputFile ? pOutputFile: stdout,  " =>%g\n", $1); }
	; 

exp: NUM		   { $$ = $1; }
	| exp '+' exp  { $$ = $1 + $3; }
	| exp '-' exp  { $$ = $1 - $3; }
	| exp '*' exp  { $$ = $1 * $3; }
	| exp '/' exp  { $$ = $1 / $3; }
	| '(' exp ')'  { $$ = $2; }
	;

%%

void close_output_file()
{
	if(pOutputFile)
	{
		fclose(pOutputFile);
		pOutputFile = NULL;
	}
}
void set_output_file(const char* filename)
{
	if(filename)	
		fopen_s(&pOutputFile, filename, "w");
}