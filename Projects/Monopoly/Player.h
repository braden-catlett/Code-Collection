#ifndef PLAYER
#define PLAYER
class player {
private:	
	int funds;
	int position;
	bool jailed; //to be jailed or not to be jailed, this returns it
	std::string name;
	int jailcard; //represent get out of jail free cards
	int jailcount; //Your only jailed for 3 turns, this is keeping track of that

public:
	player() : funds(1500), position(0), jailed(false), name("Rick James"), jailcard(0), jailcount(0) {}

	int get_funds() const { return funds; }
	int get_pos() const { return position; }
	bool injail() const { return jailed; }
	std::string getname() { return name; }
	void setname(std::string na) { name = na; }
	void setjail(bool n) { jailed = n; }
	int getjailcard() { return jailcard; }
	int getjailcount() { return jailcount; }
	void setjailcount(int n) { 
		if(n == 0)
			jailed = false;
		jailcount = n;
		jailed = true;
	}
	void inc_jail() { jailcard++; }
	void dec_jail() { jailcard--; }

	void cost(int amount) {
		funds = (funds - amount);
	}
	void gain(int amount) {
		funds = (funds + amount);
	}
	void setpos(int t) { position = t; }
};
#endif