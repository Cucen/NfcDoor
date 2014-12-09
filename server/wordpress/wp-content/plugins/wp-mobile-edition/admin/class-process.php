<?php
class FDX_Process_2 extends WP_Mobile_Edition_Admin {

function __construct() {
              if (isset( $_POST['fdx_page_2']) ) {
			  add_filter('init', array( $this, 'fdx_update_post_settings') );
              }
}


/*
 * Executes appropriate process function based on post variable
 */
function fdx_update_post_settings() {
		   switch ( $_POST['fdx_page_2'] ) {
                    case 'fdx_form_all_2':
					$this->fdx_process_all();
    				break;

                    case 'fdx_reset_2':
				    update_option( 'fdx_settings_2', false );
					break;

                    case 'hide_message_2':
				    # Hide message for 15 days
                    $time = time() + 10 * 24 * 60 * 60;
                    update_option('fdx1_hidden_time_2', $time );
					break;
    }
}

/*
 * Process All
 */
function fdx_process_all(){
//----------Select theme
            if ( isset( $_POST['p3_sel1'] ) ) {
        	$settings['p3_sel1'] = $_POST['p3_sel1'];
            }

//----------
            if ( isset( $_POST['p3_check_1'] ) ) {
				$settings['p3_check_1'] = true;
			} else {
				$settings['p3_check_1'] = false;
			}
            if ( isset( $_POST['p3_check_2'] ) ) {
				$settings['p3_check_2'] = true;
			} else {
				$settings['p3_check_2'] = false;
			}
//----------top menu
            if ( isset( $_POST['p3_check_t1'] ) ) {
				$settings['p3_check_t1'] = true;
			} else {
				$settings['p3_check_t1'] = false;
			}
            if ( isset( $_POST['p3_check_t2'] ) ) {
				$settings['p3_check_t2'] = true;
			} else {
				$settings['p3_check_t2'] = false;
			}
            if ( isset( $_POST['p3_check_t3'] ) ) {
				$settings['p3_check_t3'] = true;
			} else {
				$settings['p3_check_t3'] = false;
			}
            if ( isset( $_POST['p3_check_t4'] ) ) {
				$settings['p3_check_t4'] = true;
			} else {
				$settings['p3_check_t4'] = false;
			}
            if ( isset( $_POST['p3_check_t5'] ) ) {
				$settings['p3_check_t5'] = true;
			} else {
				$settings['p3_check_t5'] = false;
			}

//----------
            if ( isset( $_POST['p3_rad1'] ) ) {
        	$settings['p3_rad1'] = $_POST['p3_rad1'];
            }
//----------
            if ( isset($_POST['p3_txt1']) ) {
			   $settings['p3_txt1'] = stripslashes($_POST['p3_txt1']);
	  		}
            if ( isset($_POST['p3_txt2']) ) {
			   $settings['p3_txt2'] = stripslashes($_POST['p3_txt2']);
	  		}
            if ( isset($_POST['p3_txt3']) ) {
			   $settings['p3_txt3'] = stripslashes($_POST['p3_txt3']);
	  		}
            if ( isset($_POST['p3_txt4']) ) {
			   $settings['p3_txt4'] = stripslashes($_POST['p3_txt4']);
	  		}
            if ( isset($_POST['p3_txt5']) ) {
			   $settings['p3_txt5'] = stripslashes($_POST['p3_txt5']);
	  		}
            if ( isset($_POST['p3_txt6']) ) {
			   $settings['p3_txt6'] = stripslashes($_POST['p3_txt6']);
	  		}
//----------textarea
            if ( isset($_POST['p3_tex1']) ) {
			   $settings['p3_tex1'] = stripslashes($_POST['p3_tex1']);
	  		}
            if ( isset($_POST['p3_tex2']) ) {
			   $settings['p3_tex2'] = stripslashes($_POST['p3_tex2']);
	  		}
            if ( isset($_POST['p3_tex3']) ) {
			   $settings['p3_tex3'] = stripslashes($_POST['p3_tex3']);
	  		}
            if ( isset($_POST['p3_tex4']) ) {
			   $settings['p3_tex4'] = stripslashes($_POST['p3_tex4']);
	  		}
//----------
            if ( isset($_POST['p3_opl1']) ) {
			   $settings['p3_opl1'] = stripslashes($_POST['p3_opl1']);
	  		}
            if ( isset($_POST['p3_opl2']) ) {
			   $settings['p3_opl2'] = stripslashes($_POST['p3_opl2']);
	  		}
            if ( isset($_POST['p3_opl3']) ) {
			   $settings['p3_opl3'] = stripslashes($_POST['p3_opl3']);
	  		}
            if ( isset($_POST['p3_opl4']) ) {
			   $settings['p3_opl4'] = stripslashes($_POST['p3_opl4']);
	  		}
            if ( isset($_POST['p3_opl5']) ) {
			   $settings['p3_opl5'] = stripslashes($_POST['p3_opl5']);
	  		}



update_option( 'fdx_settings_2', $settings );
}


}

/* End of file class-process.php */
/* Location: ./admin/class-process.php */

