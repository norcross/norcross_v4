<?php
// music signup form
function music_shortcode($content = NULL) {

    $form = '<div class="span8">';
    $form .= '<div id="mc_embed_signup" class="well span3 offset1">';
    $form .= '<legend>Get On Board</legend>';
	$form .= '<form action="http://andrewnorcross.us1.list-manage1.com/subscribe/post?u=53df8c1710c035ea67f6511cc&amp;id=e6f975acba" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>';    
	
	$form .= '<input class="span3 required email" type="email" placeholder="email address" value="" name="EMAIL" id="mce-EMAIL">';
    $form .= '<button class="btn btn-inverse" name="subscribe" id="mc-embedded-subscribe" type="submit">Subscribe</button>';
    $form .= '</form>';
	$form .= '</div>';
	$form .= '</div>';


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