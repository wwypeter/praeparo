<?php
// Session starten
session_start();

// Konfiguration laden
define('ACCESS_ALLOWED', true);
require_once 'config.php';

// Header für JSON-Antwort
header('Content-Type: application/json');

// Rate-Limiting prüfen
$ip = $_SERVER['REMOTE_ADDR'];
$sessionKey = 'login_attempts_' . md5($ip);
$timeKey = 'login_first_attempt_' . md5($ip);

// Alte Versuche zurücksetzen, wenn Timeout abgelaufen
if (isset($_SESSION[$timeKey]) && (time() - $_SESSION[$timeKey]) > LOGIN_TIMEOUT) {
    unset($_SESSION[$sessionKey]);
    unset($_SESSION[$timeKey]);
}

// Prüfen, ob zu viele Versuche
if (isset($_SESSION[$sessionKey]) && $_SESSION[$sessionKey] >= MAX_LOGIN_ATTEMPTS) {
    $remainingTime = LOGIN_TIMEOUT - (time() - $_SESSION[$timeKey]);
    http_response_code(429);
    echo json_encode([
        'success' => false,
        'message' => 'Zu viele Anmeldeversuche. Bitte warten Sie ' . ceil($remainingTime / 60) . ' Minuten.',
        'remaining_time' => $remainingTime
    ]);
    exit;
}

// POST-Daten validieren
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Nur POST-Anfragen erlaubt'
    ]);
    exit;
}

// JSON-Input lesen
$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['password']) || empty(trim($input['password']))) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Passwort erforderlich'
    ]);
    exit;
}

$password = trim($input['password']);

// Passwort prüfen
if (password_verify($password, MAIN_PASSWORD_HASH)) {
    // Erfolgreicher Login
    $_SESSION['authenticated'] = true;
    $_SESSION['auth_time'] = time();

    // Login-Versuche zurücksetzen
    unset($_SESSION[$sessionKey]);
    unset($_SESSION[$timeKey]);

    echo json_encode([
        'success' => true,
        'message' => 'Login erfolgreich'
    ]);
} else {
    // Fehlgeschlagener Login
    if (!isset($_SESSION[$sessionKey])) {
        $_SESSION[$sessionKey] = 0;
        $_SESSION[$timeKey] = time();
    }
    $_SESSION[$sessionKey]++;

    $remainingAttempts = MAX_LOGIN_ATTEMPTS - $_SESSION[$sessionKey];

    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Falsches Passwort',
        'remaining_attempts' => max(0, $remainingAttempts)
    ]);
}
