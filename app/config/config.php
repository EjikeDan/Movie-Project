<?php

define('ENVIRONMENT', 'development');
if (ENVIRONMENT == 'development' || ENVIRONMENT == 'dev') {
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}

defined('ROOT_PATH') || define('ROOT_PATH', realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR));
define('URL_PUBLIC_FOLDER', '');
define('URL_PROTOCOL', '//');
define('URL_DOMAIN', $_SERVER['HTTP_HOST']);
define('URL_SUB_FOLDER', str_replace(URL_PUBLIC_FOLDER, '', dirname($_SERVER['SCRIPT_NAME'])));
define('URL', URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER);

define('DB_HOST', 'localhost');
define('DB_NAME', 'movies_db');
define('DB_USER', 'postgres');
define('DB_PASS', 'Agkdandozie1$');
define('DB_PORT', '5432');