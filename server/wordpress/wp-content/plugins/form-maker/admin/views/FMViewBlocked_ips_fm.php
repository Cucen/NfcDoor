<?php

class FMViewBlocked_ips_fm {
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
    $search_value = ((isset($_POST['search_value'])) ? esc_html(stripslashes($_POST['search_value'])) : '');
    $asc_or_desc = ((isset($_POST['asc_or_desc'])) ? esc_html(stripslashes($_POST['asc_or_desc'])) : 'desc');
    $order_by = (isset($_POST['order_by']) ? esc_html(stripslashes($_POST['order_by'])) : 'id');
    $order_class = 'manage-column column-title sorted ' . $asc_or_desc;
    $ids_string = '';
    ?>
    <div id="fm_blocked_ips_message" style="width: 99%; display: none;"></div>
    <div style="clear: both; float: left; width: 99%;">
      <div style="float:left; font-size: 14px; font-weight: bold;">
        This section allows you to block IPs.
        <a style="color: blue; text-decoration: none;" target="_blank" href="http://web-dorado.com/wordpress-form-maker-guide-2.html">Read More in User Manual</a>
      </div>
      <div style="float: right; text-align: right;">
        <a style="text-decoration: none;" target="_blank" href="http://web-dorado.com/files/fromFormMaker.php">
          <img width="215" border="0" alt="web-dorado.com" src="<?php echo WD_FM_URL . '/images/wd_logo.png'; ?>" />
        </a>
      </div>
    </div>
    <form onkeypress="spider_doNothing(event)" class="wrap" id="blocked_ips" method="post" action="admin.php?page=blocked_ips_fm" style="float: left; width: 99%;">
      <span class="block_icon"></span>
      <h2>Blocked IPs</h2>
      <div class="buttons_div">
        <input class="button-primary" type="submit" value="Save" onclick="spider_set_input_value('task', 'save_all');" />
        <input class="button-secondary" type="submit" value="Delete" onclick="if (confirm('Do you want to unblock selected IPs?')) {
                                                                      spider_set_input_value('task', 'delete_all');
                                                                    } else {
                                                                      return false;
                                                                    }" />
      </div>
      <div class="tablenav top">
        <?php
        WDW_FM_Library::search('IP', $search_value, 'blocked_ips');
        WDW_FM_Library::html_page_nav($page_nav['total'], $page_nav['limit'], 'blocked_ips');
        ?>
      </div>
      <table class="wp-list-table widefat fixed pages">
        <thead>
          <tr>
            <th class="manage-column column-cb check-column table_small_col"><input id="check_all" type="checkbox" style="margin: 0;" /></th>
            <th class="table_small_col <?php if ($order_by == 'id') {echo $order_class;} ?>">
              <a onclick="spider_set_input_value('task', '');
                          spider_set_input_value('order_by', 'id');
                          spider_set_input_value('asc_or_desc', '<?php echo ((isset($_POST['asc_or_desc']) && isset($_POST['order_by']) && (esc_html(stripslashes($_POST['order_by'])) == 'id') && esc_html(stripslashes($_POST['asc_or_desc'])) == 'asc') ? 'desc' : 'asc'); ?>');
                          spider_form_submit(event, 'blocked_ips')" href="">
                <span>ID</span><span class="sorting-indicator"></span></th>
              </a>
            <th class="<?php if ($order_by == 'ip') {echo $order_class;} ?>">
              <a onclick="spider_set_input_value('task', '');
                          spider_set_input_value('order_by', 'ip');
                          spider_set_input_value('asc_or_desc', '<?php echo ((isset($_POST['asc_or_desc']) && isset($_POST['order_by']) && (esc_html(stripslashes($_POST['order_by'])) == 'ip') && esc_html(stripslashes($_POST['asc_or_desc'])) == 'asc') ? 'desc' : 'asc'); ?>');
                          spider_form_submit(event, 'blocked_ips')" href="">
                <span>IP</span><span class="sorting-indicator"></span>
              </a>
            </th>
            <th class="table_big_col">Edit</th>
            <th class="table_big_col">Delete</th>
          </tr>		  
          <tr id="tr">
            <th></th>
            <th></th>
            <th class="edit_input"><input type="text" class="input_th" id="ip" name="ip" onkeypress="return spider_check_isnum(event)"></th>
            <th class="table_big_col">
              <a class="add_tag_th button-primary button button-small" onclick="if (spider_check_required('ip', 'IP')) {return false;}
                                                                                spider_set_input_value('task', 'save');
                                                                                spider_set_input_value('current_id', '');
                                                                                spider_form_submit(event, 'blocked_ips')" href="">Add IP</a>
            </th>
            <th></th>
          </tr>
        </thead>
        <tbody id="tbody_arr">
          <?php
          if ($rows_data) {
            foreach ($rows_data as $row_data) {
              $alternate = (!isset($alternate) || $alternate == 'class="alternate"') ? '' : 'class="alternate"';
              ?>
              <tr id="tr_<?php echo $row_data->id; ?>" <?php echo $alternate; ?>>
                <td class="table_small_col check-column" id="td_check_<?php echo $row_data->id; ?>" >
                  <input id="check_<?php echo $row_data->id; ?>" name="check_<?php echo $row_data->id; ?>" type="checkbox" />
                </td>
                <td class="table_small_col" id="td_id_<?php echo $row_data->id; ?>" ><?php echo $row_data->id; ?></td>
                <td id="td_ip_<?php echo $row_data->id; ?>" >
                  <a class="pointer" id="ip<?php echo $row_data->id; ?>"
                     onclick="spider_edit_ip(<?php echo $row_data->id; ?>)" 
                     title="Edit"><?php echo $row_data->ip; ?></a>
                </td>
                <td class="table_big_col" id="td_edit_<?php echo $row_data->id; ?>">
                  <a onclick="spider_edit_ip(<?php echo $row_data->id; ?>)">Edit</a>
                </td>
                <td class="table_big_col" id="td_delete_<?php echo $row_data->id; ?>">
                  <a onclick="spider_set_input_value('task', 'delete');
                              spider_set_input_value('current_id', <?php echo $row_data->id; ?>);
                              spider_form_submit(event, 'blocked_ips')" href="">Delete</a>
                </td>
              </tr>
              <?php
              $ids_string .= $row_data->id . ',';
            }
          }
          ?>
        </tbody>
      </table>
      <input id="task" name="task" type="hidden" value="" />
      <input id="current_id" name="current_id" type="hidden" value="" />
      <input id="ids_string" name="ids_string" type="hidden" value="<?php echo $ids_string; ?>" />
      <input id="asc_or_desc" name="asc_or_desc" type="hidden" value="<?php echo $asc_or_desc; ?>" />
      <input id="order_by" name="order_by" type="hidden" value="<?php echo $order_by; ?>" />
    </form>
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