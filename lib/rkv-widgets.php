<?php

/**
 * github gists
 */
class rkv_ListGistsWidget extends WP_Widget {
    /** constructor */
	function rkv_ListGistsWidget() {
		$widget_ops = array( 'classname' => 'list_gists', 'description' => 'Displays a list of gists hosted on GitHub' );
		$this->WP_Widget( 'list_gists', 'Public GitHub Gists', $widget_ops );
	}


    /** @see WP_Widget::widget */
    function widget($args, $instance) {
        extract( $args, EXTR_SKIP );

	// first check for a username. can't do much without it
	$user	= $instance['github_user'];
	if (empty ($user) ) {
		echo '<p>Please enter a username in the widget settings</p>';
	} else {

		// check for stored transient. if none present, create one
		if( false == get_transient( 'public_github_gists'.$user.'' ) ) {

			// grab username and total gists to grab
			$user	= $instance['github_user'];
			$number	= $instance['gists_num'];

			// set number of items to return
			if (!empty ($number) ) { $max = $number; } else { $max = 100; } // 100 is the max return in the GitHub API

			$request	= new WP_Http;
			$url		= 'https://api.github.com/users/'.urlencode($user).'/gists?&per_page='.$max.'';
			$response	= wp_remote_get ( $url, $args );

			// Save a transient to the database
			set_transient('public_github_gists'.$user.'', $response, 60*60*1 );

		} // end transient check


		// set all variable options for plugin call

		$user	= $instance['github_user'];
		$number	= $instance['gists_num'];
		$date	= $instance['show_date'];
		$link	= $instance['show_link'];
		$text	= $instance['link_text'];

		// check for transient cache'd result
			$response = get_transient( 'public_github_gists'.$user.'' );

			// check for bad response from GitHub
			if( is_wp_error( $response ) ) {
				echo '<p>Sorry, there was an error with your request.</p>';
			} else {
				$gist_list	= json_decode( $response['body'] );

		// start output of actual widget
		echo $before_widget;

		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		if ( !empty( $title ) ) { echo $before_title .'<i class="icon icon-github-sign pull-right"></i> '. $title . $after_title; };
		echo '<ul>';

		// list individual items
		foreach ( $gist_list as $gist ) {

			// get gist values for display
			$desc	= $gist->description;
			$gistid	= $gist->id;
			$url	= $gist->html_url;

			// grab date and convert it to a readable format
			$create	= $gist->created_at;
			$create	= strtotime($create);
			$create	= date('n/j/Y', $create);

			// check for missing values and replace them if necessary
			( $desc == null) ? $title = 'Gist ID: '.$gistid : $title = $desc;
			( empty ($text) ) ? $text = 'Github Profile' : $text = $text;

			// display list of gists
				echo '<li class="gist_item">';
				echo '<a class="gist_title" href="'.$url.'" title="'.$title.'" target="_blank">'.$title.'</a>';

				// include optional date
				if ($date == 1) : echo '<br /><span class="gist_date">Created: '.$create.'</span>'; endif;

				echo '</li>';
			} // end foreach

		echo '</ul>';

		// display optional github profile link
		if ($link == 1) : echo '<p class="github_link"><a class="btn btn-primary" href="http://github.com/'.$user.'" title="'.$text.'" target="_blank">'.$text.'</a></p>'; endif;

		} // end error check

	echo $after_widget;
	} // end username check
	?>

        <?php }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title']			= strip_tags($new_instance['title']);
		$instance['github_user']	= strip_tags($new_instance['github_user']);
		$instance['gists_num']		= strip_tags($new_instance['gists_num']);
		$instance['link_text']		= strip_tags($new_instance['link_text']);
		$instance['show_date']		= !empty($new_instance['show_date']) ? 1 : 0;
		$instance['show_link']		= !empty($new_instance['show_link']) ? 1 : 0;

		// Remove our saved transient (in case we changed something)
		delete_transient('public_github_gists');

