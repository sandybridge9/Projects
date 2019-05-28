%defines "parser.h"

%{
	#include <cmath>
	#include <cstdio>
	#include <iostream>
	#include "astgen.h"
	#include "astexec.h"

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
	char op2;
	char* string;
	float number;
	struct AstElement* ast;
}

%token<type> DATA_TYPE
%token<identifier> IDENTIFIER
%token<string> STRING_VALUE
%token<number> NUMBER_VALUE

%token RETURN IF ELIF ELSE FOR WHILE
%token<op> ADD_ASSIGN_OP SUB_ASSIGN_OP INC_OP DEC_OP ASSIGN_OP
%token<op> AND_OP OR_OP EQ_OP LE_OP ME_OP
%token<op2>  ARITHMETIC_OP BOOLEAN_OP
%type<ast> program compound_statement statement_list statement assignment_statement exp declaration_statement constant
%type<ast> if_statement loop_statement for_expression return_statement boolean_expression
%type<ast> function_call function_declaration argument_list argument

%left '-' '+'
%left '*' '/'
%left '>' '<'
%left "==" "<=" ">="

%%

program
		: statement_list { printf("Program \n"); (*(struct AstElement**)astDest) = $1; };
		;

statement_list
		: statement_list statement { printf("Statement List \n"); $$ = makeStatement($1, $2); }
		| statement { printf("\t Statement \n"); $$ = $1; }
		;

statement
		: assignment_statement ';' { printf(" Assignment "); $$ = $1; }
		| declaration_statement ';' { printf(" declaration "); $$ = $1; }
		| if_statement { printf(" if "); $$ = $1; }
		| loop_statement { printf(" loop "); $$ = $1; }
		| function_declaration { printf(" func decl "); $$ = $1; }
		| function_call ';' { printf(" func call "); $$ = $1; }
		| return_statement ';' { printf(" return "); $$ = $1; }
		;

exp
		: IDENTIFIER { printf(" IDENTIFIER: %s- ", $1); $$ = makeExpByName($1); }
		| constant { printf(" Constant "); $$ = $1; }
		| exp ARITHMETIC_OP exp { printf(" arithmetic, op: ---%c--- ", $2); $$ = makeExpression($1, $3, $2); }
		;

assignment_statement
		: IDENTIFIER ASSIGN_OP exp { printf(" Assignment "); $$ = makeAssignment($1, $3); }
		| IDENTIFIER INC_OP { printf(" Inc "); $$ = makeExpIncrease($1); }
		| IDENTIFIER DEC_OP { printf(" Dec "); $$ = makeExpDecrease($1); }
		;

constant
		: STRING_VALUE { printf(" String: %s ", $1); $$ = makeExpByString($1); }
		| NUMBER_VALUE { printf(" Number: %f ", $1); $$ = makeExpByNum($1); }
		;

declaration_statement
		: DATA_TYPE IDENTIFIER ASSIGN_OP exp { printf(" Declaration: ID: %s", $2); $$ = makeDeclaration($1, $2, $4); }
		;

if_statement
		: IF '(' boolean_expression ')' compound_statement { printf(" if "); $$ = makeIf($3, $5); }
		| if_statement ELIF boolean_expression compound_statement { printf(" elif "); $$ = makeElif($1, $3, $4); }
		| if_statement ELSE compound_statement { printf(" else "); $$ = makeElseIf($1, $3); }
		;

boolean_expression
		: IDENTIFIER BOOLEAN_OP exp { $$ = makeBooleanOperation($1, $3, $2); }
		| IDENTIFIER EQ_OP exp { $$ = makeEqualsOperation($1, $3); }
		| IDENTIFIER ME_OP exp { $$ = makeMoreOrEqualOperation($1, $3); }
		| IDENTIFIER LE_OP exp { $$ = makeLessOrEqualOperation($1, $3); }
		| boolean_expression OR_OP boolean_expression { printf(" bool op3 "); $$ = makeOrOperation($1, $3); }
		| boolean_expression AND_OP boolean_expression { printf(" bool op2 "); $$ = makeAndOperation($1, $3); }
		;

loop_statement
		: FOR for_expression compound_statement { printf(" for "); $$ = makeFor($2, $3); }
		| WHILE '(' boolean_expression ')' compound_statement { printf(" while "); $$ = makeWhile($3, $5); }
		;

for_expression
		: '(' declaration_statement ';' boolean_expression ';' exp ')' { $$ = $2; }
		;

function_call
		: IDENTIFIER '(' ')' { printf(" func call "); $$ = makeFunctionCallWithoutParameters($1); }
		| IDENTIFIER '(' argument_list ')' { printf(" func call2 "); $$ = makeFunctionCall($1, $3); }
		| IDENTIFIER ASSIGN_OP IDENTIFIER '(' argument_list ')' { $$ = makeAssignFunctionValue($1, $3, $5); }
		;

function_declaration
		: DATA_TYPE IDENTIFIER '(' argument_list ')' compound_statement { printf(" func decl "); $$ = makeFunctionDeclaration($1, $2, $4, $6); } 
		;

argument_list
		: { printf(" empty arg list "); $$ = 0; }
		| argument_list ',' argument { printf(" arg list "); $$ = makeArgumentList($1, $3); }
		| argument {  printf(" arg "); $$ = $1; }
		;

argument
		: DATA_TYPE IDENTIFIER { $$ = makeArgument($1, $2); }
		| IDENTIFIER { $$ = makeCallArgument($1); }
		| STRING_VALUE { $$ = makeCallArgument2($1); }
		| NUMBER_VALUE { $$ = makeCallArgument3($1); }
		;

return_statement
		: RETURN exp { $$ = makeReturnStatement($2); }
		;

compound_statement
		: '{' '}' { printf(" empty comp statement "); $$ = 0; }
		| '{' statement_list '}' { printf(" comp statement "); $$ = $2; }
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
	printf("\n \t AST part");
	struct AstElement* astDest;
	int rlt = yyparse(&astDest);

	if (argc == 3)
		close_output_file();

	//assert(a);
	printf("\n Starting to go along the AST ");
    struct ExecEnviron* e = createEnv();
    execAst(e, astDest);
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