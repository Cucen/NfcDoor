<?php

$current = get_option('active_plugins');

if (!isset($_GET['wcttab'])) { $_GET['wcttab'] = 'css_table'; }
if ($_POST['savecss'] != '') {
	if ($_GET['wcttab'] == 'css_widget') { $this->settings['css2'] = $_POST['newcontent']; }
	else { $this->settings['css'] = $_POST['newcontent']; }
	update_option('wuk_custom_tables', $this->settings);
}

if (in_array( 'custom-tables/custom-tables-widget.php', $current)) {
	echo "<div style=\"padding-top:15px;\"><table vspace=\"0\" hspace=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"background-image:url(" . plugins_url('custom-tables/img/tab.png') . ");height:30px;\" ><tr>";
				
	echo $this->tab_link($wcttab,'Table CSS','css_table');
	echo $this->tab_link($wcttab,'Widget CSS','css_widget');

	echo "</tr></table></div>";
}

switch ($_GET['wcttab']) {
	case 'css_widget':
		echo "<h3>".__('Edit Widget CSS', 'wct')."</h3><form name=\"template\" id=\"template\" action=\"admin.php?page=wct_css&wcttab=css_widget\" method=\"post\"><table><tr><td>
		<textarea cols=\"90\" rows=\"25\" name=\"newcontent\" id=\"newcontent\" tabindex=\"1\">".stripslashes($this->settings['css2'])."</textarea>
		</td><td><b>".__('Possible WCT Styles','wct').":</b><br/><textarea readonly rows=\"19\" cols=\"15\" name=\"possible\">.wct_widget_titel\n.wct_widget_ul\n.wct_widget_li\n.wct_widget_a\n</textarea></td></tr>
		</table><input class=\"button-primary\" type=\"submit\" name=\"savecss\" value=\"". __('Save all Changes', 'wct') ."\" /></form>";
	break;

	default:
		echo "<h3>".__('Edit Table CSS', 'wct')."</h3><form name=\"template\" id=\"template\" action=\"admin.php?page=wct_css&wcttab=css_table\" method=\"post\"><table><tr><td>
		<textarea cols=\"90\" rows=\"25\" name=\"newcontent\" id=\"newcontent\" tabindex=\"1\">".stripslashes($this->settings['css'])."</textarea>
		</td><td><b>".__('Possible WCT Styles','wct').":</b><br/><textarea readonly rows=\"26\" cols=\"25\" name=\"possible\">.wct-sortdown\n.wct-sortup\n.wct-search\n.wctarchiveheader\n.wctarchiveul\n.wctarchiveli\n.wctarchivea\n.wct-table\n.wct-headline\n.wct-td1\n.wct-td2\n.wct-td-hover\n.wct-cell\n.wct-overlay\n.wct-pagefield\n.wct-errorfield\n.wct-button\n.wct-select\n.wct-option\n\n.wct-formint6\n.wct-formint11\n.wct-formchar32\n.wct-formchar64\n.wct-formchar128\n.wct-formtext\n.wct-formdate\n.wct-formpic</textarea></td></tr>
		</table><input class=\"button-primary\" type=\"submit\" name=\"savecss\" value=\"". __('Save all Changes', 'wct') ."\" /></form>";
		printf(__('If you have defined a SALT by the table like %s, the CSS Stylesheet will change the CSS from %s to %s','wct'), '<input type=\'text\' value=\'css="10"\' size=\'12\' readonly/>', '<input type=\'text\' value=\'.wct-table\' size=\'12\' readonly/>', '<input type=\'text\' value=\'.wct10-table\' size=\'12\' readonly/>');
	break;
}

?>