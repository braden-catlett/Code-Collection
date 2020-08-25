#include <iostream>
#include <cmath>
#include <iomanip>
#include <cassert>
#include <vector>
using namespace std;

#include "Angel.h"
#include <GL/glew.h> // for OpenGL extensions
#include <GL/glut.h> // for Glut utility kit
#include "texture.h" // for the bitmap texture loader

// Global Projection Matrices
mat4 projection, modelview;

#include "GraphicsObject.h"
#include "SkyBox.h"
#include "Maze.h"

enum Direction {North = 0, East = 1, South = 2, West = 3};
int map[101][101];
int playerX = 1;
int playerY = 2; //used to keep track of player position in maze array
int direction = North; //used to keep track of player direction;

GLfloat  zoom = 1.0;         // Translation factor
GLfloat  xFact = 0.0;
GLfloat	 yFact = 0.0;
GLfloat  zFact = 0.0;
GLfloat yRot = 0.0;

GLfloat  fovy = 60.0;		 // Field-of-view in Y direction angle (in degrees)
GLfloat  aspect = 1.0;       // Viewport aspect ratio
GLfloat  zNear = .00001, zFar = 3000.0;
GLfloat  zleft = -100.0, zright = 100.0, zbottom = -2.0, ztop = 2.0;

GLfloat dir = 1.0;
GLfloat theta[] = {0.0,0.0,0.0};
GLfloat Mazetheta[] = {0.0,0.0,0.0,0.0};
GLint axis = 1;

// THE global SkyBox Object
SkyBox go_skybox;

// The
Maze maze;

void display( void )
{
	glClearColor(1.0,1.0,1.0,1.0);
	glClear(GL_COLOR_BUFFER_BIT | GL_DEPTH_BUFFER_BIT );  /*clear the window */

	projection = Perspective( fovy, aspect, zNear, zFar ) /* Translate( 0.0, 0.0, -zoom)*/;

	point4  eye( 0.0, 0.0, 0.5, 0.0 );
	point4  at( 0.0, 0.0, 1.0, 0.0 );
	vec4    up( 0.0, 1.0, 0.0, 1.0 );

	modelview = LookAt( eye, at, up );

	Mazetheta[0] = xFact; Mazetheta[1] = yFact; Mazetheta[2] = zFact;
	Mazetheta[3] = yRot;

	// tell the skybox to draw it's vertex
	go_skybox.draw( Mazetheta );

	maze.draw( Mazetheta );
	// swap the buffers
	glutSwapBuffers();
}

void spinCube()
{
	if ( axis > -1 )
	{
		theta[axis] += 0.05 * dir;
		if( theta[axis] > 360.0 ) theta[axis] -= 360.0;
		glutPostRedisplay();
	}
}

void mouse(int btn, int state, int x, int y)
{
	if(btn==GLUT_LEFT_BUTTON && state == GLUT_DOWN)	axis = 1;
	if(btn==GLUT_MIDDLE_BUTTON && state == GLUT_DOWN) axis = 0;
	if(btn==GLUT_RIGHT_BUTTON && state == GLUT_DOWN) axis = 2;
	glutPostRedisplay();
}

void mouse_move( int x, int y )
{
	zoom = ( 500.0 / 500.0 ) * y +2.0;  // compute zoom factor
}

void myReshape(int w, int h)
{
	glViewport(0, 0, w, h);
	aspect =  GLfloat (w) / h;
	if(aspect <= 1.0)
	{
		zbottom /= aspect;
		ztop /= aspect;
	}
	else
	{
		zleft += aspect;
		zright += aspect;
	}
}

void key(unsigned char k, int x, int y)
{
	if(k == '1') glutIdleFunc(spinCube);
	if(k == 'r') dir = dir * -1.0;
	if(k == '2') { glutIdleFunc(NULL); axis = -1; }
	if(k == 'q') exit(0);
	if(k == 'a' || k == 'A')
	{
		yRot -= 90.0;
		if(yRot < 0.0)
			yRot = 270.0;
		direction++;
		if(direction > 3)
			direction = 0;
		cout << direction <<endl;
	}
	if(k == 'd' || k == 'D')
	{
		yRot += 90.0;
		if(yRot > 360.0)
			yRot = 90.0;
		direction--;
		if(direction < 0)
			direction = 3;
		cout << direction <<endl;
	}
	if(k == 's' || k == 'S')
	{
		if(map[playerX][playerY] == 7)
			exit(EXIT_SUCCESS);
		switch(direction){
		case 0:
			if(map[playerX+1][playerY] != 1)
			{
				playerX++;
				zFact += 1.0;
			}
			break;
		case 1:
			if(map[playerX][playerY-1] != 1)
			{
				playerY--;
				xFact += 1.0;
			}
			break;
		case 2:
			if(map[playerX-1][playerY] != 1)
			{
				playerX--;
				zFact -= 1.0;
			}
			break;
		case 3:
			if(map[playerX][playerY+1] != 1)
			{
				playerY++;
				xFact -= 1.0;
			}
			break;
		}
	}
	if(k == 'w' || k == 'W')
	{
		if(map[playerX][playerY] == 7)
			exit(EXIT_SUCCESS);
		switch(direction){
		case 0:
			if(map[playerX-1][playerY] != 1)
			{
				playerX--;
				zFact -= 1.0;
			}
			break;
		case 1:
			if(map[playerX][playerY+1] != 1)
			{
				playerY++;
				xFact -= 1.0;
			}
			break;
		case 2:
			if(map[playerX+1][playerY] != 1)
			{
				playerX++;
				zFact += 1.0;
			}
			break;
		case 3:
			if(map[playerX][playerY-1] != 1)
			{
				playerY--;
				xFact += 1.0;
			}
			break;
		}
	}
	if(k == 'r' || k == 'R')
	{
		xFact -= 1.0;
	}
	if(k == 't' || k == 'T')
	{
		xFact += 1.0;
	}
	glutPostRedisplay();
}

