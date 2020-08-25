#include <string>
#include <iostream>
#include <random>
#include <vector>
#include "Player.h"
using namespace std;

class space { 
private:
	//Some type of x,y to let the player objects to draw on the space and houses
	bool owned;
	player* owned_by;
	player* morgaged;
	int cost;
	int morgage;
	std::string name;
	int house;
	bool hotel;
	int house_cost;
	int rent;
	//Special variables
	space* partner_one;
	space* partner_two;
	space* partner_three;

public:
	space(std::string na) : name(na), cost(0), owned(false), owned_by(NULL), morgaged(NULL) {}
	space(bool own, int price, int morg, std::string na, int housec, int rnt, space* one, space* two, space* three) 
		: owned(own), owned_by(NULL), morgaged(NULL), cost(price), morgage(morg), name(na), house(0), hotel(false), house_cost(housec),
		rent(rnt), partner_one(one), partner_two(two), partner_three(three){}

	virtual void effect (player* play) = 0;
	bool is_owned() {
		if(owned_by != NULL)
		return true;
		else
		return false;
	}
	void set_ownedby(player buyer) {
		owned_by = &buyer;
		owned = true;
	}
	player* get_ownedby() { return owned_by; }
	player* get_morgaged() { return morgaged; }
	int get_cost() { return cost; }
	int get_morgage() { return morgage; }
	std::string get_name() { return name; }
	int gethouse() { return house_cost; }
	void inc_house() {
		if(house < 5)
			house++; 
		else
			cout<<"You already have four houses"<<endl;
	}
	int get_rent() { 
		if(hotel) {
			if(house_cost == 50)
				return (rent * 100);
			else if(house_cost == 100)
				return (rent * 70);
			else if(house_cost == 150)
				return (rent * 50);
			else if(house_cost == 200)
				return (rent * 40);
		}
		if(house == 4)
			return (rent * 80);
		if(house == 3)
			return (rent * 45);
		if(house == 2)
			return (rent * 15);
		if(house == 1)
			return (rent * 5);
		if(this->haveset())
			return (rent * 2);
		else
			return rent; 
	}
	bool haveset() {
		if( partner_one->get_ownedby() == owned_by && partner_two->get_ownedby() == owned_by && partner_three->get_ownedby() == owned_by)
			return true;
		else 
			return false;
	}

};

//PROPERTY
class Property : public space {
public:
	Property(bool own, int price, int morg, std::string na, int housec, int rnt, space* one, space* two, space* three) 
		: space(own, price, morg, na, housec, rnt, one, two, three) {}
	void effect(player* play) {
		char ans;
		if(is_owned()) {
			cout << get_name() <<" is owned by " << play->getname() <<"\n You owe "  << get_rent()<<endl;
			play->cost(get_rent());
			get_ownedby()->gain(get_rent());
		}
		else {
			cout<< get_name() <<" isn't owned! " << "\n Would you like to purchase it? (Y/N)"<<endl;
			cin >> ans;
			if(ans == 'y' || ans == 'Y') {
				play->cost(get_cost());
				set_ownedby(*play);
				cout<<"Congradulations! You now own "<<get_name() <<endl<<endl;
			}
		}
		//if yes then charge the player that landed on the spot and give the amount to "Owned_by object"
		//if no then ask if the player wants to buy it
		//if yes then charge the player and add the space object to their owned vector
		// if no then move on with the show
	}

};

//LUXURY
class luxury : public space {
public:
	luxury() : space("Luxury Tax") {}
	void effect(player* play) {
		cout << "You have landed on Luxury Tax! You owe $75" << endl;
		play->cost(75);
	}
};

//INCOME
class income : public space {
public:
	income() : space("Income Tax") {}
		void effect(player* play) {
			int cho;
			cout<<"You landed on Income Tax"<<endl;
			cout<<"Which would you rather do? (1-2)" << "\n  #1: Pay the 15% income tax" << "\n  #2: $200 dollars"<<endl;
			while(true) {
			cin >> cho;
			if(cho != 1 && cho != 2)
				cout<<"Invalid answer: Please try again"<<endl;
			else
				break;
			}
			if(cho == 1)
				play->cost(play->get_funds() / 15);
			else
				play->cost(200);
			//Calculate 15% of their money and then give the user the option to pay that or 200
		}
};

//CHANCE
class chance : public space {
public:
	chance() : space("Chance") {}
	void effect(player* play) {
	unsigned int n = rand()%11;
	cout<<"You get to draw a card =O"<<endl;
		switch(n) { //fill this with random crap to happen to the player
		case 1:
			cout<<"You have won second prize in a beauty contest!\nCollect $10\n";
			play->gain(10);
			break;
		case 2:
			cout<<"Bank error in your favor\nCollect $200\n";
			play->gain(200);
			break;
		case 3:
			cout<<"Advance to GO!\n";
			play->setpos(37);
			break;
		case 4:
			cout<<"From sale of Stock\nYou Get $50\n";
			play->gain(50);
			break;
		case 5:
			cout<<"You inherit $100\n"<<endl;
			play->gain(100);
			break;
		case 6:
			cout<<"It is your birthday!\nCollect $40\n";
			play->gain(40);
			break;
		case 7:
			cout<<"Consultancy Fee\nCollect $25"<<endl;
			play->gain(25);
			break;
		case 8:
			cout<<"Go to Jail, you bad bad person"<<endl;
			play->setjail(true);
			break;
		case 9:
			cout<<"Pay Hospital fees of $100"<<endl;
			play->cost(100);
			break;
		case 10:
			cout<<"Income Tax refund\nCollect $20"<<endl;
			play->gain(20);
			break;
	}

	}
};

//GO
class GO : public space {
public:
	GO() : space("GO") {}
	void effect(player* play) {
		cout<<" You Passed GO! You receive $200! \n";
		play->gain(200);
	}
};
