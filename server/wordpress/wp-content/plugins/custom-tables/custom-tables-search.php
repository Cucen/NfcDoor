<?php
/*
   Plugin Name: Custom Tables Search
   Plugin URI: http://blog.murawski.ch/2011/08/custom-tables-wordpress-plugin/
   Description: [PREMIUM FEATURE] Extend the normal WordPress Search with the search in the Custom Tables
   Version: 3.9.5
   Author: Web Updates KMU
   Author URI: http://wuk.ch/

   Copyright (c) 2011 web updates kmu <stefan@wuk.ch>
   All rights reserved.
*/

function wct_table_search($wert) {
	global $wpdb, $_GET;
	$tabl2 = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$wert."`;");
	$array=array(); foreach($tabl2 as $member=>$data) { $array[$member]=$data; }

	$settings = get_option('wuk_custom_tables');
	if ($settings['search_charset'] == "auto" OR $settings['search_charset'] == "") {
		preg_match("/CHARSET=(.*)/",$array['Create Table'],$treffer);

		if ($treffer[1] != '') { 
			$pos = strpos($treffer[1]," ");
			if ($pos === false) { $charset = $treffer[1]; }
			else { $charset = substr($treffer[1],0,$pos); }
		}
		else {
			$charset = "latin1";
		}
	}
	elseif ($settings['search_charset'] != '') {
		$charset = $settings['search_charset'];
	}

	$felder = explode(",",str_replace(array("8,2","','","\r","\n"),array("8.2","'.'","",""),$array['Create Table']));
	unset($feld2,$feld3,$feld4);
	$feld2[1]['i'] = 'id';
	$feld2[1]['d'] = 'filter';

	for ($i=2;$felder[$i] != '';$i++) {
		if (strpos ($felder[$i-1],"KEY") !== false) {
			//KEY Overjump
		}
		elseif (strpos ($felder[$i-1]," enum") !== false) {
			$feld3[$i]['i'] = preg_replace("/.*`(.*)`\s.*/","$1",$felder[$i-1]);
		}
		elseif (strpos ($felder[$i-1]," set") !== false) {
			$feld5[$i]['i'] = preg_replace("/.*`(.*)`\s.*/","$1",$felder[$i-1]);
		}
		elseif (strpos ($felder[$i-1]," text") !== false) {
			$feld2[$i]['i'] = preg_replace("/.*`(.*)`\s.*/","$1",$felder[$i-1]);
		}
		elseif (strpos ($felder[$i-1]," int(10)") !== false) {
			$feld4[$i]['i'] = preg_replace("/.*`(.*)`\s.*/","$1",$felder[$i-1]);
		}
		else {
			$feld2[$i]['i'] = preg_replace("/.*`(.*)`\s(.*\))\s.*/","$1",$felder[$i-1]);
		}
	}
	unset($searchfields,$searchfields2);
	$query = $_GET['s'];
	$query = wct_fixspecialchars($query);
	
	if (strstr($query," ")) { $qquery = explode(" ",$query); }
	else { $qquery = array('0'=>$query); }
	foreach ($qquery as $query) {
		$query2 = $query = mb_convert_encoding($query ,mb_detect_encoding($query),$charset);

		if (preg_match("/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{4})$/", $query2, $regs)) { $db_timestamp = mktime(1,1,1,$regs[2], $regs[1], $regs[3]); }
		elseif (preg_match("/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{2})$/", $query2, $regs)) { $db_timestamp = mktime(1,1,1,$regs[2], $regs[1], '20'.$regs[3]); }
		elseif (preg_match("/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/", $query2, $regs)) { $db_timestamp = mktime(1,1,1,$regs[1], $regs[2], $regs[3]); }
		elseif (preg_match("/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{2})$/", $query2, $regs)) { $db_timestamp = mktime(1,1,1,$regs[1], $regs[2], '20'.$regs[3]); }
		elseif (preg_match("/^([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})$/", $query2, $regs)) { $db_timestamp = mktime(1,1,1,$regs[1], $regs[2], $regs[3]); }
		elseif (preg_match("/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})$/", $query2, $regs)) { $db_timestamp = mktime(1,1,1,$regs[3], $regs[2], $regs[1]); }
		elseif (preg_match("/^([0-9]{1,2})\.([0-9]{1,2})\.$/", $query2, $regs)) { $db_timestamp = mktime(1,1,1,$regs[2], $regs[1], date("Y",time())); }
		else {	unset($db_timestamp); }

		if (is_array($feld2)) {
			foreach ($feld2 as $werd) {
				if ($werd['i'] != 'id') {
					if ($_GET['exact'] == '1') { $searchfields .= "OR LOWER(`".$wert."`.`".$werd['i']."`)='".mres(strtolower($query))."' "; }
					else { $searchfields .= "OR LOWER(`".$wert."`.`".$werd['i']."`) LIKE '%".mres(strtolower(str_replace(" ","_",$query)))."%' "; }
				}
			}
		}
		if (is_array($feld3)) {
			foreach ($feld3 as $werd) {
				if ($werd['i'] != 'status') {
					$searchfields .= "OR LOWER(`".$wert."`.`".$werd['i']."`)='".mres(strtolower($query))."' ";
				}
			}
		}
		if (is_array($feld5)) {
			foreach ($feld5 as $werd) {
				if ($werd['i'] != 'status') {
					$searchfields .= "OR FIND_IN_SET('".mres(strtolower($query))."',LOWER(`".$wert."`.`".$werd['i']."`))>0 ";
				}
			}
		}
		if (isset($db_timestamp)) {
			if (is_array($feld4)) {
				foreach ($feld4 as $werd) {
					$searchfields .= "OR `".$wert."`.`".$werd['i']."`='".$db_timestamp."' ";
				}
			}
			$_GET['wctsz'] = $db_timestamp;

			$mast = $wpdb->get_row("SELECT `searchaddon` FROM `".$wpdb->prefix."wct_list` WHERE id='".$wert."' LIMIT 1;");
			if ($mast->searchaddon != '') {
				$searchfields .= "OR (".str_replace("SEARCH",$db_timestamp,$mast->searchaddon).") ";
			}
		}
	}
	return $searchfields;
}

