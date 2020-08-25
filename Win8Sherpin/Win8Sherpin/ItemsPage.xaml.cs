using Win8Sherpin.Data;

using System;
using System.Collections.Generic;
using System.Dynamic;
using System.IO;
using System.Linq;
using System.Net;
using Windows.Foundation;
using Windows.Foundation.Collections;
using Windows.Graphics.Display;
using Windows.Security.Authentication.Web;
using Windows.UI.ViewManagement;
using Windows.UI.Xaml;
using Windows.UI.Xaml.Controls;
using Windows.UI.Xaml.Controls.Primitives;
using Windows.UI.Xaml.Data;
using Windows.UI.Xaml.Input;
using Windows.UI.Xaml.Media;
using Windows.UI.Xaml.Navigation;
using Facebook;

// The Items Page item template is documented at http://go.microsoft.com/fwlink/?LinkId=234233

namespace Win8Sherpin
{
    /// <summary>
    /// A page that displays a collection of item previews.  In the Split Application this page
    /// is used to display and select one of the available groups.
    /// </summary>
    public sealed partial class ItemsPage : Win8Sherpin.Common.LayoutAwarePage
    {
        private Popup popup;
        string _facebookAppId = "326133152009"; // You must set your own AppId here 
        string _permissions = "user_about_me"; // Set your permissions here
        FacebookClient _fb = new FacebookClient();

        public ItemsPage()
        {
            this.InitializeComponent();
        }

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
            var sampleDataGroups = SherpinDataSource.GetGroups((String)navigationParameter);
            this.DefaultViewModel["Items"] = sampleDataGroups;
        }

        protected override void OnNavigatedTo(NavigationEventArgs e)
        {
            base.OnNavigatedTo(e);

            SetLoginText();
        }

        /// <summary>
        /// Invoked when an item is clicked.
        /// </summary>
        /// <param name="sender">The GridView (or ListView when the application is snapped)
        /// displaying the item clicked.</param>
        /// <param name="e">Event data that describes the item clicked.</param>
        void ItemView_ItemClick(object sender, ItemClickEventArgs e)
        {
            SherpinDataGroup grp = e.ClickedItem as SherpinDataGroup;
            // Navigate to the appropriate destination page, configuring the new page
            // by passing required information as a navigation parameter
            var groupId = grp.UniqueId;
            this.Frame.Navigate(typeof(SplitPage), groupId);
        }

        private void SetLoginText() 
        {
            if (UserInfo.LoggedIn)
                login.Text = Win8Sherpin.App.Current.Resources["Logout"].ToString();
            else
                login.Text = Win8Sherpin.App.Current.Resources["Login"].ToString();
        }

        private void Login_Tapped(object sender, TappedRoutedEventArgs e)
        {
            prgWait.Visibility = Windows.UI.Xaml.Visibility.Visible;
            SherpinDataSource.Clear();
            if (UserInfo.LoggedIn == false)
                OpenLoginDialog();
            else
                HandleLogout();
        }

        private void OpenLoginDialog()
        {
            Dialogs.LoginDialog dialog = new Dialogs.LoginDialog();
            dialog.CloseRequested += dialog_CloseRequested;
            popup = new Popup();
            popup.Child = dialog;
            popup.IsOpen = true;
        }

        void dialog_CloseRequested(object sender, EventArgs e)
        {
            //Check out https://github.com/facebook-csharp-sdk/facebook-windows8-sample/blob/master/src/Facebook.Samples.Windows8/Views/HomePage.xaml.cs
            // for facebook login

            Dialogs.LoginDialog dlg = sender as Dialogs.LoginDialog;
            popup.IsOpen = false;
            if (!dlg.IsFacebook)
                CompleteLogin(String.Format("http://www.sherpin.com/xml/xml_login.php?uname={0}&pwd={1}", dlg.Email, dlg.Pwd));
            else
                FacebookLogin();
        }

        private async void FacebookLogin()
        {
            var redirectUrl = "https://www.facebook.com/connect/login_success.html";
            try
            {
                //fb.AppId = facebookAppId;
                var loginUrl = _fb.GetLoginUrl(new
                {
                    client_id = _facebookAppId,
                    redirect_uri = redirectUrl,
                    scope = _permissions,
                    display = "popup",
                    response_type = "token"
                });

                var endUri = new Uri(redirectUrl);

                WebAuthenticationResult WebAuthenticationResult = await WebAuthenticationBroker.AuthenticateAsync(
                                                        WebAuthenticationOptions.None,
                                                        loginUrl,
                                                        endUri);
                if (WebAuthenticationResult.ResponseStatus == WebAuthenticationStatus.Success)
                {
                    var callbackUri = new Uri(WebAuthenticationResult.ResponseData.ToString());
                    var facebookOAuthResult = _fb.ParseOAuthCallbackUrl(callbackUri);
                    var accessToken = facebookOAuthResult.AccessToken;
                    if (!String.IsNullOrEmpty(accessToken))
                    {
                        // User is logged in and token was returned
                        LoginSucceded(accessToken);
                    }
                }
                else if (WebAuthenticationResult.ResponseStatus == WebAuthenticationStatus.ErrorHttp)
                {
                    throw new InvalidOperationException("HTTP Error returned by AuthenticateAsync() : " + WebAuthenticationResult.ResponseErrorDetail.ToString());
                }
            }
            catch (Exception ex)
            {
                throw ex;
            }
        }

        private async void LoginSucceded(string accessToken)
        {
            dynamic parameters = new ExpandoObject();
            parameters.access_token = accessToken;
            parameters.fields = "id";

            dynamic result = await _fb.GetTaskAsync("me", parameters);
            parameters = new ExpandoObject();
            parameters.id = result.id;
            parameters.access_token = accessToken;
            CompleteLogin(String.Format("http://www.sherpin.com/xml/xml_login.php?uname={0}", result.id));
        }
        
        private async void CompleteLogin(String url) 
        {
            using (WebResponse resp = await WebUtil.GetResponse(url))
            {
                resp.Dispose();
            }
            UserInfo.LoggedIn = true;
            SetLoginText();
            SherpinDataSource.Refresh();
            prgWait.Visibility = Windows.UI.Xaml.Visibility.Collapsed;
        }

        private async void HandleLogout()
        {
            using (WebResponse resp = await WebUtil.GetResponse("http://www.sherpin.com/xml/xml_logout.php"))
            {
                resp.Dispose();
            }
            UserInfo.LoggedIn = false;
            SetLoginText();
            SherpinDataSource.Refresh();
            prgWait.Visibility = Windows.UI.Xaml.Visibility.Collapsed;
        }
    }
}
