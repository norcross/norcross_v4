<?php get_header(); ?>
<div id="content-wrap" class="row">

    <div id="content" class="span12 blog-post single-snippet">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

        <section <?php post_class() ?> id="post-<?php the_ID(); ?>">

            <div class="post-title-area single-photo-title">
                <h1 class="entry-title">
                    <?php the_content(); ?>
                </h1>
            </div>

            <div class="post-content-area">
                <div class="entry-content">
                <?php
                global $post;
                $img_attr = array(
                    'class' => 'single-photo',
                    'alt'   => trim(strip_tags( $post->post_content )),
                    'title' => trim(strip_tags( $post->post_content )),
                );
                $photo  = get_the_post_thumbnail($post->ID, 'ig-large', $img_attr);

                echo $photo;
                ?>
                </div>
            </div>

        </section>

    <?php
    endwhile;
    endif;
    ?>


    </div><!--/span-->

</div><!--/row-->
<?php get_footer(); ?>
