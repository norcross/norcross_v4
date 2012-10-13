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

