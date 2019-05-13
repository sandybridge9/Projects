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
BOOL	(true|false)

%%
"("				{ printf("("); return '('; }
")"				{ printf(")"); return ')'; }
"{"				{ printf("{"); return '{'; }
"}"				{ printf("}"); return '}'; }
"return"		{ printf(" return "); return RETURN; }

"if"			{ printf(" if "); return IF; }
"else"			{ printf(" else "); return ELSE; }
">"				{ printf(">"); return '>'; }
"<"				{ printf("<"); return '<'; }
"=="			{ printf("=="); return EQUAL_OP; }
">="			{ printf(">="); return MORE_OR_EQUAL_OP; }
"<="			{ printf("<="); return LESS_OR_EQUAL_OP; }
"||"			{ printf("||"); return OR_OP; }
"&&"			{ printf("&&"); return AND_OP; }

"="				{ printf("="); return '='; }
"+"				{ printf("+"); return '+'; }
"-"				{ printf("-"); return '-'; }
"*"				{ printf("*"); return '*'; }
"/"				{ printf("/"); return '/'; }
"+="			{ printf("+="); return ADD_ASSIGN; }
"-="			{ printf("-="); return SUB_ASSIGN; }
"++"			{ printf("++"); return INC_OP; }
"--"			{ printf("--"); return DEC_OP; }

"for"			{ printf(" for "); return FOR; }
"continue"		{ printf(" continue "); return CONTINUE; }
"break"			{ printf(" break "); return BREAK; }
"string"		{ printf(" string "); return STRING; }
"number"		{ printf(" number "); return NUMBER; }
{NUM}			{ printf(" NUMBER "); yylval = atof(yytext); return NUMBER; }
{STR}			{ printf(" STRING "); return STRING; }
{BOOL}			{ printf(" BOOL "); return BOOL; }
{ID}			{ printf(" IDENTIFIER "); return IDENTIFIER; }
[ \t\v\n\f]		{ printf(" useless "); }
<<EOF>>			{ close_input_file(); yyterminate(); }
.

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