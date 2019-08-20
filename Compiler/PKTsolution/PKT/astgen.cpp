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
	result->operation = 1;
	return result;
}

struct AstElement* makeDeclaration(char* data_type, char* name, struct AstElement* val)
{
	struct AstElement* result = new AstElement();
	result->data.declaration.data_type = data_type;
	result->data.declaration.name = name;
	result->data.declaration.right = val;
	result->operation = 2;
	return result;
}

struct AstElement* makeExpByNum(float val)
{
	struct AstElement* result = new AstElement();
	result->data.expByNum.val = val;
	result->operation = 3;
	return result;
}

struct AstElement* makeExpByString(char* val)
{
	struct AstElement* result = new AstElement();
	result->data.expByString.val = val;
	result->operation = 4;
	return result;
}

struct AstElement* makeExpByName(char* name)
{
	struct AstElement* result = new AstElement();
	result->data.expByName.name = name;
	result->operation = 5;
	return result;
}

struct AstElement* makeExpression(struct AstElement* left, struct AstElement* right, char op)
{
	struct AstElement* result = new AstElement();
	result->data.expression.left = left;
	result->data.expression.right = right;
	result->data.expression.op = op;
	result->operation = 6;
	return result;
}

struct AstElement* makeExpIncrease(char* name)
{
	struct AstElement* result = new AstElement();
	result->data.expByName.name = name;
	result->operation = 7;
	return result;
}

struct AstElement* makeExpDecrease(char* name)
{
	struct AstElement* result = new AstElement();
	result->data.expByName.name = name;
	result->operation = 8;
	return result;
}

struct AstElement* makeStatement(struct AstElement* result, struct AstElement* toAppend)
{
	if (result->flag == false)
	{
		result = new AstElement();
		result->flag = true;
		result->data.statements.count = 0;
		result->data.statements.statements = 0;
		result->operation = 9;
	}
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
	result->operation = 10;
	return result;
}

struct AstElement* makeFor(struct AstElement* cond, struct AstElement* exec)
{
	struct AstElement* result = new AstElement();
	result->data.forStmt.cond = cond;
	result->data.forStmt.statements = exec;
	result->operation = 11;
	return result;
}

struct AstElement* makeIf(struct AstElement* cond, struct AstElement* exec)
{
	struct AstElement* result = new AstElement();
	result->data.ifStmt.cond = cond;
	result->data.ifStmt.statements = exec;
	result->operation = 12;
	return result;
}

struct AstElement* makeElif(struct AstElement* firstIf, struct AstElement* elseIfCond, struct AstElement* exec)
{
	struct AstElement* result = new AstElement();
	result->data.elifStmt.elseIfCond = elseIfCond;
	result->data.elifStmt.statements = exec;
	result->data.elifStmt.firstIf = firstIf;
	result->operation = 13;
	return result;
}

struct AstElement* makeElseIf(struct AstElement* firstIf, struct AstElement* elseStatements)
{
	struct AstElement* result = new AstElement();
	result->data.elseStmt.firstIf = firstIf;
	result->data.elseStmt.elseStatements = elseStatements;
	result->operation = 14;
	return result;
}

struct AstElement* makeBooleanOperation(char* left, struct AstElement* right, char boolOperator)
{
	struct AstElement* result = new AstElement();
	result->data.booleanOperation.left = left;
	result->data.booleanOperation.right = right;
	result->data.booleanOperation.booleanOperator = boolOperator;
	result->operation = 15;
	return result;
}

struct AstElement* makeEqualsOperation(char* left, struct AstElement* right)
{
	struct AstElement* result = new AstElement();
	result->data.eqMeLeOperations.left = left;
	result->data.eqMeLeOperations.right = right;
	result->operation = 27;
	return result;
}

struct AstElement* makeMoreOrEqualOperation(char* left, struct AstElement* right)
{
	struct AstElement* result = new AstElement();
	result->data.eqMeLeOperations.left = left;
	result->data.eqMeLeOperations.right = right;
	result->operation = 28;
	return result;
}

