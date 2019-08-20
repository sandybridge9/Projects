#include "astexec.h"
#include "astgen.h"
#include <stdlib.h>
#include <assert.h>
#include <stdio.h>
#include <string.h>
#include <vector>
#include <ctime>
#include <chrono>
#include <iostream>
using std::vector;

struct variable
{
	int type = 0; // 1 - number_const, 2 - string_const, 3 - number_variable, 4 - string_variable, 5 - boolean value, 6 - function parameter, 7 - return statement
	char* actualType;
	char* name;
	char* strVal;
	float numVal = 0;
	bool state = false;
};

struct function
{
	char* data_type;
	char* name;
	AstElement* parametersListAst;
	vector <variable> parametersList;
	AstElement* statements;
};

struct ExecEnviron
{
	vector <variable> variables;
	vector <function> functions;
	bool state = true;
	//int x; /* The value of the x variable, a real language would have some name->value lookup table instead */
};
struct ExecEnviron* createEnv();
void execAst(struct ExecEnviron* e, struct AstElement* a);
void freeEnv(struct ExecEnviron* e);
static variable valueExecs(struct ExecEnviron* e, struct AstElement* a);
static variable execExpByNumber(struct ExecEnviron* e, struct AstElement* a);
static variable execExpByString(struct ExecEnviron* e, struct AstElement* a);
static variable execExpByName(struct ExecEnviron* e, struct AstElement* a);
static variable execBinaryExp(struct ExecEnviron* e, struct AstElement* a);
static void execIncreaseExp(struct ExecEnviron* e, struct AstElement* a);
static void execDecreaseExp(struct ExecEnviron* e, struct AstElement* a);
static variable execBooleanExp(struct ExecEnviron* e, struct AstElement* a);
static variable execEqualsExp(struct ExecEnviron* e, struct AstElement* a);
static variable execMoreEqualsExp(struct ExecEnviron* e, struct AstElement* a);
static variable execLessEqualsExp(struct ExecEnviron* e, struct AstElement* a);
static void runnableExecs(struct ExecEnviron* e, struct AstElement* a);
static void execDeclaration(struct ExecEnviron* e, struct AstElement* a);
static void execAssignment(struct ExecEnviron* e, struct AstElement* a);
static void execStatements(struct ExecEnviron* e, struct AstElement* a);
static void execWhile(struct ExecEnviron* e, struct AstElement* a);
static void execIf(struct ExecEnviron* e, struct AstElement* a);
static void execElif(struct ExecEnviron* e, struct AstElement* a);
static void execElseIf(struct ExecEnviron* e, struct AstElement* a);
static void functionDeclaration(struct ExecEnviron* e, struct AstElement* a);
static void functionCall(struct ExecEnviron* e, struct AstElement* a);
static variable functionArgument(struct ExecEnviron* e, struct AstElement* a);
static variable functionCallArgument(struct ExecEnviron* e, struct AstElement* a);
static variable functionCallArgument2(struct ExecEnviron* e, struct AstElement* a);
static variable functionCallArgument3(struct ExecEnviron* e, struct AstElement* a);
//static variable functionReturnStatement(struct ExecEnviron* e, struct AstElement* a);
static void functionReturnStatement(struct ExecEnviron* e, struct AstElement* a);
static void assignFunctionValue(struct ExecEnviron* e, struct AstElement* a);
static void functionCallWithoutParameters(struct ExecEnviron* e, struct AstElement* a);
//static void execCall(struct ExecEnviron* e, struct AstElement* a);

//
//
//
//Method responsible for getting the value of expression
static variable valueExecs(struct ExecEnviron* e, struct AstElement* a)
{
	if (a->operation == 3) 
	{
		variable var = execExpByNumber(e, a);
		return var;
	}
	else if (a->operation == 4) 
	{
		variable var = execExpByString(e, a);
		return var;
	}
	else if (a->operation == 5)
	{
		variable var = execExpByName(e, a);
		return var;
	}
	else if (a->operation == 6) 
	{
		variable var = execBinaryExp(e, a);
		return var;
	}
	else if (a->operation == 15)
	{
		variable var = execBooleanExp(e, a);
		return var;
	}
	else if (a->operation == 27)
	{
		variable var = execEqualsExp(e, a);
		return var;
	}
	else if (a->operation == 28)
	{
		variable var = execMoreEqualsExp(e, a);
		return var;
	}
	else if (a->operation == 29)
	{
		variable var = execLessEqualsExp(e, a);
		return var;
	}
	else if (a->operation == 18)
	{
		variable var = functionArgument(e, a);
		return var;
	}
	else if (a->operation == 24)
	{
		variable var = functionCallArgument(e, a);
		return var;
	}
	else if (a->operation == 25)
	{
		variable var = functionCallArgument2(e, a);
		return var;
	}
	else if (a->operation == 26)
	{
		variable var = functionCallArgument3(e, a);
		return var;
	}/*
	else if (a->operation == 23)
	{
		variable var = functionReturnStatement(e, a);
		printf(" %s ", var.name);
		return var;
	}*/
}

