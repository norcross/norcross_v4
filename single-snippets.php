<?php get_header(); ?>
<div id="content-wrap" class="row">
  
    <div id="content" class="span12 blog-post single-snippet">
    <?php if (have_posts()) : while (have_posts()) : the_post();
        global $post;
        $gist_url   = get_post_meta($post->ID, '_rkv_gist_url', true);
        $gist_id    = get_post_meta($post->ID, '_rkv_gist_id', true);
    ?>
    
        <section <?php post_class() ?> id="post-<?php the_ID(); ?>">
    
            <div class="post-title-area single-snippet-title">
                <h1 class="entry-title">
                    <?php the_title(); ?>
                    <a class="ex-link" href="<?php echo esc_url($gist_url); ?>" target="_blank" title="View this on GitHub"><i class="icon icon-link"></i></a>
                </h1>
            </div>
            
            <div class="post-content-area">
                <?php echo rkv_social(); ?>
                <div class="entry-content">
                <?php the_content(); ?>
                </div>
            </div>

        </section>
              
    <?php
    endwhile;
    echo '<div class="snippet-navigation">';
        echo '<span class="pull-left">';
        previous_post_link();
        echo '</span>';

        echo '<span class="pull-right">';
        next_post_link();
        echo '</span>';
    echo '</div>';
    endif;
    ?>

  
    </div><!--/span-->

</div><!--/row-->
<?php get_footer(); ?>
