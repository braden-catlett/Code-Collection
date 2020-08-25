using System;
using System.IO;
using System.Linq;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.ComponentModel;
using System.Runtime.CompilerServices;
using System.Net;
using System.Xml;
using System.Xml.Linq;
using Windows.ApplicationModel.Resources.Core;
using Windows.Foundation;
using Windows.Foundation.Collections;
using Windows.UI.Xaml.Data;
using Windows.UI.Xaml.Media;
using Windows.UI.Xaml.Media.Imaging;
using System.Threading.Tasks;

// The data model defined by this file serves as a representative example of a strongly-typed
// model that supports notification when members are added, removed, or modified.  The property
// names chosen coincide with data bindings in the standard item templates.
//
// Applications may use this model as a starting point and build on it, or discard it entirely and
// replace it with something appropriate to their needs.

namespace Win8Sherpin.Data
{
    /// <summary>
    /// Base class for <see cref="SherpinDataItem"/> and <see cref="SherpinDataGroup"/> that
    /// defines properties common to both.
    /// </summary>
    [Windows.Foundation.Metadata.WebHostHidden]
    public abstract class SherpinDataCommon : Win8Sherpin.Common.BindableBase
    {
        private static Uri _baseUri = new Uri("ms-appx:///");
        internal static String _sherpinServer = "http://www.sherpin.com";

        public SherpinDataCommon(String uniqueId, String title, String subtitle, String imagePath, String description)
        {
            this._uniqueId = uniqueId;
            this._title = title;
            this._subtitle = subtitle;
            this._description = description;
            this._imagePath = imagePath;
        }

        private string _uniqueId = string.Empty;
        public string UniqueId
        {
            get { return this._uniqueId; }
            set { this.SetProperty(ref this._uniqueId, value); }
        }

        private string _title = string.Empty;
        public string Title
        {
            get { return this._title; }
            set { this.SetProperty(ref this._title, value); }
        }

        private string _subtitle = string.Empty;
        public string Subtitle
        {
            get { return this._subtitle; }
            set { this.SetProperty(ref this._subtitle, value); }
        }

        private string _description = string.Empty;
        public string Description
        {
            get { return this._description; }
            set { this.SetProperty(ref this._description, value); }
        }

        private ImageSource _image = null;
        private String _imagePath = null;
        public ImageSource Image
        {
            get
            {
                if (this._image == null && this._imagePath != null)
                {
                    this._image = new BitmapImage(new Uri(SherpinDataCommon._baseUri, this._imagePath));
                }
                return this._image;
            }

            set
            {
                this._imagePath = null;
                this.SetProperty(ref this._image, value);
            }
        }

        public void SetImage(String path)
        {
            this._image = null;
            this._imagePath = path;
            this.OnPropertyChanged("Image");
        }
    }

    /// <summary>
    /// Generic item data model.
    /// </summary>
    public class SherpinDataItem : SherpinDataCommon
    {
        public SherpinDataItem(String uniqueId, String title, String subtitle, String imagePath, String description, String content, String thumbnail, SherpinDataGroup group)
            : base(uniqueId, title, subtitle, imagePath, description)
        {
            this._content = content;
            this._thumbnail = thumbnail;
            this._group = group;
        }

        private string _content = string.Empty;
        public string Content
        {
            get { return this._content; }
            set { this.SetProperty(ref this._content, value); }
        }

        private string _thumbnail;
        public string Thumbnail
        {
            get { return this._thumbnail; }
            set { this.SetProperty(ref this._thumbnail, value); }
        }

        public string ShowVideoURL
        {
            get { return String.Format("{1}/showvideo.php?id={0}&header=0", UniqueId, _sherpinServer); }
        }

        private SherpinDataGroup _group;
        public SherpinDataGroup Group
        {
            get { return this._group; }
            set { this.SetProperty(ref this._group, value); }
        }
    }

    /// <summary>
    /// Generic group data model.
    /// </summary>
    public class SherpinDataGroup : SherpinDataCommon
    {
        public SherpinDataGroup(String uniqueId, String title, String subtitle, String imagePath, String description)
            : base(uniqueId, title, subtitle, imagePath, description)
        {
            GetMedia();
        }

        private ObservableCollection<SherpinDataItem> _items = new ObservableCollection<SherpinDataItem>();
        public ObservableCollection<SherpinDataItem> Items
        {
            get { return this._items; }
        }

        public async void GetMedia()
        {
            Items.Clear();
            String url = String.Format("{1}/xml/xml_videolist.php?ProfID={0}&Mobile=1", this.UniqueId, _sherpinServer);
            using (WebResponse resp = await WebUtil.GetResponse(url))
            {
                using (StreamReader rdr = new StreamReader(resp.GetResponseStream()))
                {
                    XDocument doc = XDocument.Load(rdr);

                    var videos = doc.Element("VideoList").Elements("Video");
                    foreach (XElement v in videos)
                    {
                        SherpinDataItem si = new SherpinDataItem(v.Element("ID").Value.Trim(), v.Element("Title").Value.Trim(),
                            "", String.Format("{1}{0}", v.Element("favicon").Value.Trim(), _sherpinServer),
                            v.Element("Description").Value.Trim(), v.Element("URI").Value.Trim(), v.Element("Thumbnail").Value.Trim(), this);
                        Items.Add(si);
                    }
                }
            }
        }
        
