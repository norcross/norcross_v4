<?php

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

