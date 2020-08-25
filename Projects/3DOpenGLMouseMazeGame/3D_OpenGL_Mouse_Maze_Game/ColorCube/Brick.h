#ifndef BRICK_BOX_H
#define BRICK_BOX_H
#include "GraphicsObject.h"

// Data vertex for the brick
point4  brick_vertices[8] = {
	point4(-0.5,-0.5,0.5, 1.0),
	point4(0.5,-0.5,0.5, 1.0),
	point4(0.5,0.5,0.5, 1.0),
	point4(-0.5,0.5,0.5, 1.0),
	point4(-0.5,-0.5,-0.5, 1.0),
	point4(0.5,-0.5,-0.5, 1.0),
	point4(0.5,0.5,-0.5, 1.0),
	point4(-0.5,0.5,-0.5, 1.0)
};

class Brick : public graphics_object
{
public:
	point4 offset;
	Brick() : graphics_object("SkyCube") {}

	void triangle( unsigned int a, unsigned int b, unsigned int c )
	{	 // For this texture map, the normal are set to
		 // normalized versions of the vertice itself
		 normal.push_back( normalize(vec4to3(brick_vertices[a])) );
		 vertex.push_back( brick_vertices[a] );

		 normal.push_back( normalize(vec4to3(brick_vertices[b])) );
		 vertex.push_back( brick_vertices[b] );

		 normal.push_back( normalize(vec4to3(brick_vertices[c])) );
		 vertex.push_back( brick_vertices[c] );
	}

	void quad(unsigned int a, unsigned int b, unsigned int c, unsigned int d)
	{	 triangle( a, b, c );
		 triangle( a, c, d );
	}

	void init_data()
	{
		//Right
		quad(1,5,6,2);
		//Left
	    quad(4,0,3,7);
		//Top
	    quad(3,2,6,7);
		//Bottom
	    quad(4,5,1,0);
		//Front
	    quad(0,1,2,3);
		//Back
	    quad(5,4,7,6);
	}

	void init_shader()
	{
		program  = InitShader("vshader32.glsl", "fshader32.glsl");
		GL_CHECK_ERRORS
	}

	void start_shader()
	{
		glEnable(GL_TEXTURE_CUBE_MAP);
		glActiveTexture(GL_TEXTURE2);
		glBindVertexArray( vao );
		glBindBuffer( GL_ARRAY_BUFFER, buffers[0]);
		glBindBuffer( GL_ARRAY_BUFFER, buffers[1]);
		glUseProgram( program );

		uniforms[0] = glGetUniformLocation( program, "ModelView" );
		uniforms[1] = glGetUniformLocation( program, "Projection" );
		uniforms[4] = glGetUniformLocation( program, "vOffset");

		uniforms[2] = glGetAttribLocation(program, "vPosition");
		glEnableVertexAttribArray(uniforms[2]);
		glVertexAttribPointer(uniforms[2], 4, GL_FLOAT, GL_TRUE, sizeof(GLfloat)*4, BUFFER_OFFSET(0) );

		uniforms[3] = glGetAttribLocation(program, "Normal");
		glEnableVertexAttribArray(uniforms[3]);
		glVertexAttribPointer(uniforms[3], 4, GL_FLOAT, GL_TRUE, sizeof(GLfloat)*4, BUFFER_OFFSET(0)  );

		GL_CHECK_ERRORS
	}

	void stop_shader()
	{	glUseProgram(0);
		glBindVertexArray( 0 );
		GL_CHECK_ERRORS
	}

