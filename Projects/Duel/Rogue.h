#ifndef ROGUE_H
#define ROGUE_H
#include "main.h"
#include "megaClass.h"

class rogue : public omniclass
{
public:
	rogue(){type = 6;}
	rogue(int h, int sp, int hp, int fb, int ty, int fi, string n)
	{health = h; spCharge = sp; hPot = hp; fbomb =fb; type = ty; fire=fi; name = string(n);}

	void special(omniclass *p2);
	void regular(omniclass *p2);
	void menu(omniclass *p2);
};

void rogue::menu(omniclass *p2)
{
	if(fire > 0)
		burn(p2);
	int act = 0;
	if(spCharge != 2)
	{
		cout << "Choose an action" << endl
			<< "1. Attack" << endl
			<< "2. Back Stab" << endl
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
			<< "1. Regular Attack" << endl
			<< "2. Equipment" << endl
			<< " > ";
		cin >> act;
		if(act == 1)
			regular(p2);
		else if(act == 2)
			equipment(p2);
	}
}

void rogue::special(omniclass *p2)
{	
	srand(time(NULL));
	cout << "Your opponent underestimates your sneakiness and loses sight of you\n"
		<< "giving you a change to sneak up behind them and try to land a fatal blow." << endl;

	int hit = roll(100,1);
	if(hit > 33)
	{
		int dam = roll(6,4);
		cout << "You wound your opponent for " << dam << " but not fatally...for now." << endl;
		(*p2).reduceHealth(dam);
		spCharge++;
	}
	else
	{
		//dam1 is 1-100 and dam2 is 1-50  Subtracting them you get 50-100 hopefully
		int dam1 = (26 + roll(4,6));
		cout << "You deliver a critical attack to your opponent causing " << dam1 << " damage!" << endl;
		(*p2).reduceHealth(dam1);
		spCharge++;
	}	
}


void rogue::regular(omniclass *p2)
{
	srand(time(NULL));
	int dam = roll(6,4);
	cout<<"You strike your opponent for "<<dam<<" damage\n"<<endl;
	(*p2).reduceHealth(dam);
}

#endif /* ROGUE_H */