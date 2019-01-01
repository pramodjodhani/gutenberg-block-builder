<?php 



add_action("admin_footer" , "my_footer_fn");

function my_footer_fn() {

?>

	<script>


		jQuery(document).ready(function() {


			var el = wp.element.createElement;
			var registerBlockType = wp.blocks.registerBlockType;

			registerBlockType( 'ipromz/fileblock', {
			    title: 'Pramods block file',

			    icon: 'universal-access-alt',

			    category: 'common',
				
				attributes:  {"Education":{"type":"object"}} ,

		
				edit: function(props) {
		
					console.log(props.attributes) 
					let Education = props.attributes.Education || []; 
 

					function EducationChangeFn(val) {
						

						props.setAttributes({Education: val})
						console.log(val);

					}

					

					return el(
							  "div",
							  {class: "GTS_main_div" },
							  el(wp.editor.MediaUpload, 
								  
								 	{
										onSelect: ( media ) => EducationChangeFn( media ),
										render: ( { open } ) =>  el("div" , {class: "gts_media"} , 
																		el(wp.components.Button, {onClick: open} , "Select File"),
																		el("img", {width: "100" , class: "get_media_img", style: {width: 50, height: 50, } , src: Education.url  } )
																	),
										multiple: false,
										value: Education.id				

									},
									
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

