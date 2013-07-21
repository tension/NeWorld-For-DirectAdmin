function getObj(id) {
	return document.getElementById(id);
}
ratingMsgs = new Array(6);
ratingMsgColors = new Array(6);
barColors = new Array(6);
ratingMsgs[0] = "太短";
ratingMsgs[1] = "弱";
ratingMsgs[2] = "一般";
ratingMsgs[3] = "很好";
ratingMsgs[4] = "极佳";
ratingMsgs[5] = "未评级";
ratingMsgColors[0] = "#676767";
ratingMsgColors[1] = "#aa0033";
ratingMsgColors[2] = "#f5ac00";
ratingMsgColors[3] = "#6699cc";
ratingMsgColors[4] = "#008000";
ratingMsgColors[5] = "#676767";
barColors[0] = "#dddddd";
barColors[1] = "#aa0033";
barColors[2] = "#ffcc33";
barColors[3] = "#6699cc";
barColors[4] = "#008000";
barColors[5] = "#676767";
function CreateRatePasswdReq(pwd,min_passwd_len) {
	if (!isBrowserCompatible) {
		return;
	}
	if(!pwd) return false;  
	passwd=pwd.value;
	min_passwd_len = min_passwd_len-0;
	if (!min_passwd_len) min_passwd_len=6;
	if (passwd.length < min_passwd_len)   {
		if (passwd.length > 0) {
			DrawBar(0);
		} else {
			ResetBar();
		}
	} else {
		rating = checkPasswdRate(passwd,min_passwd_len);
		DrawBar(rating);
	}
}


function DrawBar(rating) {
	var posbar = getObj('posBar');
	var negbar = getObj('negBar');
	var passwdRating = getObj('passwdRating');
	var barLength = getObj('passwdBar').width;
	if (rating >= 0 && rating <= 4) {
		posbar.style.width = barLength / 4 * rating + "px";
		negbar.style.width = barLength / 4 * (4 - rating) + "px";
	} else {
		posbar.style.width = "0px";
		negbar.style.width = barLength + "px";
		rating = 5;
	}
	posbar.style.background = barColors[rating];
	passwdRating.innerHTML	= "<font color='" + ratingMsgColors[rating] +
	 "'>" + ratingMsgs[rating] + "</font>";
}

function ResetBar() {
	var posbar = getObj('posBar');
	var negbar = getObj('negBar');
	var passwdRating = getObj('passwdRating');
	var barLength = getObj('passwdBar').width;
	posbar.style.width = "0px";
	negbar.style.width = barLength + "px";
	passwdRating.innerHTML = "&nbsp;";
}

var agt = navigator.userAgent.toLowerCase();
var is_op = (agt.indexOf("opera") != -1);
var is_ie = (agt.indexOf("msie") != -1) && document.all && !is_op;
var is_mac = (agt.indexOf("mac") != -1);
var is_gk = (agt.indexOf("gecko") != -1);
var is_sf = (agt.indexOf("safari") != -1);
function gff(str, pfx) {
var i = str.indexOf(pfx);
	if (i != -1) {
		var v = parseFloat(str.substring(i + pfx.length));
		if (!isNaN(v)) {
			return v;
		}
	}
	return null;
}
function Compatible() {
	if (is_ie && !is_op && !is_mac) {
		var v = gff(agt, "msie ");
		if (v != null) {
			return (v >= 6.0);
		}
	}
	if (is_gk && !is_sf) {
		var v = gff(agt, "rv:");
		if (v != null) {
			return (v >= 1.4);
		} else {
			v = gff(agt, "galeon/");
			if (v != null) {
				return (v >= 1.3);
			}
		}
	}
	if (is_sf) {
		var v = gff(agt, "applewebkit/");
		if (v != null) {
			return (v >= 124);
		}
	}
	return false;
}


var isBrowserCompatible = Compatible();


function CharMode(iN){
	if (iN>=48 && iN <=57)
		return 1;
	if (iN>=65 && iN <=90)
		return 2;
	if (iN>=97 && iN <=122)
		return 4;
	else
		return 8;
}

function bitTotal(num){
	modes=0;
	for (i=0;i<4;i++){
		if (num & 1) modes++;
		num>>>=1;
	}
	return modes;
}

function checkPasswdRate(sPW,min_passwd_len){
	if (sPW.length<=min_passwd_len) return 0;
	Modes=0;
	for (i=0;i<sPW.length;i++){
		Modes|=CharMode(sPW.charCodeAt(i));
	}
	return bitTotal(Modes);
}