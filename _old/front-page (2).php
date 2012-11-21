<?php get_header(); ?>

    <div id="content-wrap" class="home-wrap">

    <div id="content">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    
        <div id="home-content" class="inner-thick">
            <img class="alignleft frame" title="This Is A Picture Of Me. There Are Many Like It....Wait A Minute. No There Is Not." alt="This Is A Picture Of Me. There Are Many Like It....Wait A Minute. No There Is Not." src="<?php bloginfo('stylesheet_directory'); ?>/images/diner-coffee.jpg" />
        
            <h1 class="entry-title home-title">Hello</h1>
            <h2>I'm Norcross</h2>
            <?php the_content(); ?>

            <p class="home-button"><a href="<?php bloginfo('url'); ?>/about/" class="btn btn-primary btn-large">Learn more &raquo;</a></p>

        </div>

    <?php endwhile; endif; ?>
    </div><!--/content-->
        
    <?php // get_sidebar(); ?>
    
    <div id="sidebar" class="inner home-sidebar">
        <div class="sidebar-wrap">

        <div class="widget widget-home-block" id="home-plugins">
            <h4 class="widget-header"><a href="<?php bloginfo('url'); ?>/plugins/">Plugins</a><i class="icon icon-bolt set-right"></i></h4>
            <p>In my opinion, plugins are the main reason that WordPress is so fantastic to use. Here are some I've built.</p>
            <p class="widget-button"><a class="btn btn-primary" href="<?php bloginfo('url'); ?>/plugins/">Check Them Out &raquo;</a></p>
        </div>

        <div class="widget widget-home-block" id="home-tutorials">
            <h4 class="widget-header"><a href="<?php bloginfo('url'); ?>/tutorials/">Tutorials</a><i class="icon icon-beaker set-right"></i></h4>
            <p>Almost everything I know about coding I've learned elsewhere. Maybe I can teach y'all something.</p>
            <p class="widget-button"><a class="btn btn-primary" href="<?php bloginfo('url'); ?>/tutorials/">Learn Something &raquo;</a></p>
        </div>

        <div class="widget widget-home-block" id="home-snippets">
            <h4 class="widget-header"><a href="<?php bloginfo('url'); ?>/snippets/">Snippets</a><i class="icon icon-cut set-right"></i></h4>
            <p>I write a lot of code. A LOT. I've spent a good amount of time building a library of snippets for myself and others.</p>
            <p class="widget-button"><a class="btn btn-primary" href="<?php bloginfo('url'); ?>/snippets/">View Them &raquo;</a></p>
        </div>

        </div>
    </div>

    </div> <!-- end content wrap -->

<?php get_footer(); ?>
