package net.sherpin.mediaviewer;

import net.sherpin.mediaviewer.classes.LoginAsyncTask;
import net.sherpin.mediaviewer.utility.Global;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.text.TextUtils;
import android.util.Log;

import com.actionbarsherlock.app.SherlockFragmentActivity;
import com.facebook.Request;
import com.facebook.Response;
import com.facebook.Session;
import com.facebook.SessionState;
import com.facebook.UiLifecycleHelper;
import com.facebook.model.GraphUser;

public class LoginActivity extends SherlockFragmentActivity
{
	private UiLifecycleHelper uiHelper;
	private Fragment currentFragment;
	private boolean isLoggingIn;

	@Override
	public void onCreate(Bundle savedInstanceState)
	{
		super.onCreate(savedInstanceState);
		com.facebook.AppEventsLogger.activateApp(getApplicationContext(), getString(R.string.app_id));

		Session.StatusCallback callback = new Session.StatusCallback()
		{
			public void call(Session session, SessionState state, Exception exception)
			{
				onSessionStateChange(session, state, exception);
			}
		};
		uiHelper = new UiLifecycleHelper(this, callback);
		uiHelper.onCreate(savedInstanceState);

		SharedPreferences settings = getSharedPreferences(Global.filePrefs, 0);
		if (settings != null && !isFacebookSessionValid())
		{
			String username = settings.getString(Global.prefUsername, "");
			String pass = settings.getString(Global.prefPassword, "");
			
			boolean hasStoredUserInfo = !TextUtils.isEmpty(username) && !TextUtils.isEmpty(pass);
			if (hasStoredUserInfo)
			{
				login(username, pass, "", "", "");
				Log.e("LOGIN", "Activity: On Creating Logging In");
			}
		}

		setContentView(R.layout.login_act);

		if (savedInstanceState == null)
		{
			// Add the fragment on initial activity setup
			currentFragment = new LoginFragment();
			getSupportFragmentManager().beginTransaction().add(R.id.login_fragmentlayout, currentFragment).commit();
		}
		else
		{
			// Or set the fragment from restored state info
			currentFragment = getSupportFragmentManager().findFragmentById(R.id.login_fragmentlayout);
		}
	}

	@Override
	protected void onResume()
	{
		super.onResume();

		// For scenarios where the main activity is launched and user
		// session is not null, the session state change notification
		// may not be triggered. Trigger it if it's open/closed.
		Session session = Session.getActiveSession();
		if (session != null && (session.isOpened() || session.isClosed()))
		{
			onSessionStateChange(session, session.getState(), null);
		}
		uiHelper.onResume();
	}

	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data)
	{
		super.onActivityResult(requestCode, resultCode, data);
		uiHelper.onActivityResult(requestCode, resultCode, data);
	}

	@Override
	protected void onPause()
	{
		super.onPause();
		uiHelper.onPause();
	}

	@Override
	protected void onDestroy()
	{
		super.onDestroy();
		uiHelper.onDestroy();
	}

	@Override
	protected void onSaveInstanceState(Bundle outState)
	{
		super.onSaveInstanceState(outState);
		uiHelper.onSaveInstanceState(outState);
	}

	public void giveUiLifeCycleHelperActivityResult(int requestCode, int resultCode, Intent data)
	{
		uiHelper.onActivityResult(requestCode, resultCode, data);
	}

	private void login(String username, String password, String facebookId, String kws, String email)
	{
		if (!isLoggingIn)
		{
			LoginAsyncTask log = new LoginAsyncTask();
			log.username = username;
			log.password = password;
			log.facebookId = facebookId;
			log.kws = kws;
			log.email = email;
			log.context = this;
			log.execute();

			isLoggingIn = true;
		}
	}

	public void onLoginAsyncTaskFinish()
	{
		isLoggingIn = false;
	}

	private boolean isFacebookSessionValid()
	{
		return com.facebook.Session.getActiveSession() != null
				&& (com.facebook.Session.getActiveSession().getState() == SessionState.OPENED || com.facebook.Session.getActiveSession().getState() == SessionState.OPENING || com.facebook.Session
						.getActiveSession().getState() == SessionState.OPENED_TOKEN_UPDATED);
	}

	private void onSessionStateChange(final Session session, SessionState state, Exception exception)
	{
		if (state.isOpened())
		{
			if (session != null && session.isOpened())
			{
				// If the session is open, make an API call to get user data
				// and define a new callback to handle the response
				Request request = Request.newMeRequest(session, new Request.GraphUserCallback()
				{
					public void onCompleted(GraphUser user, Response response)
					{
						// If the response is successful
						if (session == Session.getActiveSession())
						{
							if (user != null)
							{
								Object email = user.asMap().get("email");
								login(user.getName(), "", user.getId(), "", email != null ? email.toString() : "");
								Log.e("LOGIN", "Activity onSessionStateChanged");
							}
						}
					}
				});
				Request.executeBatchAsync(request);
			}
			Log.i("Login", "Activity Logged in...");
		}
		else if (state.isClosed())
		{
			if (state == SessionState.CLOSED_LOGIN_FAILED)
			{
				SharedPreferences settings = getSharedPreferences(Global.filePrefs, 0);
				if (settings != null)
				{
					String username = settings.getString(Global.prefUsername, "");
					String pass = settings.getString(Global.prefPassword, "");

					boolean hasStoredUserInfo = !TextUtils.isEmpty(username) && !TextUtils.isEmpty(pass);
					if (hasStoredUserInfo)
					{
						login(username, pass, "", "", "");
						Log.e("LOGIN", "Activity On Creating Logging In");
					}
				}
			}
			Log.i("LOGIN", "Activity Logged out... Facebook Status: " + (state == SessionState.CLOSED_LOGIN_FAILED ? "Login Failed" : "Closed"));
		}
	}
}
