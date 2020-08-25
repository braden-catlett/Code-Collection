#ifndef CARDINAL_H
#define CARDINAL_H
#include "main.h"
#include "megaClass.h"

class cardinal : public omniclass
{
public:
	cardinal(){type = 3;}
	cardinal(int h, int sp, int hp, int fb, int ty, int fi, string n)
	{health = h; spCharge = sp; hPot = hp; fbomb =fb; type = ty; fire=fi; name = string(n);}

	void special(omniclass *p2);
	void regular(omniclass *p2);
	void menu(omniclass *p2);
};

void cardinal::menu(omniclass *p2)
{
	if(fire > 0)
		burn(p2);
	int act = 0;
	if(spCharge != 2)
	{
		cout<<"Choose an action "<<endl
			<<"1. Attack"<<endl
			<<"2. Divine Plea"<<endl
			<<"3. Equipment"<<endl
			<<" > ";
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
		cout<<"Choose an action "<<endl
			<<"1. Attack"<<endl
			<<"2. Equipment"<<endl
			<<" > ";
		cin>>act;
		if(act == 1)
			regular(p2);
		else if(act == 2)
			equipment(p2);
	}
}

void cardinal::special(omniclass *p2)
{
	cout<<"Bleeding from every orifice... You pray to God for his grace and are healed\n"<<endl;
	restoreHealth(25);
	spCharge++;	
}


void cardinal::regular(omniclass *p2)
{
	int chance = roll(100,1);
	if(getHealth() < 50 && chance < 20)
	{
		int dam = (25 + roll(6,4));
		cout << "Failing hard, you find extra strength and smite your enemy for " << dam << "!" << endl;
		(*p2).reduceHealth(dam);
	}
	else
	{				
		int dam = roll(4,6);
		cout << "You strike your opponent for " << dam << " damage." << endl;
		(*p2).reduceHealth(dam);
	}
}

#endif /* CARDINAL_H */