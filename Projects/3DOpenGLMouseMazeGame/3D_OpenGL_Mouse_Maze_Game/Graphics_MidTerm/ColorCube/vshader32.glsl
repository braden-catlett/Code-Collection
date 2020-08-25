#version 130
in  vec4 vPosition;
in  vec4 Normal;

uniform mat4 ModelView;
uniform mat4 Projection;
uniform vec4 vOffset;

out vec3 R;

void main()
{
	vec4 angles = radians( vOffset );
	vec4 c = cos( angles );
	vec4 s = sin( angles );

	mat4 scale = mat4(0.5, 0.0, 0.0, 0.0,
					  0.0, 0.5, 0.0, 0.0,
					  0.0, 0.0, 0.5, 0.0,
					  0.0, 0.0, 0.0, 1.0);
				
	mat4 ry = mat4( c.w, 0.0, -s.w, 0.0,      // first column
					0.0, 1.0,  0.0, 0.0,	  // second column
					s.w, 0.0,  c.w, 0.0,	  // third column 
					0.0, 0.0,  0.0, 1.0 );	  // fourth column

	mat4 tran = mat4(1.0,		0.0,		0.0,	  0.0,
					0.0,		1.0,		0.0,	  0.0,
					0.0,		0.0,		1.0,	  0.0,
					vOffset.x, vOffset.y, vOffset.z, 1.0);

	gl_Position = /*Projection*ModelView*scale*tran*/ry*vPosition/vPosition.w;

	// Option 1 - Cube is textured
	R = Normal.xyz;

	// Option 2 - Cube is a mirror and reflects a cube environment
	// vec4 eyePos  = ModelView*vPosition;
	// vec4 NN = ModelView*Normal;
	// vec3 N = NN.xyz;
	// R = reflect(eyePos.xyz, N);

}
