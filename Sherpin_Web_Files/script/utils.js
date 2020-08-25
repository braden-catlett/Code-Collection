function seturl(anchor) {
	if (SHERP_ID > 0) {
		var a = document.getElementById(anchor);
		if (a != null) {
			a.href = seturltarget(a.href);
		}
	}
	return true;
}

function seturltarget(url) {
	return url + "?sherp=" + SHERP_ID;
}

function GetHeight()
{
    var y = 0;
    if (self.innerHeight)
    {
            y = self.innerHeight;
    }
    else if (document.documentElement && document.documentElement.clientHeight)
    {
            y = document.documentElement.clientHeight;
    }
    else if (document.body)
    {
            y = document.body.clientHeight;
    }
    return y;
}

function GetWidth()
{
    var x = 0;
    if (self.innerHeight)
    {
            x = self.innerWidth;
    }
    else if (document.documentElement && document.documentElement.clientHeight)
    {
            x = document.documentElement.clientWidth;
    }
    else if (document.body)
    {
            x = document.body.clientWidth;
    }
    return x;
}

function cleartxt(txtbox) {
    txtbox.value = "";
}

function getattribute(node, attr) {
    var a = null;
    for (j = 0; j < node.attributes.length; j++) {
        if (node.attributes[j].name == attr)
            a = node.attributes[j]
    }

    return a;
}

function getComputedWidth(theElt){
	var browserName=navigator.appName;
	var is_ie=false;
	if (browserName=="Microsoft Internet Explorer"){
		is_ie=true;
	}
	var wid = 0;
	if(is_ie){
		wid = document.getElementById(theElt).offsetWidth;
	}
	else{
		docObj = document.getElementById(theElt);
		var tmpw = document.defaultView.getComputedStyle(docObj, "").getPropertyValue("width");
		wid = parseInt(tmpw);
	}
	return wid;
}

function getComputedHeight(theElt){
	var browserName=navigator.appName;
	var is_ie=false;
	if (browserName=="Microsoft Internet Explorer"){
		is_ie=true;
	}
	var wid = 0;
	if(is_ie){
		wid = document.getElementById(theElt).offsetHeight;
	}
	else{
		docObj = document.getElementById(theElt);
		var tmpw = document.defaultView.getComputedStyle(docObj, "").getPropertyValue("height");
		wid = parseInt(tmpw);
	}
	return wid;
}