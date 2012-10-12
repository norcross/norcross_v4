<?php

function rkv_menu_count() {
	
	$primary	= 'primary';
	$locations	= get_nav_menu_locations();
	$menu_obj	= get_term( $locations[$primary], 'nav_menu' );

	// Echo count of items in menu
	return $menu_obj->count;
}

function rkv_plugin_data($slug) {

	$trans_slug = 'norcross-plugin-'.$slug;
	// check for stored transient. if none present, create one
	if( false == get_transient( $trans_slug ) ) {	

		$data_call = array(
			'action'	=> 'plugin_information',
			'request'	=> serialize(
				(object)array(
					'slug'		=> $slug,
					'fields'	=> array(
						'description' => true
						)
				)
			)
		);

		$repository = wp_remote_post( 'http://api.wordpress.org/plugins/info/1.0/', array( 'body' => $data_call) );
		$response	= $repository['body'];

		// Save a transient to the database
		set_transient($trans_slug, $response, 60*60*1 );
	
	} // end transient check

	// check for transient cache'd result
	$response = get_transient( $trans_slug );
	
	if( is_wp_error( $response ) ) {
		echo 'Something went wrong!';
		
	} else {
		$plugin = $response;
	}

	return $plugin;

}

function rkv_plugin_sidebar() {
			// get plugin data
		global $post;
		$slug 		= get_post_meta($post->ID, '_rkv_plugin_slug', true);
		$data 		= rkv_plugin_data($slug);
		$data		= unserialize($data);
		
		$plugname	= $data->name;
		$plugslug	= $data->slug;
		$version	= $data->version;
		$requires	= $data->requires;
		$tested		= $data->tested;
		$updated	= $data->last_updated;
		$downloaded	= $data->downloaded;
		$wordpress	= 'http://wordpress.org/extend/plugins/'.$plugslug.'/';
		$support	= 'http://wordpress.org/support/plugin/'.$plugslug.'/';

		// rating calculation
		$total_rate	= $data->num_ratings;
		$ratings	= $data->rating;
		$star_calc	= ( $ratings / 100 ) * 92;
		$star_rate	= '<div class="star-holder"><div class="star-rating" style="width:'.$star_calc.'px">'.$ratings.'</div></div>';

		$r_ratings	= ceil($ratings);
		$w_ratings	= ($r_ratings / 100) * 5;		
//		$star_calc	= round($w_ratings, 1, PHP_ROUND_HALF_EVEN);
		

		echo '<div class="widget plugin-details" itemtype="http://schema.org/AggregateRating" itemscope="" itemprop="aggregateRating">';
		echo '<meta content="0" itemprop="worstRating">';
		echo '<meta content="'.$w_ratings.'" itemprop="ratingValue">';
		echo '<meta content="5" itemprop="bestRating">';
		echo '<meta content="'.$total_rate.'" itemprop="ratingCount">';
		echo '<h4 class="nav-header">'.$plugname .' Details <i class="icon icon-bookmark pull-right"></i></h4>';
		echo '<table class="table table-condensed"><tbody>';
		echo '<tr><td>Version</td><td>'.$version.'</td></tr>';
		echo '<tr><td>Requires</td><td>'.$requires.'</td></tr>';
		echo '<tr><td>Compatible</td><td>'.$tested.'</td></tr>';
		echo '<tr><td>Last Updated</td><td>'.$updated.'</td></tr>';
		echo '<tr><td>Downloads</td><td>'.$downloaded.'</td></tr>';
		
		echo '<tr><td>Rating</td><td>'.$star_rate.'</td></tr>';
		echo '<tr><td class="noline"></td><td class="noline">'.$w_ratings.' <small>out of</small> 5 stars</td></tr>';

		echo '</tbody></table>';

		echo '<p class="plugin-links row-fluid">';
		echo '<a title="View on WP.org" target="_blank" class="btn btn-primary pull-left" href="'.$wordpress.'"><i class="icon-white icon-cogs"></i> View at WP.org</a>';
		echo '<a title="Support Forum" target="_blank" class="btn btn-danger pull-right" href="'.$support.'"><i class="icon-white icon-wrench"></i> Support Forums</a>';
		echo '</p>';
		echo '<input type="hidden" id="theme-root" value="'.get_bloginfo('stylesheet_directory').'" />';
		echo '<input type="hidden" id="rating-value" value="'.$star_calc.'" />';
		echo '</div>';
}

