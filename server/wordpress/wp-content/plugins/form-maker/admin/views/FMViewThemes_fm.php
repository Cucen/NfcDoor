<?php

class FMViewThemes_fm {
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
    $rows_data = $this->model->get_rows_data();
    $page_nav = $this->model->page_nav();
    $search_value = ((isset($_POST['search_value'])) ? esc_html($_POST['search_value']) : '');
    $search_select_value = ((isset($_POST['search_select_value'])) ? (int)$_POST['search_select_value'] : 0);
    $asc_or_desc = ((isset($_POST['asc_or_desc'])) ? esc_html($_POST['asc_or_desc']) : 'asc');
    $order_by = (isset($_POST['order_by']) ? esc_html($_POST['order_by']) : 'id');
    $order_class = 'manage-column column-title sorted ' . $asc_or_desc;
    $ids_string = '';
    ?>
    <div style="clear: both; float: left; width: 99%;">
      <div style="float:left; font-size: 14px; font-weight: bold;">
        This section allows you to edit form themes.
        <a style="color: blue; text-decoration: none;" target="_blank" href="http://web-dorado.com/wordpress-form-maker-guide-2.html">Read More in User Manual</a>
      </div>
      <div style="float: right; text-align: right;">
        <a style="text-decoration: none;" target="_blank" href="http://web-dorado.com/files/fromFormMaker.php">
          <img width="215" border="0" alt="web-dorado.com" src="<?php echo WD_FM_URL . '/images/wd_logo.png'; ?>" />
        </a>
      </div>
    </div>
    <form class="wrap" id="themes_form" method="post" action="admin.php?page=themes_fm" style="float: left; width: 99%;">
      <span class="theme_icon"></span>
      <h2>
        Themes
        <a href="" class="add-new-h2" onclick="spider_set_input_value('task', 'add');
                                               spider_form_submit(event, 'themes_form')">Add new</a>
      </h2>
      <div class="buttons_div">
        <input class="button-secondary" type="submit" onclick="if (confirm('Do you want to delete selected items?')) {
                                                       spider_set_input_value('task', 'delete_all');
                                                     } else {
                                                       return false;
                                                     }" value="Delete" />
      </div>
      <div class="tablenav top">
        <?php
        WDW_FM_Library::search('Title', $search_value, 'themes_form');
        WDW_FM_Library::html_page_nav($page_nav['total'], $page_nav['limit'], 'themes_form');
        ?>
      </div>
      <table class="wp-list-table widefat fixed pages">
        <thead>
          <th class="manage-column column-cb check-column table_small_col"><input id="check_all" type="checkbox" style="margin:0;"/></th>
          <th class="table_small_col <?php if ($order_by == 'id') { echo $order_class; } ?>">
            <a onclick="spider_set_input_value('task', '');
              spider_set_input_value('order_by', 'id');
              spider_set_input_value('asc_or_desc', '<?php echo ((isset($_POST['asc_or_desc']) && isset($_POST['order_by']) && (esc_html($_POST['order_by']) == 'id') && esc_html($_POST['asc_or_desc']) == 'asc') ? 'desc' : 'asc'); ?>');
              spider_form_submit(event, 'themes_form')" href="">
              <span>ID</span><span class="sorting-indicator"></span></a>
          </th>
          <th class="<?php if ($order_by == 'title') { echo $order_class; } ?>">
            <a onclick="spider_set_input_value('task', '');
              spider_set_input_value('order_by', 'title');
              spider_set_input_value('asc_or_desc', '<?php echo ((isset($_POST['asc_or_desc']) && isset($_POST['order_by']) && (esc_html($_POST['order_by']) == 'title') && esc_html($_POST['asc_or_desc']) == 'asc') ? 'desc' : 'asc'); ?>');
              spider_form_submit(event, 'themes_form')" href="">
              <span>Title</span><span class="sorting-indicator"></span></a>
          </th>
          <th class="table_big_col <?php if ($order_by == 'default') { echo $order_class; } ?>">
            <a onclick="spider_set_input_value('task', '');
              spider_set_input_value('order_by', 'default');
              spider_set_input_value('asc_or_desc', '<?php echo ((isset($_POST['asc_or_desc']) && isset($_POST['order_by']) && (esc_html($_POST['order_by']) == 'default') && esc_html($_POST['asc_or_desc']) == 'asc') ? 'desc' : 'asc'); ?>');
              spider_form_submit(event, 'themes_form')" href="">
              <span>Default</span><span class="sorting-indicator"></span></a>
          </th>
          <th class="table_big_col">Edit</th>
          <th class="table_big_col">Delete</th>
        </thead>
        <tbody id="tbody_arr">
          <?php
          if ($rows_data) {
            foreach ($rows_data as $row_data) {
              $alternate = (!isset($alternate) || $alternate == 'class="alternate"') ? '' : 'class="alternate"';
              $default_image = (($row_data->default) ? 'default' : 'notdefault');
              $default = (($row_data->default) ? '' : 'setdefault');
              ?>
              <tr id="tr_<?php echo $row_data->id; ?>" <?php echo $alternate; ?>>
                <td class="table_small_col check-column">
                  <input id="check_<?php echo $row_data->id; ?>" name="check_<?php echo $row_data->id; ?>" type="checkbox"/>
                </td>
                <td class="table_small_col"><?php echo $row_data->id; ?></td>
                <td>
                  <a onclick="spider_set_input_value('task', 'edit');
                              spider_set_input_value('current_id', '<?php echo $row_data->id; ?>');
                              spider_form_submit(event, 'themes_form')" href="" title="Edit"><?php echo $row_data->title; ?></a>
                </td>
                <td class="table_big_col">
                  <?php
                  if ($default != '') {
                    ?>
                    <a onclick="spider_set_input_value('task', '<?php echo $default; ?>');
                                spider_set_input_value('current_id', '<?php echo $row_data->id; ?>');
                                spider_form_submit(event, 'themes_form')" href="">
                    <?php
                  }
                  ?>
                  <img src="<?php echo WD_FM_URL . '/images/' . $default_image . '.png'; ?>" />
                  <?php
                  if ($default != '') {
                    ?>
                    </a>
                    <?php
                    }
                  ?>
                </td>
                <td class="table_big_col">
                  <a onclick="spider_set_input_value('task', 'edit');
                              spider_set_input_value('current_id', '<?php echo $row_data->id; ?>');
                              spider_form_submit(event, 'themes_form')" href="">Edit</a>
                </td>
                <td class="table_big_col">
                  <a onclick="spider_set_input_value('task', 'delete');
                              spider_set_input_value('current_id', '<?php echo $row_data->id; ?>');
                              spider_form_submit(event, 'themes_form')" href="">Delete</a>
                </td>
              </tr>
              <?php
              $ids_string .= $row_data->id . ',';
            }
          }
          ?>
        </tbody>
      </table>
      <input id="task" name="task" type="hidden" value=""/>
      <input id="current_id" name="current_id" type="hidden" value=""/>
      <input id="ids_string" name="ids_string" type="hidden" value="<?php echo $ids_string; ?>"/>
      <input id="asc_or_desc" name="asc_or_desc" type="hidden" value="asc"/>
      <input id="order_by" name="order_by" type="hidden" value="<?php echo $order_by; ?>"/>
    </form>
    <?php
  }

  public function edit($id, $reset) {
    $row = $this->model->get_row_data($id, $reset);
    $page_title = (($id != 0) ? 'Edit theme ' . $row->title : 'Create new theme');
    ?>
    <style>
    .CodeMirror {
      border: 1px solid #ccc;
      font-size: 12px;
      margin-bottom: 6px;
      background: white;
    }
    </style>
    <div style="clear: both; float: left; width: 99%;">
      <div style="float:left; font-size: 14px; font-weight: bold;">
        This section allows you to edit form themes.
        <a style="color: blue; text-decoration: none;" target="_blank" href="http://web-dorado.com/wordpress-form-maker-guide-2.html">Read More in User Manual</a>
      </div>
      <div style="float: right; text-align: right;">
        <a style="text-decoration: none;" target="_blank" href="http://web-dorado.com/files/fromFormMaker.php">
          <img width="215" border="0" alt="web-dorado.com" src="<?php echo WD_FM_URL . '/images/wd_logo.png'; ?>" />
        </a>
      </div>
    </div>
    <form class="wrap" method="post" action="admin.php?page=themes_fm" style="float: left; width: 99%;">
      <span class="theme_icon"></span>
      <h2><?php echo $page_title; ?></h2>
      <div style="float: right; margin: 0 5px 0 0;">
        <input class="button-secondary" type="submit" onclick="if (spider_check_required('title', 'Title')) {return false;}; spider_set_input_value('task', 'save')" value="Save"/>
        <input class="button-secondary" type="submit" onclick="if (spider_check_required('title', 'Title')) {return false;}; spider_set_input_value('task', 'apply')" value="Apply"/>
        <input class="button-secondary" type="submit" onclick="spider_set_input_value('task', 'cancel')" value="Cancel"/>
      </div>
      <table style="clear:both;">
        <tbody>
          <tr>
            <td class="spider_label"><label for="title">Title: <span style="color:#FF0000;"> * </span> </label></td>
            <td><input type="text" id="title" name="title" value="<?php echo $row->title; ?>" class="spider_text_input" /></td>
          </tr>
          <tr>
            <td class="spider_label"><label for="css">Css: </label></td>
            <td style="width: 90%;"><textarea id="css" name="css" rows="30" style="width: 100%;"><?php echo htmlspecialchars($row->css) ?></textarea></td>
          </tr>
        </tbody>
      </table>
      <input type="hidden" id="task" name="task" value=""/>
      <input type="hidden" id="current_id" name="current_id" value="<?php echo $row->id; ?>"/>
      <input type="hidden" id="default" name="default" value="<?php echo $row->default; ?>"/>
    </form>
    <script>
      var editor = CodeMirror.fromTextArea(document.getElementById("css"), {
      lineNumbers: true,
      lineWrapping: true,
      mode: "css"
      });
      
      CodeMirror.commands["selectAll"](editor);
      editor.autoFormatRange(editor.getCursor(true), editor.getCursor(false));
      editor.scrollTo(0,0);      
    </script>
    <?php
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