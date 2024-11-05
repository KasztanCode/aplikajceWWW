<?php
$baseUrl = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historia lotów kosmicznych</title>
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body<?php echo isset($_COOKIE['darkMode']) && $_COOKIE['darkMode'] === 'enabled' ? ' class="dark-mode"' : ''; ?>>
    <header>
        <div class="container">
            <div class="logo">
                <span id="logoText"><span class="highlight">Historia</span> lotów kosmicznych</span>
            </div>

            <nav>
                <ul>
                    <li><a href="<?php echo $baseUrl; ?>/index.php">Strona główna</a></li>
                    <li><a href="<?php echo $baseUrl; ?>/index.php?page=poczatek">Początek wyścigu kosmicznego</a></li>
                    <li><a href="<?php echo $baseUrl; ?>/index.php?page=ladowanie">Lądowanie na Księżycu</a></li>
                    <li><a href="<?php echo $baseUrl; ?>/index.php?page=era">Era wahadłowców</a></li>
                    <li><a href="<?php echo $baseUrl; ?>/index.php?page=iss">ISS</a></li>
                    <li><a href="<?php echo $baseUrl; ?>/index.php?page=przyszle">Przyszłe misje</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <button id="darkModeToggle"><?php echo isset($_COOKIE['darkMode']) && $_COOKIE['darkMode'] === 'enabled' ? 'Light' : 'Dark'; ?></button>
    <div id="clock"></div>