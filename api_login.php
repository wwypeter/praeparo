<?php
// Session starten
session_start();

// Konfiguration laden
define('ACCESS_ALLOWED', true);
require_once 'config.php';

// Header für JSON-Antwort
header('Content-Type: application/json');

// POST-Daten prüfen
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Nur POST erlaubt']);
    exit;
}

// JSON-Input lesen
$input = json_decode(file_get_contents('php://input'), true);
$password = trim($input['password'] ?? '');

// Passwort prüfen (EINFACH!)
if ($password === LOGIN_PASSWORD) {
    // Login erfolgreich
    $_SESSION['authenticated'] = true;
    $_SESSION['auth_time'] = time();

    echo json_encode([
        'success' => true,
        'message' => 'Login erfolgreich'
    ]);
} else {
    // Falsches Passwort
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Falsches Passwort'
    ]);
}
