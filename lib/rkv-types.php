<?php
// Register Custom Taxonomy and Post Type

add_action( 'init', '_init_rkv_post_type' );
function _init_rkv_post_type() {
	register_post_type( 'tutorials',
		array(
			'labels' => array(
				'name' => __( 'Tutorials' ),
				'singular_name' => __( 'Tutorial' ),
				'add_new' => __( 'Add New' ),
				'add_new_item' => __( 'Add New Tutorial' ),
				'edit' => __( 'Edit' ),
				'edit_item' => __( 'Edit Tutorial' ),
				'new_item' => __( 'New Tutorial' ),
				'view' => __( 'View Tutorial' ),
				'view_item' => __( 'View Tutorial' ),
				'search_items' => __( 'Search Tutorials' ),
				'not_found' => __( 'No Tutorials found' ),
				'not_found_in_trash' => __( 'No Tutorials found in Trash' ),
			),
			'public' => true,
			'show_ui' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'menu_position' => null,
			'capability_type' => 'post',
			'taxonomies' => array( 'tutorial-type' ),
			'menu_icon' => get_stylesheet_directory_uri() . '/lib/img/menu_tutorials.png',
			'query_var' => true,
			'rewrite'	=> array( 'slug' => 'tutorials', 'with_front' => false ),
			'has_archive' => 'tutorials',
			'supports' => array('title', 'editor', 'excerpt', 'author', 'comments'),
		)
	);
	register_post_type( 'speaking',
		array(
			'labels' => array(
				'name' => __( 'Speaking' ),
				'singular_name' => __( 'Speaking Event' ),
				'add_new' => __( 'Add New' ),
				'add_new_item' => __( 'Add New Speaking Event' ),
				'edit' => __( 'Edit' ),
				'edit_item' => __( 'Edit Speaking Event' ),
				'new_item' => __( 'New Speaking Event' ),
				'view' => __( 'View Speaking Event' ),
				'view_item' => __( 'View Speaking Event' ),
				'search_items' => __( 'Search Speaking Events' ),
				'not_found' => __( 'No Speaking Events found' ),
				'not_found_in_trash' => __( 'No Speaking Events found in Trash' ),
			),
			'public' => true,
			'show_ui' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'menu_position' => null,
			'capability_type' => 'post',
			'menu_icon' => get_stylesheet_directory_uri() . '/lib/img/menu_speaking.png',
			'query_var' => true,
			'rewrite' => array( 'slug' => 'speaking', 'with_front' => false ),
			'has_archive' => 'speaking',
			'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'author'),
		)
	);
	register_post_type( 'plugins',
		array(
			'labels' => array(
				'menu_name' => __( 'Plugins' ),
				'name' => __( 'Plugins' ),
				'singular_name' => __( 'Plugin' ),
				'add_new' => __( 'Add New' ),
				'add_new_item' => __( 'Add New Plugin' ),
				'edit' => __( 'Edit' ),
				'edit_item' => __( 'Edit Plugin' ),
				'new_item' => __( 'New Plugin' ),
				'view' => __( 'View Plugin' ),
				'view_item' => __( 'View Plugin' ),
				'search_items' => __( 'Search Plugins' ),
				'not_found' => __( 'No Plugins found' ),
				'not_found_in_trash' => __( 'No Plugins found in Trash' ),
			),
			'public' => true,
			'show_ui' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'menu_position' => null,
			'capability_type' => 'post',
			'taxonomies' => array( 'plugin-type' ),
			'menu_icon' => get_stylesheet_directory_uri() . '/lib/img/menu_plugins.png',
			'query_var' => true,
			'rewrite'	=> array( 'slug' => 'plugins', 'with_front' => false ),
			'has_archive' => 'plugins',
			'supports' => array('title'),
		)
	);
	register_post_type( 'tools',
		array(
			'labels' => array(
				'menu_name'				=> __( 'Tools' ),
				'name'					=> __( 'Tools' ),
				'singular_name'			=> __( 'Tool' ),
				'add_new'				=> __( 'Add New' ),
				'add_new_item'			=> __( 'Add New Tool' ),
				'edit'					=> __( 'Edit' ),
				'edit_item'				=> __( 'Edit Tool' ),
				'new_item'				=> __( 'New Tool' ),
				'view'					=> __( 'View Tool' ),
				'view_item'				=> __( 'View Tool' ),
				'search_items'			=> __( 'Search Tools' ),
				'not_found'				=> __( 'No Tools found' ),
				'not_found_in_trash'	=> __( 'No Tools found in Trash' ),
			),
			'public'				=> true,
			'show_ui'				=> true,
			'publicly_queryable'	=> true,
			'exclude_from_search'	=> false,
			'menu_position'			=> null,
			'capability_type'		=> 'post',
			'menu_icon'				=> get_stylesheet_directory_uri() . '/lib/img/menu_tools.png',
			'query_var'				=> true,
			'taxonomies'			=> array( 'tool-type' ),
			'rewrite'				=> array( 'slug' => 'tools', 'with_front' => false ),
			'has_archive'			=> 'tools',
			'supports'				=> array('title'),
		)
	);
	register_post_type( 'snippets',
		array(
			'labels' => array(
				'menu_name'				=> __( 'Snippets' ),
				'name'					=> __( 'Snippets' ),
				'singular_name'			=> __( 'Snippet' ),
				'add_new'				=> __( 'Add New' ),
				'add_new_item'			=> __( 'Add New Snippet' ),
				'edit'					=> __( 'Edit' ),
				'edit_item'				=> __( 'Edit Snippet' ),
				'new_item'				=> __( 'New Snippet' ),
				'view'					=> __( 'View Snippet' ),
				'view_item'				=> __( 'View Snippet' ),
				'search_items'			=> __( 'Search Snippets' ),
				'not_found'				=> __( 'No Snippets found' ),
				'not_found_in_trash'	=> __( 'No Snippets found in Trash' ),
			),
			'public'				=> true,
			'show_ui'				=> true,
			'publicly_queryable'	=> true,
			'exclude_from_search'	=> false,
			'menu_position'			=> null,
			'capability_type'		=> 'post',
			'menu_icon'				=> get_stylesheet_directory_uri() . '/lib/img/menu_snippets.png',
			'query_var'				=> true,
			'rewrite'				=> array( 'slug' => 'snippets', 'with_front' => false ),
			'has_archive'			=> 'snippets',
			'supports'				=> array('title', 'editor'),
		)
	);
	register_post_type( 'downloads',
		array(
			'labels' => array(
				'menu_name'				=> __( 'Downloads' ),
				'name'					=> __( 'Downloads' ),
				'singular_name'			=> __( 'Download' ),
				'add_new'				=> __( 'Add New' ),
				'add_new_item'			=> __( 'Add New Download' ),
				'edit'					=> __( 'Edit' ),
				'edit_item'				=> __( 'Edit Download' ),
				'new_item'				=> __( 'New Download' ),
				'view'					=> __( 'View Download' ),
				'view_item'				=> __( 'View Download' ),
				'search_items'			=> __( 'Search Downloads' ),
				'not_found'				=> __( 'No Downloads found' ),
				'not_found_in_trash'	=> __( 'No Downloads found in Trash' ),
			),
			'public'				=> true,
			'show_ui'				=> true,
			'publicly_queryable'	=> true,
			'exclude_from_search'	=> true,
			'menu_position'			=> null,
			'capability_type'		=> 'post',
			'menu_icon'				=> get_stylesheet_directory_uri() . '/lib/img/menu_downloads.png',
			'query_var'				=> true,
			'rewrite'				=> array( 'slug' => 'downloads', 'with_front' => false ),
			'has_archive'			=> 'downloads',
			'supports'				=> array('title'),
		)
	);
	register_post_type( 'photos',
		array(
			'labels' => array(
				'menu_name'				=> __( 'Photos' ),
				'name'					=> __( 'Photos' ),
				'singular_name'			=> __( 'Photo' ),
				'add_new'				=> __( 'Add New' ),
				'add_new_item'			=> __( 'Add New Photo' ),
				'edit'					=> __( 'Edit' ),
				'edit_item'				=> __( 'Edit Photo' ),
				'new_item'				=> __( 'New Photo' ),
				'view'					=> __( 'View Photo' ),
				'view_item'				=> __( 'View Photo' ),
				'search_items'			=> __( 'Search Photos' ),
				'not_found'				=> __( 'No Photos found' ),
				'not_found_in_trash'	=> __( 'No Photos found in Trash' ),
			),
			'public'				=> true,
			'show_ui'				=> true,
			'publicly_queryable'	=> true,
			'exclude_from_search'	=> true,
			'menu_position'			=> null,
			'capability_type'		=> 'post',
			'menu_icon'				=> get_stylesheet_directory_uri() . '/lib/img/menu_photos.png',
			'query_var'				=> true,
			'rewrite'				=> false,
			'has_archive'			=> false,
			'supports'				=> array('title', 'editor', 'thumbnail'),
		)
	);
	register_taxonomy(
		'tutorial-type',
		array( 'tutorials' ),
		array(
			'public' => true,
			'show_in_nav_menus' => true,
			'show_ui' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'hierarchical' => false,
			'query_var' => true,
			'rewrite' => array ( 'slug' => 'tutorial-type', 'with_front' => false ),
			'labels' => array(
				'name'								=> __('Tutorial Type'),
				'singular_name'						=> __('Tutorial Type'),
				'search_items'						=> __('Search Tutorial Types'),
				'popular_items'						=> __('Popular Tutorial Types'),
				'all_items'							=> __('All Tutorial Types'),
				'parent_item'						=> __('Parent Tutorial Type'),
				'parent_item_colon'					=> __('Parent Tutorial Type:'),
				'edit_item'							=> __('Edit Tutorial Type'),
				'update_item'						=> __('Update Tutorial Type'),
				'add_new_item'						=> __('Add New Tutorial Type'),
				'new_item_name'						=> __('New Tutorial Type'),
				'add_or_remove_items'				=> __('Add or remove Tutorial types'),
				'choose_from_most_used'				=> __('Choose from the most used Tutorial types'),
				'separate_items_with_commas'		=> __('Separate Tutorial types with commas'),
			),
		)
	);
	register_taxonomy(
		'tool-type',
		array( 'tools' ),
		array(
			'public' => true,
			'show_in_nav_menus' => true,
			'show_ui' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'hierarchical' => false,
			'query_var' => true,
			'rewrite' => array ( 'slug' => 'tool-type', 'with_front' => true ),
			'labels' => array(
				'name'								=> __('Tool Type'),
				'singular_name'						=> __('Tool Type'),
				'search_items'						=> __('Search Tool Types'),
				'popular_items'						=> __('Popular Tool Types'),
				'all_items'							=> __('All Tool Types'),
				'parent_item'						=> __('Parent Tool Type'),
				'parent_item_colon'					=> __('Parent Tool Type:'),
				'edit_item'							=> __('Edit Tool Type'),
				'update_item'						=> __('Update Tool Type'),
				'add_new_item'						=> __('Add New Tool Type'),
				'new_item_name'						=> __('New Tool Type'),
				'add_or_remove_items'				=> __('Add or remove Tool types'),
				'choose_from_most_used'				=> __('Choose from the most used Tool types'),
				'separate_items_with_commas'		=> __('Separate Tool types with commas'),
			),
		)
	);
// set taxonomy registration
	register_taxonomy_for_object_type('tutorials', 'tutorial-type');
	register_taxonomy_for_object_type('tools', 'tool-type');
}

