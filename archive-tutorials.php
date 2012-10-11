<?php get_header(); ?>
<div id="content-wrap" class="row">
  
    <div id="content" class="span8 tutorials-list post-list">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    
        <section <?php post_class() ?> id="post-<?php the_ID(); ?>">
        
            <div class="post-title-area">
                <h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
            </div>

            <div class="post-content-area">
            <?php the_excerpt(); ?>
            </div>

        <?php echo rkv_tutorial_details(); ?>
        
        <hr />
        </section>

    
    <?php endwhile; endif; ?>
    
    </div><!--/span-->
        
	<?php get_sidebar(); ?>

</div><!--/row-->
<?php get_footer(); ?>