        public IEnumerable<SherpinDataItem> TopItems
        {
            // Provides a subset of the full items collection to bind to from a GroupedItemsPage
            // for two reasons: GridView will not virtualize large items collections, and it
            // improves the user experience when browsing through groups with large numbers of
            // items.
            //
            // A maximum of 12 items are displayed because it results in filled grid columns
            // whether there are 1, 2, 3, 4, or 6 rows displayed
            get { return this._items.Take(12); }
        }

        private ObservableCollection<SherpinKeyword> _keywords = new ObservableCollection<SherpinKeyword>();
        public ObservableCollection<SherpinKeyword> Keywords
        {
            get { return this._keywords; }
        }
        private ObservableCollection<SherpinChannel> _channels = new ObservableCollection<SherpinChannel>();
        public ObservableCollection<SherpinChannel> Channels
        {
            get { return this._channels; }
        }
        private ObservableCollection<SherpinGenre> _genres = new ObservableCollection<SherpinGenre>();
        public ObservableCollection<SherpinGenre> Genres
        {
            get { return this._genres; }
        }

        public void GetDetails()
        {
            GetSherpaKeywords();
            GetSherpaChannels();
            GetSherpaGenres();
        }

        private async void GetSherpaKeywords()
        {
            _keywords.Clear();
            using (WebResponse resp = await WebUtil.GetResponse(String.Format("{1}/xml/xml_keywordlist.php?ProfID={0}", this.UniqueId, _sherpinServer)))
            {
                using (StreamReader rdr = new StreamReader(resp.GetResponseStream()))
                {
                    XDocument doc = XDocument.Load(rdr);

                    var kws = doc.Element("KWList").Elements("KW");
                    foreach (XElement kw in kws)
                    {
                        _keywords.Add(new SherpinKeyword()
                        {
                            ID = Int32.Parse(kw.Element("kid").Value.Trim()),
                            Keyword = kw.Element("keyword").Value.Trim(),
                            Active = kw.Element("active").Value.Trim() == "1",
                            Exclude = kw.Element("exclude").Value.Trim() == "1"
                        });
                    }
                }
            }
        }

        private async void GetSherpaChannels()
        {
            _channels.Clear();
            using (WebResponse resp = await WebUtil.GetResponse(String.Format("{1}/xml/xml_channellist.php?ProfID={0}", this.UniqueId, _sherpinServer)))
            {
                using (StreamReader rdr = new StreamReader(resp.GetResponseStream()))
                {
                    XDocument doc = XDocument.Load(rdr);

                    var chs = doc.Element("ChannelList").Elements("Channel");
                    foreach (XElement ch in chs)
                    {
                        _channels.Add(new SherpinChannel()
                        {
                            ID = Int32.Parse(ch.Element("cid").Value.Trim()),
                            Name = ch.Element("name").Value.Trim(),
                            FavIcon = ch.Element("favicon").Value.Trim(),
                            Active = ch.Element("active").Value.Trim() == "1"
                        });
                    }
                }
            }
        }

        private async void GetSherpaGenres()
        {
            _genres.Clear();
            using (WebResponse resp = await WebUtil.GetResponse(String.Format("{1}/xml/xml_categorylist.php?ProfID={0}", this.UniqueId, _sherpinServer)))
            {
                using (StreamReader rdr = new StreamReader(resp.GetResponseStream()))
                {
                    XDocument doc = XDocument.Load(rdr);

                    var ps = doc.Element("PrefList").Elements("Pref");
                    foreach (XElement p in ps)
                    {
                        _genres.Add(new SherpinGenre()
                        {
                            ID = Int32.Parse(p.Element("pid").Value.Trim()),
                            Name = p.Element("prefname").Value.Trim(),
                            Active = p.Element("active").Value.Trim() == "1"
                        });
                    }
                }
            }
        }

    }

    [Windows.Foundation.Metadata.WebHostHidden]
    public class SherpinKeyword : Win8Sherpin.Common.BindableBase
    {
        private Int32 _id;
        public Int32 ID
        {
            get { return this._id; }
            set { this.SetProperty(ref this._id, value); }
        }
        private String _keyword;
        public String Keyword
        {
            get { return this._keyword; }
            set { this.SetProperty(ref this._keyword, value); }
        }
        private bool _active;
        public bool Active
        {
            get { return _active; }
            set { this.SetProperty(ref this._active, value); OnPropertyChanged("Image"); }
        }
        private bool _exclude;
        public bool Exclude
        {
            get { return this._exclude; }
            set { this.SetProperty(ref this._exclude, value); OnPropertyChanged("Image"); }
        }
        public ImageSource Image
        {
            get
            {
                Uri u = new Uri("/Assets/check.png", UriKind.Relative);
                if (Active)
                    return new BitmapImage(new Uri("ms-appx:/Assets/check.png", UriKind.Absolute));
                else if (Exclude)
                    return new BitmapImage(new Uri("ms-appx:/Assets/minus.png", UriKind.Absolute));
                else
                    return new BitmapImage(new Uri("ms-appx:/Assets/delete.png", UriKind.Absolute));
            }
        }
    }

