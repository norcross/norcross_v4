<?php get_header(); ?>
<div class="row">
  
  <div id="content" class="span8">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    
    <section <?php post_class() ?> id="post-<?php the_ID(); ?>">
    
      <h3><?php the_title(); ?></h3>
      <?php the_content(); ?>
          
    </section>


    <?php endwhile; endif; ?>
  
  </div><!--/span-->
        
	<?php get_sidebar(); ?>

</div><!--/row-->
<?php get_footer(); ?>
