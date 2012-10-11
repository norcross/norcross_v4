<?php

if (is_singular('plugins')) :

echo '<div id="sidebar" class="span4">';
echo '<div class="well well-small sidebar-nav">';
echo '<div class="nav nav-list">';

	echo rkv_plugin_sidebar();

	echo rkv_plugin_favorites();

echo '</div>';
echo '</div>'; // well
echo '</div>'; //span

else:

echo '<div id="sidebar" class="span4 slide-sidebar">';
echo '<div class="well well-small sidebar-nav">';
echo '<div class="nav nav-list">';

	if (is_page('music') ) :
		echo rkv_music_list();
	endif;

	if (is_home() || is_category() || is_tag() || is_singular('post')) :
		dynamic_sidebar( 'blog-sidebar' );
	endif;

	if (is_post_type_archive(array ('snippets', 'tutorials') ) || is_singular('tutorials')) :
		echo rkv_github_repos();
	endif;

	if (!is_singular('plugins')) :
		dynamic_sidebar( 'main-sidebar' );
	endif;

	


echo '</div>';
echo '</div>'; // well
echo '</div>'; //span

endif;