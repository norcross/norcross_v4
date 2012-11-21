<?php
/*
Template Name: Test
*/
?>
<?php get_header(); ?>
<div class="row">
  
  <div id="content" class="span12">
    <?php

/*
		$args 	= array (
			'sslverify'		=> false,
		);

		// grab username and total gists to grab
		$user	= 'norcross';

		$request	= new WP_Http;
		$url		= 'https://api.github.com/users/norcross';
		$response	= wp_remote_get ( $url, $args );

		$data_raw	= $response['body'];
		$data_array	= json_decode($data_raw);

		echo preprint($data_array);
*/

		$args = array (
			'sslverify'	=> false
			);

		$user	= '30588932';
		$token	= '30588932.7ff72e5.47a653791d604efd8c8cb7eaec695ed2';
		$count	= 2;
		
		$request	= new WP_Http;
		$url		= 'https://api.instagram.com/v1/users/self/media/recent?access_token='.$token.'&count='.$count.'';
		$response	= wp_remote_get ( $url, $args );

		if( is_wp_error( $response ) ) {
			echo '<p>Sorry, there was an error with your request.</p>';
		} else {
			$instagram_array	= json_decode( $response['body'] );
		}

	$photos = $instagram_array->data;

	echo preprint($photos);

    ?>
  
  </div><!--/span-->
        
	

</div><!--/row-->
<?php get_footer(); ?>
