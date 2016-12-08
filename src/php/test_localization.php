<?php
if (!function_exists("gettext"))
{
    echo "not installed\n";
}
else
{
    echo "installed\n";
}
/*
$language = "de";
echo "Language:".$language;
#putenv("LANG=".$language);
putenv("LC_ALL=".$language);
setlocale(LC_ALL, $language);

$domain = "messages";
#bindtextdomain($domain, "Locale");
#textdomain($domain);
bindtextdomain('default', 'C:\Users\Sabine\Documents\Uni\Master\Kurse\03_HENM\workspace\v3c\Locale');
textdomain('default');

echo "Test:\n";
echo gettext("This is a text string!");
echo "\n end\n";
echo "test2: ";
echo gettext ("test2_de");

*/

echo ("----------------------");

$locale = 'en';

putenv("LANG=" . $locale); // Linux
putenv("LC_ALL=" . $locale); // windows
setlocale(LC_ALL, $locale);

$domain = 'default';
//bindtextdomain($domain, 'C:\Users\Sabine\Documents\Uni\Master\Kurse\03_HENM\workspace\v3c\locale');
bindtextdomain($domain, '../../locale');
bind_textdomain_codeset($domain, 'UTF-8');
textdomain($domain);

print gettext("test2_de");

?>