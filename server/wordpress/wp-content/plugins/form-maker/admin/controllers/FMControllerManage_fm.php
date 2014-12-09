<?php

class FMControllerManage_fm {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Events                                                                             //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constants                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constructor & Destructor                                                           //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function __construct() {
  }
  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function execute() {
    // $task = ((isset($_POST['task'])) ? esc_html($_POST['task']) : '');
    // $id = ((isset($_POST['current_id'])) ? esc_html($_POST['current_id']) : 0);
    $task = WDW_FM_Library::get('task');
    $id = WDW_FM_Library::get('current_id', 0);
    $message = WDW_FM_Library::get('message');
    echo WDW_FM_Library::message_id($message);
    if (method_exists($this, $task)) {
      $this->$task($id);
    }
    else {
      $this->display();
    }
  }

  public function display() {
    require_once WD_FM_DIR . "/admin/models/FMModelManage_fm.php";
    $model = new FMModelManage_fm();

    require_once WD_FM_DIR . "/admin/views/FMViewManage_fm.php";
    $view = new FMViewManage_fm($model);
    $view->display();
  }

  public function add() {
    require_once WD_FM_DIR . "/admin/models/FMModelManage_fm.php";
    $model = new FMModelManage_fm();

    require_once WD_FM_DIR . "/admin/views/FMViewManage_fm.php";
    $view = new FMViewManage_fm($model);
    $view->edit(0);
  }

  public function edit() {
    require_once WD_FM_DIR . "/admin/models/FMModelManage_fm.php";
    $model = new FMModelManage_fm();

    require_once WD_FM_DIR . "/admin/views/FMViewManage_fm.php";
    $view = new FMViewManage_fm($model);
    // $id = ((isset($_POST['current_id']) && esc_html($_POST['current_id']) != '') ? esc_html($_POST['current_id']) : 0);
    $id = WDW_FM_Library::get('current_id', 0);
    $view->edit($id);
  }

  public function edit_old() {
    require_once WD_FM_DIR . "/admin/models/FMModelManage_fm.php";
    $model = new FMModelManage_fm();

    require_once WD_FM_DIR . "/admin/views/FMViewManage_fm.php";
    $view = new FMViewManage_fm($model);
    // $id = ((isset($_POST['current_id']) && esc_html($_POST['current_id']) != '') ? esc_html($_POST['current_id']) : 0);
    $id = WDW_FM_Library::get('current_id', 0);
    // var_dump('s');
    $view->edit_old($id);
  }

  public function form_options_old() {
    if (!isset($_GET['task'])) {
      $this->save_db();
    }
    require_once WD_FM_DIR . "/admin/models/FMModelManage_fm.php";
    $model = new FMModelManage_fm();

    require_once WD_FM_DIR . "/admin/views/FMViewManage_fm.php";
    $view = new FMViewManage_fm($model);
    // $id = ((isset($_POST['current_id']) && esc_html($_POST['current_id']) != '') ? esc_html($_POST['current_id']) : 0);
    global $wpdb;
    $id = WDW_FM_Library::get('current_id', $wpdb->get_var("SELECT MAX(id) FROM " . $wpdb->prefix . "formmaker"));
    $view->form_options_old($id);
  }

  public function save_options_old() {
    $message = $this->save_db_options_old();
    // $this->edit_old();
    $page = WDW_FM_Library::get('page');
    $current_id = WDW_FM_Library::get('current_id', 0);
    WDW_FM_Library::spider_redirect(add_query_arg(array('page' => $page, 'task' => 'edit_old', 'current_id' => $current_id, 'message' => $message), admin_url('admin.php')));
  }

  public function apply_options_old() {
    $message = $this->save_db_options_old();
    require_once WD_FM_DIR . "/admin/models/FMModelManage_fm.php";
    $model = new FMModelManage_fm();

    require_once WD_FM_DIR . "/admin/views/FMViewManage_fm.php";
    $view = new FMViewManage_fm($model);
    // $id = ((isset($_POST['current_id']) && esc_html($_POST['current_id']) != '') ? esc_html($_POST['current_id']) : 0);
    // $view->form_options_old($id);
    $page = WDW_FM_Library::get('page');
    $current_id = WDW_FM_Library::get('current_id', 0);
    $fieldset_id = WDW_FM_Library::get('fieldset_id', 'general');
    WDW_FM_Library::spider_redirect(add_query_arg(array('page' => $page, 'task' => 'form_options_old', 'current_id' => $current_id, 'message' => $message, 'fieldset_id' => $fieldset_id), admin_url('admin.php')));
  }

  public function save_db_options_old() {
    $javascript = "// Before the form is loaded.
function before_load() {
  
}	
// Before form submit.
function before_submit() {
  
}	
// Before form reset.
function before_reset() {
  
}";
    global $wpdb;
    // $id = (isset($_POST['current_id']) ? (int) esc_html(stripslashes($_POST['current_id'])) : 0);
    $id = WDW_FM_Library::get('current_id', 0);
    $mail = (isset($_POST['mail']) ? esc_html(stripslashes($_POST['mail'])) : '');
    $theme = (isset($_POST['theme']) ? esc_html(stripslashes($_POST['theme'])) : 1);
    $javascript = (isset($_POST['javascript']) ? stripslashes($_POST['javascript']) : $javascript);
    $script1 = (isset($_POST['script1']) ? esc_html(stripslashes($_POST['script1'])) : '');
    $script2 = (isset($_POST['script2']) ? esc_html(stripslashes($_POST['script2'])) : '');
    $script_user1 = (isset($_POST['script_user1']) ? esc_html(stripslashes($_POST['script_user1'])) : '');
    $script_user2 = (isset($_POST['script_user2']) ? esc_html(stripslashes($_POST['script_user2'])) : '');
    $submit_text = (isset($_POST['submit_text']) ? stripslashes($_POST['submit_text']) : '');
    $url = (isset($_POST['url']) ? esc_html(stripslashes($_POST['url'])) : '');
    $script_mail = (isset($_POST['script_mail']) ? stripslashes($_POST['script_mail']) : '%all%');
    $script_mail_user = (isset($_POST['script_mail_user']) ? stripslashes($_POST['script_mail_user']) : '%all%');
    $label_order_current = (isset($_POST['label_order_current']) ? esc_html(stripslashes($_POST['label_order_current'])) : '');
    $tax = (isset($_POST['tax']) ? esc_html(stripslashes($_POST['tax'])) : 0);
    $payment_currency = (isset($_POST['payment_currency']) ? stripslashes($_POST['payment_currency']) : '');
    $paypal_email = (isset($_POST['paypal_email']) ? esc_html(stripslashes($_POST['paypal_email'])) : '');
    $checkout_mode = (isset($_POST['checkout_mode']) ? esc_html(stripslashes($_POST['checkout_mode'])) : 'testmode');
    $paypal_mode = (isset($_POST['paypal_mode']) ? esc_html(stripslashes($_POST['paypal_mode'])) : 0);
    $from_mail = (isset($_POST['from_mail']) ? esc_html(stripslashes($_POST['from_mail'])) : '');
    $from_name = (isset($_POST['from_name']) ? esc_html(stripslashes($_POST['from_name'])) : '');
    if (isset($_POST['submit_text_type'])) {
      $submit_text_type = esc_html(stripslashes($_POST['submit_text_type']));
      if ($submit_text_type == 5) {
        $article_id = (isset($_POST['page_name']) ? esc_html(stripslashes($_POST['page_name'])) : 0);
      }
      else {
        $article_id = (isset($_POST['post_name']) ? esc_html(stripslashes($_POST['post_name'])) : 0);
      }
    }
    else {
      $submit_text_type = 0;
      $article_id = 0;
    }
    $save = $wpdb->update($wpdb->prefix . 'formmaker', array(
      'mail' => $mail,
      'theme' => $theme,
      'javascript' => $javascript,
      'submit_text' => $submit_text,
      'url' => $url,
      'submit_text_type' => $submit_text_type,
      'script_mail' => $script_mail,
      'script_mail_user' => $script_mail_user,
      'article_id' => $article_id,
      'paypal_mode' => $paypal_mode,
      'checkout_mode' => $checkout_mode,
      'paypal_email' => $paypal_email,
      'payment_currency' => $payment_currency,
      'tax' => $tax,
      'from_mail' => $from_mail,
      'from_name' => $from_name,                  
    ), array('id' => $id));
    if ($save !== FALSE) {
      return 8;
    }
    else {
      return 2;
    }
  }

  public function cancel_options_old() {
    $this->edit_old();
  }

  public function form_layout() {
    if (!isset($_GET['task'])) {
      $this->save_db();
    }
    require_once WD_FM_DIR . "/admin/models/FMModelManage_fm.php";
    $model = new FMModelManage_fm();

    require_once WD_FM_DIR . "/admin/views/FMViewManage_fm.php";
    $view = new FMViewManage_fm($model);
    // $id = ((isset($_POST['current_id']) && esc_html($_POST['current_id']) != '') ? esc_html($_POST['current_id']) : 0);
    global $wpdb;
    $id = WDW_FM_Library::get('current_id', $wpdb->get_var("SELECT MAX(id) FROM " . $wpdb->prefix . "formmaker"));
    $view->form_layout($id);
  }

  public function save_layout() {
    $message = $this->save_db_layout();
    // $this->edit();
    $page = WDW_FM_Library::get('page');
    $current_id = WDW_FM_Library::get('current_id', 0);
    WDW_FM_Library::spider_redirect(add_query_arg(array('page' => $page, 'task' => 'edit', 'current_id' => $current_id, 'message' => $message), admin_url('admin.php')));
  }

  public function apply_layout() {
    $message = $this->save_db_layout();
    require_once WD_FM_DIR . "/admin/models/FMModelManage_fm.php";
    $model = new FMModelManage_fm();

    require_once WD_FM_DIR . "/admin/views/FMViewManage_fm.php";
    $view = new FMViewManage_fm($model);
    // $id = ((isset($_POST['current_id']) && esc_html($_POST['current_id']) != '') ? esc_html($_POST['current_id']) : 0);
    $page = WDW_FM_Library::get('page');
    $current_id = WDW_FM_Library::get('current_id', 0);
    WDW_FM_Library::spider_redirect(add_query_arg(array('page' => $page, 'task' => 'form_layout', 'current_id' => $current_id, 'message' => $message), admin_url('admin.php')));
    // $view->form_layout($id);
  }

  public function save_db_layout() {
    global $wpdb;
    // $id = (isset($_POST['current_id']) ? (int) esc_html(stripslashes($_POST['current_id'])) : 0);
    $id = WDW_FM_Library::get('current_id', 0);
    $custom_front = (isset($_POST['custom_front']) ? stripslashes($_POST['custom_front']) : '');
    $autogen_layout = (isset($_POST['autogen_layout']) ? 1 : 0);
    $save = $wpdb->update($wpdb->prefix . 'formmaker', array(
      'custom_front' => $custom_front,
      'autogen_layout' => $autogen_layout
    ), array('id' => $id));
    if ($save !== FALSE) {
      return 1;
    }
    else {
      return 2;
    }
  }

  public function form_options() {
    if (!isset($_GET['task'])) {
      $this->save_db();
    }
    require_once WD_FM_DIR . "/admin/models/FMModelManage_fm.php";
    $model = new FMModelManage_fm();

    require_once WD_FM_DIR . "/admin/views/FMViewManage_fm.php";
    $view = new FMViewManage_fm($model);
    // $id = ((isset($_POST['current_id']) && esc_html($_POST['current_id']) != '') ? esc_html($_POST['current_id']) : 0);
    global $wpdb;
    $id = WDW_FM_Library::get('current_id', $wpdb->get_var("SELECT MAX(id) FROM " . $wpdb->prefix . "formmaker"));
    $view->form_options($id);
  }

  public function save_options() {
    $message = $this->save_db_options();
    // $this->edit();
    $page = WDW_FM_Library::get('page');
    $current_id = WDW_FM_Library::get('current_id', 0);
    WDW_FM_Library::spider_redirect(add_query_arg(array('page' => $page, 'task' => 'edit', 'current_id' => $current_id, 'message' => $message), admin_url('admin.php')));
  }

  public function apply_options() {
    $message = $this->save_db_options();
    require_once WD_FM_DIR . "/admin/models/FMModelManage_fm.php";
    $model = new FMModelManage_fm();

    require_once WD_FM_DIR . "/admin/views/FMViewManage_fm.php";
    $view = new FMViewManage_fm($model);
    // $id = ((isset($_POST['current_id']) && esc_html($_POST['current_id']) != '') ? esc_html($_POST['current_id']) : 0);
    // $view->form_options($id);
    $page = WDW_FM_Library::get('page');
    $current_id = WDW_FM_Library::get('current_id', 0);
    $fieldset_id = WDW_FM_Library::get('fieldset_id', 'general');
    WDW_FM_Library::spider_redirect(add_query_arg(array('page' => $page, 'task' => 'form_options', 'current_id' => $current_id, 'message' => $message, 'fieldset_id' => $fieldset_id), admin_url('admin.php')));
  }

  public function remove_query() {
    global $wpdb;
    $cid = ((isset($_POST['cid']) && $_POST['cid'] != '') ? $_POST['cid'] : NULL); 
    if (count($cid)) {
      $cids = implode(',', $cid);
      $query = 'DELETE FROM ' . $wpdb->prefix . 'formmaker_query WHERE id IN ( ' . $cids . ' )';
      if ($wpdb->query($query)) {
        echo WDW_FM_Library::message('Items Succesfully Deleted.', 'updated');
      }
      else {
        echo WDW_FM_Library::message('Error. Please install plugin again.', 'error');
      }
    }
    else {
      echo WDW_FM_Library::message('You must select at least one item.', 'error');
    }
    $this->apply_options();
  }
  
  public function cancel_options() {
    $this->edit();
  }

  public function save_db_options() {
    $javascript = "// Before the form is loaded.
function before_load() {
  
}	
// Before form submit.
function before_submit() {
  
}	
// Before form reset.
function before_reset() {
  
}";
    global $wpdb;
    // $id = (isset($_POST['current_id']) ? (int) esc_html(stripslashes($_POST['current_id'])) : 0);
    $id = WDW_FM_Library::get('current_id', 0);
    $published = (isset($_POST['published']) ? esc_html(stripslashes($_POST['published'])) : 1);
    $savedb = (isset($_POST['savedb']) ? esc_html(stripslashes($_POST['savedb'])) : 1);
    $theme = ((isset($_POST['theme']) && (esc_html($_POST['theme']) != 0)) ? esc_html(stripslashes($_POST['theme'])) : $wpdb->get_var("SELECT MAX(id) FROM " . $wpdb->prefix . "formmaker_themes"));
    $requiredmark = (isset($_POST['requiredmark']) ? esc_html(stripslashes($_POST['requiredmark'])) : '*');
    $sendemail = (isset($_POST['sendemail']) ? esc_html(stripslashes($_POST['sendemail'])) : 1);
    $mail = (isset($_POST['mail']) ? esc_html(stripslashes($_POST['mail'])) : '');
    $from_mail = (isset($_POST['from_mail']) ? esc_html(stripslashes($_POST['from_mail'])) : '');
    $from_name = (isset($_POST['from_name']) ? esc_html(stripslashes($_POST['from_name'])) : '');
    $reply_to = (isset($_POST['reply_to']) ? esc_html(stripslashes($_POST['reply_to'])) : '');
    if ($from_mail == "other") {
      $from_mail = (isset($_POST['mail_from_other']) ? esc_html(stripslashes($_POST['mail_from_other'])) : '');
    }
    if ($reply_to == "other") {
      $reply_to = (isset($_POST['reply_to_other']) ? esc_html(stripslashes($_POST['reply_to_other'])) : '');
    }
    $script_mail = (isset($_POST['script_mail']) ? stripslashes($_POST['script_mail']) : '%all%');
    $mail_from_user = (isset($_POST['mail_from_user']) ? esc_html(stripslashes($_POST['mail_from_user'])) : '');
    $mail_from_name_user = (isset($_POST['mail_from_name_user']) ? esc_html(stripslashes($_POST['mail_from_name_user'])) : '');
    $reply_to_user = (isset($_POST['reply_to_user']) ? esc_html(stripslashes($_POST['reply_to_user'])) : '');
    $condition = (isset($_POST['condition']) ? esc_html(stripslashes($_POST['condition'])) : '');
    $mail_cc = (isset($_POST['mail_cc']) ? esc_html(stripslashes($_POST['mail_cc'])) : '');
    $mail_cc_user = (isset($_POST['mail_cc_user']) ? esc_html(stripslashes($_POST['mail_cc_user'])) : '');
    $mail_bcc = (isset($_POST['mail_bcc']) ? esc_html(stripslashes($_POST['mail_bcc'])) : '');
    $mail_bcc_user = (isset($_POST['mail_bcc_user']) ? esc_html(stripslashes($_POST['mail_bcc_user'])) : '');
    $mail_subject = (isset($_POST['mail_subject']) ? esc_html(stripslashes($_POST['mail_subject'])) : '');
    $mail_subject_user = (isset($_POST['mail_subject_user']) ? esc_html(stripslashes($_POST['mail_subject_user'])) : '');
    $mail_mode = (isset($_POST['mail_mode']) ? esc_html(stripslashes($_POST['mail_mode'])) : 1);
    $mail_mode_user = (isset($_POST['mail_mode_user']) ? esc_html(stripslashes($_POST['mail_mode_user'])) : 1);
    $mail_attachment = (isset($_POST['mail_attachment']) ? esc_html(stripslashes($_POST['mail_attachment'])) : 1);
    $mail_attachment_user = (isset($_POST['mail_attachment_user']) ? esc_html(stripslashes($_POST['mail_attachment_user'])) : 1);
    $script_mail_user = (isset($_POST['script_mail_user']) ? stripslashes($_POST['script_mail_user']) : '%all%');
    $submit_text = (isset($_POST['submit_text']) ? stripslashes($_POST['submit_text']) : '');
    $url = (isset($_POST['url']) ? esc_html(stripslashes($_POST['url'])) : '');
    $tax = (isset($_POST['tax']) ? esc_html(stripslashes($_POST['tax'])) : 0);
    $payment_currency = (isset($_POST['payment_currency']) ? stripslashes($_POST['payment_currency']) : '');
    $paypal_email = (isset($_POST['paypal_email']) ? esc_html(stripslashes($_POST['paypal_email'])) : '');
    $checkout_mode = (isset($_POST['checkout_mode']) ? esc_html(stripslashes($_POST['checkout_mode'])) : 'testmode');
    $paypal_mode = (isset($_POST['paypal_mode']) ? esc_html(stripslashes($_POST['paypal_mode'])) : 0);
    $javascript = (isset($_POST['javascript']) ? stripslashes($_POST['javascript']) : $javascript);
    $send_to = '';
    for ($i = 0; $i < 20; $i++) {
      if (isset($_POST['send_to' . $i])) {
        $send_to .= '*' . esc_html(stripslashes($_POST['send_to' . $i])) . '*';
      }
    }
    if (isset($_POST['submit_text_type'])) {
      $submit_text_type = esc_html(stripslashes($_POST['submit_text_type']));
      if ($submit_text_type == 5) {
        $article_id = (isset($_POST['page_name']) ? esc_html(stripslashes($_POST['page_name'])) : 0);
      }
      else {
        $article_id = (isset($_POST['post_name']) ? esc_html(stripslashes($_POST['post_name'])) : 0);
      }
    }
    else {
      $submit_text_type = 0;
      $article_id = 0;
    }
    $save = $wpdb->update($wpdb->prefix . 'formmaker', array(
      'published' => $published,
      'savedb' => $savedb,
      'theme' => $theme,
      'requiredmark' => $requiredmark,
      'sendemail' => $sendemail,
      'mail' => $mail,
      'from_mail' => $from_mail,
      'from_name' => $from_name,
      'reply_to' => $reply_to,
      'script_mail' => $script_mail,
      'mail_from_user' => $mail_from_user,
      'mail_from_name_user' => $mail_from_name_user,
      'reply_to_user' => $reply_to_user,
      'condition' => $condition,
      'mail_cc' => $mail_cc,
      'mail_cc_user' => $mail_cc_user,
      'mail_bcc' => $mail_bcc,
      'mail_bcc_user' => $mail_bcc_user,
      'mail_subject' => $mail_subject,
      'mail_subject_user' => $mail_subject_user,
      'mail_mode' => $mail_mode,
      'mail_mode_user' => $mail_mode_user,
      'mail_attachment' => $mail_attachment,
      'mail_attachment_user' => $mail_attachment_user,
      'script_mail_user' => $script_mail_user,
      'submit_text' => $submit_text,
      'url' => $url,
      'submit_text_type' => $submit_text_type,
      'article_id' => $article_id,
      'tax' => $tax,
      'payment_currency' => $payment_currency,
      'paypal_email' => $paypal_email,
      'checkout_mode' => $checkout_mode,
      'paypal_mode' => $paypal_mode,
      'javascript' => $javascript,
      'send_to' => $send_to,
    ), array('id' => $id));
    if ($save !== FALSE) {
      return 8;
    }
    else {
      return 2;
    }
  }

  public function save_as_copy_old() {
    $message = $this->save_db_as_copy_old();
    // $this->display();
    $page = WDW_FM_Library::get('page');
    WDW_FM_Library::spider_redirect(add_query_arg(array('page' => $page, 'task' => 'display', 'message' => $message), admin_url('admin.php')));
  }

  public function save_old() {
    $message = $this->save_db_old();
    // $this->display();
    $page = WDW_FM_Library::get('page');
    WDW_FM_Library::spider_redirect(add_query_arg(array('page' => $page, 'task' => 'display', 'message' => $message), admin_url('admin.php')));
  }

  public function apply_old() {
    global $wpdb;
    $message = $this->save_db_old();
    // $this->edit_old();
    $id = (int) $wpdb->get_var("SELECT MAX(id) FROM " . $wpdb->prefix . "formmaker");
    $current_id = WDW_FM_Library::get('current_id', $id);
    $page = WDW_FM_Library::get('page');
    WDW_FM_Library::spider_redirect(add_query_arg(array('page' => $page, 'task' => 'edit_old', 'current_id' => $current_id, 'message' => $message), admin_url('admin.php')));
  }

  public function save_db_old() {
    global $wpdb;
    // $id = (isset($_POST['current_id']) ? (int) esc_html(stripslashes($_POST['current_id'])) : 0);
    $id = WDW_FM_Library::get('current_id', 0);
    $title = (isset($_POST['title']) ? esc_html(stripslashes($_POST['title'])) : '');
    $form = (isset($_POST['form']) ? stripslashes($_POST['form']) : '');
    $form_front = (isset($_POST['form_front']) ? stripslashes($_POST['form_front']) : '');
    $counter = (isset($_POST['counter']) ? esc_html(stripslashes($_POST['counter'])) : 0);
    $label_order = (isset($_POST['label_order']) ? esc_html(stripslashes($_POST['label_order'])) : '');
    $label_order_current = (isset($_POST['label_order_current']) ? esc_html(stripslashes($_POST['label_order_current'])) : '');
    $pagination = (isset($_POST['pagination']) ? esc_html(stripslashes($_POST['pagination'])) : '');
    $show_title = (isset($_POST['show_title']) ? esc_html(stripslashes($_POST['show_title'])) : '');
    $show_numbers = (isset($_POST['show_numbers']) ? esc_html(stripslashes($_POST['show_numbers'])) : '');
    $public_key = (isset($_POST['public_key']) ? esc_html(stripslashes($_POST['public_key'])) : '');
    $private_key = (isset($_POST['private_key']) ? esc_html(stripslashes($_POST['private_key'])) : '');
    $recaptcha_theme = (isset($_POST['recaptcha_theme']) ? esc_html(stripslashes($_POST['recaptcha_theme'])) : '');

    $save = $wpdb->update($wpdb->prefix . 'formmaker', array(
      'title' => $title,
      'form' => $form,
      'form_front' => $form_front,
      'counter' => $counter,
      'label_order' => $label_order,
      'label_order_current' => $label_order_current,
      'pagination' => $pagination,
      'show_title' => $show_title,
      'show_numbers' => $show_numbers,
      'public_key' => $public_key,
      'private_key' => $private_key,
      'recaptcha_theme' => $recaptcha_theme,                   
    ), array('id' => $id));
    if ($save !== FALSE) {
      return 1;
    }
    else {
      return 2;
    }
  }

  public function save_db_as_copy_old() {
    global $wpdb;
    // $id = (isset($_POST['current_id']) ? (int) esc_html(stripslashes($_POST['current_id'])) : 0);
    $id = WDW_FM_Library::get('current_id', 0);
    $row = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'formmaker WHERE id="%d"', $id));
    $title = (isset($_POST['title']) ? esc_html(stripslashes($_POST['title'])) : '');
    $form = (isset($_POST['form']) ? stripslashes($_POST['form']) : '');
    $form_front = (isset($_POST['form_front']) ? stripslashes($_POST['form_front']) : '');
    $counter = (isset($_POST['counter']) ? esc_html(stripslashes($_POST['counter'])) : 0);
    $label_order = (isset($_POST['label_order']) ? esc_html(stripslashes($_POST['label_order'])) : '');
    $pagination = (isset($_POST['pagination']) ? esc_html(stripslashes($_POST['pagination'])) : '');
    $show_title = (isset($_POST['show_title']) ? esc_html(stripslashes($_POST['show_title'])) : '');
    $show_numbers = (isset($_POST['show_numbers']) ? esc_html(stripslashes($_POST['show_numbers'])) : '');
    $public_key = (isset($_POST['public_key']) ? esc_html(stripslashes($_POST['public_key'])) : '');
    $private_key = (isset($_POST['private_key']) ? esc_html(stripslashes($_POST['private_key'])) : '');
    $recaptcha_theme = (isset($_POST['recaptcha_theme']) ? esc_html(stripslashes($_POST['recaptcha_theme'])) : '');

    $save = $wpdb->insert($wpdb->prefix . 'formmaker', array(
      'title' => $title,
      'mail' => $row->mail,
      'form' => $form,
      'form_front' => $form_front,
      'theme' => $row->theme,
      'counter' => $counter,
      'label_order' => $label_order,
      'pagination' => $pagination,
      'show_title' => $show_title,
      'show_numbers' => $show_numbers,
      'public_key' => $public_key,
      'private_key' => $private_key,
      'recaptcha_theme' => $recaptcha_theme,
      'javascript' => $row->javascript,
      'script1' => $row->script1,
      'script2' => $row->script2,
      'script_user1' => $row->script_user1,
      'script_user2' => $row->script_user2,
      'submit_text' => $row->submit_text,
      'url' => $row->url,
      'article_id' => $row->article_id,
      'submit_text_type' => $row->submit_text_type,
      'script_mail' => $row->script_mail,
      'script_mail_user' => $row->script_mail_user,
      'paypal_mode' => $row->paypal_mode,
      'checkout_mode' => $row->checkout_mode,
      'paypal_email' => $row->paypal_email,
      'payment_currency' => $row->payment_currency,
      'tax' => $row->tax,
      'label_order_current' => $row->label_order_current,
      'from_mail' => $row->from_mail,
      'from_name' => $row->from_name,
      'reply_to_user' => $row->reply_to_user,
      'mail_from_name_user' => $row->mail_from_name_user,
      'mail_from_user' => $row->mail_from_user,
      'custom_front' => $row->custom_front,
      'autogen_layout' => $row->autogen_layout,
      'send_to' => $row->send_to,
      'reply_to' => $row->reply_to,
      'requiredmark' => $row->requiredmark,
      'sendemail' => $row->sendemail,
      'savedb' => $row->savedb,
      'form_fields' => $row->form_fields,
      'published' => $row->published
    ), array(
      '%s',
      '%s',
      '%s',
      '%s',
      '%d',
      '%d',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%d',
      '%s',
      '%s',
      '%d',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%d',
      '%s',
      '%s',
      '%s',
      '%d',
      '%d',
      '%s',
      '%d'
    ));
    $id = $wpdb->get_var("SELECT MAX(id) FROM " . $wpdb->prefix . "formmaker");
    $wpdb->insert($wpdb->prefix . 'formmaker_views', array(
      'form_id' => $id,
      'views' => 0
      ), array(
        '%d',
        '%d'
    ));
    if ($save !== FALSE) {
      return 1;
    }
    else {
      return 2;
    }
  }

  public function save_as_copy() {
    $message = $this->save_db_as_copy();
    // $this->display();
    $page = WDW_FM_Library::get('page');
    WDW_FM_Library::spider_redirect(add_query_arg(array('page' => $page, 'task' => 'display', 'message' => $message), admin_url('admin.php')));
  }

  public function save() {
    $message = $this->save_db();
    // $this->display();
    $page = WDW_FM_Library::get('page');
    WDW_FM_Library::spider_redirect(add_query_arg(array('page' => $page, 'task' => 'display', 'message' => $message), admin_url('admin.php')));
  }

  public function apply() {
    $message = $this->save_db();
    // $this->edit();
    global $wpdb;
    $id = (int) $wpdb->get_var("SELECT MAX(id) FROM " . $wpdb->prefix . "formmaker");
    $current_id = WDW_FM_Library::get('current_id', $id);
    $page = WDW_FM_Library::get('page');
    WDW_FM_Library::spider_redirect(add_query_arg(array('page' => $page, 'task' => 'edit', 'current_id' => $current_id, 'message' => $message), admin_url('admin.php')));
  }

  public function save_db() {
    global $wpdb;
    $javascript = "// before form is load
function before_load() {	
}	
// before form submit
function before_submit() {
}	
// before form reset
function before_reset() {	
}";
    // $id = (isset($_POST['current_id']) ? (int) esc_html(stripslashes($_POST['current_id'])) : 0);
    $id = WDW_FM_Library::get('current_id', 0);
    $title = (isset($_POST['title']) ? esc_html(stripslashes($_POST['title'])) : '');
    $form_front = (isset($_POST['form_front']) ? stripslashes($_POST['form_front']) : '');
    $counter = (isset($_POST['counter']) ? esc_html(stripslashes($_POST['counter'])) : 0);
    $label_order = (isset($_POST['label_order']) ? esc_html(stripslashes($_POST['label_order'])) : '');
    $pagination = (isset($_POST['pagination']) ? esc_html(stripslashes($_POST['pagination'])) : '');
    $show_title = (isset($_POST['show_title']) ? esc_html(stripslashes($_POST['show_title'])) : '');
    $show_numbers = (isset($_POST['show_numbers']) ? esc_html(stripslashes($_POST['show_numbers'])) : '');
    $public_key = (isset($_POST['public_key']) ? esc_html(stripslashes($_POST['public_key'])) : '');
    $private_key = (isset($_POST['private_key']) ? esc_html(stripslashes($_POST['private_key'])) : '');
    $recaptcha_theme = (isset($_POST['recaptcha_theme']) ? esc_html(stripslashes($_POST['recaptcha_theme'])) : '');
    $label_order_current = (isset($_POST['label_order_current']) ? esc_html(stripslashes($_POST['label_order_current'])) : '');
    $form_fields = (isset($_POST['form_fields']) ? stripslashes($_POST['form_fields']) : '');

    if ($id != 0) {
      $save = $wpdb->update($wpdb->prefix . 'formmaker', array(
        'title' => $title,
        'form_front' => $form_front,
        'counter' => $counter,
        'label_order' => $label_order,
        'label_order_current' => $label_order_current,
        'pagination' => $pagination,
        'show_title' => $show_title,
        'show_numbers' => $show_numbers,
        'public_key' => $public_key,
        'private_key' => $private_key,
        'recaptcha_theme' => $recaptcha_theme,
        'form_fields' => $form_fields,
      ), array('id' => $id));
    }
    else {
      $save = $wpdb->insert($wpdb->prefix . 'formmaker', array(
        'title' => $title,
        'mail' => '',
        'form_front' => $form_front,
        'theme' => $wpdb->get_var("SELECT id FROM " . $wpdb->prefix . "formmaker_themes WHERE css LIKE '%.wdform_section%'"),
        'counter' => $counter,
        'label_order' => $label_order,
        'pagination' => $pagination,
        'show_title' => $show_title,
        'show_numbers' => $show_numbers,
        'public_key' => $public_key,
        'private_key' => $private_key,
        'recaptcha_theme' => $recaptcha_theme,
        'javascript' => $javascript,
        'submit_text' => '',
        'url' => '',
        'article_id' => 0,
        'submit_text_type' => 0,
        'script_mail' => '%all%',
        'script_mail_user' => '%all%',
        'label_order_current' => $label_order_current,
        'tax' => 0,
        'payment_currency' => '',
        'paypal_email' => '',
        'checkout_mode' => 'testmode',
        'paypal_mode' => 0,
        'published' => 1,
        'form_fields' => $form_fields,
        'savedb' => 1,
        'sendemail' => 1,
        'requiredmark' => '*',
        'from_mail' => '',
        'from_name' => '',
        'reply_to' => '',
        'send_to' => '',
        'autogen_layout' => 1,
        'custom_front' => '',
        'mail_from_user' => '',
        'mail_from_name_user' => '',
        'reply_to_user' => '',
        'condition' => '',
        'mail_cc' => '',
        'mail_cc_user' => '',
        'mail_bcc' => '',
        'mail_bcc_user' => '',
        'mail_subject' => '',
        'mail_subject_user' => '',
        'mail_mode' => 1,
        'mail_mode_user' => 1,
        'mail_attachment' => 1,
        'mail_attachment_user' => 1,
      ), array(
				'%s',
        '%s',
        '%s',
        '%d',
        '%d',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%d',
        '%d',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%d',
        '%d',
        '%s',
        '%d',
        '%d',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%d',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%d',
        '%d',
        '%d',
        '%d',
      ));
      $id = $wpdb->get_var("SELECT MAX(id) FROM " . $wpdb->prefix . "formmaker");
      // $_POST['current_id'] = $id;
      $wpdb->insert($wpdb->prefix . 'formmaker_views', array(
        'form_id' => $id,
        'views' => 0
        ), array(
          '%d',
          '%d'
      ));
    }
    if ($save !== FALSE) {
      return 1;
    }
    else {
      return 2;
    }
  }

  public function save_db_as_copy() {
    global $wpdb;
    // $id = (isset($_POST['current_id']) ? (int) esc_html(stripslashes($_POST['current_id'])) : 0);
    $id = WDW_FM_Library::get('current_id', 0);
    $row = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'formmaker WHERE id="%d"', $id));
    $title = (isset($_POST['title']) ? esc_html(stripslashes($_POST['title'])) : '');
    $form_front = (isset($_POST['form_front']) ? stripslashes($_POST['form_front']) : '');
    $counter = (isset($_POST['counter']) ? esc_html(stripslashes($_POST['counter'])) : 0);
    $label_order = (isset($_POST['label_order']) ? esc_html(stripslashes($_POST['label_order'])) : '');
    $label_order_current = (isset($_POST['label_order_current']) ? esc_html(stripslashes($_POST['label_order_current'])) : '');
    $pagination = (isset($_POST['pagination']) ? esc_html(stripslashes($_POST['pagination'])) : '');
    $show_title = (isset($_POST['show_title']) ? esc_html(stripslashes($_POST['show_title'])) : '');
    $show_numbers = (isset($_POST['show_numbers']) ? esc_html(stripslashes($_POST['show_numbers'])) : '');
    $public_key = (isset($_POST['public_key']) ? esc_html(stripslashes($_POST['public_key'])) : '');
    $private_key = (isset($_POST['private_key']) ? esc_html(stripslashes($_POST['private_key'])) : '');
    $recaptcha_theme = (isset($_POST['recaptcha_theme']) ? esc_html(stripslashes($_POST['recaptcha_theme'])) : '');
    $form_fields = (isset($_POST['form_fields']) ? stripslashes($_POST['form_fields']) : '');

    $save = $wpdb->insert($wpdb->prefix . 'formmaker', array(
      'title' => $title,
      'mail' => $row->mail,
      'form_front' => $form_front,
      'theme' => $row->theme,
      'counter' => $counter,
      'label_order' => $label_order,
      'pagination' => $pagination,
      'show_title' => $show_title,
      'show_numbers' => $show_numbers,
      'public_key' => $public_key,
      'private_key' => $private_key,
      'recaptcha_theme' => $recaptcha_theme,
      'javascript' => $row->javascript,
      'submit_text' => $row->submit_text,
      'url' => $row->url,
      'article_id' => $row->article_id,
      'submit_text_type' => $row->submit_text_type,
      'script_mail' => $row->script_mail,
      'script_mail_user' => $row->script_mail_user,
      'label_order_current' => $label_order_current,
      'tax' => $row->tax,
      'payment_currency' => $row->payment_currency,
      'paypal_email' => $row->paypal_email,
      'checkout_mode' => $row->checkout_mode,
      'paypal_mode' => $row->paypal_mode,
      'published' => $row->published,
      'form_fields' => $form_fields,
      'savedb' => $row->savedb,
      'sendemail' => $row->sendemail,
      'requiredmark' => $row->requiredmark,
      'from_mail' => $row->from_mail,
      'from_name' => $row->from_name,
      'reply_to' => $row->reply_to,
      'send_to' => $row->send_to,
      'autogen_layout' => $row->autogen_layout,
      'custom_front' => $row->custom_front,
      'mail_from_user' => $row->mail_from_user,
      'mail_from_name_user' => $row->mail_from_name_user,
      'reply_to_user' => $row->reply_to_user,
      'condition' => $row->condition,
      'mail_cc' => $row->mail_cc,
      'mail_cc_user' => $row->mail_cc_user,
      'mail_bcc' => $row->mail_bcc,
      'mail_bcc_user' => $row->mail_bcc_user,
      'mail_subject' => $row->mail_subject,
      'mail_subject_user' => $row->mail_subject_user,
      'mail_mode' => $row->mail_mode,
      'mail_mode_user' => $row->mail_mode_user,
      'mail_attachment' => $row->mail_attachment,
      'mail_attachment_user' => $row->mail_attachment_user,
    ), array(
      '%s',
      '%s',
      '%s',
      '%d',
      '%d',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%d',
      '%d',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%d',
      '%d',
      '%s',
      '%d',
      '%d',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%d',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%d',
      '%d',
      '%d',
      '%d',
    ));
    $id = $wpdb->get_var("SELECT MAX(id) FROM " . $wpdb->prefix . "formmaker");
    $wpdb->insert($wpdb->prefix . 'formmaker_views', array(
      'form_id' => $id,
      'views' => 0
      ), array(
        '%d',
        '%d'
    ));
    if ($save !== FALSE) {
      return 1;
    }
    else {
      return 2;
    }
  }

  public function delete($id) {
    global $wpdb;
    $query = $wpdb->prepare('DELETE FROM ' . $wpdb->prefix . 'formmaker WHERE id="%d"', $id);
    if ($wpdb->query($query)) {
      $wpdb->query($wpdb->prepare('DELETE FROM ' . $wpdb->prefix . 'formmaker_views WHERE form_id="%d"', $id));
      $wpdb->query($wpdb->prepare('DELETE FROM ' . $wpdb->prefix . 'formmaker_submits WHERE form_id="%d"', $id));
      $message = 3;
    }
    else {
      $message = 2;
    }
    // $this->display();
    $page = WDW_FM_Library::get('page');
    WDW_FM_Library::spider_redirect(add_query_arg(array('page' => $page, 'task' => 'display', 'message' => $message), admin_url('admin.php')));
  }
  
  public function delete_all() {
    global $wpdb;
    $flag = FALSE;
    $isDefault = FALSE;
    $form_ids_col = $wpdb->get_col('SELECT id FROM ' . $wpdb->prefix . 'formmaker');
    foreach ($form_ids_col as $form_id) {
      if (isset($_POST['check_' . $form_id])) {
        $flag = TRUE;
        $wpdb->query($wpdb->prepare('DELETE FROM ' . $wpdb->prefix . 'formmaker WHERE id="%d"', $form_id));
        $wpdb->query($wpdb->prepare('DELETE FROM ' . $wpdb->prefix . 'formmaker_views WHERE form_id="%d"', $form_id));
        $wpdb->query($wpdb->prepare('DELETE FROM ' . $wpdb->prefix . 'formmaker_submits WHERE form_id="%d"', $form_id));
      }
    }
    if ($flag) {
      $message = 5;
    }
    else {
      $message = 6;
    }
    // $this->display();
    $page = WDW_FM_Library::get('page');
    WDW_FM_Library::spider_redirect(add_query_arg(array('page' => $page, 'task' => 'display', 'message' => $message), admin_url('admin.php')));
  }

  ////////////////////////////////////////////////////////////////////////////////////////
  // Getters & Setters                                                                  //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Private Methods                                                                    //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Listeners                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
}