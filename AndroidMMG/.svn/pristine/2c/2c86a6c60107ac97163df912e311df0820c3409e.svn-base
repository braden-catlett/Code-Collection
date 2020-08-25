package net.sherpin.mediaviewer.classes;

import android.text.TextUtils;

public class VideoItem
{
	public String ID;
	public String Title;
	public String favicon;
	public boolean isNew;
	public boolean pinned;
	public String URL;
	public String ProfID;
	public String Desc;
	public String Description;
	public String Thumbnail;

	public VideoItem()
	{
		ID = "";
		Title = "";
		favicon = "";
		URL = "";
		ProfID = "";
		Desc = "";
		Description = "";
		Thumbnail = "";
		isNew = false;
		pinned = false;
	}

	@Override
	public String toString()
	{
		return Title;
	}
	
	public String stringify()
	{
		return ID + "~" + Title + "~" + favicon + "~" + URL + "~" + ProfID + "~" + Desc + "~" + Description + "~" + Thumbnail + "~" + (isNew ? "true" : "false") + "~" + (pinned ? "true" : "false");
	}
	
	public void objectify(String data)
	{
		if(!TextUtils.isEmpty(data) && data.contains("~"))
		{
			String[] items = data.split("~");
			ID = items[0];
			Title = items[1];
			favicon = items[2];
			URL = items[3];
			ProfID = items[4];
			Desc = items[5];
			Description = items[6];
			Thumbnail = items[7];
			isNew = items[8].compareTo("true") == 0;
			pinned = items[9].compareTo("true") == 0;
		}
	}
}
