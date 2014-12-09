<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL ayarları - Bu bilgileri sunucunuzdan alabilirsiniz ** //
/** WordPress için kullanılacak veritabanının adı */
define('DB_NAME', 'wordpress');

/** MySQL veritabanı kullanıcısı */
define('DB_USER', 'muzeyyen');

/** MySQL veritabanı parolası */
define('DB_PASSWORD', '333444');

/** MySQL sunucusu */
define('DB_HOST', 'localhost');

/** Yaratılacak tablolar için veritabanı karakter seti. */
define('DB_CHARSET', 'utf8');

/** Veritabanı karşılaştırma tipi. Herhangi bir şüpheniz varsa bu değeri değiştirmeyin. */
define('DB_COLLATE', '');

/**#@+
 * Eşsiz doğrulama anahtarları.
 *
 * Her anahtar farklı bir karakter kümesi olmalı!
 * {@link http://api.wordpress.org/secret-key/1.1/salt WordPress.org secret-key service} servisini kullanarak yaratabilirsiniz.
 * Çerezleri geçersiz kılmak için istediğiniz zaman bu değerleri değiştirebilirsiniz. Bu tüm kullanıcıların tekrar giriş yapmasını gerektirecektir.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'RNfVOM!Cy4^=J-`}%L@Wf*&p9d^A$1Q f#?qbgWn>sH5Rs;lrc,!B1(Ft+U7MMoQ');
define('SECURE_AUTH_KEY',  'v]B1X&IdqxIvwhd=CZ`B#qs)-ky*0jTK-!--ZIoE[A0$ 9kkg]~we3>Hy0-R$Q2t');
define('LOGGED_IN_KEY',    '2@d9>h5HFZ#]`k%2r0mmft:B5wEjkF!vZnSO1>be`#;^yXyu*?enNIGM~}RgS|LW');
define('NONCE_KEY',        'SN&A&WWd@ ~K =N!i]7+E~ha_%32Msc4s8wIAX]0}]0=Fw4s2:MJnDVpE^rem,am');
define('AUTH_SALT',        ')K_9z-rmb4ImgCBj3]qs wWSz_UqwwQX|J4w~<34A?^nQc)qKs{Nb!VUdV[hU}PD');
define('SECURE_AUTH_SALT', 'LNR+WJJbT_ W2kkGxfoW3L}5%RXJ?+w]QCtJ2rKp8|m:Sm[#aen3?q4xFx6wsxij');
define('LOGGED_IN_SALT',   '@Wo:|Ni+^aKbwG%T:[LWngJ_{>aM6, 1|?2!3^N2I[YdioQp]9_VWJ:b0Ye ;@)z');
define('NONCE_SALT',       'U:B+-{uj[`M*OXk`.Q;nuKy-#)/`^U&`>>jio-2X(^&l[5hjsgZ_qx:]OH:x!_Xv');
/**#@-*/

/**
 * WordPress veritabanı tablo ön eki.
 *
 * Tüm kurulumlara ayrı bir önek vererek bir veritabanına birden fazla kurulum yapabilirsiniz.
 * Sadece rakamlar, harfler ve alt çizgi lütfen.
 */
$table_prefix  = 'wp_';

/**
 * WordPress yerel dil dosyası, varsayılan ingilizce.
 *
 * Bu değeri değiştirmenize gerek yok! Zaten Türkçe'ye ayarlı.
 * tr_TR.mo Türkçe dil dosyasının wp-content/languages dizini altında olduğundan emin olun.
 * Türkçe çeviri hakkında öneri ve eleştirilerinizi iletisim@wordpress-tr.com adresine iletebilirsiniz.
 *
 */
define('WPLANG', 'tr_TR');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* Hepsi bu kadar. Mutlu bloglamalar! */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
