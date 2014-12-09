<?php
/*
   Class Name: Downloader for Backups and Exports
   Description: Download data from plugin
   Author: web updates kmu <stefan@wuk.ch>

   This program is distributed under the GNU General Public License, Version 2,
   June 1991. Copyright (C) 1989, 1991 Free Software Foundation, Inc., 51 Franklin
   St, Fifth Floor, Boston, MA 02110, USA

   THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
   ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
   WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
   DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
   ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
   (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
   LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
   ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
   (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
   SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/

if (!defined('DIRECTORY_SEPARATOR')) {
	if (strstr($_SERVER[DOCUMENT_ROOT],"/")) { define('DIRECTORY_SEPARATOR', '/'); }
	elseif (strstr($_SERVER[DOCUMENT_ROOT],"\\")) { define('DIRECTORY_SEPARATOR', '\\'); }
	
	if (!defined('DIRECTORY_SEPARATOR')) {
		if (strpos(php_uname('s'), 'Win') !== false ) { define('DIRECTORY_SEPARATOR', '\\'); }
		else { define('DIRECTORY_SEPARATOR', '/'); }
	}
}

$absolutepath = ".".DIRECTORY_SEPARATOR."wp-config.php";

/* No not edit the file after this line, if you dont know what to do */

if ($_GET['d'] == 'true') {
	$WCTDEBUG = true;
	error_reporting(E_ALL ^ E_NOTICE);
}
else {
	error_reporting(0);
}

function wctdebug() {
	global $WCTDEBUG;
	if ($WCTDEBUG) { return mysql_error(); }
	else { return ''; }
}

if (!function_exists('rbr')) { function rbr($t,$replace = "<br/>",$s='',$e='') { $t = html_entity_decode(str_replace(array($s."\r\n".$e,$s."\n".$e,$s."\r".$e),array($s.$replace.$e,$s.$replace.$e,$s.$replace.$e),$t)); return $t; } }
// Fix for installations without mbstring
if (!function_exists('mb_convert_encoding')) { function mb_convert_encoding($a,$b='',$c='') { return $a; } }

if ($_SERVER[SCRIPT_FILENAME] != '') {
	$dirs = explode (DIRECTORY_SEPARATOR, $_SERVER[SCRIPT_FILENAME]);
	array_pop($dirs);
	array_pop($dirs);
	array_pop($dirs);
	array_pop($dirs);
	$dir2 = implode(DIRECTORY_SEPARATOR,$dirs).DIRECTORY_SEPARATOR;
}
if ($_SERVER[DOCUMENT_ROOT] != '') {
	$dirs = explode (DIRECTORY_SEPARATOR, $_SERVER[DOCUMENT_ROOT]);
	array_pop($dirs);
	$dir3 = implode(DIRECTORY_SEPARATOR,$dirs).DIRECTORY_SEPARATOR;
	array_pop($dirs);
	$dir4 = implode(DIRECTORY_SEPARATOR,$dirs).DIRECTORY_SEPARATOR;
}

if (file_exists($absolutepath)) {
	include($absolutepath);
}
elseif ($_SERVER[SCRIPT_FILENAME] != '' AND file_exists($dir2."wp-config.php")) {
	include($dir2."wp-config.php");
}
elseif ($_SERVER[DOCUMENT_ROOT] != '' AND file_exists($_SERVER[DOCUMENT_ROOT].DIRECTORY_SEPARATOR."wp-config.php")) {
	include($_SERVER[DOCUMENT_ROOT].DIRECTORY_SEPARATOR."wp-config.php");
}
elseif ($_SERVER[SCRIPT_FILENAME] != '' AND file_exists($dir3."wp-config.php")) {
	include($dir3."wp-config.php");
}
elseif ($_SERVER[SCRIPT_FILENAME] != '' AND file_exists($dir4."wp-config.php")) {
	include($dir4."wp-config.php");
}
else {
	if ($WCTDEBUG) {
		echo "No wp-config.php found<br/><br/><b>Debug:<b/><UL>
			<li>".$absolutepath."</li>
			<li>".$dir2."wp-config.php</li>
			<li>".$_SERVER[DOCUMENT_ROOT].DIRECTORY_SEPARATOR."wp-config.php</li>
			<li>".$dir3."wp-config.php</li>
			<li>".$dir4."wp-config.php</li></UL>";
	}
	exit;
}

