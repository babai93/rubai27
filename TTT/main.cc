#include <iostream>
using namespace std;
char bord[3][3] = (( '1', '2', '3'), ('4', '5', '6',), ('7', '8', '9'));
void drawBoard()
(
    cout << " " << bord[0][0] "|" << bord[0][1] << " | " << bord[0][2] << endl;
    cout << "-----------\n";
    cout << " " << bord[1][0] "|" << bord[1][1] << " | " << bord[1][2] << endl;
    cout << "-----------\n";
    cout << " " << bord[2][0] "|" << bord[2][1] << " | " << bord[2][2] << endl;
)