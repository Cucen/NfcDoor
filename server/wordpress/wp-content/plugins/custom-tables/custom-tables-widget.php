<?php
/*
   Plugin Name: Custom Tables Widget
   Plugin URI: http://blog.murawski.ch/2011/08/custom-tables-wordpress-plugin/
   Description: [PREMIUM FEATURE] Delivers a Widget for Link Categories to a Custom Table
   Version: 3.9.5
   Author: Web Updates KMU
   Author URI: http://wuk.ch/

   Copyright (c) 2011 web updates kmu <stefan@wuk.ch>
   All rights reserved.
*/

Class WCT_Widget Extends WP_Widget {

	function WCT_Widget() {
		$widget_ops = array('classname' => 'WCT_Widget', 
						'description' => __( 'The recent posts of your blogroll links', 'wct') );
		$control_ops = array( 'width' => 400);
		$this->WP_Widget ( 'wct', 'Custom Tables Widget', $widget_ops, $control_ops);
	}

	function wct_sort_object($a, $b) {
		global $k, $l, $j;
		if ($a->$j == $b->$j ){ return 0; } 
		return ($a->$j < $b->$j) ? $k : $l;
	} 

	function widget($args, $instance) {
		global $wpdb,$donewctonce, $field, $j, $k, $l;
		extract($args);

		$out = wp_cache_get( 'wct_widget'.$title , 'wct');
		if ($out == false) {

			$out .= $before_widget;
			$link = $instance['link'];
			$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);

			/* hack for qtranslatesupport */
			if(!function_exists('qtrans_getLanguage')) {function qtrans_getLanguage(){}}
			if (qtrans_getLanguage() != '') {
				$field = $instance['field'.qtrans_getLanguage()];
				if (preg_match('/.*!--:'.qtrans_getLanguage().'-->(.*?)<!--:--.*/',$title)) {
					preg_match('/.*!--:'.qtrans_getLanguage().'-->(.*?)<!--:--.*/',rbr($feld), $treffer);
					$treffer = $treffer[1];
				}
				$lang = "&lang=".qtrans_getLanguage();
			}
			else { $field = $instance['field']; }

			$settings = get_option('wuk_custom_tables');
			if ($settings['css2'] != '') { $out .= "<style>".stripslashes($settings['css2'])."</style>"; }

			if ($donewctonce == '' AND $instance['show_list'] == '1' AND !empty( $title )) { $out .= "<script>
				function wct_box_toggle(name) {
					var huhu = document.getElementById(name).style.visibility;
					if (huhu == \"visible\") {
						document.getElementById(name).style.visibility = \"hidden\";
						document.getElementById(name).style.display = 'none';
						document.getElementById(name + \"B\").style.visibility = \"visible\";
						document.getElementById(name + \"B\").style.display = 'block';
					}
					else {
						document.getElementById(name).style.visibility = \"visible\";
						document.getElementById(name).style.display = 'block';
						document.getElementById(name + \"B\").style.visibility = \"hidden\";
						document.getElementById(name + \"B\").style.display = 'none';
					}
				}
				</script>";
				$donewctonce = '1';
			}

			if (strpos($url, "?") !== false) { $link = $link.$lang; }
			else { $link = $link.str_replace("&","?",$lang); }

			if ( !empty( $title ) ) {
				$out .= $before_title."<a href=\"";
				if ($instance['show_list'] == '1') { $out .= "#\" onclick=\"wct_box_toggle('".md5($title)."')\" style=\"text-decoration:none;\""; }
				else { $out .= "".$link."\""; }
				$out .= " class=\"wct_widget_title\">". $title ."</a>". $after_title;
			}
			$table = isset($instance['table']) ? $instance['table'] : false;

			$show_count = $instance['show_count'] ? '1' : '0';
			$show_empty = $instance['show_empty'] ? '1' : '0';
			$limit = ($instance['limit'] != '-1') ? "LIMIT ".$instance['limit'] : '';

			if ($table != '' OR $field != '' OR $link != '') {
				$url = $link;
				$pos = strpos($url, "&");
				if ($pos !== false) { $url = substr_replace($url, "?", $pos, 1); }
				if (strpos($url,"?") === false) { $url .= "?"; } elseif (substr($url, -1) != "?") { $url .= "&"; }

				if ($instance['filter'] != '') { $sqlfilter = " AND ".html_entity_decode(str_replace(array("&lt;","&gt;","time()-1d","time()+1d","time()"),array("<",">",(time()-86400),(time()+86400),time()),$instance['filter'])); }

				$qry = $wpdb->get_row("SHOW COLUMNS FROM `".$wpdb->prefix."wct".$table."` LIKE '".$field."';");	
				if (substr($qry->Type,0,5) == "enum(") {

					if ($instance['order'] == 'anz DESC') { $order = "`anzahl` DESC"; }
					elseif ($instance['order'] == 'field ASC') { $order = "`".$field."` ASC"; }
					elseif ($instance['order'] == 'field DESC') { $order = "`".$field."` DESC"; }
					else { $order = "`anzahl` ASC"; }

					$qry = $wpdb->get_results("SELECT count(id) as `anzahl`, `".$field."` FROM `".$wpdb->prefix."wct".$table."` WHERE `status`='active' AND `".$field."`!='' ".$sqlfilter." GROUP BY `".$field."` ORDER BY ".$order." ".$limit.";");
				}
				else {
					$sets = explode(",",substr($qry->Type,4,strlen($qry->Type)-5));
					unset($qry);
					$m = '0';
					foreach ($sets as $var => $wert) {
						$wert = substr($wert,1,strlen($wert)-2);
						$sql .= " sum( CASE WHEN LOCATE(\",".$wert.",\",CONCAT(',',".$field.", ',')) THEN 1 ELSE 0 END) as `feld_".$wert."`,";
					}
					$abfrage = "SELECT ".substr($sql,0,strlen($sql)-1)." FROM `".$wpdb->prefix."wct".$table."` WHERE `status`='active' AND `setfeld`!='';";
					$abfrage = $wpdb->get_row($abfrage);
					foreach ($sets as $var => $wert) {
						$wert = substr($wert,1,strlen($wert)-2);
						$n = new stdClass();
						if ($field != '') { $n->$field = $wert; }
						$g = "feld_".$wert;
						$n->anzahl = $abfrage->$g;
						$qry[$m] = $n;
						$m++;
					}

					if ($instance['order'] == 'anz DESC') { $j = 'anzahl'; $k='1'; $l='-1'; }
					elseif ($instance['order'] == 'anz ASC') { $j = 'anzahl'; $k='-1'; $l='1';  }
					elseif ($instance['order'] == 'field DESC') { $j = $field; $k='1'; $l='-1'; }
					else { $j = $field; $k='-1'; $l='1'; }
					usort($qry,array( &$this, 'wct_sort_object'));
				}

				if (count($qry) >= '1') {
					$out .= "<ul class=\"wct_widget_ul\" id=\"".md5($title)."\" style=\"visibility:";
					if ($instance['show_entries'] == '0' AND $instance['show_list'] == '1') { $out .= "hidden;display:none;"; }
					else {  $out .= "visible;display:block;"; }
					$out .= "\">";
					$x = '0';
					unset($total);
					foreach ($qry as $row) {
						if ($row->anzahl >= '1' OR $instance['show_empty'] == '0') {
							$out .= "<li class=\"wct_widget_li\"><a title=\"".$row->$field."\" href=\"".$url."wctdrof=".$field."&wctdrop=".($row->$field != '' ? rawurlencode(base64_encode($row->$field)) : '' ).$lang."\" class=\"wct_widget_a\">".$row->$field."";
							if ($show_count == '1') { $out .= " (".$row->anzahl.")"; }
							$out .= "</a></li>";
							$total = $total + $row->anzahl;
						}
					}
					$out .= "</ul>";
					if ($instance['hide_allentrytag'] == '0' AND $instance['show_list'] == '1' AND !empty( $title )) {
						$out .= "<ul class=\"wct_widget_ul\" id=\"".md5($title)."B\" style=\"visibility:";
						if ($instance['show_entries'] != '0') { $out .= "hidden;display:none;"; }
						else {  $out .= "visible;display:block;"; }
						$out .= "\">";
						$out .= "<li class=\"wct_widget_li\"><a href=\"".$link."\" class=\"wct_widget_a\">".__('Show all Entries','wct');
						if ($show_count == '1') { $out .= " (".$total.")"; }
						$out .= "</a></li>";
						$out .= "</ul>";
					}
				}
			}
			else {
				$out .= __('Widget not configurated','wct');
				if (qtrans_getLanguage() != '') { $out .= " Language '".qtrans_getLanguage()."' field not set?"; }
			}		
			$out .= $after_widget;
			wp_cache_set( 'wct_widget'.$title, $out, 'wct', $this->settings['wct_cachetime']);
		}
		echo $out;
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;

		$aargs = array( 
			'title' => '',
			'table' => '',
			'field' => '',
			'link' => '',
			'filter' => '',
			'order' => 'anz ASC',
			'limit' => 0 );
		if(!function_exists('qtrans_getLanguage')) {function qtrans_getLanguage(){}}
		if (qtrans_getLanguage() != '') {
			$langs = get_option('qtranslate_enabled_languages');
			foreach ($langs as $var => $wert) {
				$aargs['field'.$wert] = '';
			}
		}

		$new_instance = wp_parse_args( (array) $new_instance, $aargs );
		$instance['title'] = $new_instance['title'];
		$instance['table'] = (int)$new_instance['table'];
		$instance['field'] = $new_instance['field'];
		$instance['order'] = $new_instance['order'];
		$instance['link'] = $new_instance['link'];
		$instance['filter'] = $new_instance['filter'];
		$instance['show_entries'] = $new_instance['show_entries'] ? 1 : 0;
		$instance['limit'] = ($new_instance['limit'] != '0') ? (int)$new_instance['limit'] : '0';
		$instance['show_count'] = $new_instance['show_count'] ? 1 : 0;
		$instance['show_empty'] = $new_instance['show_empty'] ? 1 : 0;
		$instance['show_list'] = $new_instance['show_list'] ? 1 : 0;
		$instance['hide_allentrytag'] = $new_instance['hide_allentrytag'] ? 1 : 0;


		if (qtrans_getLanguage() != '') {
			foreach ($langs as $var => $wert) {
				$instance['field'.$wert] = $new_instance['field'.$wert];
			}
		}

		return $instance;
	}

	function prem_chk($serial = '', $do = '0') {
		if ($serial == '') { $serial = $this->settings['form_serial']; }
		if ($do == '1') { return $serial; }
		else {
			$parts = explode('-',$serial);
			if(sizeof($parts) != 4) return false;
 			list($part1, $part2, $part3, $part4) = $parts;
			if (($part2 % 4) == substr($part3,2,1) AND ($part1 % 9) == substr($part2,0,1) AND ($part1 % 5) == substr($part2,3,1) AND $part4 == (($part3 + 4) % 8).(($part1 + $part3 * 39) % 7 ).(($part2 + 12 + $part3 / (2/7)) % 3 ).(($part2 * 27 + 1) % 3 )) { return true; }
			else { return false; }
		}
	}

	function form($instance) {	
		$settings = get_option('wuk_custom_tables');
		if (!array_key_exists('form_serial',$settings) OR $settings['form_serial'] == '' OR $this->prem_chk($settings['form_serial']) == false) {
			$settings['form_serial'] = '';
			$settings['form_serialvu'] = '0';
			update_option('wuk_custom_tables', $settings);

			$current = get_option('active_plugins');
			array_splice($current, array_search( 'custom-tables/custom-tables-widget.php', $current), 1 );
			update_option('active_plugins', $current);
			exit("<meta http-equiv=\"refresh\" content=\"0; url=plugins.php?deactivate=true\">");
		}

		global $wpdb;		

		$aargs = array( 
			'title' => '',
			'table' => '',
			'field' => '',
			'link' => '',
			'filter' => '',
			'order' => 'anz ASC',
			'limit' => 0,
			'show_count' => 1,
			'show_entries' => 1,
			'show_list' => 1,
			'show_empty' => 1,
			'hide_allentrytag' => 0 );

		if(!function_exists('qtrans_getLanguage')) {function qtrans_getLanguage(){}}
		if (qtrans_getLanguage() != '') {
			$langs = get_option('qtranslate_enabled_languages');
			foreach ($langs as $var => $wert) {
				$aargs['field'.$wert] = '';
			}
		}

		$instance = wp_parse_args( (array) $instance, $aargs );

		$title = $instance['title'];
		$link = strip_tags($instance['link']);

		$field = $instance['field'];

		if (qtrans_getLanguage() != '') {
			foreach ($langs as $var => $wert) {
				$t = "field".$wert;
				$$t = $instance['field'.$wert];
			}
		}

		$show_count = $instance['show_count'] ? 'checked' : '';
		$show_empty = $instance['show_empty'] ? 'checked' : '';
		$show_entries = $instance['show_entries'] ? 'checked' : '';
		$show_list = $instance['show_list'] ? 'checked' : '';
		$hide_allentrytag = $instance['hide_allentrytag'] ? 'checked' : '';

		$limit = ($instance['limit'] != '0') ? $instance['limit'] : '-1';

		$qry = $wpdb->get_results("SELECT `id`,`name` FROM `".$wpdb->prefix."wct_list` WHERE `id`!='0' ORDER BY `id` ASC;");
			
		echo "<p style=\"border-bottom:1px solid #DFDFDF;\"><strong><font color=\"#0000A0\">PREMIUM FEATURE</font></strong></p>
		<p>
			<label for=\"".$this->get_field_id('title')."\">". __('Title:', 'wct')."</label>
			<input id=\"".$this->get_field_id('title')."\" name=\"".$this->get_field_name('title')."\" type=\"text\" value=\"".$instance['title']."\" size=\"50\" />
		</p>	
		<p>
			<label for=\"".$this->get_field_id('link')."\">". __('Table Page URL:', 'wct')."</label>
			<input id=\"".$this->get_field_id('link')."\" name=\"".$this->get_field_name('link')."\" type=\"text\" value=\"".$instance['link']."\" size=\"47\" />
		</p>		
		<p>
			".__('Generate Widget from Table', 'wct').":
			<label for=\"".$this->get_field_id('table')."\" class=\"screen-reader-text\">". __('Select Table', 'wct')."</label>
			<select style=\"width: 150px;\" id=\"".$this->get_field_id('table')."\" name=\"".$this->get_field_name('table')."\" onchange=\"WctOnChange();\">";
				if ($instance['table'] == '') { echo '<option value="" selected></option>\n'; }
				foreach ( $qry as $row ) {
					echo '<option value="' . intval($row->id) . '"'. ( $row->id == $instance['table'] ? ' selected' : '' ). '>' . $row->name . '</option>\n';
				}
			echo "</select>
		</p>
		
		<script type=\"text/javascript\">
			function WctOnChange () {
				var myindex = document.getElementById('".$this->get_field_id('table')."').selectedIndex;
				var SelTable = document.getElementById('".$this->get_field_id('table')."').options[myindex].value;";
				
				if (qtrans_getLanguage() != '') {
					foreach ($langs as $var => $wert) {
						echo "document.getElementById('".$this->get_field_id('field'.$wert)."').options.length=0;";
					}
				}
				else {
					echo "document.getElementById('".$this->get_field_id('field')."').options.length=0;";
				}
			
				$anz = count($qry);
				foreach ( $qry as $row ) {

					$table = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$row->id."`;");
					$array=array(); foreach($table as $member=>$data) { $array[$member]=$data; }
					$tmp = explode("PRIMARY KEY",$array['Create Table']);
					echo "if (SelTable == '".$row->id."') {";

					preg_match_all("/`(.*)` (enum|set).*/",$tmp[0],$matches);

					for ($x=0;$matches[1][$x] != '';$x++) {
						if ($matches[1][$x] != 'status') {
							if (qtrans_getLanguage() != '') {
								foreach ($langs as $var => $wert) {
									echo "document.getElementById('".$this->get_field_id('field'.$wert)."').options[$x]=new Option(\"".$matches[1][$x]."\", \"".$matches[1][$x]."\", false, false);";
								}
							}
							else {
								echo "document.getElementById('".$this->get_field_id('field')."').options[$x]=new Option(\"".$matches[1][$x]."\", \"".$matches[1][$x]."\", false, false);";
							}
							if ($row->id == $instance['table']) {
								if (qtrans_getLanguage() != '') {
									foreach ($langs as $var => $wert) {
										$t = "field".$wert; $m = "stdopt".$wert;
										$$m .= "<option value=\"".$matches[1][$x]."\"". (($matches[1][$x] == $$t) ? ' selected' : '' ).">".$matches[1][$x]."</option>";
									}
								}
								else {
									$stdopt .= "<option value=\"".$matches[1][$x]."\"". (($matches[1][$x] == $field) ? ' selected' : '' ).">".$matches[1][$x]."</option>";
								}
							}
						}
					}
					
					echo "}";
				}
			echo "}</script>";
			
		if (qtrans_getLanguage() != '') {
			foreach ($langs as $var => $wert) {
				echo "<p>".__('List Items of Field', 'wct')." (".$wert."):
					<label for=\"".$this->get_field_id('field'.$wert)."\" class=\"screen-reader-text\">". __('Select Fields', 'wct')."</label>
					<select id=\"".$this->get_field_id('field'.$wert)."\" name=\"".$this->get_field_name('field'.$wert)."\">";
						$m = "stdopt".$wert; echo $$m;
						echo "</select> ".__('Only Enum() and Set() fields can be selected','wct')."
				</p>";
			}
		}
		else {
			echo "<p>".__('List Items of Field', 'wct').":
				<label for=\"".$this->get_field_id('field')."\" class=\"screen-reader-text\">". __('Select Fields', 'wct')."</label>
				<select id=\"".$this->get_field_id('field')."\" name=\"".$this->get_field_name('field')."\"> 
					".$stdopt."
				</select> ".__('Only Enum() and Set() fields can be selected','wct')."
			</p>";
		}

		echo "<p>
			".__('Order of Links', 'wct').":
			<label for=\"".$this->get_field_id('order')."\" class=\"screen-reader-text\">". __('Select Order', 'wct')."</label>
			<select id=\"".$this->get_field_id('order')."\" name=\"".$this->get_field_name('order')."\"> 
				<option value=\"anz DESC\"". ('anz DESC' == $instance['order'] ? ' selected' : '' ).">".__('Item Count (DESC)','wct')."</option>
				<option value=\"anz ASC\"". ('anz ASC' == $instance['order'] ? ' selected' : '' ).">".__('Item Count (ASC)','wct')."</option>
				<option value=\"field ASC\"". ('field ASC' == $instance['order'] ? ' selected' : '' ).">".__('Field Content (ASC)','wct')."</option>
				<option value=\"field DESC\"". ('field DESC' == $instance['order'] ? ' selected' : '' ).">".__('Field Content (DESC)','wct')."</option>
			</select>
		</p>
		<p>
			<input class=\"checkbox\" type=\"checkbox\" ".$show_count." id=\"".$this->get_field_id( 'show_count' )."\" name=\"".$this->get_field_name( 'show_count' )."\" />
			<label for=\"".$this->get_field_id( 'show_count' )."\">". __('Show count', 'wct')."</label>
		</p>
		<p>
			<input class=\"checkbox\" type=\"checkbox\" ".$show_empty." id=\"".$this->get_field_id( 'show_empty' )."\" name=\"".$this->get_field_name( 'show_empty' )."\" />
			<label for=\"".$this->get_field_id( 'show_empty' )."\">". __('Hide empty tables links', 'wct')."</label>
		</p>
		<p>
			<fieldset style=\"background-color: #ffffff;\">
				<legend><strong>" . __('Widget Handling', 'wct') . "</strong></legend>
				<input class=\"checkbox\" type=\"checkbox\" ".$show_list." id=\"".$this->get_field_id( 'show_list' )."\" name=\"".$this->get_field_name( 'show_list' )."\" />
				<label for=\"".$this->get_field_id( 'show_list' )."\">". __('Show and hide List possible', 'wct')."</label><br/>

				<input class=\"checkbox\" type=\"checkbox\" ".$show_entries." id=\"".$this->get_field_id( 'show_entries' )."\" name=\"".$this->get_field_name( 'show_entries' )."\" />
				<label for=\"".$this->get_field_id( 'show_entries' )."\">". __('List opened as Default', 'wct')."</label><br/>

				<input class=\"checkbox\" type=\"checkbox\" ".$hide_allentrytag." id=\"".$this->get_field_id( 'hide_allentrytag' )."\" name=\"".$this->get_field_name( 'hide_allentrytag' )."\" />
				<label for=\"".$this->get_field_id( 'hide_allentrytag' )."\">". __('Hide All Entries Tag', 'wct')."</label>
			</fieldset>
		</p>";
		$wctsettings = get_option('wuk_custom_tables');
		if ($wctsettings['wct_unfilteredsql'] == "1") {
			echo "<p>
				<label for=\"".$this->get_field_id('filter')."\">". __('SQL Filter', 'wct').":</label>
				<input id=\"".$this->get_field_id('filter')."\" name=\"".$this->get_field_name('filter')."\" type=\"text\" value=\"".$instance['filter']."\" size=\"47\" />
			</p>";
		}
		printf ("<p>".__('List max %s Entries','wct')."</p>","<input style=\"text-align: right;\" size=\"5\" type=\"text\" id=\"".$this->get_field_id( 'limit' )."\" name=\"".$this->get_field_name( 'limit' )."\" value=\"".$limit."\" />");
	}
}

$current = get_option('active_plugins');
if (count($current)==0 AND WP_ALLOW_MULTISITE == true) {
	$current = get_site_option('active_sitewide_plugins');
}

if (in_array( 'custom-tables/custom-tables-widget.php', $current) OR array_key_exists( 'custom-tables/custom-tables-widget.php', $current) AND (!in_array( 'custom-tables/custom-tables.php', $current) OR $settings['form_serial'] == '')) {
	if (WP_ALLOW_MULTISITE == true) {
		foreach ($current as $var => $wert) {
			if ($var != "custom-tables/custom-tables-widget.php" AND $wert != "custom-tables/custom-tables-widget.php") { $newplugs[$var] = $wert;  }
		}

		echo "<div class=\"updated\" style=\"width:610px;background-color: red;\"><p><b>Custom Tables Search</b>".
		__('The Premium Extension is Single Domain Usage only! Please activate it only on the subpages directly.<br/><br/>This Plugin extension will be automatically disabled.','wct')."</p>
		</div>";

		update_site_option('active_sitewide_plugins', $newplugs);
		update_option('active_plugins', $newplugs);
	}
	else {
	
		echo "<div class=\"updated\" style=\"width:610px;background-color: red;\"><p><b>Custom Tables Search</b>".
		__('This is a Premium Extension! The usage without a key is prohibited.<br/><br/>This Plugin extension will be automatically disabled.','wct')."</p>
		</div>";
		
		array_splice($current, array_search( 'custom-tables/custom-tables-search.php', $current) +1, 1 );
		update_option('active_plugins', $current);
	}
}

add_action('widgets_init', create_function('', 'return register_widget("WCT_Widget");'));

?>