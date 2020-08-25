package net.sherpin.mediaviewer.utility;

import java.io.BufferedInputStream;
import java.io.BufferedWriter;
import java.io.IOException;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.io.UnsupportedEncodingException;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLEncoder;
import java.security.KeyStore;
import java.util.List;

import javax.net.ssl.HttpsURLConnection;
import javax.net.ssl.SSLContext;
import javax.net.ssl.TrustManagerFactory;

import net.sherpin.mediaviewer.SherpinApplication;
import net.sherpin.mediaviewer.classes.Pair;

import android.content.Context;

public class WebUtil
{
//	public static DefaultHttpClient client = null;
//
//	private static void initializeHttpClient() throws NoSuchAlgorithmException, KeyManagementException, UnrecoverableKeyException, KeyStoreException
//	{
//		SSLSocketFactory ssf = newSslSocketFactory();
////		ssf.setHostnameVerifier((X509HostnameVerifier)SSLSocketFactory.ALLOW_ALL_HOSTNAME_VERIFIER);
////		HttpsURLConnection.setDefaultHostnameVerifier(SSLSocketFactory.ALLOW_ALL_HOSTNAME_VERIFIER);
//		
//		HttpParams params = new BasicHttpParams();
//        HttpProtocolParams.setVersion(params, HttpVersion.HTTP_1_1);
//        HttpProtocolParams.setContentCharset(params, HTTP.UTF_8);
//        
//		SchemeRegistry registry = new SchemeRegistry();
//		registry.register(new Scheme("http", PlainSocketFactory.getSocketFactory(), 80));
//		registry.register(new Scheme("https", ssf, 443));
//
//		ThreadSafeClientConnManager mgr = new ThreadSafeClientConnManager(params, registry);
//		client = new DefaultHttpClient(mgr, params);
//	}
	
//	public static SSLSocketFactory newSslSocketFactory()
//	{
//		try
//		{
//			// Get an instance of the Bouncy Castle KeyStore format
//			KeyStore trusted = SherpinApplication.createCertificateKeystore();
//			
//			// Pass the keystore to the SSLSocketFactory. The factory is responsible
//			// for the verification of the server certificate.
//			SSLSocketFactory sf = new SSLSocketFactory(trusted);
//			
//			// Hostname verification from certificate
//			// http://hc.apache.org/httpcomponents-client-ga/tutorial/html/connmgmt.html#d4e506
//			sf.setHostnameVerifier(SSLSocketFactory.STRICT_HOSTNAME_VERIFIER);
//			return sf;
//		}
//		catch (Exception e)
//		{
//			throw new AssertionError(e);
//		}
//	}
	
	public static SSLContext newHTTPSSslSocketFactory()
	{
		try
		{
			// Get an instance of the Bouncy Castle KeyStore format
			KeyStore trusted = SherpinApplication.createCertificateKeystore();
			String algorithm = TrustManagerFactory.getDefaultAlgorithm();
			TrustManagerFactory tmf = TrustManagerFactory.getInstance(algorithm);
			tmf.init(trusted);
			
			SSLContext context = SSLContext.getInstance("TLS");
			context.init(null, tmf.getTrustManagers(), null);
			return context;
		}
		catch (Exception e)
		{
			throw new AssertionError(e);
		}
	}
	
//	public static void cleanUp() 
//	{
//		if(client != null)
//		{
//			client = null;
//		}
//	}

	public static BufferedInputStream GetHTTPResponse(String address, Context context) throws IOException {
		URL url = new URL(address);
		HttpURLConnection urlConnection = (HttpURLConnection) url.openConnection();

		BufferedInputStream in;
		try {
			in = new BufferedInputStream(urlConnection.getInputStream());
		} catch (IOException e) {
			e.printStackTrace();
			return null;
		} finally {
//			urlConnection.disconnect();
		}
		return in;
	}

	public static BufferedInputStream GetHTTPSResponse(String address, Context context) throws IOException {
		URL url = new URL(address);
		HttpsURLConnection urlConnection = (HttpsURLConnection) url.openConnection();
		urlConnection.setSSLSocketFactory(newHTTPSSslSocketFactory().getSocketFactory());
		
		BufferedInputStream in;
		try {
			in = new BufferedInputStream(urlConnection.getInputStream());
		} catch (IOException e) {
			e.printStackTrace();
			return null;
		} finally {
//			urlConnection.disconnect();
		}
		return in;
	}

	public static BufferedInputStream GetHTTPSResponse(String address, List<Pair> params, Context context) throws IOException {
		URL url = new URL(address);
		HttpsURLConnection urlConnection = (HttpsURLConnection) url.openConnection();
		urlConnection.setSSLSocketFactory(newHTTPSSslSocketFactory().getSocketFactory());
		urlConnection.setUseCaches(false);
		urlConnection.setDoOutput(true);
		urlConnection.setDoInput(true);
		urlConnection.setReadTimeout(10000);
		urlConnection.setConnectTimeout(15000);

		OutputStream os = urlConnection.getOutputStream();
		BufferedWriter writer = new BufferedWriter(new OutputStreamWriter(os, "UTF-8"));
		writer.write(getQuery(params));
		writer.flush();
		writer.close();
		os.close();

		BufferedInputStream in;
		try {
			in = new BufferedInputStream(urlConnection.getInputStream());
		} catch (IOException e) {
			e.printStackTrace();
			return null;
		} finally {
//			urlConnection.disconnect();
		}
		return in;
	}
	
