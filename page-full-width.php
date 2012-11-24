<?php
/*
Template Name: Full Width
*/
?>
<?php get_header(); ?>
<div class="row">
  
    <div id="content" class="span12">

        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div class="well">
            <section <?php post_class() ?> id="post-<?php the_ID(); ?>">
    
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
          
            </section>
        </div>
        <?php endwhile; endif; ?>
    </div><!--/span-->

</div><!--/row-->
<?php get_footer(); ?>