// change post title box text
function rkv_change_post_text( $title ) {
     $screen = get_current_screen();

     if  ( 'tutorials' == $screen->post_type ) :
          $title = 'Tutorial Name';
     endif;

     return $title;
}

add_filter('enter_title_here', 'rkv_change_post_text');

// column setup
/*
function rkv_register_columns( $columns ) {
    $columns['featured'] = __( 'Featured');

    return $columns;
}

function rkv_display_columns( $column_name ) {

    if ( 'featured' != $column_name )
        return;

    global $post;
    $featured = get_post_meta($post->ID, '_rkv_post_featured', true);

    if ( !empty($featured) )
        echo '<span class="meta-item"><img src="'.get_bloginfo('stylesheet_directory').'/lib/img/meta-yes.png" alt="Featured" title="Featured"></span>';
}

add_filter ( 'manage_edit-post_columns',   'rkv_register_columns' );
add_action ( 'manage_posts_custom_column', 'rkv_display_columns', 10, 2 );
*/

// create sort pages
add_action('admin_menu' , 'create_sort_pages');

function create_sort_pages() {
    add_submenu_page('edit.php?post_type=speaking', 'Sort Items', 'Sort Items', 'edit_posts', 'sort-speaking', 'speaking_sort_order');
    add_submenu_page('edit.php?post_type=downloads', 'Sort Items', 'Sort Items', 'edit_posts', 'sort-downloads', 'downloads_sort_order');
    add_submenu_page('edit.php?post_type=plugins', 'Sort Plugins', 'Sort Plugins', 'edit_posts', 'sort-plugins', 'plugins_sort_order');
}

