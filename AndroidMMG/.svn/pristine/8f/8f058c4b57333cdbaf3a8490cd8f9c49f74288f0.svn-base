package net.sherpin.mediaviewer.handlers;

import java.util.ArrayList;
import java.util.List;

import net.sherpin.mediaviewer.classes.KeywordItem;

import org.xml.sax.Attributes;
import org.xml.sax.SAXException;
import org.xml.sax.helpers.DefaultHandler;

public class KeywordItemHandler extends DefaultHandler {
	private List<KeywordItem> lstKeywords = new ArrayList<KeywordItem>();
	private int iCurr = 0;
	private KeywordItem keyword;

	private final String tagKW = "KW";
	private final String tagKID = "kid";
	private final String tagKeyword = "keyword";
	private final String tagActive = "active";
	private final String tagExclude = "exclude";

	private String valKID;
	private String valKeyword;
	private String valActive;
	private String valExclude;

	private boolean inKW = false;
	private boolean inKID = false;
	private boolean inKeyword = false;
	private boolean inActive = false;
	private boolean inExclude = false;

	public int size() {
		return lstKeywords.size();
	}
	
	public KeywordItem Get(int index){
		return (index < size() ? lstKeywords.get(index) : null);
	}
	public String[] getStrings() {
		String[] ret = new String[size()];

		for (int i = 0; i < size(); i++)
			ret[i] = lstKeywords.get(i).toString();

		return ret;
	}

	public void clearItems() {
		if (lstKeywords != null)
			lstKeywords.clear();
	}

	public KeywordItem getCurrKeyword() {
		return (lstKeywords != null && iCurr < size()) ? lstKeywords.get(iCurr) : null;
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
	public void startElement(String namespaceURI, String localName,
			String qName, Attributes atts) throws SAXException {
		if (localName.equalsIgnoreCase(tagKW)) {
			keyword = new KeywordItem();
			inKW = true;
		} else if (localName.equalsIgnoreCase(tagKID)) {
			inKID = true;
			valKID = new String();
		} else if (localName.equalsIgnoreCase(tagKeyword)) {
			inKeyword = true;
			valKeyword = new String();
		} else if (localName.equalsIgnoreCase(tagActive)) {
			inActive = true;
			valActive = new String();
		} else if (localName.equalsIgnoreCase(tagExclude)) {
			inExclude = true;
			valExclude = new String();
		}
	}

	@Override
	public void endElement(String namespaceURI, String localName, String qName)
			throws SAXException {
		if (inKW && localName.equalsIgnoreCase(tagKW)) {
			lstKeywords.add(keyword);
			inKW = false;
		} else if (inKID && localName.equalsIgnoreCase(tagKID)) {
			inKID = false;
			keyword.ID = valKID.trim();
		} else if (localName.equalsIgnoreCase(tagKeyword)) {
			inKeyword = false;
			keyword.Keyword = valKeyword.trim();
		} else if (localName.equalsIgnoreCase(tagActive)) {
			inActive = false;
			keyword.Active = valActive.trim().equals("1");
		} else if (localName.equalsIgnoreCase(tagExclude)) {
			inExclude = false;
			keyword.Exclude = valExclude.trim().equals("1");
		}
	}

	@Override
	public void characters(char ch[], int start, int length) {
		if (inKID)
			valKID = new String(ch, start, length).trim();
		else if (inKeyword)
			valKeyword = new String(ch, start, length).trim();
		else if (inActive)
			valActive = new String(ch, start, length).trim();
		else if (inExclude)
			valExclude = new String(ch, start, length).trim();
	}
}
