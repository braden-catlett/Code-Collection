﻿using Win8Sherpin.Data;

using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Net;
using Windows.Foundation;
using Windows.Foundation.Collections;
using Windows.Graphics.Display;
using Windows.UI.ViewManagement;
using Windows.UI.Xaml;
using Windows.UI.Xaml.Controls;
using Windows.UI.Xaml.Controls.Primitives;
using Windows.UI.Xaml.Data;
using Windows.UI.Xaml.Input;
using Windows.UI.Xaml.Media;
using Windows.UI.Xaml.Navigation;

// The Split Page item template is documented at http://go.microsoft.com/fwlink/?LinkId=234234

namespace Win8Sherpin
{
    /// <summary>
    /// A page that displays a group title, a list of items within the group, and details for the
    /// currently selected item.
    /// </summary>
    public sealed partial class EditPage : Win8Sherpin.Common.LayoutAwarePage
    {
        public EditPage()
        {
            this.InitializeComponent();

            txtAddKeyword.AddHandler(TappedEvent, new TappedEventHandler(AddKW_Tapped), true);
        }

        #region Page state management

        /// <summary>
        /// Populates the page with content passed during navigation.  Any saved state is also
        /// provided when recreating a page from a prior session.
        /// </summary>
        /// <param name="navigationParameter">The parameter value passed to
        /// <see cref="Frame.Navigate(Type, Object)"/> when this page was initially requested.
        /// </param>
        /// <param name="pageState">A dictionary of state preserved by this page during an earlier
        /// session.  This will be null the first time a page is visited.</param>
        protected override void LoadState(Object navigationParameter, Dictionary<String, Object> pageState)
        {
            // TODO: Create an appropriate data model for your problem domain to replace the sample data
            // TODO: Create an appropriate data model for your problem domain to replace the sample data
            var group = SherpinDataSource.GetGroup((String)navigationParameter);
            while (group == null)
                group = SherpinDataSource.GetGroup((String)navigationParameter);
            group.GetDetails();
            this.DefaultViewModel["Group"] = group;
            this.DefaultViewModel["Items"] = group.Items;
            this.DefaultViewModel["Keywords"] = group.Keywords;
            this.DefaultViewModel["Channels"] = group.Channels;
            this.DefaultViewModel["Genres"] = group.Genres;

            //if (pageState == null)
            //{
                // When this is a new page, select the first item automatically unless logical page
                // navigation is being used (see the logical page navigation #region below.)
                if (!this.UsingLogicalPageNavigation() && this.keywordsViewSource.View != null)
                {
                    this.keywordsViewSource.View.MoveCurrentToFirst();
                }
            //}
            //else
            //{
            //    // Restore the previously saved state associated with this page
            //    if (pageState.ContainsKey("SelectedItem") && this.keywordsViewSource.View != null)
            //    {
            //        var selectedItem = SherpinDataSource.GetItem((String)pageState["SelectedItem"]);
            //        this.keywordsViewSource.View.MoveCurrentTo(selectedItem);
            //    }
            //}
        }

        /// <summary>
        /// Preserves state associated with this page in case the application is suspended or the
        /// page is discarded from the navigation cache.  Values must conform to the serialization
        /// requirements of <see cref="SuspensionManager.SessionState"/>.
        /// </summary>
        /// <param name="pageState">An empty dictionary to be populated with serializable state.</param>
        protected override void SaveState(Dictionary<String, Object> pageState)
        {
            //if (this.keywordsViewSource.View != null)
            //{
            //    var selectedItem = (SherpinDataItem)this.keywordsViewSource.View.CurrentItem;
            //    if (selectedItem != null) pageState["SelectedItem"] = selectedItem.UniqueId;
            //}
        }

        #endregion

        #region Logical page navigation

        // Visual state management typically reflects the four application view states directly
        // (full screen landscape and portrait plus snapped and filled views.)  The split page is
        // designed so that the snapped and portrait view states each have two distinct sub-states:
        // either the item list or the details are displayed, but not both at the same time.
        //
        // This is all implemented with a single physical page that can represent two logical
        // pages.  The code below achieves this goal without making the user aware of the
        // distinction.