if (is_numeric($_GET['i']) AND isset($_GET['l']) AND ($_GET['t'] == 'excel' OR $_GET['t'] == 'csv' OR $_GET['t'] == 'xml')) {
	if ($WCTDEBUG) echo "In der Verarbeitung<br/>";
	$num = (integer)$_GET['i'];
	$db = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(wctdebug());
	mysql_select_db(DB_NAME,$db) or die(wctdebug());

	$secretchk = mysql_query("SELECT `id` FROM `".$wpdb->prefix."wct_list` WHERE `id`='".mysql_real_escape_string($num)."' AND `secret`='".mysql_real_escape_string($_GET['l'])."' LIMIT 1;", $db) or die(wctdebug());
	if (@mysql_num_rows($secretchk) == '1') {
		$table = mysql_query("SHOW CREATE TABLE `".$wpdb->prefix."wct".mysql_real_escape_string($num)."`;", $db) or die(wctdebug());
		if (@mysql_num_rows($table) == '1') {
			if ($_GET['t'] == 'csv') {
				if (!$WCTDEBUG) {
					header("Content-type: application/CSV");
					header("Content-Disposition: attachment; filename=".date("Ymd",time())."_wct_table".$num.".csv");
				}
				else { echo "Header csv gesetzt<br/>"; }
			}
			elseif ($_GET['t'] == 'xml') {
				if (!$WCTDEBUG) {
					header("Content-Type: application/xml");
					header("Content-Disposition: attachment; filename=".date("Ymd",time())."_wct_table".$num.".xml");
				}
				else { echo "Header xml gesetzt<br/>"; }
				echo "<?xml version='1.0' standalone='yes'?>\r\n<table>\r\n\t<name>wct".mysql_real_escape_string($num)."</name>\r\n\t<header><![CDATA[";

			}
			else {
				if (!$WCTDEBUG) {
					header("Content-type: application/vnd-ms-excel");
					header("Content-Disposition: attachment; filename=".date("Ymd",time())."_wct_table".$num.".xls");
					echo "<table border=\"1\"><tr>";
				}
				else { echo "Header Excel gesetzt<br/>"; }
			}
			$felder = explode("\n",mysql_result($table,0,"Create Table"));
			for ($i=3;$felder[$i] != '';$i++) {
				if ($_GET['t'] == 'csv') {
					if (!$WCTDEBUG) echo preg_replace("/.*`(.*)`.*/","\"$1\";",$felder[$i-2]);
				}
				if ($_GET['t'] == 'xml') {
					if (!$WCTDEBUG) echo "\"".preg_replace("/.*`(.*)`.*/","$1",$felder[$i-2])."\",";
				}
				elseif ($_GET['t'] == 'excel') {
					if (!$WCTDEBUG) echo preg_replace("/.*`(.*)`.*/","<td><strong>$1</strong></td>",$felder[$i-2]);
				}
			}
			if ($_GET['t'] == 'csv') { if (!$WCTDEBUG) { echo "\r\n"; } }
			elseif ($_GET['t'] == 'excel') { if (!$WCTDEBUG) { echo "</tr>"; } }
			elseif ($_GET['t'] == 'xml') { if (!$WCTDEBUG) { echo "]]></header>\r\n"; } }
			$i = $i - 4;

			if ($WCTDEBUG) echo "Headerzeile ausgegeben<br/>";

			
			if ($_GET['r'] != '') {
				$ids = substr(base64_decode($_GET['r']),0,-1);
				if (!preg_match('/^[0-9,]*$/',$ids)) {
					$ids = '';
				}
			}
			else { $ids = ''; }
			if (isset($_GET['r'])) {
				$addon = "WHERE `status`='active'";
				if ($ids != '') { $addon .= " AND `id` IN(".mysql_real_escape_string($ids).")"; }
			}
			$abf = mysql_query("SHOW CREATE TABLE `".$wpdb->prefix."wct".mysql_real_escape_string($num)."`;", $db) or die(wctdebug());
			$create = mysql_result($abf,0,"Create Table");
			$fields = explode("`",str_replace("` "," ",$create));
			array_shift($fields); array_shift($fields);
			foreach ($fields as $field => $def) {
				if (strstr($def,"int(10)")) {
					$ff[$field] = '1';
				}
			}
			
			$abfrage = mysql_query("SELECT * FROM `".$wpdb->prefix."wct".mysql_real_escape_string($num)."` ".($addon != '' ? $addon : "").";", $db) or die(wctdebug());
			if (mysql_num_rows($abfrage) >= '1') {
				if ($_GET['t'] == 'xml') { echo "\t<content>\r\n"; }
				while ($row = mysql_fetch_array($abfrage))
				{
					if ($_GET['t'] == 'excel') { echo "<tr>"; }
					if ($_GET['t'] == 'xml') { echo "\t\t<row><![CDATA[\r\n"; }

					for ($x=0;$x <= $i;$x++) {
						if (is_numeric($row[$x]) AND $ff[$x] == '1') { $row[$x] = date("Y-m-d",$row[$x]); }

						if ($_GET['t'] == 'csv') {
							if (!$WCTDEBUG) echo "\"".mb_convert_encoding(str_replace("\\\"","'",$row[$x]),"Windows-1252","UTF-8")."\";";
						}
						elseif ($_GET['t'] == 'xml') {
							$Spalte = "row".$x + 2;
							if (!$WCTDEBUG) echo "\"".str_replace("\\\"","'",$row[$x])."\",";
						}
						else {
							if (!$WCTDEBUG) echo "<td>".htmlspecialchars($row[$x], ENT_QUOTES, "UTF-8")."</td>";
						}
					}
					if ($_GET['t'] == 'csv') { if (!$WCTDEBUG) { echo "\r\n"; } else { echo ". "; } }
					elseif ($_GET['t'] == 'excel') { if (!$WCTDEBUG) { echo "</tr>"; } else { echo ". "; } }
					elseif ($_GET['t'] == 'xml') { if (!$WCTDEBUG) { echo "]]></row>\r\n"; } else { echo ". "; } }
				}
				if ($_GET['t'] == 'xml') { echo "\t</content>\r\n"; }
			}
			if ($_GET['t'] == 'excel') { if (!$WCTDEBUG) { echo "</table>"; } else { echo "<br/>Fertig"; } }
			elseif ($_GET['t'] == 'xml') { if (!$WCTDEBUG) { echo "</table>"; } else { echo "<br/>Fertig"; } }
			else { if ($WCTDEBUG) { echo "<br/>Fertig"; } }
		}
	}
}
elseif (isset($_GET['s'])) {
	$db = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(wctdebug());
	mysql_select_db(DB_NAME,$db) or die(wctdebug());

	$qrya = mysql_query("SELECT `id` FROM `".$wpdb->prefix."wct_list` WHERE `secret`='".mysql_real_escape_string($_GET['s'])."' AND `id`='0' LIMIT 1;", $db) or die(wctdebug());
	if (@mysql_num_rows($qrya) >= '1') {

		if (!$WCTDEBUG) {
			header("Content-type: text/wct");
			header("Content-Disposition: attachment; filename=".date("Ymd",time())."_wct_backup.wct");
			echo "// WordPress Custom Tables Backup ".date("Y-m-d H:i:s",time())."\r\n\r\n";
		}
		else {
			echo "Header ausgegeben<br/>";
		}
		$qry = mysql_query("SELECT `blog_id`,`option_value` FROM `".$wpdb->prefix."options` WHERE `option_name`='wuk_custom_tables' LIMIT 1;",$db) or die(wctdebug());
		if (!$WCTDEBUG) {
			echo "// Custom Tables Settings\r\n";
			echo "\$wpdb->get_row(\"DELETE FROM `\".\$wpdb->prefix.\"options` WHERE `blog_id`='".mysql_result($qry,0,"blog_id")."' AND `option_name`='wuk_custom_tables' LIMIT 1;\");\r\n";
			echo "\$wpdb->get_row(\"REPLACE INTO `\".\$wpdb->prefix.\"options` SET `blog_id`='".mysql_result($qry,0,"blog_id")."', `option_name`='wuk_custom_tables', `option_value`='".mysql_real_escape_string(mysql_result($qry,0,"option_value"))."', `autoload`='yes';\");\r\n\r\n";
			echo "\$wpdb->get_row(\"DELETE FROM `\".\$wpdb->prefix.\"wct_list`;\");\r\n\r\n";
		}
		else { echo "Settings ausgegeben<br/>"; }

		$qry = mysql_query("SELECT * FROM `".$table_prefix."wct_list` ORDER BY `id` ASC;",$db) or die(wctdebug());
		if (@mysql_num_rows($qry) >= '1') {
			while ($row = mysql_fetch_assoc($qry)) {
				if (!$WCTDEBUG) {
					echo "// Table '".$row[name]."':\r\n";
					if ($row[id] != '0') { $secret = $row[secret]; } else { $secret = '-- none --'; }
					echo "\$wpdb->get_row(\"INSERT INTO `\".\$wpdb->prefix.\"wct_list` SET `id`='".$row[id]."', `name`='".mysql_real_escape_string($row[name])."', `secret`='".$secret."', `t_setup`='".mysql_real_escape_string($row[t_setup])."', `e_setup`='".mysql_real_escape_string($row[e_setup])."', `o_setup`='".mysql_real_escape_string($row[o_setup])."', `sheme`='".$row[sheme]."', `overlay`='".mysql_real_escape_string($row[overlay])."', `headerline`='".mysql_real_escape_string($row[headerline])."', `header`='".mysql_real_escape_string($row[header])."', `headersort`='".mysql_real_escape_string($row[headersort])."', `vortext`='".mysql_real_escape_string($row[vortext])."', `nachtext`='".mysql_real_escape_string($row[nachtext])."', `sort`='".$row[sort]."', `sortB`='".$row[sortB]."', `searchaddon`='".$row[searchaddon]."';\");\r\n";
				} else { echo "Tabelle: Erstellt"; }

				if ($row[id] != '0') {
					$tablet = mysql_query("SHOW CREATE TABLE `".$table_prefix."wct".$row[id]."`;");

					if (!$WCTDEBUG) {
						echo "\$wpdb->get_row(\"DROP TABLE `\".\$wpdb->prefix.\"wct".$row[id]."`;\");\r\n";
						echo "\$wpdb->get_row(\"".str_replace($table_prefix,"\".\$wpdb->prefix.\"",rbr(mysql_result($tablet,0,'Create Table'),'')).";\");\r\n";
					} else { echo ", Drop &amp; Create, Inhalt:<br/>"; }

					$abfrage = mysql_query("SELECT * FROM `".$table_prefix."wct".$row[id]."`;",$db) or die(wctdebug());
					if (@mysql_num_rows($abfrage) >= '1') {
						while ($row2 = mysql_fetch_assoc($abfrage)) {
							$x='0';
							if (!$WCTDEBUG) echo "\$wpdb->get_row(\"INSERT INTO `\".\$wpdb->prefix.\"wct".$row[id]."` SET";
							foreach ($row2 as $var => $wert) {
								if (!$WCTDEBUG AND $x >= '1') { echo ","; }
								$x++;
								if (!$WCTDEBUG) echo " `".$var."`='".mysql_real_escape_string($wert)."'";
							}
							if (!$WCTDEBUG) { echo ";\");\r\n"; } else { echo ". "; }
						}
					}
				}
				else {
					if (!$WCTDEBUG) { echo "\$wpdb->get_row(\"UPDATE `\".\$wpdb->prefix.\"wct_list` SET `id`=0 WHERE `name`='Archive' LIMIT 1;\");\r\n"; }
					else { echo "Archive Eintrag erstellt<br/>"; }
				}
				if (!$WCTDEBUG) { echo "\r\n"; } else{ echo "<br/>"; }
			}
		}

		$qry = mysql_query("SELECT * FROM `".$table_prefix."wct_setup` ORDER BY `id` ASC;",$db) or die(wctdebug());
		if (@mysql_num_rows($qry) >= '1') {
			while ($row = mysql_fetch_assoc($qry)) {
				if (!$WCTDEBUG) {
					echo "// Table '".$row[table_id]."' Alternate Design '".$row[name]."':\r\n";
					echo "\$wpdb->get_row(\"INSERT INTO `\".\$wpdb->prefix.\"wct_setup` SET `id`='".$row[id]."', `name`='".mysql_real_escape_string($row[name])."', `table_id`='".mysql_real_escape_string($row[table_id])."', `t_setup`='".mysql_real_escape_string($row[t_setup])."', `e_setup`='".mysql_real_escape_string($row[e_setup])."', `o_setup`='".mysql_real_escape_string($row[o_setup])."', `sheme`='".$row[sheme]."', `overlay`='".mysql_real_escape_string($row[overlay])."', `headerline`='".mysql_real_escape_string($row[headerline])."', `header`='".mysql_real_escape_string($row[header])."', `headersort`='".mysql_real_escape_string($row[headersort])."', `vortext`='".mysql_real_escape_string($row[vortext])."', `nachtext`='".mysql_real_escape_string($row[nachtext])."', `sort`='".$row[sort]."', `sortB`='".$row[sortB]."', `searchaddon`='".$row[searchaddon]."';\");\r\n";
				} else { echo "Alternative Designs: Erstellt"; }

				if (!$WCTDEBUG) { echo "\r\n"; } else{ echo "<br/>"; }
			}
		}

		if (!$WCTDEBUG) { echo "\$wpdb->get_row(\"DELETE FROM `\".\$wpdb->prefix.\"wct_form`;\");\r\n\r\n"; }
		else { echo "<br/>Bestehende Forms l&ouml;schen<br/>"; }

		$qry = mysql_query("SELECT * FROM `".$table_prefix."wct_form` ORDER BY `id` ASC;",$db) or die(wctdebug());
		if (@mysql_num_rows($qry) >= '1') {
			while ($row = mysql_fetch_assoc($qry)) {
				if (!$WCTDEBUG) {
					echo "// Form '".$row[name]."':\r\n";
					echo "\$wpdb->get_row(\"INSERT INTO `\".\$wpdb->prefix.\"wct_form` SET `id`='".$row[id]."', `name`='".mysql_real_escape_string($row[name])."', `t_setup`='".mysql_real_escape_string($row[t_setup])."', `e_setup`='".mysql_real_escape_string($row[e_setup])."', `r_fields`='".mysql_real_escape_string($row[r_fields])."', `r_table`='".$row[r_table]."', `r_filter`='".mysql_real_escape_string($row[r_filter])."', `rights`='".mysql_real_escape_string($row[rights])."'\");\r\n";
					echo "\r\n";
				}
				else {
					echo "Formular created<br/>";
				}
			}
		}

		if (!$WCTDEBUG) { echo "\$wpdb->get_row(\"DELETE FROM `\".\$wpdb->prefix.\"wct_cron`;\");\r\n\r\n"; }
		else { echo "<br/>Bestehende Cronjobs l&ouml;schen<br/>"; }

		$qry = mysql_query("SELECT * FROM `".$table_prefix."wct_cron` ORDER BY `id` ASC;",$db) or die(wctdebug());
		if (@mysql_num_rows($qry) >= '1') {
			while ($row = mysql_fetch_assoc($qry)) {
				if (!$WCTDEBUG) {
					echo "// Cron '".$row[id]."':\r\n";
					echo "\$wpdb->get_row(\"INSERT INTO `\".\$wpdb->prefix.\"wct_cron` SET `id`='".$row[id]."', `schedule`='".mysql_real_escape_string($row[schedule])."', `command`='".mysql_real_escape_string($row[command])."', `nextrun`='".mysql_real_escape_string($row[nextrun])."', `error`='".mysql_real_escape_string($row[error])."', `active`='".$row[active]."'\");\r\n";
					echo "\r\n";
				}
				else {
					echo "Cronjob created<br/>";
				}
			}
		}


		if (!$WCTDEBUG) { echo "// Backup End ".date("Y-m-d H:i:s",time()); }
		else { echo "Backup zu Ende"; }
	}
	else {
		exit("Not authorised to take a backup");
	}
}
?>