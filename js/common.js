jQuery(document).ready(function() {
	jQuery(document).on("click" , ".stg_heading" , function() {
		jQuery(this).next(".stg_form_div").slideToggle();
		
		var text = jQuery(this).find(".stg_toggle_icon").text();
		if(text == "+" ) {
			jQuery(this).find(".stg_toggle_icon").text("-");

		}
		else {
			jQuery(this).find(".stg_toggle_icon").text("+");

		}
	})
})