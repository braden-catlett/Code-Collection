package net.sherpin.mediaviewer.handlers;

import java.util.ArrayList;

import net.sherpin.mediaviewer.classes.ProfileItem;

import org.xml.sax.Attributes;
import org.xml.sax.SAXException;
import org.xml.sax.helpers.DefaultHandler;

public class ProfileItemHandler extends DefaultHandler
{
	private final String tagProfile = "Prof";
	private final String tagID = "pid";
	private final String tagName = "name";
	private final String tagChecked = "checked";
	private final String tagDesc = "desc";
	private final String tagIcon = "icon";

	private ProfileItem piTmp = null;

	private ArrayList<ProfileItem> profiles = new ArrayList<ProfileItem>();
	private boolean inID = false;
	private boolean inName = false;
	private boolean inChecked = false;
	private boolean inDesc = false;
	private boolean inIcon = false;
	private int iCurr = -1;
	
	public boolean containsProfileId(String pid)
	{
		for(int i = 0; i < profiles.size(); i++)
		{
			if(profiles.get(i).pid.equalsIgnoreCase(pid))
			{
				return true;
			}
		}
		return false;
	}

	public void clearItems()
	{
		profiles.clear();
	}

	public int size()
	{
		return profiles.size();
	}

	public ProfileItem getCurrProfile()
	{
		return (profiles != null && iCurr < size() && iCurr >= 0) ? profiles.get(iCurr) : null;
	}

	public void moveFirst()
	{
		iCurr = 0;
	}

	public boolean moveNext()
	{
		iCurr++;
		return hasMore();
	}

	public boolean hasMore()
	{
		return (iCurr < size() && iCurr >= 0);
	}

	public String[] getStrings()
	{
		String[] ret = new String[profiles.size()];

		for (int i = 0; i < profiles.size(); i++)
			ret[i] = profiles.get(i).name;

		return ret;
	}

	public ArrayList<ProfileItem> getProfiles()
	{
		return profiles;
	}

	public ProfileItem getProfile(int i)
	{
		return profiles.get(i);
	}

	@Override
	public void startElement(String namespaceURI, String localName, String qName, Attributes atts) throws SAXException
	{
		if (localName.equalsIgnoreCase(tagProfile))
		{
			iCurr = 0;
			piTmp = new ProfileItem();
		}
		else if (localName.equalsIgnoreCase(tagID))
			inID = true;
		else if (localName.equalsIgnoreCase(tagName))
			inName = true;
		else if (localName.equalsIgnoreCase(tagChecked))
			inChecked = true;
		else if (localName.equalsIgnoreCase(tagDesc))
			inDesc = true;
		else if (localName.equalsIgnoreCase(tagIcon))
			inIcon = true;
	}

	@Override
	public void endElement(String namespaceURI, String localName, String qName) throws SAXException
	{
		if (localName.equalsIgnoreCase(tagProfile))
			profiles.add(piTmp);
		else if (inID && localName.equalsIgnoreCase(tagID))
			inID = false;
		else if (inName && localName.equalsIgnoreCase(tagName))
			inName = false;
		else if (inChecked && localName.equalsIgnoreCase(tagChecked))
			inChecked = false;
		else if (inDesc && localName.equalsIgnoreCase(tagDesc))
			inDesc = false;
		else if (inIcon && localName.equalsIgnoreCase(tagIcon))
			inIcon = false;
	}

	@Override
	public void characters(char ch[], int start, int length)
	{
		if (inID)
			piTmp.pid = new String(ch, start, length).trim();
		else if (inName)
			piTmp.name = new String(ch, start, length).trim();
		else if (inChecked)
			piTmp.checked = new String(ch, start, length).trim();
		else if (inDesc)
			piTmp.desc = new String(ch, start, length).trim();
		else if (inIcon)
			piTmp.Icon = new String(ch, start, length).trim();
	}
}
