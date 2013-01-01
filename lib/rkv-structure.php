<?php

// Comment Layout
function rkv_comment_callback($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment;
//   echo preprint($comment);
   $comm_args = array (
   	'reply_text' => 'Reply <i class="icon icon-share-alt"></i>'
   	);
   ?>
	<li <?php comment_class(); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="clearfix">
			<div class="comment-author vcard row-fluid clearfix">
				<div class="comment-avatar span3">
					<?php echo get_avatar($comment, $size = '88', $default = '404', $alt = ''); ?>
				</div>
				<div class="comment-text span9">
					<?php printf(__('<h4><span class="fn">%s</span></h4>'), get_comment_author_link()) ?>

                    <?php if ($comment->comment_approved == '0') : ?>
       					<div class="alert-message success">
          				<p><?php _e('Your comment is awaiting moderation.') ?></p>
          				</div>
					<?php endif; ?>

                    <?php comment_text() ?>
                </div>
                <div class="comment-extra span12">
                    <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time('M jS, Y'); ?> </a></time>

					<?php comment_reply_link(array_merge( $comm_args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
                </div>
			</div>
		</article>
    <!-- </li> is added by wordpress automatically -->
<?php
} // don't remove this bracket!

// Display trackbacks/pings callback function
function list_pings($comment, $args, $depth) {
       $GLOBALS['comment'] = $comment;
?>
        <li id="comment-<?php comment_ID(); ?>"><i class="icon icon-share-alt"></i>&nbsp;<?php comment_author_link(); ?>
<?php

}

// Only display comments in comment count (which isn't currently displayed in wp-bootstrap, but i'm putting this in now so i don't forget to later)
add_filter('get_comments_number', 'comment_count', 0);
function comment_count( $count ) {
	if ( ! is_admin() ) {
		global $id;
	    $comments_by_type = &separate_comments(get_comments('status=approve&post_id=' . $id));
	    return count($comments_by_type['comment']);
	} else {
	    return $count;
	}
}

// Numeric Page Navi (built into the theme by default)
function rkv_page_navi($before = '', $after = '') {
	global $wpdb, $wp_query;
	$request = $wp_query->request;
	$posts_per_page = intval(get_query_var('posts_per_page'));
	$paged = intval(get_query_var('paged'));
	$numposts = $wp_query->found_posts;
	$max_page = $wp_query->max_num_pages;
	if ( $numposts <= $posts_per_page ) { return; }
	if(empty($paged) || $paged == 0) {
		$paged = 1;
	}
	$pages_to_show = 7;
	$pages_to_show_minus_1 = $pages_to_show-1;
	$half_page_start = floor($pages_to_show_minus_1/2);
	$half_page_end = ceil($pages_to_show_minus_1/2);
	$start_page = $paged - $half_page_start;
	if($start_page <= 0) {
		$start_page = 1;
	}
	$end_page = $paged + $half_page_end;
	if(($end_page - $start_page) != $pages_to_show_minus_1) {
		$end_page = $start_page + $pages_to_show_minus_1;
	}
	if($end_page > $max_page) {
		$start_page = $max_page - $pages_to_show_minus_1;
		$end_page = $max_page;
	}
	if($start_page <= 0) {
		$start_page = 1;
	}

	echo $before.'<div class="pagination pagination-left"><ul class="clearfix">'."";
	if ($paged > 1) {
		$first_page_text = "&laquo";
		echo '<li class="prev"><a href="'.get_pagenum_link().'" title="First">'.$first_page_text.'</a></li>';
	}

	$prevposts = get_previous_posts_link('&larr; Prev');
	if($prevposts) { echo '<li>' . $prevposts  . '</li>'; }
	else { echo '<li class="disabled"><a href="#" title="Previous">&larr; Prev</a></li>'; }

	for($i = $start_page; $i  <= $end_page; $i++) {
		if($i == $paged) {
			echo '<li class="active"><a title="Page '.$i.'" href="#">'.$i.'</a></li>';
		} else {
			echo '<li><a title="Page '.$i.'" href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
		}
	}
	echo '<li class="">';
	next_posts_link('Next &rarr;');
	echo '</li>';
	if ($end_page < $max_page) {
		$last_page_text = "&raquo;";
		echo '<li class="next"><a href="'.get_pagenum_link($max_page).'" title="Last">'.$last_page_text.'</a></li>';
	}
	echo '</ul></div>'.$after."";
}

// Menu output mods
class description_walker extends Walker_Nav_Menu
{
      function start_el(&$output, $item, $depth, $args)
      {
			global $wp_query;
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			$class_names = $value = '';

			// If the item has children, add the dropdown class for bootstrap
			if ( $args->has_children ) {
				$class_names = "dropdown ";
			}

			$classes = empty( $item->classes ) ? array() : (array) $item->classes;

			$class_names .= join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
			$class_names = ' class="'. esc_attr( $class_names ) . '"';

           	$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

           	$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
           	$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
           	$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
           	$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
           	// if the item has children add these two attributes to the anchor tag
           	if ( $args->has_children ) {
				$attributes .= ' class="dropdown-toggle" data-toggle="dropdown"';
			}

            $item_output = $args->before;
            $item_output .= '<a'. $attributes .'>';
            $item_output .= $args->link_before .apply_filters( 'the_title', $item->title, $item->ID );
            $item_output .= $args->link_after;
            // if the item has children add the caret just before closing the anchor tag
            if ( $args->has_children ) {
            	$item_output .= '<b class="caret"></b></a>';
            }
            else{
            	$item_output .= '</a>';
            }
            $item_output .= $args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
            }

        function start_lvl(&$output, $depth) {
            $indent = str_repeat("\t", $depth);
            $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
        }

      	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output )
      	    {
      	        $id_field = $this->db_fields['id'];
      	        if ( is_object( $args[0] ) ) {
      	            $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
      	        }
      	        return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
      	    }


}
