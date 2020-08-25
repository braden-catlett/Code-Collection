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

class Maze : public graphics_object
{
public:
	int maze[101][101];
	Maze() : graphics_object("Maze") {}

	void triangle( point4 a, point4 b, point4 c )
	{	 // For this texture map, the normal are set to
		 // normalized versions of the vertice itself
		 normal.push_back( normalize(vec4to3(a)) );
		 vertex.push_back( a );

		 normal.push_back( normalize(vec4to3(b)) );
		 vertex.push_back( b );

		 normal.push_back( normalize(vec4to3(c)) );
		 vertex.push_back( c );
	}

	void quad(point4 a, point4 b, point4 c, point4 d)
	{	 triangle( a, b, c );
		 triangle( a, c, d );
	}

	void load_data(int map[101][101])
	{
		for(int i = 0; i < 101; i++)
		{
			for(int j = 0; j < 101; j++)
			{
				maze[i][j] = map[i][j];
			}
		}
	}

	void init_data()
	{
		GLfloat col = 0.0;
		GLfloat row = 0.0;
		for(int i = 0; i < 101; i++)
		{
			for(int j = 0; j < 101; j++)
			{
				if(maze[i][j] == 0 || maze[i][j] == 7)
				{
					//The floor
					//Bottom
				    //quad(4,5,1,0);
					quad(point4(brick_vertices[4].x + col, brick_vertices[4].y, brick_vertices[4].z + row, brick_vertices[4].w)
						,point4(brick_vertices[5].x + col, brick_vertices[5].y, brick_vertices[5].z + row, brick_vertices[5].w)
						,point4(brick_vertices[1].x + col, brick_vertices[1].y, brick_vertices[1].z + row, brick_vertices[1].w)
						,point4(brick_vertices[0].x + col, brick_vertices[0].y, brick_vertices[0].z + row, brick_vertices[0].w));
				}
				else if(maze[i][j] == 1)
				{
					//From array perspective this is right wall
					//Right
					//quad(1,5,6,2);
					quad(point4(brick_vertices[1].x + col, brick_vertices[1].y, brick_vertices[1].z + row, brick_vertices[1].w)
						,point4(brick_vertices[5].x + col, brick_vertices[5].y, brick_vertices[5].z + row, brick_vertices[5].w)
						,point4(brick_vertices[6].x + col, brick_vertices[6].y, brick_vertices[6].z + row, brick_vertices[6].w)
						,point4(brick_vertices[2].x + col, brick_vertices[2].y, brick_vertices[2].z + row, brick_vertices[2].w));
					//Left wall
					//Left
					//quad(4,0,3,7);
					quad(point4(brick_vertices[4].x + col, brick_vertices[4].y, brick_vertices[4].z + row, brick_vertices[4].w)
						,point4(brick_vertices[0].x + col, brick_vertices[0].y, brick_vertices[0].z + row, brick_vertices[0].w)
						,point4(brick_vertices[3].x + col, brick_vertices[3].y, brick_vertices[3].z + row, brick_vertices[3].w)
						,point4(brick_vertices[7].x + col, brick_vertices[7].y, brick_vertices[7].z + row, brick_vertices[7].w));
					//Top
					//quad(3,2,6,7);
					quad(point4(brick_vertices[3].x + col, brick_vertices[3].y, brick_vertices[3].z + row, brick_vertices[3].w)
						,point4(brick_vertices[2].x + col, brick_vertices[2].y, brick_vertices[2].z + row, brick_vertices[2].w)
						,point4(brick_vertices[6].x + col, brick_vertices[6].y, brick_vertices[6].z + row, brick_vertices[6].w)
						,point4(brick_vertices[7].x + col, brick_vertices[7].y, brick_vertices[7].z + row, brick_vertices[7].w));
					//The floor
					//Bottom
				    //quad(4,5,1,0);
					quad(point4(brick_vertices[4].x + col, brick_vertices[4].y, brick_vertices[4].z + row, brick_vertices[4].w)
						,point4(brick_vertices[5].x + col, brick_vertices[5].y, brick_vertices[5].z + row, brick_vertices[5].w)
						,point4(brick_vertices[1].x + col, brick_vertices[1].y, brick_vertices[1].z + row, brick_vertices[1].w)
						,point4(brick_vertices[0].x + col, brick_vertices[0].y, brick_vertices[0].z + row, brick_vertices[0].w));
					//front
					//Front
					//quad(0,1,2,3);
					quad(point4(brick_vertices[0].x + col, brick_vertices[0].y, brick_vertices[0].z + row, brick_vertices[0].w)
						,point4(brick_vertices[1].x + col, brick_vertices[1].y, brick_vertices[1].z + row, brick_vertices[1].w)
						,point4(brick_vertices[2].x + col, brick_vertices[2].y, brick_vertices[2].z + row, brick_vertices[2].w)
						,point4(brick_vertices[3].x + col, brick_vertices[3].y, brick_vertices[3].z + row, brick_vertices[3].w));
					//The Back
					//Back
					//quad(5,4,7,6);
					quad(point4(brick_vertices[5].x + col, brick_vertices[5].y, brick_vertices[5].z + row, brick_vertices[5].w)
						,point4(brick_vertices[4].x + col, brick_vertices[4].y, brick_vertices[4].z + row, brick_vertices[4].w)
						,point4(brick_vertices[7].x + col, brick_vertices[7].y, brick_vertices[7].z + row, brick_vertices[7].w)
						,point4(brick_vertices[6].x + col, brick_vertices[6].y, brick_vertices[6].z + row, brick_vertices[6].w));
				}
				col += 1.0;
			}
			row -= 1.0;
			col = 0.0;
		}
	}

