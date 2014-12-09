<?php
/*
   Class Name: TinyMCE Editor Class
   Description: Class to bring TinyMCE Editor to the Frontend
   Author: Web Updates KMU
   Author URI: http://blog.murawski.ch/2011/10/wordpress-backend-editor-tinymce-im-frontend-einbinden/
   Version: 1.0.0

   Copyright (c) 2011 web updates kmu <stefan@wuk.ch>
   All rights reserved.

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

if (!class_exists('wuk_tinymce')) {
	class wuk_tinymce {
		var $mce_locale;

		function wuk_tinymce() {
			$this->mce_locale = ( '' == get_locale() ) ? 'en' : strtolower( substr(get_locale(), 0, 2) );
			add_action('template_redirect', array( &$this, 'tinymce_loadCoreJS'));
			add_shortcode('wuktinymce', array(&$this,'timymce_wuk'));
		}

		function tinymce_wuk() {
			extract(shortcode_atts(array('fields' => '', 'html' => '0', 'initArray' => ''), $atts));
			if ($fields != '') {
				$this->tinymce_getInitJS($allefelder,$htmleditor,$initArray);
			}
		}

		function tinymce_getcss() {
			if ($this->tinymce_isGreaterThan('2.8.0')) {
				return get_option('siteurl') . '/wp-includes/js/tinymce/themes/advanced/skins/wp_theme/content.css';
			}
			elseif ($this->tinymce_isGreaterThan('2.5.0')) {
				return get_option('siteurl') . '/wp-includes/js/tinymce/wordpress.css';
			}
			else {
				return get_option('siteurl') . '/wp-includes/js/tinymce/plugins/wordpress/wordpress.css';
			}
		}

		function tinymce_isGreaterThan($ver) {
			global $wp_version;
			if ($wp_version == 'abc') return true;
			list($Cmajor, $Cminor, $Crev) = explode('.', $ver);
			list($major, $minor, $rev) = explode('.', $wp_version);
			if ($major < $Cmajor) return false;
			if ($minor < $Cminor) return false;
			return true;
		}

		function tinymce_loadCoreJS() {
			wp_enqueue_script('tiny_mce', get_option('siteurl') . '/wp-includes/js/tinymce/tiny_mce.js', false, '20081129');
			wp_enqueue_script('tiny_mce_lang', get_option('siteurl') . '/wp-includes/js/tinymce/langs/wp-langs-' . $this->mce_locale . '.js', false, '20081129');
			//wp_deregister_script('comment-reply');
			//wp_enqueue_script( 'comment-reply', get_option('siteurl') . '/wp-content/plugins/' . plugin_basename ( dirname ( __FILE__ ) ) . "/comment-reply.dev.js", false, '20090102');
		}

		function tinymce_getInitJS($wct_elements,$htmlview = '0', $initArray='') {
			if ($wct_elements == '') { return false; }
			if ($initArray == '') {
				if ($htmlview == '1') { $htmlview = ",|,code"; } else { $htmlview = ''; }

				$initArray = array (
					'mode' => 'exact',
					'elements' => $wct_elements,
					'theme' => 'advanced',
					'theme_advanced_buttons1' => 'bold,italic,underline,strikethrough,forecolor,backcolor,|,bullist,numlist,|,outdent,indent,|,removeformat',
					'theme_advanced_buttons2' => 'undo,redo,|,link,unlink,|,hr,sub,sup,|,charmap'.$htmlview,
    					'theme_advanced_buttons3' => '',
					'theme_advanced_toolbar_location' => "top",
					'theme_advanced_toolbar_align' => "left",
					'theme_advanced_statusbar_location' => 'bottom',
					'theme_advanced_resizing' => true,
					'theme_advanced_resize_horizontal' => true,
					'theme_advanced_disable' => '',
					'force_p_newlines' => false,
					'force_br_newlines' => true,
					'forced_root_block' => "p",
					'gecko_spellcheck' => true,
					'skin' => 'default',
					'content_css' => $this->tinymce_getcss(),
					'directionality' => 'ltr',
					'save_callback' => "brstonewline",
					'entity_encoding' => "raw",
					'plugins' => $tinymce_options['plugins'],
					//'extended_valid_elements' => "a[name|href|title],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style],blockquote[cite]",'.$le;
					'language' => $this->mce_locale,
				);
			}
			else {
				$initArray['elements'] = $wct_elements;
			}
   
			$params = array();
			foreach ( $initArray as $k => $v ) { $params[] = $k . ':"' . $v . '"	'; }
			$res = join(',', $params);
			echo "<script type=\"text/javascript\">
				function brstonewline(element_id, html, body) {
					html = html.replace(/<br\\s*\\/>/gi, \"\\n\");
					return html;
				}
				function insertHTML(html) {
					tinyMCE.execCommand(\"mceInsertContent\",false, html);
				}
				tinyMCEPreInit = {
					base : \"". get_option('siteurl') ."/wp-includes/js/tinymce\",
					suffix : \"\",
					query : \"ver=20081129\",
					mceInit : {". $res ."},
					go : function() {
						var t = this, sl = tinymce.ScriptLoader, ln = t.mceInit.language, th = t.mceInit.theme, pl = t.mceInit.plugins;
						sl.markDone(t.base + '/langs/' + ln + '.js');
						sl.markDone(t.base + '/themes/' + th + '/langs/' + ln + '.js');
						sl.markDone(t.base + '/themes/' + th + '/langs/' + ln + '_dlg.js');
						tinymce.each(pl.split(','), function(n) {
							if (n && n.charAt(0) != '-') {
								sl.markDone(t.base + '/plugins/' + n + '/langs/' + ln + '.js');
								sl.markDone(t.base + '/plugins/' + n + '/langs/' + ln + '_dlg.js');
							}
						});
					},
					load_ext : function(url,lang) {
						var sl = tinymce.ScriptLoader;
						sl.markDone(url + '/langs/' + lang + '.js');
						sl.markDone(url + '/langs/' + lang + '_dlg.js');
					}
				};
				var subBtn = document.getElementById(\"submit\");
				if (subBtn != null) {
					subBtn.onclick=function() {
						var inst = tinyMCE.getInstanceById(\"comment\");
						document.getElementById(\"comment\").value = inst.getContent();
						document.getElementById(\"commentform\").submit();
						return false;
					}
				}
				tinyMCEPreInit.go();
				tinyMCE.init(tinyMCEPreInit.mceInit);
			</script>";
		}
	}
	$sss = get_option('wuk_custom_tables');
	if (is_array($sss)) {
		if ($sss['form_serial'] != '') {
			add_action('init', 'wuk_tinymce1');
			function wuk_tinymce1() {
				global $wuk_tinymce;
				$wuk_tinymce = new wuk_tinymce();
			}
		}
	}
}

?>