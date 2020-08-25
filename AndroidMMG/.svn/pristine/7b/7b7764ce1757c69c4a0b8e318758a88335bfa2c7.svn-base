package net.sherpin.mediaviewer;

import java.io.BufferedInputStream;
import java.util.ArrayList;

import javax.xml.parsers.SAXParser;
import javax.xml.parsers.SAXParserFactory;

import net.sherpin.mediaviewer.classes.Pair;
import net.sherpin.mediaviewer.handlers.UserInfo;
import net.sherpin.mediaviewer.utility.Global;
import net.sherpin.mediaviewer.utility.WebUtil;

import org.xml.sax.InputSource;
import org.xml.sax.XMLReader;

import android.app.AlertDialog;
import android.app.AlertDialog.Builder;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.text.TextUtils;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.view.inputmethod.InputMethodManager;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.actionbarsherlock.app.SherlockFragment;

public class RegisterFragment extends SherlockFragment
{
	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState)
	{
		View v = inflater.inflate(R.layout.register, container, false);
		Button btn = (Button) v.findViewById(R.id.btnregister);
		btn.setOnClickListener(new OnClickListener()
		{
			public void onClick(View arg0)
			{
				EditText eEmail = (EditText) getView().findViewById(R.id.email);
				EditText eUser = (EditText) getView().findViewById(R.id.username);
				EditText ePwd = (EditText) getView().findViewById(R.id.pwd);
				EditText eConfirmPwd = (EditText) getView().findViewById(R.id.confirm_pwd);

				final String email = eEmail.getText().toString();
				final String user = eUser.getText().toString();
				final String pwd = ePwd.getText().toString();
				final String confirm = eConfirmPwd.getText().toString();

				if (TextUtils.isEmpty(email))
				{
					// State that they need a username
					AlertDialog.Builder b = new Builder(getSherlockActivity());
					b.setTitle(getString(R.string.email));
					b.setMessage(getString(R.string.reg_noemail));
					b.create().show();
					return;
				}

				if (TextUtils.isEmpty(user))
				{
					// State that they need a username
					AlertDialog.Builder b = new Builder(getSherlockActivity());
					b.setTitle(getString(R.string.register));
					b.setMessage(getString(R.string.reg_nousername));
					b.create().show();
					return;
				}

				if (TextUtils.isEmpty(pwd))
				{
					// State that they need a password
					AlertDialog.Builder b = new Builder(getSherlockActivity());
					b.setTitle(getString(R.string.register));
					b.setMessage(getString(R.string.reg_nopassword));
					b.create().show();
					return;
				}

				if (TextUtils.isEmpty(confirm) || (!TextUtils.isEmpty(confirm) && pwd.compareTo(confirm) != 0))
				{
					// The passwords need to match
					AlertDialog.Builder b = new Builder(getSherlockActivity());
					b.setTitle(getString(R.string.register));
					b.setMessage(getString(R.string.reg_nomismatchpassword));
					b.create().show();
					return;
				}

				Thread t = new Thread(new Runnable()
				{
					public void run()
					{
						final UserInfo ui = new UserInfo();
						String urlPrefix = "https://www.sherpin.com/xml/xml_login.php";

						ArrayList<Pair> postParameters = new ArrayList<Pair>();

						postParameters.add(new Pair("uname", user));

						if (!TextUtils.isEmpty(pwd))
						{
							postParameters.add(new Pair("pwd", pwd));
						}

						if (!TextUtils.isEmpty(email))
						{
							postParameters.add(new Pair("email", email));
						}

						try
						{
							
							BufferedInputStream resp = WebUtil.GetHTTPSResponse(urlPrefix, postParameters, getSherlockActivity());
							if(resp != null) {
								SAXParserFactory spf = SAXParserFactory.newInstance();
								SAXParser sp = spf.newSAXParser();

								XMLReader rdr = sp.getXMLReader();
								rdr.setContentHandler(ui);

								rdr.parse(new InputSource(resp));
								resp.close();
								Log.e("Register", "Got Response");
							}
							else {
								Log.e("Register", "No Response");
							}
						}
						catch (Exception ex)
						{
							Log.e("Register", "Error talking to server: " + ex.getLocalizedMessage());
						}

						getActivity().runOnUiThread(new Runnable()
						{
							public void run()
							{
								if (ui.id != null)
								{
									// We have this user info. Store the ID.
									SharedPreferences settings = getActivity().getSharedPreferences(Global.filePrefs, 0);
									SharedPreferences.Editor e = settings.edit();
									e.putString(Global.prefUserID, ui.id);
									e.putString(Global.prefUsername, ui.username);
									e.putString(Global.prefEmail, email);
									e.putString(Global.prefPassword, pwd);
									e.commit();

									startActivity(new Intent(getSherlockActivity(), HomeActivity.class));
									getSherlockActivity().finish();
								}
								else
								{
									// error occurred
									if (!TextUtils.isEmpty(ui.error))
									{
										Toast.makeText(getSherlockActivity(), getString(R.string.username_taken), Toast.LENGTH_LONG).show();
									}
									else
									{
										Toast.makeText(getSherlockActivity(), getString(R.string.register_fail), Toast.LENGTH_LONG).show();
									}
									Log.e("Register", "Register Failed " + ui.error);
								}
							}
						});
					}
				});
				t.start();
			}
		});

		return v;
	}

	@Override
	public void onPause()
	{
		EditText eEmail = (EditText) getView().findViewById(R.id.email);
		EditText eUser = (EditText) getView().findViewById(R.id.username);
		EditText ePwd = (EditText) getView().findViewById(R.id.pwd);
		EditText eConfirmPwd = (EditText) getView().findViewById(R.id.confirm_pwd);

		InputMethodManager imm = (InputMethodManager) getSherlockActivity().getSystemService(Context.INPUT_METHOD_SERVICE);
		imm.hideSoftInputFromWindow(eEmail.getWindowToken(), 0);
		imm.hideSoftInputFromWindow(eUser.getWindowToken(), 0);
		imm.hideSoftInputFromWindow(ePwd.getWindowToken(), 0);
		imm.hideSoftInputFromWindow(eConfirmPwd.getWindowToken(), 0);
		super.onPause();
	}

}
