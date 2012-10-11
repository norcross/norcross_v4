<?php get_header(); ?>
<div id="content-wrap" class="row">
  
    <div id="content" class="span8 speaking-list post-list">
    <?php
    if (have_posts()) :
    echo '<div id="content-block">';
    echo '<div id="content-inner" class="speaking-archives row-fluid">';
    while (have_posts()) : the_post();

        if ( has_post_thumbnail() ) { ?>

        <div class="speaking-block span4">
        
            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                <?php the_post_thumbnail('speaking'); ?>
                <div class="speaking-title"><span><?php the_title(); ?></span></div>
            </a>

        </div>


        <?php } ?>
    
       
   
    <?php endwhile; ?>
    </div>
    </div>
    <!--
    <nav class="wp-prev-next">
        <ul class="clearfix">
            <li class="prev-link"><?php next_posts_link('&laquo; Older Entries'); ?></li>
            <li class="next-link"><?php previous_posts_link('Newer Entries &raquo;'); ?></li>
        </ul>
    </nav>
    -->
    <?php endif; ?>
    
    </div><!--/span-->
        
	<?php get_sidebar(); ?>

</div><!--/row-->
<?php get_footer(); ?>
