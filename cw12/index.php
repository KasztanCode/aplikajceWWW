<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
ini_set('display_errors', 1);
session_start();

require_once 'includes/cfg.php';
require_once 'showpage.php';
//Pobiera i formatuje zawartość strony głównej
//Wyświetla aktywne podstrony
function getHomepageContent() {
    global $db;

    $content = '<div class="container">
        <div class="main-content" role="main">
            <div id="home" class="section hero fade-in">
                <h1>Odkrywanie kosmosu: Podróż ludzkości ku gwiazdom</h1>
                <img src="https://t3.ftcdn.net/jpg/02/12/39/04/360_F_212390498_x7mQiUVPrOCF9YW8MHHkWxRKFUL56G3t.jpg" alt="Obraz kosmosu" class="hero-image">
                <p>Poznaj fascynującą historię eksploracji kosmosu i dowiedz się, jak marzenia o podróżach międzygwiezdnych stały się rzeczywistością.</p>
            </div>
            <div class="section topics">';



    $content .= '</div></div></div>';
    return $content;
}

$pageId = $_GET['id'] ?? 1;

require_once 'includes/header.php';

if ($pageId == 1) {
    echo getHomepageContent();
} else {
    echo PokazPodstrone($pageId);
}

require_once 'includes/footer.php';

$nr_indexu = '164356';
$nrGrupy = 'ISI 1';
?>