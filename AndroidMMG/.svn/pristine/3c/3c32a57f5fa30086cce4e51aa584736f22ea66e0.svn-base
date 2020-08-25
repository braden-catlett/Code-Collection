package net.sherpin.mediaviewer.handlers;

import java.util.ArrayList;
import java.util.List;

import net.sherpin.mediaviewer.classes.GenreItem;

import org.xml.sax.Attributes;
import org.xml.sax.SAXException;
import org.xml.sax.helpers.DefaultHandler;

public class GenreItemHandler extends DefaultHandler {
	private List<GenreItem> lstGenres = new ArrayList<GenreItem>();
	private int iCurr = 0;

	private final String tagGenre = "Pref";
	private final String tagId = "pid";
	private final String tagName = "prefname";
	private final String tagActive = "active";
	private String valName;
	private String valId;
	private String valActive;
	private boolean inName = false;
	private boolean inActive = false;
	private boolean inId = false;
	private GenreItem item;

	public int size() {
		return lstGenres.size();
	}
	
	public GenreItem Get(int index){
		return index < size() ? lstGenres.get(index) : null;
	}

	public String[] getStrings() {
		String[] ret = new String[size()];

		for (int i = 0; i < size(); i++)
			ret[i] = lstGenres.get(i).toString();

		return ret;
	}

	public void clearItems() {
		if (lstGenres != null)
			lstGenres.clear();
	}

	public GenreItem getCurrGenre() {
		return (lstGenres != null && iCurr < size()) ? lstGenres.get(iCurr) : null;
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
		if (localName.equalsIgnoreCase(tagName)) {
			valName = new String();
			inName = true;
		} else if (localName.equalsIgnoreCase(tagGenre)) {
			item = new GenreItem();
		} else if (localName.equalsIgnoreCase(tagActive)) {
			valActive = new String();
			inActive = true;
		} else if (localName.equalsIgnoreCase(tagId)) {
			valId = new String();
			inId = true;
		}
	}

	@Override
	public void endElement(String namespaceURI, String localName, String qName) throws SAXException {
		if (localName.equalsIgnoreCase(tagGenre)) {
			lstGenres.add(item);
		} else if (inName && localName.equalsIgnoreCase(tagName)) {
			item.Name = valName;
			inName = false;
		} else if (inActive && localName.equalsIgnoreCase(tagActive)) {
			item.Active = valActive;
			inActive = false;
		} else if (inId && localName.equalsIgnoreCase(tagId)) {
			item.Id = valId;
			inId = false;
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
	}
}
