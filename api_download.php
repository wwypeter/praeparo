<?php
// BREMSE: Verzögert JEDE Anfrage um 1 Sekunde -> Schutz gegen Brute Force
sleep(1);

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
        'message' => 'Nicht eingeloggt. Bitte zuerst einloggen.'
    ]);
    exit;
}

// POST-Daten prüfen
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Nur POST erlaubt']);
    exit;
}

// JSON-Input lesen
$input = json_decode(file_get_contents('php://input'), true);
$fileId = trim($input['file_id'] ?? '');
$password = trim($input['password'] ?? '');

// Prüfen, ob Datei existiert (Whitelist-Check)
if (!isset($pdfPasswords[$fileId]) || !isset($pdfFiles[$fileId])) {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Datei nicht gefunden']);
    exit;
}

// Passwort prüfen (Klartext-Vergleich)
if ($password === $pdfPasswords[$fileId]) {
    // Passwort korrekt - Datei ausliefern
    $filepath = $pdfFiles[$fileId];

    if (!file_exists($filepath)) {
        http_response_code(404);
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Datei existiert nicht auf dem Server']);
        exit;
    }

    // Datei ausliefern
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
    header('Content-Length: ' . filesize($filepath));
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');

    readfile($filepath);
    exit;
} else {
    // Falsches Passwort
    http_response_code(401);
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Falsches Passwort']);
}
?>