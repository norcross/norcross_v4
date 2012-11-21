<?php get_header(); ?>
<div class="row well plugin-well">
  
	

	<section id="plugin-archives" class="span12">
<!--  	<div class="row-fluid well"> -->
  		
	    <?php
	    if (have_posts()) : while (have_posts()) : the_post();

		global $post;
		$slug	= get_post_meta($post->ID, '_rkv_plugin_slug', true);
		$banner	= get_post_meta($post->ID, '_rkv_plugin_img', true);
		$link	= get_permalink($post->ID);
		$data	= rkv_plugin_data($slug);
		$data	= unserialize($data);
	//	echo preprint( $data );

		// plugin data
		$plugin_name	= $data->name;
		$description	= $data->description;

		echo '<div class="span4 plugin-single">';
		echo '<a href="'.$link.'" title="'.$plugin_name.'"><img class="plugin-banner" src="'.$banner.'" alt="'.$plugin_name.'" title="'.$plugin_name.'"></a>';
		echo '<h3><a href="'.$link.'" title="'.$plugin_name.'">'.$plugin_name.'</a></h3>';
		echo '<div class="plugin-text">'.$description.'</div>';
	//	echo $description;
		echo '<p class="plugin-link"><a class="btn" title="View details of '.$plugin_name.'" href="'.$link.'">View details &raquo;</a></p>';

		echo '</div>';

		endwhile;
		endif;
		?>

  </section>
  
        
</div><!--/row-->
<?php get_footer(); ?>
