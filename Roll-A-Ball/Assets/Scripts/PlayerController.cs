using UnityEngine;
using UnityEngine.UI;
using System.Collections;

public class PlayerController : MonoBehaviour {
	
	public Rigidbody rb;
	public float speed;
	public Text countText;
	public Text winText;
	private int count;

	// Use this for initialization
	void Start () {
		rb = GetComponent<Rigidbody> ();
		count = 0;
		winText.text = "";
		updateCountText();
	}
	
	// Update is called once per frame
	void Update () {
	
	}

	//Called before any physics calcalutions are done
	void FixedUpdate () {
		float moveHorizontal = Input.GetAxis ("Horizontal");
		float moveVertical = Input.GetAxis ("Vertical");
		Vector3 movement = new Vector3 (moveHorizontal, 0.0f, moveVertical);
		rb.AddForce (movement * speed * Time.deltaTime);
	}
	
	void OnTriggerEnter (Collider other) {
		//Destroy(other.gameObject);
		if (other.gameObject.tag == "PickUp") {
			other.gameObject.SetActive (false);
			count++;
			updateCountText();
		}
	}

	void updateCountText() {
		countText.text = "Count: " + count.ToString ();
		if (count >= 13) {
			winText.text = "You Win!";
		}
	}
}
