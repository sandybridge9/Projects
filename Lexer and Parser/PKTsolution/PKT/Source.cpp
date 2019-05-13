#include <iostream>

#include "parser.h"

using namespace std;

// this function is called syntax parser
// just the parser, the parse
extern int yyparse();

extern void set_input_file(const char* filename);
extern void set_output_file(const char* filename);
extern void close_output_file();
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
	int rlt = yyparse();

	if (argc == 3)
		close_output_file();

	return 0;
}

// we have to code this function
void yyerror(const char* msg)
{
	cout << "Error: " << msg << endl;

}