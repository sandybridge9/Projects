%defines "parser.h"

%{
	#include <cmath>
	#include <cstdio>
	#include <iostream>
	#include "astgen.h"

	#define YYDEBUG 1
	#define YYERROR_VERBOSE
	#pragma warning (disable: 4005)

	extern int yylex(); // lexical analyzer	 
	extern void yyerror(void* astDest, const char* msg);
	
	FILE* pOutputFile = NULL;
	using namespace std;
%}

%parse-param {void *astDest}

%union{
	char* type;
	char* identifier;
	char* op;
	char* string;
	float number;
	struct AstElement* ast;
}

%token<type> DATA_TYPE
%token<identifier> IDENTIFIER
%token<string> STRING_VALUE
%token<number> NUMBER_VALUE

%token RETURN IF ELIF ELSE FOR WHILE
%token<op> MORE_OP LESS_OP EQUAL_OP MORE_OR_EQUAL_OP LESS_OR_EQUAL_OP OR_OP AND_OP
%token<op> ADD_OP SUB_OP MUL_OP DIV_OP MOD_OP ADD_ASSIGN_OP SUB_ASSIGN_OP INC_OP DEC_OP ASSIGN_OP
%type<op> boolean_operator arithmetic_operator
%type<ast> program compound_statement statement_list statement exp declaration_statement constant
%type<ast> if_statement loop_statement for_expression return_statement boolean_expression
%type<ast> function_call function_declaration argument_list argument

%left '-' '+'
%left '*' '/'

%%

program
		: statement_list { (*(struct AstElement**)astDest) = $1; };
		;

statement_list
		: statement { $$ = $1; }
		| statement_list statement { $$ = makeStatement($1, $2); }
		;

statement
		: exp ';' { $$ = $1; }
		| declaration_statement ';' { $$ = $1; }
		| if_statement { $$ = $1; }
		| loop_statement { $$ = $1; }
		| function_declaration { $$ = $1; }
		| function_call ';' { $$ = $1; }
		| return_statement ';' { $$ = $1; }
		;

exp
		: IDENTIFIER { $$ = makeExpByName($1); }
		| constant { $$ = $1; }
		| IDENTIFIER ASSIGN_OP exp { $$ = makeAssignment($1, $3); }
		| exp arithmetic_operator exp { $$ = makeExpression($1, $3, $2); }
		| IDENTIFIER INC_OP { $$ = makeExpIncrease($1); }
		| IDENTIFIER DEC_OP { $$ = makeExpDecrease($1); }
		;

constant
		: STRING_VALUE { $$ = makeExpByString($1); }
		| NUMBER_VALUE { $$ = makeExpByNum($1); }
		;


arithmetic_operator
		: ADD_OP { $$ = $1; }
		| SUB_OP { $$ = $1; }
		| MUL_OP { $$ = $1; }
		| DIV_OP { $$ = $1; }
		| MOD_OP { $$ = $1; }
		;

declaration_statement
		: DATA_TYPE IDENTIFIER ASSIGN_OP exp { $$ = makeDeclaration($1, $2, $4); }
		;

if_statement
		: IF boolean_expression compound_statement { $$ = makeIf($2, $3); }
		| if_statement ELIF boolean_expression compound_statement { $$ = makeElif($1, $3, $4); }
		| if_statement ELSE compound_statement { $$ = makeElseIf($1, $3); }
		;

boolean_expression
		: '(' exp boolean_operator exp ')' { $$ = makeBooleanOperation($2, $4, $3); } 
		| '(' boolean_expression AND_OP boolean_expression ')' { $$ = makeAndOperation($2, $4); }
		| '(' boolean_expression OR_OP boolean_expression ')' { $$ = makeOrOperation($2, $4); }
		| exp boolean_operator exp { $$ = makeBooleanOperation($1, $3, $2); }
		;

loop_statement
		: FOR for_expression compound_statement { $$ = makeFor($2, $3); }
		| WHILE boolean_expression compound_statement { $$ = makeWhile($2, $3); }
		;

for_expression
		: '(' declaration_statement ';' boolean_expression ';' exp ')' { $$ = $2; }
		;

function_call
		: IDENTIFIER '(' ')' { $$ = makeFunctionCallWithoutParameters($1); }
		| IDENTIFIER '(' exp ')' { $$ = makeFunctionCall($1, $3); }
		;

function_declaration
		: DATA_TYPE IDENTIFIER '(' argument_list ')' compound_statement { $$ = makeFunctionDeclaration($1, $2, $4, $6); } 
		;

argument_list
		: argument_list ',' argument { $$ = makeArgumentList($1, $3); }
		| argument { $$ = $1; }
		| { $$ = 0; }
		;

argument
		: DATA_TYPE IDENTIFIER { $$ = makeArgument($1, $2); }
		;

return_statement
		: RETURN exp { $$ = makeReturnStatement($2); }
		;

boolean_operator
		: MORE_OP { $$ = $1; }
		| LESS_OP { $$ = $1; }
		| EQUAL_OP { $$ = $1; }
		| MORE_OR_EQUAL_OP { $$ = $1; }
		| LESS_OR_EQUAL_OP { $$ = $1; }
		| OR_OP { $$ = $1; }
		| AND_OP { $$ = $1; }
		;

compound_statement
		: '{' '}' { $$ = 0; }
		| '{' statement_list '}' { $$ = $2; }
		;

%%

#include <iostream>
#include "parser.h"
#include "astgen.h"
using namespace std;

void set_input_file(const char* filename);
void set_output_file(const char* filename);
void close_output_file();

int main(int argc, char** argv)
{

	if (argc == 2) {
		set_input_file(argv[1]);
	}
	else if (argc == 3) {
		set_input_file(argv[1]);
		set_output_file(argv[2]);
	}
	else {
		set_input_file("input.txt");
	}
	struct AstElement* astDest;
	int rlt = yyparse(&astDest);

	if (argc == 3)
		close_output_file();

	assert(a);
    struct ExecEnviron* e = createEnv();
    execAst(e, a);
    freeEnv(e);

	return 0;
}

// we have to code this function
void yyerror(void* ast, const char* msg)
{
	cout << "Error: " << msg << endl;
}

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