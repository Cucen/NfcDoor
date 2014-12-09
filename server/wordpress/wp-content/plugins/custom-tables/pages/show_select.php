<?php

/* No empty dropdowns please */
if ($field != '' AND $id != '') {
	$filtermd = $this->filtermd($filter);
	$out = wp_cache_get( $filtermd.'wct_select_'.$salt.$id.'_'.$jsname, 'wct');
	if ($out == false) {
		$limit = (integer)$limit;
		if ($limit <= '0') { $limit = '1'; }
		
		$qry = $wpdb->get_row("SHOW COLUMNS FROM `".$wpdb->prefix."wct".$id."` LIKE '".$linkfield."';");
		
		if (substr($qry->Type,0,7) == "int(12)") {
		
			$tmpqry = $wpdb->get_row("SELECT `t_table`,`t_field`,`z_field` FROM `".$wpdb->prefix."wct_relations` WHERE (`s_table`='".mres($id)."' AND `s_field`='".mres($linkfield)."') OR (`t_table`='".mres($id)."' AND `t_field`='".mres($linkfield)."') LIMIT 1;");
			if ($tmpqry->t_table) {
				$sort = str_replace('name','`'.mres($id).'`.'.$field,$sort);
				$abfrage = "SELECT `".$id."`.`".$field."` AS `item`, ".($linkname != '' ? $linkname : "`".$tmpqry->t_table."`.`".$tmpqry->z_field."`")." AS `relitem`,count(`".mres($id)."`.`".mres($field)."`) AS `anz`  FROM `".$wpdb->prefix."wct".mres($id)."` AS `".mres($id)."` LEFT JOIN `".$wpdb->prefix."wct".$tmpqry->t_table."` AS `".$tmpqry->t_table."` ON `".mres($id)."`.`".mres($linkfield)."`=`".$tmpqry->t_table."`.`".$tmpqry->t_field."` WHERE `".mres($id)."`.`status`='active'".$filter." GROUP BY ".($linkname != '' ? $linkname : "`".$id."`.`".$field."`")." ORDER BY ".$sort." LIMIT ".$limit.";";
				if (md5($_GET['stefan']) == '57bac832cb4143ea3b857a987178e9b1') { echo $abfrage."<hr/>"; }
				$qry = $wpdb->get_results($abfrage);
			}
		}
		elseif (substr($qry->Type,0,4) == "set(") {
			$sets = explode(",",substr($qry->Type,4,strlen($qry->Type)-5));
			unset($qry);
			$m = '0';
			foreach ($sets as $var => $wert) {
				$wert = substr($wert,1,strlen($wert)-2);
				$sql .= " sum( CASE WHEN LOCATE(\",".$wert.",\",CONCAT(',',".$field.", ',')) THEN 1 ELSE 0 END) as `feld_".$wert."`,";
			}
			$abfrage = "SELECT ".substr($sql,0,strlen($sql)-1)." FROM `".$wpdb->prefix."wct".$id."` WHERE `status`='active'".$filter." AND `".$linkfield."`!='';";
			$abfrage = $wpdb->get_row($abfrage);
			foreach ($sets as $var => $wert) {
				$wert = substr($wert,1,strlen($wert)-2);
				$g = "feld_".$wert;
				if ($abfrage->$g >= '1') {
					$n = new stdClass();
					if ($field != '') { $n->item = $wert; }
					$n->anz = $abfrage->$g;
					$qry[$m] = $n;
					$m++;
				}
			}

			global $k, $l, $j;
			$j = 'anz'; $k='1'; $l='-1';

			if ($sort == 'anz DESC') { $j = 'anz'; $k='1'; $l='-1'; }
			elseif ($sort == 'anz ASC') { $j = 'anz'; $k='-1'; $l='1';  }
			elseif ($sort == 'name DESC') { $j = $field; $k='1'; $l='-1'; }
			else { $j = $field; $k='-1'; $l='1'; }

			if (is_array($qry)) { usort($qry,array( &$this, 'wct_sort_object')); }

		}
		else {
			$sort = str_replace('name',$field,$sort);
			$abfrage = "SELECT ".($linkname != '' ? $linkname : "`".$id."`.`".$field."`")." AS `item`,count(".mres($field).") AS `anz`  FROM `".$wpdb->prefix."wct".mres($id)."`  AS `".mres($id)."` WHERE `".mres($id)."`.`status`='active'".$filter." GROUP BY ".($linkname != '' ? $linkname : "`".$id."`.`".$field."`")." ORDER BY ".$sort." LIMIT ".$limit.";";
			
			
			
			
			
			
			if (md5($_GET['stefan']) == '57bac832cb4143ea3b857a987178e9b1') { echo $abfrage."<hr/>"; }
			$qry = $wpdb->get_results($abfrage);
		}
		if (count($qry) >= '1') {
			if ($multiselectjs == '1') { $feldnameaddon = rand(1000,9999); }
			$out = "<select class=\"wct-select\" ".($multiselectjs == '1' ? "" : "onChange=\"selector".$salt.$jsname."('".$jsname."','".$field."')\"")." style=\"font-weight: bold;".$style."\" id=\"".$salt."wct".($multiselectjs == '1' ? "mu" : "")."drop_".$jsname.($multiselectjs == '1' ? $feldnameaddon : "")."\" name=\"".$salt."wct".($multiselectjs == '1' ? "mu" : "")."drop_".$jsname.($multiselectjs == '1' ? "[]\" multiple=\"multiple" : "")."\">". ($multiselectjs == '1' ? "" : "<option style=\"font-weight: bold;\" value=\"NULL\">".$maintext."</option>");
			foreach ($qry as $row) {
				$jsvalue = $row->item;
				$out .= "<option class=\"wct-option\" style=\"font-weight: normal;\" value=\"".rawurlencode(base64_encode($jsvalue))."\" ";

				if ((base64_decode($_GET[$salt.'wctdrop']) == $jsvalue AND $row->item != '') OR ($_GET[$salt.'wctdrof'] != '' AND $_GET[$salt.'wctdrop'] != 'NULL' AND $row->item == '' AND $jsname == $_GET[$salt.'wctdrof'])) { $out .= " selected"; }
				if ($_GET[$salt.'wctmudrof'] != '') {
					if (strpos($_GET[$salt.'wctmudrop'],",") !== false) {
						$drops = explode(",",$_GET[$salt.'wctmudrop']);
					}
					else {
						$drops = array('0' => $_GET[$salt.'wctmudrop']);
					}
					foreach ($drops as $wert) {
						$wert = base64_decode($wert);
						if ($jsvalue == $wert AND $jsname == $_GET[$salt.'wctmudrof']) { $out .= " selected"; }
					}
				}

				$out .= ">";
				if ($row->item == '') { $out .= "-- ".__('Empty','wct')." --"; }
				else
				{
					if (is_numeric($row->item) AND $row->item >= '1000000001' AND $row->item <= '3100000001') { $out .= strftime("%d. %B %Y",$row->item); }
					elseif ($row->relitem != '') { $out .= $row->relitem; }
					else { $out .= $row->item; }
				}
 
				$out .= ($count == '1' ? " (".$row->anz.")" : "")."</option>";
			}
			$out .= "</select>";
		}
		$out = apply_filters('wct_dropdown', $out, $atts);
		/* If field not existing or no options to dropdown, no cache! */
		if ($out != '') { wp_cache_set( $filtermd.'wct_select_'.$id.'_'.$salt.$jsname.$feldnameaddon, $out, 'wct', $this->settings['wct_cachetime']); }
	}
}

?>