	void init_texture_map()
	{
		glGenTextures(1, &tex);
		glActiveTexture(GL_TEXTURE2);
		glBindTexture(GL_TEXTURE_CUBE_MAP, tex);
		glTexParameteri(GL_TEXTURE_CUBE_MAP, GL_TEXTURE_MAG_FILTER, GL_NEAREST);
		glTexParameteri(GL_TEXTURE_CUBE_MAP, GL_TEXTURE_MIN_FILTER, GL_NEAREST);
		glTexParameteri(GL_TEXTURE_CUBE_MAP, GL_TEXTURE_WRAP_S, GL_CLAMP_TO_EDGE);
		glTexParameteri(GL_TEXTURE_CUBE_MAP, GL_TEXTURE_WRAP_T, GL_CLAMP_TO_EDGE);
		glTexParameteri(GL_TEXTURE_CUBE_MAP, GL_TEXTURE_WRAP_R, GL_CLAMP_TO_EDGE);

		int TexRight = MyLoadCubeMapBitmap( "colorfulkitty.bmp", GL_TEXTURE_CUBE_MAP_POSITIVE_X );
		int TexLeft = MyLoadCubeMapBitmap( "colorfulsmoke.bmp", GL_TEXTURE_CUBE_MAP_NEGATIVE_X );
		int TexTop = MyLoadCubeMapBitmap( "supernova.bmp", GL_TEXTURE_CUBE_MAP_POSITIVE_Y );
		int TexBottom = MyLoadCubeMapBitmap( "rainbowroad.bmp", GL_TEXTURE_CUBE_MAP_NEGATIVE_Y );
		int TexFront = MyLoadCubeMapBitmap( "swanson.bmp", GL_TEXTURE_CUBE_MAP_POSITIVE_Z );
		int TexBack =  MyLoadCubeMapBitmap( "Tulips.bmp", GL_TEXTURE_CUBE_MAP_NEGATIVE_Z );

		texMapLocation = glGetUniformLocation(program, "texMap");
		glUniform1i( texMapLocation, tex );

		GL_CHECK_ERRORS
	}

	void init_VAO()
	{
		// Init the VAO for this object on the graphics card
		glGenVertexArrays( 1, &vao );
		glBindVertexArray( vao );
		GL_CHECK_ERRORS
	}

	void init_VBO()
	{
		// Generate 2 buffers, one for the vertex, one for the normal
		glGenBuffers(2, buffers);

		// Initialize a buffer data object of all the vertex
		glBindBuffer( GL_ARRAY_BUFFER, buffers[0]);
		glBufferData( GL_ARRAY_BUFFER, sizeof(GLfloat)*4*vertex.size(),  &(vertex[0]), GL_STATIC_DRAW );

		GL_CHECK_ERRORS

		// Initialize a buffer data object of all the normal
		glBindBuffer( GL_ARRAY_BUFFER, buffers[1]);
		glBufferData( GL_ARRAY_BUFFER, sizeof(GLfloat)*4*normal.size(), &(normal[0]), GL_STATIC_DRAW );
	}

	void redraw()
	{
		glUniform4f(uniforms[4], offset[0],offset[1],offset[2],offset[3]);
		glutPostRedisplay();
	}
	void draw ( GLfloat theta[] )
	{
		glPolygonMode (GL_FRONT_AND_BACK, GL_FILL);
		GL_CHECK_ERRORS
		start_shader();
		// ship down the new the projection and viewing matrices
		glUniformMatrix4fv(uniforms[0], 1, GL_TRUE, modelview * Scale( 0.5, 0.5, 0.5) * RotateX(theta[0]) * RotateY(theta[1])  * RotateZ(theta[2]) );
		GL_CHECK_ERRORS

		glUniformMatrix4fv( uniforms[1], 1, GL_TRUE, projection );
		GL_CHECK_ERRORS

		glUniform4f(uniforms[4], offset[0],offset[1],offset[2],offset[3]);

		glDrawArrays( GL_TRIANGLES, 0,  vertex.size() );
		GL_CHECK_ERRORS
		stop_shader();
	}

	void cleanup()
	{
		glDeleteTextures(1, &tex );
		glDeleteBuffers(3, buffers);
		glDeleteVertexArrays(1, &vao);
	}
};
#endif