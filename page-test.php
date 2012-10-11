<?php
/*
Template Name: Test
*/
?>
<?php get_header(); ?>
<div class="row">
  
  <div id="content" class="span12">
    <?php


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

    ?>
  
  </div><!--/span-->
        
	

</div><!--/row-->
<?php get_footer(); ?>