function rkv_plugin_favorites() {

	/** If plugins_api isn't available, load the file that holds the function */
	if ( ! function_exists( 'plugins_api' ) )
		require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );

	/** Prepare our query */
	$api = plugins_api( 'query_plugins',
		array(
			'user'		=> 'norcross',
		)
	);

	/** Display the results */
	if (is_wp_error( $api ) )
		echo 'Something went wrong!';
	else
		$favorites = $api->plugins;

		shuffle($favorites);

		// grab the first one after randomizing the array
		$plugin_name	= $favorites[0]->name;
		$plugin_slug	= $favorites[0]->slug;
		$plugin_link	= $favorites[0]->homepage;
		$plugin_text	= $favorites[0]->short_description;
		$author_name	= $favorites[0]->author;
		$author_link	= $favorites[0]->author_profile;

		echo '<div class="widget plugin-details plugin-favorite">';
		echo '<h4 class="nav-header">Other Favorites <i class="icon icon-tags pull-right"></i></h4>';
		
		// first one
		echo '<div class="favorite-single">';
		echo '<h5><a href="'.$plugin_link.'" target="_blank">'.$plugin_name.'</a></h5>';
		echo '<p class="plugin-author"><em><small>by</small></em> <a href="'.$author_link.'" target="_blank">'.$author_name.'</a></p>';
		echo '<p>'.$plugin_text.'</p>';
		echo '<p class="more-link"><a class="btn" href="http://wordpress.org/extend/plugins/'.$plugin_slug.'/" target="_blank">Learn More &rarr;</a></p>';
		echo '</div>';

		// now grab the second one after randomizing the array
		$plugin_name	= $favorites[1]->name;
		$plugin_slug	= $favorites[1]->slug;
		$plugin_link	= $favorites[1]->homepage;
		$plugin_text	= $favorites[1]->short_description;
		$author_name	= $favorites[1]->author;
		$author_link	= $favorites[1]->author_profile;

		// second one
		echo '<div class="favorite-single">';
		echo '<h5><a href="'.$plugin_link.'" target="_blank">'.$plugin_name.'</a></h5>';
		echo '<p class="plugin-author"><em><small>by</small></em> <a href="'.$author_link.'" target="_blank">'.$author_name.'</a></p>';
		echo '<p>'.$plugin_text.'</p>';
		echo '<p class="more-link"><a class="btn" href="http://wordpress.org/extend/plugins/'.$plugin_slug.'/" target="_blank">Learn More &rarr;</a></p>';
		echo '</div>';

		// close it out
		echo '</div>';

}


function rkv_post_details() {
	// get variables
	global $post;
	$category	= get_the_category($post->ID);
	$cat_name	= $category[0]->cat_name;
	$cat_link	= get_category_link( $category[0]->cat_ID );
	$post_date	= get_the_date('F jS, Y');
	$schm_date	= get_the_date('c');
	$auth_id	= get_the_author_meta( 'ID' );
	$auth_name	= get_the_author_meta( 'display_name' );
	$auth_url	= get_author_posts_url($auth_id);

	echo '<p class="post-details">';
	echo '<span class="detail-item author vcard hidden-phone"><i class="icon icon-user"></i> <span class="fn"><a href="'.$auth_url.'" rel="author" title="View all posts by '.$auth_name.'">'.$auth_name.'</a></span></span>';
	echo '<span title="'.$schm_date.'" class="detail-item date published updated time"><i class="icon icon-calendar"></i> '.$post_date.'</span>';
	echo '<span class="detail-item detail-last detail-comment"><i class="icon icon-comments"></i> ';
	echo comments_popup_link( 'Leave a Comment', '1 Comment', '% Comments', '', '' );
	echo '</span>';
	echo '<span class="detail-item detail-category pull-right"><a class="label label-primary" title="View all posts in '.$cat_name.'" href="'.$cat_link.'">'.$cat_name.'</a></span>';
	echo '</p>';
}

