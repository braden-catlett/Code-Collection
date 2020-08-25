#ifndef KNIGHT_H
#define KNIGHT_H
#include "main.h"
#include "megaClass.h"

class knight : public omniclass
{
public:
	knight(){type = 4;}
	knight(int h, int sp, int hp, int fb, int ty, int fi, string n)
	{health = h; spCharge = sp; hPot = hp; fbomb =fb; type = ty; fire=fi; name = string(n);}

	void special(omniclass *p2);
	void regular(omniclass *p2);
	void menu(omniclass *p2);
};

void knight::menu(omniclass *p2)
{
	if(fire > 0)
		burn(p2);
	int act = 0;
	if(spCharge != 2)
	{
		cout<<"Choose an action "<<endl
			<<"1. Attack"<<endl
			<<"2. Crusade"<<endl
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

void knight::regular(omniclass *p2)
{
	srand(time(NULL));
	int dam = roll(8,4);
	cout<<"You strike your opponent for "<<dam<<" damage\n"<<endl;
	(*p2).reduceHealth(dam);
}

void knight::special(omniclass *p2)
{
	int hit = roll(100,1);
	cout<<"You are enraged from battle and swing with all your might\n"<<endl;				
	if(hit > 50)
	{				
		int dam = (25 + roll(6,4));
		cout<<"You manage to strike your opponent with a crushing force dealing "<<dam<<" damage to them"<<endl;				
		(*p2).reduceHealth(dam);
		spCharge++;
	}
	if(hit <= 50)
	{
		cout<<"Your opponent manages to dodge your mighty blow... Possibly saving their life"<<endl;
		spCharge++;
	}	
}

#endif /* KNIGHT_H */