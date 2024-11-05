<?php
session_start();

require_once 'includes/config.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

$allowed_pages = ['home', 'poczatek', 'ladowanie', 'era', 'iss', 'przyszle'];
$page = in_array($page, $allowed_pages) ? $page : 'home';

require_once 'includes/header.php';

require_once "templates/{$page}.php";

require_once 'includes/footer.php';
?>