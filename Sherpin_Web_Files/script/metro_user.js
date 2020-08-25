var COOKIE_ID = "sherpinid";
var COOKIE_NAME = "sherpinname";
var USERID = -1;
var USERNAME = "";
var onlogin_function;

function checkcookie() {
    checksession();
    if (USERID == -1) {
        var uid = getCookie(COOKIE_ID);
        if (uid != null && uid != "") {
			USERID = uid;
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function () {
				if (this.readyState == 4 && this.status == 200) {
					setCookie(COOKIE_ID, uid, 14);
					
					welcomebanner();
					if (onlogin_function != null)
						onlogin_function();
				}
			}
			var url = "/xml/xml_userinfo.php?UserId=" + uid + "&Update=1";
			xmlhttp.open("GET", url, true);
			xmlhttp.send();
        }
		else {
			if (onlogin_function != null)
				onlogin_function();
		}
    }
	else {
		welcomebanner();
		if (onlogin_function != null)
			onlogin_function();
	}
}

function setSessionUserName(fn) {
	var xmlhttp = new XMLHttpRequest();
	if (fn != null) {
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				fn();
			}
		}
	}
	var url = "/xml/xml_userinfo.php?UserName=" + USERNAME;
	xmlhttp.open("GET", url, true);
	xmlhttp.send();
}

function welcomebanner() {
	if (USERID == -1) return;
	
	if (USERNAME.length > 0)
		setWelcomeBanner();
	else {
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function () {
			if (this.readyState == 4 && this.status == 200) {
				var xmldoc = this.responseXML;
				var fbook = getattribute(xmldoc.getElementsByTagName("user")[0], "facebook").value;
				if (fbook != "1") {
					USERNAME = getattribute(xmldoc.getElementsByTagName("user")[0], "name").value;
					setSessionUserName(function() {
						setWelcomeBanner();
					});
				}
				else {
					fbinit();
					FB.login(function(r) {
						if (r != null) {
							FB.getLoginStatus(function (response) {
								if (response.status === 'connected') {
									FB.api('/me', function (resp) {
										if (resp.id != null) {
											USERNAME = resp.first_name;
											setSessionUserName(function() {
												setWelcomeBanner();
											});
									   }
									});
								}
							});
						}
					});
				}
			}
		}
		var url = "/xml/xml_userinfo.php?UserId=" + USERID;
		xmlhttp.open("GET", url, true);
		xmlhttp.send();
	}
}

function setWelcomeBanner() {
    var spn = document.getElementById('spanUser');
    var spnlogout = document.getElementById('spanLogout');
    if (USERID != -1) {
        if (spn != null) {
			if (USERNAME.length == 0)
				spn.innerHTML = '&lt;change user&gt;';
			else
				spn.innerHTML = 'welcome ' + USERNAME;
		}
        if (spnlogout != null)
            spnlogout.innerHTML = '<span style="color: white; font: 24px/32px Segoe UI, Sans-Serif;cursor:pointer" onclick="logout()">logout</span>';
    }
    else {
        if (spn != null)
            spn.innerHTML = 'sign in';
        if (spnlogout != null)
            spnlogout.innerHTML = '';
    }
}

function startlogin(mobile) {
	USERNAME = "";
    USERID = -1;
    if (!mobile)
        $.colorbox({ href: 'register.php', width: 275, height: 320, opacity: 0.70 })
    else
        $.colorbox({ href: 'register.php', width: 275, height: 320, opacity: 0.70, top: true })
}

function fbinit() {
    if (USERID == -1 && (FB._initialized == null || FB._initialized == false)) {
		FB.init({
		  appId      : '326133152009', // App ID from the App Dashboard
		  channelUrl : '//www.sherpin.com/channel.php', // Channel File for x-domain communication
		  status     : true, // check the login status upon init?
		  cookie     : true, // set sessions cookies to allow your server to access the session?
		  xfbml      : true  // parse XFBML tags on this page?
		});
	}
}

