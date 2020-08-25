#version 130
in  vec4 vPosition;
in  vec4 Normal;
in	vec2 vMapCoord;

uniform mat4 ModelView;
uniform mat4 Projection;
uniform vec4 vOffset;

out vec3 R;
out vec2 vSR;

void main()
{
	vec4 angles = radians( vOffset );
	vec4 c = cos( angles );
	vec4 s = sin( angles );

	mat4 scale = mat4(1.0, 0.0, 0.0, 0.0,
					  0.0, 1.0, 0.0, 0.0,
					  0.0, 0.0, 1.0, 0.0,
					  0.0, 0.0, 0.0, 1.0);
				
	mat4 ry = mat4( c.w, 0.0, -s.w, 0.0,      // first column
					0.0, 1.0,  0.0, 0.0,	  // second column
					s.w, 0.0,  c.w, 0.0,	  // third column 
					0.0, 0.0,  0.0, 1.0 );	  // fourth column

	mat4 tran = mat4(1.0,		0.0,		0.0,	  0.0,
					0.0,		1.0,		0.0,	  0.0,
					0.0,		0.0,		1.0,	  0.0,
					vOffset.x, vOffset.y, vOffset.z, 1.0);

	gl_Position = Projection*ModelView*scale*ry*tran*vPosition;

	R = (Projection*ModelView*ry*Normal).xyz;

	vSR = vMapCoord;
}
