#include "astgen.h"
#include <stdio.h>
#include <stdlib.h>
#include <assert.h>
#include <string.h>

//Function that is not used
/*
static AstElement* checkAlloc(size_t sz)
{
	void* result = calloc(sz, 1);
	if (!result)
	{
		printf("alloc failed\n");
		exit(1);
	}
}
*/
//Function used to resize the pointer
static AstElement** cRealloc(AstElement** Block, size_t sz)
{
	void* result = realloc(Block, sz);
	if (!result)
	{
		printf("alloc failed\n");
		exit(1);
	}
}

//All of the following functions are responsible for AST node creation and value assignments
struct AstElement* makeAssignment(char* name, struct AstElement* val)
{
	struct AstElement* result = new AstElement();
	result->data.assignment.name = name;
	result->data.assignment.right = val;
	result->data.assignment.operation = "assignment";
	printf(" assignment ");
	return result;
}

struct AstElement* makeDeclaration(char* data_type, char* name, struct AstElement* val)
{
	struct AstElement* result = new AstElement();
	result->data.declaration.data_type = data_type;
	result->data.declaration.name = name;
	result->data.declaration.right = val;
	result->data.declaration.operation = "declaration";
	printf(" assignment ");
	return result;
}

struct AstElement* makeExpByNum(float val)
{
	struct AstElement* result = new AstElement();
	result->data.expByNum.val = val;
	result->data.expByNum.operation = "expByNum";
	printf(" number: %f", result->data.expByNum.val);
	return result;
}

struct AstElement* makeExpByString(char* val)
{
	struct AstElement* result = new AstElement();
	result->data.expByString.val = val;
	result->data.expByString.operation = "expByString";
	printf(" string: %s ", result->data.expByString.val);
	return result;
}

struct AstElement* makeExpByName(char* name)
{
	struct AstElement* result = new AstElement();
	result->data.expByName.name = name;
	result->data.expByName.operation = "expByName";
	printf(" ID: %s ", result->data.expByName.name);
	return result;
}

struct AstElement* makeExpression(struct AstElement* left, struct AstElement* right, char* op)
{
	struct AstElement* result = new AstElement();
	result->data.expression.left = left;
	result->data.expression.right = right;
	result->data.expression.op = op;
	result->data.expression.operation = "expression";
	printf(" expression ");
	return result;
}

struct AstElement* makeExpIncrease(char* name)
{
	struct AstElement* result = new AstElement();
	result->data.expByName.name = name;
	result->data.expByName.operation = "expIncrease";
	printf(" increase: %s ", result->data.expByName.name);
	return result;
}

struct AstElement* makeExpDecrease(char* name)
{
	struct AstElement* result = new AstElement();
	result->data.expByName.name = name;
	result->data.expByName.operation = "expDecrease";
	printf(" decrease: %s ", result->data.expByName.name);
	return result;
}

struct AstElement* makeStatement(struct AstElement* result, struct AstElement* toAppend)
{
	if (!result)
	{
		result = new AstElement();
		result->data.statements.count = 0;
		result->data.statements.statements = 0;
		result->data.statements.operation = "statements";
	}
	printf(" statement ");
	//assert(result->data.operationNumber == 9);
	result->data.statements.count++;
	//AstElement* results2 = cRealloc(result->data.statements.statements, result->data.statements.count * sizeof(*result->data.statements.statements));
	//result = results2;
	result->data.statements.statements = cRealloc(result->data.statements.statements, result->data.statements.count * sizeof(*result->data.statements.statements));
	result->data.statements.statements[result->data.statements.count - 1] = toAppend;
	return result;
}

struct AstElement* makeWhile(struct AstElement* cond, struct AstElement* exec)
{
	struct AstElement* result = new AstElement();
	result->data.whileStmt.cond = cond;
	result->data.whileStmt.statements = exec;
	result->data.whileStmt.operation = "whileStmt";
	printf(" while_statement ");
	return result;
}

struct AstElement* makeFor(struct AstElement* cond, struct AstElement* exec)
{
	struct AstElement* result = new AstElement();
	result->data.forStmt.cond = cond;
	result->data.forStmt.statements = exec;
	return result;
}