			return $instance;
		}

    /** @see WP_Widget::form */
    function form($instance) {
        $instance = wp_parse_args( (array) $instance, array(
			'title'			=> '',
			'github_user'	=> '',
			'gists_num'		=> '',
			'link_text'		=> 'See my GitHub profile',
			'show_date'		=> 0,
			'show_link'		=> 0,
			));
		foreach ( $instance as $field => $val ) {
			if ( isset($new_instance[$field]) )
				$instance[$field] = 1;
		}
		$title			= strip_tags($instance['title']);
		$github_user	= strip_tags($instance['github_user']);
		$gists_num		= strip_tags($instance['gists_num']);
		$link_text		= strip_tags($instance['link_text']);
        ?>
		<p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
		<p>
        <label for="<?php echo $this->get_field_id('github_user'); ?>"><?php _e('GitHub username'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('github_user'); ?>" name="<?php echo $this->get_field_name('github_user'); ?>" type="text" value="<?php echo esc_attr($github_user); ?>" />
        <?php if (empty ($github_user) ) :	echo '<span class="gist_error_message">Username is required!</span>'; endif; ?>
        </p>

		<p>
        <label for="<?php echo $this->get_field_id('gists_num'); ?>"><?php _e('Gists to display'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('gists_num'); ?>" name="<?php echo $this->get_field_name('gists_num'); ?>" type="text" value="<?php echo esc_attr($gists_num); ?>" />
        </p>
        <br />
		<p><strong>Optional Values</strong></p>
        <p>
        <input class="checkbox" type="checkbox" <?php checked($instance['show_date'], true) ?> id="<?php echo $this->get_field_id('show_date'); ?>" name="<?php echo $this->get_field_name('show_date'); ?>" />
		<label for="<?php echo $this->get_field_id('show_date'); ?>"><?php _e('Display creation date'); ?></label>
        </p>
		<p>
        <input class="checkbox" type="checkbox" <?php checked($instance['show_link'], true) ?> id="<?php echo $this->get_field_id('show_link'); ?>" name="<?php echo $this->get_field_name('show_link'); ?>" />
		<label for="<?php echo $this->get_field_id('show_link'); ?>"><?php _e('Include link to Github profile'); ?></label>
        </p>
		<p>
        <label for="<?php echo $this->get_field_id('link_text'); ?>"><?php _e('Profile link text'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('link_text'); ?>" name="<?php echo $this->get_field_name('link_text'); ?>" type="text" value="<?php echo esc_attr($link_text); ?>" />
        </p>

		<?php }

} // class


// tutorials
class rkv_recent_tutorials extends WP_Widget {
	function rkv_recent_tutorials() {
		$widget_ops = array( 'classname' => 'tutorial_posts', 'description' => 'Displays recent tutorials' );
		$this->WP_Widget( 'tutorial_posts', 'Recent Tutorials', $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		if ( !empty( $title ) ) { echo $before_title .'<i class="icon icon-beaker pull-right"></i> '. $title . $after_title; };

			$public = new WP_Query( array (
				'post_type'			=> 'tutorials',
				'posts_per_page'	=> $instance['count'],
			));
			if ($public->have_posts()) :
			echo '<ul>';
			while ($public->have_posts()) : $public->the_post();
			// begin single items
				// get variables
				global $post;
				$link		= get_permalink($post->ID);
				$title		= get_the_title($post->ID);

			echo '<li><a href="'.$link.'" title="'.$title.'">'.$title.'</a></li>';
			// end each item
			endwhile;
			echo '</ul>';
			endif;
			echo wp_reset_query();
			echo '<p class="all_news"><a class="btn btn-primary" href="'.get_bloginfo('url').'/tutorials/" title="View All Tutorials">View All Tutorials</a></p>';
		echo $after_widget;
		?>

        <?php }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
	$instance = $old_instance;
	$instance['title']	= strip_tags($new_instance['title']);
	$instance['count']	= $new_instance['count'];
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
        $instance = wp_parse_args( (array) $instance, array(
			'title'	=> 'Recent Tutorials',
			'count'	=> '5',
			));
		$title	= strip_tags($instance['title']);
		$count	= strip_tags($instance['count']);
        ?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>">Widget Title:<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('count'); ?>">Post Count:<input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo esc_attr($count); ?>" /></label></p>
		<?php }

} // class

// this is my jam - recent jam
class rkv_recent_jams extends WP_Widget {
	function rkv_recent_jams() {
		$widget_ops = array( 'classname' => 'recent_jam', 'description' => 'Displays details of recent jam' );
		$this->WP_Widget( 'recent_jam', 'Recent Jam', $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };

		// load variables with fallback conditionals
		$username	= empty($instance['username'])										? 'jamoftheday'	: $instance['username'];
		$show_text	= isset($instance['show_text'])  && $instance['show_text'] == 1		? 'true'		: 'false';
		$show_image	= isset($instance['show_image']) && $instance['show_image'] == 1	? 'true'		: 'false';
		$image_size	= empty($instance['image_size'])									? 'medium'		: $instance['image_size'];

		// output variables
		echo '<script src="http://www.thisismyjam.com/includes/js/medallion.js"></script>';
		echo '<script>Jam.Medallion.insert({username: "'.$username.'",text: '.$show_text.', image: '.$show_image.',imageSize: "'.$image_size.'"})</script>';

		echo $after_widget;
		?>

        <?php }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
	$instance = $old_instance;
	$instance['title']		= strip_tags($new_instance['title']);
	$instance['username']	= strip_tags($new_instance['username']);
	$instance['show_text']	= !empty($new_instance['show_text'])	? 1 : 0;
	$instance['show_image']	= !empty($new_instance['show_image'])	? 1 : 0;
		if ( in_array( $new_instance['image_size'], array( 'small', 'medium', 'large' ) ) ) {
			$instance['image_size'] = $new_instance['image_size'];
		} else {
			$instance['image_size'] = 'medium';
		}
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
        $instance = wp_parse_args( (array) $instance, array(
			'title'			=> 'Recent Jam',
			'username'		=> '',
			'show_text'		=> 0,
			'show_image'	=> 1,
			'image_size'	=> 'medium'
			));
		foreach ( $instance as $field => $val ) {
			if ( isset($new_instance[$field]) )
				$instance[$field] = 1;
		}
		$title		= esc_attr( $instance['title'] );
		$username	= esc_attr( $instance['username'] );
        ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Username'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo esc_attr($username); ?>" />
		</p>
        <p>
        <input class="checkbox" type="checkbox" <?php checked($instance['show_text'], true) ?> id="<?php echo $this->get_field_id('show_text'); ?>" name="<?php echo $this->get_field_name('show_text'); ?>" />
		<label for="<?php echo $this->get_field_id('show_text'); ?>"><?php _e('Display description below album'); ?></label>
        </p>
        <p>
        <input class="checkbox" type="checkbox" <?php checked($instance['show_image'], true) ?> id="<?php echo $this->get_field_id('show_image'); ?>" name="<?php echo $this->get_field_name('show_image'); ?>" />
		<label for="<?php echo $this->get_field_id('show_image'); ?>"><?php _e('Display album image'); ?></label>
        </p>
		<p>
			<label for="<?php echo $this->get_field_id('image_size'); ?>"><?php _e( 'Album Image Size' ); ?></label>
			<select name="<?php echo $this->get_field_name('image_size'); ?>" id="<?php echo $this->get_field_id('image_size'); ?>" class="widefat">
				<option value="small"<?php selected( $instance['image_size'], 'small' ); ?>><?php _e('Small'); ?></option>
				<option value="medium"<?php selected( $instance['image_size'], 'medium' ); ?>><?php _e('Medium'); ?></option>
				<option value="large"<?php selected( $instance['image_size'], 'large' ); ?>><?php _e( 'Large' ); ?></option>
			</select>
		</p>


		<?php }

} // class


/**
 * display speaker badges
 *
 * @return Reaktiv_Widgets
 *
 * @since 1.0
 */
class rkv_speaking_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'speaker-badge', 'description' => __( 'Display conference speaking badges') );
		parent::__construct('speaker-badge', __('Conference Badges'), $widget_ops);
		$this->alt_option_name = 'speaker-badge';
	}

	function widget( $args, $instance ) {

		extract( $args, EXTR_SKIP );

		echo $before_widget;

		$title = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };

        echo '<a class="badge-link" href="'.$instance['clink'].'" title="'.$instance['alttx'].'" target="_blank">';
        echo '<img class="badge-image" src="'.$instance['badge'].'" alt="'.$instance['alttx'].'">';
        echo '</a>';

		echo $after_widget;


	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title']  = strip_tags( $new_instance['title'] );
		$instance['clink']	= strip_tags( $new_instance['clink'] );
		$instance['badge']  = strip_tags( $new_instance['badge'] );
		$instance['alttx']  = strip_tags( $new_instance['alttx'] );

		return $instance;
	}

	function form( $instance ) {
		$title  = isset( $instance['title'] )   ? esc_attr( $instance['title'] )	: '';
		$clink	= isset( $instance['clink'] )   ? esc_url( $instance['clink'] )		: '';
		$badge  = isset( $instance['badge'] )   ? esc_url( $instance['badge'] )		: '';
		$alttx  = isset( $instance['alttx'] )   ? esc_attr( $instance['alttx'] )	: '';
	?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'clink' ); ?>"><?php _e( 'Badge URL' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'clink' ); ?>" name="<?php echo $this->get_field_name( 'clink' ); ?>" type="url" value="<?php echo $clink; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'badge' ); ?>"><?php _e( 'Badge Image URL' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'badge' ); ?>" name="<?php echo $this->get_field_name( 'badge' ); ?>" type="url" value="<?php echo $badge; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'alttx' ); ?>"><?php _e( 'Badge Alt Text' ); ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id( 'alttx' ); ?>" name="<?php echo $this->get_field_name( 'alttx' ); ?>"><?php echo $alttx; ?></textarea>
		</p>

	<?php }


} // end widget class


add_action( 'widgets_init', create_function( '', "register_widget('rkv_ListGistsWidget');" ) );
add_action( 'widgets_init', create_function( '', "register_widget('rkv_recent_tutorials');" ) );
add_action( 'widgets_init', create_function( '', "register_widget('rkv_recent_jams');" ) );
add_action( 'widgets_init', create_function( '', "register_widget('rkv_speaking_Widget');" ) );
