#include "Asteroid.h"
#include "SpaceShip.h"

class Collides 
{
	bool collides( GameObject  * other )
	{

	}

    bool collides( GameObject * a, GameObject * b )
    {
    			// check if this ship collides with another game object
		if ( GameObject::collides( other ) )
		{
			// if we collide with an asteroid, blow our ship up.
			// and exchange momentum for a bounce effect
			if ( typeid(other) == typeid(Asteroid*)  )
			{
				explodes();
				Asteroid * pa = dynamic_cast<Asteroid*>(other);
				if ( pa && ! pa->pieces() )
				{	exchange_momentum(other);
				}
				else
				{	dynamic_cast<Asteroid*>(other)->explodes();
				}
			}
			return true;
		}
		return false;
    	// check if this asteroid collides with another game object
    	if ( GameObject::collides( other ) )
    	{
    		if ( typeid(*other) == typeid(SpaceShip) )
    		{	dynamic_cast<SpaceShip*>(other)->explodes();
    			exchange_momentum( other );
    		}
    		else if ( typeid(*other) == typeid(Bullet) )
    		{	explodes();
    			other->dead();
    		}
    		else if ( typeid(*other) == typeid(Asteroid) &&  ! bpieces && ! dynamic_cast<Asteroid *>(other)->bpieces )
    			exchange_momentum( other );
    		return true;
    	}
    	return false;
    }
};