//returns a number value
static variable execExpByNumber(struct ExecEnviron* e, struct AstElement* a) 
{
	variable var;
	var.type = 1;
	var.numVal = a->data.expByNum.val;
	return var;
}

//returns a string value
static variable execExpByString(struct ExecEnviron* e, struct AstElement* a)
{
	variable var;
	var.type = 2;
	var.strVal = a->data.expByString.val;
	return var;
}

//finds a variable with a matching name and returns it
static variable execExpByName(struct ExecEnviron* e, struct AstElement* a)
{
	variable var;
	var.name = a->data.expByName.name;
	for (variable v : e->variables)
	{
		if (strcmp(v.name, var.name) == 0)
		{
			var = v;
			break;
		}
	}
	return var; 
}

//increases number variable's value by 1
static void execIncreaseExp(struct ExecEnviron* e, struct AstElement* a)
{
	char* name = a->data.expByName.name;
	for (variable v : e->variables)
	{
		if (strcmp(v.name, name) == 0)
		{
			if (v.actualType == "number")
			{
				v.numVal = v.numVal + 1;
				break;
			}
			
		}
	}
}

//decreases number variable's value by 1
static void execDecreaseExp(struct ExecEnviron* e, struct AstElement* a)
{
	char* name = a->data.expByName.name;
	for (variable v : e->variables)
	{
		if (v.name == name)
		{
			if (v.actualType == "number")
			{
				v.numVal = v.numVal + 1;
				break;
			}

		}
	}
}

//Executes binary operations and returns a number
static variable execBinaryExp(struct ExecEnviron* e, struct AstElement* a)
{
	variable left = valueExecs(e, a->data.expression.left);
	variable right = valueExecs(e, a->data.expression.right);
	if ((left.type == 1  || left.type == 3) && (right.type == 1 || left.type == 3)) {
		if (a->data.expression.op == '+') {
			variable ans;
			ans.type = 1; //ans is a number
			ans.numVal = left.numVal + right.numVal;
			return ans;
		}
		else if (a->data.expression.op == '-') {
			variable ans;
			ans.type = 1; //ans is a number
			ans.numVal = left.numVal - right.numVal;
			return ans;
		}
		else if (a->data.expression.op == '*') {
			variable ans;
			ans.type = 1; //ans is a number
			ans.numVal = left.numVal * right.numVal;
			return ans;
		}
		else if (a->data.expression.op == '/') {
			variable ans;
			ans.type = 1; //ans is a number
			ans.numVal = left.numVal / right.numVal;
			return ans;
		}
		/*
		else if (a->data.expression.op = "%") {
			variable ans;
			ans.numVal = left.numVal % right.numVal;
			return ans;
		}
		*/
	}
}

//Executes Boolean expressions
static variable execBooleanExp(struct ExecEnviron* e, struct AstElement* a)
{
	char* leftName = a->data.booleanOperation.left;
	variable left;
	variable right = valueExecs(e, a->data.booleanOperation.right);
	char booleanOperator = a->data.booleanOperation.booleanOperator;

	for (int i = 0; i < e->variables.size(); i++)
	{
		if (strcmp(e->variables.at(i).name, leftName) == 0)
		{
			left = e->variables.at(i);
		}
	}
	if ((left.type == 1 || left.type == 3) && (right.type == 1 || left.type == 3)) {
		if (booleanOperator == '<') {
			variable ans;
			ans.type = 5; //ans is a bool
			if (left.numVal < right.numVal)
			{
				ans.state = true;
				return ans;
				//return true;
			}
			else if (left.numVal >= right.numVal)
			{
				ans.state = false;
				return ans;
				//return false;
			}
		}
		else if (booleanOperator == '>') {
			variable ans;
			ans.type = 5; //ans is a bool
			if (left.numVal > right.numVal)
			{
				ans.state = true;
				return ans;
				//return true;
			}
			else if (left.numVal <= right.numVal)
			{
				ans.state = false;
				return ans;
				//return false;
			}
		}
	}
}

