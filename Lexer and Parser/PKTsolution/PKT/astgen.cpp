#include "astgen.h"
#include <stdio.h>
#include <stdlib.h>
#include <assert.h>
#include <string.h>

static AstElement* checkAlloc(size_t sz)
{
	void* result = calloc(sz, 1);
	if (!result)
	{
		printf("alloc failed\n");
		exit(1);
	}
}
static AstElement** cRealloc(AstElement** Block, size_t sz)
{
	void* result = realloc(Block, sz);
	if (!result)
	{
		printf("alloc failed\n");
		exit(1);
	}
}

struct AstElement* makeAssignment(char* name, struct AstElement* val)
{
	struct AstElement* result = new AstElement();
	result->data.assignment.name = name;
	result->data.assignment.right = val;
	printf(" assignment ");
	return result;
}

struct AstElement* makeDeclaration(char* data_type, char* name, struct AstElement* val)
{
	struct AstElement* result = new AstElement();
	result->data.declaration.data_type = data_type;
	result->data.declaration.name = name;
	result->data.declaration.right = val;
	printf(" assignment ");
	return result;
}

struct AstElement* makeExpByNum(float val)
{
	struct AstElement* result = new AstElement();
	result->data.val = val;
	printf(" number: %f ", result->data.val);
	return result;
}

struct AstElement* makeExpByString(char* val)
{
	struct AstElement* result = new AstElement();
	result->data.charVal = val;
	printf(" string: %s ", result->data.charVal);
	return result;
}

struct AstElement* makeExpByName(char* name)
{
	struct AstElement* result = new AstElement();
	result->data.name = name;
	printf(" ID: %s ", result->data.name);
	return result;
}

struct AstElement* makeExp(struct AstElement* left, struct AstElement* right, char* op)
{
	struct AstElement* result = new AstElement();
	result->data.expression.left = left;
	result->data.expression.right = right;
	result->data.expression.op = op;
	printf(" expression ");
	return result;
}

struct AstElement* makeExpIncrease(char* name)
{
	struct AstElement* result = new AstElement();
	result->data.name = name;
	printf(" increase: %s ", result->data.name);
	return result;
}

struct AstElement* makeExpDecrease(char* name)
{
	struct AstElement* result = new AstElement();
	result->data.name = name;
	printf(" decrease: %s ", result->data.name);
	return result;
}

struct AstElement* makeStatement(struct AstElement* result, struct AstElement* toAppend)
{
	if (!result)
	{
		result = new AstElement();
		result->data.statements.count = 0;
		result->data.statements.statements = 0;
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
	printf(" if ");
	return result;
}

struct AstElement* makeElif(struct AstElement* firstIf, struct AstElement* elseIfCond, struct AstElement* exec)
{
	struct AstElement* result = new AstElement();
	result->data.elifStmt.elseIfCond = elseIfCond;
	result->data.elifStmt.statements = exec;
	result->data.elifStmt.firstIf = firstIf;
	printf(" elif ");
	return result;
}

struct AstElement* makeElseIf(struct AstElement* firstIf, struct AstElement* elseStatements)
{
	struct AstElement* result = new AstElement();
	result->data.elseStmt.firstIf = firstIf;
	result->data.elseStmt.elseStatements = elseStatements;
	printf(" elseif ");
	return result;
}

struct AstElement* makeBooleanOperation(struct AstElement* left, struct AstElement* right, char* binaryOperator)
{
	struct AstElement* result = new AstElement();
	result->data.booleanOperation.left = left;
	result->data.booleanOperation.right = right;
	result->data.booleanOperation.binaryOperator = binaryOperator;
	printf(" BoolOperation ");
	return result;
}

struct AstElement* makeAndOperation(struct AstElement* left, struct AstElement* right)
{
	struct AstElement* result = new AstElement();
	result->data.andOrOperation.left = left;
	result->data.andOrOperation.right = right;
	printf(" ANDOperation ");
	return result;
}

struct AstElement* makeOrOperation(struct AstElement* left, struct AstElement* right)
{
	struct AstElement* result = new AstElement();
	result->data.andOrOperation.left = left;
	result->data.andOrOperation.right = right;
	printf(" OROperation ");
	return result;
}

struct AstElement* makeArgument(char* data_type, char* name)
{
	struct AstElement* result = new AstElement();
	result->data.argument.data_type = data_type;
	result->data.argument.name = name;
	printf(" argument ");
	return result;
}

struct AstElement* makeArgumentList(struct AstElement* left, struct AstElement* right)
{
	struct AstElement* result = new AstElement();
	result->data.argumentList.left = left;
	result->data.argumentList.right = right;
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
	printf(" argumentList ");
	return result;
}

struct AstElement* makeFunctionCall(char* name, struct AstElement* parameters)
{
	struct AstElement* result = new AstElement();
	result->data.functionCall.name = name;
	result->data.functionCall.parameters = parameters;
	printf(" function call ");
	return result;
}

struct AstElement* makeFunctionCallWithoutParameters(char* name)
{
	struct AstElement* result = new AstElement();
	result->data.functionCallWithoutParameters.name = name;
	printf(" parameterless function call ");
	return result;
}