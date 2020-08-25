#pragma once
#include "stdafx.h"
#include <string>
#include <cmath>

using namespace std;

extern class SpaceShip;

class GameObject 
{
private:
	RectF r;   // x,y location and bounds of the object
	PointF v;   // x,y velocity vector
    bool balive; // is this object alive?
	bool bexploding; // is this object exploding?

protected:
    Image *ps; // the current image for this object
    string name; // object name

public:
	static const long time_to_regenerate;
	static const double sin45; 
	static const double thrust_delta;

	// Constructor
	GameObject( double x=0.0, double y=0.0, Image *psprite=NULL ) : v(0.0f,0.0f), balive(true), ps(psprite), r( x, y, psprite->GetWidth(), psprite->GetHeight() ), name(""),  bexploding(false)  
    { }

	GameObject( double x, double y, Image *psprite, bool exploding ) : v(0.0f,0.0f), balive(true), ps(psprite), r( x, y, psprite->GetWidth(), psprite->GetHeight() ), name(""),  bexploding(exploding)  
    { }

    // Gettors 
    double getx() { return r.X; }
    double gety() { return r.Y; }
    double getvx() { return v.X; }
    double getvy() { return v.Y; }
    string getname() { return name; }
    Image * getsprite() { return ps; } 
    double randomv( double x )   { 	return ( (0.5 * x) - ( drand() * 0.90 * x)) + x;   }
	bool isalive() { return balive;  }
	bool isdead() { return !balive; }
	bool isexploding() { return bexploding; }
    
	// Settors
	void setx(double x) { r.X = x; }
    void sety(double y) { r.Y = y; }
    void setvx(double vx) { v.X = vx; }
    void setvy(double vy) { v.Y = vy; }
	void setall(double x, double y, double vx, double vy )
    {  	setx(x);  	sety(y);   	setvx(vx);    	setvy(vy);
    }
    void setname(string pname) { name = pname; }
    void setsprite(Image * psprite) { ps = psprite; }
	void setexploding( bool state ) { bexploding = state; }
	void kill() { balive = false; }
        
    // Draw the object
    virtual void draw( Graphics * g )   {	g->DrawImage( (Image*) ps, (const RectF&) r );    }
    
    // Move the object
    virtual void move( double timeStep )
    {
    	r.X = r.X + v.X * timeStep;
    	r.Y = r.Y + v.Y * timeStep;
    	
    	// Check for collision with the left and right boundaries
		if ( r.X < 0.0 )
    	{   r.X = 0.0;
    		v.X = -v.X;
    	}
    	else if ( v.X >= 0.0 && r.X > (800.0 - 1.5*ps->GetWidth()) )
    	{	r.X = 800.0 - 1.5*ps->GetWidth();
    		v.X = -v.X;
    	}
		
		// Check for collision with the top and bottom boundaries
		if ( r.Y < 0.0 )
    	{   r.Y = 0.0;
    		v.Y = -v.Y;
    	}
    	else if ( v.Y >= 0.0 && r.Y > (600.0 - 3.0*ps->GetHeight()) )
    	{	r.Y = 600.0 - 3.0*ps->GetHeight();
    		v.Y = -v.Y;
    	}		
    }
    

	bool collides( GameObject * b )
    {  	// check if the object collides with the other game object
		if ( r.IntersectsWith( b->r ) )
			return true;
		else
    		return false;
    }

	// Every game object must implement explodes
	virtual void explodes() = 0;
    
	virtual bool CantExchangeM()
	{ return false; }

    virtual void exchange_momentum( GameObject * po )
    {
		if ( isdead() || po->isdead() || CantExchangeM() || po->CantExchangeM()  )
			return;

    	// we currently assume all objects have the same mass...
    	// and an elastic collision. Would be easy to change 
    	// to a more realistic collision
    	double tvx, tvy;
    	tvx = po->v.X; po->v.X = v.X; v.X = tvx;
    	tvy = po->v.Y; po->v.Y = v.Y; v.Y = tvy;  
    	
    	// Modify the objects positions so they are not intersecting
    	double overlapx = r.Width - abs(r.X - po->r.X);
    	double overlapy = r.Height - abs(r.Y - po->r.Y);
    	if ( overlapx > 0.0 && overlapy > 0.0 )
    	{
	    	if ( overlapx < overlapy )
	    	{
		    	if ( r.X < po->r.X )
		    	{	po->r.X += overlapx/2;
		    		r.X -= overlapx/2;
		    	}
		    	else
		    	{	r.X += overlapx/2;
		    		po->r.X -= overlapx/2;
		    	}
	    	}
	    	else
			{
		       	if ( r.Y < po->r.Y )
		       	{	po->r.Y += overlapy/2;
		       		r.Y -= overlapy/2;
		       	}
		       	else
		       	{	r.Y += overlapy/2;
		       		po->r.Y -= overlapy/2;
		       	}
	    	}
    	}
    }
};

const double GameObject::sin45 = 0.707106781; // sin of 45 degrees
const double GameObject::thrust_delta = 0.03125;
const long  GameObject::time_to_regenerate = 500;