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
">"				{ return MORE_OP; }
"<"				{ return LESS_OP; }
"=="			{ return EQUAL_OP; }
">="			{ return MORE_OR_EQUAL_OP; }
"<="			{ return LESS_OR_EQUAL_OP; }
"||"			{ return OR_OP; }
"&&"			{ return AND_OP; }

"for"			{ return FOR; }
"while"			{ return WHILE; }
"continue"		{ ; }
"break"			{ ; }

"="				{ return ASSIGN_OP; }
"+"				{ return ADD_OP; }
"-"				{ return SUB_OP; }
"*"				{ return MUL_OP; }
"/"				{ return DIV_OP; }
"%"				{ return MOD_OP; }
"+="			{ return ADD_ASSIGN_OP; }
"-="			{ return SUB_ASSIGN_OP; }
"++"			{ return INC_OP; }
"--"			{ return DEC_OP; }

"string"		{ yylval.type = _strdup(yytext); return DATA_TYPE; }
"number"		{ yylval.type = _strdup(yytext); return DATA_TYPE; }
"void"			{ yylval.type = _strdup(yytext); return DATA_TYPE; }
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