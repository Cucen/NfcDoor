<?php  if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
        die ('Please do not load this page directly. Thanks!');
?>
<a name="comments" id="comments"></a>
<?php if ( post_password_required() ) : ?>

<fieldset style="margin: 20px;" id="respond"><legend>Protected</legend>
<?php _e( 'This post is password protected. Enter the password to view any comments.', 'wp-mobile-edition' ); ?>
</fieldset>
<?php
return;
		endif;
?>

<?php if ( have_comments() ) : ?>
</div> <!-- single -->
<div class="rack1"></div>
<div class="fdx_comments_respond">
<?php comments_number('No', '"1" Comment', '"%" Comments');?>
<div style="float: right; margin-right: 5px"><a href="#respond">&dArr;</a></div>
</div>


<div class="fdx_content">
<div class="fdx_comments" id="comments">
<ol>
<?php wp_list_comments( array( 'callback' => 'fdx_comment' ) );?>
</ol>

</div>

<!-- COMENT COUNT -->
<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
<div class="paginate-com">
<?php
//Create pagination links for the comments on the current post, with single arrow heads for previous/next
paginate_comments_links( array('prev_text' => '&lsaquo;&lsaquo;', 'next_text' => '&rsaquo;&rsaquo;'));
?>
</div>
<?php endif; ?>




<?php endif; // have_comments() ?>

<?php if ( ! comments_open()) : ?>


<fieldset style="margin: 20px;" id="respond"><legend><?php _e( 'Comments are closed', 'wp-mobile-edition' ); ?> </legend>

</fieldset>

<?php else: ?>

<fieldset style="margin: 20px;"><legend><?php comment_form_title(); ?> </legend>


<div id="respond">

<p style="text-align: center"><?php cancel_comment_reply_link(); ?></p>


<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
<p><?php _e( 'You must be', 'wp-mobile-edition' ); ?> <a href="<?php echo wp_login_url( get_permalink() ); ?>"><strong><?php _e( 'logged in', 'wp-mobile-edition' ); ?></strong></a> <?php _e( 'to post a comment', 'wp-mobile-edition' ); ?>.</p>
<?php else : ?>


<form action="<?php echo esc_url( get_bloginfo('wpurl') ); ?>/wp-comments-post.php" method="post" id="commentform" class="form-post">

<?php if ( is_user_logged_in() ) : ?>

<?php _e( 'Welcome', 'wp-mobile-edition' ); ?> <a href="<?php echo admin_url('profile.php'); ?>"><?php echo $user_identity; ?></a> <small>(<a href="<?php echo wp_logout_url( get_permalink() ); ?>"><?php _e( 'Logout', 'wp-mobile-edition' ); ?></a>)</small>

<?php else : ?>

<div class="input-group">
<span class="input-group-addon">&rarr;</span><input class="form-control" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" type="text" placeholder="<?php _e('Name', 'wp-mobile-edition'); ?><?php if ($req) { ?>*<?php } ?>">
</div>
 <br>
<div class="input-group">
<span class="input-group-addon">&rarr;</span><input class="form-control" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" type="text" placeholder="<?php _e('E-mail', 'wp-mobile-edition'); ?><?php if ($req) { ?>*<?php } ?>">
</div>

<br>
<div class="input-group">
<span class="input-group-addon">&rarr;</span><input class="form-control" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" type="text" placeholder="<?php _e('Website', 'wp-mobile-edition'); ?>">
</div>
<?php endif; ?>
<br />
<textarea name="comment" id="comment" class="form-control" rows="3" placeholder="<?php _e('Comment', 'wp-mobile-edition'); ?>"></textarea>

<div style="text-align: center; margin-top: 10px">
<input type="submit" id="submit" style="padding: 5px" value="<?php _e( 'Post Comment', 'wp-mobile-edition' ); ?>" />
</div>

<?php comment_id_fields(); ?>

</form>


<?php endif; ?>

</div>
     </fieldset>
 <?php endif; ?>