//Executes Equals expression
static variable execEqualsExp(struct ExecEnviron* e, struct AstElement* a)
{
	char* leftName = a->data.booleanOperation.left;
	variable left;
	variable right = valueExecs(e, a->data.booleanOperation.right);

	for (int i = 0; i < e->variables.size(); i++)
	{
		if (strcmp(e->variables.at(i).name, leftName) == 0)
		{
			left = e->variables.at(i);
		}
	}
	if ((left.type == 1 || left.type == 3) && (right.type == 1 || left.type == 3)) {
		variable ans;
		ans.type = 5;
		if (left.numVal == right.numVal)
		{
			ans.state = true;
			return ans;
		}
		else
		{
			ans.state = false;
			return ans;
		}
	}
}

//Executes More equals expression
static variable execMoreEqualsExp(struct ExecEnviron* e, struct AstElement* a)
{
	char* leftName = a->data.booleanOperation.left;
	variable left;
	variable right = valueExecs(e, a->data.booleanOperation.right);

	for (int i = 0; i < e->variables.size(); i++)
	{
		if (strcmp(e->variables.at(i).name, leftName) == 0)
		{
			left = e->variables.at(i);
		}
	}
	if ((left.type == 1 || left.type == 3) && (right.type == 1 || left.type == 3)) {
		variable ans;
		ans.type = 5;
		if (left.numVal >= right.numVal)
		{
			ans.state = true;
			return ans;
		}
		else
		{
			ans.state = false;
			return ans;
		}
	}
}

//Executes More equals expression
static variable execLessEqualsExp(struct ExecEnviron* e, struct AstElement* a)
{
	char* leftName = a->data.booleanOperation.left;
	variable left;
	variable right = valueExecs(e, a->data.booleanOperation.right);

	for (int i = 0; i < e->variables.size(); i++)
	{
		if (strcmp(e->variables.at(i).name, leftName) == 0)
		{
			left = e->variables.at(i);
		}
	}
	if ((left.type == 1 || left.type == 3) && (right.type == 1 || left.type == 3)) {
		variable ans;
		ans.type = 5;
		if (left.numVal <= right.numVal)
		{
			ans.state = true;
			return ans;
		}
		else
		{
			ans.state = false;
			return ans;
		}
	}
}

//Function argument template
static variable functionArgument(struct ExecEnviron* e, struct AstElement* a)
{
	char* data_type = a->data.argument.data_type;
	char* name = a->data.argument.name;
	variable var;
	var.actualType = data_type;
	var.name = name;
	//var.type = 6;
	return var;
}

//Function call parameter template
static variable functionCallArgument(struct ExecEnviron* e, struct AstElement* a)
{
	char* name = a->data.callArgument.name;
	variable var;
	for (int i = 0; i < e->variables.size(); i++)
	{
		if (strcmp(name, e->variables.at(i).name) == 0)
		{
			var = e->variables.at(i);
			return var;
		}
	}
}

//Function call parameter template for string values without identifier
static variable functionCallArgument2(struct ExecEnviron* e, struct AstElement* a)
{
	char* strVal = a->data.callArgument2.strVal;
	variable var;
	var.type = 2;
	var.strVal = strVal;
	return var;
}

//Function call parameter template for float values without identifier
static variable functionCallArgument3(struct ExecEnviron* e, struct AstElement* a)
{
	float numVal = a->data.callArgument3.numVal;
	variable var;
	var.type = 1;
	var.numVal = numVal;
	return var;
}


//
//
//
//All runnable actions ( declarations, assignments, statements, while and for loops etc. )
static void runnableExecs(struct ExecEnviron* e, struct AstElement* a)
{
	if (e->state == true)
	{
		if (a->operation == 1)
		{
			execAssignment(e, a);
		}
		else if (a->operation == 2)
		{
			execDeclaration(e, a);
		}
		else if (a->operation == 7)
		{
			execIncreaseExp(e, a);
		}
		else if (a->operation == 8)
		{
			execDecreaseExp(e, a);
		}
		else if (a->operation == 9)
		{
			execStatements(e, a);
		}
		else if (a->operation == 10)
		{
			execWhile(e, a);
		}
		else if (a->operation == 12)
		{
			execIf(e, a);
		}
		else if (a->operation == 13)
		{
			execElif(e, a);
		}
		else if (a->operation == 14)
		{
			execElseIf(e, a);
		}
		else if (a->operation == 20)
		{
			functionDeclaration(e, a);
		}
		else if (a->operation == 21)
		{
			functionCall(e, a);
		}
		else if (a->operation == 22)
		{
			functionCallWithoutParameters(e, a);
		}
		else if (a->operation == 23)
		{
			functionReturnStatement(e, a);
		}
		else if (a->operation == 30)
		{
			assignFunctionValue(e, a);
		}
	}
}

