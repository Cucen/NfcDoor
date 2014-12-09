<?php

class FMViewFormMakerEditCSS {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Events                                                                             //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constants                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  private $model;


  ////////////////////////////////////////////////////////////////////////////////////////
  // Constructor & Destructor                                                           //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function __construct($model) {
    $this->model = $model;
  }
  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function display() {
    $theme_id = ((isset($_GET['id'])) ? esc_html(stripslashes($_GET['id'])) : '');
    $form_id = ((isset($_GET['form_id'])) ? esc_html(stripslashes($_GET['form_id'])) : 0);
    $row = $this->model->get_theme_row($theme_id);
    wp_print_scripts('jquery');
    ?>
    <link media="all" type="text/css" href="<?php echo get_admin_url(); ?>load-styles.php?c=1&amp;dir=ltr&amp;load=admin-bar,dashicons,wp-admin,buttons,wp-auth-check" rel="stylesheet">
    <link media="all" type="text/css" href="<?php echo get_admin_url(); ?>css/colors<?php echo ((get_bloginfo('version') < '3.8') ? '-fresh' : ''); ?>.min.css" id="colors-css" rel="stylesheet">
    <link media="all" type="text/css" href="<?php echo WD_FM_URL . '/css/form_maker_tables.css'; ?>" rel="stylesheet">
    <script src="<?php echo WD_FM_URL . '/js/form_maker_admin.js'; ?>" type="text/javascript"></script>
    <script src="<?php echo WD_FM_URL . '/js/layout/codemirror.js'; ?>" type="text/javascript"></script>
    <script src="<?php echo WD_FM_URL . '/js/layout/formatting.js'; ?>" type="text/javascript"></script>
    <script src="<?php echo WD_FM_URL . '/js/layout/css.js'; ?>" type="text/javascript"></script>
    <script src="<?php echo WD_FM_URL . '/js/layout/clike.js'; ?>" type="text/javascript"></script>
    <script src="<?php echo WD_FM_URL . '/js/layout/javascript.js'; ?>" type="text/javascript"></script>
    <script src="<?php echo WD_FM_URL . '/js/layout/htmlmixed.js'; ?>" type="text/javascript"></script>
    <script src="<?php echo WD_FM_URL . '/js/layout/xml.js'; ?>" type="text/javascript"></script>
    <script src="<?php echo WD_FM_URL . '/js/layout/php.js'; ?>" type="text/javascript"></script>
    <link media="all" type="text/css" href="<?php echo WD_FM_URL . '/css/codemirror.css'; ?>" rel="stylesheet">
    
    <style>
      .CodeMirror {
        border: 1px solid #ccc;
        font-size: 12px;
        margin-bottom: 6px;
        background: white;
      }
    </style>

    <form id="fm_theme" class="wrap wp-core-ui" method="post" action="#" style="width: 99%; margin: 5px 0 0 5px;">
      <div style="float: right; margin: 0 5px 0 0;">
        <input class="button-secondary" type="submit" onclick="if (spider_check_required('title', 'Theme title')) {return false;};
                                                               spider_set_input_value('task', 'save');
                                                               window.parent.jQuery('#theme option[value=<?php echo $theme_id; ?>]').html(jQuery('#title').val());
                                                               window.parent.tb_remove();" value="Save"/>
        <input class="button-secondary" type="submit" onclick="if (spider_check_required('title', 'Theme title')) {return false;};
                                                               spider_set_input_value('task', 'apply');
                                                               window.parent.jQuery('#theme option[value=<?php echo $theme_id; ?>]').html(jQuery('#title').val());" value="Apply"/>
        <input class="button-secondary" type="submit" onclick="if (spider_check_required('title', 'Theme title')) {return false;};
                                                               spider_set_input_value('task', 'save_as_new');
                                                               window.parent.jQuery('#theme').append('<option value=0>' + jQuery('#title').val() + '</option>');
                                                               window.parent.tb_remove();" value="Save as New"/>
        <input class="button-primary" type="button" onclick="jQuery('#css').val(jQuery('#main_theme').html());" value="Reset"/>
        <input class="button-secondary" type="button" onclick="window.parent.tb_remove();" value="Cancel"/>
      </div>
      <table style="clear: both;">
        <tbody>
          <tr>
            <td class="spider_label"><label for="title">Theme title: <span style="color:#FF0000;"> * </span> </label></td>
            <td><input type="text" id="title" name="title" value="<?php echo $row->title; ?>" class="spider_text_input" /></td>
          </tr>
          <tr>
            <td class="spider_label"><label for="css">Css: </label></td>
            <td style="width: 90%;"><textarea id="css" name="css" rows="25" style="width: 100%;"><?php echo htmlspecialchars($row->css); ?></textarea></td>
          </tr>
        </tbody>
      </table>
      <div style="display: none;" id="main_theme"><?php echo str_replace('"', '\"', $row->css); ?></div>
      <input type="hidden" id="task" name="task" value="" />
      <input type="hidden" id="current_id" name="current_id" value="<?php echo $row->id; ?>" />
      <input type="hidden" id="default" name="default" value="<?php echo $row->default; ?>" />
      <input type="hidden" name="form_id" id="form_id" value="<?php echo $form_id; ?>" />
    </form>
    <script>
      var editor = CodeMirror.fromTextArea(
        document.getElementById("css"), {
        lineNumbers: true,
        lineWrapping: true,
        mode: "css"
      });
      
      CodeMirror.commands["selectAll"](editor);
      editor.autoFormatRange(editor.getCursor(true), editor.getCursor(false));
      editor.scrollTo(0,0);
    </script>
    <?php
    die();
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