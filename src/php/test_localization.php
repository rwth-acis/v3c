<?php
// I18N support information here

// define constants
define('PROJECT_DIR', realpath('./'));
define('LOCALE_DIR', '../../locale');
define('DEFAULT_LOCALE', 'en');

require_once('../../../php-gettext-1.0.12/php-gettext-1.0.12/gettext.inc');

$encoding = 'UTF-8';

$locale = (isset($_GET['lang']))? $_GET['lang'] : DEFAULT_LOCALE;

//var_dump($locale);die();

// gettext setup
T_setlocale(LC_MESSAGES, $locale);
// Set the text domain as 'messages'
$domain = 'default';
bindtextdomain($domain, LOCALE_DIR);
// bind_textdomain_codeset is supported only in PHP 4.2.0+
if (function_exists('bind_textdomain_codeset'))
    bind_textdomain_codeset($domain, $encoding);
textdomain($domain);

echo gettext("HELLO_WORLD");

?>
