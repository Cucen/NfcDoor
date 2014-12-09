<?php	

if (get_bloginfo('version','raw') >= '3.3') {
	echo "<script type=\"text/javascript\">
	function startnow () {
	var wct_toolbar = document.getElementById(\"qt_content_toolbar\");";
	$vorid = "qt_content_";
}
else {
	echo "<script type=\"text/javascript\">
	var wct_toolbar = document.getElementById(\"ed_toolbar\");";
	$vorid = "cp_";
}

if ($_GET['wcttab2'] == 'tview') {
	echo "
	var theButtontd = document.createElement('input');

	theButtontd.type = 'button';
	theButtontd.value = 'TABLE';
	theButtontd.onclick = cp_myentryB;
	theButtontd.className = 'ed_button3';
	theButtontd.title = 'TABLE';
	theButtontd.style.backgroundImage = \"url(".plugins_url('custom-tables/img/fade-butt2.png').")\";
	theButtontd.id = '".$vorid."td';
	wct_toolbar.appendChild(theButtontd);

	var theButtontd = document.createElement('input');
	var theButtonlink = document.createElement('input');
	theButtonlink.type = 'button';
	theButtonlink.value = 'LINK';
	theButtonlink.onclick = cp_myentryC;
	theButtonlink.className = 'ed_button3';
	theButtonlink.style.backgroundImage = \"url(".plugins_url('custom-tables/img/fade-butt2.png').")\";
	theButtonlink.title = 'LINK';
	theButtonlink.id = '".$vorid."link';
	wct_toolbar.appendChild(theButtonlink);

	var theButtontd = document.createElement('input');
	theButtontd.type = 'button';
	theButtontd.value = 'wctoverlay';
	theButtontd.onclick = cp_myentryD;
	theButtontd.className = 'ed_button3';
	theButtontd.style.backgroundImage = \"url(".plugins_url('custom-tables/img/fade-butt2.png').")\";
	theButtontd.title = 'wctoverlay';
	theButtontd.id = '".$vorid."wct_ol';
	wct_toolbar.appendChild(theButtontd);";
}

if ($_GET['wcttab2'] == 'eview') {
	echo "
	var theButtonlink = document.createElement('input');
	theButtonlink.type = 'button';
	theButtonlink.value = 'BACK';
	theButtonlink.onclick = cp_myentryC;
	theButtonlink.className = 'ed_button3';
	theButtonlink.style.backgroundImage = \"url(".plugins_url('custom-tables/img/fade-butt2.png').")\";
	theButtonlink.title = 'BACK';
	theButtonlink.id = '".$vorid."link';
	wct_toolbar.appendChild(theButtonlink);";
}

if ($_GET['wcttab'] == 'eviw') {
	echo "
	var theButtonlink = document.createElement('input');
	theButtonlink.type = 'button';
	theButtonlink.value = 'again';
	theButtonlink.onclick = cp_myentryC;
	theButtonlink.className = 'ed_button3';
	theButtonlink.style.backgroundImage = \"url(".plugins_url('custom-tables/img/fade-butt2.png').")\";
	theButtonlink.title = 'again';
	theButtonlink.id = '".$vorid."link';
	wct_toolbar.appendChild(theButtonlink);";
}

echo "
	var theButtontd = document.createElement('input');
	theButtontd.type = 'button';
	theButtontd.value = 'if';
	theButtontd.onclick = cp_myentryD;
	theButtontd.className = 'ed_button3';
	theButtontd.style.backgroundImage = \"url(".plugins_url('custom-tables/img/fade-butt2.png').")\";
	theButtontd.title = 'if';
	theButtontd.id = '".$vorid."if';
	wct_toolbar.appendChild(theButtontd);

	var theButtontd = document.createElement('input');
	theButtontd.type = 'button';
	theButtontd.value = 'wctphp';
	theButtontd.onclick = cp_myentryD;
	theButtontd.className = 'ed_button3';
	theButtontd.style.backgroundImage = \"url(".plugins_url('custom-tables/img/fade-butt2.png').")\";
	theButtontd.title = 'wctphp';
	theButtontd.id = '".$vorid."wctphp';
	wct_toolbar.appendChild(theButtontd);

	var theButtontd = document.createElement('input');
	theButtontd.type = 'button';
	theButtontd.value = 'wctdate';
	theButtontd.onclick = cp_myentryE;
	theButtontd.className = 'ed_button3';
	theButtontd.style.backgroundImage = \"url(".plugins_url('custom-tables/img/fade-butt2.png').")\";
	theButtontd.title = 'wctdate';
	theButtontd.id = '".$vorid."wctdate';
	wct_toolbar.appendChild(theButtontd);
";

if ($this->prem_chk() == true)
{
	echo "
	var theButtontd = document.createElement('input');
	theButtontd.type = 'button';
	theButtontd.value = 'wctloggedin';
	theButtontd.onclick = cp_myentryD;
	theButtontd.className = 'ed_button3';
	theButtontd.style.backgroundImage = \"url(".plugins_url('custom-tables/img/fade-butt2.png').")\";
	theButtontd.title = 'wctloggedin';
	theButtontd.id = '".$vorid."wctloggedin';
	wct_toolbar.appendChild(theButtontd);";
}

if ($_GET['wcttab'] =="eviw") {
	$myrow = $wpdb->get_row("SELECT `r_fields`,`r_table` FROM `".$wpdb->prefix."wct_form` WHERE `id`='".mres(str_replace("wct_form_","",$_GET['page']))."' LIMIT 1;");	

	$table = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$myrow->r_table."`;");
	$array=array(); foreach($table as $member=>$data) { $array[$member]=$data; }
	$felder = explode("PRIMARY KEY",str_replace(array(",","8 ,2","' ,'","\r","\n"),array(" ,","8.2","'.'","",""),$array['Create Table']));

	preg_match_all("/`.*?`/",$felder[0],$treffer);
	$treffer = $treffer[0]; // Shift array one instance lower
	array_shift($treffer); // remove table name
	array_shift($treffer); // remove first field id
	array_shift($treffer); // remove first field status

	$felder2 =  explode(",",$myrow->r_fields);

	foreach ($treffer as $f => $feld) {
		$feld = str_replace("`","",$feld);
		echo "var theButton".$feld." = document.createElement('input');
			theButton".$feld.".type = 'button';
			theButton".$feld.".value = '".$feld."';
			theButton".$feld.".onclick = cp_myentry;";
		if (in_array($feld,$felder2)) {
			echo "theButton".$feld.".className = 'ed_button4';
			theButton".$feld.".style.backgroundImage = \"url(".plugins_url('custom-tables/img/fade-butt3.png').")\";";
		}
		else {
			echo "theButton".$feld.".className = 'ed_button3';
			theButton".$feld.".style.backgroundImage = \"url(".plugins_url('custom-tables/img/fade-butt2.png').")\";";
		}
		echo "theButton".$feld.".title = '".$feld."';
			theButton".$feld.".id = '".$vorid.$feld."';
			wct_toolbar.appendChild(theButton".$feld.");";
	}
}
else {
	if ($tableid != '0')	{

		echo "
		var theButton = document.createElement('input');
		theButton.type = 'button';
		theButton.value = 'id';
		theButton.onclick = cp_myentry;
		theButton.className = 'ed_button2';
		theButton.style.backgroundImage = \"url(".plugins_url('custom-tables/img/fade-butt.png').")\";
		theButton.title = 'id';
		theButton.id = '".$vorid."id';
		wct_toolbar.appendChild(theButton);\n";

		$table = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$tableid."`;");
		$array=array(); foreach($table as $member=>$data) { $array[$member]=$data; }
		$tmp = explode("PRIMARY KEY",$array['Create Table']);
		$felder = explode(",",str_replace(array(",","8 ,2","' ,'"),array(" ,","8.2","'.'"),$tmp[0]));
		for ($i=3;$felder[$i] != '';$i++) {
			// Do not show relation fields
			preg_match("/`.*`\s(.*?)\s/",$felder[$i-1],$re);
			if ($re[1] != "int(12)") {
				$feldoutput .= preg_replace("/`(.*)`\s.*/","var theButton$1= document.createElement('input');\ntheButton$1.type = 'button';\ntheButton$1.value = '$1';\ntheButton$1.onclick = cp_myentry;\ntheButton$1.className = 'ed_button2';\ntheButton$1.style.backgroundImage = \"url(".plugins_url('custom-tables/img/fade-butt.png').")\";\ntheButton$1.title = '$1';\ntheButton$1.id = 'cp_$1';\nwct_toolbar.appendChild(theButton$1);\n",$felder[$i-1]);
			}
		}
		
		// Show relations if exists
		$relz = $wpdb->get_results("SELECT `t_table`,`s_field`,`t_field` FROM `".$wpdb->prefix."wct_relations` WHERE `s_table`='".$tableid."';");
		if (count($relz) >= '1') {
			foreach($relz as $rel) {
				$feldoutput .= "
		var theButton".$rel->t_table."_id = document.createElement('input');
		theButton".$rel->t_table."_id.type = 'button';
		theButton".$rel->t_table."_id.value = '".$rel->t_table.".id';
		theButton".$rel->t_table."_id.onclick = cp_myentry;
		theButton".$rel->t_table."_id.className = 'ed_button2';
		theButton".$rel->t_table."_id.style.backgroundImage = \"url(".plugins_url('custom-tables/img/fade-butt4.png').")\";
		theButton".$rel->t_table."_id.title = '".$rel->t_table."_id';
		theButton".$rel->t_table."_id.id = '".$vorid.$rel->t_table."_id';
		wct_toolbar.appendChild(theButton".$rel->t_table."_id);\n";
		
								$feldoutput .= "
		var theButton".$rel->s_table."_rel = document.createElement('input');
		theButton".$rel->s_table."_rel.type = 'button';
		theButton".$rel->s_table."_rel.name = 'wctable id=\"".$rel->t_table."\" filter=\"`".$tableid."`.`".$rel->t_field."`=\\'{".$rel->s_field."}\\'\"';
		theButton".$rel->s_table."_rel.value = 'Rel ".$tableid.".".$rel->s_field." => ".$rel->t_table.".".$rel->t_field."';
		theButton".$rel->s_table."_rel.onclick = cp_myentryZ;
		theButton".$rel->s_table."_rel.className = 'ed_button2';
		theButton".$rel->s_table."_rel.style.backgroundImage = \"url(".plugins_url('custom-tables/img/fade-butt4.png').")\";
		theButton".$rel->s_table."_rel.title = '".$rel->s_table."_rel';
		theButton".$rel->s_table."_rel.id = '".$vorid.$rel->s_table."_rel';
		wct_toolbar.appendChild(theButton".$rel->s_table."_rel);\n";
		
				$table2 = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$rel->t_table."`;");
				$array=array(); foreach($table2 as $member=>$data) { $array[$member]=$data; }
				$tmp = explode("PRIMARY KEY",$array['Create Table']);
				$felder2 = explode(",",str_replace(array(",","8 ,2","' ,'"),array(" ,","8.2","'.'"),$tmp[0]));
				for ($i=3;$felder2[$i] != '';$i++) {
					// Do not show relation fields
					preg_match("/`.*`\s(.*?)\s/",$felder2[$i-1],$re);
					if ($re[1] != "int(12)") {
						$feldoutput .= preg_replace("/`(.*)`\s.*/","var theButton".$rel->t_table."_$1= document.createElement('input');\ntheButton".$rel->t_table."_$1.type = 'button';\ntheButton".$rel->t_table."_$1.value = '".$rel->t_table.".$1';\ntheButton".$rel->t_table."_$1.onclick = cp_myentry;\ntheButton".$rel->t_table."_$1.className = 'ed_button2';\ntheButton".$rel->t_table."_$1.style.backgroundImage = \"url(".plugins_url('custom-tables/img/fade-butt4.png').")\";\ntheButton".$rel->t_table."_$1.title = '".$rel->t_table."_$1';\ntheButton.id = 'cp_".$rel->t_table."_$1';\nwct_toolbar.appendChild(theButton".$rel->t_table."_$1);\n",$felder2[$i-1]);
					}
				}
				
				$relz2 = $wpdb->get_results("SELECT `t_table`,`s_field`,`t_field` FROM `".$wpdb->prefix."wct_relations` WHERE `s_table`='".$rel->t_table."';");
				if (count($relz2) >= '1') {
						foreach($relz2 as $rel2) {
							$feldoutput .= "
					var theButton".$rel2->t_table."_id = document.createElement('input');
					theButton".$rel2->t_table."_id.type = 'button';
					theButton".$rel2->t_table."_id.value = '".$rel2->t_table.".id';
					theButton".$rel2->t_table."_id.onclick = cp_myentry;
					theButton".$rel2->t_table."_id.className = 'ed_button2';
					theButton".$rel2->t_table."_id.style.backgroundImage = \"url(".plugins_url('custom-tables/img/fade-butt4.png').")\";
					theButton".$rel2->t_table."_id.title = '".$rel2->t_table."_id';
					theButton".$rel2->t_table."_id.id = '".$vorid.$rel2->t_table."_id';
					wct_toolbar.appendChild(theButton".$rel2->t_table."_id);\n";
										
							$table2 = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$rel2->t_table."`;");
							$array=array(); foreach($table2 as $member=>$data) { $array[$member]=$data; }
							$tmp = explode("PRIMARY KEY",$array['Create Table']);
							$felder2 = explode(",",str_replace(array(",","8 ,2","' ,'"),array(" ,","8.2","'.'"),$tmp[0]));
							for ($i=3;$felder2[$i] != '';$i++) {
								// Do not show relation fields
								preg_match("/`.*`\s(.*?)\s/",$felder2[$i-1],$re);
								if ($re[1] != "int(12)") {
									$feldoutput .= preg_replace("/`(.*)`\s.*/","var theButton".$rel2->t_table."_$1= document.createElement('input');\ntheButton".$rel2->t_table."_$1.type = 'button';\ntheButton".$rel2->t_table."_$1.value = '".$rel2->t_table.".$1';\ntheButton".$rel2->t_table."_$1.onclick = cp_myentry;\ntheButton".$rel2->t_table."_$1.className = 'ed_button2';\ntheButton".$rel2->t_table."_$1.style.backgroundImage = \"url(".plugins_url('custom-tables/img/fade-butt4.png').")\";\ntheButton".$rel2->t_table."_$1.title = '".$rel2->t_table."_$1';\ntheButton.id = 'cp_".$rel2->t_table."_$1';\nwct_toolbar.appendChild(theButton".$rel2->t_table."_$1);\n",$felder2[$i-1]);
								}
							}
							
							$relz = $wpdb->get_results("SELECT `t_table`,`s_field`,`t_field` FROM `".$wpdb->prefix."wct_relations` WHERE `s_table`='".$rel->t_table."';");
							
						}		
					}
			}		
		}
		// Show sub relations if exists
		$relz = $wpdb->get_results("SELECT `s_table`,`s_field`,`t_field` FROM `".$wpdb->prefix."wct_relations` WHERE `t_table`='".$tableid."';");
		if (count($relz) >= '1') {
			foreach($relz as $rel) {

				$feldoutput .= "
		var theButton".$rel->s_table."_id = document.createElement('input');
		theButton".$rel->s_table."_id.type = 'button';
		theButton".$rel->s_table."_id.value = '".$rel->s_table.".id';
		theButton".$rel->s_table."_id.onclick = cp_myentry;
		theButton".$rel->s_table."_id.className = 'ed_button2';
		theButton".$rel->s_table."_id.style.backgroundImage = \"url(".plugins_url('custom-tables/img/fade-butt4.png').")\";
		theButton".$rel->s_table."_id.title = '".$rel->s_table."_id';
		theButton".$rel->s_table."_id.id = '".$vorid.$rel->s_table."_id';
		wct_toolbar.appendChild(theButton".$rel->s_table."_id);\n";
		
						$feldoutput .= "
		var theButton".$rel->s_table."_rel = document.createElement('input');
		theButton".$rel->s_table."_rel.type = 'button';
		theButton".$rel->s_table."_rel.name = 'wctable id=\"".$rel->s_table."\" filter=\"`".$rel->s_table."`.`".$rel->s_field."`=\\'{".$rel->t_field."}\\'\"';
		theButton".$rel->s_table."_rel.value = 'Rel ".$tableid.".".$rel->t_field." <= ".$rel->s_table.".".$rel->s_field."';
		theButton".$rel->s_table."_rel.onclick = cp_myentryZ;
		theButton".$rel->s_table."_rel.className = 'ed_button2';
		theButton".$rel->s_table."_rel.style.backgroundImage = \"url(".plugins_url('custom-tables/img/fade-butt4.png').")\";
		theButton".$rel->s_table."_rel.title = '".$rel->s_table."_rel';
		theButton".$rel->s_table."_rel.id = '".$vorid.$rel->s_table."_rel';
		wct_toolbar.appendChild(theButton".$rel->s_table."_rel);\n";
		
				$table2 = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$rel->s_table."`;");
				$array=array(); foreach($table2 as $member=>$data) { $array[$member]=$data; }
				$tmp = explode("PRIMARY KEY",$array['Create Table']);
				$felder2 = explode(",",str_replace(array(",","8 ,2","' ,'"),array(" ,","8.2","'.'"),$tmp[0]));
				for ($i=3;$felder2[$i] != '';$i++) {
					// Do not show relation fields
					preg_match("/`.*`\s(.*?)\s/",$felder2[$i-1],$re);
					if ($re[1] != "int(12)") {
						$feldoutput .= preg_replace("/`(.*)`\s.*/","var theButton".$rel->s_table."_$1= document.createElement('input');\ntheButton".$rel->s_table."_$1.type = 'button';\ntheButton".$rel->s_table."_$1.value = '".$rel->s_table.".$1';\ntheButton".$rel->s_table."_$1.onclick = cp_myentry;\ntheButton".$rel->s_table."_$1.className = 'ed_button2';\ntheButton".$rel->s_table."_$1.style.backgroundImage = \"url(".plugins_url('custom-tables/img/fade-butt4.png').")\";\ntheButton".$rel->s_table."_$1.title = '".$rel->s_table."_$1';\ntheButton.id = 'cp_".$rel->s_table."_$1';\nwct_toolbar.appendChild(theButton".$rel->s_table."_$1);\n",$felder2[$i-1]);
					}
				}

			}		
		}

	}
	else {
		$felder = array('author','date','title','content','comment_count');
		foreach ($felder as $feld) {
			$feldoutput .= "var theButton".$feld." = document.createElement('input');\ntheButton".$feld.".type = 'button';\ntheButton".$feld.".value = '".$feld."';\ntheButton".$feld.".onclick = cp_myentry;\ntheButton".$feld.".className = 'ed_button2';\ntheButton$1.style.backgroundImage = \"url(".plugins_url('custom-tables/img/fade-butt.png').")\";\ntheButton".$feld.".title = '".$feld."';\ntheButton".$feld.".id = 'cp_".$feld."';\nwct_toolbar.appendChild(theButton".$feld.");\n";
		}
	}
	echo $feldoutput;
}


