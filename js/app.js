var stgFormBuilder;
jQuery(document).ready(function($) { 
	
	var formdata = $("#stg_form_json").val();
	//alert(formdata);
	var options = {};
	
	if(formdata) {
		//alert("here");
		options.defaultFields = JSON.parse(formdata);
	}

	console.log(options);
	var stgFormBuilder = $('.formDiv').formBuilder(options);
	
	window.setTimeout(() => {

		$(".save-template").text("Generate Code");
		$(".save-template").click(() => {

			var json = stgFormBuilder.actions.getData();
			console.log(json);
			

		})

	},1000)
	
	$("form[name=post]").submit(() => {
		var json = stgFormBuilder.actions.getData();
		$("#stg_form_json").val(JSON.stringify(json));
	})
	
	$(".stg_namespace").change(()=> {
		let namespace = jQuery(".stg_namespace").val();	
		let patern = new RegExp(".+\/.+");
		if(patern.test(namespace)) {
			$(".stg_namespace_error").removeClass("stg_error");
			$(".stg_namespace").removeClass("stg_error_input");
		}
		else {
			$(".stg_namespace_error").addClass("stg_error");
			$(".stg_namespace").addClass("stg_error_input");

		}
	})

	$(".stg_php_function").blur(function() {
		let v = $(this).val();
		let lasttwo = v.slice(-2);
		//alert(lasttwo);
		if(lasttwo !== "()") {
			$(this).val(v+"()");	
		}
	})

})