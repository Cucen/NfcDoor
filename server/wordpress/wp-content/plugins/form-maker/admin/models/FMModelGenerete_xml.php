<?php

class FMModelGenerete_xml {
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

  public function get_data() {
	$is_paypal_info = FALSE;
    global $wpdb;
    $params = array();
    $form_id = $_REQUEST['form_id'];
    $paypal_info_fields = array('ip', 'ord_date', 'ord_last_modified', 'status', 'full_name', 'fax', 'mobile_phone', 'email', 'phone', 'address', 'paypal_info', 'without_paypal_info', 'ipn', 'checkout_method', 'tax', 'shipping', 'shipping_type', 'read');
    $query = $wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "formmaker_submits where form_id= %d ORDER BY date ASC", $form_id);
    $rows = $wpdb->get_results($query);
    $n = count($rows);
    $labels = array();
    for ($i = 0; $i < $n; $i++) {
      $row = &$rows[$i];
      if (!in_array($row->element_label, $labels)) {
        array_push($labels, $row->element_label);
      }
    }
    $label_titles = array();
    $sorted_labels = array();
    $query_lable = "SELECT label_order,title FROM " . $wpdb->prefix . "formmaker where id=$form_id ";
    $rows_lable = $wpdb->get_results($query_lable);
    $ptn = "/[^a-zA-Z0-9_]/";
    $rpltxt = "";
    $title = preg_replace($ptn, $rpltxt, $rows_lable[0]->title);
    $sorted_labels_id = array();
    $sorted_labels = array();
    $label_titles = array();
    if ($labels) {
      $label_id = array();
      $label_order = array();
      $label_order_original = array();
      $label_type = array();
      $label_all = explode('#****#', $rows_lable[0]->label_order);
      $label_all = array_slice($label_all, 0, count($label_all) - 1);
      foreach ($label_all as $key => $label_each) {
        $label_id_each = explode('#**id**#', $label_each);
        array_push($label_id, $label_id_each[0]);
        $label_oder_each = explode('#**label**#', $label_id_each[1]);
        array_push($label_order_original, $label_oder_each[0]);
        $ptn = "/[^a-zA-Z0-9_]/";
        $rpltxt = "";
        $label_temp = preg_replace($ptn, $rpltxt, $label_oder_each[0]);
        array_push($label_order, $label_temp);
        array_push($label_type, $label_oder_each[1]);
      }
      foreach ($label_id as $key => $label) {
        if (in_array($label, $labels)) {
          array_push($sorted_labels, $label_order[$key]);
          array_push($sorted_labels_id, $label);
          array_push($label_titles, stripslashes($label_order_original[$key]));
        }
      }
    }
    $m = count($sorted_labels);
    $group_id_s = array();
    $l = 0;
    if (count($rows) > 0 and $m) {
      for ($i = 0; $i < count($rows); $i++) {
        $row = &$rows[$i];
        if (!in_array($row->group_id, $group_id_s)) {
          array_push($group_id_s, $row->group_id);
        }
      }
    }
    $data = array();
    $temp_all = array();
    for ($j = 0; $j < $n; $j++) {
      $row = &$rows[$j];
      $key = $row->group_id;
      if (!isset($temp_all[$key])) {
        $temp_all[$key] = array();
      }
      array_push($temp_all[$key], $row);
    }
    for ($www = 0; $www < count($group_id_s); $www++) {
      $i = $group_id_s[$www];
      $temp = array();
      $temp = $temp_all[$i];
      $f = $temp[0];
      $date = $f->date;
      $ip = $f->ip;
      $data_temp['Submit date'] = $date;
      $data_temp['Ip'] = $ip;
      $ttt = count($temp);
      for ($h = 0; $h < $m; $h++) {
        for ($g = 0; $g < $ttt; $g++) {
          $t = $temp[$g];
          if ($t->element_label == $sorted_labels_id[$h]) {
            if (strpos($t->element_value, "*@@url@@*")) {
              $file_names = '';
              $new_files = explode("*@@url@@*", $t->element_value);
              foreach ($new_files as $new_file) {
                if ($new_file) {
                  $file_names .= $new_file . ", ";
                }
              }
              $data_temp[stripslashes($label_titles[$h])] = $file_names;
            }
            elseif (strpos($t->element_value, "***br***")) {
              $element_value = str_replace("***br***", ', ', $t->element_value);
              if (strpos($element_value, "***quantity***")) {
                $element_value = str_replace("***quantity***", '', $element_value);
              }
							if (strpos($element_value, "***property***")) {
                $element_value = str_replace("***property***", '', $element_value);
              }
							if(substr($element_value, -2) == ', ') {
								$data_temp[stripslashes($label_titles[$h])]= substr($element_value, 0, -2);
              }
							else {
								$data_temp[stripslashes($label_titles[$h])]= $element_value;
              }
            }
            elseif (strpos($t->element_value, "***map***")) {
              $data_temp[stripslashes($label_titles[$h])] = 'Longitude:' . str_replace("***map***", ', Latitude:', $t->element_value);
            }
            elseif (strpos($t->element_value,"***star_rating***")) {
              $element = str_replace("***star_rating***", '', $t->element_value);
							$element = explode("***", $element);
							$data_temp[stripslashes($label_titles[$h])] = ' ' . $element[1] . '/' . $element[0];
						}
            elseif (strpos($t->element_value, "@@@") || $t->element_value == "@@@" || $t->element_value == "@@@@@@@@@") {
							$data_temp[stripslashes($label_titles[$h])] = str_replace("@@@", ' ', $t->element_value);
						}
            elseif (strpos($t->element_value, "***grading***")) {
              $element = str_replace("***grading***", '', $t->element_value);
              $grading = explode(":", $element);
							$items_count = sizeof($grading) - 1;
							$items = "";
							$total = "";
              for ($k = 0; $k < $items_count / 2; $k++) {
                $items .= $grading[$items_count / 2 + $k] . ": " . $grading[$k] . ", ";
                $total += $grading[$k];
              }
              $items .= "Total: " . $total;
							$data_temp[stripslashes($label_titles[$h])] = $items;
						}
            elseif (strpos($t->element_value, "***matrix***")) {
              $element = str_replace("***matrix***", '', $t->element_value);
              $matrix_value = explode('***', $element);
              $matrix_value = array_slice($matrix_value, 0, count($matrix_value) - 1);
							$mat_rows = $matrix_value[0];
							$mat_columns = $matrix_value[$mat_rows + 1];
							$matrix = "";
							$aaa = Array();
              $var_checkbox = 1;
							$selected_value = "";
              $selected_value_yes = "";
              $selected_value_no = "";
							for ($k = 1; $k <= $mat_rows; $k++) {
							  if ($matrix_value[$mat_rows + $mat_columns + 2] == "radio") {
                  if ($matrix_value[$mat_rows + $mat_columns + 2 + $k] == 0) {
                    $checked = "0";
                    $aaa[1] = "";
									}
                  else {
                    $aaa = explode("_", $matrix_value[$mat_rows + $mat_columns + 2 + $k]);
                  }
                  for ($l = 1; $l <= $mat_columns; $l++) {
										if ($aaa[1] == $l) {
									    $checked = '1';
                    }
                    else {
									    $checked = '0';
                    }
						        $matrix .= '['.$matrix_value[$k].','.$matrix_value[$mat_rows+1+$l].']='.$checked."; ";
					        }
						    }
								else {
                  if ($matrix_value[$mat_rows+$mat_columns + 2] == "checkbox") {
                    for ($l = 1; $l <= $mat_columns; $l++) {
                      if ($matrix_value[$mat_rows+$mat_columns + 2 + $var_checkbox] == 1) {
                        $checked = '1';
                      }
                      else {
                        $checked = '0';
                      }
							        $matrix .= '['.$matrix_value[$k].','.$matrix_value[$mat_rows+1+$l].']='.$checked."; ";
                      $var_checkbox++;
                    }
                  }
                  else {
                    if ($matrix_value[$mat_rows+$mat_columns + 2] == "text") {
							        for ($l = 1; $l <= $mat_columns; $l++) {
                        $text_value = $matrix_value[$mat_rows+$mat_columns+2+$var_checkbox];
                        $matrix .='['.$matrix_value[$k].','.$matrix_value[$mat_rows+1+$l].']='.$text_value."; ";
                        $var_checkbox++;
                      }
                    }
                    else {
                      for ($l = 1; $l <= $mat_columns; $l++) {
                        $selected_text = $matrix_value[$mat_rows+$mat_columns + 2 + $var_checkbox];
                        $matrix .= '['.$matrix_value[$k].','.$matrix_value[$mat_rows + 1 + $l].']='.$selected_text."; ";
                        $var_checkbox++;
                      }
                    }
                  }
								}
							}
							$data_temp[stripslashes($label_titles[$h])] = $matrix;
						}
            else {
              $val = str_replace('&amp;', "&", $t->element_value);
              $val = stripslashes(str_replace('&#039;', "'", $t->element_value));
              $data_temp[stripslashes($label_titles[$h])] = ($t->element_value ? $val : '');
            }
          }
        }
      }
      $query = $wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "formmaker_sessions where group_id= %d", $f->group_id);
      $paypal_info = $wpdb->get_results($query);
      if ($paypal_info) {
        $is_paypal_info = TRUE;
      }
      if ($is_paypal_info) {
        foreach ($paypal_info_fields as $paypal_info_field)	{
          if ($paypal_info) {
            $data_temp['PAYPAL_' . $paypal_info_field] = $paypal_info[0]->$paypal_info_field;
          }
          else {
            $data_temp['PAYPAL_' . $paypal_info_field] = '';
          }
        }
      }
      $data[] = $data_temp;
    }
	array_push($params, $data);
	array_push($params, $title);
	return $params;	
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