struct AstElement* makeLessOrEqualOperation(char* left, struct AstElement* right)
{
	struct AstElement* result = new AstElement();
	result->data.eqMeLeOperations.left = left;
	result->data.eqMeLeOperations.right = right;
	result->operation = 29;
	return result;
}

struct AstElement* makeAndOperation(struct AstElement* left, struct AstElement* right)
{
	struct AstElement* result = new AstElement();
	result->data.andOrOperation.left = left;
	result->data.andOrOperation.right = right;
	result->operation = 16;
	return result;
}

struct AstElement* makeOrOperation(struct AstElement* left, struct AstElement* right)
{
	struct AstElement* result = new AstElement();
	result->data.andOrOperation.left = left;
	result->data.andOrOperation.right = right;
	result->operation = 17;
	return result;
}

struct AstElement* makeArgument(char* data_type, char* name)
{
	struct AstElement* result = new AstElement();
	result->data.argument.data_type = data_type;
	result->data.argument.name = name;
	result->operation = 18;
	return result;
}

struct AstElement* makeCallArgument(char* name)
{
	struct AstElement* result = new AstElement();
	result->data.callArgument.name = name;
	result->operation = 24;
	return result;
}

struct AstElement* makeCallArgument2(char* strVal)
{
	struct AstElement* result = new AstElement();
	result->data.callArgument2.strVal = strVal;
	result->operation = 25;
	return result;
}

struct AstElement* makeCallArgument3(float numVal)
{
	struct AstElement* result = new AstElement();
	result->data.callArgument3.numVal = numVal;
	result->operation = 26;
	return result;
}

struct AstElement* makeArgumentList(struct AstElement* result, struct AstElement* toAppend)
{
	if (result->flag2 == false)
	{
		result = new AstElement();
		result->flag2 = true;
		result->data.argumentList.count = 0;
		result->data.argumentList.arguments = 0;
		result->operation = 19;
	}
	//assert(result->data.operationNumber == 9);
	result->data.argumentList.count++;
	//AstElement* results2 = cRealloc(result->data.statements.statements, result->data.statements.count * sizeof(*result->data.statements.statements));
	//result = results2;
	result->data.argumentList.arguments = cRealloc(result->data.argumentList.arguments, result->data.argumentList.count * sizeof(*result->data.argumentList.arguments));
	result->data.argumentList.arguments[result->data.argumentList.count - 1] = toAppend;
	return result;
}

struct AstElement* makeFunctionDeclaration(char* data_type, char* name, struct AstElement* argumentsList, struct AstElement* statements)
{
	struct AstElement* result = new AstElement();
	result->data.functionDeclaration.data_type = data_type;
	result->data.functionDeclaration.name = name;
	result->data.functionDeclaration.argumentsList = argumentsList;
	result->data.functionDeclaration.statements = statements;
	result->operation = 20;
	return result;
}

struct AstElement* makeFunctionCall(char* name, struct AstElement* parameters)
{
	struct AstElement* result = new AstElement();
	result->data.functionCall.name = name;
	result->data.functionCall.parameters = parameters;
	result->operation = 21;
	return result;
}

struct AstElement* makeFunctionCallWithoutParameters(char* name)
{
	struct AstElement* result = new AstElement();
	result->data.functionCallWithoutParameters.name = name;
	result->operation = 22;
	return result;
}

struct AstElement* makeReturnStatement(struct AstElement* expression)
{
	struct AstElement* result = new AstElement();
	result->data.returnStatement.expression = expression;
	result->operation = 23;
	return result;
}

struct AstElement* makeAssignFunctionValue(char* varName, char* funcName, struct AstElement* parameters)
{
	struct AstElement* result = new AstElement();
	result->data.assignFunctionValue.varName = varName;
	result->data.assignFunctionValue.funcName = funcName;
	result->data.assignFunctionValue.parameters = parameters;
	result->operation = 30;
	return result;
}

