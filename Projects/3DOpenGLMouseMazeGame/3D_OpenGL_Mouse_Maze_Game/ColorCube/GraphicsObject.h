#ifndef GRAPHICS_OBJECT_H
#define GRAPHICS_OBJECT_H

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

#define GL_CHECK_ERRORS \
{ \
	int err=glGetError(); \
	if (err!=0) \
	{   cout << "OpenGL Error: " << err << endl; \
		assert(err == GL_NO_ERROR); \
	} \
}

// Graphics Object Data Structure
typedef Angel::vec4 point4;

// Convert vec4 to vec3
#define vec4to3( v ) vec3(v.x,v.y,v.z)

class graphics_object
{
protected:
	// Data for a graphics object
	string name;
	vector<point4> vertex;
	vector<point4> normal;
	vector<vec2> mapcoord;

	// Arbitrary number of buffers per object, increase if you need more
	static const int MAX_BUFFERS = 10;
	static const int MAX_UNIFORMS = 10;

	// Shader variables for the graphics object
	GLuint program;
	GLuint vao;
	GLuint tex;
	GLuint buffers[MAX_BUFFERS];
	GLint uniforms[MAX_UNIFORMS];
	GLuint texMapLocation;

public:
	graphics_object( string Name ) : name( Name ) { };

	virtual void init_data() = 0;	// must provide an init data function to set up normal and vertex and texture map coords if applicable
	virtual void init_shader() = 0;	// must provide an init shader function to set up program
	virtual void start_shader() = 0; // Start the shader for this object
	virtual void stop_shader() = 0; // STop the shader for this object
	virtual void init_texture_map() = 0; // must provide an init texture map function
	GLuint get_shader_id() { return program;	}
	virtual void init_VAO() = 0;  // must provide an init VAO function
	virtual void init_VBO() = 0;  // must provide an init VBO function
	virtual void draw() { };      // must override draw
	virtual void cleanup() = 0;   // must provide a cleanup function
};
#endif