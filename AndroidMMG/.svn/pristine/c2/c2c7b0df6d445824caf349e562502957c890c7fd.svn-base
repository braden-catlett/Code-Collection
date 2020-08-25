package net.sherpin.mediaviewer.handlers;

import org.xml.sax.Attributes;
import org.xml.sax.SAXException;
import org.xml.sax.helpers.DefaultHandler;

public class NewProfileHandler extends DefaultHandler
{
	private final String tagResult = "result";
	private final String tagID = "id";

	private String valID;

	public String getID()
	{
		return valID;
	}

	@Override
	public void startElement(String namespaceURI, String localName, String qName, Attributes atts) throws SAXException
	{
		if (localName.equalsIgnoreCase(tagResult))
		{
			valID = atts.getValue(tagID);
		}
	}

	@Override
	public void endElement(String namespaceURI, String localName, String qName) throws SAXException
	{
	}

	@Override
	public void characters(char ch[], int start, int length)
	{
	}
}