function fblogin() {
	fbinit();
    FB.login(getlogininfo);
}

function fblogout() {
	FB.getLoginStatus(function(response) {
		if (response.status === 'connected') {
			// the user is logged in and has authenticated your
			// app, and response.authResponse supplies
			// the user's ID, a valid access token, a signed
			// request, and the time the access token 
			// and signed request each expire
			FB.logout(function(response) {});
		} else if (response.status === 'not_authorized') {
			// the user is logged in to Facebook, 
			// but has not authenticated your app
		} else {
			// the user isn't logged in to Facebook.
		}
	});
}

function sherplogin() {
    var e = document.getElementById('email');
    var p = document.getElementById('password');
	if (e.value.length != 0) {
		getsherpalogin(e.value, p.value, "", e.value);
		USERNAME = e.value;
	}
}

function getlogininfo(r) {
    if (r != null) {
        FB.getLoginStatus(function (response) {
            if (response.status === 'connected') {
                FB.api('/me', function (resp) {
					fbMe(resp);
                });
            }
        });
    }
}

function fbMe(resp) {
	if (resp.id != null) {
		USERNAME = resp.first_name;
		var userid = resp.id;
		var email = resp.email;
		//setCookie(COOKIE_NAME, USERNAME, 14);
		var kws = "";
		if (resp.home_town != null && resp.home_town.name != null) {
			kws = resp.home_town.name;
		}
		if (resp.location != null && resp.location.name != null) {
			if (kws.length > 0) { kws = kws + ","; }
			kws = kws + resp.location.name;
		}
		FB.api('/me/likes', function(resp) {
			if (resp != null) {
				for (var i=0; i<resp.data.length; i++) {
					if (kws.length > 0) { kws = kws + ","; }
					kws = kws + resp.data[i].name;
				}
			}
			getsherpalogin(userid, "", kws, email);
		});
		FB.api('/me/picture?redirect=0&width=150&type=normal', function(resp) {
			if (resp != null) {
				var xmlhttp = new XMLHttpRequest();
				var url = "/xml/xml_userinfo.php?UserPic=" + resp.data.url;
				xmlhttp.open("GET", url, true);
				xmlhttp.send();
			}
		});
   }
}

function getsherpalogin(uname, pwd, kws, email) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var xmlDoc = this.responseXML;
			var errnode = xmlDoc.getElementsByTagName("error")[0];
			if (errnode != null) {
				alert(errnode.childNodes[0].nodeValue);
			}
			else {
				var node = xmlDoc.getElementsByTagName("user")[0];

				USERID = getattribute(node, "id").value;
				if (USERNAME.length == 0 && pwd.length != 0)
					USERNAME = uname;

				setCookie(COOKIE_ID, USERID, 14);
				setSessionUserName(function() {
					if (onlogin_function != null)
						onlogin_function();
				});
				
				welcomebanner();
					
				var dqa = document.getElementById("divQuickStart");
				if (dqa != null)
					dqa.innerHTML = "";
			}
       }
    }
    var url = "/xml/xml_login.php";
	var params = "uname="+uname;
    if (pwd.length != 0)
        params = params + "&pwd=" + pwd;
	if (kws.length != 0)
		params = params + "&kws=" + kws;
	if (email != null && email.length != 0)
		params = params + "&email=" + email;
    xmlhttp.open("POST", url, true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(params);
}

function logout() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			setCookie(COOKIE_ID, "-1", 14);
			setCookie(COOKIE_NAME, "", 14);
			
			window.location = "/index.php";
		}
	}
    var url = "/xml/xml_logout.php";
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
	
	fblogout();
}

function quicksearch() {
	var txtsearch = document.getElementById("txtsearch");
	if (txtsearch != null) {
		window.location="/sherpa_detail.php?ProfID=-4&QSearch=" + txtsearch.value;
	}
}