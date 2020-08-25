using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Text;
using System.Threading.Tasks;

namespace Win8Sherpin
{
    class WebUtil
    {
        internal static CookieContainer cookies = new CookieContainer();
        public static Task<WebResponse> GetResponse(String url)
        {
            HttpWebRequest req = HttpWebRequest.CreateHttp(url);
            req.CookieContainer = WebUtil.cookies;
            return req.GetResponseAsync();
        }
    }
}
