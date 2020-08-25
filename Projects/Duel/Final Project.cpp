////
// Brad Catlett-Rossen
// Peter Northcott
//11/09/09
//Final Project
// CS171
////
#include "main.h"
#include "megaClass.h"
#include "Alchemist.h"
#include "Archer.h"
#include "Mage.h"
#include "Knight.h"
#include "Cardinal.h"
#include "Rogue.h"
#include <iostream>

void classDetails();
void saveGame(omniclass *p1, omniclass *p2);
omniclass* loadGame1();
omniclass* loadGame2();
void logo();
bool mainMenu(omniclass* p1, omniclass* p2);
void classCreation(omniclass* p1, omniclass* p2);
void game(omniclass* p1, omniclass* p2);

int main()
{
	HANDLE textColor;
	textColor = GetStdHandle(STD_OUTPUT_HANDLE);
	//pointers
	omniclass *p1 = NULL;
	omniclass *p2 = NULL;

	logo();
	while(mainMenu(p1,p2));
	
	cout << "Thanks for playing!" << endl;
	system("pause");
	return 0;
}

void saveGame(omniclass *p1, omniclass *p2)
{
	ofstream save;

	save.open("p1.txt");
	//Player One
	save << (*p1).getHealth() << " " << (*p1).getSP() << " " << (*p1).gethPot() << " "
		<< (*p1).getfBomb() << " " << (*p1).getType() << " " << (*p1).getFire() << " "
		<< (*p1).getName() << endl;
	save.close();

	//Player two
	save.open("p2.txt");
	save << (*p2).getHealth() << " " << (*p2).getSP() << " " << (*p2).gethPot() << " " 
		<< (*p2).getfBomb() << " " << (*p2).getType() << " " << (*p2).getFire() << " "
		<< (*p2).getName() <<endl;		
	save.close();
	cout << "\n  Game Saved" << endl;
}

