<?php
/**
* Plugin Name: Ahn Race Report
* Plugin URI: http://anthonyahn.com/2017/02/18/wordpress-runners-plugin/
* Description: Add a race report custom post type to add to your WP site with info specific to foot races.
* Author: Anthony Ahn
* Author URI: http://www.anthonyahn.com
* Version: 0.0.1
* License: GPLv2
*/

//The following is standard WP security
//Exits execution of this code if anyone other than WP is trying to access it
if(!defined('ABSPATH')){
	exit;
}


//Include javascript & css
function aahn_admin_enqueue_script() {
	global $pagenow, $typenow; //Strings for current page being executed and post type, respectively
	//The following will enqueue scripts only if there is an edit screen or for certain post type
	if (($pagenow == 'post.php' || $pagenow == 'post-new.php') && $typenow == 'race_report') {
		wp_enqueue_style('aahn-race-css', plugins_url( 'css/race_plugin_styles.css', __FILE__) );
		//commented out in favor of not including javascript - maybe add later
		//wp_enqueue_script('aahn-race-js', plugins_url( 'js/race-js.js', __FILE__, array('jquery', 'jquery-ui-datepicker'), '20170212', true));
	}

}
add_action('admin_enqueue_scripts', 'aahn_admin_enqueue_script');

//include custom metabox for entering race info
require_once(plugin_dir_path(__FILE__) . 'ahn_race_report_metaboxes.php');

//New custom post types must be registered
function aahn_register_post_type(){
	//the parameter(s) for your post type should be defined first, then passed to register_post_type function
	$singular = 'Race Report';
	$plural = 'Race Reports';
	$labels = array (
		'name' 			=> $plural,
		'singular_name' => $singular,
		'add_name' 		=> 'Add New',
		'add_new_item' 	=> 'Add New ' . $singular,
		'edit' 			=> 'Edit',
		'edit_item' 	=> 'Edit ' . $singular,
		'new_item' 		=> 'New ' . $singular,
		'view' 			=> 'View ' . $singular,
		'view_item' 	=> 'View ' . $singular,
		'search_term' 	=> 'Search ' . $plural,
		'parent' 		=> 'Parent ' . $singular,
		'not_found' 	=> 'No ' . $plural . ' found',
		'not_found_in_trash' => 'No ' . $plural . ' in Trash'	
	);
	
	
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_in_nav_menus' =>true,
		'menu_icon' => 'dashicons-heart',
		'supports'=> array('author')
	);
	register_post_type('race_report',$args);
}

add_action('init','aahn_register_post_type');


function aahn_register_taxonomy(){

	$plural = 'Race Types';
	$singular = 'Race Type';

	$labels = array(
		'name' => $plural,
		'singular_name' => $singular,
		'search_items' => 'Search ' . $plural,
		'popular_items' => 'Popular ' . $plural,
		'all_items' => 'All ' . $plural,
		'parent_item' => null,
		'parent_item_colon' => null,
		'edit_item' => 'Edit ' . $singular,
		'update_item' => 'Update ' . $singular,
		'add_new_item' => 'Add New ' . $singular,
		'new_item_name' => 'New ' . $singular . 'Name',
		'separate_items_with_commas' => 'Separate ' . $plural . ' with commas'
	);

	$args = array(
		'hierarchical' 	=> true,
		'labels' 		=> $labels,
		'show_ui'		=> true,
		'show_admin_column' 	=> true,
		'update_count_callback' => '_update_post_term_count',
		'query_var' 		=> true,
		'rewrite' 			=> array('slug' => 'race_type')

	);
	register_taxonomy('race_type','race_report',$args);
}

add_action('init','aahn_register_taxonomy');

//Include single.php template
function aahn_load_template( $original_template ){
	//This should only execute if the post type is race report
	if (get_query_var('post_type') != 'race_report'){
		return $original_template;
	}

	//First, check if user is trying to access archive
	if (is_archive() || is_search() ){
		//The following control structure allows user to use their existing archive template if one exists and returns
		//the default template if one does not exist
		if (file_exists(get_stylesheet_directory() .'/archive-race_report.php')){
			return get_stylesheet_directory() . '/archive-race_report.php';
		}
		else {
			return plugin_dir_path(__FILE__) . '/views/archive-race_report.php';
		}
	} else if (is_single()) {
		//The following control structure allows user to use their existing single template if one exists and returns
		//the default template if one does not exist		
		if (file_exists(get_stylesheet_directory() .'/single-race_report.php')){
			return get_stylesheet_directory() . '/single-race_report.php';
		}
		else {
			return plugin_dir_path(__FILE__) . '/views/single-race_report.php';
		}
	}
	else {
		return $original_template;
	}

}

add_action('template_include', 'aahn_load_template');