echo "
function cp_myentry(querystr) {
	var myField = document.getElementById(\"content\");
	var myInhalt = this.value;

	if (document.selection) {
		myField.focus();
		var sel = document.selection.createRange();
		sel.text +=  \"{\" + myInhalt + \"}\";
		myField.focus();
	}
	else if (myField.selectionStart || myField.selectionStart == '0') {
		var startPos = myField.selectionStart, endPos = myField.selectionEnd, cursorPos = endPos, scrollTop = myField.scrollTop;

		if (startPos != endPos) {
			myField.value = myField.value.substring(0, startPos)
		              + myField.value.substring(startPos, endPos)
		              + \"{\" + myInhalt + \"}\"
		              + myField.value.substring(endPos, myField.value.length);
			cursorPos += edButtons[i].tagStart.length + edButtons[i].tagEnd.length;
		}
		else {

			myField.value = myField.value.substring(0, startPos)
		              + \"{\" + myInhalt + \"}\"
			       + myField.value.substring(endPos, myField.value.length);
			cursorPos = startPos + edButtons[i].tagStart.length;
		}
		myField.focus();
		myField.selectionStart = cursorPos;
		myField.selectionEnd = cursorPos;
		myField.scrollTop = scrollTop;
	}
	else {
		myField.value += \"{\" + myInhalt + \"}\";
		myField.focus();
	}
}
function cp_myentryB(querystr) {
	var myField = document.getElementById(\"content\");
	var myInhalt = this.value;

	if (document.selection) {
		myField.focus();
		var sel = document.selection.createRange();
		sel.text +=  \"<td></td>\";
		myField.focus();
	}
	else if (myField.selectionStart || myField.selectionStart == '0') {
		var startPos = myField.selectionStart, endPos = myField.selectionEnd, cursorPos = endPos, scrollTop = myField.scrollTop;

		if (startPos != endPos) {
			myField.value = myField.value.substring(0, startPos)
		              + myField.value.substring(startPos, endPos)
		              + \"<td></td>\"
		              + myField.value.substring(endPos, myField.value.length);
			cursorPos += edButtons[i].tagStart.length + edButtons[i].tagEnd.length;
		}
		else {

			myField.value = myField.value.substring(0, startPos)
		              + \"<td></td>\"
			       + myField.value.substring(endPos, myField.value.length);
			cursorPos = startPos + edButtons[i].tagStart.length;
		}
		myField.focus();
		myField.selectionStart = cursorPos;
		myField.selectionEnd = cursorPos;
		myField.scrollTop = scrollTop;
	}
	else {
		myField.value += \"<td></td>\";
		myField.focus();
	}
}
function cp_myentryZ(querystr) {
	var myField = document.getElementById(\"content\");
	var myInhalt = this.name;

	if (document.selection) {
		myField.focus();
		var sel = document.selection.createRange();
		sel.text +=  \"[\" + myInhalt + \"]\";
		myField.focus();
	}
	else if (myField.selectionStart || myField.selectionStart == '0') {
		var startPos = myField.selectionStart, endPos = myField.selectionEnd, cursorPos = endPos, scrollTop = myField.scrollTop;

		if (startPos != endPos) {
			myField.value = myField.value.substring(0, startPos)
		              + myField.value.substring(startPos, endPos)
		              + \"[\" + myInhalt + \"]\"
		              + myField.value.substring(endPos, myField.value.length);
			cursorPos += edButtons[i].tagStart.length + edButtons[i].tagEnd.length;
		}
		else {

			myField.value = myField.value.substring(0, startPos)
		              + \"[\" + myInhalt + \"]\"
			       + myField.value.substring(endPos, myField.value.length);
			cursorPos = startPos + edButtons[i].tagStart.length;
		}
		myField.focus();
		myField.selectionStart = cursorPos;
		myField.selectionEnd = cursorPos;
		myField.scrollTop = scrollTop;
	}
	else {
		myField.value += \"[\" + myInhalt + \"]\";
		myField.focus();
	}
}
function cp_myentryC(querystr) {
	var myField = document.getElementById(\"content\");
	var myInhalt = this.value;

	if (document.selection) {
		myField.focus();
		var sel = document.selection.createRange();
		sel.text +=  \"[\" + myInhalt + \"]\";
		myField.focus();
	}
	else if (myField.selectionStart || myField.selectionStart == '0') {
		var startPos = myField.selectionStart, endPos = myField.selectionEnd, cursorPos = endPos, scrollTop = myField.scrollTop;

		if (startPos != endPos) {
			myField.value = myField.value.substring(0, startPos)
		              + myField.value.substring(startPos, endPos)
		              + \"[\" + myInhalt + \"]\"
		              + myField.value.substring(endPos, myField.value.length);
			cursorPos += edButtons[i].tagStart.length + edButtons[i].tagEnd.length;
		}
		else {

			myField.value = myField.value.substring(0, startPos)
		              + \"[\" + myInhalt + \"]\"
			       + myField.value.substring(endPos, myField.value.length);
			cursorPos = startPos + edButtons[i].tagStart.length;
		}
		myField.focus();
		myField.selectionStart = cursorPos;
		myField.selectionEnd = cursorPos;
		myField.scrollTop = scrollTop;
	}
	else {
		myField.value += \"[\" + myInhalt + \"]\";
		myField.focus();
	}
}
function cp_myentryD(querystr) {
	var myField = document.getElementById(\"content\");
	var myInhalt = this.value;
	if (myInhalt == \"if\") { var myField2 = 'if field=\"\" check=\"==\" var=\"\" else=\"\"'; }
	else { var myField2 = myInhalt; }

	if (document.selection) {
		myField.focus();
		var sel = document.selection.createRange();
		sel.text +=  \"[\" + myInhalt + \"][/\" + myInhalt + \"]\";
		myField.focus();
	}
	else if (myField.selectionStart || myField.selectionStart == '0') {
		var startPos = myField.selectionStart, endPos = myField.selectionEnd, cursorPos = endPos, scrollTop = myField.scrollTop;

		if (startPos != endPos) {
			myField.value = myField.value.substring(0, startPos) + \"[\" + myField2 + \"]\"
		              + myField.value.substring(startPos, endPos)
		              + \"[/\" + myInhalt + \"]\"
		              + myField.value.substring(endPos, myField.value.length);
			cursorPos += edButtons[i].tagStart.length + edButtons[i].tagEnd.length;
		}
		else {
			myField.value = myField.value.substring(0, startPos)
		              + \"[\" + myField2 + \"][/\" + myInhalt + \"]\"
			       + myField.value.substring(endPos, myField.value.length);
			cursorPos = startPos + edButtons[i].tagStart.length;
		}
		myField.focus();
		myField.selectionStart = cursorPos;
		myField.selectionEnd = cursorPos;
		myField.scrollTop = scrollTop;
	}
	else {
		myField.value += \"[\" + myField2 + \"][/\" + myInhalt + \"]\";
		myField.focus();
	}
}
function cp_myentryE(querystr) {
	var myField = document.getElementById(\"content\");
	var myInhalt = this.value;
	if (myInhalt == \"if\") { var myField2 = 'if field=\"\" check=\"==\" var=\"\" else=\"\"'; }
	else { var myField2 = myInhalt; }

	if (document.selection) {
		myField.focus();
		var sel = document.selection.createRange();
		sel.text +=  \"[wctphp]echo strftime(\\\"%A, %d.%m.%Y\\\",'{putheretimefield}');[/wctphp]\";
		myField.focus();
	}
	else if (myField.selectionStart || myField.selectionStart == '0') {
		var startPos = myField.selectionStart, endPos = myField.selectionEnd, cursorPos = endPos, scrollTop = myField.scrollTop;

		if (startPos != endPos) {
			myField.value = myField.value.substring(0, startPos) + \"[wctphp]echo strftime(\\\"%A, %d.%m.%Y\\\",'\"
		              + myField.value.substring(startPos, endPos)
		              + \"');[/wctphp]\"
		              + myField.value.substring(endPos, myField.value.length);
			cursorPos += edButtons[i].tagStart.length + edButtons[i].tagEnd.length;
		}
		else {
			myField.value = myField.value.substring(0, startPos)
		              + \"[wctphp]echo strftime(\\\"%A, %d.%m.%Y\\\",'{putheretimefield}');[/wctphp]\"
			       + myField.value.substring(endPos, myField.value.length);
			cursorPos = startPos + edButtons[i].tagStart.length;
		}
		myField.focus();
		myField.selectionStart = cursorPos;
		myField.selectionEnd = cursorPos;
		myField.scrollTop = scrollTop;
	}
	else {
		myField.value += \"[wctphp]echo strftime(\\\"%A, %d.%m.%Y\\\",'{putheretimefield}');[/wctphp]\";
		myField.focus();
	}
}";

if (get_bloginfo('version','raw') >= '3.3') {
	echo "}
	setTimeout('startnow()',500);";
}

echo "
</script>";
?>