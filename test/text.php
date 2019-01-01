<?php 



add_action("admin_footer" , "my_footer_fn");

function my_footer_fn() {

?>

	<script>


		jQuery(document).ready(function() {


			var el = wp.element.createElement;
			var registerBlockType = wp.blocks.registerBlockType;

			registerBlockType( 'ipromz/asdas2', {
			    title: 'Pramods block text.php',

			    icon: 'universal-access-alt',

			    category: 'common',
				
				attributes:  {"Education":{"type":"array"}} ,

		
				edit: function(props) {
		
					console.log(props.attributes) 
					let Education = props.attributes.Education || []; 
 

					function EducationChangeFn(isChecked, value) {
						
						console.log(isChecked, value)		
						if(isChecked) {
							if(! Education.includes(value)) {
								console.log(value+" include nhi krta, will push ")
								Education = Education.concat([value]); //comcat doesn't work
							}
						}
						else {
							let index = Education.indexOf(value)
							//Education.splice(index,1); // splice also doesn't work
							Education = Education.filter(function(_value, index, arr){
							    return value != _value;
							});
						}

						props.setAttributes({Education: Education})
						console.log(props.attributes);

					}

				
					let Education_values = [{"label":"High scool","value":"High scool","selected":true},{"label":"Bed","value":"Bed"},{"label":"Fail","value":"Fail"},{"label":"beta","value":"beta","selected":true},{"label":"alpha","value":"alpha"},{"label":"gamma","value":"gamma"}];
			
					let Education_arr = Education_values.map((checkbox) => {
							//console.log(props.attributes.Education , checkbox.value)
							let temp = el(wp.components.CheckboxControl , 
			        					{
			        						label: checkbox.label,
			        						value: checkbox.value, 
			        						checked: Education.includes(checkbox.value), 
			        						onChange: (checked) => EducationChangeFn(checked , checkbox.value)
			        					}	
			        				)
							return temp;
						});

					

					return el(
							  "div",
							  {class: "GTS_main_div" },
							  el("p" , {class: "stg_heading"} , "Pramods block" , 
							  	el("span", {class: "stg_toggle_icon"} , "-") 
							  ),
							  el("div" , {class: "stg_form_div" , }  
							, el('div' , {class: 'stg_single_row'} , Education_arr )
								) 
				 	) //return 
				}, 
				save: function() {
					        return null;
					    }

			}); //closing registerBlockType
		}); //document ready
	</script>	
<?php 

}

