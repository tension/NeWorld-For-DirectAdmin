function set_expand_visible(toggle_name, vis_name) {
	var vis_element = document.getElementById(vis_name);
	var toggle_element = document.getElementById(toggle_name);

	vis_element.style.display = '';
	toggle_element.innerHTML = "-";
	toggle_element.className = "expand_toggle_neg";
}
function set_expand_hidden(toggle_name, vis_name) {
	var vis_element = document.getElementById(vis_name);
	var toggle_element = document.getElementById(toggle_name);

	vis_element.style.display = 'none';
	toggle_element.innerHTML = "+";
	toggle_element.className = "expand_toggle_plus";
}

function toggle_expand(toggle_name, vis_name) {
	var vis_element = document.getElementById(vis_name);
	if (vis_element.style.display == 'none')
	{
		set_expand_visible(toggle_name, vis_name);
	}
	else
	{
		set_expand_hidden(toggle_name, vis_name);
	}
}
