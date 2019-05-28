#ifndef ASTGEN_H
#define ASTGEN_H

struct AstElement
{
	AstElement(){

	}
	bool flag = false; //this will be set to true the first time we call makeStatements() function
	bool flag2 = false; //flag for argument list
	int operation;
    union
    {
		struct
		{
			float val;
		}expByNum;
		struct
		{
			char* val;
		}expByString;
		struct
		{
			char* name;
		}expByName;
        struct
        {
            struct AstElement *left, *right;
            char op;
        }expression;
        struct
        {
            char* name;
            struct AstElement* right;
        }assignment;
		struct
		{
			char* data_type;
			char* name;
			struct AstElement* right;
		}declaration;
        struct
        {
            int count;
            struct AstElement** statements;
        }statements;
        struct
        {
            struct AstElement* cond;
            struct AstElement* statements;
        } whileStmt;
		struct
		{
			struct AstElement* cond;
			struct AstElement* statements;
		} forStmt;
		struct
		{
			struct AstElement* cond;
			struct AstElement* statements;
		}ifStmt;
		struct
		{
			struct AstElement* elseIfCond;
			struct AstElement* statements;
			struct AstElement* firstIf;
		}elifStmt;
		struct
		{
			struct AstElement* firstIf;
			struct AstElement* elseStatements;
		}elseStmt;
		struct
		{
			char* left;
			struct AstElement *right;
			char booleanOperator;
		}booleanOperation;
		struct
		{
			char* left;
			struct AstElement *right;
		}eqMeLeOperations;
		struct
		{
			struct AstElement *left, *right;
		}andOrOperation;
		struct
		{
			char* data_type;
			char* name;
		}argument;
		struct
		{
			char* name;
		}callArgument;
		struct
		{
			char* strVal;
		}callArgument2;
		struct
		{
			float numVal;
		}callArgument3;
		struct
		{
			int count;
			struct AstElement** arguments;
		}argumentList;
		struct
		{
			char* data_type;
			char* name;
			struct AstElement *argumentsList;
			struct AstElement *statements;
		}functionDeclaration;
        struct
        {
            char* name;
            struct AstElement* parameters;
        }functionCall;
		struct
		{
			char* varName; //variable to assign to
			char* funcName;
			struct AstElement* parameters;
		}assignFunctionValue; //return statement
		struct
		{
			struct AstElement* expression;
		}returnStatement;
		struct
		{
			char* name;
		}functionCallWithoutParameters;
    } data;
};

struct AstElement* makeAssignment(char* name, struct AstElement* val);
struct AstElement* makeDeclaration(char* data_type, char* name, struct AstElement* val);
struct AstElement* makeExpByNum(float val);
struct AstElement* makeExpByString(char* val);
struct AstElement* makeExpByName(char* name);
struct AstElement* makeExpression(struct AstElement* left, struct AstElement* right, char op);
struct AstElement* makeExpIncrease(char* name);
struct AstElement* makeExpDecrease(char* name);
struct AstElement* makeStatement(struct AstElement* dest, struct AstElement* toAppend);
struct AstElement* makeWhile(struct AstElement* cond, struct AstElement* exec);
struct AstElement* makeFor(struct AstElement* cond, struct AstElement* exec);
struct AstElement* makeIf(struct AstElement* cond, struct AstElement* exec);
struct AstElement* makeElif(struct AstElement* firstIf, struct AstElement* elseIfCond, struct AstElement* exec);
struct AstElement* makeElseIf(struct AstElement* firstIf, struct AstElement* elseStatements);
struct AstElement* makeBooleanOperation(char* left, struct AstElement* right, char boolOperator);
struct AstElement* makeEqualsOperation(char* left, struct AstElement* right);
struct AstElement* makeMoreOrEqualOperation(char* left, struct AstElement* right);
struct AstElement* makeLessOrEqualOperation(char* left, struct AstElement* right);
struct AstElement* makeAndOperation(struct AstElement* left, struct AstElement* right);
struct AstElement* makeOrOperation(struct AstElement* left, struct AstElement* right);
struct AstElement* makeArgument(char* data_type, char* name);
struct AstElement* makeCallArgument(char* name);
struct AstElement* makeCallArgument2(char* strVal);
struct AstElement* makeCallArgument3(float numVal);
struct AstElement* makeArgumentList(struct AstElement* left, struct AstElement* right);
struct AstElement* makeFunctionDeclaration(char* data_type, char* name, struct AstElement* argumentsList, struct AstElement* statements);
struct AstElement* makeFunctionCall(char* name, struct AstElement* parameters);
struct AstElement* makeFunctionCallWithoutParameters(char* name);
struct AstElement* makeAssignFunctionValue(char* varName, char* funcName, struct AstElement* parameters);
struct AstElement* makeReturnStatement(struct AstElement* expression);
#endif