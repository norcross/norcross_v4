<?php

// Do not delete these lines
  if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
    die ('Please do not load this page directly. Thanks!');

  if ( post_password_required() ) { ?>
  	<div class="alert alert-info"><?php _e("This post is password protected. Enter the password to view comments."); ?></div>
  <?php
    return;
  }
?>

<!-- You can start editing here. -->
<section id="comment-block">
<?php if ( have_comments() ) : ?>
	<?php
	$comments_by_type = &separate_comments($comments);
	if ( ! empty($comments_by_type['comment']) ) :
	?>
	<h3 id="comments"><?php comments_number('<span>' . __("No") . '</span> ' . __("Responses") . '', '<span>' . __("One") . '</span> ' . __("Response") . '', '<span>%</span> ' . __("Responses") );?> <?php _e("to"); ?> &#8220;<?php the_title(); ?>&#8221;</h3>

	
	<ol class="commentlist well">
		<?php wp_list_comments('type=comment&callback=rkv_comment_callback'); ?>
	</ol>
	
	<?php endif; ?>
	
	<?php if ( ! empty($comments_by_type['pings']) ) : ?>
		<h3 id="pings">Trackbacks/Pingbacks</h3>
		
		<ol class="pinglist">
			<?php wp_list_comments('type=pings&callback=list_pings'); ?>
		</ol>
	<?php endif; ?>

	<?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
    	<!-- If comments are open, but there are no comments. -->

	<?php else : // comments are closed ?>
	
	<p class="alert alert-info"><?php _e('Comments are closed'); ?>.</p>

	<?php endif; ?>

<?php endif; ?>
</section>
<?php if ( comments_open() ) : ?>

<section id="respond" class="respond-form">

	<div class="comment-form-title">
		<h3 id="comment-form-title"><?php comment_form_title( 'Leave a Reply', 'Reply to %s' ); ?></h3>

		<div id="cancel-comment-reply">
			<p class="small"><?php cancel_comment_reply_link( __("Cancel") ); ?></p>
		</div>
	</div>	

	<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
  	<div class="help">
  		<p><?php _e("You must be"); ?> <a href="<?php echo wp_login_url( get_permalink() ); ?>"><?php _e("logged in"); ?></a> <?php _e("to post a comment"); ?>.</p>
  	</div>
	<?php else : ?>

	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" class="form-vertical" id="commentform">

	<?php if ( is_user_logged_in() ) : ?>

	<p class="comments-logged-in-as"><?php _e("Logged in as"); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e("Log out of this account"); ?>"><?php _e("Log out"); ?> &raquo;</a></p>

	<?php else : ?>
	
	<ul id="comment-form-elements" class="clearfix">
		
		<li>
			<div class="control-group">
			  <div class="input-prepend">
			  	<span class="add-on"><i class="icon-user"></i></span><input class="comment-field field-required" type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" placeholder="<?php _e("Your Name"); ?>" tabindex="601" <?php if ($req) echo "aria-required='true'"; ?> />
			  </div>
		  	</div>
		</li>
		
		<li>
			<div class="control-group">
			  <div class="input-prepend">
			  	<span class="add-on"><i class="icon-envelope"></i></span><input class="comment-field field-required" type="email" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" placeholder="<?php _e("Email"); ?>" tabindex="602" <?php if ($req) echo "aria-required='true'"; ?> />
			  	<span class="help-inline">(<?php _e("will not be published"); ?>)</span>
			  </div>
		  	</div>
		</li>
		
		<li>
			<div class="control-group">
			  <div class="input-prepend">
			  <span class="add-on"><i class="icon-globe"></i></span><input class="comment-field" type="url" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" placeholder="<?php _e("Your Website"); ?>" tabindex="603" />
			  </div>
		  	</div>
		</li>
		
	</ul>

	<?php endif; ?>
	
	<div class="clearfix">
		<div class="input">
			<textarea name="comment" class="reply-text" id="comment" placeholder="<?php _e("Your Comment Here…"); ?>" tabindex="604" cols="79" rows="8"></textarea>
		</div>
	</div>
	
	<div id="comment-submit" class="form-actions">
	  <input class="btn btn-primary" name="submit" type="submit" id="submit" tabindex="5" value="<?php _e("Submit Comment"); ?>" />
	  <?php comment_id_fields(); ?>
	</div>
	
	<?php 
		//comment_form();
		do_action('comment_form()', $post->ID); 
	
	if (is_singular('tutorials')) {
		$disclaimer = '<p><em><strong>Please note:</strong> These tutorials are meant to be helpful, but please note that I cannot and will not be able to help with any implementations or modifications.</em></p>';
		$disclaimer .= '<p class="comment-tldr">tl;dr <strong>If you do not understand it, hire someone who does.</strong></p>';

		echo $disclaimer;

	}

	?>
	
	</form>
	
	<?php endif; // If registration required and not logged in ?>
</section>

<?php endif; // if you delete this the sky will fall on your head ?>