//Variable declaration
static void execDeclaration(struct ExecEnviron* e, struct AstElement* a)
{
	char* name = a->data.declaration.name;
	char* data_type = a->data.declaration.data_type;
	variable var = valueExecs(e, a->data.declaration.right); // right side value/variable
	var.name = name; // assigns a name to the new variable
	var.actualType = data_type; // assigns a data type to the new variable
	if (strcmp(var.actualType, "string") == 0)
	{
		var.type = 4;
	}
	else if (strcmp(var.actualType, "number") == 0)
	{
		var.type = 3;
	}
	e->variables.push_back(var); // pushes the new variable into the variable array
}

//Value assignment
static void execAssignment(struct ExecEnviron* e, struct AstElement* a)
{
	char* name = a->data.assignment.name;
	struct AstElement* r = a->data.assignment.right;
	variable var = valueExecs(e, r); //gets right side value/variable

	for(int i = 0; i < e->variables.size(); i++)
	{
		if (strcmp(e->variables.at(i).name, name) == 0)
		{
			if (e->variables.at(i).type == 3)
			{
				if (var.type == 1 || var.type == 3)
				{
					e->variables.at(i).numVal = var.numVal;
					break;
				}
			}
			else if (e->variables.at(i).type == 4)
			{
				if (var.type == 2 || var.type == 4)
				{
					e->variables.at(i).strVal = var.strVal;
					break;
				}
			}
		}
	}

}

//All statement execution
static void execStatements(struct ExecEnviron* e, struct AstElement* a)
{
	for (int i = 0; i < a->data.statements.count-1; i++)
	{
		runnableExecs(e, a->data.statements.statements[i]);
	}
}

//While statement execution
static void execWhile(struct ExecEnviron* e, struct AstElement* a)
{
	struct AstElement* const condition = a->data.whileStmt.cond;
	struct AstElement* const statements = a->data.whileStmt.statements;
	variable var;
	var = valueExecs(e, condition);
	if (var.type == 5)
	{
		while (var.state)
		{
			runnableExecs(e, statements);
			var = valueExecs(e, condition);
		}
	}

}

//If statement execution
static void execIf(struct ExecEnviron* e, struct AstElement* a)
{
	struct AstElement* const condition = a->data.ifStmt.cond;
	struct AstElement* const statements = a->data.ifStmt.statements;
	variable var;
	var = valueExecs(e, condition);
	if (var.type == 5)
	{
		if (var.state)
		{
			runnableExecs(e, statements);
		}
	}

}

//Elif statement execution
static void execElif(struct ExecEnviron* e, struct AstElement* a)
{
	struct AstElement* const firstIfCond = a->data.elifStmt.firstIf->data.ifStmt.cond;
	struct AstElement* const firstIfStatements = a->data.elifStmt.firstIf->data.ifStmt.statements;
	struct AstElement* const elifCond = a->data.elifStmt.elseIfCond;
	struct AstElement* const elifStatements = a->data.elifStmt.statements;
	variable var1;
	var1 = valueExecs(e, firstIfCond);
	variable var2;
	var2 = valueExecs(e, elifCond);
	if (var1.type == 5 && var2.type == 5)
	{
		if (var1.state)
		{
			runnableExecs(e, firstIfStatements);
		}
		else if (var2.state)
		{
			runnableExecs(e, elifStatements);
		}
	}
}

//If Else statement execution
static void execElseIf(struct ExecEnviron* e, struct AstElement* a)
{
	struct AstElement* const firstIfCond = a->data.elseStmt.firstIf->data.ifStmt.cond;
	struct AstElement* const firstIfStatements = a->data.elseStmt.firstIf->data.ifStmt.statements;
	struct AstElement* const elseStatements = a->data.elseStmt.elseStatements;
	variable var;
	var = valueExecs(e, firstIfCond);
	if (var.type == 5)
	{
		if (var.state)
		{
			runnableExecs(e, firstIfStatements);
		}
		else
		{
			runnableExecs(e, elseStatements);
		}
	}

}