	private static String getQuery(List<Pair> params) throws UnsupportedEncodingException
	{
	    StringBuilder result = new StringBuilder();
	    boolean first = true;

	    for (Pair pair : params)
	    {
	        if (first)
	            first = false;
	        else
	            result.append("&");

	        result.append(URLEncoder.encode(pair.key, "UTF-8"));
	        result.append("=");
	        result.append(URLEncoder.encode(pair.value, "UTF-8"));
	    }

	    return result.toString();
	}
//	public static HttpResponse GetResponse(String url, Context context) throws KeyManagementException, UnrecoverableKeyException, NoSuchAlgorithmException, KeyStoreException
//	{
//		if (client == null)
//		{
//			initializeHttpClient();
//		}
//
//		HttpGet get = new HttpGet(url);
//		HttpResponse response = null;
//		try
//		{
//			response = client.execute(get);
//		}
//		catch (Exception e)
//		{
//			Log.e("WebUtil", "Error during Get: " + e.getLocalizedMessage());
//		}
//		return response;
//	}
//
//	public static HttpResponse PostResponse(String url, Context context) throws KeyManagementException, UnrecoverableKeyException, NoSuchAlgorithmException, KeyStoreException
//	{
//		if (client == null)
//		{
//			initializeHttpClient();
//		}
//
//		HttpPost httpPost = new HttpPost(url);
//		HttpResponse response = null;
//		try
//		{
//			response = client.execute(httpPost);
//		}
//		catch (Exception e)
//		{
//			Log.e("WebUtil", "Error during Post: " + e.getLocalizedMessage());
//		}
//		return response;
//	}
//
//	public static HttpResponse PostResponse(String url, String xml, Context context) throws KeyManagementException, UnrecoverableKeyException, NoSuchAlgorithmException, KeyStoreException
//	{
//		if (client == null)
//		{
//			initializeHttpClient();
//		}
//
//		HttpPost httpPost = new HttpPost(url);
//		HttpResponse response = null;
//		try
//		{
//			httpPost.setEntity(new StringEntity(xml));
//			response = client.execute(httpPost);
//		}
//		catch (Exception e)
//		{
//			Log.e("WebUtil", "Error during Post(xml): " + e.getLocalizedMessage());
//		}
//		return response;
//	}
//
//	public static HttpResponse PostResponse(String url, UrlEncodedFormEntity xml, Context context) throws KeyManagementException, UnrecoverableKeyException, NoSuchAlgorithmException, KeyStoreException
//	{
//		if (client == null)
//		{
//			initializeHttpClient();
//		}
//
//		HttpPost httpPost = new HttpPost(url);
//		HttpResponse response = null;
//		try
//		{
//			httpPost.setEntity(xml);
//			response = client.execute(httpPost);
//		}
//		catch (Exception e)
//		{
//			Log.e("WebUtil", "Error during Post(URLEncodedForm): " + e.getLocalizedMessage());
//		}
//		return response;
//	}
//
//	public static HttpResponse PostResponse(String url, String xml, String contentType, Context context) throws KeyManagementException, UnrecoverableKeyException, NoSuchAlgorithmException, KeyStoreException
//	{
//		if (client == null)
//		{
//			initializeHttpClient();
//		}
//
//		HttpPost httpPost = new HttpPost(url);
//		httpPost.setHeader("Content-type", contentType);
//		HttpResponse response = null;
//		try
//		{
//			if (!TextUtils.isEmpty(xml))
//				httpPost.setEntity(new StringEntity(xml));
//
//			response = client.execute(httpPost);
//		}
//		catch (Exception e)
//		{
//			Log.e("WebUtil", "Error during Post(xml contenttype): " + e.getLocalizedMessage());
//		}
//		return response;
//	}
//
//	public static HttpResponse PostResponse(String url, HttpParams params, Context context) throws KeyManagementException, UnrecoverableKeyException, NoSuchAlgorithmException, KeyStoreException
//	{
//		if (client == null)
//		{
//			initializeHttpClient();
//		}
//
//		client.setParams(params);
//
//		HttpPost httpPost = new HttpPost(url);
//		HttpResponse response = null;
//		try
//		{
//			response = client.execute(httpPost);
//		}
//		catch (Exception e)
//		{
//			Log.e("WebUtil", "Error during Post(params): " + e.getLocalizedMessage());
//		}
//		return response;
//	}

//	public static void storeCookies(SharedPreferences prefs) throws KeyManagementException, UnrecoverableKeyException, NoSuchAlgorithmException, KeyStoreException
//	{
//		if (client == null)
//		{
//			initializeHttpClient();
//		}
//
//		String cookiesJSON = "";
//		for (Cookie c : client.getCookieStore().getCookies())
//		{
//			cookiesJSON += c.getName() + ":" + c.getValue() + "~";
//		}
//		prefs.edit().putString(Global.prefCookies, cookiesJSON);
//	}
//
//	public static void loadCookies(SharedPreferences prefs) throws KeyManagementException, UnrecoverableKeyException, NoSuchAlgorithmException, KeyStoreException
//	{
//		if (client == null)
//		{
//			initializeHttpClient();
//		}
//
//		String[] cookies = prefs.getString(Global.prefCookies, "~").split("~");
//
//		for (String cookie : cookies)
//		{
//			if (cookie.contains(":"))
//			{
//				String[] cookieparts = cookie.split(":");
//				client.getCookieStore().addCookie(new BasicClientCookie(cookieparts[0], cookieparts[1]));
//			}
//		}
//	}
}