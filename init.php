<?php 
/*
Plugin Name: Shortcode to Gutenberg Block
Plugin URI: https://wordpress.org/plugins/shortcode-to-gutenberg
Description: Converts your shortcodes to Gutenberg Blocks
Version: 0.1.0
Author: Pramod Jodhani
Author URI: http://pramodjodhani.com
*/

define('STG_FILE' , __FILE__);
define('STG_URL' , plugins_url("" , STG_FILE)."/" );


require_once "lib/util.php";
require_once "admin/init.php";
require_once "lib/STG.class.php";
require_once "metabox.php";

//delete these required
//require_once "test/file.php";

class STG_Main {

	function __construct() {
		add_action( 'wp_enqueue_scripts', array($this , "front_scripts") );
		add_action( 'admin_enqueue_scripts', array($this , "backend_scripts") );
		add_action( 'init', array($this , "register_gutenblock") );
		add_action( 'init', array($this , "register_gutenblock_posttype") );
		add_action("admin_footer" , array($this , "generate_gutenberg_blocks_code"));
	}
	
	function front_scripts() {
	    //wp_enqueue_style( 'skedool-css-front', plugins_url( "/css/style.css", __FILE__ ) );
		//wp_enqueue_script( 'skedool-js-front', plugins_url( "/js/script.js", __FILE__ ) , array(), '1.0.0', true);
	}


	function backend_scripts() {
	    wp_enqueue_style( 'stg-css-admin', plugins_url( "/css/adminstyle.css", __FILE__ ) );
		wp_enqueue_script( 'stg-js-admin', plugins_url( "/js/common.js", __FILE__ ) , array(), '1.0.0', true);

		$css = plugin_dir_url( __FILE__ ) . 'css/dashicons-picker.css';
    	wp_enqueue_style( 'dashicons-picker', $css, array( 'dashicons' ), '1.0' );

		$js = plugin_dir_url( __FILE__ ) . 'js/dashicons-picker.js';
		wp_enqueue_script( 'dashicons-picker', $js, array( 'jquery' ), '1.0' );

	}

	function register_gutenblock_posttype() {
		$args = array(
			'label'             => "Guten Block",
	        'description'        => 'Create Guten block from shortcodes',
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			//'rewrite'            => array( 'slug' => 'book' ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', )
		);

		register_post_type( 'gutenblock', $args );
	}

	function register_gutenblock() {
		$qry = new WP_Query(array(
							"post_type"=>"gutenblock",
							"posts_per_page" => 20,
							"post_status" => "publish"
						));

		while($qry->have_posts()) {
			$qry->the_post();

			$post_id = get_the_ID();
			
			$stg_namespace = get_post_meta($post_id , "stg_namespace" , true);
			$stg_php_function = get_post_meta($post_id , "stg_php_function" , true);

			$stg_php_function = stg_trim_fn($stg_php_function);

			if(function_exists($stg_php_function)) {
				
				register_block_type( $stg_namespace , array(
				    'render_callback' => $stg_php_function,
				) );
			}
			
		}
	}

	function generate_gutenberg_blocks_code() {

		$qry = new WP_Query(array(
							"post_type"=>"gutenblock",
							"posts_per_page" => 20,
							"post_status" => "publish"
						));

		while($qry->have_posts()) {
			$qry->the_post();


			$this->handle_single_block_post(get_the_ID());

			
		}

	}

	function handle_single_block_post($post_id) {

		if( function_exists( 'register_block_type' ) ) {
			
			//if(is_gutenberg_page()) {


				//$base = esc_attr(get_post_meta($post_id , "stg_base" , true));
				$namespace = esc_attr(get_post_meta($post_id , "stg_namespace" , true));
				$cat = esc_attr(get_post_meta($post_id , "stg_category" , true));
				$title = get_the_title($post_id);
				$json = esc_attr(get_post_meta($post_id , "stg_form_json" , true));
				$icon = esc_attr(get_post_meta($post_id , "stg_dashicon" , true));

				$guten = new Shortcode_guten($namespace , $cat , $title, $json , $icon);

				$html = $guten->get_head();
				$html .= $guten->get_edit();
				$html .= $guten->get_save();
				$html .= $guten->get_footer();
				
				//debug
				//echo "<pre>";
				echo $html;
				//exit;
			//}			
		}

	}

}

new STG_Main();

//remove this code 

function pramod_testblock() {
	
}