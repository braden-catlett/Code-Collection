#include "stdafx.h"
#include <vector>
#include <algorithm>
#include <sstream>
#include "GameObject.h"
#include "Asteroid.h"
#include "SpaceShip.h"
#include "Strsafe.h"

using namespace std;

class Game 
	{
	private:
		long lastSystemTime;
		vector<GameObject *> gobjects;
		SpaceShip * ship;
		HDC hdcBuffer;
		HBITMAP hBmp;
		int WIDTH;
		int HEIGHT;
		int count;
		long timeStep;
	public:
		
		// Initialize all the game objects and the graphics buffer
		Game( RECT r )
		{	
			count = 0;
			lastSystemTime = GetTickCount(); 

			WIDTH = (r.right-r.left);
			HEIGHT = (r.bottom-r.top);

			ship = new SpaceShip( WIDTH/2, HEIGHT/2, 0.25, gobjects);
			gobjects.push_back(ship);

			for ( int i=0; i<20; i++ )
			{	gobjects.push_back(new Asteroid(drand()*WIDTH, drand()*HEIGHT, 0.15, gobjects ));
				( (Asteroid *) (gobjects[i]) )->setall(drand()*WIDTH, drand()*HEIGHT,drand()*0.025, drand()*0.025);
			}
		

		}
		~Game()
		{
			for ( int i=0; i< gobjects.size(); i++ )
				delete gobjects[i];
		}


		void KeyPressed( WPARAM wParam )
		{	if ( wParam == VK_SPACE) {
				ship->start_firing( );
			}	
		}

		void KeyReleased( WPARAM wParam )
		{	switch( wParam ) 
			{
			case VK_LEFT:	ship->turn_left(); break;
			case VK_RIGHT:	ship->turn_right(); break;
			case VK_DOWN:	ship->fire_engines(); break;
			case VK_UP:		ship->stop(); break;
			case VK_SPACE:  ship->stop_firing(); break;
			case VK_ESCAPE:	exit(0); break;
			}
		}

		void draw( HWND hWnd, HDC hdc )
		{

			RECT r;
			GetClientRect(hWnd, &r);
			int WIDTHB = (r.right-r.left);
			int HEIGHTB = (r.bottom-r.top);

			// Create a buffer into which we will draw
			hdcBuffer = CreateCompatibleDC(hdc);
			hBmp = CreateCompatibleBitmap(hdc,WIDTHB,HEIGHTB); 
			SelectObject(hdcBuffer, hBmp);
			Graphics graphics(hdcBuffer);

			// Blank the buffer
			graphics.Clear(Color::Black);

			// Draw all the objects 
			for ( int i=0; i < gobjects.size(); i++ )
				if ( gobjects[i]->isalive())
					gobjects[i]->draw(&graphics);

			wostringstream obuf;
			obuf << "Frame Rate: " << 1.0/(timeStep/1000.0);

			SolidBrush  brush(Color(255, 0, 0, 255));
			FontFamily  fontFamily(L"Times New Roman");
			Font        font(&fontFamily, 24, FontStyleRegular, UnitPixel);
			PointF      pointF(10.0f, 20.0f);
   
			graphics.DrawString( (obuf.str()).c_str(), -1, &font, pointF, &brush);

			BitBlt(hdc, 0,0, WIDTH , HEIGHT, graphics.GetHDC(), 0,0, SRCCOPY);

			// Very important! Must clean up the buffer and bitmaps
			// to prevent a memory leak!
			DeleteDC(hdcBuffer);
			DeleteObject(hBmp);     

		}



		void update( ) 
		{
						
			// compute the length of the last loop
			long long ltimeStep = GetTickCount() - lastSystemTime;
			lastSystemTime = GetTickCount(); 

			timeStep = (long) ltimeStep;
			
			// Update and  all the objects 
			for ( int i=0; i < gobjects.size(); i++ )
			{
				if ( gobjects[i]->isalive())
				{	gobjects[i]->move(timeStep);
				}
			}
			

			// Collision detection
			for ( int i=0; i < gobjects.size()-1; i++ )
			{	for ( int j=i+1; j < gobjects.size(); j++ )
				{	// Deal with collisions (if they occur)
					if ( gobjects[i]->collides( gobjects[j] ) )
					{
						gobjects[i]->exchange_momentum(gobjects[j]);
						if ( typeid((*gobjects[i])) != typeid((*gobjects[j])) )
						{	gobjects[i]->explodes();
							gobjects[j]->explodes();
						}
					}
				}
			}

			// Check for dead objects and remove them
			int num1 = gobjects.size();
			for (int i=gobjects.size()-1; i>=0; i-- ) 
			{	if ( gobjects[i]->isdead() )
				{	swap( gobjects[i], gobjects[ gobjects.size()-1 ] );
  					delete gobjects[ gobjects.size()-1 ];
					gobjects.pop_back();
				}
			}
			int num2 = gobjects.size();

		}
		
	};