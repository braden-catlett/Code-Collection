package net.sherpin.mediaviewer;

import java.io.BufferedInputStream;
import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.util.ArrayList;

import net.sherpin.mediaviewer.classes.Pair;
import net.sherpin.mediaviewer.classes.VideoItem;
import net.sherpin.mediaviewer.utility.Global;
import net.sherpin.mediaviewer.utility.WebUtil;

import android.annotation.SuppressLint;
import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.res.Configuration;
import android.graphics.Bitmap;
import android.media.AudioManager;
import android.os.AsyncTask;
import android.os.Bundle;
import android.text.TextUtils;
import android.util.DisplayMetrics;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.Window;
import android.webkit.WebChromeClient;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.Button;
import android.widget.Toast;

import com.actionbarsherlock.app.ActionBar;
import com.actionbarsherlock.app.SherlockFragmentActivity;

public class VideoViewerActivity extends SherlockFragmentActivity
{
	private WebView webview;
	private VideoItem currentVideoItem;

//	@Override
//	public boolean onCreateOptionsMenu(com.actionbarsherlock.view.Menu menu)
//	{
//		menu.add(0, Global.MENU_RELOAD, 0, "Reload");
//		return super.onCreateOptionsMenu(menu);
//	}
//
//	@Override
//	public boolean onOptionsItemSelected(com.actionbarsherlock.view.MenuItem item)
//	{
//		switch (item.getItemId())
//		{
//		case Global.MENU_RELOAD:
//			webview.reload();
//			return true;
//		}
//		return super.onOptionsItemSelected(item);
//	}

	@SuppressLint("SetJavaScriptEnabled")
	@Override
	public void onCreate(Bundle savedInstanceState)
	{
		this.requestWindowFeature(Window.FEATURE_PROGRESS);
		super.onCreate(savedInstanceState);
		this.setContentView(R.layout.video_view);

		currentVideoItem = new VideoItem();
		currentVideoItem.objectify(this.getIntent().getStringExtra(Global.currentVideoItem));
		// DisplayMetrics m = getResources().getDisplayMetrics();

		this.setProgressBarIndeterminateVisibility(true);
		this.setProgressBarIndeterminate(true);

		webview = (WebView) this.findViewById(R.id.videowebview);

		webview.getSettings().setJavaScriptEnabled(true);
		webview.getSettings().setJavaScriptCanOpenWindowsAutomatically(true);
		webview.getSettings().setUseWideViewPort(true);
		webview.getSettings().setLoadWithOverviewMode(true);
//		webview.getSettings().setPluginState(WebSettings.PluginState.ON);
		// webview.getSettings().setUserAgent(0);
		webview.setScrollBarStyle(View.SCROLLBARS_OUTSIDE_OVERLAY);
		webview.setScrollbarFadingEnabled(false);

		webview.setWebChromeClient(new WebChromeClient()
		{
			@Override
			public void onProgressChanged(WebView view, int progress)
			{

			}
		});

		webview.setWebViewClient(new WebViewClient()
		{
			@Override
			public void onReceivedError(WebView view, int errorCode, String description, String failingUrl)
			{
				Toast.makeText(VideoViewerActivity.this, "Error: " + description, Toast.LENGTH_SHORT).show();
			}

			@Override
			public boolean shouldOverrideUrlLoading(WebView view, String url)
			{
				webview.loadUrl(url);
				return true;
			}

			@Override
			public void onPageStarted(WebView view, String url, Bitmap favicon)
			{
				super.onPageStarted(view, url, favicon);
			}

			@Override
			public void onPageFinished(WebView view, String url)
			{
				super.onPageFinished(view, url);
				VideoViewerActivity.this.setProgressBarIndeterminateVisibility(false);
			}
		});

		// audio = (AudioManager) getSystemService(Context.AUDIO_SERVICE);
		setVolumeControlStream(AudioManager.STREAM_MUSIC);

		Button pin = (Button) findViewById(R.id.pin);
		pin.setBackgroundResource(currentVideoItem.pinned ? R.drawable.pinned : R.drawable.unpinned);
		pin.setOnClickListener(new OnClickListener()
		{
			public void onClick(View v)
			{
				currentVideoItem.pinned = !currentVideoItem.pinned;
				v.setBackgroundResource(currentVideoItem.pinned ? R.drawable.pinned : R.drawable.unpinned);

				Thread t = new Thread(new Runnable()
				{
					public void run()
					{
						ArrayList<Pair> postParameters = new ArrayList<Pair>();

						postParameters.add(new Pair("ProfID", currentVideoItem.ProfID));
						postParameters.add(new Pair("VideoID", currentVideoItem.ID));
						postParameters.add(new Pair("Pin", currentVideoItem.pinned ? "1" : "0"));

						try
						{
							final String urlPin = "https://www.sherpin.com/xml/xml_pinvideo.php";
							BufferedInputStream resp = WebUtil.GetHTTPSResponse(urlPin, postParameters, getApplicationContext());
							if(resp != null) {
								resp.close();
								Log.e("PINSHERPA", "Got Response");
							}
							else {
								Log.e("PINSHERPA", "No Response");
							}
						}
						catch (Exception ex)
						{
							Log.e("PINSHERPA", "Pin: " + ex.getMessage());
						}
					}
				});
				t.start();
			}
		});
		Button detailbutton = (Button) findViewById(R.id.VideoDetail);
		if(detailbutton != null) 
		{
			detailbutton.setOnClickListener(new OnClickListener()
			{
				public void onClick(View v)
				{
					AlertDialog.Builder builder = new AlertDialog.Builder(v.getContext());
					builder.setTitle(getString(R.string.Details));
					final String[] items = new String[3];
					items[0] = (getString(R.string.title) + ": " + currentVideoItem.Title);
					items[1] = (getString(R.string.description) + ": " + currentVideoItem.Desc);
//					items[2] = ("URL: " + currentVideoItem.URL);
	
					builder.setItems(items, new DialogInterface.OnClickListener()
					{
						public void onClick(DialogInterface dialog, int item)
						{
							//Toast.makeText(getApplicationContext(), items[item], Toast.LENGTH_LONG).show();
						}
					});
					AlertDialog alert = builder.create();
					alert.show();
				}
			});
		}
	}

