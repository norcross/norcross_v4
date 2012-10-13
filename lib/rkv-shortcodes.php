<?php
// music signup form
function music_shortcode($content = NULL) {

    $form = '<div id="music-signup-form" class="clear-well span3 offset1">';
    $form .= '<legend>Get On Board</legend>';
	$form .= '<form>';    
	$form .= '<input class="span3 required email" type="email" placeholder="email address" value="" name="music-email" id="music-email">';
    $form .= '<input type="button" class="btn btn-inverse" name="music-subscribe" id="music-subscribe" value="Subscribe">';
    $form .= '</form>';
	$form .= '</div>';
    // placeholders for AJAX response
    $form .= '<span id="music-msg"></span>';
    $form .= '<span id="music-list"></span>';

    // now send it all back
    return $form;
}

add_shortcode ( 'music', 'music_shortcode');

// embed gists
function gist_shortcode($atts, $content = NULL) {
        extract( shortcode_atts( array(
            'id'    => '',
            'title' => ''
           
        ), $atts ) );

    if (empty ($id) )
        return;

    $gist = '<div class="github-gist-block">';
    
    if(!empty($title))
        $gist .= '<h4>'.$title.'</h4>';

    $gist .= '<script src="https://gist.github.com/'.$id.'.js"></script>';
    $gist .= '</div>';


    // now send it all back
    return $gist;
}


add_shortcode ( 'gist', 'gist_shortcode');


function emailbot_ssc($attr) {
    extract( shortcode_atts( array(
        'address' => '',
    ), $attr ) );

    $email = '<a class="email_link" href="mailto:'.antispambot($attr['address']).'" title="Send Us An Email" target="_blank">';
    $email .= antispambot($attr['address']);
    $email .= '</a>';

    return $email;
}

add_shortcode('email', 'emailbot_ssc');