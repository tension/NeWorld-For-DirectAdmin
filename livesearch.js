var xmlhttp;

var loadedat=0;

var ajax_highlight = new Array();

function setLoaded()
{
	var d = new Date();
	loadedat = d.getTime();
}

function hideit(delayed, command)
{
	if (delayed == 1)
	{
		return setTimeout("hideit(0, '"+command+"')", 1000);
	}

	document.getElementById("livesearch").innerHTML="";
	document.getElementById("livesearch").style.border="0px;";
	document.getElementById("livecontainer").style.visibility="hidden";
	
	if (command != '')
		ajax_highlight[command] = -1;

	return;
}

function is_visible(id)
{
	if (document.getElementById(id).style.visibility == "visible")
	{
		return 1;
	}
	return 0;
}

function handle_key_press(key_pressed, command)
{
	
	if (ajax_highlight[command] === undefined)
		ajax_highlight[command] = -1;
	var selected = ajax_highlight[command];



	if (key_pressed == 9 || key_pressed == 13 || key_pressed == 32)
	{
	
		if (is_visible("livecontainer") && selected >= 0)
		{
			//9 = tab
			//13 enter
			//32 space

			var id_name = command+'-'+selected;
			var item_element = document.getElementById(id_name);

			if (item_element != null)
			{
				if (typeof item_element.onclick == 'function')
				{
					item_element.onclick();
				}
				else if (typeof item_element.click == 'function')
				{
					item_element.click();
				}
					
				hideit(0, command);
			}
		}
		return;
	}



	if (key_pressed == 38 || key_pressed == 40)
	{	
		var old_selected = selected;

		if (key_pressed == 38) //up
		{
			selected = (+selected) - 1;
		}
		
		if (key_pressed == 40) //down
		{
			selected = (+selected) + 1;
		}
			
			
		if (selected == -2)
			selected = -1;
		
		//alert("new selected will be "+selected);
		
		if (selected >= 0)
		{
			var id_name = command+'-'+selected;
			var item_element = document.getElementById(id_name);
			if (item_element == null)
			{
				return; //nope, doesn't exist. Can't go here.
			}
			
			
			if (old_selected >= 0)
			{
				var old_id_name = command+'-'+old_selected;
				var old_item_element = document.getElementById(old_id_name);
				if (old_item_element != null)
				{
					outof(old_item_element, 0);
				}
			}

			over(item_element,0);
		}
	}
}

function showResult(str, command)
{
	var d = new Date();
	
	if (is_visible("livecontainer"))
	{
		var key_pressed = document.layers ? event.which : document.all ? event.keyCode : document.getElementById ? event.keyCode : 0;

		if (key_pressed == 38 || key_pressed == 40 || key_pressed == 9 || key_pressed == 13 || key_pressed == 32)
		{
			handle_key_press(key_pressed, command);
			return;
		}
	}
	
	//we need to ensure at least 200 milliseconds has passed because keyup from form submission can happen after the next page has loaded.
	if (str.length < 2 || d.getTime() - loadedat < 200 || loadedat == 0)
	{
		return hideit(0, command);
	}

	xmlhttp=GetXmlHttpObject()
	if (xmlhttp==null)
	{
		alert ("Your browser does not support XML HTTP Request");
		return;
	}

	str = str.replace(/&/, '%26');

	var url=command;
	url=url+"?query="+str;
	url=url+"&sid="+Math.random();
	xmlhttp.onreadystatechange=stateChanged;

	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
}

function stateChanged()
{
	if (xmlhttp.readyState==4)
	{
		document.getElementById("livesearch").innerHTML=xmlhttp.responseText;
		document.getElementById("livesearch").style.border="1px solid #A5ACB2";
		
		
		//new
		if (document.getElementById("livesearch").innerHTML == "")
		{
			hideit(0, '');
		}
		else
		{
			document.getElementById("livecontainer").style.visibility="visible";
		}
	}
}

function GetXmlHttpObject()
{
	if (window.XMLHttpRequest)
	{
		// code for IE7+, Firefox, Chrome, Opera, Safari
		return new XMLHttpRequest();
	}
	if (window.ActiveXObject)
	{
		// code for IE6, IE5
		return new ActiveXObject("Microsoft.XMLHTTP");
	}
	return null;
}

function get_ajax_name(id_str)
{
	if (id_str == "")
		return 'default';

	var id_split = id_str.split('-', 2);
	var ajax_name = id_split[0];
	if (ajax_name != "")
		return ajax_name;
	
	return 'default';
}

function get_ajax_number(id_str)
{
	if (id_str == "")
		return 0;

	var id_split = id_str.split('-', 2);
	var ajax_number = id_split[1];
	if (ajax_number != "")
		return ajax_number ;
	
	return 0;
}

function over(div, is_mouse)
{
	div.className='hoverin';
	
	var ajax_name = get_ajax_name(div.id);
	var ajax_number = get_ajax_number(div.id);

	if (ajax_highlight[ajax_name] === undefined)
		ajax_highlight[ajax_name] = -1;

  	var old_selected = ajax_highlight[ajax_name];
	ajax_highlight[ajax_name] = ajax_number;
	
	if (is_mouse == 0) return;
	if (old_selected == -1) return;
	
	var old_name = ajax_name+'-'+old_selected;
	var old_element = document.getElementById(old_name);
	if (old_element == null) return;
	
	old_element.className='hoverout';
}
function outof(div, is_mouse)
{
	div.className='hoverout';	
}
