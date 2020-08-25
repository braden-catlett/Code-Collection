package net.sherpin.mediaviewer.handlers;

import java.util.ArrayList;
import java.util.List;

import net.sherpin.mediaviewer.classes.ChannelItem;

import org.xml.sax.Attributes;
import org.xml.sax.SAXException;
import org.xml.sax.helpers.DefaultHandler;

public class ChannelItemHandler extends DefaultHandler {
	private List<ChannelItem> lstChannels = new ArrayList<ChannelItem>();
	private ChannelItem current;
	private int iCurr = 0;

	private final String tagChannel = "Channel";
	private final String tagId = "cid";
	private final String tagName = "name";
	private final String tagFavicon = "favicon";
	private final String tagActive = "active";
	private String valName;
	private String valId;
	private String valActive;
	private String valFavicon;
	private boolean inName = false;
	private boolean inId = false;
	private boolean inActive = false;
	private boolean inFavicon = false;

	public int size() {
		return lstChannels.size();
	}
	
	public ChannelItem Get(int index){
		return index < size() ? lstChannels.get(index) : null;
	}

	public String[] getStrings() {
		String[] ret = new String[size()];

		for (int i = 0; i < size(); i++)
			ret[i] = lstChannels.get(i).toString();

		return ret;
	}

	public void clearItems() {
		if (lstChannels != null)
			lstChannels.clear();
	}

	public ChannelItem getCurrChannel() {
		return (lstChannels != null && iCurr < size()) ? lstChannels.get(iCurr) : null;
	}

	public void moveFirst() {
		iCurr = 0;
	}

	public boolean moveNext() {
		iCurr++;
		return hasMore();
	}

	public boolean hasMore() {
		return (iCurr < size());
	}

	@Override
	public void startElement(String namespaceURI, String localName, String qName, Attributes atts) throws SAXException {
		if(localName.equalsIgnoreCase(tagChannel)){
			current = new ChannelItem();
		} else if (localName.equalsIgnoreCase(tagName)) {
			valName = new String();
			inName = true;
		} else if (localName.equalsIgnoreCase(tagActive)) {
			valActive = new String();
			inActive = true;
		} else if (localName.equalsIgnoreCase(tagId)) {
			valId = new String();
			inId = true;
		} else if (localName.equalsIgnoreCase(tagFavicon)) {
			valFavicon = new String();
			inFavicon = true;
		}
	}

	@Override
	public void endElement(String namespaceURI, String localName, String qName)
			throws SAXException {
		if (localName.equalsIgnoreCase(tagChannel)) {
			lstChannels.add(current);
		} else if (inName && localName.equalsIgnoreCase(tagName)){
			inName = false;
			current.Name = valName;
		}
		else if (inActive && localName.equalsIgnoreCase(tagActive)){
			inActive = false;
			current.Active = valActive;
		}
		else if (inId && localName.equalsIgnoreCase(tagId)){
			inId = false;
			current.Id = valId;
		}
		else if (inFavicon && localName.equalsIgnoreCase(tagFavicon)){
			inFavicon = false;
			current.Favicon = "http://www.sherpin.com" + valFavicon;
		}
	}

	@Override
	public void characters(char ch[], int start, int length) {
		if (inName)
			valName = new String(ch, start, length).trim();
		else if (inActive)
			valActive = new String(ch, start, length).trim();
		else if (inId)
			valId = new String(ch, start, length).trim();
		else if (inFavicon)
			valFavicon = new String(ch, start, length).trim();
	}
}