function wct_search_addon($args) {
	global $wpdb,$_GET;
	
	$query = $_GET['s'];
	$sssquery = md5(wct_fixspecialchars($query));
	$args_cached = wp_cache_get( 'wct_search_'.$sssquery, 'wct');
	if ($args_cached == false) {
		// Do not find multiple times the same results
		
		foreach ($args as $var) { $donts .= "'".$var->ID."',"; }
		if ($donts != '') { $donts = $wpdb->prefix."posts.ID NOT IN (".substr($donts,0,strlen($donts)-1).") AND "; }

		// Search all posts and pages with wctable in it
		$qry = $wpdb->get_results("SELECT ".$wpdb->prefix."posts.* FROM ".$wpdb->prefix."posts WHERE ".$donts." (".$wpdb->prefix."posts.post_content LIKE '%[wctable%' OR ".$wpdb->prefix."posts.post_content LIKE '%[wcteid%') AND ".$wpdb->prefix."posts.post_type IN ('post', 'page') AND ".$wpdb->prefix."posts.post_status = 'publish' ORDER BY ".$wpdb->prefix."posts.post_date DESC;");
		if (count($qry) >= '1') {
			foreach ($qry as $row) {
				//Search frr wctable tag
				preg_match_all("/\[wctable.*?\]/",$row->post_content,$treffer);
				
				foreach ($treffer[0] as $wert) {
					preg_match("/id=[\"]*([0-9]+)[\"]/",$wert,$id);
					preg_match("/filter=[\"]*(.*?)[\"]/",$wert,$filter);
					
					$filter = $filter[1];
					$wert = $id[1];
					$t = "table".$wert.md5($filter);
					if ($$t == '') {

						$searchfields = wct_table_search($wert);
						$searchfields = str_replace(array($wpdb->prefix."wct".$wert,",`id`"),array("",""),$searchfields);
						
						$relations = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wct_relations` WHERE `s_table`='".$wert."';");
						if (count($relations) >= '1') {
							foreach ($relations as $relation) {
								$tr = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$relation->t_table."`;");
								$array=array(); foreach($tr as $member=>$data) { $array[$member]=$data; }
								$felder = explode("PRIMARY KEY",$array['Create Table']);
								$felder = explode(",",str_replace(array("8,2","','","\r","\n"),array("8.2","'.'","",""),$felder[0]));
								for ($i=1;$felder[$i] != '';$i++) {
									$srel .= preg_replace("/.*`(.*)`\s.*/","`".$relation->t_table."`.`$1` AS `$1---".$relation->t_table."`,",$felder[$i-1]);
								}	
								$abfrage2 = "INNER JOIN `".$wpdb->prefix."wct".$relation->t_table."` as `".$relation->t_table."` ON `".$wert."`.`".$relation->s_field."`=`".$relation->t_table."`.`".$relation->t_field."` ";
								$searchfields .= wct_table_search($relation->t_table);
							}
						}

						$abfrage = "SELECT `".$wert."`.`id` FROM `".$wpdb->prefix."wct".$wert."` AS `".$wert."` ".$abfrage2."WHERE (".substr($searchfields,3,strlen($searchfields)-3).") AND `".$wert."`.`status`='active'".($filter != '' ? " AND ".$filter : "")." LIMIT 1;";
						$qry = $wpdb->get_results($abfrage);
						if (count($qry) == '1' AND $added[$row->ID] != '1') {
							$$t = '1';
							$lastID = $row->ID;

							$_GET['wctsf'] = "*";
							$_GET['wcts'] = $_GET['s'];

							$added[$row->ID] = '1';
							$n = count($args);
							$args[$n]->ID = $row->ID;
							$args[$n]->post_author = $row->post_author;
							$args[$n]->post_date = $row->post_date;
							$args[$n]->post_date_gmt = $row->post_date_gmt;
							$args[$n]->post_content = $row->post_content;
							$args[$n]->post_title = $row->post_title;
							$args[$n]->post_excerpt = $row->post_excerpt;
							$args[$n]->post_status = $row->post_status;
							$args[$n]->comment_status = $row->comment_status;
							$args[$n]->ping_status = $row->ping_status;
							$args[$n]->post_password = $row->post_password;
							$args[$n]->post_name = $row->post_name;
							$args[$n]->to_ping = $row->to_ping;
							$args[$n]->pinged = $row->pinged;
							$args[$n]->post_modified = $row->post_modified; 
							$args[$n]->post_modified_gmt = $row->post_modified_gmt;
							$args[$n]->post_content_filtered = $row->post_content_filtered;
							$args[$n]->post_parent = $row->post_parent;
							$args[$n]->guid = $row->guid;
							$args[$n]->menu_order = $row->menu_order;
							$args[$n]->post_type = $row->post_type;
							$args[$n]->post_mime_type = $row->post_mime_type;
							$args[$n]->comment_count = $row->comment_count;
							
						}
						else {
							$$t = '0';
						}
					}
					elseif ($$t == '1' AND $lastID != $row->ID AND $added[$row->ID] != '1') {
						$_GET['wctsf'] = "*";
						$_GET['wcts'] = $_GET['s'];

						$n = count($args);
						$args[$n]->ID = $row->ID;
						$args[$n]->post_author = $row->post_author;
						$args[$n]->post_date = $row->post_date;
						$args[$n]->post_date_gmt = $row->post_date_gmt;
						$args[$n]->post_content = $row->post_content;
						$args[$n]->post_title = $row->post_title;
						$args[$n]->post_excerpt = $row->post_excerpt;
						$args[$n]->post_status = $row->post_status;
						$args[$n]->comment_status = $row->comment_status;
						$args[$n]->ping_status = $row->ping_status;
						$args[$n]->post_password = $row->post_password;
						$args[$n]->post_name = $row->post_name;
						$args[$n]->to_ping = $row->to_ping;
						$args[$n]->pinged = $row->pinged;

						$args[$n]->post_modified = $row->post_modified; 
						$args[$n]->post_modified_gmt = $row->post_modified_gmt;
						$args[$n]->post_content_filtered = $row->post_content_filtered;
						$args[$n]->post_parent = $row->post_parent;
						$args[$n]->guid = $row->guid;
						$args[$n]->menu_order = $row->menu_order;
						$args[$n]->post_type = $row->post_type;
						$args[$n]->post_mime_type = $row->post_mime_type;
						$args[$n]->comment_count = $row->comment_count;
					}
				}

				//Search for wctweid tag (id->table)
				preg_match_all("/\[wcteid.?+eid=[\"]*([0-9]+)[\"].*id=[\"]*([0-9]+)[\"]*/",$row->post_content,$treffer);
				foreach ($treffer as $wert) {
					$t = "table".$wert[2];
					if ($$t == '' AND $wert[2] != '') {
						$tabl2 = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$wert."`;");
						$array=array(); foreach($tabl2 as $member=>$data) { $array[$member]=$data; }

						$settings = get_option('wuk_custom_tables');
						if ($settings['search_charset'] == "auto" OR $settings['search_charset'] == "") {
							preg_match("/CHARSET=(.*)/",$array['Create Table'],$treffer);

							if ($treffer[1] != '') { 
								$pos = strpos($treffer[1]," ");
								if ($pos === false) { $charset = $treffer[1]; }
								else { $charset = substr($treffer[1],0,$pos); }
							}
							else {
								$charset = "latin1";
							}
						}
						elseif ($settings['search_charset'] != '') {
							$charset = $settings['search_charset'];
						}

						$felder = explode(",",str_replace(array("8,2","','","\r","\n"),array("8.2","'.'","",""),$array['Create Table']));
						unset($feld2,$feld3,$feld4);
						$feld2[1]['i'] = 'id';
						$feld2[1]['d'] = 'filter';

						for ($i=2;$felder[$i] != '';$i++) {
							if (strpos ($felder[$i-1],"KEY") !== false) {
								//KEY Overjump
							}
							elseif (strpos ($felder[$i-1]," enum") !== false) {
								$feld3[$i]['i'] = preg_replace("/.*`(.*)`\s.*/","$1",$felder[$i-1]);
							}
							elseif (strpos ($felder[$i-1]," set") !== false) {
								$feld5[$i]['i'] = preg_replace("/.*`(.*)`\s.*/","$1",$felder[$i-1]);
							}
							elseif (strpos ($felder[$i-1]," text") !== false) {
								$feld2[$i]['i'] = preg_replace("/.*`(.*)`\s.*/","$1",$felder[$i-1]);
							}
							elseif (strpos ($felder[$i-1]," int(10)") !== false) {
								$feld4[$i]['i'] = preg_replace("/.*`(.*)`\s.*/","$1",$felder[$i-1]);
							}
							else {
								$feld2[$i]['i'] = preg_replace("/.*`(.*)`\s(.*\))\s.*/","$1",$felder[$i-1]);
							}
						}

						unset($searchfields,$searchfields2);
						$query = $_GET['s'];
						if (strstr($query," ")) { $qquery = explode(" ",$query); }
						else { $qquery = array('0'=>$query); }
						foreach ($qquery as $query) {
							$query2 = $query = mb_convert_encoding($query ,mb_detect_encoding($query),$charset);

							if (preg_match("/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{4})$/", $query2, $regs)) { $db_timestamp = mktime(1,1,1,$regs[2], $regs[1], $regs[3]); }
							elseif (preg_match("/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{2})$/", $query2, $regs)) { $db_timestamp = mktime(1,1,1,$regs[2], $regs[1], '20'.$regs[3]); }
							elseif (preg_match("/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/", $query2, $regs)) { $db_timestamp = mktime(1,1,1,$regs[1], $regs[2], $regs[3]); }
							elseif (preg_match("/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{2})$/", $query2, $regs)) { $db_timestamp = mktime(1,1,1,$regs[1], $regs[2], '20'.$regs[3]); }
							elseif (preg_match("/^([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})$/", $query2, $regs)) { $db_timestamp = mktime(1,1,1,$regs[1], $regs[2], $regs[3]); }
							elseif (preg_match("/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})$/", $query2, $regs)) { $db_timestamp = mktime(1,1,1,$regs[3], $regs[2], $regs[1]); }
							elseif (preg_match("/^([0-9]{1,2})\.([0-9]{1,2})\.$/", $query2, $regs)) { $db_timestamp = mktime(1,1,1,$regs[2], $regs[1], date("Y",time())); }
							else {	unset($db_timestamp); }

							if (is_array($feld2)) {
								foreach ($feld2 as $werd) {
									if ($werd['i'] != 'id') {
										if ($_GET['exact'] == '1') { $searchfields .= "OR LOWER(`".$werd['i']."`)='".mres(strtolower($query))."' "; }
										else { $searchfields .= "OR LOWER(`".$werd['i']."`) LIKE '%".mres(strtolower(str_replace(" ","_",$query)))."%' "; }
									}
								}
							}
							if (is_array($feld3)) {
								foreach ($feld3 as $werd) {
									if ($werd['i'] != 'status') { $searchfields .= "OR LOWER(`".$werd['i']."`)='".mres(strtolower($query))."' "; }
								}
							}
							if (is_array($feld5)) {
								foreach ($feld5 as $werd) {
									if ($werd['i'] != 'status') { $searchfields .= "OR FIND_IN_SET('".mres(strtolower($query))."',LOWER(`".$werd['i']."`))>0 "; }
								}
							}
							if (isset($db_timestamp)) {
								if (is_array($feld4)) {
									foreach ($feld4 as $werd) {
										$searchfields .= "OR `".$werd['i']."`='".$db_timestamp."' ";
									}
								}
								$_GET['wctsz'] = $db_timestamp;

								$mast = $wpdb->get_row("SELECT `searchaddon` FROM `".$wpdb->prefix."wct_list` WHERE id='".$wert."' LIMIT 1;");
								if ($mast->searchaddon != '') {
									$searchfields .= "OR (".str_replace("SEARCH",$db_timestamp,$mast->searchaddon).") ";
								}
							}
						}
						$searchfields = str_replace(array($wpdb->prefix."wct".$wert,",`id`"),array("",""),$searchfields);

						$abfrage = "SELECT `id` FROM `".$wpdb->prefix."wct".$wert."` WHERE (".substr($searchfields,3,strlen($searchfields)-3).") AND `status`='active' AND `id`='".$wert[1]."' LIMIT 1;";
						$qry = $wpdb->get_results($abfrage);
						if (count($qry) == '1') {
							$$t = '1';
							$lastID = $row->ID;

							$_GET['wctsf'] = "*";
							$_GET['wcts'] = $_GET['s'];

							$n = count($args);
							$args[$n]->ID = $row->ID;
							$args[$n]->post_author = $row->post_author;
							$args[$n]->post_date = $row->post_date;
							$args[$n]->post_date_gmt = $row->post_date_gmt;
							$args[$n]->post_content = $row->post_content;
							$args[$n]->post_title = $row->post_title;
							$args[$n]->post_excerpt = $row->post_excerpt;
							$args[$n]->post_status = $row->post_status;
							$args[$n]->comment_status = $row->comment_status;
							$args[$n]->ping_status = $row->ping_status;
							$args[$n]->post_password = $row->post_password;
							$args[$n]->post_name = $row->post_name;
							$args[$n]->to_ping = $row->to_ping;
							$args[$n]->pinged = $row->pinged;
							$args[$n]->post_modified = $row->post_modified; 
							$args[$n]->post_modified_gmt = $row->post_modified_gmt;
							$args[$n]->post_content_filtered = $row->post_content_filtered;
							$args[$n]->post_parent = $row->post_parent;
							$args[$n]->guid = $row->guid;
							$args[$n]->menu_order = $row->menu_order;
							$args[$n]->post_type = $row->post_type;
							$args[$n]->post_mime_type = $row->post_mime_type;
							$args[$n]->comment_count = $row->comment_count;
						}
						else {
							$$t = '0';
						}
					}
					elseif ($$t == '1' AND $lastID != $row->ID AND $wert[2] != '') {
						$_GET['wctsf'] = "*";
						$_GET['wcts'] = $_GET['s'];

						$n = count($args);
						$args[$n]->ID = $row->ID;
						$args[$n]->post_author = $row->post_author;
						$args[$n]->post_date = $row->post_date;
						$args[$n]->post_date_gmt = $row->post_date_gmt;
						$args[$n]->post_content = $row->post_content;
						$args[$n]->post_title = $row->post_title;
						$args[$n]->post_excerpt = $row->post_excerpt;
						$args[$n]->post_status = $row->post_status;
						$args[$n]->comment_status = $row->comment_status;
						$args[$n]->ping_status = $row->ping_status;
						$args[$n]->post_password = $row->post_password;
						$args[$n]->post_name = $row->post_name;
						$args[$n]->to_ping = $row->to_ping;
						$args[$n]->pinged = $row->pinged;

						$args[$n]->post_modified = $row->post_modified; 
						$args[$n]->post_modified_gmt = $row->post_modified_gmt;
						$args[$n]->post_content_filtered = $row->post_content_filtered;
						$args[$n]->post_parent = $row->post_parent;
						$args[$n]->guid = $row->guid;
						$args[$n]->menu_order = $row->menu_order;
						$args[$n]->post_type = $row->post_type;
						$args[$n]->post_mime_type = $row->post_mime_type;
						$args[$n]->comment_count = $row->comment_count;
					}
				}
				
				//Search for wctweid tag (table->id)
				preg_match_all("/\[wcteid.?+id=[\"]*([0-9]+)[\"].*eid=[\"]*([0-9]+)[\"]*/",$row->post_content,$treffer);
				foreach ($treffer[1] as $var => $wert) {
					$t = "table".$wert;
					$jeid = $treffer[2][$var];
					if ($$t == '') {
						$tabl2 = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$wert."`;");
						$array=array(); foreach($tabl2 as $member=>$data) { $array[$member]=$data; }

						$settings = get_option('wuk_custom_tables');
						if ($settings['search_charset'] == "auto" OR $settings['search_charset'] == "") {
							preg_match("/CHARSET=(.*)/",$array['Create Table'],$treffer);

							if ($treffer[1] != '') { 
								$pos = strpos($treffer[1]," ");
								if ($pos === false) { $charset = $treffer[1]; }
								else { $charset = substr($treffer[1],0,$pos); }
							}
							else {
								$charset = "latin1";
							}
						}
						elseif ($settings['search_charset'] != '') {
							$charset = $settings['search_charset'];
						}

						$felder = explode(",",str_replace(array("8,2","','","\r","\n"),array("8.2","'.'","",""),$array['Create Table']));
						unset($feld2,$feld3,$feld4);
						$feld2[1]['i'] = 'id';
						$feld2[1]['d'] = 'filter';

						for ($i=2;$felder[$i] != '';$i++) {
							if (strpos ($felder[$i-1],"KEY") !== false) {
								//KEY Overjump
							}
							elseif (strpos ($felder[$i-1]," enum") !== false) {
								$feld3[$i]['i'] = preg_replace("/.*`(.*)`\s.*/","$1",$felder[$i-1]);
							}
							elseif (strpos ($felder[$i-1]," set") !== false) {
								$feld5[$i]['i'] = preg_replace("/.*`(.*)`\s.*/","$1",$felder[$i-1]);
							}
							elseif (strpos ($felder[$i-1]," text") !== false) {
								$feld2[$i]['i'] = preg_replace("/.*`(.*)`\s.*/","$1",$felder[$i-1]);
							}
							elseif (strpos ($felder[$i-1]," int(10)") !== false) {
								$feld4[$i]['i'] = preg_replace("/.*`(.*)`\s.*/","$1",$felder[$i-1]);
							}
							else {
								$feld2[$i]['i'] = preg_replace("/.*`(.*)`\s(.*\))\s.*/","$1",$felder[$i-1]);
							}
						}

						unset($searchfields,$searchfields2);
						$query = $_GET['s'];
						if (strstr($query," ")) { $qquery = explode(" ",$query); }
						else { $qquery = array('0'=>$query); }
						foreach ($qquery as $query) {
							$query2 = $query = mb_convert_encoding($query ,mb_detect_encoding($query),$charset);

							if (preg_match("/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{4})$/", $query2, $regs)) { $db_timestamp = mktime(1,1,1,$regs[2], $regs[1], $regs[3]); }
							elseif (preg_match("/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{2})$/", $query2, $regs)) { $db_timestamp = mktime(1,1,1,$regs[2], $regs[1], '20'.$regs[3]); }
							elseif (preg_match("/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/", $query2, $regs)) { $db_timestamp = mktime(1,1,1,$regs[1], $regs[2], $regs[3]); }
							elseif (preg_match("/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{2})$/", $query2, $regs)) { $db_timestamp = mktime(1,1,1,$regs[1], $regs[2], '20'.$regs[3]); }
							elseif (preg_match("/^([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})$/", $query2, $regs)) { $db_timestamp = mktime(1,1,1,$regs[1], $regs[2], $regs[3]); }
							elseif (preg_match("/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})$/", $query2, $regs)) { $db_timestamp = mktime(1,1,1,$regs[3], $regs[2], $regs[1]); }
							elseif (preg_match("/^([0-9]{1,2})\.([0-9]{1,2})\.$/", $query2, $regs)) { $db_timestamp = mktime(1,1,1,$regs[2], $regs[1], date("Y",time())); }
							else {	unset($db_timestamp); }

							if (is_array($feld2)) {
								foreach ($feld2 as $werd) {
									if ($werd['i'] != 'id') {
										if ($_GET['exact'] == '1') { $searchfields .= "OR LOWER(`".$werd['i']."`)='".mres(strtolower($query))."' "; }
										else { $searchfields .= "OR LOWER(`".$werd['i']."`) LIKE '%".mres(strtolower(str_replace(" ","_",$query)))."%' "; }
									}
								}
							}
							if (is_array($feld3)) {
								foreach ($feld3 as $werd) {
									if ($werd['i'] != 'status') { $searchfields .= "OR LOWER(`".$werd['i']."`)='".mres(strtolower($query))."' "; }
								}
							}
							if (is_array($feld5)) {
								foreach ($feld5 as $werd) {
									if ($werd['i'] != 'status') { $searchfields .= "OR FIND_IN_SET('".mres(strtolower($query))."',LOWER(`".$werd['i']."`))>0 "; }
								}
							}
							if (isset($db_timestamp)) {
								if (is_array($feld4)) {
									foreach ($feld4 as $werd) {
										$searchfields .= "OR `".$werd['i']."`='".$db_timestamp."' ";
									}
								}
								$_GET['wctsz'] = $db_timestamp;

								$mast = $wpdb->get_row("SELECT `searchaddon` FROM `".$wpdb->prefix."wct_list` WHERE id='".$wert."' LIMIT 1;");
								if ($mast->searchaddon != '') {
									$searchfields .= "OR (".str_replace("SEARCH",$db_timestamp,$mast->searchaddon).") ";
								}
							}
						}
						$searchfields = str_replace(array($wpdb->prefix."wct".$wert,",`id`"),array("",""),$searchfields);

						$abfrage = "SELECT `id` FROM `".$wpdb->prefix."wct".$wert."` WHERE (".substr($searchfields,3,strlen($searchfields)-3).") AND `status`='active' AND `id`='".$jeid."' LIMIT 1;";
						$qry = $wpdb->get_results($abfrage);
						if (count($qry) == '1') {
							$$t = '1';
							$lastID = $row->ID;

							$_GET['wctsf'] = "*";
							$_GET['wcts'] = $_GET['s'];

							$n = count($args);
							$args[$n]->ID = $row->ID;
							$args[$n]->post_author = $row->post_author;
							$args[$n]->post_date = $row->post_date;
							$args[$n]->post_date_gmt = $row->post_date_gmt;
							$args[$n]->post_content = $row->post_content;
							$args[$n]->post_title = $row->post_title;
							$args[$n]->post_excerpt = $row->post_excerpt;
							$args[$n]->post_status = $row->post_status;
							$args[$n]->comment_status = $row->comment_status;
							$args[$n]->ping_status = $row->ping_status;
							$args[$n]->post_password = $row->post_password;
							$args[$n]->post_name = $row->post_name;
							$args[$n]->to_ping = $row->to_ping;
							$args[$n]->pinged = $row->pinged;
							$args[$n]->post_modified = $row->post_modified; 
							$args[$n]->post_modified_gmt = $row->post_modified_gmt;
							$args[$n]->post_content_filtered = $row->post_content_filtered;
							$args[$n]->post_parent = $row->post_parent;
							$args[$n]->guid = $row->guid;
							$args[$n]->menu_order = $row->menu_order;
							$args[$n]->post_type = $row->post_type;
							$args[$n]->post_mime_type = $row->post_mime_type;
							$args[$n]->comment_count = $row->comment_count;
						}
						else {
							$$t = '0';
						}
					}
					elseif ($$t == '1' AND $lastID != $row->ID) {
						$_GET['wctsf'] = "*";
						$_GET['wcts'] = $_GET['s'];

						$n = count($args);
						$args[$n]->ID = $row->ID;
						$args[$n]->post_author = $row->post_author;
						$args[$n]->post_date = $row->post_date;
						$args[$n]->post_date_gmt = $row->post_date_gmt;
						$args[$n]->post_content = $row->post_content;
						$args[$n]->post_title = $row->post_title;
						$args[$n]->post_excerpt = $row->post_excerpt;
						$args[$n]->post_status = $row->post_status;
						$args[$n]->comment_status = $row->comment_status;
						$args[$n]->ping_status = $row->ping_status;
						$args[$n]->post_password = $row->post_password;
						$args[$n]->post_name = $row->post_name;
						$args[$n]->to_ping = $row->to_ping;
						$args[$n]->pinged = $row->pinged;

						$args[$n]->post_modified = $row->post_modified; 
						$args[$n]->post_modified_gmt = $row->post_modified_gmt;
						$args[$n]->post_content_filtered = $row->post_content_filtered;
						$args[$n]->post_parent = $row->post_parent;
						$args[$n]->guid = $row->guid;
						$args[$n]->menu_order = $row->menu_order;
						$args[$n]->post_type = $row->post_type;
						$args[$n]->post_mime_type = $row->post_mime_type;
						$args[$n]->comment_count = $row->comment_count;
					}
				}

				//Search for wctweid tag (table->id)
				preg_match_all("/\[wcteid.?+eid=[\"]*([0-9]+)[\"].*id=[\"]*([0-9]+)[\"]*/",$row->post_content,$treffer);
				foreach ($treffer[2] as $var => $wert) {
					$t = "table".$wert;
					$jeid = $treffer[1][$var];
					if ($$t == '') {
						$tabl2 = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$wert."`;");
						$array=array(); foreach($tabl2 as $member=>$data) { $array[$member]=$data; }

						$settings = get_option('wuk_custom_tables');
						if ($settings['search_charset'] == "auto" OR $settings['search_charset'] == "") {
							preg_match("/CHARSET=(.*)/",$array['Create Table'],$treffer);

							if ($treffer[1] != '') { 
								$pos = strpos($treffer[1]," ");
								if ($pos === false) { $charset = $treffer[1]; }
								else { $charset = substr($treffer[1],0,$pos); }
							}
							else {
								$charset = "latin1";
							}
						}
						elseif ($settings['search_charset'] != '') {
							$charset = $settings['search_charset'];
						}

						$felder = explode(",",str_replace(array("8,2","','","\r","\n"),array("8.2","'.'","",""),$array['Create Table']));
						unset($feld2,$feld3,$feld4);
						$feld2[1]['i'] = 'id';
						$feld2[1]['d'] = 'filter';

						for ($i=2;$felder[$i] != '';$i++) {
							if (strpos ($felder[$i-1],"KEY") !== false) {
								//KEY Overjump
							}
							elseif (strpos ($felder[$i-1]," enum") !== false) {
								$feld3[$i]['i'] = preg_replace("/.*`(.*)`\s.*/","$1",$felder[$i-1]);
							}
							elseif (strpos ($felder[$i-1]," set") !== false) {
								$feld5[$i]['i'] = preg_replace("/.*`(.*)`\s.*/","$1",$felder[$i-1]);
							}
							elseif (strpos ($felder[$i-1]," text") !== false) {
								$feld2[$i]['i'] = preg_replace("/.*`(.*)`\s.*/","$1",$felder[$i-1]);
							}
							elseif (strpos ($felder[$i-1]," int(10)") !== false) {
								$feld4[$i]['i'] = preg_replace("/.*`(.*)`\s.*/","$1",$felder[$i-1]);
							}
							else {
								$feld2[$i]['i'] = preg_replace("/.*`(.*)`\s(.*\))\s.*/","$1",$felder[$i-1]);
							}
						}

						unset($searchfields,$searchfields2);
						$query = $_GET['s'];
						if (strstr($query," ")) { $qquery = explode(" ",$query); }
						else { $qquery = array('0'=>$query); }
						foreach ($qquery as $query) {
							$query2 = $query = mb_convert_encoding($query ,mb_detect_encoding($query),$charset);

							if (preg_match("/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{4})$/", $query2, $regs)) { $db_timestamp = mktime(1,1,1,$regs[2], $regs[1], $regs[3]); }
							elseif (preg_match("/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{2})$/", $query2, $regs)) { $db_timestamp = mktime(1,1,1,$regs[2], $regs[1], '20'.$regs[3]); }
							elseif (preg_match("/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/", $query2, $regs)) { $db_timestamp = mktime(1,1,1,$regs[1], $regs[2], $regs[3]); }
							elseif (preg_match("/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{2})$/", $query2, $regs)) { $db_timestamp = mktime(1,1,1,$regs[1], $regs[2], '20'.$regs[3]); }
							elseif (preg_match("/^([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})$/", $query2, $regs)) { $db_timestamp = mktime(1,1,1,$regs[1], $regs[2], $regs[3]); }
							elseif (preg_match("/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})$/", $query2, $regs)) { $db_timestamp = mktime(1,1,1,$regs[3], $regs[2], $regs[1]); }
							elseif (preg_match("/^([0-9]{1,2})\.([0-9]{1,2})\.$/", $query2, $regs)) { $db_timestamp = mktime(1,1,1,$regs[2], $regs[1], date("Y",time())); }
							else {	unset($db_timestamp); }

							if (is_array($feld2)) {
								foreach ($feld2 as $werd) {
									if ($werd['i'] != 'id') {
										if ($_GET['exact'] == '1') { $searchfields .= "OR LOWER(`".$werd['i']."`)='".mres(strtolower($query))."' "; }
										else { $searchfields .= "OR LOWER(`".$werd['i']."`) LIKE '%".mres(strtolower(str_replace(" ","_",$query)))."%' "; }
									}
								}
							}
							if (is_array($feld3)) {
								foreach ($feld3 as $werd) {
									if ($werd['i'] != 'status') { $searchfields .= "OR LOWER(`".$werd['i']."`)='".mres(strtolower($query))."' "; }
								}
							}
							if (is_array($feld5)) {
								foreach ($feld5 as $werd) {
									if ($werd['i'] != 'status') { $searchfields .= "OR FIND_IN_SET('".mres(strtolower($query))."',LOWER(`".$werd['i']."`))>0 "; }
								}
							}
							if (isset($db_timestamp)) {
								if (is_array($feld4)) {
									foreach ($feld4 as $werd) {
										$searchfields .= "OR `".$werd['i']."`='".$db_timestamp."' ";
									}
								}
								$_GET['wctsz'] = $db_timestamp;

								$mast = $wpdb->get_row("SELECT `searchaddon` FROM `".$wpdb->prefix."wct_list` WHERE id='".$wert."' LIMIT 1;");
								if ($mast->searchaddon != '') {
									$searchfields .= "OR (".str_replace("SEARCH",$db_timestamp,$mast->searchaddon).") ";
								}
							}
						}
						$searchfields = str_replace(array($wpdb->prefix."wct".$wert,",`id`"),array("",""),$searchfields);

						$abfrage = "SELECT `id` FROM `".$wpdb->prefix."wct".$wert."` WHERE (".substr($searchfields,3,strlen($searchfields)-3).") AND `status`='active' AND `id`='".$jeid."' LIMIT 1;";
						$qry = $wpdb->get_results($abfrage);
						if (count($qry) == '1') {
							$$t = '1';
							$lastID = $row->ID;

							$_GET['wctsf'] = "*";
							$_GET['wcts'] = $_GET['s'];

							$n = count($args);
							$args[$n]->ID = $row->ID;
							$args[$n]->post_author = $row->post_author;
							$args[$n]->post_date = $row->post_date;
							$args[$n]->post_date_gmt = $row->post_date_gmt;
							$args[$n]->post_content = $row->post_content;
							$args[$n]->post_title = $row->post_title;
							$args[$n]->post_excerpt = $row->post_excerpt;
							$args[$n]->post_status = $row->post_status;
							$args[$n]->comment_status = $row->comment_status;
							$args[$n]->ping_status = $row->ping_status;
							$args[$n]->post_password = $row->post_password;
							$args[$n]->post_name = $row->post_name;
							$args[$n]->to_ping = $row->to_ping;
							$args[$n]->pinged = $row->pinged;
							$args[$n]->post_modified = $row->post_modified; 
							$args[$n]->post_modified_gmt = $row->post_modified_gmt;
							$args[$n]->post_content_filtered = $row->post_content_filtered;
							$args[$n]->post_parent = $row->post_parent;
							$args[$n]->guid = $row->guid;
							$args[$n]->menu_order = $row->menu_order;
							$args[$n]->post_type = $row->post_type;
							$args[$n]->post_mime_type = $row->post_mime_type;
							$args[$n]->comment_count = $row->comment_count;
						}
						else {
							$$t = '0';
						}
					}
					elseif ($$t == '1' AND $lastID != $row->ID) {
						$_GET['wctsf'] = "*";
						$_GET['wcts'] = $_GET['s'];

						$n = count($args);
						$args[$n]->ID = $row->ID;
						$args[$n]->post_author = $row->post_author;
						$args[$n]->post_date = $row->post_date;
						$args[$n]->post_date_gmt = $row->post_date_gmt;
						$args[$n]->post_content = $row->post_content;
						$args[$n]->post_title = $row->post_title;
						$args[$n]->post_excerpt = $row->post_excerpt;
						$args[$n]->post_status = $row->post_status;
						$args[$n]->comment_status = $row->comment_status;
						$args[$n]->ping_status = $row->ping_status;
						$args[$n]->post_password = $row->post_password;
						$args[$n]->post_name = $row->post_name;
						$args[$n]->to_ping = $row->to_ping;
						$args[$n]->pinged = $row->pinged;

						$args[$n]->post_modified = $row->post_modified; 
						$args[$n]->post_modified_gmt = $row->post_modified_gmt;
						$args[$n]->post_content_filtered = $row->post_content_filtered;
						$args[$n]->post_parent = $row->post_parent;
						$args[$n]->guid = $row->guid;
						$args[$n]->menu_order = $row->menu_order;
						$args[$n]->post_type = $row->post_type;
						$args[$n]->post_mime_type = $row->post_mime_type;
						$args[$n]->comment_count = $row->comment_count;
					}
				}

			}
		}
		$settings = get_option('wuk_custom_tables');
		wp_cache_set( 'wct_search_'.$sssquery, $args, 'wct', $settings['wct_cachetime']);
	}
	else {
		$args = $args_cached;
	}
	return $args;
}

$current = get_option('active_plugins');
if (count($current)==0 AND WP_ALLOW_MULTISITE == true) {
	$current = get_site_option('active_sitewide_plugins');
}

if (in_array( 'custom-tables/custom-tables-search.php', $current) OR array_key_exists( 'custom-tables/custom-tables-search.php', $current) AND (!in_array( 'custom-tables/custom-tables.php', $current) OR $settings['form_serial'] == '')) {
	if (WP_ALLOW_MULTISITE == true) {
		foreach ($current as $var => $wert) {
			if ($var != "custom-tables/custom-tables-search.php" AND $wert != "custom-tables/custom-tables-search.php") { $newplugs[$var] = $wert;  }
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

if ($_GET['s'] != '') {
	add_filter('posts_results','wct_search_addon');
	add_filter('the_excerpt', 'do_shortcode', 11);
	add_filter('the_content', 'do_shortcode', 12);
}


?>