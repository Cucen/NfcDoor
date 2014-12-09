		<!-- Yorum -->
		<div class="yazi">
		<div class="yazi_baslik"><a>Yorumlar (<?php comments_number('0', '1', '%'); ?>)</a></div>
		
		<div class="yazi_ic">
<div id="yorumtemp">
<div class="yorumlar">
<?php if(!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) : ?>    
    <?php die('You can not access this page directly!'); ?> 
<?php endif; ?>
<?php if(!empty($post->post_password)) : ?>
    <?php if($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) : ?>
        <p>This post is password protected. Enter the password to view comments.</p>
    <?php endif; ?>
<?php endif; ?>
<?php if($comments) : ?>
    <ol>
        <?php foreach($comments as $comment) : ?>
        <li id="comment-<?php comment_ID(); ?>">
                        <div id="yorum">
            <?php if ($comment->comment_approved == '0') : ?>
            <hr/>Yorumunuz onaylandıktan sonra sitede yayınlanacaktır.<hr/>
            <?php endif; ?>
                        <div class="yorum-avatar"><?php echo get_avatar( $comment, 50 ); ?></div>
                        <div class="yorum-yan"><b><?php comment_author_link(); ?></b> - <?php comment_date(); ?>, <?php comment_time(); ?>
                       <div class="yorum-alt">
            <?php comment_text(); ?></div></div>
</div><br /><br />
        </li>
        <?php endforeach; ?>
    </ol>
<?php else : ?>
    <p>Henüz yorum yapılmamış.</p><br />
<?php endif; ?>
</div>
<div class="yorumyap">
<b>Yorum Yap</b><br />
<?php if(comments_open()) : ?>
    <?php if(get_option('comment_registration') && !$user_ID) : ?>
        <p>Yorum yapabilmek için <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">giriş</a> yapmalısınız.</p><?php else : ?>
        <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
            <?php if($user_ID) : ?>
                <p>Giriş yaptığınız kullanıcı <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Çıkış &raquo;</a></p>
            <?php else : ?>
                <div class="genislik"><label for="author"><small>İsim <?php if($req) echo "(zorunlu)"; ?></small></label></div> <input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" /><br/>
				<div class="genislik"><label for="email"><small>E-Mail <?php if($req) echo "(zorunlu)"; ?></small></label></div> <input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" /><br/>
				<div class="genislik"><label for="url"><small>İnternet Sitesi</small></label></div> <input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" /><br/>
            <?php endif; ?>
            <p><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>
            <p><input name="submit" type="submit" id="submit" tabindex="5" value="Yorum Ekle" />
            <input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" /></p>
            <?php do_action('comment_form', $post->ID); ?>
        </form>
    <?php endif; ?>
<?php else : ?>
    <p>Yoruma Kapalı.</p>
<?php endif; ?>
</div>
</div>
			<div class="temizlik"></div>
		<br/>

			<div class="temizlik"></div>
		</div>
		
		<div class="yazi_alt"></div>
		</div>
		<!--/Yorum -->