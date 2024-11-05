<?php

define('BASE_PATH', dirname(__DIR__));
define('BASE_URL', rtrim(dirname($_SERVER['PHP_SELF']), '/\\'));

error_reporting(E_ALL);
ini_set('display_errors', 1);

date_default_timezone_set('Europe/Warsaw');

ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', isset($_SERVER['HTTPS']));