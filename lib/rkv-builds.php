<?php

function rkv_menu_count() {

	$primary	= 'primary';
	$locations	= get_nav_menu_locations();
	$menu_obj	= get_term( $locations[$primary], 'nav_menu' );

	// Echo count of items in menu
	return $menu_obj->count;
}


function rkv_plugin_sidebar() {
			// get plugin data
		global $post;
		$slug 		= get_post_meta($post->ID, '_rkv_plugin_slug', true);
		$data 		= rkv_plugin_data($slug);
		$data		= unserialize($data);

		$plugname	= $data->name;
		$plugslug	= $data->slug;
		$version	= $data->version;
		$requires	= $data->requires;
		$tested		= $data->tested;
		$added		= $data->added;
		$updated	= $data->last_updated;
		$downloaded	= $data->downloaded;
		$wordpress	= 'http://wordpress.org/extend/plugins/'.$plugslug.'/';
		$support	= 'http://wordpress.org/support/plugin/'.$plugslug.'/';

		// rating calculation
		$total_rate	= $data->num_ratings;
		$ratings	= $data->rating;
		$star_calc	= ( $ratings / 100 ) * 92;
		$star_rate	= '<div class="star-holder star-block"><div class="star-rating star-block" style="width:'.$star_calc.'px">'.$ratings.'</div></div>';

		$r_ratings	= ceil($ratings);
		$w_ratings	= ($r_ratings / 100) * 5;

		echo '<div class="widget plugin-details" itemtype="http://schema.org/AggregateRating" itemscope="" itemprop="aggregateRating">';
		echo '<meta content="0" itemprop="worstRating">';
		echo '<meta content="'.$w_ratings.'" itemprop="ratingValue">';
		echo '<meta content="5" itemprop="bestRating">';
		echo '<meta content="'.$total_rate.'" itemprop="ratingCount">';
		echo '<h4 class="nav-header">'.$plugname .' Details <i class="icon icon-bookmark pull-right"></i></h4>';
		echo '<table class="table table-condensed"><tbody>';
		echo '<tr><td>Version</td><td>'.$version.'</td></tr>';
		echo '<tr><td>Requires</td><td>'.$requires.'</td></tr>';
		echo '<tr><td>Compatible</td><td>'.$tested.'</td></tr>';
		echo '<tr><td>Released</td><td>'. date('m/d/Y', strtotime( $added ) ).'</td></tr>';
		echo '<tr><td>Last Updated</td><td>'. date('m/d/Y', strtotime( $updated ) ).'</td></tr>';
		echo '<tr><td>Downloads</td><td>'.$downloaded.'</td></tr>';

		echo '<tr><td>Rating</td><td>'.$star_rate.'</td></tr>';
		echo '<tr><td class="noline"></td><td class="noline">'.$w_ratings.' <small>out of</small> 5 stars</td></tr>';

		echo '</tbody></table>';

		echo '<p class="plugin-links row-fluid">';
		echo '<a title="View on WP.org" target="_blank" class="btn btn-primary pull-left" href="'.$wordpress.'"><i class="icon-white icon-cogs"></i> View at WP.org</a>';
		echo '<a title="Support Forum" target="_blank" class="btn btn-danger pull-right" href="'.$support.'"><i class="icon-white icon-wrench"></i> Support Forums</a>';
		echo '</p>';
		echo '<input type="hidden" id="theme-root" value="'.get_bloginfo('stylesheet_directory').'" />';
		echo '<input type="hidden" id="rating-value" value="'.$star_calc.'" />';
		echo '</div>';
}

function rkv_post_details() {
	// get variables
	global $post;
	$categories	= get_the_category($post->ID);
	$post_date	= get_the_date('M jS, Y');
	$schm_date	= get_the_date('c');
	$auth_id	= get_the_author_meta( 'ID' );
	$auth_name	= get_the_author_meta( 'display_name' );
	$auth_url	= $auth_id == 1 ? get_bloginfo('url').'/about/' : get_author_posts_url($auth_id);

	echo '<p class="post-details">';
	echo '<span class="detail-item author vcard"><i class="icon icon-user"></i> <span class="fn"><a href="'.$auth_url.'" rel="author" title="View all posts by '.$auth_name.'">'.$auth_name.'</a></span></span>';

	if ( comments_open() ) :
		echo '<span title="'.$schm_date.'" class="detail-item date published updated time"><i class="icon icon-calendar"></i> '.$post_date.'</span>';
		echo '<span class="detail-item detail-last detail-comment"><i class="icon icon-comments"></i> ';
		echo comments_popup_link( 'Leave a Comment', '1 Comment', '% Comments', '', '' );
		echo '</span>';
	else:
		echo '<span title="'.$schm_date.'" class="detail-item date published updated time detail-last"><i class="icon icon-calendar"></i> '.$post_date.'</span>';
	endif;

	if ($categories):
	echo '<span class="detail-item detail-category pull-right">';
		foreach ($categories as $category) :
			$cat_name	= $category->cat_name;
			$cat_link	= get_category_link( $category->cat_ID );
			echo '<a class="label label-primary" title="View all posts in '.$cat_name.'" href="'.$cat_link.'">'.$cat_name.'</a>';
		endforeach;
	echo '</span>';
	endif;

	echo '</p>';
}

