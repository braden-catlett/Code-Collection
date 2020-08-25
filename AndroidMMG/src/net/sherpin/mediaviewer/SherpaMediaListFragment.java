package net.sherpin.mediaviewer;

import java.io.BufferedInputStream;
import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;

import javax.xml.parsers.SAXParser;
import javax.xml.parsers.SAXParserFactory;

import net.sherpin.mediaviewer.classes.FoundVideoAdapter;
import net.sherpin.mediaviewer.classes.VideoItem;
import net.sherpin.mediaviewer.handlers.VideoListHandler;
import net.sherpin.mediaviewer.utility.Global;
import net.sherpin.mediaviewer.utility.WebUtil;

import org.xml.sax.InputSource;
import org.xml.sax.XMLReader;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Intent;
import android.graphics.Color;
import android.os.Bundle;
import android.text.TextUtils;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ListView;
import android.widget.TextView;

import com.actionbarsherlock.app.SherlockFragment;

/*
 * Main class
 * 
 * Shows the media list for the user to choose from
 * Listens for a list item to be chosen. When chosen,
 * this will create a new view with that media and
 * a button to return to this view.
 */
public class SherpaMediaListFragment extends SherlockFragment
{
	private VideoListHandler vlhandler = new VideoListHandler();
	private String profileid;
	private String profileTitle;
	private String profileDesc;
	private String searchQuery;

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState)
	{
		View v = inflater.inflate(R.layout.sherpamedialist, container, false);
		return v;
	}

	/** Called when the activity is first created. */
	@Override
	public void onCreate(Bundle savedInstanceState)
	{
		super.onCreate(savedInstanceState);

		Bundle d = this.getArguments();
		profileid = d.getString(Global.prefProfileID);
		profileTitle = d.getString(Global.prefProfileTitle);
		profileDesc = d.getString(Global.prefProfileDesc);
		searchQuery = d.getString(Global.prefSearchQuery);

		final ProgressDialog progress = ProgressDialog.show(getSherlockActivity(), "", "Downloading...", true);
		progress.setCancelable(true);
		new Thread(new Runnable()
		{
			public void run()
			{
				populateVideoList();
				getSherlockActivity().runOnUiThread(new Runnable()
				{
					public void run()
					{
						showVideoList();
						progress.dismiss();
					}
				});
			}
		}).start();
	}

	public void populateVideoList()
	{
		String urlVideoList;
		if (!TextUtils.isEmpty(searchQuery))
		{
			String encodedQuery;
			try {
				encodedQuery = URLEncoder.encode(searchQuery, "UTF-8");
			} catch (UnsupportedEncodingException e) {
				encodedQuery = searchQuery;
			}
			urlVideoList = String.format("https://www.sherpin.com/xml/xml_quicksearch.php?Search=%s&Mobile=2&StartRow=0&RowLimit=200", encodedQuery);
		}
		else
		{
			urlVideoList = String.format("https://www.sherpin.com/xml/xml_videolist.php?ProfID=%s&Mobile=2&StartRow=0", profileid);
		}

		try
		{
			BufferedInputStream resp = WebUtil.GetHTTPSResponse(urlVideoList, getSherlockActivity());
			if(resp != null) {
				SAXParserFactory spf = SAXParserFactory.newInstance();
				SAXParser sp = spf.newSAXParser();

				XMLReader rdr = sp.getXMLReader();
				vlhandler.clearItems();
				rdr.setContentHandler(vlhandler);

				rdr.parse(new InputSource(resp));
				resp.close();
				Log.e(Global.tagHTTPGET, "Got Response");
			}
			else {
				Log.e(Global.tagHTTPGET, "No Response");
			}
		}
		catch (Exception ex)
		{
			Log.e(Global.tagHTTPGET, ex.getMessage());
		}
	}

	private void showVideoList()
	{
		try
		{
			TextView profiletitle = (TextView) getView().findViewById(R.id.profiletitle);
			if (!TextUtils.isEmpty(searchQuery))
			{
				profiletitle.setText("Results for " + searchQuery);
			}
			else
			{
				profiletitle.setText(profileTitle + ": " + profileDesc);
			}

			// Put the items in the List<Video> into the ListView
			ListView lvMedia = (ListView) getView().findViewById(R.id.medialistview);
			lvMedia.setAdapter(new FoundVideoAdapter(getSherlockActivity(), R.layout.videolist_item, vlhandler.getVideos()));
			lvMedia.setCacheColorHint(Color.parseColor("#BCD2EE"));
			lvMedia.setOnItemClickListener(new OnMediaListItemListener());
		}
		catch (Exception ex)
		{
			Log.e(Global.tagHTTPGET, "showVideoList Exception: " + ex.getMessage());
		}
	}

	// Listen for results.
	@Override
	public void onActivityResult(int requestCode, int resultCode, Intent data)
	{
		// See which child activity is calling us back.
		switch (requestCode)
		{
		case Global.REQ_REFRESH:
			if (resultCode == Activity.RESULT_OK)
			{
				final ProgressDialog progress = ProgressDialog.show(getSherlockActivity(), "", "Updating Video List...", true);
				progress.setCancelable(true);
				new Thread(new Runnable()
				{
					public void run()
					{
						populateVideoList();
						getSherlockActivity().runOnUiThread(new Runnable()
						{
							public void run()
							{
								showVideoList();
								progress.dismiss();
							}
						});
					}
				}).start();
			}
			break;
		default:
			break;
		}
	}

	// Listens for an item in the ListView to be chosen.
	// When clicked, play that video in a new view
	class OnMediaListItemListener implements OnItemClickListener
	{
		public void onItemClick(AdapterView<?> parent, View view, int position, long id)
		{
			try
			{
				VideoItem vi = vlhandler.getVideo((int) id);
				Intent intent = null;
				intent = new Intent(getSherlockActivity(), VideoViewerActivity.class);
				intent.putExtra(Global.currentVideoItem, vi.stringify());
				startActivity(intent);
			}
			catch (Exception ex)
			{
				Log.e("Sherpin", String.format("Error %s", ex.getMessage()));
			}
		}
	}
}