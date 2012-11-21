<?php get_header(); ?>
<div id="content-wrap" class="row-fluid">
  
    <div id="content" class="span8 snippets-list post-list">
    <div id="content-block" class="well">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        
        <section <?php post_class('snippet-block span4') ?> id="post-<?php the_ID(); ?>">
        
            <div class="post-title-area snippet-title-area">
                <h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
                <p><?php echo get_the_date('F jS, Y'); ?></p>
            </div>
        </section>

    
    <?php
    endwhile;
    rkv_page_navi();
    endif;
    ?>
    
    </div><!--/well-->
    </div><!--/span-->

        
	<?php get_sidebar(); ?>

</div><!--/row-->
<?php get_footer(); ?>