function rkv_tutorial_details() {
	// get variables
	global $post;
	$tax_terms	= get_the_terms($post->ID, 'tutorial-type');
	$post_date	= get_the_date('M jS, Y');
	$auth_id	= get_the_author_meta( 'ID' );
	$auth_name	= get_the_author_meta( 'display_name' );
	$auth_url	= $auth_id == 1 ? get_bloginfo('url').'/about/' : get_author_posts_url($auth_id);

	echo '<p class="post-details">';
	echo '<span class="detail-item"><i class="icon icon-user"></i> <a href="'.$auth_url.'" rel="author" title="View all posts by '.$auth_name.'">'.$auth_name.'</a></span>';

	if ( comments_open() ) :
		echo '<span class="detail-item"><i class="icon icon-calendar"></i> '.$post_date.'</span>';
		echo '<span class="detail-item detail-last"><i class="icon icon-comment"></i> ';
		echo comments_popup_link( 'Leave a Comment', '1 Comment', '% Comments', '', '' );
		echo '</span>';
	else:
		echo '<span class="detail-item detail-last"><i class="icon icon-calendar"></i> '.$post_date.'</span>';
	endif;
	if ($tax_terms):
	echo '<span class="detail-item detail-category pull-right">';
		foreach ($tax_terms as $tax_term) :
			$term_name	= $tax_term->name;
			$term_slug	= $tax_term->slug;
			$term_id	= $tax_term->term_id;
			$term_link	= get_term_link( $term_slug, 'tutorial-type' );
			echo '<a class="label label-primary" title="View all posts in '.$term_name.'" href="'.$term_link.'">'.$term_name.'</a>';
		endforeach;
	echo '</span>';
	endif;


	echo '</p>';
}

// get taxonomies terms links
function custom_tax_links($tax_type) {
	global $post, $post_id;

	$terms = get_the_terms( $post->ID, $tax_type );

	// no terms? bail
	if(!$terms)
		return;

	// got some? give'em back
	if ( $terms && ! is_wp_error( $terms ) ) :

		$term_links = array();

		foreach ( $terms as $term ) {
			$term_links[] = '<span class="label pull-right link-label"><a href="' .get_term_link($term->slug, $tax_type) .'">'.$term->name.'</a></span>';
		}

	$term_labels = join( ' ', $term_links );

	return $term_labels;

	endif;
}

// social buttons
function rkv_social() {
	global $post;
	$link	= get_permalink($post->ID);
	$short	= wp_get_shortlink($post->ID);
	$text	= get_the_title($post->ID);
	?>

	<div class="social-button-container">

	    <!-- Twitter -->
	    <div class="social-twitter">
	    	<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $short; ?>" data-text="<?php echo $text; ?>" data-via="norcross" data-count="horizontal" data-size="medium" data-counturl="<?php echo $link; ?>" data-dnt="true">Tweet</a>
	    </div>

	    <!-- Google Plus -->
	    <div class="social-gplus">
	    	<div class="g-plusone" data-size="medium" data-annotation="bubble" data-width="200" data-href="<?php echo $short; ?>"></div>
	    </div>

	    <!-- instapaper
	    <div class="social-instapaper">
	    	<a href="http://www.instapaper.com/hello2?url=<?php echo urlencode($link); ?>&title=<?php echo $text; ?>" class="instapaper-icon manual-button">Save to Instapaper</a>
	    </div>
	     -->


	</div>

<?php }

function rkv_snippet_search() {
		echo '<div class="input-append">';
		echo '<form class="searchform" role="search" method="get" id="snippet-search" action="' . home_url( '/' ) . '" >';
		echo '<input type="text" value="' . get_search_query() . '" name="s" id="s" class="s" />';
		echo '<input type="submit" class="btn btn-primary" value="Go" id="snippetsubmit">';
		echo '<input type="hidden" name="post_type" value="snippets" />';
		echo '</form>';
		echo '</div>';
}

// instagram feed

function rkv_instagram_feed() {

	$args = array (
		'fields'        => 'ids',
		'post_type'     => 'photos',
		'numberposts'   => -1,
	);

	$photos = get_posts( $args );

	foreach ( $photos as $photo ) :

		$caption	= get_post_field('post_content', $photo);

		$thumb_id	= get_post_thumbnail_id($photo, 'ig-regular');	// Medium resolution
		$standard	= wp_get_attachment_image_src($thumb_id, 'ig-regular');
		$fullsize	= wp_get_attachment_image_src($thumb_id, 'ig-large');

		echo '<div class="instagram-photo">';
		echo '<a class="instagram-link" href="'.$fullsize[0].'" title="'.$caption.'" rel="instagram-gallery">';
		echo '<img class="instagram-pic" src="'.$standard[0].'" alt="'.$caption.'" title="'.$caption.'">';
		echo '</a>';
		echo '</div>';

	endforeach;
}
