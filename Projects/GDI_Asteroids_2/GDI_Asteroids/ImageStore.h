#pragma once
#include "stdafx.h"
/**GameObject
 * A resource manager for sprites in the game. Its often quite important
 * how and where you get your game resources from. In most cases
 * it makes sense to have a central resource loader that goes away, gets
 * your resources and caches them for future use.
 * <p>
 * [singleton]
 * <p>
 * @author Kevin Glass
 */

class ImageContainer {
private:
	/** contains the map of strings to image pointer */
	map<wstring, Image *> single;
	
public:	
	ImageContainer() : single()
	{}

	/**
	 * Retrieve a sprite from the store
	 * 
	 * @param fileName The reference to the image to use for the sprite
	 * @return A pointer to an Image object
	 */

	Image * getSprite(wstring fileName, double scaleFactor )
	{
		// if we've already got the image in the cache
		// then just return the existing version
		if ( single.find( fileName ) != single.end() ) {
			return single[fileName];
		}

		Image * original = Image::FromFile(fileName.c_str());
		if ( original == NULL ) 
			cout << "Failed to load: " << fileName.c_str() << endl;

        
		float oldHeight = (float)original->GetHeight() ;
		float oldWidth =  (float)original->GetWidth();

		//Calculate the new height using the aspect ratio and the desired new width.
		int newHeight = (int)(scaleFactor * oldHeight);
		int newWidth = (int)(scaleFactor * oldWidth);

		//Create a bitmap of the correct size and format.
		Bitmap *temp = new Bitmap(newWidth, newHeight, original->GetPixelFormat());

		//Get a Graphics object from the bitmap.
		Graphics * newImage = Graphics::FromImage(temp);

		//Draw the image with the new width/height
		newImage->DrawImage(original, 0, 0, newWidth, newHeight);

		//Dispose of our temporary objects.
		delete original;
		delete newImage;

		// Put image pointer into the cash and return it.
		single[fileName] = dynamic_cast<Image *>(temp);

		return dynamic_cast<Image *>( temp );
	}


	/**
	 * Utility method to handle resource loading failure
	 * 
	 * @param message The message to display on failure
	 */
	void fail(wstring message) {
		// we're pretty dramatic here, if a resource isn't available
		// we dump the message and exit the game
		cerr << message.c_str() << endl;
		exit(0);
	}
};
