/* A Bison parser, made by GNU Bison 3.0.4.  */

/* Bison interface for Yacc-like parsers in C

   Copyright (C) 1984, 1989-1990, 2000-2013 Free Software Foundation, Inc.

   This program is free software: you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation, either version 3 of the License, or
   (at your option) any later version.

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   You should have received a copy of the GNU General Public License
   along with this program.  If not, see <http://www.gnu.org/licenses/>.  */

/* As a special exception, you may create a larger work that contains
   part or all of the Bison parser skeleton and distribute that work
   under terms of your choice, so long as that work isn't itself a
   parser generator using the skeleton or a modified version thereof
   as a parser skeleton.  Alternatively, if you modify or redistribute
   the parser skeleton itself, you may (at your option) remove this
   special exception, which will cause the skeleton and the resulting
   Bison output files to be licensed under the GNU General Public
   License without this special exception.

   This special exception was added by the Free Software Foundation in
   version 2.2 of Bison.  */

#ifndef YY_YY_PARSER_H_INCLUDED
# define YY_YY_PARSER_H_INCLUDED
/* Debug traces.  */
#ifndef YYDEBUG
# define YYDEBUG 0
#endif
#if YYDEBUG
extern int yydebug;
#endif

/* Token type.  */
#ifndef YYTOKENTYPE
# define YYTOKENTYPE
  enum yytokentype
  {
    DATA_TYPE = 258,
    IDENTIFIER = 259,
    STRING_VALUE = 260,
    NUMBER_VALUE = 261,
    RETURN = 262,
    IF = 263,
    ELIF = 264,
    ELSE = 265,
    FOR = 266,
    WHILE = 267,
    MORE_OP = 268,
    LESS_OP = 269,
    EQUAL_OP = 270,
    MORE_OR_EQUAL_OP = 271,
    LESS_OR_EQUAL_OP = 272,
    OR_OP = 273,
    AND_OP = 274,
    ADD_OP = 275,
    SUB_OP = 276,
    MUL_OP = 277,
    DIV_OP = 278,
    MOD_OP = 279,
    ADD_ASSIGN_OP = 280,
    SUB_ASSIGN_OP = 281,
    INC_OP = 282,
    DEC_OP = 283,
    ASSIGN_OP = 284
  };
#endif

/* Value type.  */
#if ! defined YYSTYPE && ! defined YYSTYPE_IS_DECLARED
typedef union YYSTYPE YYSTYPE;
union YYSTYPE
{
#line 22 "parser.y" /* yacc.c:1909  */

	char* type;
	char* identifier;
	char* op;
	char* string;
	float number;
	struct AstElement* ast;

#line 93 "parser.h" /* yacc.c:1909  */
};
# define YYSTYPE_IS_TRIVIAL 1
# define YYSTYPE_IS_DECLARED 1
#endif


extern YYSTYPE yylval;

int yyparse (void *astDest);

#endif /* !YY_YY_PARSER_H_INCLUDED  */
