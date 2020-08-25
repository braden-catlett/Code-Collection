package net.sherpin.mediaviewer;

import java.util.Arrays;

import net.sherpin.mediaviewer.classes.LoginAsyncTask;
import net.sherpin.mediaviewer.utility.Global;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.support.v4.app.FragmentManager;
import android.util.Log;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.View.OnKeyListener;
import android.view.ViewGroup;
import android.view.inputmethod.InputMethodManager;
import android.widget.Button;
import android.widget.EditText;

import com.actionbarsherlock.app.SherlockFragment;
import com.facebook.widget.LoginButton;

public class LoginFragment extends SherlockFragment
{
	private FragmentManager manager;

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState)
	{
		Log.e("LOGIN", "OnCreateView");
		View v = inflater.inflate(R.layout.login_frag, container, false);

		LoginButton authButton = (LoginButton) v.findViewById(R.id.facebooklogin);
		authButton.setReadPermissions(Arrays.asList("email"));
		authButton.setFragment(this);

		EditText password = (EditText) v.findViewById(R.id.pwd);
		password.setOnKeyListener(new OnKeyListener()
		{
			public boolean onKey(View v, int arg1, KeyEvent key)
			{
				EditText username = (EditText) getView().findViewById(R.id.username);
				if (key.getKeyCode() == KeyEvent.KEYCODE_ENTER && username.getText().toString().trim() != "")
				{
					String u = username.getText().toString().trim();
					String p = ((EditText) v).getText().toString().trim();

					InputMethodManager imm = (InputMethodManager) getActivity().getSystemService(Context.INPUT_METHOD_SERVICE);
					imm.hideSoftInputFromWindow(v.getWindowToken(), 0);

					login(u, p, "", "", "");
					return true;
				}
				return false;
			}
		});

		Button submit = (Button) v.findViewById(R.id.submit);
		submit.setOnClickListener(new OnClickListener()
		{
			public void onClick(View v)
			{
				EditText username = (EditText) getView().findViewById(R.id.username);
				if (username.getText().toString().trim() != "")
				{
					String u = username.getText().toString().trim();
					String p = ((EditText) getView().findViewById(R.id.pwd)).getText().toString().trim();
					login(u, p, "", "", "");
				}
			}
		});
		
		Button signup = (Button) v.findViewById(R.id.signup);
		signup.setOnClickListener(new OnClickListener()
		{
			public void onClick(View v)
			{
				getActivity().getSupportFragmentManager().beginTransaction().replace(R.id.login_fragmentlayout, new RegisterFragment()).addToBackStack("Register").commit();
			}
		});

		Button guestlogin = (Button) v.findViewById(R.id.guest);
		guestlogin.setOnClickListener(new OnClickListener()
		{
			public void onClick(View v)
			{
				Intent i = new Intent(getActivity().getApplicationContext(), HomeActivity.class);
				i.putExtra(Global.prefIsGuestAccount, true);
				startActivity(i);
				getActivity().finish();
			}
		});

		return v;
	}

	@Override
	public void onActivityCreated(Bundle savedInstanceState)
	{
		super.onActivityCreated(savedInstanceState);

		if (manager == null)
		{
			manager = getFragmentManager();
		}
	}
	
	@Override
	public void onActivityResult(int requestCode, int resultCode, Intent data)
	{
		super.onActivityResult(requestCode, resultCode, data);
		LoginActivity log = (LoginActivity) getSherlockActivity();
		log.giveUiLifeCycleHelperActivityResult(requestCode, resultCode, data);
	}

	private void login(String username, String password, String facebookId, String kws, String email)
	{
		LoginAsyncTask log = new LoginAsyncTask();
		log.username = username;
		log.password = password;
		log.facebookId = facebookId;
		log.kws = kws;
		log.email = email;
		log.context = getSherlockActivity();
		log.execute();
	}
}
