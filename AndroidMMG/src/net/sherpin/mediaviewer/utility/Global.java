package net.sherpin.mediaviewer.utility;

import android.graphics.Color;

public class Global
{
	public static final String filePrefs = "MyMediaGuidePrefs";
	public static final String user = "User";
	public static final String tagHTTPGET = "HTTP GET";
	public static final String htmlMetaTag = "<!DOCTYPE HTML><html lang='en-US'><head><meta name='viewport' content='width=device-width, height=device-height, initial-scale=1, user-scalable=no'><title></title></head><body>%s</body></html>";
	public static final String htmlshowvideoIframeHTML = "<iframe id=\"_showvideo\" src=\"/loading.html\" style=\"height:100%;width:85%;border-style:none;float:left\"></iframe>";
	
	public static final String prefUserID = "net.sherpin.mediaviewer.UserID";
	public static final String prefFacebookID = "net.sherpin.mediaviewer.FacebookID";
	public static final String prefUsername = "net.sherpin.mediaviewer.Username";
	public static final String prefPassword = "net.sherpin.mediaviewer.Password";
	public static final String prefEmail = "net.sherpin.mediaviewer.Email";
	public static final String prefProfileTitle = "net.sherpin.mediaviewer.ProfileTitle";
	public static final String prefProfileID = "net.sherpin.mediaviewer.ProfileID";
	public static final String prefProfileDesc = "net.sherpin.mediaviewer.ProfileDesc";
	public static final String prefSearchQuery = "net.sherpin.mediaviewer.SearchQuery";
	public static final String prefCookies = "net.sherpin.mediaviewer.Cookies";
	public static final String prefIsGuestAccount = "net.sherpin.mediaviewer.IsGuessAccount";

	public static final String storedVideoItem = "net.sherpin.mediaviewer.StoredVideoItem";
	public static final String currentVideoItem = "net.sherpin.mediaviewer.CurrentVideoItem";
	
	public static final int selectedSherpaColor = Color.BLUE;
	public static final int standardSherpaColor = Color.parseColor("#dbdbdb");
	
	public static final int MENU_REGISTER = 0;
	public static final int MENU_LOGOUT = 1;
	public static final int MENU_SHERPAS = 2;
	public static final int MENU_RELOAD = 3;
	
	public static final int REQ_REGISTER = 0;
	public static final int REQ_REFRESH = 1;
}