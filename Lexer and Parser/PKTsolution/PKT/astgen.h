#ifndef ASTGEN_H
#define ASTGEN_H

struct AstElement
{
    enum kind {ekId, ekDeclaration, ekNumber, ekString, ekBinExpression,
		ekAssignment, ekIncrease, ekDecrease, ekWhile, ekCall,
		ekStatements, ekLastElement, ekIf, ekElif, ekElseIf,
		ekBooleanOperation, ekAndOperation, ekOrOperation, ekFor};

	AstElement(){

	}

    union
    {
        float val;
		char* charVal;
        char* name;
        struct
        {
            struct AstElement *left, *right;
            char* op;
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
			struct AstElement *left, *right;
			char* binaryOperator;
		}booleanOperation;
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
			struct AstElement *left, *right;
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
			char* name;
		}functionCallWithoutParameters;
		struct
		{
			struct AstElement *expression;
		}returnStatement;
    } data;
};

struct AstElement* makeAssignment(char* name, struct AstElement* val);
struct AstElement* makeDeclaration(char* data_type, char* name, struct AstElement* val);
struct AstElement* makeExpByNum(float val);
struct AstElement* makeExpByString(char* val);
struct AstElement* makeExpByName(char* name);
struct AstElement* makeExp(struct AstElement* left, struct AstElement* right, char* op);
struct AstElement* makeExpIncrease(char* name);
struct AstElement* makeExpDecrease(char* name);
struct AstElement* makeStatement(struct AstElement* dest, struct AstElement* toAppend);
struct AstElement* makeWhile(struct AstElement* cond, struct AstElement* exec);
struct AstElement* makeFor(struct AstElement* cond, struct AstElement* exec);
struct AstElement* makeIf(struct AstElement* cond, struct AstElement* exec);
struct AstElement* makeElif(struct AstElement* firstIf, struct AstElement* elseIfCond, struct AstElement* exec);
struct AstElement* makeElseIf(struct AstElement* firstIf, struct AstElement* elseStatements);
struct AstElement* makeBooleanOperation(struct AstElement* left, struct AstElement* right, char* binaryOperator);
struct AstElement* makeAndOperation(struct AstElement* left, struct AstElement* right);
struct AstElement* makeOrOperation(struct AstElement* left, struct AstElement* right);
struct AstElement* makeArgument(char* data_type, char* name);
struct AstElement* makeArgumentList(struct AstElement* left, struct AstElement* right);
struct AstElement* makeFunctionDeclaration(char* data_type, char* name, struct AstElement* argumentsList, struct AstElement* statements);
struct AstElement* makeFunctionCall(char* name, struct AstElement* parameters);
struct AstElement* makeFunctionCallWithoutParameters(char* name);
struct AstElement* makeReturnStatement(struct AstElement* expression);
#endif