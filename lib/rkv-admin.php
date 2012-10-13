<?php

// sort admin
function rkv_custom_menu_order($menu_ord) {
	if (!$menu_ord) return true;
		return array(
        'index.php',						// this represents the dashboard link
		'edit.php',							// this is the default POST admin menu 
		'edit.php?post_type=tutorials',		// custom post type
		'edit.php?post_type=page',			// pages
		'edit.php?post_type=speaking',		// custom post type
		'edit.php?post_type=plugins',		// custom post type
		'edit.php?post_type=snippets',		// custom post type
		'edit.php?post_type=tools',			// custom post type
		'edit.php?post_type=downloads',		// custom post type
		'edit.php?post_type=photos',		// custom post type
		'upload.php',
	);
}
add_filter('custom_menu_order', 'rkv_custom_menu_order');
add_filter('menu_order', 'rkv_custom_menu_order');


// pull stuff into admin
function rkv_admin_scripts() {
	wp_enqueue_style( 'rkv-admin', get_bloginfo('stylesheet_directory').'/lib/css/admin.css', array(), null, 'all' );
	wp_enqueue_script( 'rkv-admin', get_bloginfo('stylesheet_directory').'/lib/js/rkv.admin.js', array('jquery'), null, true );
}

add_action ( 'admin_enqueue_scripts',  'rkv_admin_scripts', 10 );


// my helper
function preprint($s, $return = false) {
    $code = '<pre>';
    $code .= print_r($s, 1);
    $code .= '</pre>';
    
    if ($return)
        return $code;
    else
        print $code;
}