<?php
/*
|--------------------------------------------------------------------------
| if(function_exists('fdx_option')) {
|--------------------------------------------------------------------------
*/

if( !is_admin()){
// disable admin bar in front end
	show_admin_bar( false );
}


if ( function_exists( 'add_theme_support' ) ) {
     	add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 250, 150 );
}



// categoria etc tag
function fdx_body_result_text() {
	global $is_ajax; if (!$is_ajax) {
			if (is_search()) {
				echo __('Results for', 'wp-mobile-edition') . ' &rsaquo; ' . get_search_query();
			} if (is_category()) {
                echo __('Category', 'wp-mobile-edition') . ' &rsaquo; ' . single_cat_title('', false);
			} elseif (is_tag()) {
                echo __('Tag', 'wp-mobile-edition') . ' &rsaquo; ' . single_tag_title('', false);
			} elseif (is_day()) {
                echo __('Archive', 'wp-mobile-edition') . ' &rsaquo; ' . get_the_time('F jS, Y');
			} elseif (is_month()) {
                echo __('Archive', 'wp-mobile-edition') . ' &rsaquo; ' . get_the_time('F, Y');
			} elseif (is_year()) {
			   echo __('Archive', 'wp-mobile-edition') . ' &rsaquo; ' . get_the_time('Y');
            } elseif (is_author()) {
               global $author;
               $userdata = get_userdata($author);
			   echo __('Author', 'wp-mobile-edition') . ' &rsaquo; ' . $userdata->display_name;
		}
	}
}

/*
|--------------------------------------------------------------------------
| remove shortcodes
|--------------------------------------------------------------------------
*/
	function fdx_remove_shortcodes() {
	    if(function_exists('fdx_option')) {
	    $shortcodes = fdx_option('p3_txt6');
          } else { $shortcodes = ''; }
		$all_short_codes = explode( ',', str_replace( ', ', ',', $shortcodes ) );
		if ( $all_short_codes ) {
			foreach( $all_short_codes as $code ) {
				add_shortcode( $code, 'fdx_shortcode_off' );
			}
		}
	}
add_action('init', 'fdx_remove_shortcodes');

function fdx_shortcode_off( $atts, $content = null ) {
return do_shortcode($content);
}




/* LIMITAR OS CARACTERES do EXCERTP // echo fdx_excerpt(150);
 *------------------------------------------------------------*/
function fdx_excerpt($count){
  global $post;
  if(!empty($post->post_excerpt)){
  return $post->post_excerpt; //se tem resumo
	} else{
  $excerpt = strip_tags($post->post_content);
  $excerpt = substr($excerpt, 0, $count);
  $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
  return $excerpt;
   }
}


// **************************************************************************
// S.E.O Archive
// **************************************************************************
function csv_tags_m() {
	$posttags = get_the_tags();
	foreach((array)$posttags as $tag) {
		@$csv_tags .= $tag->name . ',';
	}
	echo $csv_tags;
}

function head_meta_desc_m() {
	/* >> user-configurable variables */
	$default_blog_desc = ''; // default description (setting overrides blog tagline)
	$post_desc_length  = 30; // description length in # words for post/Page
	$post_use_excerpt  = 1; // 0 (zero) to force content as description for post/Page
	$custom_desc_key   = 'description'; // custom field key; if used, overrides excerpt/content
	/* << user-configurable variables */

	global $cat, $cache_categories, $wp_query, $wp_version;
	if(is_single() || is_page()) {
		$post = $wp_query->post;
		$post_custom = get_post_custom($post->ID);
		@$custom_desc_value = $post_custom["$custom_desc_key"][0];

		if($custom_desc_value) {
			$text = $custom_desc_value;
		} elseif($post_use_excerpt && !empty($post->post_excerpt)) {
			$text = $post->post_excerpt;
		} else {
			$text = $post->post_content;
		}
		$text = str_replace(array("\r\n", "\r", "\n", "  "), " ", $text);
		$text = str_replace(array("\""), "", $text);
		$text = trim(strip_tags($text));
		$text = explode(' ', $text);
		if(count($text) > $post_desc_length) {
			$l = $post_desc_length;
			$ellipsis = '...';
		} else {
			$l = count($text);
			$ellipsis = '';
		}
		$description = '';
		for ($i=0; $i<$l; $i++)
			$description .= $text[$i] . ' ';

		$description .= $ellipsis;
	} elseif(is_category()) {
		$category = $wp_query->get_queried_object();
		$description = trim(strip_tags($category->category_description));
	} else {
		$description = (empty($default_blog_desc)) ? trim(strip_tags(get_bloginfo('description'))) : $default_blog_desc;
	}

	if($description) {
		echo $description;
	}
}


if ( ! function_exists( 'fdx_comment' ) ) :
function fdx_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>

<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'wp-mobile-edition' ); ?> <?php comment_author_link(); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
?>

<li <?php comment_class(); ?> id="li-<?php comment_ID(); ?>">

    <div id="<?php comment_ID(); ?>">
            <div class="fdx_comments_info">
				<?php
                    echo '<div class="fdx_comments_author">';
					echo get_avatar( $comment, 40 );
                    echo '</div>';
					printf( '<div class="fdx_comments_author_name">%1$s</div>',get_comment_author_link());
					printf( '<div class="fdx_comments_author_date"><a href="%1$s">%3$s</a></div><br />',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						sprintf( __( '%1$s at %2$s', 'wp-mobile-edition' ), get_comment_date(), get_comment_time() )
					);
				?>
			</div>

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<?php _e( 'Your comment is awaiting moderation.', 'wp-mobile-edition' ); ?>
			<?php endif; ?>

			<div class="fdx_comments_body">
				<?php comment_text(); ?>
			</div>

				<div class="fdx_comments_reply">
				<?php comment_reply_link( array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div>

    </div>




    <?php
		break;
	endswitch; // end comment_type check
}
endif;
