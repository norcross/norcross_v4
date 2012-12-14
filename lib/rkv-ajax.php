<?php

 // Start up the engine
class NorcrossAjax {


    /**
     * This is our constructor. There are many like it, but this one is mine.
     *
     * @return Norcrossv4
     */

    public function __construct() {
        add_action ( 'wp_enqueue_scripts',              array( $this, 'scripts_styles'          ),      99      );
        add_action ( 'wp_ajax_music_signup', 			array( $this, 'music_signup'			)				);
        add_action ( 'wp_ajax_nopriv_music_signup',		array( $this, 'music_signup'			)				);
    }


    /**
     * Load CSS and JS files
     *
     * @return Norcrossv4
     */

    public function scripts_styles() {

	    wp_enqueue_script( 'rkv-ajax', get_bloginfo('stylesheet_directory').'/lib/js/rkv.ajax.js', array('jquery'), null, true );
		wp_localize_script( 'rkv-ajax', 'rkvAJAX', array(
			'ajaxurl'	=> admin_url( 'admin-ajax.php' ),
			'nonce'		=> wp_create_nonce( 'rkv_nonce' )
			) );
	}

    /**
     * grab the back issues for display on success
     *
     * @return Norcrossv4
     */

    function back_issues() {

	    $args = array (
	        'fields'        => 'ids',
	        'post_type'     => 'downloads',
	        'numberposts'   => -1,
	        'meta_key'      => '_rkv_download_url',
	        'order'			=> 'ASC',
	        'orderby'		=> 'menu_order'
	    );

	    $dlist_query = get_posts( $args );

	    $dlist_count = (count($dlist_query) > 0 ) ? true : false;

	    if($dlist_count == false)
	        return;

		$backs = '';

	    $backs .= '<div id="download-list" class="music-clear">';

	    $backs .= '<h4>Back Issues</h4>';
	    $backs .= '<ul>';

	    foreach ($dlist_query as $dload):
			$dlist_link     = get_permalink($dload);
	        $dlist_title    = get_the_title($dload);

	        $backs .= '<li><a href="'.$dlist_link.'">'.$dlist_title.'</a></li>';

	    endforeach;

	    $backs .= '</ul>';
	    $backs .= '</div>';

	    return $backs;

    }

    /**
     * process the mailchimp signup
     *
     * @return Norcrossv4
     */

	public function music_signup() {

		$MC_KEY		= akm_get_key('MC_KEY');
		$MC_LIST	= akm_get_key('MC_LIST');

		$apikey		= $MC_KEY;
		$list_id	= $MC_LIST;
		$method		= 'listSubscribe';
		$email		= $_POST['email'];

		$request	= new WP_Http;
		$url		= 'http://us1.api.mailchimp.com/1.3/?method='.$method.'&apikey='.$apikey.'&id='.$list_id.'&email_address='.$email.'&double_optin=false&output=json';

		$response	= wp_remote_get ( $url );

		$ret = array();

		check_ajax_referer( 'rkv_nonce', 'nonce' );

		if( is_wp_error( $response ) ) {

			$ret['success'] = false;
			$ret['message'] = 'There was an error with your request. Please try again.';
			echo json_encode($ret);
			die();

		} else {
			$return	= $response['body'];
			$data	= json_decode($return);
		}

		// now process the actual return
		if( isset($data->error) ) {

			$ret['success'] = false;
			$ret['message'] = $data->error;
		}

		if( isset($data->code) && $data->code === 214 ) {

			$ret['success'] = false;
			$ret['errcode'] = 'EMAIL_EXISTS';
			$ret['message'] = $data->error;
			$ret['display'] = $this->back_issues();
		}

		if( $data === true ) {

			$ret['success'] = true;
			$ret['message'] = 'Success! Welcome to the club. Care to peruse the back issues?';
			$ret['display'] = $this->back_issues();
		}

		echo json_encode($ret);
		die();

	}



/// end class
}


// Instantiate our class
$NorcrossAjax = new NorcrossAjax();
