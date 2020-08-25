#version 130

in vec3 R;
in vec2 vSR;

uniform sampler2D texMap;

out vec4 FragColor;

void main()
{
	vec4 tMap = texture(texMap, vSR);
	FragColor = 0.000001*vec4(R,1.0) + tMap;
}
