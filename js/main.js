		$(document).ready(function() {
			//$("input[type=checkbox]").wrap("<label class=\"option\"></label>");
			//$("label.option").append("<span class=\"checkbox\"></span>");
			
			$("select").wrap("<div class=\"select\"></div>");
			
			$(".navbar-toggle").click(function() {
				$("nav").slideToggle("5000");
			});
		});