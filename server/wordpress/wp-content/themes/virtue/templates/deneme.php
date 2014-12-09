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