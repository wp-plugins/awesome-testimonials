<?php
/*
Plugin Name: Awesome Testimonials
Plugin URI: http://steponwebstudio.com/
Description: Wordpress Testimonials with front end Add Testimonials Facility.
Version: 1.1
Author: Prakash
Author URI: http://steponwebstudio.com/
License: GPL
*/
$siteurl = get_option('siteurl');

global $wpdb;

register_activation_hook(__FILE__,'pra_install');
register_deactivation_hook(__FILE__ , 'pra_uninstall' );


function pra_theme_enqueue() {
		wp_register_style( 'pra_TestimonialsCss', plugins_url('css/pra_testimonial.css', __FILE__) );
		wp_enqueue_style( 'pra_TestimonialsCss' );
		
		wp_enqueue_script('jquery');		
		
		wp_register_script( 'pra_TestimonialMinCss', plugins_url('js/jquery.carouFredSel-6.2.1.js', __FILE__) );
		wp_enqueue_script( 'pra_TestimonialMinCss' );
		
		wp_register_script( 'pra_TestimonialsJs', plugins_url('js/pra_testimonials.js', __FILE__) );
		wp_enqueue_script( 'pra_TestimonialsJs' );
	}
	
add_action( 'wp_enqueue_scripts', 'pra_theme_enqueue' );


function pra_install()
{

	global $wpdb;
	$pro_table_prefix=$wpdb->prefix.'pra_';
	
	$table2 = $pro_table_prefix."testimonial_settings";
    $structure2 = "CREATE TABLE $table2 (
    		id int(11) NOT NULL AUTO_INCREMENT,
  			metaname varchar(255) NOT NULL,
 		 	value varchar(225) NOT NULL,
			PRIMARY KEY (`id`)
    );";
    $wpdb->query($structure2);
	
	
	 $wpdb->query("INSERT INTO $table2 (id,metaname, value)
        VALUES (1,'effect', 'crossfade')");
		
	$wpdb->query("INSERT INTO $table2 (id,metaname, value)
        VALUES (2,'display_arrow', 1)");
	
	$wpdb->query("INSERT INTO $table2 (id,metaname, value)
        VALUES (3,'show_image', 1)");

	$wpdb->query("INSERT INTO $table2 (id,metaname, value)
	      VALUES (4,'pauseduration', 9000)");

	$wpdb->query("INSERT INTO $table2 (id,metaname, value)
	      VALUES (5,'scrollduration', 1000)");

	$wpdb->query("INSERT INTO $table2 (id,metaname, value)
	      VALUES (6,'pauseonhover', 'true')");
		  
	$wpdb->query("INSERT INTO $table2 (id,metaname, value)
	      VALUES (7,'autoplay','true' )");
		  

	  
}
function pra_uninstall()
{
   global $wpdb;
   $pro_table_prefix=$wpdb->prefix.'pra_';

    $table1 = $pro_table_prefix."testimonial_settings";
    $structure1 = "drop table if exists $table1";
    $wpdb->query($structure1);  
	
	
}


add_action('admin_menu','pra_admin_menu');

function pra_admin_menu() { 
	add_menu_page(
		"Awesome Testimonials",
		"Testimonial Settings",
		8,
		__FILE__,
		"pra_admin_menu_list",
		plugins_url( 'images/prakash.png' , __FILE__ )
	); 
}

/*******************************************************************************/
add_action('init', 'pra_awesome_testi_init');
	function pra_awesome_testi_init() 
	{
		/*----------------------------------------------------------------------
			testimonial Post Type Labels
		----------------------------------------------------------------------*/
		
		$labels = array(
			'name' => _x('All Testimonials', 'Post type general name'),
			'singular_name' => _x('Testimonials', 'Post type singular name'),
			'add_new' => _x('Add new testimonial', 'Testimonial Item'),
			'add_new_item' => __('Add New Testimonial'),
			'edit_item' => __('Edit testimonial'),
			'new_item' => __('New testimonial'),
			'all_items' => __('All Testimonials'),
			'view_item' => __('View'),
			'search_items' => __('Search'),
			'not_found' =>  __('No testimonials found.'),
			'not_found_in_trash' => __('No testimonials found.'), 
			'parent_item_colon' => '',
			'menu_name' => 'Testimonials'
		);
		
		/*----------------------------------------------------------------------
			testimonial Post Type Properties
		----------------------------------------------------------------------*/
		
		$args = array(
		'label'               => __( 'Testimonial', 'twentythirteen' ),
		'description'         => __( 'Testimonial Discriptions', 'twentythirteen' ),
		'labels'              => $labels,
		// Features this CPT supports in Post Editor
		'supports'            => array( 'title', 'editor', 'thumbnail'),
		// You can associate this CPT with a taxonomy or custom taxonomy. 
		'taxonomies'          => array( 'genres' ),
		/* A hierarchical CPT is like Pages and can have
		* Parent and child items. A non-hierarchical CPT
		* is like Posts.
		*/	
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
		
	);
		
		
register_post_type('pra_testimonials',$args);
	
		//Enabling Support for Post Thumbnails
		add_theme_support( 'post-thumbnails');
	}

/*******************************************************************************/


function pra_admin_menu_list()
{
	 include 'testimonial_settings.php';
}



//Add ShortCode for "front end listing"
//Short Code [pra_Testimonial]
add_shortcode("pra_testimonial","pra_testimonial_shortcode");
 function pra_testimonial_shortcode($atts) 
{ 
	  include 'testimonial.php';
}

?>