#pragma once
#include "GameObject.h"
#include "ImageStore.h"

extern ImageContainer * ImageStore;

class Bullet : public GameObject, Target 
{
private:
	static const long time_to_live = 1500;
	double live_time;

public:
	Bullet(double x, double y, double vx, double vy, double scaleFactor ) : GameObject(x, y, ImageStore->getSprite(L"img/Bullet.jpg",scaleFactor) )
	{	live_time = 0;
		setvx(vx);
		setvy(vy);
	}
	   
	// Draw the object
    void draw( Graphics & g )
    {  	// Only draw bullets that are alive!
    	if ( isalive() )
    		draw( g );
    }

	void explodes() {
		kill();
	}

	bool CantExchangeM()
	{ return true; }
    
	 void move( double timeStep )
	 {	 if ( isalive() )
		 {	 GameObject::move(timeStep);
		 
			 // keep track of how long this bullet has lived
			 live_time += timeStep;
			 
			 // kill this bullet after the time is up
			 if ( live_time > time_to_live )
				 kill();
		 }
	 }
};
