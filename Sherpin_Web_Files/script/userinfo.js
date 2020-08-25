    var COOKIE_ID = "sherpinid";
    var COOKIE_NAME = "sherpinname";
    var LOGIN = -1;
    var FB_ID = -1;
    var FB_NAME = "";
    var FB_EMAIL = "";
    var SHERP_ID = -1;
    var SHERP_NAME = "";

    FB.init({ appId: '326133152009', cookie: true, status: true, xfbml: true, oauth: true });
    FB.Event.subscribe('auth.login', getlogininfo);

    function getlogininfo(r) {
        if (getloggedin() > 0) {
            showuser();
            return;
        }
        var uid = getCookie(COOKIE_ID);
        if (uid != null && uid != "") {
            setCookie(COOKIE_ID, uid, 14);
            SHERP_NAME = getCookie(COOKIE_NAME);
            if (SHERP_NAME != null && SHERP_NAME != "")
                setCookie(COOKIE_NAME, SHERP_NAME, 14);
        }
        //r is null when I call this, but not null when facebook calls from the login button
        if (uid == null || uid == "") {
        	if (r != null) {
        	    FB.getLoginStatus(function (response) {
        	        if (response.status === 'connected') {
        	            FB.api('/me', function (resp) {
        	                if (resp.id != null) {
        	                    LOGIN = 1;
        	                    FB_ID = resp.id;
        	                    FB_NAME = resp.first_name;
        	                    SHERP_NAME = resp.first_name;
        	                    setCookie(COOKIE_NAME, SHERP_NAME, 14);

        	                    showuser();
        	                    setreviewlink();
        	                    storesherpid();
        	                }
        	                else {
        	                    LOGIN = 0;
        	                    showuser();
        	                }
        	            });
        	        }
        	        else {
        	            LOGIN = 0;
        	            showuser();
        	        }
        	    });
            }
            else {
                LOGIN = 0;
                showuser();
            }
        }
        else {
            LOGIN = 2;
            SHERP_ID = uid;
            showuser();
        	setreviewlink();
        }
    }
    
    function setreviewlink() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                var admin = xmlhttp.responseText.match('val=\'([^\']*)\'')
                if (admin!= null && admin.length >= 2) {
                	if (admin[1] === "true") {
                		var areview = document.getElementById('review');
                		areview.style.visibility="visible";
                	}
                }
            }
        }
        var url = "";
        if (getloggedin() == 1)
        	url = "/xml/xml_isadmin.php?fbid=" + getfbid();
        else if (getloggedin() == 2)
        	url = "/xml/xml_isadmin.php?uid=" + getsherpid();
        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    }

    function storesherpid() {
    	//only do this if we're logged in through facebook
        if (getloggedin() != 1)
        	return;

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                var userid = xmlhttp.responseText.match('id="([0-9]+)"')
                SHERPID = userid[1];
                setCookie(COOKIE_ID, userid[1], 14);

                window.location = "/viewer.php?sherp=" + userid[1];

            	//need to login to sherpin with this facebook profile so that the lastloggedin field is updated
	        	var xmlhttp_login = new XMLHttpRequest();
	        	var urllogin = "/xml/xml_login.php?uname=" + getfbid();
	            xmlhttp_login.open("GET", urllogin, false);
	            xmlhttp_login.send();
            }
        }
	    var url = "/xml/xml_userinfo.php?FBID=" + getfbid();
        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    }

    function getloggedin() { return LOGIN; }
    function getfbid() { return FB_ID; }
    function getusername() {
        if (LOGIN == 1)
            return FB_NAME;
        else if (LOGIN == 2)
            return SHERP_NAME;
        else
            return ""; 
    }
    function getsherpid() { return SHERP_ID; }

    function login(utext, ptext, btext, move) {
        var uname = document.getElementById(utext);
        var pwd = document.getElementById(ptext);
        var banner = document.getElementById(btext);
        var xmlhttp = new XMLHttpRequest();

        if (uname.value != "" && pwd.value != "") {
            if (banner != null) banner.innerHTML = "";
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    var userid = xmlhttp.responseText.match('id=\'([0-9]+)\'')
                    var username = xmlhttp.responseText.match('name=\'([^\']*)\'')
                    if (userid != null && userid.length >= 2) {
                        setCookie(COOKIE_ID, userid[1], 14);
                        setCookie(COOKIE_NAME, username[1], 14);
                        if (move == 1)
	            			window.location = "/viewer.php?sherp=" + userid[1];
	            		else {
	            			var u = window.location.href.replace("#", "");
	            			if (u.indexOf("sherp=") == -1)
	            				u = u + "?sherp=" + userid[1];
	            			window.location = u;
	            		}
                    }
                    else {
                        var error = xmlhttp.responseText.match('reason=\'([^\']*)\'');
                        if (banner != null && error != null) banner.innerHTML = error[1];
                    }
                }
            }
            xmlhttp.open("GET", "/xml/xml_login.php?uname=" + uname.value + "&pwd=" + pwd.value, true);
            xmlhttp.send();
        }
        else {
            if (banner != null) banner.innerHTML = "invalid login information";
        }
    }

    function changepwd(oldpwdtxt, newpwdtxt, confirmtxt, btxt) {
        var oldpwd = document.getElementById(oldpwdtxt);
        var newpwd = document.getElementById(newpwdtxt);
        var confirmpwd = document.getElementById(confirmtxt);
        var banner = document.getElementById(btxt);
        var xmlhttp = new XMLHttpRequest();

        if (newpwd.value == "" || confirmpwd.value == "") {
            if (banner != null) banner.innerHTML = "invalid passwords";
        }
        else if (newpwd.value != confirmpwd.value) {
            if (banner != null) banner.innerHTML = "passwords don't match";
        }
        else {
            if (banner != null) banner.innerHTML = "";
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    var error = xmlhttp.responseText.match('reason=\'([^\']*)\'');
                    if (error != null) {
                        if (banner != null && error != null) banner.innerHTML = error[1];
                    }
                    else {
                        if (banner != null) banner.innerHTML = "password changed";
                    }
                }
            }
            xmlhttp.open("GET", "/xml/xml_changepwd.php?sherp=" + getsherpid() + "&op=" + oldpwd.value + "&np=" + newpwd.value + "&cp=" + confirmpwd.value, true);
            xmlhttp.send();
        }
    }

    function logout() {
        LOGIN = 0;
        setCookie(COOKIE_ID, "", 0);
        /*
        FB.getLoginStatus(function (response) {
            if (response.status === 'connected') {
        		FB.logout(function (response) {
            		hideuser(response);
            		window.location = "/home.php";
        		});
        	}
        	else {
	        	hideuser(null);
        	}
        });
        */
    	window.location = "/home.php";
    }

    function hideuser(response) {
        SHERP_ID = -1;
        SHERP_NAME = "";
        FB_ID = -1;
        FB_NAME = "";

        var viewer = document.getElementById("aviewer");
        if (viewer != null) viewer.style.visibility = "collapse";

        var btns = document.getElementById("loginbuttons");
        if (btns != null) btns.style.visibility = "visible";
        var loggedin = document.getElementById("loggedinuser");
        if (loggedin != null) loggedin.style.visibility = "collapse";
    }
