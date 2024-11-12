<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historia lotów kosmicznych</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<header>
    <div class="container">
        <div class="logo">
            <span id="logoText"><span class="highlight">Historia</span> lotów kosmicznych</span>
        </div>

        <nav>
            <ul>
                <li><a href="<?php echo BASE_URL; ?>/index.php">Strona główna</a></li>
                <li><a href="<?php echo BASE_URL; ?>/index.php?page=poczatek">Początek wyścigu kosmicznego</a></li>
                <li><a href="<?php echo BASE_URL; ?>/index.php?page=ladowanie">Lądowanie na Księżycu</a></li>
                <li><a href="<?php echo BASE_URL; ?>/index.php?page=era">Era wahadłowców</a></li>
                <li><a href="<?php echo BASE_URL; ?>/index.php?page=iss">ISS</a></li>
                <li><a href="<?php echo BASE_URL; ?>/index.php?page=przyszle">Przyszłe misje</a></li>
                <li><a href="<?php echo BASE_URL; ?>/index.php?page=filmy">Filmy</a></li>
            </ul>
        </nav>
    </div>
</header>

<button id="darkModeToggle">Dark</button>
<div id="clock"></div>