function rkv_tutorial_details() {
	// get variables
	global $post;
	$tax_term	= get_the_terms($post->ID, 'tutorial-type');

	if( empty($tax_term) )
		return;

	$term_root = array_merge($tax_term);
	$term_name	= $term_root[0]->name;
	$term_slug	= $term_root[0]->slug;
	$term_id	= $term_root[0]->term_id;
	$term_link	= get_term_link( $term_slug, 'tutorial-type' );
	$post_date	= get_the_date('F jS, Y');
	$auth_id	= get_the_author_meta( 'ID' );
	$auth_name	= get_the_author_meta( 'display_name' );
	$auth_url	= get_author_posts_url($auth_id);

	echo '<p class="post-details">';
	echo '<span class="detail-item"><i class="icon icon-user"></i> <a href="'.$auth_url.'" rel="author" title="View all posts by '.$auth_name.'">'.$auth_name.'</a></span>';
	echo '<span class="detail-item"><i class="icon icon-calendar"></i> '.$post_date.'</span>';
	echo '<span class="detail-item detail-last"><i class="icon icon-comment"></i> ';
	echo comments_popup_link( 'Leave a Comment', '1 Comment', '% Comments', '', '' );
	echo '</span>';
	echo '<span class="detail-item detail-category pull-right"><a class="label label-primary" title="View all posts in '.$term_name.'" href="'.$term_link.'">'.$term_name.'</a></span>';
	echo '</p>';
}

// get taxonomies terms links
function custom_tax_links($tax_type) {
	global $post, $post_id;

	$terms = get_the_terms( $post->ID, $tax_type );

	// no terms? bail
	if(!$terms)
		return;

	// got some? give'em back
	if ( $terms && ! is_wp_error( $terms ) ) : 

		$term_links = array();

		foreach ( $terms as $term ) {
			$term_links[] = '<span class="label pull-right link-label"><a href="' .get_term_link($term->slug, $tax_type) .'">'.$term->name.'</a></span>';
		}
						
	$term_labels = join( ' ', $term_links );

	return $term_labels;

	endif;
}

// social buttons
function rkv_social() {
	global $post;
	$link = get_permalink($post->ID);
	$text = get_the_title($post->ID);
	?>

	<div class="social-button-container">
 
	    <!-- Twitter -->
	    <div class="social-twitter">
	    	<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $link; ?>" data-text="<?php echo $text; ?>" data-via="norcross" data-count="horizontal" data-size="medium" data-dnt="true">Tweet</a>
	    </div>
	 
	    <!-- Google Plus -->
	    <div class="social-gplus">
	    	<div class="g-plusone" data-size="medium" data-annotation="inline" data-width="200" data-href="<?php echo $link; ?>"></div>
	    </div>
	 
 
	</div>

<?php }

// downloads list
function rkv_music_list() {

    $args = array (
        'fields'        => 'ids',
        'post_type'     => 'downloads',
        'numberposts'   => -1,
        'meta_key'      => '_rkv_download_url',
    );

    $dlist_query = get_posts( $args );

    $dlist_count = (count($dlist_query) > 0 ) ? true : false;

    if($dlist_count == false)
        return;

    echo '<div class="widget widget_downloads" id="download-list">';

    echo '<h4 class="nav-header"><i class="icon icon-download-alt pull-right"></i> Back Issues</h4>';    
    echo '<ul>';
    
    foreach ($dlist_query as $dload):
        $dlist_file     = get_post_meta($dload, '_rkv_download_url', true);
        $dlist_title    = get_the_title($dload);
        
        echo '<li><a href="'.$dlist_file.'">'.$dlist_title.'</a></li>';
                
    endforeach;

    echo '</ul>';
    echo '</div>';
}


