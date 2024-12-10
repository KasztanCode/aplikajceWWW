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
                <img src="/api/placeholder/1200/600" alt="Obraz kosmosu" class="hero-image">
                <p>Poznaj fascynującą historię eksploracji kosmosu i dowiedz się, jak marzenia o podróżach międzygwiezdnych stały się rzeczywistością.</p>
            </div>
            <div class="section topics">';

    try {
        $query = "SELECT id, page_title, page_content FROM page_list WHERE status = 1 ORDER BY id ASC";
        $result = $db->query($query);

        while ($page = $result->fetch(PDO::FETCH_ASSOC)) {
            $content .= sprintf('
                <div id="page-%d" class="topic-card fade-in">
                    <h3>%s</h3>
                    <img src="/api/placeholder/300/200" alt="%s" class="image">
                    <p>%s</p>
                </div>',
                $page['id'],
                htmlspecialchars($page['page_title']),
                htmlspecialchars($page['page_title']),
                htmlspecialchars(substr(strip_tags($page['page_content']), 0, 150)) . '...'
            );
        }

    } catch(PDOException $e) {
        $content .= '<p>Error loading content</p>';
    }

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

echo 'Autor asdawd ' .$nr_indexu. 'grupa ' .$nrGrupy.' <br/><br/>';
?>