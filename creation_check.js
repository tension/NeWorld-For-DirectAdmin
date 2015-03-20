var xmlhttp_array = new Array();

function ajax_run_js(str)
{
	if (str == '')
		return;

	console.log(str);

	eval(str);
}

function ajax_state_changed(xh)
{
	if (xmlhttp_array[xh].readyState==4 && xmlhttp_array[xh].status==200)
	{
		ajax_run_js(xmlhttp_array[xh].responseText);
	}
}

function ajax_start(url, xh, post)
{
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp_array[xh]=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp_array[xh]=new ActiveXObject("Microsoft.XMLHTTP");
	}

	var method = 'GET';
	if (post.length > 0)
		method='POST'

	xmlhttp_array[xh].onreadystatechange=function() { ajax_state_changed(xh); };
	xmlhttp_array[xh].open(method,url,true);
	xmlhttp_array[xh].send(post);

}

function ajax_checkName()
{
	var u=document.getElementById("username").value;
	var url="CMD_AJAX_CHECK_USERNAME?rand="+Math.random();

	ajax_start(url, 'user', 'username='+encodeURIComponent(u));
}

function ajax_checkPass()
{
	var p=document.getElementById("passwd").value;
	var url="CMD_AJAX_CHECK_PASSWORD?rand="+Math.random();

	ajax_start(url, 'pass', 'passwd='+encodeURIComponent(p));
}
function ajax_randomPass(extra_set)
{
	var url="CMD_AJAX_CHECK_PASSWORD?action=get&rand="+Math.random();

	if (extra_set != '')
	{
		url=url+"&extra_set="+extra_set;
	}

	ajax_start(url, 'rand_pass','');
}

function ajax_checkDomain()
{
	var d=document.getElementById("domain").value;
	var url="CMD_AJAX_CHECK_DOMAIN?rand="+Math.random();

	ajax_start(url, 'domain', 'domain='+encodeURIComponent(d));
}

function set_admin_level_updates()
{
	var pu=document.getElementById("plugin_updates");
	var url="CMD_AJAX_GET_COUNTS?plugin_updates=yes&program=yes&rand="+Math.random();

	ajax_start(url, 'plugin_updates', '');
}