omniclass* loadGame1()
{
	//holding pointers
	omniclass *p1 = NULL;
	string name;
	int character1;
	ifstream save("p1.txt");
	if(save.fail())
	{
		cout << "Player One: Not Found" << endl;
		return p1;
	} 
	if(save.eof()){
			cout << "Player One: Not Found" << endl;
			cout << "\tPlayer 1\n Please enter in a name > ";
			getline(cin,name);
			do
			{
				cout << endl << "    " << name << ", Please Choose a Class" << endl
				<< "1. Alchemist" << endl
				<< "2. Archer" << endl
				<< "3. Cleric" << endl
				<< "4. Knight" << endl
				<< "5. Mage" << endl
				<< "6. Rogue" << endl << endl
				<< "(Enter 0 for detail descriptions)" << endl
				<< " Enter Number of Choice > ";
			cin >> character1;
			if(character1 == 0)
			{
				system("cls");
				classDetails();
			}
			else if(character1 > 6 || character1 < 0) // If not 0 through 6
			{
				system("cls");
				cout << "  Invalid selection..." << endl; // output error
			}
		}
		while(character1 > 6 || character1 < 1); // If not 1 through 6, loop

		//Dynamically create the object under the player one pointer
		switch(character1)
		{
		case 1:
			p1 = new alchemist;
			break;
		case 2:
			p1 = new archer;
			break;
		case 3:
			p1 = new cardinal;
			break;
		case 4:
			p1 = new knight;
			break;
		case 5:
			p1 = new mage;
			break;
		case 6:
			p1 = new rogue;
			break;
		}
		// Set player 1's name in object
		(*p1).setName(name);

		// Clear variables for Player 2
		name.clear();
		cin.ignore(1000,'\n');
		system("cls");
		return p1;
	}
	else {
	//Player one and two holding variables
	int health1, sp1, pot1, bomb1, type1, fire1;
	string name1;
	//Loading
	save >> health1 >> sp1 >> pot1 >> bomb1 >> type1 >> fire1;
	getline(save,name1);
	//Player One
	switch(type1)
	{
	case 1:
		p1 = new alchemist(health1, sp1, pot1, bomb1, type1, fire1, name1);
		break;
	case 2:
		p1 = new archer(health1, sp1, pot1, bomb1, type1, fire1, name1);
		break;
	case 3:
		p1 = new mage(health1, sp1, pot1, bomb1, type1, fire1, name1);
		break;
	case 4:
		p1 = new knight(health1, sp1, pot1, bomb1, type1, fire1, name1);
		break;
	case 5:
		p1 = new cardinal(health1, sp1, pot1, bomb1, type1, fire1, name1);
		break;
	case 6:
		p1 = new rogue(health1, sp1, pot1, bomb1, type1, fire1, name1);
		break;
	}
	save.close();
	cout << (*p1).getName() << " Loaded Correctly." << endl;
	return p1;
}
omniclass* loadGame2()
{
	//holding pointers 
	omniclass *p2 = NULL;
	string name;
	int character1;
	ifstream save("p2.txt");
	if(save.fail())
	{
		cout << "Player Two: Not Found" << endl;
		return p2;
	}
	if(save.eof()){
			cout << "Player Two: Not Found" << endl;
			cout << "\tPlayer 2\n Please enter in a name > ";
			getline(cin,name);
			do
			{
				cout << endl << "    " << name << ", Please Choose a Class" << endl
				<< "1. Alchemist" << endl
				<< "2. Archer" << endl
				<< "3. Cleric" << endl
				<< "4. Knight" << endl
				<< "5. Mage" << endl
				<< "6. Rogue" << endl << endl
				<< "(Enter 0 for detail descriptions)" << endl
				<< " Enter Number of Choice > ";
			cin >> character1;
			if(character1 == 0)
			{
				system("cls");
				classDetails();
			}
			else if(character1 > 6 || character1 < 0) // If not 0 through 6
			{
				system("cls");
				cout << "  Invalid selection..." << endl; // output error
			}
		}
		while(character1 > 6 || character1 < 1); // If not 1 through 6, loop

		//Dynamically create the object under the player one pointer
		switch(character1)
		{
		case 1:
			p2 = new alchemist;
			break;
		case 2:
			p2 = new archer;
			break;
		case 3:
			p2 = new cardinal;
			break;
		case 4:
			p2 = new knight;
			break;
		case 5:
			p2 = new mage;
			break;
		case 6:
			p2 = new rogue;
			break;
		}
		// Set player 1's name in object
		(*p2).setName(name);

		// Clear variables for Player 2
		name.clear();
		cin.ignore(1000,'\n');
		system("cls");
		return p2;
	}
	else {
		//Player one and two holding variables
		int  health2, sp2, pot2, bomb2, type2, fire2;
		string name2;
		//Loading
		save >> health2 >> sp2 >> pot2 >> bomb2 >> type2 >> fire2;
		getline(save,name2);
		switch(type2)
		{
		case 1:
			p2 = new alchemist(health2, sp2, pot2, bomb2, type2, fire2, name2);
			break;
		case 2:
			p2 = new archer(health2, sp2, pot2, bomb2, type2, fire2, name2);
			break;
		case 3:
			p2 = new mage(health2, sp2, pot2, bomb2, type2, fire2, name2);
			break;
		case 4:
			p2 = new knight(health2, sp2, pot2, bomb2, type2, fire2, name2);
			break;
		case 5:
			p2 = new cardinal(health2, sp2, pot2, bomb2, type2, fire2, name2);
			break;
		case 6:
			p2 = new rogue(health2, sp2, pot2, bomb2, type2, fire2, name2);
			break;
		}
	save.close();
	cout << (*p2).getName() << " Loaded Correctly." << endl;
	return p2;
		}
}

int roll(int diceSize, int times)
{
	srand(time(NULL));
	int sum = 0;
	for(times;times > 0;times--)
		sum += (1 + rand() % diceSize);
	return sum;
}

void classDetails()
{
	cout << "\tAlchemist"
		<< "\nAttack - Attack with club"
		<< "\nMix - Mix a random concoction. You never know what you might get..."
		<< endl;
	Sleep(500);
	cout << "\n\tArcher"
		<< "\nSingle Shot - Shoot an arrow at your opponent"
		<< "\nRapid Shot - Quickly shoot off 3 arrows, each shot has a chance to miss"
		<< endl;
	Sleep(500);
	cout << "\n\tCleric"
		<< "\nAttack - Attack with a mace"
		<< "\nDivine Plea - Recover 40 health"
		<< endl;
	Sleep(500);
	cout << "\n\tKnight"
		<< "\nAttack - Attack with a great sword"
		<< "\nCrusade - 33% change to hit for epic damage"
		<< endl;
	Sleep(500);
	cout << "\n\tMage"
		<< "\nMagic Missile - Shoot the mage's standard spell to attack the darkness"
		<< "\nFireball - Blasts your opponent for massive damage"
		<< endl;
	Sleep(500);
	cout << "\n\tRogue"
		<< "\nAttack - Attack with daggers"
		<< "\nBack Stab - Disappears, sneaks up, and attempts a critcal strike"
		<< endl << endl;
	system("pause");
	system("cls");
}

void logo()
{
	cout << setw(30) << "**   *  * **** *" << endl;
	cout << setw(30) << "* *  *  * *    *" << endl;
	cout << setw(30) << "*  * *  * ***  *" << endl;
	cout << setw(30) << "* *  *  * *    *" << endl;
	cout << setw(33) << "**   **** **** ****" << endl;
	cout << endl;
}

bool mainMenu(omniclass* p1, omniclass* p2)
{
	int choice;
	cout << "1. New Game" << endl
		<< "2. Load Game" << endl
		<< "3. Quit" << endl
		<< "Enter Option > ";
	cin >> choice;

	switch(choice)
	{
	case 1:
		classCreation(p1,p2);
		break;
	case 2:
		p1 = loadGame1();
		p2 = loadGame2();
		system("pause");
		if(p1 == NULL && p2 == NULL)
		{
			system("cls");
			logo();
			mainMenu(p1,p2);
			break;
		}
		game(p1,p2);
		break;
	case 3:
		return 0;
	default:
		system("cls");
		logo();
		cout << "Invalid selection..." << endl;
		break;
	}
	return 1;
}

void classCreation(omniclass* p1,omniclass* p2)
{
	string name;
	int character1, character2;

	/**************************/
	/**** Player Creation *****/
	/**************************/
	// Player 1 name
	cin.ignore(1000,'\n');
	system("cls");
	cout << "\tPlayer 1\n Please enter in a name > ";
	getline(cin,name);

	// Player 1 class selection
	do
	{
		cout << endl << "    " << name << ", Please Choose a Class" << endl
			<< "1. Alchemist" << endl
			<< "2. Archer" << endl
			<< "3. Cleric" << endl
			<< "4. Knight" << endl
			<< "5. Mage" << endl
			<< "6. Rogue" << endl << endl
			<< "(Enter 0 for detail descriptions)" << endl
			<< " Enter Number of Choice > ";
		cin >> character1;
		if(character1 == 0)
		{
			system("cls");
			classDetails();
		}
		else if(character1 > 6 || character1 < 0) // If not 0 through 6
		{
			system("cls");
			cout << "  Invalid selection..." << endl; // output error
		}
	}
	while(character1 > 6 || character1 < 1); // If not 1 through 6, loop

	//Dynamically create the object under the player one pointer
	switch(character1)
	{
	case 1:
		p1 = new alchemist;
		break;
	case 2:
		p1 = new archer;
		break;
	case 3:
		p1 = new cardinal;
		break;
	case 4:
		p1 = new knight;
		break;
	case 5:
		p1 = new mage;
		break;
	case 6:
		p1 = new rogue;
		break;
	}

	// Set player 1's name in object
	(*p1).setName(name);

	// Clear variables for Player 2
	name.clear();
	cin.ignore(1000,'\n');
	system("cls");

	// Player 2 name
	cout << "\tPlayer 2\n Please enter in a name > ";
	getline(cin,name);

	// Player 2 class selection
	do
	{
		cout << endl << "    " << name << ", Please Choose a Class" << endl
			<< "1. Alchemist" << endl
			<< "2. Archer" << endl
			<< "3. Cleric" << endl
			<< "4. Knight" << endl
			<< "5. Mage" << endl
			<< "6. Rogue" << endl << endl
			<< "(Enter 0 for detail descriptions)" << endl
			<< " Enter Number of Choice > ";
		cin >> character2;
		if(character2 == 0)
		{
			system("cls");
			classDetails();
		}
		else if(character2 > 6 || character2 < 0) // If not 0 through 6
		{
			system("cls");
			cout << "  Invalid selection..." << endl; // output error
		}
	}
	while(character2 > 6 || character2 < 1); // If not 1 through 6, loop

	//Dynamically create the object under the player two pointer
	switch(character2)
	{
	case 1:
		p2 = new alchemist;
		break;
	case 2:
		p2 = new archer;
		break;
	case 3:
		p2 = new cardinal;
		break;
	case 4:
		p2 = new knight;
		break;
	case 5:
		p2 = new mage;
		break;
	case 6:
		p2 = new rogue;
		break;
	}

	// Set player 2's name in object
	(*p2).setName(name);
	name.clear();
	cin.clear();
	cin.ignore();
	//Screen Clear
	game(p1,p2);
}

void game(omniclass* p1, omniclass* p2)
{
	/**************************/
	/***** Combat Section *****/
	/**************************/

	system("cls");
	//Counter for turns and battles
	while(1)
	{
		//Display Both Player's Health
		cout << "************************" << endl
			<< (*p1).getName() << "'s Health: " << (*p1).getHealth() << endl
			<< (*p2).getName() << "'s Health: " << (*p2).getHealth() << endl
			<< "************************" << endl;

		//Player One
		cout << setw(15) << (*p1).getName() << "'s Turn " << endl;
		(*p1).menu(p2);
		//Check to see if one player has won
		if((*p1).checkWin(p2) && (*p2).checkWin(p1))
		{
			cout << endl << "No one has won." << endl << endl;
			system("pause");
			system("cls");
			logo();
			break;
		}
		else if((*p1).checkWin(p2))
		{
			cout << endl << (*p1).getName() << " has won!" << endl << endl;
			system("pause");
			system("cls");
			logo();
			break;
		}

		//Display Both Player's Health
		system("pause");
		system("cls");
		cout << "************************" << endl
			<< (*p1).getName() << "'s Health: " << (*p1).getHealth() << endl
			<< (*p2).getName() << "'s Health: " << (*p2).getHealth() << endl
			<< "************************" << endl;

		//Player Two
		cout << setw(15) << (*p2).getName() << "'s Turn " << endl;
		(*p2).menu(p1);

		//Check to see if two player has won
		if((*p1).checkWin(p2) && (*p2).checkWin(p1))
		{
			cout << endl << "No one has won." << endl << endl;
			system("pause");
			system("cls");
			logo();
			break;
		}
		else if((*p2).checkWin(p1))
		{
			cout << endl << (*p2).getName() << " has won!" << endl << endl;
			system("pause");
			system("cls");
			logo();
			break;
		}
		saveGame(p1,p2);
		system("pause");
		system("cls");
	}
	delete p1, p2; // Deletes the pointers to prevent a memory leak
}