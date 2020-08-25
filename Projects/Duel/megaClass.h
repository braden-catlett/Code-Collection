#ifndef OMNICLASS_H
#define OMNICLASS_H
#include <string>
#include "main.h"
using namespace std;

class omniclass
{
protected:
	int health, spCharge, hPot, fbomb, fire, type;
	string name;

public:
	//constructors
	omniclass()	{health = 100; spCharge = 0; name = "Bob"; hPot = 3; fbomb = 1; fire = 0;}

	int getHealth();
	void setHealth(int w);
	void reduceHealth(int n);
	void restoreHealth(int n);
	void setName(string title);
	string getName(); 
	bool checkWin(omniclass *p2);
	int getSP();
	virtual void menu(omniclass *p2) = 0;
	void equipment(omniclass *p2);
	int getType();
	int getfBomb();	
	int gethPot();
	int getFire();
	void burn(omniclass *p2);
};

int omniclass::getHealth()
{
	return health;
}
void omniclass::setHealth(int w)
{
	health = w;
}

void omniclass::reduceHealth(int n)
{
	health -= n;
}

void omniclass::restoreHealth(int n)
{
	health += n;
}

void omniclass::setName(string title)
{
	name = title;
}

string omniclass::getName()
{
	return name;
}

int omniclass::getSP()
{
	return spCharge;
}

int omniclass::getfBomb()
{
	return fbomb;
}

int omniclass::gethPot()
{
	return hPot;
}

bool omniclass::checkWin(omniclass *p2)
{
	if((*p2).getHealth() < 1)
		return 1;
	else
		return 0;
}

void omniclass::equipment(omniclass *p2)
{
	int cho;
	cout << "1. Health Potion [Qty " << hPot << "]" << endl
		<< "2. Fire Bomb [Qty " << fbomb << "]" << endl
		<< "3. Cancel" << endl
		<< " > ";
	cin>>cho;
	if(cho == 1 && hPot != 0)
		{
			cout << "MMMMM kinda has a skunky taste" << endl;
			restoreHealth(20);
			hPot--;
		}
	else if(cho == 1 && hPot == 0)
		cout << "Your out of pot...lol" << endl;
		
	else if(cho == 2 && fbomb != 0)
		{
			int dam = (10 + roll(3,5));
			cout << "Fire in the Hole for " << dam << " damage" << endl;
			(*p2).reduceHealth(dam);
			fbomb--;
			fire++;
		}
	else if(cho == 2 && fbomb == 0)
		cout << "No more fire in that hole" << endl;
	
	else if(cho == 3)
	{
		system("cls");
		menu(p2);
	}
}

int omniclass::getType()
{
	return type;
}

int omniclass::getFire()
{
	return fire;
}

void omniclass::burn(omniclass *p2)
{
	double dam = (6 + roll(4,2));
	switch(fire)
	{
	case 1:
		cout << (*p2).getName() <<" continues to burn, taking "<< dam <<" damage."<< endl;
		(*p2).reduceHealth(dam);
		fire++;
		break;
	case 2:
		dam *= 0.5;
		cout << (*p2).getName() <<" takes "<< dam <<" damage as the fire goes out."<< endl;
		(*p2).reduceHealth(dam);
		fire = 0;
		break;
	}
}

#endif /* OMNICLASS_H */