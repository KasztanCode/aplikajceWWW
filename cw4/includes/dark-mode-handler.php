<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $darkMode = isset($_POST['darkMode']) && $_POST['darkMode'] === 'true';
    setcookie('darkMode', $darkMode ? 'enabled' : 'disabled', time() + (86400 * 365), '/');
    echo json_encode(['success' => true, 'darkMode' => $darkMode]);
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}