package net.sherpin.mediaviewer.views;

import java.util.List;

import net.sherpin.mediaviewer.MediaDetailActivity;
import net.sherpin.mediaviewer.R;
import net.sherpin.mediaviewer.VideoViewerActivity;
import net.sherpin.mediaviewer.classes.VideoItem;
import android.content.Context;
import android.content.Intent;
import android.graphics.Color;
import android.view.View;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ListView;

public class ListViewGuideButton extends Button
{
	private ListView lvGuide;
	private List<VideoItem> videos;
	private Context context;

	public ListViewGuideButton(Context c, List<VideoItem> vs)
	{
		super(c);

		context = c;
		lvGuide = new ListView(context);
		lvGuide.setScrollContainer(false);
		videos = vs;
		populateVideos();

		this.setOnClickListener(new OnClickListener()
		{
			public void onClick(View arg0)
			{
				int vis = ListViewGuideButton.this.lvGuide.getVisibility();
				if (vis == View.GONE)
				{
					ListViewGuideButton.this.setText("^");
					ListViewGuideButton.this.lvGuide.setVisibility(View.VISIBLE);
				}
				else
				{
					ListViewGuideButton.this.setText("V");
					ListViewGuideButton.this.lvGuide.setVisibility(View.GONE);
				}
			}
		});
	}

	public View getListView()
	{
		return lvGuide;
	}

	private void populateVideos()
	{
		lvGuide.setAdapter(new ArrayAdapter<VideoItem>(context, R.layout.guide_listitem, videos));
		lvGuide.setTextFilterEnabled(true);
		lvGuide.setPadding(10, 0, 0, 0);
		lvGuide.setBackgroundColor(Color.DKGRAY);
		lvGuide.setOnItemClickListener(new OnItemClickListener()
		{
			public void onItemClick(AdapterView<?> parent, View view, int position, long id)
			{
				VideoItem vi = (VideoItem) parent.getItemAtPosition(position);
				Intent intent = null;
				if (vi.favicon.contains("tvdataico.jpg"))
				{
					intent = new Intent(context, MediaDetailActivity.class);
					intent.putExtra("net.mymediaguide.mediaviewer.VideoID", vi.ID);
				}
				else
				{
					// intent = new Intent(GuideListViewer.this,
					// FlashViewer.class);
					intent = new Intent(context, VideoViewerActivity.class);
					intent.putExtra("net.mymediaguide.mediaviewer.VideoURL", vi.URL);
				}
				intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
				context.startActivity(intent);
			}
		});
		lvGuide.setVisibility(View.GONE);
	}
}
