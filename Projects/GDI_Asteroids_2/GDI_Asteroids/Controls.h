#pragma once
class Controls {
public:
	
	virtual void turn_left() = 0;
	virtual void turn_right() = 0;
	virtual void fire_engines() = 0;
	virtual void fire_weapon() = 0;
};