<?php
$baseUrl = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$darkMode = isset($_COOKIE['darkMode']) && $_COOKIE['darkMode'] === 'enabled';
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historia lotów kosmicznych - <?php echo ucfirst($_GET['page'] ?? 'Strona główna'); ?></title>
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body<?php echo $darkMode ? ' class="dark-mode"' : ''; ?>>
    <div class="container">
        <div class="logo">
            <span id="logoText"><span class="highlight">Historia</span> lotów kosmicznych</span>
        </div>

        <?php include 'nav.php'; ?>
    </div>

    <button id="darkModeToggle"><?php echo $darkMode ? 'Light' : 'Dark'; ?></button>
    <div id="clock"></div>

    <main>