<?php get_header(); ?>
<div id="content-wrap" class="row-fluid">
  
    <div id="content" class="span8 snippets-list post-list">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    
        <section <?php post_class('snippet-block span4') ?> id="post-<?php the_ID(); ?>">
        
            <div class="post-title-area snippet-title-area">
                <h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
                <p><?php echo get_the_date('F jS, Y'); ?></p>
            </div>

       
        <hr />
        </section>

    
    <?php endwhile; ?>

        <?php
        if (function_exists('rkv_page_navi')) {
                        
            rkv_page_navi(); // use the page navi function
                        
        } else { // if it is disabled, display regular wp prev & next links ?>
            
            <nav class="wp-prev-next">
                <ul class="clearfix">
                    <li class="prev-link"><?php next_posts_link(_e('&laquo; Older Entries', "bonestheme")) ?></li>
                    <li class="next-link"><?php previous_posts_link(_e('Newer Entries &raquo;', "bonestheme")) ?></li>
                </ul>
            </nav>
        <?php } ?> 

    <?php endif; ?>
    
    </div><!--/span-->
        
	<?php get_sidebar(); ?>

</div><!--/row-->
<?php get_footer(); ?>
