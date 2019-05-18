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
		struct
		{
			const char* operation;
			float val;
		}expByNum;
		struct
		{
			const char* operation;
			char* val;
		}expByString;
		struct
		{
			const char* operation;
			char* name;
		}expByName;
        struct
        {
			const char* operation;
            struct AstElement *left, *right;
            char* op;
        }expression;
        struct
        {
			const char* operation;
            char* name;
            struct AstElement* right;
        }assignment;
		struct
		{
			const char* operation;
			char* data_type;
			char* name;
			struct AstElement* right;
		}declaration;
        struct
        {
			const char* operation;
            int count;
            struct AstElement** statements;
        }statements;
        struct
        {
			const char* operation;
            struct AstElement* cond;
            struct AstElement* statements;
        } whileStmt;
		struct
		{
			const char* operation;
			struct AstElement* cond;
			struct AstElement* statements;
		} forStmt;
		struct
		{
			const char* operation;
			struct AstElement* cond;
			struct AstElement* statements;
		}ifStmt;
		struct
		{
			const char* operation;
			struct AstElement* elseIfCond;
			struct AstElement* statements;
			struct AstElement* firstIf;
		}elifStmt;
		struct
		{
			const char* operation;
			struct AstElement* firstIf;
			struct AstElement* elseStatements;
		}elseStmt;
		struct
		{
			const char* operation;
			struct AstElement *left, *right;
			char* binaryOperator;
		}booleanOperation;
		struct
		{
			const char* operation;
			struct AstElement *left, *right;
		}andOrOperation;
		struct
		{
			const char* operation;
			char* data_type;
			char* name;
		}argument;
		struct
		{
			const char* operation;
			struct AstElement *left, *right;
		}argumentList;
		struct
		{
			const char* operation;
			char* data_type;
			char* name;
			struct AstElement *argumentsList;
			struct AstElement *statements;
		}functionDeclaration;
        struct
        {
			const char* operation;
            char* name;
            struct AstElement* parameters;
        }functionCall;
		struct
		{
			const char* operation;
			char* name;
		}functionCallWithoutParameters;
		struct
		{
			const char* operation;
			struct AstElement *expression;
		}returnStatement;
    } data;
};

struct AstElement* makeAssignment(char* name, struct AstElement* val);
struct AstElement* makeDeclaration(char* data_type, char* name, struct AstElement* val);
struct AstElement* makeExpByNum(float val);
struct AstElement* makeExpByString(char* val);
struct AstElement* makeExpByName(char* name);
struct AstElement* makeExpression(struct AstElement* left, struct AstElement* right, char* op);
struct AstElement* makeExpIncrease(char* name);
struct AstElement* makeExpDecrease(char* name);
struct AstElement* makeStatement(struct AstElement* dest, struct AstElement* toAppend);
struct AstElement* makeWhile(struct AstElement* cond, struct AstElement* exec);
struct AstElement* makeFor(struct AstElement* cond, struct AstElement* exec);
struct AstElement* makeIf(struct AstElement* cond, struct AstElement* exec);
struct AstElement* makeElif(struct AstElement* firstIf, struct AstElement* elseIfCond, struct AstElement* exec);
struct AstElement* makeElseIf(struct AstElement* firstIf, struct AstElement* elseStatements);
struct AstElement* makeBooleanOperation(struct AstElement* left, struct AstElement* right, char* boolOperator);
struct AstElement* makeAndOperation(struct AstElement* left, struct AstElement* right);
struct AstElement* makeOrOperation(struct AstElement* left, struct AstElement* right);
struct AstElement* makeArgument(char* data_type, char* name);
struct AstElement* makeArgumentList(struct AstElement* left, struct AstElement* right);
struct AstElement* makeFunctionDeclaration(char* data_type, char* name, struct AstElement* argumentsList, struct AstElement* statements);
struct AstElement* makeFunctionCall(char* name, struct AstElement* parameters);
struct AstElement* makeFunctionCallWithoutParameters(char* name);
struct AstElement* makeReturnStatement(struct AstElement* expression);
#endif