#ifndef ARCHER_H
#define ARCHER_H
#include "main.h"
#include "megaClass.h"

class archer : public omniclass
{	
public:
	archer() {type = 2;}
	archer(int h, int sp, int hp, int fb, int ty, int fi, string n)
	{health = h; spCharge = sp; hPot = hp; fbomb =fb; type = ty; fire=fi; name = string(n);}

	void special(omniclass *p2);
	void regular(omniclass *p2);
	void menu(omniclass *p2);
};

void archer::menu(omniclass *p2)
{
	if(fire > 0)
		burn(p2);
	int act = 0;
	if(spCharge != 2)
	{
		cout<<"Choose an action "<<endl
			<<"1. Single Shot"<<endl
			<<"2. Rapid Fire"<<endl
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
			<<"1. Single Shot"<<endl
			<<"2. Equipment"<<endl
			<<" > ";
		cin>>act;
		if(act == 1)
			regular(p2);
		else if(act == 2)
			equipment(p2);
	}
}

void archer::special(omniclass *p2)
{
	cout<<"Rapid Fire!"<<endl;
	for(int count = 1; count <= 3; count++)
	{
		Sleep(250);				
		int hit = roll(100,1);				
		if(hit >= 50)
		{
			int dam = (2 + roll(6,2));
			cout<<"You hit your opponent for "<<dam<<" damage\n"<<endl;
			(*p2).reduceHealth(dam);
		}
		if(hit < 50)
		{
			cout<<"You miss your opponent\n"<<endl;
		}
	}
	spCharge++;
}		

void archer::regular(omniclass *p2)
{
	int dam = (roll(4,6));
	cout<<"You shoot a regular arrow and it hits your opponent for "<<dam<<" damage\n"<<endl;
	(*p2).reduceHealth(dam);
}

#endif /* ARCHER_H */