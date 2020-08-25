package net.sherpin.mediaviewer;

import java.io.InputStream;
import java.net.CookieHandler;
import java.net.CookieManager;
import java.security.KeyStore;

import org.acra.ACRA;
import org.acra.ReportingInteractionMode;
import org.acra.annotation.ReportsCrashes;

import android.app.Application;
import android.content.Context;

@ReportsCrashes(formKey = "", 
				mailTo = "bcatlett-rossen14@my.whitworth.edu",
				mode = ReportingInteractionMode.TOAST,
				resToastText = R.string.acra_notification_text)
				
public class SherpinApplication extends Application 
{
	private static Context context;
	
	@Override
	public void onCreate() 
	{
		super.onCreate();
		ACRA.init(this);
		context = getApplicationContext();
		
		CookieManager cookieManager = new CookieManager();  
		CookieHandler.setDefault(cookieManager);
	}
	
	public static KeyStore createCertificateKeystore()
	{
		try
		{
			final KeyStore ks = KeyStore.getInstance("BKS");

			// the bks file we generated above
			final InputStream in = context.getResources().openRawResource(R.raw.sherpinkeystore);
			try
			{
				ks.load(in, context.getString(R.string.sherpin_storepassword).toCharArray());
			}
			finally
			{
				in.close();
			}

			return ks;

		}
		catch (Exception e)
		{
			throw new RuntimeException(e);
		}
	}
}