//Function declaration
static void functionDeclaration(struct ExecEnviron* e, struct AstElement* a)
{
	char* data_type = a->data.functionDeclaration.data_type;
	char* name = a->data.functionDeclaration.name;
	struct AstElement* parametersListAst = a->data.functionDeclaration.argumentsList;
	struct AstElement* statements = a->data.functionDeclaration.statements;
	function func;
	func.data_type = data_type;
	func.name = name;
	func.parametersListAst = parametersListAst;
	func.statements = statements;
	vector<variable> parametersList;
	for (int i = 0; i < parametersListAst->data.argumentList.count; i++)
	{
		variable param = valueExecs(e, parametersListAst->data.argumentList.arguments[i]);
		parametersList.push_back(param);
	}
	func.parametersList = parametersList;
	e->functions.push_back(func);
}

//Function call
static void functionCall(struct ExecEnviron* e, struct AstElement* a)
{
	char* name = a->data.functionCall.name;
	struct AstElement* argumentsList = a->data.functionCall.parameters;
	function func;
	//Function call parameters
	vector<variable> parametersList;
	for (int i = 0; i < argumentsList->data.argumentList.count; i++)
	{
		variable param = valueExecs(e, argumentsList->data.argumentList.arguments[i]);
		parametersList.push_back(param);
	}
	if (strcmp(name, "print") == 0) // print function
	{
		for (int i = 0; i < parametersList.size(); i++)
		{			
			variable param = parametersList.at(i);
			if(param.type == 2)
			{
				printf(param.strVal);
			}
			else if (param.type == 1)
			{
				printf("%f", param.numVal);
			}
			else if (strcmp(param.actualType, "number") == 0)
			{
				printf("%f", param.numVal);
			}
			else if(strcmp(param.actualType, "string") == 0)
			{
				printf(param.strVal);
			}
		}
	}
	else //User made functions
	{
		for (function f : e->functions)
		{
			if (strcmp(f.name, name) == 0)
			{
				func = f;
			}
		}
		AstElement* statements = func.statements; //All function statements
		vector<variable> parametersList2 = func.parametersList; // Function declaration parameters
		vector<variable> actualParameters;
		bool match = false;
		if (parametersList.size() == parametersList2.size())
		{
			for (int i = 0; i < parametersList.size(); i++)
			{
				if (strcmp(parametersList.at(i).actualType, parametersList2.at(i).actualType) != 0)
				{
					match = false;
					break;
				}
				else
				{
					if (strcmp(parametersList.at(i).actualType, "string") == 0)
					{
						parametersList2.at(i).strVal = parametersList.at(i).strVal;
					}
					else if (strcmp(parametersList.at(i).actualType, "number") == 0)
					{
						parametersList2.at(i).numVal = parametersList.at(i).numVal;
					}
					match = true;
				}
			}
		}
		if (match == true)
		{
			for (variable v : parametersList2)
			{
				if (strcmp(v.actualType, "string") == 0)
				{
					printf("- name: %s, strVal: %s -", v.name, v.strVal);
				}
				else if (strcmp(v.actualType, "number") == 0)
				{
					printf("- name: %s, numVal: %f -", v.name, v.numVal);
				}
			}
			ExecEnviron* e2 = createEnv(); // Function is executed in a new environment
			e2->variables = parametersList2; //Assigning parameters to new environment's variables
			execAst(e2, statements); // Funtion execution
			freeEnv(e2);
		}
	}
}

//Function call without parameters
static void functionCallWithoutParameters(struct ExecEnviron* e, struct AstElement* a)
{
	char* name = a->data.functionCallWithoutParameters.name;
	function func;
	if (strcmp(name, "print") == 0) // print function
	{
		printf("Print can't be called without parameters");
	}
	else if (strcmp(name, "time") == 0)
	{
		auto start = std::chrono::system_clock::now();
		auto end = std::chrono::system_clock::now();
		std::chrono::duration<double> elapsed_seconds = end - start;
		std::time_t end_time = std::chrono::system_clock::to_time_t(end);
		std::cout << "Current Time: " << std::ctime(&end_time) << "\n";
	}
	else //User made functions without parameters
	{
		for (function f : e->functions)
		{
			if (strcmp(f.name, name) == 0)
			{
				func = f;
			}
		}
		if (func.parametersList.size() != 0)
		{
			printf("FUNCTION HAS TO BE CALLED WITH PARAMETERS");
		}
		else
		{
			AstElement* statements = func.statements; //All function statements
			ExecEnviron* e2 = createEnv(); // Function is executed in a new environment
			execAst(e2, statements); // Funtion execution
			freeEnv(e2);
		}

	}
}

