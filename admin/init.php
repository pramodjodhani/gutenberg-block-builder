<?php 

function stg_register_my_custom_menu_page(){
    add_menu_page( 
        __( 'Franchise Map', 'ufl' ),
        'Franchise Map',
        'manage_options',
        'franchise-map',
        'ufl_menu_page'
    ); 
}
//add_action( 'admin_menu', 'ufl_register_my_custom_menu_page' );
 
/**
 * Display a custom menu page
 */
function stg_menu_page(){
	?>
	<div class="ufl_container">
		<h1>Franchise Map</h1>
		<hr>

		<div class="ufl_upload_files ufl_box_1">
			<label>
				Locations List
				<input type="file" name="locations"> <br>
				<small>Updated monthly</small>
			</label>
		</div>
		<div class="ufl_upload_files ufl_box_1">
			<label>
				Zip codes to county code list:
				<input type="file" name="code_to_country"><br>
				<small>Updated annually</small>
			</label>
		</div>
	</div>
	<?php
}