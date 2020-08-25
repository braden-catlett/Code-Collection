#include "Space.h"
#include <ctime>
#include <vector>
using namespace std;
// Function to simulate the dice will the game
int roll(int diceSize, int times);
//Function to enter in number of players and the player's name
void enter_data(vector<player*>& players);
//To build the board
void build_board(vector<space*>& board);
//Menu
void menu(vector<space*>& board, vector<player*>& players);

int main() {
	srand(time(NULL));
	//player objects
	player* one = new player;
	player* two = new player;
	player* three = new player;
	player* four = new player;

	//containers for the spaces and players
	vector<space*> board;
	vector<player*> players;
	players.push_back(one);
	players.push_back(two);
	players.push_back(three);
	players.push_back(four);
	//Example game code
	build_board(board);
	enter_data(players);
	system("pause");
	system("cls");
	while(players.size() != 1) {
	menu(board,players);
	}
	cout<<"Congradulations "<<players[0]->getname()<<"! You have Won"<<endl;
	return 0;
}
int roll(int diceSize, int times) {
	int sum = 0;
	for(times;times > 0;times--)
		sum += (1 + rand() % diceSize);
	return sum;
}

void enter_data(vector<player*>& players) {
		int numplay;
		std::string name;
		cout<<"How many players will be playing? "<<endl;
		cin >> numplay;
		for(int i = (4 - numplay); i > 0; i--) {
			players.pop_back();
		}
		for(int i = 0; i < numplay; i++) {
			cin.ignore();
			cout<<"Player "<<(i+1)<<", Please enter in your name\n";
			cin >> name;
			players[i]->setname(name);
		}
	}

void build_board(vector<space*>& board) {
	//Other spaces
	GO* go = new GO;
	chance* chest = new chance;
	income* come = new income;
	luxury* lux = new luxury;
	//Properties
	//Brown
	Property* brown = new Property(false, 60, 30, "Mediterranean Avenue", 50, 2, NULL, NULL, NULL);
	Property* brown2 = new Property(false, 60, 30, "Baltic Avenue", 50, 4, NULL, NULL, NULL);
	//Light Blue
	Property* lblue = new Property(false, 100, 50, "Oriental Avenue", 50, 6, NULL, NULL, NULL);
	Property* lblue2 = new Property(false, 100, 50, "Vermont Avenue", 50, 6, NULL, NULL, NULL);
	Property* lblue3 = new Property(false, 120, 60, "Connecticut Avenue", 50, 8, NULL, NULL, NULL);
	//Purple
	Property* purp = new Property(false, 140, 70, "St.Charles Place", 100, 10, NULL, NULL, NULL);
	Property* purp2 = new Property(false, 140, 70, "States Avenue", 100, 10, NULL, NULL, NULL);
	Property* purp3 = new Property(false, 160, 80, "Virginia Avenue", 100, 12, NULL, NULL, NULL);
	//Orange
	Property* orange = new Property(false, 180, 90, "St.James Place", 100, 10, NULL, NULL, NULL);
	Property* orange2 = new Property(false, 180, 90, "Tennessee Avenue", 100, 10, NULL, NULL, NULL);
	Property* orange3 = new Property(false, 200, 100, "New York Avenue", 100, 10, NULL, NULL, NULL);
	//Red
	Property* red = new Property(false, 220, 110, "Kentucky Avenue", 150, 18, NULL, NULL, NULL);
	Property* red2 = new Property(false, 220, 110, "Indiana Avenue", 150, 18, NULL, NULL, NULL);
	Property* red3 = new Property(false, 240, 120, "Illinois Avenue", 150, 20, NULL, NULL, NULL);
	//Yellow
	Property* yellow = new Property(false, 260, 130, "Alantic Avenue", 150, 22, NULL, NULL, NULL);
	Property* yellow2= new Property(false, 260, 130, "Ventnor Avenue", 150, 22, NULL, NULL, NULL);
	Property* yellow3 = new Property(false, 280, 140, "Marvin Gardens", 150, 24, NULL, NULL, NULL);
	//Green
	Property* green = new Property(false, 300, 150, "Pacific Avenue", 200, 26, NULL, NULL, NULL);
	Property* green2 = new Property(false, 300, 150, "North Carolina Avenue", 200, 26, NULL, NULL, NULL);
	Property* green3 = new Property(false, 320, 160, "Pennsylvania Avenue", 200, 28, NULL, NULL, NULL);
	//Blue
	Property* blue = new Property(false, 350, 175, "Park Place", 200, 35, NULL, NULL, NULL);
	Property* blue2 = new Property(false, 400, 200, "Boardwalk", 200, 50, NULL, NULL, NULL);
	//Railroads
	Property* rail1 = new Property(false, 200, 10, "Short Line", 0, 25, NULL, NULL, NULL);
	Property* rail2 = new Property(false, 200, 100, "Reading Railroad", 0, 25, NULL, NULL, NULL);
	Property* rail3 = new Property(false, 200, 100, "Pennsylvania Railroad", 0, 25, NULL, NULL, NULL);
	Property* rail4 = new Property(false, 200, 100, "B & O Railroad", 0, 25, NULL, NULL, NULL);
	//Utilities
	Property* power = new Property(false, 150, 75, "Electric Company", 0, 25, NULL, NULL, NULL);
	Property* water = new Property(false, 150, 75, "Water Works", 0, 25,NULL, NULL, NULL);

	//construction of board
	board.push_back(go);
	board.push_back(brown);
	board.push_back(chest);
	board.push_back(brown2);
	board.push_back(come);
	board.push_back(rail1);
	board.push_back(lblue);
	board.push_back(chest);
	board.push_back(lblue2);
	board.push_back(lblue3);
	//board.push_back(NULL);//Just visiting/In Jail
	board.push_back(purp);
	board.push_back(power);
	board.push_back(purp2);
	board.push_back(purp3);
	board.push_back(rail2);
	board.push_back(orange);
	board.push_back(chest);
	board.push_back(orange2);
	board.push_back(orange3);
	//board.push_back(NULL);//free parking
	board.push_back(red);
	board.push_back(chest);
	board.push_back(red2);
	board.push_back(red3);
	board.push_back(rail3);
	board.push_back(yellow);
	board.push_back(yellow2);
	board.push_back(water);
	board.push_back(yellow3);
	//board.push_back(NULL);//Go to Jail
	board.push_back(green);
	board.push_back(green2);
	board.push_back(chest);
	board.push_back(green3);
	board.push_back(rail4);
	board.push_back(chest);
	board.push_back(blue);
	board.push_back(lux);
	board.push_back(blue2);
	}