function sortable_print_scripts() {
    global $pagenow;

    $pages = array('edit.php');
    if (in_array($pagenow, $pages)) {
        wp_enqueue_script('jquery-ui-sortable');
    }
}
add_action( 'admin_enqueue_scripts', 'sortable_print_scripts' );


function save_sortable_order() {
    global $wpdb; // WordPress database class

    $order = explode(',', $_POST['order']);
    $counter = 0;

    foreach ($order as $item_id) {
        $wpdb->update($wpdb->posts, array( 'menu_order' => $counter ), array( 'ID' => $item_id) );
        $counter++;
    }
    die(1);
}
add_action('wp_ajax_sortable_sort', 'save_sortable_order');

function speaking_sort_order() {
    $svcs = new WP_Query('post_type=speaking&post_status=publish&posts_per_page=-1&orderby=menu_order&order=ASC');
?>
    <div class="wrap custom-sort-wrap">
    <h3>Sort Items <img src="<?php bloginfo('stylesheet_directory'); ?>/lib/img/loading.gif" id="loading-animation" /></h3>
    <ul id="custom-type-list">
    <?php
    while ( $svcs->have_posts() ) : $svcs->the_post();
    ?>
        <li id="<?php the_id(); ?>"><?php the_title(); ?></li>
    <?php endwhile; ?>
    </ul>
    </div>

<?php }

