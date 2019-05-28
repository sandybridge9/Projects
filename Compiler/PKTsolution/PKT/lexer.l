%option noyywrap

%{ 
	#pragma warning (disable: 4005)
	#include <iostream>
	#include <cmath>
	using namespace std;
	#include "parser.h"
	#define YYERROR_VERBOSE
	FILE* pInputFile = NULL;
	extern void close_input_file();
%}

ID		([a-zA-Z_][a-zA-Z_0-9]*)
NUM		([0-9]+)|([0-9]*\.[0-9]+)
STR		(\"(\\.|[^"])*\")

%%
"("				{ return '('; }
")"				{ return ')'; }
"{"				{ return '{'; }
"}"				{ return '}'; }
";"				{ return ';'; }
","				{ return ','; }
"return"		{ return RETURN; }

"if"			{ return IF; }
"elif"			{ return ELIF; }
"else"			{ return ELSE; }
">"				{ yylval.op2 = *yytext; return BOOLEAN_OP; }
"<"				{ yylval.op2 = *yytext; return BOOLEAN_OP; }
"=="			{ return EQ_OP; }
">="			{ return ME_OP; }
"<="			{ return LE_OP; }
"||"			{ return OR_OP; }
"&&"			{ return AND_OP; }

"for"			{ return FOR; }
"while"			{ return WHILE; }
"continue"		{ ; }
"break"			{ ; }

"="				{ return ASSIGN_OP; }
"+"				{ yylval.op2 = *yytext; return ARITHMETIC_OP; }
"-"				{ yylval.op2 = *yytext; return ARITHMETIC_OP; }
"*"				{ yylval.op2 = *yytext; return ARITHMETIC_OP; }
"/"				{ yylval.op2 = *yytext; return ARITHMETIC_OP; }
"+="			{ return ADD_ASSIGN_OP; }
"-="			{ return SUB_ASSIGN_OP; }
"++"			{ return INC_OP; }
"--"			{ return DEC_OP; }

"string"		{ yylval.type = _strdup(yytext); return DATA_TYPE; }
"number"		{ yylval.type = _strdup(yytext); return DATA_TYPE; }
"void"			{ yylval.type = _strdup(yytext); return DATA_TYPE; }
"print"			{ yylval.identifier = _strdup(yytext); return IDENTIFIER; }
"time"			{ yylval.identifier = _strdup(yytext); return IDENTIFIER; }
{NUM}			{ yylval.number = atof(yytext); return NUMBER_VALUE; }
{STR}			{ yylval.string = _strdup(yytext); return STRING_VALUE; }
{ID}			{ yylval.identifier = _strdup(yytext); return IDENTIFIER; }
[ \v\f]			{ ; }
[\t]			{ printf("\t"); }
[\n]			{ printf("\n"); }
<<EOF>>			{ close_input_file(); yyterminate(); }
.				{ ; }

%%

void close_input_file()
{
	if(pInputFile)
	{
		fclose(pInputFile);
		pInputFile = NULL;
	}
}

void set_input_file(const char* filename)
{
	if(filename && !fopen_s(&pInputFile, filename, "r"))
	{
		yyin = pInputFile;
		printf("input file set");
	}
}