        /// <summary>
        /// Invoked to determine whether the page should act as one logical page or two.
        /// </summary>
        /// <param name="viewState">The view state for which the question is being posed, or null
        /// for the current view state.  This parameter is optional with null as the default
        /// value.</param>
        /// <returns>True when the view state in question is portrait or snapped, false
        /// otherwise.</returns>
        private bool UsingLogicalPageNavigation(ApplicationViewState? viewState = null)
        {
            if (viewState == null) viewState = ApplicationView.Value;
            return viewState == ApplicationViewState.FullScreenPortrait ||
                viewState == ApplicationViewState.Snapped;
        }

        /// <summary>
        /// Invoked when an item within the list is selected.
        /// </summary>
        /// <param name="sender">The GridView (or ListView when the application is Snapped)
        /// displaying the selected item.</param>
        /// <param name="e">Event data that describes how the selection was changed.</param>
        void ItemListView_SelectionChanged(object sender, SelectionChangedEventArgs e)
        {
            // Invalidate the view state when logical page navigation is in effect, as a change
            // in selection may cause a corresponding change in the current logical page.  When
            // an item is selected this has the effect of changing from displaying the item list
            // to showing the selected item's details.  When the selection is cleared this has the
            // opposite effect.
            if (this.UsingLogicalPageNavigation()) this.InvalidateVisualState();
        }

        /// <summary>
        /// Invoked when the page's back button is pressed.
        /// </summary>
        /// <param name="sender">The back button instance.</param>
        /// <param name="e">Event data that describes how the back button was clicked.</param>
        protected override void GoBack(object sender, RoutedEventArgs e)
        {
            if (this.UsingLogicalPageNavigation() && keywordListView.SelectedItem != null)
            {
                // When logical page navigation is in effect and there's a selected item that
                // item's details are currently displayed.  Clearing the selection will return
                // to the item list.  From the user's point of view this is a logical backward
                // navigation.
                this.keywordListView.SelectedItem = null;
            }
            else
            {
                // When logical page navigation is not in effect, or when there is no selected
                // item, use the default back button behavior.
                base.GoBack(sender, e);
            }
        }

        /// <summary>
        /// Invoked to determine the name of the visual state that corresponds to an application
        /// view state.
        /// </summary>
        /// <param name="viewState">The view state for which the question is being posed.</param>
        /// <returns>The name of the desired visual state.  This is the same as the name of the
        /// view state except when there is a selected item in portrait and snapped views where
        /// this additional logical page is represented by adding a suffix of _Detail.</returns>
        protected override string DetermineVisualState(ApplicationViewState viewState)
        {
            // Update the back button's enabled state when the view state changes
            var logicalPageBack = this.UsingLogicalPageNavigation(viewState) && this.keywordListView.SelectedItem != null;
            var physicalPageBack = this.Frame != null && this.Frame.CanGoBack;
            this.DefaultViewModel["CanGoBack"] = logicalPageBack || physicalPageBack;

            // Determine visual states for landscape layouts based not on the view state, but
            // on the width of the window.  This page has one layout that is appropriate for
            // 1366 virtual pixels or wider, and another for narrower displays or when a snapped
            // application reduces the horizontal space available to less than 1366.
            if (viewState == ApplicationViewState.Filled ||
                viewState == ApplicationViewState.FullScreenLandscape)
            {
                var windowWidth = Window.Current.Bounds.Width;
                if (windowWidth >= 1366) return "FullScreenLandscapeOrWide";
                return "FilledOrNarrow";
            }

            // When in portrait or snapped start with the default visual state name, then add a
            // suffix when viewing details instead of the list
            var defaultStateName = base.DetermineVisualState(viewState);
            return logicalPageBack ? defaultStateName + "_Detail" : defaultStateName;
        }

        private void PlayPage_Click(object sender, TappedRoutedEventArgs e)
        {
            SherpinDataGroup grp = this.DefaultViewModel["Group"] as SherpinDataGroup;
            // Navigate to the appropriate destination page, configuring the new page
            // by passing required information as a navigation parameter
            var groupId = grp.UniqueId;
            this.Frame.Navigate(typeof(SplitPage), groupId);
        }

        #endregion

