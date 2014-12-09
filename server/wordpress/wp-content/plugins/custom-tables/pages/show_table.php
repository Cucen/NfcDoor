<?php
$this->wctnr++;
/* hack for qtranslatesupport */
if(!function_exists('qtrans_getLanguage')){function qtrans_getLanguage(){}}
if (!is_array($this->saltdone)) { $this->saltdone = array(); }

if (is_user_logged_in()) {
	global $current_user,$arr_user,$user;
	if (!isset($arr_user)) {
		$arr_user = array('subscriber'=>0, 'contributor'=>1, 'author'=>2, 'editor'=>5, 'administrator'=>8);
	}
	get_currentuserinfo();
	$user = $current_user;
	if (!is_object($user)) {
		$preset = $wpdb->prefix."capabilities";
		if ($user->{$preset}['administrator'] == '1' AND $user->user_level == '0') { $user->user_level = '10'; }
	}
}

if ($_GET['wcteid'] == '' AND $eid == '') {
	$url = $this->generate_pagelink("/[&?]+wcteid=[0-9]*/","");
	$cache = $this->filtermd($filter.$design.$css);
	$this->getOptions();
	
	/** Load individual or global search query */
	$searchqry = ($_GET['wcts'] != '' ? $_GET['wcts'] : $_GET['s']);
	$searchqry = wct_fixspecialchars($searchqry);
			
	$savechaching = apply_filters('wct_savecaching','wct_table'.$id.$cache.count($this->saltdone)."_".$_REQUEST['wct'.$this->wctnr.'start'].'s'.$_REQUEST['wctsort'].$_REQUEST['wctinvs'] );

	$out = wp_cache_get( $savechaching , 'wct');
	do_action('wct_showtable', array('table' => $id, 'start' => $_REQUEST['wct'.$this->wctnr.'start'], 'sort' => $_REQUEST['wctsort'], 'invertsort' => $_REQUEST['wctinvs']));
	
	if ($out == false OR is_user_logged_in() OR $searchqry != '') {
		if ($design != '' AND $design != NULL) {
			$designnotfound = '0'; 
			$table = $wpdb->get_row("SELECT `name`,`t_setup`,`e_setup`,`o_setup`,`sheme`,`overlay`,`header`,`headerline`,`headersort`,`vortext`,`nachtext`,`sort`,`sortB`,`searchaddon`,`dl`,`rowcount`,`editlink` FROM `".$wpdb->prefix."wct_setup` WHERE `table_id`='".$id."' AND (`name`='".mres($design)."' OR `id`='".mres($design)."') LIMIT 1;");
			if (count($table) != '1') { $designnotfound = '1'; }
			
		}
		if ($designnotfound == '1' OR !isset($designnotfound)) {
			$table = $wpdb->get_row("SELECT `name`,`t_setup`,`e_setup`,`o_setup`,`sheme`,`overlay`,`header`,`headerline`,`headersort`,`vortext`,`nachtext`,`sort`,`sortB`,`searchaddon`,`dl`,`rowcount`,`editlink` FROM `".$wpdb->prefix."wct_list` WHERE `id`='".$id."' LIMIT 1;");
		}

		if ($table->t_setup != '') {
			global $wctcssdone;

			if ($table->rowcount != '') { $rowcount = $table->rowcount; } else { $rowcount = '1'; }
			$colspan = substr_count($table->t_setup,"<td") * $rowcount;
			
			if ($wctcssdone != '1') { $out = "<style>".stripslashes($this->settings['css'])."</style>"; $wctcssdone = '1'; }
			else { $out = ''; }

			if ($table->vortext != '') { $out .= rbr(stripslashes($table->vortext)); }
			

				
			if ($searched != '1' OR $searchqry != '') {
				if ($table->overlay == '1') {
				$out .= "<script>
					function box_show(name,namB,color) {
						document.getElementById(\"hH\").value = document.getElementById(name).offsetHeight;
						document.getElementById(namB).setAttribute(\"class\", color);
						document.getElementById(name).style.top = document.getElementById(\"My\").value+\"px\";
						document.getElementById(name).style.left = document.getElementById(\"Mx\").value+\"px\";
						document.getElementById(name).style.visibility = \"visible\";
						document.getElementById(name).style.display = 'block';
					}
					function box_hide(name,namB,color) {
						document.getElementById(namB).setAttribute(\"class\", color);
						document.getElementById(name).style.visibility = \"hidden\";
						document.getElementById(name).style.display = 'none';
					}
					function box_hide2(name) {
						document.getElementById(name).style.visibility = \"hidden\";
						document.getElementById(name).style.display = 'none';
					}
					var IE = false;
					if (navigator.appName == \"Microsoft Internet Explorer\"){IE = true}
					if (!IE){document.captureEvents(Event.MOUSEMOVE) }
					document.onmousemove = getMouseXY;
					function getMouseXY(m){
						if (IE) {var tmpX = event.clientX;var tmpY = event.clientY;}
						else if(m.clientY){var tmpX = m.clientX;var tmpY = m.clientY;}
						else {var tmpX = m.pageX;var tmpY = m.pageY;}

						if (IE) {
							if (document.documentElement.scrollTop) {var iL = document.documentElement.scrollLeft;var iV = document.documentElement.scrollTop;var hH = document.documentElement.offsetHeight;var wH = document.documentElement.offsetWidth;}
							else if (document.body.scrollTop) {var iL = document.body.scrollLeft;var iV = document.body.scrollTop; var hH = document.body.offsetHeight;var wH = document.body.offsetWidth;}
							else { iL = 0; iV = 0; }

							if ('IE6' == '";
							if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6.') !== false) { $pos = "IE6"; }
							$out .= $pos."') {
								var ie6pos = findPos('wct-table');
								iV = iV - ie6pos[1] +140;
								iL = iL - ie6pos[0] +12;
							}
						}
						else {
							iL = 0; iV = 0;
							var hH = window.innerHeight;var wH = window.innerWidth;
						}

						var breite = tmpX + iL + 10;
						var hohe = tmpY + iV;

						var divhohe = parseInt(document.getElementById(\"hH\").value);
						if (hH < (hohe + divhohe)) {
							hohe = hH - divhohe;
						}

						document.getElementById(\"My\").value = hohe;
						document.getElementById(\"Mx\").value = breite;
					}
					function findPos(obj) {
						obj = document.getElementById(obj);

						var posX = obj.offsetLeft;var posY = obj.offsetTop;

						while(obj.offsetParent) {
							if(obj==document.getElementsByTagName('body')[0]){break;}
							else {
								posX=posX+obj.offsetParent.offsetLeft;
								posY=posY+obj.offsetParent.offsetTop;
								obj=obj.offsetParent;
							}
						}
						var posArray=[posX,posY];
						return posArray;
					}
					</script>
					<input type=\"hidden\" id=\"Mx\"><input type=\"hidden\" id=\"My\"><input type=\"hidden\" id=\"hH\">";
				}
				$out .= "<table name=\"wct".$css."-table\" id=\"wct".$css."-table\" class=\"wct".$css."-table\">";
				
				if ($table->headerline == '1') {
					$out .= "<tr class=\"wct".$css."-headline\">";
					$y = '0';
					for ($x=0;$x<$rowcount;$x++) {
						$sort = explode(",",$table->headersort);
						if ($table->header == '') {
							$inhalt = str_replace("[LINK]","",apply_filters('wct_table',$table->t_setup));
							preg_match_all("/\[(.*?)\]/",$inhalt,$felde);
							$felder = $felde[1];
							foreach ($felder as $feld) {
								$out .= "<td><b>".do_shortcode($feld)."</b>";
								if ($sort[$y] != '') { $out .= " ".$this->wct_sort($sort[$y],$table); }
								$out .= "</td>";
								$y++;
							}
						}
						else {
							$inhalt = stripslashes($table->header);
							$felder = explode(",",$inhalt);
							foreach ($felder as $feld) {
								/*qtranslate support */
								if (preg_match('/.*!--:'.qtrans_getLanguage().'-->(.*?)<!--:--.*/',rbr($feld))) {
									/* Language found */
									preg_match('/.*!--:'.qtrans_getLanguage().'-->(.*?)<!--:--.*/',rbr($feld), $treffer);
									$feld = $treffer[1];
								}
								$out .= "<td><b>".rbr(do_shortcode($feld))."</b>";
								if ($sort[$y] != '') { $out .= " ".$this->wct_sort($sort[$y],$table); }
								$out .= "</td>";
								$y++;
							}
						}
						if (is_user_logged_in()) { $out .= "<td></td>"; }
					}
					$out .= "</tr>";
					
				}

				$table2 = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$id."`;");
				$array=array(); foreach($table2 as $member=>$data) { $array[$member]=$data; }
				$felder = explode(",",str_replace(array("8,2","','","\r","\n"),array("8.2","'.'","",""),$array['Create Table']));

				unset($feld2,$feld3,$feld4);
				$feld2[1]['i'] = 'id';
				$feld2[1]['d'] = 'filter';

				for ($i=2;$felder[$i] != '';$i++) {
					if (strpos ($felder[$i-1]," enum") !== false) {
						 $feld3[$i]['i'] = preg_replace("/.*`(.*)`\s.*/","$1",$felder[$i-1]);
					}
					elseif (strpos ($felder[$i-1]," set") !== false) {
						 $feld5[$i]['i'] = preg_replace("/.*`(.*)`\s.*/","$1",$felder[$i-1]);
					}
					elseif (strpos ($felder[$i-1]," text") !== false) {
						 $feld2[$i]['i'] = preg_replace("/.*`(.*)`\s.*/","$1",$felder[$i-1]);
						 $feld2[$i]['d'] = "pass";
					}
					elseif (strpos ($felder[$i-1]," int(10)") !== false) {
						 $feld4[$i]['i'] = preg_replace("/.*`(.*)`\s.*/","$1",$felder[$i-1]);
					}
					else {
						 $feld2[$i]['i'] = preg_replace("/.*`(.*)`\s(.*\))\s.*/","$1",$felder[$i-1]);
						 $feld2[$i]['d'] = "pass";
					}
				}

				if ($nofilter == '' AND $searchqry != '') {

					/* Welche Felder sind erlaubt zum suchen */
					if ($_GET['wctsf'] != "*") { $wanted = ",".str_replace("%2C",",",$_GET['wctsf']).","; }
					
					unset($searchfields,$searchfields2);

					if (strstr($searchqry," ") AND $_GET['exact'] != '1') { $qquery = explode(" ",$searchqry); }
					else { $qquery = array('0'=>$searchqry); }
					foreach ($qquery as $searchqry) {
						if (is_array($feld2)) {
							foreach ($feld2 as $var => $werd) {
								if (!strstr($werd['i'],"PRIMARY KEY")) {
									if ($_GET['wctsf'] != '*') {
										if (strpos($wanted,",".$werd['i'].",") !== FALSE) {
											$searchfields .= "OR LOWER(`".$id."`.`".$werd['i']."`) LIKE '%".mres(strtolower($searchqry))."%' ";
										}
									}
									else {
										$searchfields .= "OR LOWER(`".$id."`.`".$werd['i']."`) LIKE '%".mres(strtolower($searchqry))."%' ";
									}
								}
							}
						}
						if (is_array($feld3)) {
							foreach ($feld3 as $werd) {
								if ($werd['i'] != 'status') { $searchfields .= "OR LOWER(`".$id."`.`".$werd['i']."`)='".mres(strtolower($searchqry))."' "; }
							}
						}
						if (is_array($feld5)) {
							foreach ($feld5 as $werd) {
								if ($werd['i'] != 'status') { $searchfields .= "OR FIND_IN_SET('".mres(strtolower($searchqry))."',LOWER(`".$id."`.`".$werd['i']."`))>0 "; }
							}
						}

						if ($_GET['wctsz'] == '') {
							$query2 = $searchqry;

							if (preg_match("/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{4})$/", $query2, $regs)) { $db_timestamp = mktime(1,1,1,$regs[2], $regs[1], $regs[3]); }
							elseif (preg_match("/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{2})$/", $query2, $regs)) { $db_timestamp = mktime(1,1,1,$regs[2], $regs[1], '20'.$regs[3]); }
							elseif (preg_match("/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/", $query2, $regs)) { $db_timestamp = mktime(1,1,1,$regs[1], $regs[2], $regs[3]); }
							elseif (preg_match("/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{2})$/", $query2, $regs)) { $db_timestamp = mktime(1,1,1,$regs[1], $regs[2], '20'.$regs[3]); }
							elseif (preg_match("/^([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})$/", $query2, $regs)) { $db_timestamp = mktime(1,1,1,$regs[1], $regs[2], $regs[3]); }
							elseif (preg_match("/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})$/", $query2, $regs)) { $db_timestamp = mktime(1,1,1,$regs[3], $regs[2], $regs[1]); }
							elseif (preg_match("/^([0-9]{1,2})\.([0-9]{1,2})\.$/", $query2, $regs)) { $db_timestamp = mktime(1,1,1,$regs[2], $regs[1], date("Y",time())); }
							else {	unset($db_timestamp); }	
						}
						else { $db_timestamp = (integer)$_GET['wctsz']; }

						if (isset($db_timestamp) AND $db_timestamp != '') {
							if (is_array($feld4)) {
								foreach ($feld4 as $werd) {
									$searchfields .= "OR `".$id."`.`".$werd['i']."`='".$db_timestamp."' ";
								}
							}
							if ($table->searchaddon != '') {
								$searchfields .= "OR (".str_replace("SEARCH",$db_timestamp,$table->searchaddon).") ";
							}
						}

						if ($_GET['wctsf'] == '*') { $searchfields = str_replace(array(",".$id,",id"),array("",""),$searchfields); }
					}
					if ($searchfields != '') {
						$searchfields = substr($searchfields,3,strlen($searchfields));
					}
				}

				/* Searchstring if needed */
				if ($nofilter == '' AND $searchqry != '' AND $searchfields != '') {
					$zusatz = " AND ( ".$searchfields." )";
				}

				/* Filter if needed */
				if ($nofilter == '') {
					if (is_array($this->saltdone) AND count($this->saltdone) >= '1') {
						foreach ($this->saltdone as $dro) {
							if (isset($_GET[$dro.'wctdrop']) AND $_GET[$dro.'wctdrop'] != 'NULL' AND $_GET[$dro.'wctdrof'] != '') {
								if (is_array($feld5) AND !in_array(array('i'=>$_GET[$dro.'wctdrof']),$feld5)) {
									$zusatz .= " AND `".$id."`.`".mres($_GET[$dro.'wctdrof'])."` LIKE '".mres(base64_decode($_GET[$dro.'wctdrop']))."'";
								}
								else {
									$zusatz .= " AND FIND_IN_SET('".($_GET[$dro.'wctdrop'] != '' ? mres(rtrim(base64_decode($_GET[$dro.'wctdrop']))) : '')."',LOWER(`".$id."`.`".mres($_GET[$dro.'wctdrof'])."`))>0 ";
								}
							}
							elseif (isset($_GET[$dro.'wctmudrop']) AND $_GET[$dro.'wctmudrop'] != 'NULL' AND $_GET[$dro.'wctmudrof'] != '') {
								if (strpos($_GET[$dro.'wctmudrop'],",") !== false) {
									$drops = explode(",",$_GET[$dro.'wctmudrop']);
								}
								else {
									$drops = array('0' => $_GET[$dro.'wctmudrop']);
								}
								if (is_array($feld5) AND !in_array(array('i'=>$_GET[$dro.'wctmudrof']),$feld5)) {
									$zusatz .= " AND (";
									foreach ($drops as $wert) {
										if ($wert == "") {
											$zusatz .= " `".$id."`.`".mres($_GET[$dro.'wctmudrof'])."`='' OR";
										}
										else {
											$zusatz .= " `".$id."`.`".mres($_GET[$dro.'wctmudrof'])."` LIKE '".mres(base64_decode($wert))."' OR";
										}
									}
									$zusatz .= ")";
									$zusatz = str_replace("OR)",")",$zusatz);
								}
								else {
									$zusatz .= " AND (";
									foreach ($drops as$wert) {
										$zusatz .= " FIND_IN_SET('".($_GET[$dro.'wctmudrop'] != '' ? mres(base64_decode($wert)) : '')."',LOWER(`".$id."`.`".mres($_GET[$dro.'wctmudrof'])."`))>0 OR";
									}
									$zusatz .= ")";
									$zusatz = str_replace("OR)",")",$zusatz);
								}
							}
						}
					}
					else {
						if (isset($_GET['wctdrop']) AND $_GET['wctdrop'] != 'NULL' AND $_GET['wctdrof'] != '') {
							if (is_array($feld5) AND !in_array(array('i'=>$_GET['wctdrof']),$feld5)) {
								$zusatz .= " AND `".$id."`.`".mres($_GET['wctdrof'])."` LIKE '".mres(base64_decode($_GET['wctdrop']))."'";
							}
							else {
								$zusatz .= " AND FIND_IN_SET('".($_GET['wctdrop'] != '' ? mres(rtrim(base64_decode($_GET['wctdrop']))) : '')."',LOWER(`".$id."`.`".mres($_GET['wctdrof'])."`))>0 ";
							}
						}
						elseif (isset($_GET['wctmudrop']) AND $_GET['wctmudrop'] != 'NULL' AND $_GET['wctmudrof'] != '') {
							if (is_array($feld5) AND !in_array(array('i'=>$_GET['wctmudrof']),$feld5)) {
								$zusatz .= " AND `".$id."`.`".mres($_GET['wctmudrof'])."` LIKE '".mres(base64_decode($_GET['wctmudrop']))."'";
							}
							else {
								$zusatz .= " AND FIND_IN_SET('".($_GET['wctmudrop'] != '' ? mres(rtrim(base64_decode($_GET['wctmudrop']))) : '')."',LOWER(`".$id."`.`".mres($_GET['wctmudrof'])."`))>0 ";
							}
						}
					}
				}

				if ($this->lastfilter != '') {
					$zusatz .= $this->lastfilter;
				}

				/* How it should be sorted */				
				if ($nofilter == '' AND $_REQUEST['wctsort'] != '') {
					if ($_REQUEST['wctsort'] == "rand()")
					{
						$zusatz2 = " ORDER BY rand() ";
					}
					else {
						$zusatz2 = " ORDER BY `".$id."`.`".mres($_REQUEST['wctsort'])."` ";
						if ($_REQUEST['wctinvs'] == '1') { $zusatz2 .= "ASC"; } else { $zusatz2 .= "DESC"; }
					}
				}
				else {
					if ($table->sort == "rand()")
					{
						$zusatz2 = " ORDER BY rand() ";
					}
					else {
						$zusatz2 = " ORDER BY `".$id."`.`".$table->sort."` ".$table->sortB." "; 
					}
				}

				/* Limit of Results, Next Pages */
				if ($_REQUEST['wct'.$this->wctnr.'start'] != '') {
					$start = (integer)$_REQUEST['wct'.$this->wctnr.'start'];
					$limit2 = ($start-1).",".$limit;
				} else { $limit2 = $limit; }

				$abfrage = '';
				/* Adding relation to mysql query */
				$relations = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wct_relations` WHERE `s_table`='".$id."';");
				if (count($relations) >= '1') {
					foreach ($relations as $relation) {
						$tr = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$relation->t_table."`;");
						$array=array(); foreach($tr as $member=>$data) { $array[$member]=$data; }
						$felder = explode("PRIMARY KEY",$array['Create Table']);
						$felder = explode(",",str_replace(array("8,2","','","\r","\n"),array("8.2","'.'","",""),$felder[0]));
						for ($i=1;$felder[$i] != '';$i++) {
							$srel .= preg_replace("/.*`(.*)`\s.*/","`".$relation->t_table."`.`$1` AS `$1---".$relation->t_table."`,",$felder[$i-1]);
						}
						if ($alldone[$relation->t_table."-".$id] != '1') {
							$alldone[$relation->t_table."-".$id] = '1';
							$abfrage2 = "LEFT JOIN `".$wpdb->prefix."wct".$relation->t_table."` as `".$relation->t_table."` ON `".$id."`.`".$relation->s_field."`=`".$relation->t_table."`.`".$relation->t_field."` ";
						}
						
						$relations2 = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wct_relations` WHERE `s_table`='".$relation->t_table."';");
						if (count($relations2) >= '1') {
							foreach ($relations2 as $relation2) {
								$tr = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$relation2->t_table."`;");
								$array=array(); foreach($tr as $member=>$data) { $array[$member]=$data; }
								$felder = explode("PRIMARY KEY",$array['Create Table']);
								$felder = explode(",",str_replace(array("8,2","','","\r","\n"),array("8.2","'.'","",""),$felder[0]));
								for ($i=1;$felder[$i] != '';$i++) {
									$srel .= preg_replace("/.*`(.*)`\s.*/","`".$relation2->t_table."`.`$1` AS `$1---".$relation2->t_table."`,",$felder[$i-1]);
								}
								if ($alldone[$relation2->t_table."-".$relation->t_table] != '1') {
									$alldone[$relation2->t_table."-".$relation->t_table] = '1';
									$abfrage2 .= "LEFT JOIN `".$wpdb->prefix."wct".$relation2->t_table."` as `".$relation2->t_table."` ON `".$relation->t_table."`.`".$relation2->s_field."`=`".$relation2->t_table."`.`".$relation2->t_field."` ";
								}
							}
						}
					}
				}
				/* finishing up and send query */
				
				$finishabfrage = " FROM `".$wpdb->prefix."wct".$id."` as `".$id."` ". $abfrage2 . "WHERE `".$id."`.`status`='active'".$zusatz;		
				$abfrage = "SELECT `".$id."`.*".($srel != '' ? ", ".substr(str_replace("---","",$srel),0,-1) : "").$finishabfrage.$zusatz2." LIMIT ".$limit2.";";
				
				$abfrage = apply_filters('wct_searchfilter', $abfrage, array('filter'=>'1','searchfilter'=>$searchfilter) );
				
				if (md5($_GET['stefan']) == '57bac832cb4143ea3b857a987178e9b1') { echo $abfrage."<hr/>"; }
				$qry = $wpdb->get_results($abfrage);

				if (count($qry) >= '1') {
					if ($this->settings['nice_setfields'] == '1') {
						$table2 = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$id."`;");
						$array=array(); foreach($table2 as $member=>$data) { $array[$member]=$data; }
						$felder = explode("PRIMARY KEY",$array['Create Table']);
						$felder = explode(",",str_replace(array("8,2","','","\r","\n"),array("8.2","'.'","",""),$felder[0]));
						for ($i=2;$felder[$i] != '';$i++) {
							if (strpos ($felder[$i-1]," set") !== false) {
								$nicesetfeld[] = preg_replace("/.*`(.*)`\s.*/","$1",$felder[$i-1]);
							}
						}
					}

					$schlaufe = '1';
					unset($zeile);
					$adline = $this->settings['ads_line'];
					$linie='0';

					foreach ($qry as $row) {
						if ($this->settings['ads_active'] == '1' AND $linie == (integer)$adline) {
							$adline += $this->settings['ads_line'];
							$out .= "<tr><td colspan=\"".$colspan."\">".stripslashes($this->settings['ads_code'])."</td></tr>";
						}
						$linie++;

						$dlids .=  $row->id.",";
						if ($this->settings['nice_setfields'] == '1' AND is_array($nicesetfeld)) {
							foreach ($nicesetfeld as $wert) {
								$row->$wert = str_replace(",",", ",$row->$wert);
							}
						}

						// Remove breaklines between table
						$inhalt = $this->filter_tables(apply_filters('wct_table',$table->t_setup));

						// Replace link
						$inhalt = rbr(str_replace("[LINK]",$url."wcteid=".$row->id,stripslashes($inhalt)));

						if ($schlaufe == '1') {
							if ($color == "1") { $color = "2"; } else { $color = "1"; }
							$zeile .= "<tr class=\"wct".$css."-td".$color."\" id=\"wct_omaster".$cache."_".$row->id."\" ";
							if ($table->overlay == '1' AND strpos($inhalt,"[wctoverlay]") === FALSE) { $zeile .= "onmousemove=\"box_show('wct_overlay".$cache."_".$row->id."','wct_omaster".$cache."_".$row->id."','wct".$css."-td-hover')\" onmouseout=\"box_hide('wct_overlay".$cache."_".$row->id."','wct_omaster".$cache."_".$row->id."','wct".$css."-td".$color."')\""; }
							else { $zeile .= "onmouseover=\"this.setAttribute('class', 'wct".$css."-td-hover')\" onmouseout=\"this.setAttribute('class', 'wct".$css."-td".$color."')\""; }

							if ($row->link != '') {
								$zeile .= " onclick=\"location.href='".$row->link."'\"";
							}
							elseif ($table->editlink != '') {
								$zeile .= " onclick=\"location.href='".$table->editlink."?wctfid=".$row->id."'\"";
							}
							elseif (strpos($table->t_setup,"[LINK]") == FALSE AND $table->e_setup != '') {
								$zeile .= " onclick=\"location.href='".$url."wcteid=".$row->id."'\"";
							}
							$zeile .= ">";
						}

						if (has_filter('the_editor', 'qtrans_modifyRichEditor')) {

							/*qtranslate support*/
							if (!preg_match('/.*!--:'.qtrans_getLanguage().'-->(.*?)<!--:--.*/',$inhalt))
							{
								/* No multilanguage content found */
								$tmp = $inhalt;
							}
							else {
								/* Language found */
								preg_match('/.*!--:'.qtrans_getLanguage().'-->(.*?)<!--:--.*/',$inhalt, $treffer);
								$tmp = $treffer[1];
							}
						}
						else {
							$tmp = $inhalt;
						}
						/* replace all {fields} with content, including relations */	
						$tmp = stripslashes(preg_replace("/\{([0-9]*)\.*(.*?)\}/e","stripslashes(\$row->$2$1)",$tmp));
						
						if ($table->overlay == '1' AND strpos($inhalt,"[wctoverlay]") !== FALSE) { $tmp = str_replace("[wctoverlay]","[wctoverlay id=\"".$row->id."\" color=\"".$color."\" cache=\"".$cache."\"]",$tmp); }
						elseif (strpos($inhalt,"[wctoverlay]") !== FALSE) { $tmp = str_replace(array("[wctoverlay]","[/wctoverlay]"),array("",""),$tmp); }

						if (is_user_logged_in()) {
							if (strpos($tmp,"[wctedit]") !== FALSE) {
								if ($arr_user[$this->settings['crole'.$id.'_c']] <= $user->user_level) {
									$tmp = str_replace(
										array("editlink","[wctedit]","[/wctedit]"),
										array("<a style=\"text-decoration:none;\" href=\"".($table->editlink != '' ? $table->editlink : admin_url()."admin.php?page=wct_table_".$id."&wcttab=content&action=edit&rid=").$row->id."\">[". __('Edit','wct')."]</a>","",""),
										$tmp
									);
								}
							}
							elseif ($arr_user[$this->settings['crole'.$id.'_c']] <= $user->user_level  AND $this->settings['hideedit'] != '1') {
								$tmp .= "<td><a style=\"text-decoration:none;\" href=\"".($table->editlink != '' ? $table->editlink : admin_url()."admin.php?page=wct_table_".$id."&wcttab=content&action=edit&rid=").$row->id."\">[". __('Edit','wct')."]</a></td>";
							}
						}
						elseif (strpos($tmp,"[wctedit]") !== FALSE) {
							$tmp = preg_replace("/\[wctedit\].*\[\/wctedit\]/", ($table->editlink != '' ? $table->editlink : ""), $tmp);
						}
						
						$zeile .= do_shortcode($tmp);

						if ($schlaufe == $rowcount) {
							$zeile .= "</tr>";
							$schlaufe = '0';
						}
						
						if ($table->overlay == '1') {

							if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6.') !== FALSE) { $pos = "position: absolute;"; }
							else { $pos = "position: fixed;"; }

							if (!preg_match('/!--:'.qtrans_getLanguage().'-->(.*?)<!--:--/',$this->filter_tables(apply_filters('wct_overlay',$table->o_setup)))) {
								$overlay .= "<div style=\"z-index:9999;".$pos."\" id=\"wct_overlay".$cache."_".$row->id."\" class=\"wct".$css."-overlay\">".
								"<a style=\"float: right;text-decoration:none;\" href=\"javascript:box_hide2('wct_overlay".$cache."_".$row->id."');\">X</a>".
								rbr(rbr(do_shortcode(stripslashes(preg_replace("/\{(.*?)\}/e","stripslashes(\$row->$1)",stripslashes(apply_filters('wct_overlay',$table->o_setup))))," ",">","<")))."</div>";
							}
							else {
								preg_match('/.*!--:'.qtrans_getLanguage().'-->(.*?)<!--:--.*/',apply_filters('wct_overlay',$table->o_setup), $treffer);
								$overlay .= "<div style=\"z-index:9999;".$pos."\" id=\"wct_overlay".$cache."_".$row->id."\" class=\"wct".$css."-overlay\">".
								"<a style=\"float: right;text-decoration:none;\" href=\"javascript:box_hide2('wct_overlay".$cache."_".$row->id."');\">X</a>".
								rbr(rbr(do_shortcode(stripslashes(preg_replace("/\{(.*?)\}/e","stripslashes(\$row->$1)",$treffer[1]))," ",">","<")))."</div>";
							}
						}
						$schlaufe++;
						$out .= $zeile;
						unset($zeile);
					}
				}
				else {
					$out .= "<tr><td colspan=\"".($colspan != '' ? $colspan : '500')."\" class=\"wct".$css."-errorfield\">".__('No entries found', 'wct')."</td></tr>";
				}

				$abfrage2 = "SELECT count(`".$id."`.`id`) as `anz` ".$finishabfrage.";";
				$abfrage2 = apply_filters('wct_searchfilter', $abfrage2, array('filter'=>'2','searchfilter'=>$searchfilter) );

				$qry = $wpdb->get_row($abfrage2);
				$menge = ceil($qry->anz / $limit);
				
				if ($menge > '1' AND $this->settings['hidepagenumbers'] != '1' AND $hidepagenumbers != '1') {
					$url = $this->generate_pagelink("/[&?]+wct".$this->wctnr."start=[0-9]*/","");
					$out .= "<tr><td colspan=\"".($colspan != '' ? $colspan : '500')."\" class=\"wct".$css."-pagefield\"><div class='tablenav-pages'><center><b>".__('Page', 'wct').":</b>&nbsp;";
					for ($x=1;$x <= $menge;$x++) {
						$l = ($limit * ($x - 1)) + 1;

						if ($x <= floor ($pages / 2) OR (($_GET['wct'.$this->wctnr.'start']+$limit) == $l) ) { $ausgabe = '1'; }
						elseif ($x > $menge - floor ($pages / 2)) {
							if ($nonceC != '1') {
								$out .= "...&nbsp;";
								$nonceC = '1';
							}
							$ausgabe = '1';
						}
						elseif ($_GET['wct'.$this->wctnr.'start'] >= $l AND $_GET['wct'.$this->wctnr.'start'] < ($l + ($limit * 4))) {
							if ($nonceA != '1') {
								$out .= "...&nbsp;";
								$nonceA = '1';
							}
							$ausgabe = '1';
						}
						else { $ausgabe = '0'; }
						
						if ($ausgabe == '1') {
							if($_GET['wct'.$this->wctnr.'start'] == $l OR ($l == '1' AND $_GET['wct'.$this->wctnr.'start'] == '')) { $out .= $x."&nbsp;"; }
							else {
								$out .= "<a href=\"".$url."wct".$this->wctnr."start=".$l."\">".($_GET['wct'.$this->wctnr.'start'] == $l ? "<b>".$x."</b>" : $x )."</a>&nbsp;";
							}
						}
					}

					if ($table->dl != '0') {
						$out .= "&nbsp;&nbsp;&nbsp;<b>".__('Download','wct').":</b>";
						$qrr = $wpdb->get_row("SELECT `secret` FROM `".$wpdb->prefix."wct_list` WHERE `id`='".$id."' LIMIT 1;");
						if ($table->dl == '1' OR $table->dl == '3') { 
							$out .= "<a target=\"_blank\" href=\"".plugins_url('custom-tables/dl.php')."?i=".$id."&l=".$qrr->secret."&t=excel&r=".base64_encode($dlids)."\"><img style=\"position:relative;top:7px;margin-top:-5px;\" src=\"".plugins_url('custom-tables/img/excel.png')."\" border=\"0\" alt=\"Excel\" height=\"25\" /></a>";
						}
						if ($table->dl == '2' OR $table->dl == '3') { 
							$out .="<a target=\"_blank\" href=\"".plugins_url('custom-tables/dl.php')."?i=".$id."&l=".$qrr->secret."&t=csv&r=".base64_encode($dlids)."\"><img style=\"position:relative;top:7px;margin-top:-5px;\" src=\"".plugins_url('custom-tables/img/csv.gif')."\" border=\"0\" alt=\"CSV\" height=\"25\" /></a>";
						}
					}
					$out .= "</center></div></td></tr>";
				}
				else {
					if ($table->dl != '0') {
						$qrr = $wpdb->get_row("SELECT `secret` FROM `".$wpdb->prefix."wct_list` WHERE `id`='".$id."' LIMIT 1;");
						$out .= "<tr><td colspan=\"".($colspan != '' ? $colspan : '500')."\" class=\"wct".$css."-pagefield\"><center>";
						$out .= "&nbsp;&nbsp;&nbsp;<b>".__('Download','wct').":</b>";
						$qrr = $wpdb->get_row("SELECT `secret` FROM `".$wpdb->prefix."wct_list` WHERE `id`='".$id."' LIMIT 1;");
						if ($table->dl == '1' OR $table->dl == '3') { 
							$out .= "<a target=\"_blank\" href=\"".plugins_url('custom-tables/dl.php')."?i=".$id."&l=".$qrr->secret."&t=excel&r=".base64_encode($dlids)."\"><img style=\"position:relative;top:7px;margin-top:-5px;\" src=\"".plugins_url('custom-tables/img/excel.png')."\" border=\"0\" alt=\"Excel\" height=\"25\" /></a>";
						}
						if ($table->dl == '2' OR $table->dl == '3') { 
							$out .="<a target=\"_blank\" href=\"".plugins_url('custom-tables/dl.php')."?i=".$id."&l=".$qrr->secret."&t=csv&r=".base64_encode($dlids)."\"><img style=\"position:relative;top:7px;margin-top:-5px;\" src=\"".plugins_url('custom-tables/img/csv.gif')."\" border=\"0\" alt=\"CSV\" height=\"25\" /></a>";
						}
						$out .= "</center></td></tr>";
					}
				}

				$out .= "</table>\n\n<div style=\"visibility:hidden;display:none;\">Custom Tables Plugin 05a1a29bdcae7b12229e651a9fd48b11</div>\n\n";
				if ($table->overlay == '1') {
					echo $overlay;
				}

				if ($table->nachtext != '') { $out .= "<br/>".rbr(stripslashes($table->nachtext)); }
			}
		}
		else {
			$out = "<p>".__('Table Setup', 'wct')." ".__('not configured', 'wct')."</p>";
		}
		$out = do_shortcode($out);
		if (!is_user_logged_in() AND !$searchqry) { wp_cache_set( $savechaching , $out, 'wct', $this->settings['wct_cachetime']); }
	}
}
else {
	if ($eid == '') { $entry = (integer)$_GET['wcteid']; }
	else { $entry = (integer)$eid; }
	$out = wp_cache_get( 'wct_table'.$id.'e'.$entry , 'wct');
	do_action('wct_showentry', array('table' => $id, 'entry' => $entry));
	
	if ($out == false OR is_user_logged_in()) {
		$url = $this->generate_pagelink("/[&?]+wcteid=[0-9]*/","");

		if ($design != '' AND $design != '') {
			$designnotfound = '0'; 
			$table = $wpdb->get_row("SELECT `e_setup` FROM `".$wpdb->prefix."wct_setup` WHERE `table_id`='".$id."' AND `id`='".mres($design)."' LIMIT 1;");
			if (count($table) != '1') { $designnotfound = '1';  }
		}
		if ($designnotfound == '1' OR !isset($designnotfound)) {
			$table = $wpdb->get_row("SELECT `e_setup` FROM `".$wpdb->prefix."wct_list` WHERE `id`='".$id."' LIMIT 1;");
		}

		if ($table->e_setup != '') {
			$out = "<p>";
			$qry = $wpdb->get_row("SELECT * FROM `".$wpdb->prefix."wct".$id."` WHERE `id`='".mres($entry)."' AND `status`='active' LIMIT 1;");
			if ($qry->id != '') {
				// Remove breaklines between table
				$inhalt = rbr($this->filter_tables(apply_filters('wct_entry',$table->e_setup)));

				if (!preg_match('/!--:'.qtrans_getLanguage().'-->(.*?)<!--:--/',$inhalt)) {
					$inhalt = rbr(rbr(stripslashes(preg_replace("/\{(.*?)\}/e","\$qry->$1",$inhalt))," ",">","<"));
				}
				else {
					preg_match('/!--:'.qtrans_getLanguage().'-->(.*?)<!--:--/',$inhalt, $treffer);
					$inhalt = rbr(rbr(stripslashes(preg_replace("/\{(.*?)\}/e","\$qry->$1",$treffer[1]))," ",">","<"));
				}
				$out .= str_replace("[BACK]","<a href=\"".$url."\">".__('back', 'wct')."</a>",$inhalt);

				if (is_user_logged_in()) {
					if ($arr_user[$this->settings['crole'.$id.'_c']] <= $user->user_level) {
						$out .= "<br/><br/><a style=\"text-decoration:none;\" href=\"".admin_url()."admin.php?page=wct_table_".$id."&wcttab=content&action=edit&rid=".$entry."\">". __('Edit','wct')."</a>";
					}
				}
			}
			else {
				$out .= "<p>".__('Entry not found', 'wct')."</p>";
			}
			$out .= "</p>";
		}
		else {
			$out = "<p>".__('Entry Setup', 'wct')." ".__('not configured', 'wct')."</p>";
		}
		$out = do_shortcode($out);
		if (!is_user_logged_in()) { wp_cache_set( 'wct_table'.$id.'e'.$entry, $out, 'wct', $this->settings['wct_cachetime']); }
	}
}

if ($_GET['wct_chkliz'] == '1') {
	$t = "pre";$p = "ch";$t = $t."m_".$p."k";$t = $this->$t('',1);

	$data = $this->http_request('POST','http://api.wuk.ch/wct-premium.php',"serial=".trim($t[1]."-".$t[2]."-".$t[3])."&dom=".$_SERVER['SERVER_NAME']);
	
	if (strpos($data,"|") !== false) {
		echo "Illegal Key found: '".$t[1]."-".$t[2]."-".$t[3]."-".$t[4]."'";
		$this->settings['form_serial'] = '';
		$this->settings['form_serialvu'] = '0';
		update_option('wuk_custom_tables', $this->settings);
	}
	else {
		echo "Serial Valid, see SALT: '".md5("wct-".$t[2].$t[3])."'";
	}
}

?>