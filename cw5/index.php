<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
ini_set('display_errors', 1);
session_start();

require_once 'includes/config.php';

$page = $_GET['page'] ?? 'home';

$allowed_pages = ['home', 'poczatek', 'ladowanie', 'era', 'iss', 'przyszle', 'filmy'];
$page = in_array($page, $allowed_pages) ? $page : 'home';

require_once 'includes/header.php';

require_once "templates/$page.php";

require_once 'includes/footer.php';

$nr_indexu = '164356';
$nrGrupy = 'ISI 1';

echo 'Autor asdawd ' .$nr_indexu. 'grupa ' .$nrGrupy.' <br/><br/>';