function downloads_sort_order() {
    $svcs = new WP_Query('post_type=downloads&post_status=publish&posts_per_page=-1&orderby=menu_order&order=ASC');
?>
    <div class="wrap custom-sort-wrap">
    <h3>Sort Items <img src="<?php bloginfo('stylesheet_directory'); ?>/lib/img/loading.gif" id="loading-animation" /></h3>
    <ul id="custom-type-list">
    <?php
    while ( $svcs->have_posts() ) : $svcs->the_post();
    ?>
        <li id="<?php the_id(); ?>"><?php the_title(); ?></li>
    <?php endwhile; ?>
    </ul>
    </div>

<?php }


function plugins_sort_order() {
    $svcs = new WP_Query('post_type=plugins&post_status=publish&posts_per_page=-1&orderby=menu_order&order=ASC');
?>
    <div class="wrap custom-sort-wrap">
    <h3>Sort Plugins <img src="<?php bloginfo('stylesheet_directory'); ?>/lib/img/loading.gif" id="loading-animation" /></h3>
    <ul id="custom-type-list">
    <?php
    while ( $svcs->have_posts() ) : $svcs->the_post();
    ?>
        <li id="<?php the_id(); ?>"><?php the_title(); ?></li>
    <?php endwhile; ?>
    </ul>
    </div>

<?php }