struct AstElement* makeIf(struct AstElement* cond, struct AstElement* exec)
{
	struct AstElement* result = new AstElement();
	result->data.ifStmt.cond = cond;
	result->data.ifStmt.statements = exec;
	result->data.ifStmt.operation = "ifStmt";
	printf(" if_statement ");
	return result;
}

struct AstElement* makeElif(struct AstElement* firstIf, struct AstElement* elseIfCond, struct AstElement* exec)
{
	struct AstElement* result = new AstElement();
	result->data.elifStmt.elseIfCond = elseIfCond;
	result->data.elifStmt.statements = exec;
	result->data.elifStmt.firstIf = firstIf;
	result->data.elifStmt.operation = "elifStmt";
	printf(" elif_statement ");
	return result;
}

struct AstElement* makeElseIf(struct AstElement* firstIf, struct AstElement* elseStatements)
{
	struct AstElement* result = new AstElement();
	result->data.elseStmt.firstIf = firstIf;
	result->data.elseStmt.elseStatements = elseStatements;
	result->data.elseStmt.operation = "elseStmt";
	printf(" else_statement ");
	return result;
}

struct AstElement* makeBooleanOperation(struct AstElement* left, struct AstElement* right, char* boolOperator)
{
	struct AstElement* result = new AstElement();
	result->data.booleanOperation.left = left;
	result->data.booleanOperation.right = right;
	result->data.booleanOperation.binaryOperator = boolOperator;
	result->data.booleanOperation.operation = "booleanOperation";
	printf(" BoolOperation ");
	return result;
}

struct AstElement* makeAndOperation(struct AstElement* left, struct AstElement* right)
{
	struct AstElement* result = new AstElement();
	result->data.andOrOperation.left = left;
	result->data.andOrOperation.right = right;
	result->data.andOrOperation.operation = "andOperation";
	printf(" ANDOperation ");
	return result;
}

struct AstElement* makeOrOperation(struct AstElement* left, struct AstElement* right)
{
	struct AstElement* result = new AstElement();
	result->data.andOrOperation.left = left;
	result->data.andOrOperation.right = right;
	result->data.andOrOperation.operation = "orOperation";
	printf(" OROperation ");
	return result;
}

struct AstElement* makeArgument(char* data_type, char* name)
{
	struct AstElement* result = new AstElement();
	result->data.argument.data_type = data_type;
	result->data.argument.name = name;
	result->data.argument.operation = "argument";
	printf(" argument ");
	return result;
}

struct AstElement* makeArgumentList(struct AstElement* left, struct AstElement* right)
{
	struct AstElement* result = new AstElement();
	result->data.argumentList.left = left;
	result->data.argumentList.right = right;
	result->data.argumentList.operation = "argumentList";
	printf(" argumentList ");
	return result;
}

struct AstElement* makeFunctionDeclaration(char* data_type, char* name, struct AstElement* argumentsList, struct AstElement* statements)
{
	struct AstElement* result = new AstElement();
	result->data.functionDeclaration.data_type = data_type;
	result->data.functionDeclaration.name = name;
	result->data.functionDeclaration.argumentsList = argumentsList;
	result->data.functionDeclaration.statements = statements;
	result->data.functionDeclaration.operation = "functionDeclaration";
	printf(" Function declaration ");
	return result;
}

struct AstElement* makeFunctionCall(char* name, struct AstElement* parameters)
{
	struct AstElement* result = new AstElement();
	result->data.functionCall.name = name;
	result->data.functionCall.parameters = parameters;
	result->data.functionCall.operation = "functionCall";
	printf(" function call ");
	return result;
}

struct AstElement* makeFunctionCallWithoutParameters(char* name)
{
	struct AstElement* result = new AstElement();
	result->data.functionCallWithoutParameters.name = name;
	result->data.functionCallWithoutParameters.operation = "functionCallWithoutParameters";
	printf(" parameterless function call ");
	return result;
}

struct AstElement* makeReturnStatement(struct AstElement* expression)
{
	struct AstElement* result = new AstElement();
	result->data.returnStatement.expression = expression;
	result->data.returnStatement.operation = "returnStatement";
	printf(" return statement ");
	return result;
}