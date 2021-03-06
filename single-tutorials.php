<?php get_header(); ?>
<div id="content-wrap" class="row">
  
    <div id="content" class="span8 blog-post">
    <div class="well">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    
        <section <?php post_class() ?> id="post-<?php the_ID(); ?>">
    
            <div class="post-title-area">
                <h1 class="entry-title"><?php the_title(); ?></h1>
                <?php echo rkv_tutorial_details(); ?>
            </div>
            
            <div class="post-content-area">
                <div class="entry-content">
                <?php the_content(); ?>
                </div>

                <?php echo rkv_social(); ?>
            </div>

        </section>

               
        <?php comments_template(); ?>
    <?php endwhile; endif; ?>
  
    </div><!--/span-->
    </div>    
	<?php get_sidebar(); ?>

</div><!--/row-->
<?php get_footer(); ?>