	@Override
	protected void onResume()
	{
		super.onResume();
		loadVideoUrl();
		
		ActionBar bar = getSupportActionBar();
		if (getResources().getConfiguration().orientation == Configuration.ORIENTATION_LANDSCAPE)
		{
			bar.hide();
		}
		else
		{
			bar.show();
		}
	}

	// @Override
	// public boolean onKeyDown(int keyCode, KeyEvent event)
	// {
	// switch (keyCode)
	// {
	// case KeyEvent.KEYCODE_VOLUME_UP:
	// // audio.adjustStreamVolume(AudioManager.STREAM_MUSIC,
	// AudioManager.ADJUST_RAISE, AudioManager.FLAG_SHOW_UI);
	// return true;
	// case KeyEvent.KEYCODE_VOLUME_DOWN:
	// // audio.adjustStreamVolume(AudioManager.STREAM_MUSIC,
	// AudioManager.ADJUST_LOWER, AudioManager.FLAG_SHOW_UI);
	// return true;
	// default:
	// return super.onKeyDown(keyCode, event);
	// }
	// }

	@Override
	protected void onPause()
	{
		super.onPause();
	}

	@Override
	protected void onStop()
	{
		super.onStop();
	}

	@Override
	protected void onDestroy()
	{
		super.onDestroy();
		webview.destroy();
	}

	@Override
	public void onConfigurationChanged(Configuration newConfig)
	{
		super.onConfigurationChanged(newConfig);
	}