// instagram feed
/*
Client ID 		7ff72e53f4af49d890df3ef3731e8234
Client Secret 	c80efc2b883748a09e13e5a8465caae0
Website URL 	http://andrewnorcross.com
Redirect URI 	http://andrewnorcross.com
http://andrewnorcross.com/#access_token=30588932.7ff72e5.47a653791d604efd8c8cb7eaec695ed2
https://api.instagram.com/oauth/authorize/?client_id=7ff72e53f4af49d890df3ef3731e8234&redirect_uri=http://andrewnorcross.com&response_type=token
*/
function rkv_instagram_feed() {

	if( false == get_transient( 'rkv_instagram' ) ) {	

		$args = array (
			'sslverify'	=> false
			);

		$user	= '30588932';
		$token	= '30588932.7ff72e5.47a653791d604efd8c8cb7eaec695ed2';
		$count	= 60;
		
		$request	= new WP_Http;
		$url		= 'https://api.instagram.com/v1/users/self/media/recent?access_token='.$token.'&count='.$count.'';
		$response	= wp_remote_get ( $url, $args );

		// Save a transient to the database
			set_transient('rkv_instagram', $response, 60*60*12 );

	} // end transient check 

		// check for transient cache'd result
	$response = get_transient( 'rkv_instagram' );

	if( is_wp_error( $response ) ) {
		echo '<p>Sorry, there was an error with your request.</p>';
	} else {
		$instagram_array	= json_decode( $response['body'] );
	}



	// list individual items
	$photos = $instagram_array->data;

		foreach ( $photos as $photo ) :
			// make caption with fallback
			$caption_base	= $photo->caption;
			$image_caption	= empty($caption_base->text) ? '' : $caption_base->text;
			$image_caption	= str_replace('@', '', $image_caption);

			// build thumbnail  150px
			$thumb_base		= $photo->images->thumbnail;
			$thumb_url		= $thumb_base->url;
			$thumb_ht		= $thumb_base->height;
			$thumb_wd		= $thumb_base->width;
			
			// build standard  306px
			$standard_base	= $photo->images->low_resolution;
			$standard_url	= $standard_base->url;
			$standard_ht	= $standard_base->height;
			$standard_wd	= $standard_base->width;

			// build fullsize  612px
			$fullsize_base	= $photo->images->standard_resolution;
			$fullsize_url	= $fullsize_base->url;
			$fullsize_ht	= $fullsize_base->height;
			$fullsize_wd	= $fullsize_base->width;

			echo '<div class="instagram-photo">';
			echo '<a class="instagram-link" href="'.$fullsize_url.'" title="'.$image_caption.'" rel="instagram-gallery">';
//			echo '<img src="'.$thumb_url.'" alt="'.$image_caption.'" title="'.$image_caption.'" height="'.$thumb_ht.'" width="'.$thumb_wd.'">';
			echo '<img class="instagram-pic" src="'.$standard_url.'" alt="'.$image_caption.'" title="'.$image_caption.'">';
			echo '</a>';
			echo '</div>';

		endforeach;

}

function rkv_github_userdata() {

	if( false == get_transient( 'rkv_github_user' ) ) {	

		$args 	= array (
			'sslverify'		=> false,
		);

		$request	= new WP_Http;
		$url		= 'https://api.github.com/users/norcross';
		$response	= wp_remote_get ( $url, $args );

		// Save a transient to the database
		set_transient('rkv_github_user', $response, 60*60*12 );

	} // end transient check 

	$response = get_transient( 'rkv_github_user' );

	$user_raw	= $response['body'];
	$user_data	= json_decode($user_raw);

	return $user_data;

}


function rkv_github_repos() {

	if( false == get_transient( 'rkv_github_repos' ) ) {	

		$args 	= array (
			'sslverify'		=> false,
		);

		// grab username and total gists to grab
		$user	= 'norcross';

		$request	= new WP_Http;
		$url		= 'https://api.github.com/users/'.urlencode($user).'/repos?&type=owner&per_page=8&sort=updated';
		$response	= wp_remote_get ( $url, $args );

		// Save a transient to the database
		set_transient('rkv_github_repos', $response, 60*60*12 );

	} // end transient check 

	$response = get_transient( 'rkv_github_repos' );

	$data_raw	= $response['body'];
	$data_array	= json_decode($data_raw);

	// now build the bastard
	echo '<div class="widget widget-github-repos" id="github-repos">';
	echo '<h4 class="nav-header"><i class="icon icon-github-sign pull-right"></i>GitHub Repositories</h4>';
	echo '<ul>';
	foreach ($data_array as $data) {
		echo '<li><a href="' . $data->html_url . '">' . str_replace('-', ' ', $data->name) . '</a></li>';
	}
	echo '</ul>';

	$userdata = rkv_github_userdata();

	echo '<div class="github-button">';
	echo '<a class="btn btn-mini btn-primary github-link" href="http://github.com/norcross" title="Follow Me On Github" target="_blank"><i class="icon icon-github"></i> follow @norcross on GitHub</a>';
//	echo '<span class="github-count">'.$userdata->followers.'</span>';
	echo '</div>';

	echo '</div>';
}


function rkv_snippet_search() {
		echo '<div class="input-append">';
		echo '<form class="searchform" role="search" method="get" id="snippet-search" action="' . home_url( '/' ) . '" >';
		echo '<input type="text" value="' . get_search_query() . '" name="s" id="s" class="s" />';
		echo '<input type="submit" class="btn btn-primary" value="Search" id="snippetsubmit">';
		echo '<input type="hidden" name="post_type" value="snippets" />';
		echo '</form>';
		echo '</div>';
}
