package net.sherpin.mediaviewer.handlers;

import java.util.ArrayList;

import net.sherpin.mediaviewer.classes.VideoItem;

import org.xml.sax.Attributes;
import org.xml.sax.SAXException;
import org.xml.sax.helpers.DefaultHandler;

public class VideoListHandler extends DefaultHandler {
	private final String tagVideo = "Video";
	private final String tagFavicon = "favicon";
	private final String tagNew = "new";
	private final String tagPinned = "pinned";
	private final String tagTitle = "Title";
	private final String tagURL = "URI";
	private final String tagID = "ID";
	private final String tagProfID = "ProfID";
	private final String tagDesc = "Desc";
	private final String tagDescription = "Description";
	private final String tagThumbnail = "Thumbnail";

	private VideoItem viTmp = null;

	private ArrayList<VideoItem> videos = new ArrayList<VideoItem>();
	private boolean inVideo = false;
	private boolean inFavicon = false;
	private boolean inTitle = false;
	private boolean inURL = false;
	private boolean inID = false;
	private boolean inProfID = false;
	private boolean inDesc = false;
	private boolean inDescription = false;
	private boolean inThumbnail = false;	

	public void clearItems() {
		videos.clear();
	}

	public String[] getStrings() {
		String[] ret = new String[videos.size()];

		for (int i = 0; i < videos.size(); i++)
			ret[i] = videos.get(i).Title;

		return ret;
	}

	public VideoItem getVideo(int i) {
		return videos.get(i);
	}
	public ArrayList<VideoItem> getVideos(){
		return videos;
	}

	@Override
	public void startElement(String namespaceURI, String localName, String qName, Attributes atts) throws SAXException {
		if (localName.equalsIgnoreCase(tagVideo)){
			viTmp = new VideoItem();
			viTmp.isNew = atts.getValue(tagNew) != null && atts.getValue(tagNew).equalsIgnoreCase("1");
			viTmp.pinned = atts.getValue(tagPinned) != null && atts.getValue(tagPinned).equalsIgnoreCase("1");
			inVideo = true;
		}
		else if (localName.equalsIgnoreCase(tagID))
			inID = true;
		else if (localName.equalsIgnoreCase(tagFavicon))
			inFavicon = true;
		else if (localName.equalsIgnoreCase(tagTitle))
			inTitle = true;
		else if (localName.equalsIgnoreCase(tagURL))
			inURL = true;
		else if (localName.equalsIgnoreCase(tagProfID))
			inProfID = true;
		else if (localName.equalsIgnoreCase(tagDesc))
			inDesc = true;
		else if (localName.equalsIgnoreCase(tagDescription))
			inDescription = true;
		else if (localName.equalsIgnoreCase(tagThumbnail))
			inThumbnail = true;
	}

	@Override
	public void endElement(String namespaceURI, String localName, String qName)throws SAXException {
		if (inVideo && localName.equalsIgnoreCase(tagVideo)){
			videos.add(viTmp);
			inVideo = false;
		}
		else if (inID && localName.equalsIgnoreCase(tagID))
			inID = false;
		else if (inFavicon && localName.equalsIgnoreCase(tagFavicon))
			inFavicon = false;
		else if (inTitle && localName.equalsIgnoreCase(tagTitle))
			inTitle = false;
		else if (inURL && localName.equalsIgnoreCase(tagURL))
			inURL = false;
		else if (inProfID && localName.equalsIgnoreCase(tagProfID))
			inProfID = false;
		else if (inDesc && localName.equalsIgnoreCase(tagDesc))
			inDesc = false;
		else if (inDescription && localName.equalsIgnoreCase(tagDescription))
			inDescription = false;
		else if (inThumbnail && localName.equalsIgnoreCase(tagThumbnail))
			inThumbnail = false;
	}

	@Override
	public void characters(char ch[], int start, int length) {
		if (inFavicon)
			viTmp.favicon = "http://www.sherpin.com" + new String(ch, start, length).trim();
		else if (inID)
			viTmp.ID = new String(ch, start, length).trim();
		else if (inTitle)
			viTmp.Title = new String(ch, start, length).trim();
		else if (inProfID)
			viTmp.ProfID = new String(ch, start, length).trim();
		else if (inDesc){
			String data = new String(ch, start, length).trim();
			if(!data.contains("<![CDATA[") && !data.contains("]]>") && data.length() > 1)
				viTmp.Desc = data;
		}
		else if (inDescription){
			String data = new String(ch, start, length).trim();
			if(!data.contains("<![CDATA[") && !data.contains("]]>"))
				viTmp.Description = data;
		}
		else if (inThumbnail)
			viTmp.Thumbnail = new String(ch, start, length).trim();
		else if(inURL)
		{
			String data = new String(ch, start, length).trim();
			viTmp.URL += data;
		}
	}
}