void menu(vector<space*>& board, vector<player*>& players) {
	int choice;
	for(unsigned int i = 0; i < players.size(); i++) {
		cout<<players[i]->getname() <<"'s Turn"<<endl;
		cout<<"#1 --Roll--"<<endl;
		cout<<"#2 --Purchase House/Hotels--"<<endl;
		cout<<"#3 --Morgage Property--"<<endl;
		cout<<"#4 --Display Personal Stats"<<endl;
		cout<<"#5 --Quit--"<<endl;
		cin >> choice;
		if(choice > 5 || choice < 1) {
			cin.ignore();
			cout<<"Invalid Choice"<<endl;
			cin >> choice;
		}
		switch(choice) {
		case 1:
			{
				//If player is jailed then follow this menu/switch statement
			if(players[i]->injail()) {
				cin.ignore();
				int jail;
				cout<<"You are in jail!"<<endl;
				cout<<"#1 --Roll Again to Try to get out--"<<endl;
				cout<<"#2 --Pay the jail fee--"<<endl;
				if(players[i]->getjailcard() > 0)
					cout<<"#3 --Use a Get Out of Jail Free card--"<<endl;
				cin >> jail;
				if(jail > 3 || jail < 1) {
					cin.ignore();
					cout<<"Invalid Choice"<<endl;
					cin >> jail;
				}
				switch(jail) {
				case 1: {
					int r = roll(6,1);
					int r2 = roll(6,1);
					if(r == r2) {
						cout<<"You got out!"<<endl;
						players[i]->setjailcount(0);
						}
					else
						cout<<"You rolled a "<<r<<" and a "<<r2<<"\nBetter luck next time mate"<<endl;
						players[i]->setjailcount(players[i]->getjailcount() - 1);
					break;
				}
				case 2: {
					cout<<"I didn't see anything...That'll be $50"<<endl;
					players[i]->cost(50);
					players[i]->setjailcount(0);
					break;
						}
				case 3: {
					players[i]->dec_jail();
					players[i]->setjailcount(0);
					break;
						}
				}
				break;
			}
			//If not jailed then follow this one
			int r = roll(6,1);
			int r2 = roll(6,1);
			cout<<"You rolled a "<< r <<" and a "<< r2 << endl;
			/*if(r == r2) {
			}*/
			if((players[i]->get_pos() + (r + r2)) > 37) {
				board[0]->effect(players[i]);
				players[i]->setpos((players[i]->get_pos() + (r + r2))- 37);
				board[players[i]->get_pos()]->effect(players[i]);
			}
			else {
			players[i]->setpos((players[i]->get_pos() + (r + r2)));
			board[players[i]->get_pos()]->effect(players[i]);
			}
			break;
		}
		case 2: {
			break;
		}
		case 3: {
			break;
		}
		case 4: {
			int it = 1;
			int mt = 1;
			cout<<"Current Money: $"<<players[i]->get_funds()<<endl;
			cout<<"Property: "<<endl;			
			for(int k = 0; k < board.size(); k++) {
				if(board[k]->is_owned() == true) {
					if(board[k]->get_ownedby()->getname() == players[i]->getname()) { //Here is where the problem is. I think its just not liking calling getname
						cout<<"#"<<it<<" "<<board[k]->get_name()<<endl;			//on a null pointer which is what the objects GO, Chance, etc... have for their
						it++;													//owned_by member variables since they can't be owned.
						}
				}
			}
			cout<<"Morgaged: "<<endl;
			for(int k = 0; k < board.size(); k++) {
				if(board[k]->get_morgaged() != NULL) {
				if(board[k]->get_morgaged()->getname() == players[i]->getname()) {
					cout<<"#"<<mt<<" "<<board[k]->get_name()<<endl;
					mt++;
					}
				}
					system("pause");
					system("cls");
					menu(board,players);
					break;
				}
			}
		case 5: {
			cout<<"=( bye bye"<<endl;
			delete players[i];
			break;
		}
	}
	system("cls");
	}
}