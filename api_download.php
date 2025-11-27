<?php
// Session starten
session_start();

// Konfiguration laden
define('ACCESS_ALLOWED', true);
require_once 'config.php';

// Prüfen, ob Benutzer eingeloggt ist
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    http_response_code(401);
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Nicht authentifiziert. Bitte zuerst einloggen.'
    ]);
    exit;
}

// Rate-Limiting für Downloads
$ip = $_SERVER['REMOTE_ADDR'];
$sessionKey = 'download_attempts_' . md5($ip);
$timeKey = 'download_first_attempt_' . md5($ip);

// Alte Versuche zurücksetzen, wenn Timeout abgelaufen
if (isset($_SESSION[$timeKey]) && (time() - $_SESSION[$timeKey]) > DOWNLOAD_TIMEOUT) {
    unset($_SESSION[$sessionKey]);
    unset($_SESSION[$timeKey]);
}

// Prüfen, ob zu viele Versuche
if (isset($_SESSION[$sessionKey]) && $_SESSION[$sessionKey] >= MAX_DOWNLOAD_ATTEMPTS) {
    $remainingTime = DOWNLOAD_TIMEOUT - (time() - $_SESSION[$timeKey]);
    http_response_code(429);
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Zu viele fehlgeschlagene Download-Versuche. Bitte warten Sie ' . ceil($remainingTime / 60) . ' Minuten.',
        'remaining_time' => $remainingTime
    ]);
    exit;
}

// POST-Daten validieren
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Nur POST-Anfragen erlaubt'
    ]);
    exit;
}

// JSON-Input lesen
$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['file_id']) || !isset($input['password'])) {
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Datei-ID und Passwort erforderlich'
    ]);
    exit;
}

$fileId = trim($input['file_id']);
$password = trim($input['password']);

// Prüfen, ob Datei existiert
if (!isset($pdfPasswords[$fileId]) || !isset($pdfFiles[$fileId])) {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Datei nicht gefunden'
    ]);
    exit;
}

// Passwort prüfen
if (password_verify($password, $pdfPasswords[$fileId])) {
    // Passwort korrekt - Datei ausliefern
    $filepath = $pdfFiles[$fileId];

    if (!file_exists($filepath)) {
        http_response_code(404);
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => 'Datei existiert nicht auf dem Server'
        ]);
        exit;
    }

    // Download-Versuche zurücksetzen bei Erfolg
    unset($_SESSION[$sessionKey]);
    unset($_SESSION[$timeKey]);

    // Datei ausliefern
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
    header('Content-Length: ' . filesize($filepath));
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');

    // Datei ausgeben
    readfile($filepath);
    exit;
} else {
    // Falsches Passwort
    if (!isset($_SESSION[$sessionKey])) {
        $_SESSION[$sessionKey] = 0;
        $_SESSION[$timeKey] = time();
    }
    $_SESSION[$sessionKey]++;

    $remainingAttempts = MAX_DOWNLOAD_ATTEMPTS - $_SESSION[$sessionKey];

    http_response_code(401);
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Falsches Passwort',
        'remaining_attempts' => max(0, $remainingAttempts)
    ]);
}
