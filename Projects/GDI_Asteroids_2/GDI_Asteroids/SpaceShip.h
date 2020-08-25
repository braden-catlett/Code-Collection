#pragma once
#include "stdafx.h"
#include "Bullet.h"
#include "GameObject.h"
#include "Controls.h"
#include "Target.h"
#include "ImageStore.h"



class SpaceShip : public GameObject, Controls, Target
{
private: 
	Image * shipview[10];


	vector<GameObject *> & gobjects;

	long exploding_time;
	bool exploding;
	bool firing_weapon;

	static const int left = 0;
	static const int leftup = 1;
	static const int up = 2;
	static const int rightup = 3;
	static const int right = 4;
	static const int rightdown = 5;
	static const int down = 6;
	static const int leftdown = 7;
	static const int kaboom1 = 8;
	static const int kaboom2 = 9;

	double bvelocity;

	int dir;
	int boomview;

public:

	int getdir()  {	return dir;  }

	SpaceShip( double x, double y, double scaleFactor, vector<GameObject *> & gobjs ) : GameObject(x, y, ImageStore->getSprite(L"img/shipup.jpg",scaleFactor) ), gobjects(gobjs)
	{
		exploding_time = 0;
		exploding = false;
		firing_weapon = false;
		bvelocity = 1.0;
		dir = up;
		boomview = kaboom1;
		
		shipview[leftup] = ImageStore->getSprite(L"img/shipleftup.jpg",scaleFactor);
		shipview[up] = ImageStore->getSprite(L"img/shipup.jpg",scaleFactor);
		shipview[rightup] = ImageStore->getSprite(L"img/shiprightup.jpg",scaleFactor);
		shipview[left] = ImageStore->getSprite(L"img/shipleft.jpg",scaleFactor);
		shipview[kaboom1] = ImageStore->getSprite(L"img/shipkaboom1.jpg",scaleFactor);
		shipview[kaboom2] = ImageStore->getSprite(L"img/shipkaboom2.jpg",scaleFactor);
		shipview[right] = ImageStore->getSprite(L"img/shipright.jpg",scaleFactor);
		shipview[leftdown] = ImageStore->getSprite(L"img/shipleftdown.jpg",scaleFactor);
		shipview[down] = ImageStore->getSprite(L"img/shipdown.jpg",scaleFactor);
		shipview[rightdown] = ImageStore->getSprite(L"img/shiprightdown.jpg",scaleFactor);

	}

	void move( double timeStep )
	{

		GameObject::move(timeStep);

		if ( firing_weapon ) {	fire_weapon();	}

		// set the ships sprite depending on ships direction
		if ( !exploding )  
		{	setsprite( shipview[ getdir( ) ] );
		}
		else   
		{	// set the ships sprite to explosion for exploding_time
			exploding_time += timeStep;

			// regenerate ship after exploding_time is up. reset exploding_time counter to zero
			// for the next time we collide
			if ( exploding_time > time_to_regenerate )
			{	exploding = false;
				setsprite( shipview[ getdir( ) ] );
				exploding_time = 0;
			}

			// alternate the ships explosion sprites
			// for a dynamic explosion effect
			if ( boomview == kaboom1 )
				boomview = kaboom2;
			else
				boomview = kaboom1;

			// set the explosion sprite for the ship
			setsprite( shipview[ boomview ] );
		}
	}

	void turn_left()
	{	dir = dir - 1;
		if ( dir < 0) dir = 7;
	}

	void turn_right()
	{	dir = dir + 1;
		if ( dir > 7) dir = 0;
	}

	void stop()
	{	setvx(0.0);
		setvy(0.0);
	}

	void fire_engines()
	{	if ( dir == left )
			setvx( getvx() - thrust_delta);
		else if ( dir == leftup )
		{	setvx( getvx() - thrust_delta * sin45 );
			setvy( getvy() - thrust_delta * sin45 );
		}
		else if ( dir == up )
			setvy( getvy() - thrust_delta);
		else if ( dir == rightup )
		{	setvx( getvx() + thrust_delta * sin45 );
			setvy( getvy() - thrust_delta * sin45 );
		}
		else if ( dir == right )
			setvx( getvx() + thrust_delta );
		else if ( dir == rightdown )
		{	setvx( getvx() + thrust_delta * sin45 );
			setvy( getvy() + thrust_delta * sin45 );
		}
		else if ( dir == down )
			setvy( getvy() + thrust_delta );
		else if ( dir == leftdown )
		{	setvx( getvx() - thrust_delta * sin45 );
			setvy( getvy() + thrust_delta * sin45 );
		}
	}

	void start_firing( )
	{	firing_weapon = true;
	}

	void stop_firing( )
	{	firing_weapon = false;
	}

	void fire_weapon(  ) 
	{	// Can't fire bullets while exploding!
		if (exploding)
			return;

		double brvelocity = randomv(bvelocity);

		double bw = 8;
		double bh = 8;
		double bx = 0, by = 0;
		double x = getx();
		double y = gety();
		double bvx = getvx();
		double bvy = getvy();

		if ( dir == left )
		{	bx = x-bw;
			by = y + ps->GetHeight()/2 - bw/2;
			bvx -= brvelocity;
		}
		else if ( dir == leftup )
		{	bx = x-bw;
			by = y-bh;
			bvx -= brvelocity * sin45;
			bvy -= brvelocity * sin45;
		}
		else if ( dir == up )
		{	bx = x + ps->GetWidth()/2 - bw/2;
			by = y - bh;
			bvy -= brvelocity;
		}
		else if ( dir == rightup )
		{	bx = x + ps->GetWidth() + bw;
			by = y - bh;
			bvx += brvelocity * sin45;
			bvy -= brvelocity * sin45;
		}
		else if ( dir == right )
		{	bx = x + ps->GetWidth() + bw;
			by = y + ps->GetHeight()/2 - bh/2;
			bvx += brvelocity;
		}
		else if ( dir == rightdown )
		{	bx = x + ps->GetWidth() + bw;
			by = y + ps->GetHeight() + bh;
			bvx += brvelocity * sin45;
			bvy += brvelocity * sin45;
		}
		else if ( dir == down )
		{	bx = x + ps->GetWidth()/2 - bw/2;
			by = y + ps->GetHeight() + bh;
			bvy += brvelocity;
		}
		else if ( dir == leftdown )
		{	bx = x - bw/2;
			by = y + ps->GetHeight() + bh;
			bvx -= brvelocity * sin45;
			bvy += brvelocity * sin45;
		}

		gobjects.push_back( static_cast<GameObject *> (new Bullet(bx,by,bvx,bvy,1.0)) );
	} 

	bool CantExchangeM()
	{ return true; }

	void explodes() {
		setexploding( true );
		setsprite( shipview[ kaboom1 ] );
	}
};


