#ifndef MAGE_H
#define MAGE_H
#include "main.h"
#include "megaClass.h"

class mage : public omniclass
{
public:
	mage() {type = 5;}
	mage(int h, int sp, int hp, int fb, int ty, int fi, string n)
	{health = h; spCharge = sp; hPot = hp; fbomb =fb; type = ty; fire=fi; name = string(n);}

	void special(omniclass *p2);
	void regular(omniclass *p2);
	void menu(omniclass *p2);
};

void mage::menu(omniclass *p2)
{
	if(fire > 0)
		burn(p2);
	int act = 0;
	if(spCharge != 2)
	{
		cout << "Choose an action " << endl
			<< "1. Magic Missile" << endl
			<< "2. Fireball" << endl
			<< "3. Equipment" << endl
			<< " > ";
		cin>>act;
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
			<< "1. Magic Missile" << endl
			<< "2. Equipment" << endl
			<< " > ";
		cin>>act;
		if(act == 1)
			regular(p2);
		else if(act == 2)
			equipment(p2);
	}
}

void mage::special(omniclass *p2)
{
	srand(time(NULL));
	int dam = (20 + roll(4,8));
	cout << "You blast your opponent with an instant ball of fire dealing " << dam << " damage" << endl;
	(*p2).reduceHealth(dam);
	spCharge++;
}



void mage::regular(omniclass *p2)
{
	int dam = roll(4,5);
	cout << "You cast magic shot dealing " << dam << " damage to your opponent" << endl;
	(*p2).reduceHealth(dam);
}

#endif /* MAGE_H */