#pragma once

#include "GameObject.h"
#include "ImageStore.h"
#include "Target.h"

extern ImageContainer * ImageStore;

class Asteroid : public GameObject, Target
{

private:
	static const long time_to_live = 1500;
	vector<GameObject *> & gobjects;
	double scaleFactor;
	double bvelocity;
	bool bpieces;
	long exploding_time;

public:
	Asteroid(double x, double y, double scaleFactor, vector<GameObject *> & gobj ) : gobjects(gobj), GameObject(x, y, ImageStore->getSprite(L"img/asteroid.jpg", scaleFactor) ) 
	{	bvelocity = drand() * 0.25;
		bpieces = false;
		this->scaleFactor = scaleFactor;
		exploding_time = 0.0;
	}
	
	Asteroid(double x, double y, double vx, double vy, double scaleFactor, vector<GameObject *> & gobj  ) : gobjects(gobj), GameObject(x, y,ImageStore->getSprite(L"img/asteroidpiece.jpg",scaleFactor), true )
	{	setall(x, y, vx, vy );
		this->scaleFactor = scaleFactor;
		bpieces = true;
		exploding_time = 0.0;
	}
	
	bool pieces() { return bpieces; }

	void move( double timeStep ) {  

		 if ( isalive() )
		 {	 GameObject::move(timeStep);
		 
			if ( pieces() )
			{
				 // keep track of how long this asteroid piece has lived
				 exploding_time += timeStep;
			 
				 // kill this asteroid piece after the time is up
				 if ( exploding_time > time_to_live )
					 kill();
			}
		 }

	}
	 
	// Asteroids only exhcange momentum when they are large!
	virtual bool CantExchangeM() { return bpieces; }

	void explodes() 
	{	
		// If already a piece of an asteroid, don't break it up into any smaller asteroid pieces
		if ( bpieces )
			return;

		// Not a piece yet, so make it one to prevent causing further explosions
		bpieces = true;
		
		// Implement explosion
		double w = ps->GetWidth()/2;
		double h = ps->GetHeight()/2;
		double bx = getx()+w;
		double by = gety()+h;
		double bvx = getvx();
		double bvy = getvy();
		
		bvx = getvx() - randomv(bvelocity);
		bvy = getvy();
		gobjects.push_back(new Asteroid( bx,  by, bvx, bvy, scaleFactor , gobjects )  );
		
		bvx = getvx() - randomv(bvelocity) * sin45;
		bvy = getvy() - randomv(bvelocity) * sin45;
		gobjects.push_back(new Asteroid( bx,  by, bvx, bvy, scaleFactor , gobjects )  );

		bvx = getvx();
		bvy = getvy() - randomv(bvelocity);
		gobjects.push_back(new Asteroid( bx,  by, bvx, bvy, scaleFactor , gobjects )  );
		
		bvx = getvx() + randomv(bvelocity) * sin45;
		bvy = getvy() - randomv(bvelocity) * sin45;
		gobjects.push_back(new Asteroid( bx,  by, bvx, bvy, scaleFactor , gobjects )  );

		bvx = getvx() + randomv(bvelocity);
		bvy = getvy();
		gobjects.push_back(new Asteroid( bx,  by, bvx, bvy, scaleFactor , gobjects )  );
		
		bvx = getvx() + randomv(bvelocity) * sin45;
		bvy = getvy() + randomv(bvelocity) * sin45;
		gobjects.push_back(new Asteroid( bx,  by, bvx, bvy, scaleFactor , gobjects )  );

		bvx = getvx();
		bvy = getvy() + randomv(bvelocity);
		gobjects.push_back(new Asteroid( bx,  by, bvx, bvy, scaleFactor, gobjects  )  );
		
		bvx = getvx() - randomv(bvelocity) * sin45;
		bvy = getvy() + randomv(bvelocity) * sin45;
		gobjects.push_back(new Asteroid( bx,  by, bvx, bvy, scaleFactor , gobjects )  );

		// Kill the parent asteroid
		kill();
	}

};
