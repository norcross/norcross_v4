<?php get_header(); ?>
<div id="content-wrap" class="row">
  
  <div id="content" class="span12">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    
    <section <?php post_class() ?> id="post-<?php the_ID(); ?>">
     
	<?php
	global $post;
	$dl_file	= get_post_meta($post->ID, '_rkv_download_url', true);
    $dl_title	= get_the_title($post->ID);
		echo '<div class="post-title-area">';
		echo '<h1>'.$dl_title.'</h1>';
		echo '</div>';

		echo '<div class="post-content-area">';
		echo '<div class="entry-content">';
		if(!empty($dl_file))
			echo '<p>File not downloading? <a href="'.$dl_file.'" target="_blank" title="Download '.$dl_title.'">Get it here</a></p>';

		if(empty($dl_file))
			echo '<p>Whoops...looks like '.$dl_title.' is missing something. Maybe later?</p>';

		echo '</div>';
		echo '</div>';
    ?>
		
        
        

		
			

        	

    </section>


    <?php endwhile; endif; ?>
  
  </div><!--/span-->
       

</div><!--/row-->
<?php get_footer(); ?>
