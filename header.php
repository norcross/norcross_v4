<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php wp_title(''); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Andrew Norcross">
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" />
	
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php if ( is_singular('post') ) wp_enqueue_script( 'comment-reply' ); ?>
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->


    <link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/lib/img/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php bloginfo('stylesheet_directory'); ?>/lib/img/icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php bloginfo('stylesheet_directory'); ?>/lib/img/114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php bloginfo('stylesheet_directory'); ?>/lib/img/72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php bloginfo('stylesheet_directory'); ?>/lib/img/icon-57-precomposed.png">

	<?php wp_head(); ?>
	
</head>

<body <?php body_class('norcross'); ?> itemtype="http://schema.org/Blog" itemscope="">

<div id="wrapper">

    <div id="header" class="inner-thin">
        <div class="header-wrap">
            <div class="face-logo set-left">
                <a class="face-icon" href="<?php bloginfo('url'); ?>/"><img class="nav-avatar" src="<?php bloginfo('stylesheet_directory'); ?>/images/norcrosshead-icon.png" alt="<?php bloginfo('name'); ?>" title="<?php bloginfo('name'); ?>"></a>
                <span class="text-title"><?php bloginfo('name'); ?></span>
                
            </div>

            <?php
            // nav menu
            wp_nav_menu( array (
                'theme_location'    => 'primary',
                'container_class'   => 'main-navigation',
                'container_id'      => false,
                'menu_class'        => 'nav',
                'menu_id'           => false,
                'depth'             => '2', /* suppress lower levels for now */
                'walker'            => new description_walker()             
            )); 
            ?>

            <div class="social-header set-right">
                <a href="http://twitter.com/norcross/" title="Norcross on Twitter" target="_blank"><i class="icon icon-twitter"></i></a>
                <a href="http://github.com/norcross" title="Norcross on Github" target="_blank"><i class="icon icon-github"></i></a>
                <a href="https://plus.google.com/101309579396817654042/posts" title="Norcross on Google Plus" target="_blank"><i class="icon icon-google-plus"></i></a>
                <a href="<?php bloginfo('rss2_url'); ?>" title="RSS Feed" target="_blank"><i class="icon icon-rss"></i></a>
            </div> 
        </div>
    </div>

