<?php get_header(); ?>
<div id="content-wrap" class="row">
  
    <div id="content" class="span12 blog-post">
    <?php if (have_posts()) : while (have_posts()) : the_post();
        global $post;
        $gist_url   = get_post_meta($post->ID, '_rkv_gist_url', true);
        $gist_id    = get_post_meta($post->ID, '_rkv_gist_id', true);
    ?>
    
        <section <?php post_class() ?> id="post-<?php the_ID(); ?>">
    
            <div class="post-title-area">
                <h1>
                    <?php the_title(); ?>
                    <a class="ex-link" href="<?php echo esc_url($gist_url); ?>" target="_blank" title="View this on GitHub"><i class="icon icon-external-link"></i></a>
                </h1>
            </div>
            
            <div class="post-content-area">
                <div class="entry-content">
               
                <?php 
                echo '<div class="github-gist-block">';
                echo '<script src="https://gist.github.com/'.$gist_id.'.js"></script>';
                echo '</div>';
                ?>
               
                </div>

            </div>

        </section>
              
    <?php endwhile; endif; ?>
  
    </div><!--/span-->

</div><!--/row-->
<?php get_footer(); ?>