    [Windows.Foundation.Metadata.WebHostHidden]
    public class SherpinChannel : Win8Sherpin.Common.BindableBase
    {
        private Int32 _id;
        public Int32 ID 
        {
            get { return _id; }
            set { this.SetProperty(ref this._id, value); }
        }
        private String _name;
        public String Name 
        {
            get { return _name; }
            set { this.SetProperty(ref this._name, value); }
        }
        private String _favicon;
        public String FavIcon 
        {
            get { return _favicon; }
            set { this.SetProperty(ref this._favicon, value); OnPropertyChanged("FavImage"); }
        }
        private bool _active;
        public bool Active 
        {
            get { return _active; }
            set { this.SetProperty(ref this._active, value); OnPropertyChanged("Image"); }
        }
        public ImageSource Image
        {
            get
            {
                if (Active)
                    return new BitmapImage(new Uri("ms-appx:/Assets/check.png", UriKind.Absolute));
                else
                    return new BitmapImage(new Uri("ms-appx:/Assets/delete.png", UriKind.Absolute));
            }
        }
        public ImageSource FavImage
        {
            get { return new BitmapImage(new Uri(String.Format("{1}{0}", FavIcon, SherpinDataCommon._sherpinServer), UriKind.Absolute)); }
        }
    }

    [Windows.Foundation.Metadata.WebHostHidden]
    public class SherpinGenre : Win8Sherpin.Common.BindableBase
    {
        private Int32 _id;
        public Int32 ID
        {
            get { return _id; }
            set { this.SetProperty(ref this._id, value); }
        }
        private String _name;
        public String Name 
        {
            get { return _name; }
            set { this.SetProperty(ref this._name, value); }
        }
        private bool _active;
        public bool Active 
        {
            get { return _active; }
            set { this.SetProperty(ref this._active, value); OnPropertyChanged("Image"); }
        }
        public ImageSource Image
        {
            get
            {
                Uri u = new Uri("/Assets/check.png", UriKind.Relative);
                if (Active)
                    return new BitmapImage(new Uri("ms-appx:/Assets/check.png", UriKind.Absolute));
                else
                    return new BitmapImage(new Uri("ms-appx:/Assets/delete.png", UriKind.Absolute));
            }
        }
    }

    /// <summary>
    /// Creates a collection of groups and items with hard-coded content.
    /// </summary>
    public sealed class SherpinDataSource
    {
        private static SherpinDataSource _sherpinDataSource = new SherpinDataSource();

        private ObservableCollection<SherpinDataGroup> _allGroups = new ObservableCollection<SherpinDataGroup>();
        public ObservableCollection<SherpinDataGroup> AllGroups
        {
            get { return this._allGroups; }
        }

        public static IEnumerable<SherpinDataGroup> GetGroups(string uniqueId)
        {
            if (!uniqueId.Equals("AllGroups")) throw new ArgumentException("Only 'AllGroups' is supported as a collection of groups");
            
            return _sherpinDataSource.AllGroups;
        }

        public static SherpinDataGroup GetGroup(string uniqueId)
        {
            // Simple linear search is acceptable for small data sets
            var matches = _sherpinDataSource.AllGroups.Where((group) => group.UniqueId.Equals(uniqueId));
            if (matches.Count() == 1) return matches.First();
            return null;
        }

        public static SherpinDataItem GetItem(string uniqueId)
        {
            // Simple linear search is acceptable for small data sets
            var matches = _sherpinDataSource.AllGroups.SelectMany(group => group.Items).Where((item) => item.UniqueId.Equals(uniqueId));
            if (matches.Count() == 1) return matches.First();
            return null;
        }

        public async void GetSherpas()
        {
            try
            {
                using (WebResponse resp = await WebUtil.GetResponse(String.Format("{0}/xml/xml_profilelist.php", SherpinDataCommon._sherpinServer)))
                {
                    using (StreamReader rdr = new StreamReader(resp.GetResponseStream()))
                    {
                        XDocument doc = XDocument.Load(rdr);

                        var sherpas = doc.Element("ProfList").Elements("Prof");
                        foreach (XElement s in sherpas)
                        {
                            String img = s.Element("icon") == null ? "Assets/default.png" : s.Element("icon").Value.Trim();
                            SherpinDataGroup sg = new SherpinDataGroup(s.Element("pid").Value.Trim(),
                                s.Element("name").Value.Trim(), "", img, s.Element("desc").Value.Trim());
                            AllGroups.Add(sg);
                        }
                    }
                }
            }
            catch { ;}
        }

        public static void Refresh()
        {
            _sherpinDataSource.GetSherpas();
        }

        public static void Clear()
        {
            _sherpinDataSource.AllGroups.Clear();
        }

        public SherpinDataSource()
        {
            GetSherpas();
        }
    }
}
