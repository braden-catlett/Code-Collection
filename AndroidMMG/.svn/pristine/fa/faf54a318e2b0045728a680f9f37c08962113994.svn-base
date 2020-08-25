package net.sherpin.mediaviewer.handlers;

import org.xml.sax.Attributes;
import org.xml.sax.SAXException;
import org.xml.sax.helpers.DefaultHandler;

public class UserInfo extends DefaultHandler
{
	public String username = null;
	public String id = null;
	public String facebookId = null;
	public String error = null;

	private final String tagUser = "user";
	private final String tagError = "error";

	@Override
	public void startElement(String namespaceURI, String localName, String qName, Attributes atts) throws SAXException
	{
		if (localName.equalsIgnoreCase(tagUser))
		{
			username = atts.getValue("name");
			id = atts.getValue("id");
			facebookId = atts.getValue("facebook");
		}
		else if (localName.equalsIgnoreCase(tagError))
		{
			error = atts.getValue("reason");
		}
	}
}