	void init_shader()
	{
		program  = InitShader("vshader32.glsl", "fshader32.glsl");
		GL_CHECK_ERRORS
	}

	void start_shader()
	{	glEnable(GL_TEXTURE_CUBE_MAP);
		glActiveTexture(GL_TEXTURE2);
		glBindVertexArray( vao );
		glBindBuffer( GL_ARRAY_BUFFER, buffers[0]);
		glBindBuffer( GL_ARRAY_BUFFER, buffers[1]);
		glUseProgram( program );

		uniforms[0] = glGetUniformLocation( program, "ModelView" );
		uniforms[1] = glGetUniformLocation( program, "Projection" );
		uniforms[4] = glGetUniformLocation(program, "vOffset");

		uniforms[2] = glGetAttribLocation(program, "vPosition");
		glEnableVertexAttribArray(uniforms[2]);
		glVertexAttribPointer(uniforms[2], 4, GL_FLOAT, GL_TRUE, sizeof(GLfloat)*4, BUFFER_OFFSET(0) );

		uniforms[3] = glGetAttribLocation(program, "Normal");
		glEnableVertexAttribArray(uniforms[3]);
		glVertexAttribPointer(uniforms[3], 4, GL_FLOAT, GL_TRUE, sizeof(GLfloat)*4, BUFFER_OFFSET(0)  );

		GL_CHECK_ERRORS
		GL_CHECK_ERRORS
	}

	void stop_shader()
	{	glUseProgram(0);
		glBindVertexArray( 0 );
		GL_CHECK_ERRORS
	}

	void init_texture_map()
	{
		GLubyte red[3] = {255, 0, 0};
		GLubyte green[3] = {0, 255, 0};
		GLubyte blue[3] = {0, 0, 255};
		GLubyte cyan[3] = {0, 255, 255};
		GLubyte magenta[3] = {255, 0, 255};
		GLubyte yellow[3] = {255, 255, 0};

		glGenTextures(1, &tex);
		glActiveTexture(GL_TEXTURE2);
		glBindTexture(GL_TEXTURE_CUBE_MAP, tex);
		/*glTexImage2D(GL_TEXTURE_CUBE_MAP_POSITIVE_X ,0,3,1,1,0,GL_RGB,GL_UNSIGNED_BYTE, red);
		glTexImage2D(GL_TEXTURE_CUBE_MAP_NEGATIVE_X ,0,3,1,1,0,GL_RGB,GL_UNSIGNED_BYTE, green);
		glTexImage2D(GL_TEXTURE_CUBE_MAP_POSITIVE_Y ,0,3,1,1,0,GL_RGB,GL_UNSIGNED_BYTE, blue);
		glTexImage2D(GL_TEXTURE_CUBE_MAP_NEGATIVE_Y ,0,3,1,1,0,GL_RGB,GL_UNSIGNED_BYTE, cyan);
		glTexImage2D(GL_TEXTURE_CUBE_MAP_POSITIVE_Z ,0,3,1,1,0,GL_RGB,GL_UNSIGNED_BYTE, magenta);
		glTexImage2D(GL_TEXTURE_CUBE_MAP_NEGATIVE_Z ,0,3,1,1,0,GL_RGB,GL_UNSIGNED_BYTE, yellow);*/

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

	void draw ( GLfloat move[] )
	{
		glPolygonMode (GL_FRONT_AND_BACK, GL_FILL);
			GL_CHECK_ERRORS

		start_shader();

			glUniform4f(uniforms[4], move[0], move[1], move[2], move[3]);
			// ship down the new the projection and viewing matrices
			glUniformMatrix4fv(uniforms[0], 1, GL_TRUE, modelview);
			GL_CHECK_ERRORS

			glUniformMatrix4fv( uniforms[1], 1, GL_TRUE, projection);
			GL_CHECK_ERRORS

			glDrawArrays( GL_TRIANGLES, 0, 48 );
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