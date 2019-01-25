<?php 
function STG_register_meta_boxes() {
    add_meta_box( 'STG', 'Create Gutenberg Block' , 'STG_display_callback', 'gutenblock' );
}
add_action( 'add_meta_boxes', 'STG_register_meta_boxes' );
 

function STG_display_callback($post) {
	//print_r($post); exit;	
	//$shortcode_base = esc_attr(get_post_meta($post->ID , "stg_base" , true));
	$shortcode_namespace = esc_attr(get_post_meta($post->ID , "stg_namespace" , true));
	$stg_form_json = esc_attr(get_post_meta($post->ID , "stg_form_json" , true));
	$stg_category = esc_attr(get_post_meta($post->ID , "stg_category" , true));
	$stg_php_function = esc_attr(get_post_meta($post->ID , "stg_php_function" , true));
	$stg_dashicon = esc_attr(get_post_meta($post->ID , "stg_dashicon" , true));
	
	if(!$stg_dashicon){
		$stg_dashicon = "dashicons-screenoptions";
	}

	?>


	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	<script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
	


	<div class="stg_container">
		
		<div class="stg_fields">
			

			<div class="stg_single_row">
				<label >
					Namespace <br>
					<input type="text" name="stg_namespace" class="stg_namespace" required="" value="<?php echo $shortcode_namespace; ?>" Placeholder="myplugin/myblock"   /> <br>
					<span class="stg_desc stg_namespace_error">Must contain a forward slash(/) </span>
				</label>	
			</div>

			<div class="stg_single_row">
				<label >
					Dashicon <br>
					<input type="text" name="stg_dashicon" class="stg_dashicon  dashicons-picker" required="" value="<?php echo $stg_dashicon; ?>" Placeholder="dashicons-universal-access"    /> <br>
					<span class="stg_desc stg_namespace_error">See all dashicons <a href="https://developer.wordpress.org/resource/dashicons/" target=_blank>here</a>.</span>
				</label>	
			</div>

			<div class="stg_single_row">
				<label >
					PHP callback function:<br>
					<input type="text" name="stg_php_function" class="stg_php_function" required="" value="<?php echo $stg_php_function; ?>" Placeholder="myblock_frontend()" /> <br>
					<span class="stg_desc">Define this function in functions.php file of your theme/child theme.</span>
					
				</label>	
			</div>
			
			<div class="stg_single_row">
				<label >
					Block Category <br>
					<select name="stg_category" id="stg_category">
						<option <?php selected("common", $stg_category); ?>value="common">common</option>
						<option <?php selected("formatting", $stg_category); ?>value="formatting">formatting</option>
						<option <?php selected("layout", $stg_category); ?>value="layout">layout</option>
						<option <?php selected("widgets", $stg_category); ?>value="widgets">widgets</option>
						<option <?php selected("embed", $stg_category); ?>value="embed">embed</option>
					</select>
				</label>	
			</div>

			
			<input type="hidden" id="stg_form_json" name="stg_form_json" value="<?php echo $stg_form_json; ?>">

		</div>
	
		<div class="stg_form">
			<div class="formDiv"></div>
		</div>
		
	</div>


	<script src="<?php echo STG_URL;  ?>js/generateGBCode.js"></script>	
	<script src="<?php echo STG_URL;  ?>js/app.js"></script>	
	<?php 
}


function STG_save_meta_box( $post_id ) {
	//todo nonce check
	if(isset($_POST["stg_namespace"])) {

		update_post_meta($post_id , "stg_base" , $_POST["stg_base"] );
		update_post_meta($post_id , "stg_namespace" , $_POST["stg_namespace"] );
		update_post_meta($post_id , "stg_form_json" , $_POST["stg_form_json"] );
		update_post_meta($post_id , "stg_category" , $_POST["stg_category"] );
		update_post_meta($post_id , "stg_php_function" , $_POST["stg_php_function"] );
		update_post_meta($post_id , "stg_dashicon" , $_POST["stg_dashicon"] );
	}

	//echo $_POST["stg_form_json"]; exit;
}
add_action( 'save_post', 'STG_save_meta_box' );	


function stg_admin_notice__success() {
    
    global $post;
    $screen = get_current_screen();
    
    if($screen->id == "gutenblock")  {
    
    	$stg_php_function = get_post_meta($post->ID ,"stg_php_function" , true);
	    $stg_php_function = stg_trim_fn($stg_php_function); //removes  "()" from function name
    
    	if($stg_php_function ) {
    		//echo "Aaaassa"; exit;
    		if(!function_exists($stg_php_function)) {
			    ?>
			    <div class="notice notice-error is-dismissible">
			        <p><b><?php echo $stg_php_function; ?></b> function is not defined. </p>
			    </div>
			    <?php
    		}	
    	}
    }
}
add_action( 'admin_notices', 'stg_admin_notice__success' );