        private void KeywordListView_ItemClick(object sender, ItemClickEventArgs e)
        {
            SherpinKeyword kw = e.ClickedItem as SherpinKeyword;
            SherpinDataGroup grp = this.DefaultViewModel["Group"] as SherpinDataGroup;
            var groupId = grp.UniqueId;
            String url = null;
            if (kw.Active)
            {
                url = String.Format("{0}/xml/xml_excludekeyword.php?ProfID={1}&Keyword={2}", SherpinDataCommon._sherpinServer, grp.UniqueId, kw.Keyword.Replace(' ', '+'));
                kw.Active = false;
                kw.Exclude = true;
            }
            else if (kw.Exclude)
            {
                kw.Exclude = false;
                kw.Active = false;
                url = String.Format("{0}/xml/xml_removekeyword.php?ProfID={1}&Keyword={2}", SherpinDataCommon._sherpinServer, grp.UniqueId, kw.Keyword.Replace(' ', '+'));
            }
            else
            {
                kw.Active = true;
                kw.Exclude = false;
                url = String.Format("{0}/xml/xml_addkeyword.php?ProfID={1}&Keyword={2}", SherpinDataCommon._sherpinServer, grp.UniqueId, kw.Keyword.Replace(' ', '+'));
            }

            SubmitUpdate(url);
            if (this.UsingLogicalPageNavigation()) this.InvalidateVisualState();
        }

        private void ChannelListView_ItemClick(object sender, ItemClickEventArgs e)
        {
            SherpinChannel ch = e.ClickedItem as SherpinChannel;
            SherpinDataGroup grp = this.DefaultViewModel["Group"] as SherpinDataGroup;
            var groupId = grp.UniqueId;
            String url = null;
            if (ch.Active)
            {
                ch.Active = false;
                url = String.Format("{0}/xml/xml_removechannel.php?ProfID={1}&ChannelID={2}", SherpinDataCommon._sherpinServer, grp.UniqueId, ch.ID);
            }
            else
            {
                ch.Active = true;
                url = String.Format("{0}/xml/xml_addchannel.php?ProfID={1}&ChannelID={2}", SherpinDataCommon._sherpinServer, grp.UniqueId, ch.ID);
            }

            SubmitUpdate(url);
            if (this.UsingLogicalPageNavigation()) this.InvalidateVisualState();
        }

        private void GenreListView_ItemClick(object sender, ItemClickEventArgs e)
        {
            SherpinGenre g = e.ClickedItem as SherpinGenre;
            SherpinDataGroup grp = this.DefaultViewModel["Group"] as SherpinDataGroup;
            var groupId = grp.UniqueId;
            String url = null;
            if (g.Active)
            {
                g.Active = false;
                url = String.Format("{0}/xml/xml_removepreference.php?ProfID={1}&PrefID={2}", SherpinDataCommon._sherpinServer, grp.UniqueId, g.ID);
            }
            else
            {
                g.Active = true;
                url = String.Format("{0}/xml/xml_addpreferences.php?ProfID={1}&PrefID={2}", SherpinDataCommon._sherpinServer, grp.UniqueId, g.ID);
            }

            SubmitUpdate(url);
            if (this.UsingLogicalPageNavigation()) this.InvalidateVisualState();
        }

        private async void SubmitUpdate(String url)
        {
            WebResponse resp = await WebUtil.GetResponse(url);
            SherpinDataGroup grp = this.DefaultViewModel["Group"] as SherpinDataGroup;
            grp.GetMedia();
        }

        private void AddKW_Tapped(object sender, TappedRoutedEventArgs e)
        {
            imgNewKW.Visibility = Windows.UI.Xaml.Visibility.Visible;
            if (txtAddKeyword.Text == Win8Sherpin.App.Current.Resources["KeywordAdd"].ToString())
                txtAddKeyword.Text = "";
            else
                txtAddKeyword.SelectAll();
        }

        private void NewKW_Tapped(object sender, TappedRoutedEventArgs e)
        {
            SherpinDataGroup grp = this.DefaultViewModel["Group"] as SherpinDataGroup;
            var groupId = grp.UniqueId;
            SherpinKeyword kw = new SherpinKeyword() { ID = -1, Keyword = txtAddKeyword.Text, Active = true, Exclude = false };
            String url = String.Format("{0}/xml/xml_addkeyword.php?ProfID={1}&Keyword={2}", SherpinDataCommon._sherpinServer, grp.UniqueId, kw.Keyword.Replace(' ', '+'));
            grp.Keywords.Add(kw);
            imgNewKW.Visibility = Windows.UI.Xaml.Visibility.Collapsed;

            SubmitUpdate(url);
            
            txtAddKeyword.Text = Win8Sherpin.App.Current.Resources["KeywordAdd"].ToString();
        }
    }
}