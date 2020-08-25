using UnityEngine;
using System.Collections;

public class CameraController : MonoBehaviour {
	public GameObject player;
	private Vector3 offset;

	// Use this for initialization
	void Start () {
		//This basically the starting position
		offset = transform.position;
	}
	
	// Update is called once per frame
	void LateUpdate () {
		//So we update the transform position to the player position plus the starting position 
		transform.position = player.transform.position + offset;
	}
}
