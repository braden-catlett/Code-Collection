package net.sherpin.mediaviewer;

import java.io.BufferedInputStream;
import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;
import java.util.ArrayList;

import net.sherpin.mediaviewer.classes.Pair;
import net.sherpin.mediaviewer.utility.Global;
import net.sherpin.mediaviewer.utility.WebUtil;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.text.TextUtils;
import android.util.Log;

import com.actionbarsherlock.app.SherlockActivity;

public class SplashActivity extends SherlockActivity
{
	@Override
	protected void onCreate(Bundle savedInstanceState)
	{
		super.onCreate(savedInstanceState);
		setContentView(R.layout.splash);

		SharedPreferences settings = getSharedPreferences(Global.filePrefs, 0);
		if (settings != null)
		{
			String userid = settings.getString(Global.prefUserID, "");
			String username = settings.getString(Global.prefUsername, "");
			String pass = settings.getString(Global.prefPassword, "");

			boolean hasStoredUser = !TextUtils.isEmpty(username) && !TextUtils.isEmpty(userid);
			if (hasStoredUser)
			{
				dicreetelogin(getApplicationContext(), username, pass);
			}
			else
			{
				startActivity(new Intent(getApplicationContext(), LoginActivity.class));
				finish();
			}
		}
		else
		{
			startActivity(new Intent(getApplicationContext(), LoginActivity.class));
			finish();
		}
	}

	private void dicreetelogin(final Context context, final String username, final String password)
	{
		Thread t = new Thread(new Runnable()
		{
			public void run()
			{
				String encodedUsername = "";
				String encodedPassword = "";
				try
				{
					encodedUsername = URLEncoder.encode(username, "utf-8");
					encodedPassword = URLEncoder.encode(password, "utf-8");
				}
				catch (UnsupportedEncodingException e1)
				{
					encodedUsername = username;
					encodedPassword = password;
					Log.e("DISCRETELOGIN: ", e1.getLocalizedMessage());
				}
				
				String urlPrefix = "https://www.sherpin.com/xml/xml_login.php";
				ArrayList<Pair> postParameters = new ArrayList<Pair>();

				postParameters.add(new Pair("uname", encodedUsername));

				if (!TextUtils.isEmpty(encodedPassword))
				{
					postParameters.add(new Pair("pwd", encodedPassword));
				}

				try
				{
					BufferedInputStream resp = WebUtil.GetHTTPSResponse(urlPrefix, postParameters, context);
					if(resp != null) {
						resp.close();
						Log.e("DISCRETELOGIN", "Got Response");
					}
					else {
						Log.e("DISCRETELOGIN", "No Response");
					}
					
					runOnUiThread(new Runnable()
					{
						public void run()
						{
							startActivity(new Intent(getApplicationContext(), HomeActivity.class));
							finish();
						}
					});
				}
				catch (Exception ex)
				{
					Log.e("DISCRETELOGIN", "Unable to connect Exception: " + ex.getMessage());
					runOnUiThread(new Runnable()
					{
						public void run()
						{
							startActivity(new Intent(getApplicationContext(), LoginActivity.class));
							finish();
						}
					});
				}
			}
		});
		t.start();
	}
}