	private void loadVideoUrl()
	{
		String videoUrl = currentVideoItem.URL;
		if (!TextUtils.isEmpty(videoUrl))
		{
			if (webview.getVisibility() == View.INVISIBLE)
				webview.setVisibility(View.VISIBLE);

			// DisplayMetrics m =
			// getSherlockActivity().getResources().getDisplayMetrics();
			// int height = (int) (m.heightPixels / m.density) -
			// getSherlockActivity().getSupportActionBar().getHeight();// -
			// ((RelativeLayout)
			// getView().findViewById(R.id.videolayout)).getHeight();//getView().getHeight();
			// int width = (int) (m.widthPixels /
			// m.density);//getView().getWidth();
			// String showvideoCompleteURL =
			// "https://www.sherpin.com/showvideo.php?id=" + currentVideoItem.ID
			// + "&click=1&share=0&header=0";
			// String iframe = "iframe id='imgVideo' frameborder='0' width='" +
			// width + "' height='" + height + "' src='" + showvideoCompleteURL
			// + "'";
			// webview.loadDataWithBaseURL(videoUrl,
			// String.format(Global.htmlMetaTag, "<" + iframe + "/>"),
			// "text/html", "utf-8", null);

			new AsyncTask<Void, Void, String>()
			{
				@SuppressWarnings("deprecation")
				@Override
				protected String doInBackground(Void... params)
				{
					String showvideoURL = "https://www.sherpin.com/showvideo.php";
					ArrayList<Pair> postParameters = new ArrayList<Pair>();
					StringBuilder total = new StringBuilder();
					try
					{
						// Add parameters for the showvideo.php request
						postParameters.add(new Pair("id", currentVideoItem.ID));
						// postParameters.add(new Pair("click", "1"));
						// postParameters.add(new Pair("share", "0"));
						postParameters.add(new Pair("header", "0"));

						BufferedInputStream in = WebUtil.GetHTTPSResponse(showvideoURL, postParameters, getApplicationContext());
						BufferedReader r = new BufferedReader(new InputStreamReader(in));
						String line;
						while ((line = r.readLine()) != null)
						{
							total.append(line);
						}
					}
					catch (Exception ex)
					{
						Log.e("ShowVideo", "showvideo error: " + ex.getMessage());
					}
					return total.toString();
				}

				@Override
				protected void onPostExecute(String html)
				{
					if (webview != null)
					{
						DisplayMetrics m = new DisplayMetrics();
						getWindowManager().getDefaultDisplay().getMetrics(m);
//						int height = m.heightPixels;
						int width = m.widthPixels;
						int height = findViewById(R.id.videowebview).getHeight();
//						int width = (int) (findViewById(R.id.videowebview)).getWidth();
//						html = html.replace("<body id=\"showvideo\" onload=\"setvideosize()\" style=\"margin-left:auto;margin-right:auto;text-align:center\">", "<body id=\"showvideo\" onload=\"setvideosize()\" style=\"margin-left:auto;margin-right:auto;text-align:center;background:url('/Images/background.png') no-repeat center center fixed;\">");
						html = html.replace("function getvideoheight", "function h$$$");
						html = html.replace("function getvideowidth", "function w$$$");
						html = html.replace("getvideoheight()", String.valueOf(height));
						html = html.replace("getvideowidth()", String.valueOf(width));
						html = html.replace("function h$$$", "function getvideoheight");
						html = html.replace("function w$$$", "function getvideowidth");
						html = html.replace("w=466&h=263", "w=" + width + "&h=" + height);
						html = html.replace("<iframe", "<iframe height=\"" + height + "\" width=\"" + width + "\"");
						html = html.replace("<head>", "<head><meta name=\"viewport\" content=\"width=device-width\">");
						
						// If we are loading a youtube then we need to alter the css on the iframe
//						if (currentVideoItem.URL.contains("youtube.com"))
//						{
//							html = html.replace("style=\"margin-left:auto;margin-right:auto\"", "style=\"margin-left:auto;margin-right:auto;height:" + height + "px;width:" + width
//									+ "px\"");
//						}
						// //Only change the margins if in portrait
						// else if(orientation ==
						// Configuration.ORIENTATION_PORTRAIT)
						// {
						// html =
						// html.replace("margin-left:auto;margin-right:auto;",
						// "margin-bottom:0px;");
						// }

						webview.loadDataWithBaseURL("https://www.sherpin.com/showvideo.php", html, "text/html", "utf-8", null);
					}
					super.onPostExecute(html);
				}

			}.execute();

			// Fragment currentFragment =
			// getFragmentManager().findFragmentById(R.id.home_fragmentlayout);
			// if (videoUrl.contains("youtube.com") && !(currentFragment
			// instanceof YouTubePlayerSupportFragment))
			// {
			// launchYoutubeVideo();
			// }
			// else
			// {
			// DisplayMetrics m =
			// getSherlockActivity().getResources().getDisplayMetrics();
			// int height = (int) (m.heightPixels / m.density) -
			// getSherlockActivity().getSupportActionBar().getHeight();// -
			// ((RelativeLayout)
			// getView().findViewById(R.id.videolayout)).getHeight();//getView().getHeight();
			// int width = (int) (m.widthPixels /
			// m.density);//getView().getWidth();
			// if (videoUrl.contains("<script"))
			// {
			// int begin = videoUrl.indexOf("src=\"") + 5;
			// int end = videoUrl.indexOf("\">", begin);
			// String Url = videoUrl.substring(begin, end);
			// webview.loadDataWithBaseURL(Url,
			// String.format(Global.htmlMetaTag, Global.htmlshowvideoIframeHTML
			// + videoUrl.replace("h=263", "h=" +
			// m.heightPixels).replace("w=466", "w=" + m.widthPixels) +
			// "</iframe>"),
			// "text/html", "utf-8", null);
			// }
			// else if(videoUrl.contains("src=\""))
			// {
			// webview.loadDataWithBaseURL(videoUrl.split("src=\"")[1].replace("\"",
			// ""), String.format(Global.htmlMetaTag,
			// videoUrl.replace("height=\"270\"", "height='" + height +
			// "'").replace("width=\"480\"", "width='" + width + "'")),
			// "text/html", "utf-8", null);
			// }
			// else
			// {
			// String iframe = "iframe id='imgVideo' frameborder='0' width='" +
			// width + "' height='" + height + "' src='" + videoUrl + "'";
			// webview.loadDataWithBaseURL(videoUrl,
			// String.format(Global.htmlMetaTag, "<" + iframe + "/>"),
			// "text/html", "utf-8", null);
			// }
			// }
			// Log.e("SHERPIN", "url is " + videoUrl);
		}
	}
}
