<?php get_header(); ?>

<div id="content-wrap" class="row">
  
    <div id="content" class="span8 blog-list post-list">
    <div id="content-block" class="well">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        
            <section <?php post_class() ?> id="post-<?php the_ID(); ?>">
            
                <div class="post-title-area">
                    <h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
                </div>

                <div class="post-content-area row-fluid">
                <?php
                if (has_post_thumbnail()):
                    echo '<div class="pull-right thumbnail-block span3">';
                    $title = get_the_title();
                    echo '<a href="'.get_permalink().'">'.get_the_post_thumbnail($id, 'blog-page', array(
                            'class' => 'opacity post_image thumbnail',
                            'alt'   => $title,
                            'title' => $title
                    )).'</a>';
                    echo '</div>';
                
                    echo '<div class="pull-left post-excerpt span9">';
                    the_excerpt();
                    echo '</div>';
                else :

                    echo '<div class="pull-left post-excerpt span12">';
                    the_excerpt();
                    echo '</div>';

                endif;
                ?>
                </div>
                <?php echo rkv_post_details(); ?>          
            <hr />
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
