<?php get_header(); ?>
<div id="content-wrap" class="row">
    <div id="content" class="span8">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

        <div id="home-content" class="hero-unit well">
        <img class="alignleft frame" title="This Is A Picture Of Me. There Are Many Like It....Wait A Minute. No There Is Not." alt="This Is A Picture Of Me. There Are Many Like It....Wait A Minute. No There Is Not." src="<?php bloginfo('stylesheet_directory'); ?>/images/wpcs.jpg">

            <h1 class="entry-title">Hello</h1>
            <h2>I'm Norcross</h2>
            <?php the_content(); ?>
        <p><a href="<?php bloginfo('url'); ?>/about/" class="btn btn-primary pull-right">Learn more &raquo;</a></p>
        </div>

    <?php endwhile; endif; ?>


    </div><!--/content-->

    <?php // get_sidebar(); ?>

    <div id="sidebar" class="span4">
    <div class="well well-small sidebar-nav">
    <div class="nav nav-list">

        <div class="widget widget-home-block" id="home-plugins">
        <h4 class="nav-header"><i class="icon icon-bolt pull-right"></i><a href="<?php bloginfo('url'); ?>/plugins/">Plugins</a></h4>
        <p>In my opinion, plugins are the main reason that WordPress is so fantastic to use. Here are some I've built.</p>
        <p><a class="btn btn-primary" href="<?php bloginfo('url'); ?>/plugins/">Check Them Out &raquo;</a></p>
        </div>

        <div class="widget widget-home-block" id="home-tutorials">
        <h4 class="nav-header"><i class="icon icon-beaker pull-right"></i><a href="<?php bloginfo('url'); ?>/tutorials/">Tutorials</a></h4>
        <p>Almost everything I know about development I've learned from someone else. So maybe I can teach y'all something.</p>
        <p><a class="btn btn-primary" href="<?php bloginfo('url'); ?>/tutorials/">Learn Something &raquo;</a></p>
        </div>

        <div class="widget widget-home-block" id="home-snippets">
        <h4 class="nav-header"><i class="icon icon-git-fork pull-right"></i><a href="<?php bloginfo('url'); ?>/snippets/">Snippets</a></h4>
        <p>I write a lot of code. A LOT. I've spent a good amount of time building a library of snippets for myself and others.</p>
        <p><a class="btn btn-primary" href="<?php bloginfo('url'); ?>/snippets/">View Them &raquo;</a></p>
        </div>

    </div>
    </div>
    </div>

</div><!--/row-->
<?php get_footer(); ?>
