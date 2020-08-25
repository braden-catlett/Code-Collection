package net.sherpin.mediaviewer.classes;

import java.io.BufferedInputStream;
import java.io.UnsupportedEncodingException;
import java.net.URLDecoder;
import java.net.URLEncoder;
import java.util.ArrayList;

import javax.xml.parsers.SAXParser;
import javax.xml.parsers.SAXParserFactory;

import net.sherpin.mediaviewer.HomeActivity;
import net.sherpin.mediaviewer.LoginActivity;
import net.sherpin.mediaviewer.R;
import net.sherpin.mediaviewer.handlers.UserInfo;
import net.sherpin.mediaviewer.utility.Global;
import net.sherpin.mediaviewer.utility.WebUtil;

import org.xml.sax.InputSource;
import org.xml.sax.XMLReader;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.text.TextUtils;
import android.util.Log;
import android.widget.Toast;

public class LoginAsyncTask extends AsyncTask<Void, UserInfo, Void>
{
	public String username;
	public String password;
	public String kws;
	public String email;
	public String facebookId;
	public Context context;

	private boolean facebookLoggedIn;
	private ProgressDialog progress;

	@Override
	protected void onPreExecute()
	{
		super.onPreExecute();
		progress = new ProgressDialog(context);
		progress.setIndeterminate(true);
		progress.setCancelable(false);
		progress.setButton(DialogInterface.BUTTON_NEUTRAL, context.getString(R.string.cancel), new DialogInterface.OnClickListener()
		{
			public void onClick(DialogInterface dialog, int which)
			{
				LoginAsyncTask.this.cancel(true);
			}
		});
		progress.setMessage(context.getString(R.string.loggingin));
		progress.show();
	}

	@Override
	protected Void doInBackground(Void... p)
	{
		UserInfo ui = new UserInfo();
		String encodedUsername = "";
		String encodedPassword = "";
		String encodedKWS = "";
		String encodedEmail = "";
		facebookLoggedIn = !TextUtils.isEmpty(facebookId);
		if (facebookLoggedIn)
		{
			encodedUsername = facebookId;
		}
		else
		{
			try
			{
				encodedUsername = URLEncoder.encode(username, "utf-8");
				encodedPassword = URLEncoder.encode(password, "utf-8");
				encodedKWS = URLEncoder.encode(kws, "utf-8");
				encodedEmail = URLEncoder.encode(email, "utf-8");
			}
			catch (UnsupportedEncodingException e1)
			{
				encodedUsername = username;
				encodedPassword = password;
				encodedKWS = kws;
				encodedEmail = email;
				Log.e("Sherpin Login(287): ", e1.getLocalizedMessage());
			}
		}
		String urlPrefix = "https://www.sherpin.com/xml/xml_login.php";

		ArrayList<Pair> postParameters = new ArrayList<Pair>();

		postParameters.add(new Pair("uname", encodedUsername));

		if (!TextUtils.isEmpty(encodedPassword))
		{
			postParameters.add(new Pair("pwd", encodedPassword));
		}

		if (!TextUtils.isEmpty(encodedKWS))
		{
			postParameters.add(new Pair("kws", encodedKWS));
		}

		if (!TextUtils.isEmpty(encodedEmail))
		{
			postParameters.add(new Pair("email", encodedEmail));
		}

		try
		{
			BufferedInputStream resp = WebUtil.GetHTTPSResponse(urlPrefix, postParameters, context);
			if(resp != null) {
				SAXParserFactory spf = SAXParserFactory.newInstance();
				SAXParser sp = spf.newSAXParser();

				XMLReader rdr = sp.getXMLReader();
				rdr.setContentHandler(ui);

				rdr.parse(new InputSource(resp));
				resp.close();
				publishProgress(ui);
				
				Log.e("LOGIN", "Got Response");
			}
			else {
				Log.e("LOGIN", "Unable to connect Network Issue");
			}
		}
		catch (Exception ex)
		{
			Log.e("LOGIN", "Unable to connect Exception: " + ex.getMessage());
		}
		return null;
	}

	@Override
	protected void onProgressUpdate(UserInfo... values)
	{
		super.onProgressUpdate(values);

		UserInfo ui = values[0];
		if (!TextUtils.isEmpty(ui.id))
		{
			Log.e("LOGIN", "Successful Login: " + ui.id + ", " + (facebookLoggedIn ? username : ui.username) + ", " + password);
			// We have this user info. Store the ID.
			SharedPreferences settings = context.getSharedPreferences(Global.filePrefs, 0);
			SharedPreferences.Editor e = settings.edit();
			
			try {
				username = URLDecoder.decode((facebookLoggedIn ? username : ui.username), "UTF-8");
			} catch (UnsupportedEncodingException e1) {
				e1.printStackTrace();
			}

			e.putString(Global.prefUserID, ui.id);
			e.putString(Global.prefUsername, username);
			e.putString(Global.prefEmail, email);
			if (facebookLoggedIn)
				e.putString(Global.prefFacebookID, username);
			e.putString(Global.prefPassword, password);
			e.commit();

			Intent i = new Intent(context.getApplicationContext(), HomeActivity.class);
			i.putExtra(Global.prefIsGuestAccount, false);
			context.startActivity(i);
			((Activity) context).finish();
		}
		else
		{
			Log.e("LOGIN", "UserID isEmpty: " + ui.id);
			Toast.makeText(context, "Login Failed", Toast.LENGTH_SHORT).show();
		}
		context = null;
	}

	@Override
	protected void onCancelled()
	{
		super.onCancelled();
		progress.dismiss();
		if (context instanceof LoginActivity)
		{
			((LoginActivity) context).onLoginAsyncTaskFinish();
		}
	}

	@Override
	protected void onPostExecute(Void result)
	{
		super.onPostExecute(result);
		progress.dismiss();
		if (context instanceof LoginActivity)
		{
			((LoginActivity) context).onLoginAsyncTaskFinish();
		}
	}
}
