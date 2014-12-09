<div id="support_container">
    <?php
    if (!$_POST['request_type']) {
		include($this->wctpath."/pages/support/select.php");
    }
	elseif ($_POST['formsubm']) {
		if ($_POST['name'] != '') {
			$headers = "From: ".str_replace(array("\n","\r"),"",$_POST['name'])." <".get_option( 'admin_email' ).">\r\n";
		}
		$multiple_to_recipients = array('ticket@wuk.ch',get_option( 'admin_email' ));
		
		
		if ($this->prem_chk() == true) {
			$t = "pre";$p = "ch";$t = $t."m_".$p."k";$t = $this->$t('',1);
			$data = $this->http_request('POST','http://api.wuk.ch/wct-premium.php',"serial=".trim($t[1]."-".$t[2]."-".$t[3])."&dom=".$_SERVER['SERVER_NAME']);
			
			if (strpos($data,"|") !== false) {
				$key = "illegal fey found: '".$t[1]."-".$t[2]."-".$t[3]."-".$t[4]."'";
			}
			else {
				$key = "valid key found (Salt: '".md5("wct-".$t[2].$t[3])."')";
			}
		}
		else {
			$key;
		}
	
		foreach ($_POST as $var => $wert) {
			if ($var != 'description' AND $var != 'formsubm') {
				$content .= $var." => ".$wert."\r\n";
			}
		}
	
		wp_mail(
			$multiple_to_recipients,
			$_POST['subject'],
			($key != '' ? "Serial: ".$key."--------------------------------------\r\n" : "").$content."--------------------------------------\r\nDescription => ".$_POST['description'],
			$headers
			);
			
		echo "<h2>".__('Request submitted')."</h2>".__('Request has been submitted sucessfully.','wct');
		
		if ($_POST['paypal'] != '') {
			wp_mail(
				'stefan@wuk.ch',
				"Premium Request - ". $_POST['subject'],
				"PayPal Transaction ID: ".$_POST['paypal']."\r\nSerial: ".$key."\r\n--------------------------------------\r\n".
				$content."--------------------------------------\r\nDescription => ".$_POST['description'],
				$headers
			);
			
			echo "<br/><br/>";
			printf(__('If you dont receive an response in the <b>next 2 workingdays</b>, please send me a mail to %s with the PayPal Transaction ID.','wct'),'<a href="mailto:stefan@wuk.ch">stefan@wuk.ch</a>');
		}
	}
	else {
		include($this->wctpath."/pages/support/form.php");			
    }
	?>
</div>