#ifndef TEXTURE_H
#define TEXTURE_H
/**********************************************************
 *
 * VARIABLES DECLARATION
 *
 *********************************************************/

// Counter to keep track of the last loaded texture
extern int num_texture;

/**********************************************************
 *
 * FUNCTION MyLoadBitmap(char *)
 *
 * This function loads a bitmap file and return the OpenGL reference ID to use that texture
 *
 *********************************************************/
extern int MyLoadCubeMapBitmap(char *filename, GLenum  target );
extern int MyLoadBitmap(char *filename, GLenum  target, bool alphablend);
extern int MyLoadBitmap(char *filename, GLenum  target );
#endif