#ifndef ALCHEMIST_H
#define ALCHEMIST_H
#include "main.h"
#include "megaClass.h"

class alchemist : public omniclass
{
public:
	alchemist() {type = 1;}
	alchemist(int h, int sp, int hp, int fb, int ty, int fi, string n)
	{health = h; spCharge = sp; hPot = hp; fbomb =fb; type = ty; fire=fi; name = string(n);}
	void special(omniclass *p2);
	void regular(omniclass *p2);
	void menu(omniclass *p2);
};


void alchemist::menu(omniclass *p2)
{
	if(fire > 0)
		burn(p2);
	int act = 0;
	if(spCharge != 2)
	{
		cout << "Choose an action " << endl
			<< "1. Attack" << endl
			<< "2. Mix" << endl
			<< "3. Equipment" << endl
			<< " > ";
		cin >> act;
		if(act == 1)
			regular(p2);
		else if(act == 2)
			special(p2);
		else if(act == 3)
			equipment(p2);
	}
	else
	{
		cout << "Choose an action " << endl
			<< "1. Attack" << endl
			<< "2. Equipment" << endl
			<< " > ";
		cin>>act;
		if(act == 1)
			regular(p2);
		else if(act == 2)
			equipment(p2);
	}
}


void alchemist::regular(omniclass *p2)
{
	srand(time(NULL));
	int dam = roll(4,6);
	cout << "You strike your opponent for " << dam << " damage\n" << endl;
	(*p2).reduceHealth(dam);
}


void alchemist::special(omniclass *p2)
{
	srand(time(NULL));
	cout << "You mix together some of the ingredients you have with you..." << endl;
	int chance = (rand()%101);
	if(chance > 50)
	{
		int dam = (26 + roll(6,4));
		cout << "You mix something explosive." << endl
			<< "You throw it at your opponent for " << dam << " damage." << endl;
		(*p2).reduceHealth(dam);
	}
	else if(chance <= 50 && chance > 0)
	{
		int health = (16 + roll(6,4));
		cout << "You mix something restorative." << endl
			<< " You use it on yourself restoring " << health << " health." << endl;
		restoreHealth(health);
	}
	else if(chance == 0)
	{
		char ans;
		do
		{
			cout << "This looks potent. Do you want to use it? (yes/no) > ";
			cin.get(ans);
			cin.ignore(10000,'\n');
			ans = tolower(ans); // Convert first letter of string to single lower case char
			if(ans == 'n') // If no, forfeit turn
				cout << "You put it in your bag to analyze it later..." << endl;
			else if(ans == 'y')
			{
				cout << "You throw the whole bottle at your opponent." << endl;
				chance = roll(50,1);
				if(chance > 25)
				{
					cout << "An explosion like you've never seen before erupts engulfing the entire fight in firey death." << endl
						<< "You are both dead." << endl;
					(*p2).setHealth(0);
					setHealth(0);
				}
				else
				{
					cout << "An explosion of light bathes the field engulfs the field in holy radience." << endl
						<< "You are both restored to maximum health." << endl;
					(*p2).setHealth(100);
					setHealth(100);
				}
			}
			if(!(ans == 'n' || ans == 'y')) // If not 'n' or 'y', output error
				cout << "  Invalid answer..." << endl;
		}
		while(!(ans == 'n' || ans == 'y')); // If not 'n' or 'y', loop
	}

	spCharge++;
}

#endif /* ALCHEMIST_H */