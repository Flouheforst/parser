/*
$(document).ready(function(){

	var overlay = $(".spinner");

	window.addEventListener("load", function(){
		overlay.css({
			"display" : "none"
		});
	});

	$(".main #Parse").click(function(e){
		e.preventDefault();

		var site = $(".main form input[name='site']").val();
		if (site.length !== 0 ) {
			$.ajax({
				url : "php/action/urlSite.php",
				method: 'POST',
				data : {
					site: site
				},

				success: function() {
					
				}
			});
		} else {
			
		}
	})
});
*/