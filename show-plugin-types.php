<?php
define('CLI_SCRIPT', true);
require('config.php');

$pluginman = core_plugin_manager::instance();

foreach ($pluginman->get_plugin_types() as $type => $dir) {
    $dir = substr($dir, strlen($CFG->dirroot));
    printf("%-20s %-50s %s".PHP_EOL, $type, $pluginman->plugintype_name_plural($type), $dir);
}