//Return statement
/*
static variable functionReturnStatement(struct ExecEnviron* e, struct AstElement* a)
{
	printf(" 654654465456456return_statement6465645465 ");
	AstElement* returnExpression = a->data.returnStatement.expression;
	variable var = valueExecs(e, returnExpression);
	var.type = 7;
	return var;
}*/

static void functionReturnStatement(struct ExecEnviron* e, struct AstElement* a)
{
	AstElement* returnExpression = a->data.returnStatement.expression;
	variable var = valueExecs(e, returnExpression);
	var.type = 7;
	e->variables.push_back(var);
	e->state = false;
}

static void assignFunctionValue(struct ExecEnviron* e, struct AstElement* a)
{
	char* varName = a->data.assignFunctionValue.varName;
	char* funcName = a->data.assignFunctionValue.funcName;
	struct AstElement* argumentsList = a->data.assignFunctionValue.parameters;
	function func;
	//Function call parameters
	vector<variable> parametersList;
	for (int i = 0; i < argumentsList->data.argumentList.count; i++)
	{
		variable param = valueExecs(e, argumentsList->data.argumentList.arguments[i]);
		parametersList.push_back(param);
	}
	for (function f : e->functions)
	{
		if (strcmp(f.name, funcName) == 0)
		{
			func = f;
		}
	}
	AstElement* statements = func.statements; //All function statements
	vector<variable> parametersList2 = func.parametersList; // Function declaration parameters
	vector<variable> actualParameters;
	bool match = false;
	if (parametersList.size() == parametersList2.size())
	{
		for (int i = 0; i < parametersList.size(); i++)
		{
			if (strcmp(parametersList.at(i).actualType, parametersList2.at(i).actualType) != 0)
			{
				match = false;
				break;
			}
			else
			{
				if (strcmp(parametersList.at(i).actualType, "string") == 0)
				{
					parametersList2.at(i).type = parametersList.at(i).type;
					parametersList2.at(i).strVal = parametersList.at(i).strVal;
				}
				else if (strcmp(parametersList.at(i).actualType, "number") == 0)
				{
					parametersList2.at(i).type = parametersList.at(i).type;
					parametersList2.at(i).numVal = parametersList.at(i).numVal;
				}
				match = true;
			}
		}
	}
	if (match == true)
	{
		for (variable v : parametersList2)
		{
			if (strcmp(v.actualType, "string") == 0)
			{
				printf("- name: %s, strVal: %s -", v.name, v.strVal);
			}
			else if (strcmp(v.actualType, "number") == 0)
			{
				printf("- name: %s, numVal: %f -", v.name, v.numVal);
			}
		}
		ExecEnviron* e2 = createEnv(); // Function is executed in a new environment
		e2->variables = parametersList2; //Assigning parameters to new environment's variables
		e2->functions = e->functions; // for recursion
		execAst(e2, statements); // Funtion execution
		if (strcmp(func.data_type, "void") == 0)
		{
			freeEnv(e2);
		}
		else
		{
			variable returnVariable; //The result of function
			for (variable v : e2->variables)
			{
				if (v.type == 7)
				{
					returnVariable = v;
					//printf(" returnVar sk: %f")
					break;
				}
			}
			printf(" name: %s, type: %d ", returnVariable.name, returnVariable.type);
			for (int i = 0; i < e->variables.size(); i++)
			{
				if (strcmp(varName, e->variables.at(i).name) == 0)
				{					
					if (returnVariable.numVal != 0)
					{
						e->variables.at(i).numVal = returnVariable.numVal;
						printf(" =-%f-= ", e->variables.at(i).numVal);
					}
					else
					{
						e->variables.at(i).strVal = returnVariable.strVal;
						printf(" =-%s-= ", e->variables.at(i).strVal);
					}
					freeEnv(e2);
				}
			}
		}
	}
}

//Method that executes given AST
void execAst(struct ExecEnviron* e, struct AstElement* a)
{
	runnableExecs(e, a);
}

struct ExecEnviron* createEnv()
{
	//assert(ekLastElement == (sizeof(valExecs) / sizeof(*valExecs)));
	//assert(ekLastElement == (sizeof(runExecs) / sizeof(*runExecs)));
	ExecEnviron* execEnviron = new ExecEnviron();
	return execEnviron;
}

void freeEnv(struct ExecEnviron* e)
{
	free(e);
}