void init_gl()
{
	glEnable(GL_DEPTH_TEST);
}

void initMaze()
{
	srand(time(NULL));
	for(int i = 0; i < 101; i++)
	{
		for(int j = 0; j < 101; j++)
		{
			map[i][j] = 1;
		}
	}
	int row = 1;
	int col = 2;
	int direction = 1;
	int count = 0;
	while(count < 1000)
	{
		switch(direction)
		{
			int diff;
			case 1://left
					diff = (rand()%col) - 1;
					for(int i = 0; i < diff; i++)
					{
						if(map[row][col] == 1)
							count++;
						map[row][col] = 0;
						col--;
					}
				break;
			case 2://up
					diff = (rand()%row) - 1;
					for(int i = 0; i < diff; i++)
					{
						if(map[row][col] == 1)
							count++;
						map[row][col] = 0;
						row--;
					}
				break;
			case 3://right
					diff = (rand()%(101 - col)) - 1;
					for(int i = 0; i < diff; i++)
					{
						if(map[row][col] == 1)
							count++;
						map[row][col] = 0;
						col++;
					}
				break;
			case 4://down
					diff = (rand()%(101 - row)) - 1;
					for(int i = 0; i < diff; i++)
					{
						if(map[row][col] == 1)
							count++;
						map[row][col] = 0;
						row++;
					}
				break;
		}
		direction = ((rand()%40000)/10000) + 1;
	}
	while(row < 99)
	{
		map[row++][col] = 0;
	}
	while(col < 99)
	{
		map[row][col++] = 0;
	}
	map[99][99] = 7;
	for(int i = 0; i < 101; i++)
	{
		for(int j = 0; j < 101; j++)
		{
			std::cout << map[i][j];
		}
		std::cout << std::endl;
	}
}

void init()
{
	initMaze();
	init_gl();			    // Setup general OpenGL stuff of the object

	go_skybox.init_data();	        // Setup the data for the skybox object
	go_skybox.init_shader();		// Initialize the shader objects and textures for skybox
	go_skybox.init_texture_map();	// Initialize the texture map for this object
	go_skybox.init_VAO();          // Initialize the vertex array object for this object
	go_skybox.init_VBO();			// Initialize the data buffers for this object

	maze.load_data(map);
	maze.init_data();	        // Setup the data for the skybox object
	maze.init_shader();		// Initialize the shader objects and textures for skybox
	maze.init_VAO();          // Initialize the vertex array object for this object
	maze.init_VBO();			// Initialize the data buffers for this object
	maze.init_texture_map();	// Initialize the texture map for this object

	GL_CHECK_ERRORS
}

void OnShutdown()
{
	go_skybox.cleanup(); // release the textures on the graphics card
	maze.cleanup();
}

void checkGlew()
{
	glewExperimental = GL_TRUE;
	GLenum err = glewInit();
	if (GLEW_OK != err)	{
		cerr<<"Error: " << glewGetErrorString(err)<<endl;
	} else {
		if (GLEW_VERSION_3_3)
		{
			cout<<"Driver supports OpenGL 3.3\nDetails:"<<endl;
		}
	}
	cout<<"Using GLEW "<<glewGetString(GLEW_VERSION)<<endl;
	cout<<"Vendor: "<<glGetString (GL_VENDOR)<<endl;
	cout<<"Renderer: "<<glGetString (GL_RENDERER)<<endl;
	cout<<"Version: "<<glGetString (GL_VERSION)<<endl;
	cout<<"GLSL: "<<glGetString (GL_SHADING_LANGUAGE_VERSION)<<endl;
}

int main(int argc, char **argv)
{
	atexit(OnShutdown);
	glutInit(&argc, argv);
	glutInitDisplayMode(GLUT_DOUBLE | GLUT_RGB | GLUT_DEPTH);
	glutInitWindowSize(500, 500);
	// glutInitContextVersion( 3, 2 );
	// glutInitContextProfile( GLUT_CORE_PROFILE );

	glutCreateWindow( "Maze" );
	checkGlew();
	init();
	glutReshapeFunc(myReshape);
	glutDisplayFunc(display);
	glutIdleFunc(spinCube);       // set in key press
	glutMouseFunc(mouse);
	glutMotionFunc(mouse_move);   // Called when mouse moves with a mouse button pressed
	glutKeyboardFunc(key);
	glutMainLoop();

	return 0;
}