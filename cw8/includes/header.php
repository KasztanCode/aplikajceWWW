<?php require_once 'includes/cfg.php'; ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historia lotów kosmicznych</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/script.js"></script>
</head>
<body>
<header>
    <div class="container">
        <div class="logo">
            <span id="logoText"><span class="highlight">Historia</span> lotów kosmicznych</span>
        </div>

        <nav class="dropdown-nav">
            <ul class="nav-list">
                <?php
                try {
                    $query = "SELECT * FROM page_list WHERE status = 1 ORDER BY id ASC";
                    $result = $db->query($query);
                    while ($page = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo '<li><a href="' . BASE_URL . '/index.php?id=' . $page['id'] . '">' .
                             htmlspecialchars($page['page_title']) . '</a></li>';
                    }
                } catch(PDOException $e) {
                    echo '<li><a href="#">Error loading menu</a></li>';
                }
                ?>
            </ul>
        </nav>
    </div>
</header>

<button id="darkModeToggle">Dark</button>
<div id="clock"></div>
