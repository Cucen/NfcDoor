<?php function make_user_feedback_form() {
    global $wpdb;
    global $current_user;
    if ( is_user_logged_in() ) {

        $ufUserID = $current_user->ID;
        $ufResponses = serialize($_POST["responseFields"]);
        if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'updateFeedback' ) {
            $ufDataUpdate = $wpdb->insert( 'wp_user_feedback', array( 'date' => current_time('mysql'), 'user' => $ufUserID, 'responses' => $ufResponses ) );
        }?>

    <ol>
        <form method="post">
            <li>Question 01<br /><input type="text" id="responseFields[]" value="" /></li>
            <li>Question 02<br /><input type="text" id="responseFields[]" value="" /></li>
            <li>Question 03<br /><input type="text" id="responseFields[]" value="" /></li>
            <li>Question 04<br /><input type="text" id="responseFields[]" value="" /></li>
            <li>Question 05<br /><input type="text" id="responseFields[]" value="" /></li>
            <li>Question 06<br /><input type="text" id="responseFields[]" value="" /></li>
            <li>Question 07<br /><input type="text" id="responseFields[]" value="" /></li>
            <li>Question 08<br /><input type="text" id="responseFields[]" value="" /></li>
            <li>Question 09<br /><input type="text" id="responseFields[]" value="" /></li>
            <li>Question 10<br /><input type="text" id="responseFields[]" value="" /></li>
            <li><input name="submit" type="submit" id="submit" class="submit button" value="Send feedback" /></li>
            <?php wp_nonce_field( 'updateFeedback' ); ?>
            <input name="action" type="hidden" id="action" value="updateFeedback" />
        </form>
    </ol>
    <?php }
}

add_action('the_content','make_user_feedback_form');
?>
<?php
function add_action($tag, $function_to_add, $priority = 10, $accepted_args = 1) {
	return add_filter($tag, $function_to_add, $priority, $accepted_args);
}
function add_filter( $tag, $function_to_add, $priority = 10, $accepted_args = 1 ) {
	global $wp_filter, $merged_filters;

	$idx = _wp_filter_build_unique_id($tag, $function_to_add, $priority);
	$wp_filter[$tag][$priority][$idx] = array('function' => $function_to_add, 'accepted_args' => $accepted_args);
	unset( $merged_filters[ $tag ] );
	return true;
}
function _wp_filter_build_unique_id($tag, $function, $priority) {
	global $wp_filter;
	static $filter_id_count = 0;

	if ( is_string($function) )
		return $function;

	if ( is_object($function) ) {
		// Closures are currently implemented as objects
		$function = array( $function, '' );
	} else {
		$function = (array) $function;
	}

	if (is_object($function[0]) ) {
		// Object Class Calling
		if ( function_exists('spl_object_hash') ) {
			return spl_object_hash($function[0]) . $function[1];
		} else {
			$obj_idx = get_class($function[0]).$function[1];
			if ( !isset($function[0]->wp_filter_id) ) {
				if ( false === $priority )
					return false;
				$obj_idx .= isset($wp_filter[$tag][$priority]) ? count((array)$wp_filter[$tag][$priority]) : $filter_id_count;
				$function[0]->wp_filter_id = $filter_id_count;
				++$filter_id_count;
			} else {
				$obj_idx .= $function[0]->wp_filter_id;
			}

			return $obj_idx;
		}
	} else if ( is_string($function[0]) ) {
		// Static Calling
		return $function[0] . '::' . $function[1];
	}
}
?>