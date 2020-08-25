package net.sherpin.mediaviewer;

import java.io.BufferedInputStream;
import java.io.InputStream;
import java.util.ArrayList;

import javax.xml.parsers.SAXParser;
import javax.xml.parsers.SAXParserFactory;

import net.sherpin.mediaviewer.classes.ChannelItem;
import net.sherpin.mediaviewer.classes.GenreItem;
import net.sherpin.mediaviewer.classes.KeywordItem;
import net.sherpin.mediaviewer.classes.Pair;
import net.sherpin.mediaviewer.handlers.ChannelItemHandler;
import net.sherpin.mediaviewer.handlers.GenreItemHandler;
import net.sherpin.mediaviewer.handlers.KeywordItemHandler;
import net.sherpin.mediaviewer.utility.Global;
import net.sherpin.mediaviewer.utility.WebUtil;
import org.xml.sax.InputSource;
import org.xml.sax.XMLReader;

import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.SharedPreferences;
import android.graphics.Color;
import android.graphics.drawable.Drawable;
import android.os.Bundle;
import android.text.Editable;
import android.text.TextWatcher;
import android.util.Log;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.view.ViewGroup.LayoutParams;
import android.view.inputmethod.EditorInfo;
import android.view.inputmethod.InputMethodManager;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ProgressBar;
import android.widget.ScrollView;
import android.widget.TextView;
import android.widget.TextView.OnEditorActionListener;
import android.widget.Toast;

import com.actionbarsherlock.app.SherlockFragment;

public class EditSherpaFragment extends SherlockFragment
{
	private KeywordItemHandler keywords = new KeywordItemHandler();
	private ChannelItemHandler channels = new ChannelItemHandler();
	private GenreItemHandler genres = new GenreItemHandler();

