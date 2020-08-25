package net.sherpin.mediaviewer;

import java.io.BufferedInputStream;
import java.util.ArrayList;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

import net.sherpin.mediaviewer.classes.Pair;
import net.sherpin.mediaviewer.utility.WebUtil;

import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.Toast;

import com.actionbarsherlock.app.SherlockFragment;

public class FeedbackFragment extends SherlockFragment
{

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState)
	{
		View v = inflater.inflate(R.layout.feedback, null);
		View submit = v.findViewById(R.id.submit);
		submit.setOnClickListener(new OnClickListener()
		{
			public void onClick(View v)
			{
				LinearLayout main = (LinearLayout) v.getParent();
				
				String name = ((EditText)main.findViewById(R.id.name)).getText().toString();
				String email = ((EditText)main.findViewById(R.id.email)).getText().toString();
				String comment = ((EditText)main.findViewById(R.id.comment)).getText().toString();
				
				if(!isEmailValid(email)) {
					Toast.makeText(getSherlockActivity(), getString(R.string.invalid_email), Toast.LENGTH_LONG).show();
					return;
				}
				
				// Get the Video titles from the server
				final String urlFeedback = "https://www.sherpin.com/xml/xml_addfeedback.php?";
				
				final ArrayList<Pair> postParameters = new ArrayList<Pair>();
				postParameters.add(new Pair("n", name));
				postParameters.add(new Pair("e", email));
				postParameters.add(new Pair("c", comment));
				
				Thread t = new Thread(new Runnable()
				{
					public void run()
					{
						try
						{
							BufferedInputStream resp = WebUtil.GetHTTPSResponse(urlFeedback, postParameters, getActivity());
							if(resp != null) {
								resp.close();
								Log.e("SHERPIN_FEEDBACK", "Got Response");
							}
							else {
								Log.e("SHERPIN_FEEDBACK", "No Response");
							}
						}
						catch (Exception e)
						{
							Log.e("SHERPIN_FEEDBACK","Error submitting feedback ERROR: " + e.getMessage());
						}
						
						FeedbackFragment.this.getActivity().runOnUiThread(new Runnable()
						{
							public void run()
							{
								getFragmentManager().popBackStack();
							}
						});
					}
				});
				t.start();
				
			}
		});
		return v;
	}
	
	public static boolean isEmailValid(String email) 
	{
	    boolean isValid = false;

	    String expression = "^[\\w\\.-]+@([\\w\\-]+\\.)+[A-Z]{2,4}$";
	    CharSequence inputStr = email;

	    Pattern pattern = Pattern.compile(expression, Pattern.CASE_INSENSITIVE);
	    Matcher matcher = pattern.matcher(inputStr);
	    if (matcher.matches()) {
	        isValid = true;
	    }
	    return isValid;
	}
}
