<?php get_header(); ?>
<div id="content-wrap" class="row">
    <div id="content" class="span8">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    
        <div class="hero-unit home-content well">
        <?php the_content(); ?>
        <p><a href="<?php bloginfo('url'); ?>/about/" class="btn btn-primary btn-large">Learn more &raquo;</a></p>
        </div>

    <?php endwhile; endif; ?>

        <div class="row-fluid home-row">

            <div class="span4 home-item">
                <h2><i class="icon icon-bolt"></i><a href="<?php bloginfo('url'); ?>/plugins/">Plugins</a></h2>
                
                <p class="home-info">I love the WordPress community. So I've tried to contribute however I can, which for now is plugins.</p>
                
                <p><a class="btn btn-primary" href="<?php bloginfo('url'); ?>/plugins/">Check Them Out &raquo;</a></p>
            </div>

            <div class="span4 home-item">
                <h2><i class="icon icon-beaker"></i><a href="<?php bloginfo('url'); ?>/tutorials/">Tutorials</a></h2>
                
                <p class="home-info">I write a lot of code. A LOT. While a lot isn't very useful outside of my own projects, I try to share whatever I can.</p>
                
                <p><a class="btn btn-primary" href="<?php bloginfo('url'); ?>/tutorials/">Learn Something &raquo;</a></p>
            </div>

            <div class="span4 home-item">
                <h2><i class="icon icon-cut"></i><a href="<?php bloginfo('url'); ?>/snippets/">Snippets</a></h2>
                
                <p class="home-info">Random code I've written. May be helpful for others.</p>
                <p><a class="btn btn-primary" href="<?php bloginfo('url'); ?>/snippets/">View Them &raquo;</a></p>

            </div>

        </div><!--/home-row-->
    
    </div><!--/content-->
        
    <?php get_sidebar(); ?>

</div><!--/row-->
<?php get_footer(); ?>