	private String ProfileTitle;
	private String ProfileDesc;
	private String ProfileID;
	private String UserID;

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState)
	{
		View v = inflater.inflate(R.layout.editsherpa, container, false);
		
		EditText eDesc = (EditText) v.findViewById(R.id.descedittext);
		eDesc.addTextChangedListener(new TextWatcher()
		{
			
			public void onTextChanged(CharSequence s, int start, int before, int count) {}
			
			public void beforeTextChanged(CharSequence s, int start, int count, int after) {}
			
			public void afterTextChanged(final Editable s)
			{
				Thread t = new Thread(new Runnable()
				{
					public void run()
					{
						RedescribeSherpa(s.toString(), ProfileID);
					}
				});
				t.start();
			}
		});
		
		EditText eName = (EditText) v.findViewById(R.id.nameedittext);
		eName.addTextChangedListener(new TextWatcher()
		{
			
			public void onTextChanged(CharSequence s, int start, int before, int count) {}
			
			public void beforeTextChanged(CharSequence s, int start, int count, int after) {}
			
			public void afterTextChanged(final Editable s)
			{
				Thread t = new Thread(new Runnable()
				{
					public void run()
					{
						RenameSherpa(s.toString(), ProfileID);
					}
				});
				t.start();
			}
		});
		return v;
	}

	@Override
	public void onActivityCreated(Bundle savedInstanceState)
	{
		super.onActivityCreated(savedInstanceState);

		ProfileTitle = this.getArguments().getString(Global.prefProfileTitle);
		ProfileDesc = this.getArguments().getString(Global.prefProfileDesc);
		ProfileID = this.getArguments().getString(Global.prefProfileID);

		SharedPreferences settings = getActivity().getSharedPreferences(Global.filePrefs, 0);
		UserID = settings.getString(Global.prefUserID, "");

		loadSherpaContent();
	}


	@Override
	public void onPause()
	{	
		EditText eDesc = (EditText) getView().findViewById(R.id.descedittext);
		EditText eName = (EditText) getView().findViewById(R.id.nameedittext);
		
		InputMethodManager imm = (InputMethodManager)getSherlockActivity().getSystemService(Context.INPUT_METHOD_SERVICE);
		imm.hideSoftInputFromWindow(eDesc.getWindowToken(), 0);
		imm.hideSoftInputFromWindow(eName.getWindowToken(), 0);
		
		super.onPause();
	}

	private void loadSherpaContent()
	{
		((EditText) getView().findViewById(R.id.nameedittext)).setText(ProfileTitle);
		((EditText) getView().findViewById(R.id.descedittext)).setText(ProfileDesc);
		
		ImageView done = (ImageView) getView().findViewById(R.id.done);
		done.setOnClickListener(new OnClickListener()
		{
			public void onClick(View v)
			{
				getFragmentManager().popBackStack();
			}
		});
		
		ImageView delete = (ImageView) getView().findViewById(R.id.deletesherpa);
		delete.setOnClickListener(new OnClickListener()
		{
			public void onClick(View v)
			{
				AlertDialog.Builder b = new AlertDialog.Builder(getSherlockActivity());
				b.setTitle(R.string.deletesherpa);
				b.setMessage(R.string.deletesherpa_message);
				b.setPositiveButton(R.string.yes, new DialogInterface.OnClickListener()
				{
					public void onClick(DialogInterface dialog, int which)
					{
						Thread t = new Thread(new Runnable()
						{
							public void run()
							{
								try
								{
									BufferedInputStream resp = WebUtil.GetHTTPResponse("https://www.sherpin.com/xml/xml_deleteprofile.php?ProfID=" + ProfileID, getSherlockActivity());
									if(resp != null) {
										resp.close();
										Log.e("DELETESHERPA", "Got Response");
									}
									else {
										Log.e("DELETESHERPA", "No Response");
									}
								}
								catch (Exception ex)
								{
									Log.e("DELETESHERPA", "delete sherpa: " + ex.getMessage());
								}
							}
						});
						t.start();
						getFragmentManager().popBackStack();
					}
				});
				b.setNegativeButton(R.string.no, null);
				b.show();
			}
		});

		Button genre = ((Button) getView().findViewById(R.id.genrebutton));
		genre.setOnClickListener(new OnClickListener()
		{
			public void onClick(View v)
			{
				unhighlightAllButtons();
				v.setBackgroundResource(R.drawable.widebackground);
				((ProgressBar) getView().findViewById(R.id.progressbar)).setVisibility(View.VISIBLE);
				new Thread(new Runnable()
				{
					public void run()
					{
						GetSherpaGenres();
						getActivity().runOnUiThread(new Runnable()
						{
							public void run()
							{
								((ProgressBar) getView().findViewById(R.id.progressbar)).setVisibility(View.INVISIBLE);
								SetupSherpaGenres();
							}
						});
					}
				}).start();
			}
		});

		Button keyword = ((Button) getView().findViewById(R.id.keywordbutton));
		keyword.setOnClickListener(new OnClickListener()
		{
			public void onClick(View v)
			{
				unhighlightAllButtons();
				v.setBackgroundResource(R.drawable.widebackground);
				((ProgressBar) getView().findViewById(R.id.progressbar)).setVisibility(View.VISIBLE);
				new Thread(new Runnable()
				{
					public void run()
					{
						GetSherpaKeywords();
						getActivity().runOnUiThread(new Runnable()
						{
							public void run()
							{
								((ProgressBar) getView().findViewById(R.id.progressbar)).setVisibility(View.INVISIBLE);
								SetupSherpaKeywords();
							}
						});
					}
				}).start();
			}
		});

		Button channel = ((Button) getView().findViewById(R.id.channelbutton));
		channel.setOnClickListener(new OnClickListener()
		{
			public void onClick(View v)
			{
				unhighlightAllButtons();
				v.setBackgroundResource(R.drawable.widebackground);
				((ProgressBar) getView().findViewById(R.id.progressbar)).setVisibility(View.VISIBLE);
				new Thread(new Runnable()
				{
					public void run()
					{
						GetSherpaChannels();
						getActivity().runOnUiThread(new Runnable()
						{
							public void run()
							{
								((ProgressBar) getView().findViewById(R.id.progressbar)).setVisibility(View.INVISIBLE);
								SetupSherpaChannels();
							}
						});
					}
				}).start();
			}
		});

		((Button) getView().findViewById(R.id.genrebutton)).setBackgroundResource(R.drawable.widebackground);
		((ProgressBar) getView().findViewById(R.id.progressbar)).setVisibility(View.VISIBLE);
		new Thread(new Runnable()
		{
			public void run()
			{
				GetSherpaGenres();
				getActivity().runOnUiThread(new Runnable()
				{
					public void run()
					{
						((ProgressBar) getView().findViewById(R.id.progressbar)).setVisibility(View.INVISIBLE);						
						SetupSherpaGenres();
					}
				});
			}
		}).start();
	}

	private void SetupSherpaGenres()
	{
		ScrollView glist = (ScrollView) getView().findViewById(R.id.optionsmatrix);
		glist.removeAllViewsInLayout();
		glist.setMinimumHeight(100);

		LinearLayout listholder = new LinearLayout(this.getActivity());
		listholder.setOrientation(LinearLayout.VERTICAL);
		while (genres.hasMore())
		{
			ImageView image = new ImageView(this.getActivity());
			image.setMinimumHeight(25);
			image.setMinimumWidth(25);
			image.setTag(genres.getCurrGenre());
			image.setImageResource(genres.getCurrGenre().Active.contentEquals("1") ? R.drawable.check : R.drawable.delete);

			TextView text = new TextView(this.getActivity());
			text.setTextColor(Color.WHITE);
			text.setText(genres.getCurrGenre().Name.replace("_", " "));

			LinearLayout items = new LinearLayout(this.getActivity());
			items.setOrientation(LinearLayout.HORIZONTAL);
			items.setTag(image);
			items.setOnClickListener(new OnClickListener()
			{
				public void onClick(View v)
				{
					final ImageView image = (ImageView) v.getTag();
					final GenreItem item = (GenreItem) image.getTag();
					item.Active = item.Active.contentEquals("1") ? "0" : "1";

					Thread t;
					if (item.Active.contentEquals("1"))
					{
						t = new Thread(new Runnable()
						{
							public void run()
							{
								ArrayList<Pair> postParameters = new ArrayList<Pair>();
								postParameters.add(new Pair("ProfID", ProfileID));
								postParameters.add(new Pair("PrefID", item.Id));

								try
								{
									final String urlRemovePreference = "https://www.sherpin.com/xml/xml_addpreferences.php";
									BufferedInputStream resp = WebUtil.GetHTTPSResponse(urlRemovePreference, postParameters, getActivity());
									if(resp != null) {
										resp.close();
										Log.e("EDITSHERPA", "Got Response");
									}
									else {
										Log.e("EDITSHERPA", "No Response");
									}
								}
								catch (Exception ex)
								{
									Log.e("EDITSHERPA", "Add Preference: " + ex.getMessage());
								}

								getActivity().runOnUiThread(new Runnable()
								{
									public void run()
									{
										image.setImageResource(item.Active.contentEquals("1") ? R.drawable.check : R.drawable.delete);
									}
								});
							}
						});
					}
					else
					{
						t = new Thread(new Runnable()
						{
							public void run()
							{
								ArrayList<Pair> postParameters = new ArrayList<Pair>();
								postParameters.add(new Pair("ProfID", ProfileID));
								postParameters.add(new Pair("PrefID", item.Id));

								try
								{
									final String urlLogin = "https://www.sherpin.com/xml/xml_removepreference.php";
									BufferedInputStream resp = WebUtil.GetHTTPSResponse(urlLogin, postParameters, getActivity());
									if(resp != null) {
										resp.close();
										Log.e("EDITSHERPA", "Got Response");
									}
									else {
										Log.e("EDITSHERPA", "No Response");
									}
								}
								catch (Exception ex)
								{
									Log.e("EDITSHERPA", "Remove Preference: " + ex.getMessage());
								}

								getActivity().runOnUiThread(new Runnable()
								{
									public void run()
									{
										image.setImageResource(item.Active.contentEquals("1") ? R.drawable.check : R.drawable.delete);
									}
								});
							}
						});
					}
					t.start();
				}
			});

			items.addView(image);
			items.addView(text);

			listholder.addView(items);
			genres.moveNext();
		}
		glist.addView(listholder);
		genres.moveFirst();
	}

	private void SetupSherpaChannels()
	{
		final ScrollView chlist = (ScrollView) getView().findViewById(R.id.optionsmatrix);
		chlist.removeAllViewsInLayout();
		chlist.setMinimumHeight(100);
		LinearLayout listholder = new LinearLayout(this.getActivity());
		listholder.setOrientation(LinearLayout.VERTICAL);
		while (channels.hasMore())
		{
			ImageView check = new ImageView(this.getActivity());
			check.setMinimumHeight(25);
			check.setMinimumWidth(25);
			check.setTag(channels.getCurrChannel());
			check.setImageResource(channels.getCurrChannel().Active.contentEquals("1") ? R.drawable.check : R.drawable.delete);

			ImageView icon = new ImageView(this.getActivity());
			icon.setMinimumHeight(25);
			icon.setMinimumWidth(25);
			try
			{
				Drawable d = Drawable.createFromStream((InputStream) new java.net.URL(channels.getCurrChannel().Favicon).getContent(), "Sherpa");
				icon.setImageDrawable(d);
			}
			catch (Exception e)
			{
				// Assign default image
			}
			TextView text = new TextView(this.getActivity());
			text.setTextColor(Color.WHITE);
			text.setText(channels.getCurrChannel().Name);

			LinearLayout items = new LinearLayout(this.getActivity());
			items.setOrientation(LinearLayout.HORIZONTAL);
			items.setTag(check);
			items.setOnClickListener(new OnClickListener()
			{
				public void onClick(View v)
				{
					final ImageView image = (ImageView) v.getTag();
					final ChannelItem item = (ChannelItem) image.getTag();
					item.Active = item.Active.contentEquals("1") ? "0" : "1";
					image.setImageResource(item.Active.contentEquals("1") ? R.drawable.check : R.drawable.delete);

					Thread t;
					if (item.Active.contentEquals("1"))
					{
						t = new Thread(new Runnable()
						{
							public void run()
							{
								ArrayList<Pair> postParameters = new ArrayList<Pair>();
								postParameters.add(new Pair("ProfID", ProfileID));
								postParameters.add(new Pair("ChannelID", item.Id));

								try
								{
									final String urlAddChannel = "https://www.sherpin.com/xml/xml_addchannel.php";
									BufferedInputStream resp = WebUtil.GetHTTPSResponse(urlAddChannel, postParameters, getActivity());
									if(resp != null) {
										resp.close();
										Log.e("EDITSHERPA", "Got Response");
									}
									else {
										Log.e("EDITSHERPA", "No Response");
									}
								}
								catch (Exception ex)
								{
									Log.e("EDITSHERPA", "Add Channel: " + ex.getMessage());
								}
							}
						});
					}
					else
					{
						t = new Thread(new Runnable()
						{
							public void run()
							{
								ArrayList<Pair> postParameters = new ArrayList<Pair>();
								postParameters.add(new Pair("ProfID", ProfileID));
								postParameters.add(new Pair("ChannelID", item.Id));

								try
								{
									final String urlRemoveChannel = "https://www.sherpin.com/xml/xml_removechannel.php";
									BufferedInputStream resp = WebUtil.GetHTTPSResponse(urlRemoveChannel, postParameters, getActivity());
									if(resp != null) {
										resp.close();
										Log.e("EDITSHERPA", "Got Response");
									}
									else {
										Log.e("EDITSHERPA", "No Response");
									}
								}
								catch (Exception ex)
								{
									Log.e("EDITSHERPA", "Remove Channel: " + ex.getMessage());
								}
							}
						});
					}
					t.start();
				}
			});
			items.addView(check);
			items.addView(icon);
			items.addView(text);
			listholder.addView(items, LayoutParams.MATCH_PARENT, LayoutParams.WRAP_CONTENT);
			channels.moveNext();
		}
		chlist.addView(listholder, LayoutParams.WRAP_CONTENT, LayoutParams.MATCH_PARENT);
		channels.moveFirst();
	}

	private void SetupSherpaKeywords()
	{
		final ScrollView kwlist = (ScrollView) getView().findViewById(R.id.optionsmatrix);
		kwlist.removeAllViewsInLayout();
		kwlist.setMinimumHeight(100);

		LinearLayout listholder = new LinearLayout(this.getActivity());
		listholder.setOrientation(LinearLayout.VERTICAL);
		while (keywords.hasMore())
		{
			ImageView check = new ImageView(this.getActivity());
			check.setMinimumHeight(25);
			check.setMinimumWidth(25);
			check.setTag(keywords.getCurrKeyword());
			if (keywords.getCurrKeyword().Active)
			{
				check.setImageResource(R.drawable.check);
			}
			else if (keywords.getCurrKeyword().Exclude)
			{
				check.setImageResource(R.drawable.minus);
			}
			else if (!keywords.getCurrKeyword().Exclude && !keywords.getCurrKeyword().Active)
			{
				check.setImageResource(R.drawable.delete);
			}

			TextView text = new TextView(this.getActivity());
			text.setTextColor(Color.WHITE);
			text.setText(keywords.getCurrKeyword().Keyword);

			LinearLayout items = new LinearLayout(this.getActivity());
			items.setOrientation(LinearLayout.HORIZONTAL);
			items.setTag(check);
			items.setOnClickListener(new OnClickListener()
			{
				public void onClick(View v)
				{
					final ImageView image = (ImageView) v.getTag();
					final KeywordItem item = (KeywordItem) image.getTag();
					if (item.Active)
					{
						item.Active = false;
						item.Exclude = true;
						image.setImageResource(R.drawable.minus);

						Thread t = new Thread(new Runnable()
						{
							public void run()
							{
								ArrayList<Pair> postParameters = new ArrayList<Pair>();
								postParameters.add(new Pair("ProfID", ProfileID));
								postParameters.add(new Pair("Keyword", item.Keyword));

								try
								{
									final String urlExcludePreference = "https://www.sherpin.com/xml/xml_excludekeyword.php";
									BufferedInputStream resp = WebUtil.GetHTTPSResponse(urlExcludePreference, postParameters, getActivity());
									if(resp != null) {
										resp.close();
										Log.e("EDITSHERPA", "Got Response");
									}
									else {
										Log.e("EDITSHERPA", "No Response");
									}
								}
								catch (Exception ex)
								{
									Log.e("EDITSHERPA", "Exclude Preference: " + ex.getMessage());
								}
							}
						});
						t.start();
					}
					else if (!item.Active && !item.Exclude)
					{
						item.Active = true;
						image.setImageResource(R.drawable.check);

						Thread t = new Thread(new Runnable()
						{
							public void run()
							{
								ArrayList<Pair> postParameters = new ArrayList<Pair>();
								postParameters.add(new Pair("ProfID", ProfileID));
								postParameters.add(new Pair("Keyword", item.Keyword));

								try
								{
									final String urlAddPreference = "https://www.sherpin.com/xml/xml_addkeyword.php";
									BufferedInputStream resp = WebUtil.GetHTTPSResponse(urlAddPreference, postParameters, getActivity());
									if(resp != null) {
										resp.close();
										Log.e("EDITSHERPA", "Got Response");
									}
									else {
										Log.e("EDITSHERPA", "No Response");
									}
								}
								catch (Exception ex)
								{
									Log.e("EDITSHERPA", "Add Preference: " + ex.getMessage());
								}
							}
						});
						t.start();
					}
					else if (item.Exclude)
					{
						item.Active = false;
						item.Exclude = false;
						image.setImageResource(R.drawable.delete);

						Thread t = new Thread(new Runnable()
						{
							public void run()
							{
								ArrayList<Pair> postParameters = new ArrayList<Pair>();
								postParameters.add(new Pair("ProfID", ProfileID));
								postParameters.add(new Pair("Keyword", item.Keyword));

								try
								{
									final String urlRemoveKeyword = "https://www.sherpin.com/xml/xml_removekeyword.php";
									BufferedInputStream resp = WebUtil.GetHTTPSResponse(urlRemoveKeyword, postParameters, getActivity());
									if(resp != null) {
										resp.close();
										Log.e("EDITSHERPA", "Got Response");
									}
									else {
										Log.e("EDITSHERPA", "No Response");
									}
								}
								catch (Exception ex)
								{
									Log.e("EDITSHERPA", "Remove Preference: " + ex.getMessage());
								}
							}
						});
						t.start();
					}
				}
			});

			items.addView(check);
			items.addView(text);
			listholder.addView(items);
			keywords.moveNext();
		}
		keywords.moveFirst();

		LinearLayout newitemlayout = new LinearLayout(getActivity());
		newitemlayout.setOrientation(LinearLayout.HORIZONTAL);

		EditText newitem = new EditText(this.getActivity());
		newitem.setHint("<New Keyword>");
		newitem.setImeOptions(EditorInfo.IME_ACTION_DONE);
		newitem.setBackgroundColor(Color.WHITE);
		newitem.setSingleLine();
		newitem.setOnEditorActionListener(new OnEditorActionListener()
		{
			public boolean onEditorAction(TextView v, int actionId, KeyEvent event)
			{
				if (event.getKeyCode() == KeyEvent.KEYCODE_ENTER)
				{
					final String data = ((EditText) v).getText().toString();

					Thread t = new Thread(new Runnable()
					{
						public void run()
						{
							addNewKeyword(data);

							getActivity().runOnUiThread(new Runnable()
							{
								public void run()
								{
									SetupSherpaKeywords();
								}
							});
						}
					});
					t.start();
				}
				return false;
			}
		});

		Button submit = new Button(getActivity());
		submit.setText(getString(R.string.submit));
		submit.setTag(newitem);
		submit.setOnClickListener(new OnClickListener()
		{
			public void onClick(View v)
			{
				final String data = ((EditText) v.getTag()).getText().toString();

				Thread t = new Thread(new Runnable()
				{
					public void run()
					{
						addNewKeyword(data);

						getActivity().runOnUiThread(new Runnable()
						{
							public void run()
							{
								SetupSherpaKeywords();
							}
						});
					}
				});
				t.start();
			}
		});

		newitemlayout.addView(newitem, LayoutParams.WRAP_CONTENT, LayoutParams.MATCH_PARENT);
		newitemlayout.addView(submit, LayoutParams.WRAP_CONTENT, LayoutParams.MATCH_PARENT);

		listholder.addView(newitemlayout, LayoutParams.MATCH_PARENT, LayoutParams.WRAP_CONTENT);
		kwlist.addView(listholder);
	}

	private void RenameSherpa(String Name, String ProfId)
	{
		ArrayList<Pair> postParameters = new ArrayList<Pair>();
		postParameters.add(new Pair("ProfID", ProfId));
		postParameters.add(new Pair("ProfName", Name));

		try
		{
			final String urlRename = "https://www.sherpin.com/xml/xml_renameprofile.php";
			BufferedInputStream resp = WebUtil.GetHTTPSResponse(urlRename, postParameters, getActivity());
			if(resp != null) {
				resp.close();
				Log.e("EDITSHERPA", "Got Response");
			}
			else {
				Log.e("EDITSHERPA", "No Response");
			}
		}
		catch (Exception ex)
		{
			Log.e("EDITSHERPA", "Rename: " + ex.getMessage());
		}
	}

	private void RedescribeSherpa(String Desc, String ProfId)
	{
		ArrayList<Pair> postParameters = new ArrayList<Pair>();
		postParameters.add(new Pair("ProfID", ProfId));
		postParameters.add(new Pair("ProfDesc", Desc));

		try
		{
			final String urlRedescribe = "https://www.sherpin.com/xml/xml_editprofiledesc.php";
			BufferedInputStream resp = WebUtil.GetHTTPSResponse(urlRedescribe, postParameters, getActivity());
			if(resp != null) {
				resp.close();
				Log.e("EDITSHERPA", "Got Response");
			}
			else {
				Log.e("EDITSHERPA", "No Response");
			}
		}
		catch (Exception ex)
		{
			Log.e("EDITSHERPA", "Rename: " + ex.getMessage());
		}
	}

	private void GetSherpaKeywords()
	{
		try
		{
			ArrayList<Pair> postParameters = new ArrayList<Pair>();
			postParameters.add(new Pair("ProfID", ProfileID));
			postParameters.add(new Pair("UserID", UserID));

			BufferedInputStream resp = WebUtil.GetHTTPSResponse("https://www.sherpin.com/xml/xml_keywordlist.php", postParameters, getActivity());
			if(resp != null) {
				SAXParserFactory spf = SAXParserFactory.newInstance();
				SAXParser sp = spf.newSAXParser();
	
				XMLReader rdr = sp.getXMLReader();
				keywords.clearItems();
				rdr.setContentHandler(keywords);
	
				rdr.parse(new InputSource(resp));
				resp.close();
				Log.e("EDITSHERPA", "Got Response");
			}
			else {
				Log.e("EDITSHERPA", "No Response");
			}
		}
		catch (Exception ex)
		{
			Toast.makeText(this.getActivity(), String.format("Failed to parse XML(keywords): %s", ex.getMessage()), Toast.LENGTH_LONG).show();
		}
	}

	private void GetSherpaChannels()
	{
		try
		{
			ArrayList<Pair> postParameters = new ArrayList<Pair>();
			postParameters.add(new Pair("ProfID", ProfileID));
			postParameters.add(new Pair("UserID", UserID));

			BufferedInputStream resp = WebUtil.GetHTTPSResponse("https://www.sherpin.com/xml/xml_channellist.php", postParameters, getActivity());
			if(resp != null) {
				SAXParserFactory spf = SAXParserFactory.newInstance();
				SAXParser sp = spf.newSAXParser();
	
				XMLReader rdr = sp.getXMLReader();
				channels.clearItems();
				rdr.setContentHandler(channels);
	
				rdr.parse(new InputSource(resp));
				resp.close();
				Log.e("EDITSHERPA", "Got Response");
			}
			else {
				Log.e("EDITSHERPA", "No Response");
			}
		}
		catch (Exception ex)
		{
			Toast.makeText(this.getActivity(), String.format("Failed to parse XML(channels): %s", ex.getMessage()), Toast.LENGTH_LONG).show();
		}
	}

	private void GetSherpaGenres()
	{
		try
		{
			ArrayList<Pair> postParameters = new ArrayList<Pair>();
			postParameters.add(new Pair("ProfID", ProfileID));
			postParameters.add(new Pair("UserID", UserID));

			BufferedInputStream resp = WebUtil.GetHTTPSResponse("https://www.sherpin.com/xml/xml_categorylist.php", postParameters, getActivity());
			if(resp != null) {
				SAXParserFactory spf = SAXParserFactory.newInstance();
				SAXParser sp = spf.newSAXParser();
	
				XMLReader rdr = sp.getXMLReader();
				genres.clearItems();
				rdr.setContentHandler(genres);
	
				rdr.parse(new InputSource(resp));
				resp.close();
				Log.e("EDITSHERPA", "Got Response");
			}
			else {
				Log.e("EDITSHERPA", "No Response");
			}
		}
		catch (Exception ex)
		{
			Toast.makeText(this.getActivity(), String.format("Failed to parse XML(genres): %s", ex.getMessage()), Toast.LENGTH_LONG).show();
		}
	}

	private void unhighlightAllButtons()
	{
		Button genre = ((Button) getView().findViewById(R.id.genrebutton));
		Button keyword = ((Button) getView().findViewById(R.id.keywordbutton));
		Button channel = ((Button) getView().findViewById(R.id.channelbutton));

		genre.setBackgroundResource(0);
		keyword.setBackgroundResource(0);
		channel.setBackgroundResource(0);
	}

	private void addNewKeyword(final String data)
	{
		ArrayList<Pair> postParameters = new ArrayList<Pair>();
		postParameters.add(new Pair("ProfID", ProfileID));
		postParameters.add(new Pair("Keyword", data));

		try
		{
			final String urlAddNewKeyword = "https://www.sherpin.com/xml/xml_addkeyword.php";
			BufferedInputStream resp = WebUtil.GetHTTPSResponse(urlAddNewKeyword, postParameters, getSherlockActivity());
			if(resp != null) {
				resp.close();
				Log.e("DELETESHERPA", "Got Response");
			}
			else {
				Log.e("DELETESHERPA", "No Response");
			}
		}
		catch (Exception ex)
		{
			Log.e("EDITSHERPA", "Add New Preference: " + ex.getMessage());
		}
		GetSherpaKeywords();
	}
}
