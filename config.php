<?php
// Sicherheit: Direkten Zugriff verhindern
if (!defined('ACCESS_ALLOWED')) {
    http_response_code(403);
    die('Zugriff verweigert');
}

// ═══════════════════════════════════════════════════════════════
// HIER ÄNDERST DU DIE PASSWÖRTER - GANZ EINFACH!
// ═══════════════════════════════════════════════════════════════

// Login-Passwort für die Seite
define('LOGIN_PASSWORD', 'Pflege2025_dloads2');

// PDF-Passwörter (kannst du frei ändern!)
$pdfPasswords = [
    // Erste schriftliche Prüfung - Passwort: Pruefung1_2025
    's1.1' => 'Pruefung1_2025',
    's1.2' => 'Pruefung1_2025',
    's1.3' => 'Pruefung1_2025',
    's1.4' => 'Pruefung1_2025',
    's1.5' => 'Pruefung1_2025',
    's1.6' => 'Pruefung1_2025',
    's1.7' => 'Pruefung1_2025',
    's1.8' => 'Pruefung1_2025',
    's1.9' => 'Pruefung1_2025',
    's1.10' => 'Pruefung1_2025',

    // Zweite schriftliche Prüfung - Passwort: Pruefung2_2025
    's2.1' => 'Pruefung2_2025',
    's2.2' => 'Pruefung2_2025',
    's2.3' => 'Pruefung2_2025',
    's2.4' => 'Pruefung2_2025',
    's2.5' => 'Pruefung2_2025',
    's2.6' => 'Pruefung2_2025',
    's2.7' => 'Pruefung2_2025',
    's2.8' => 'Pruefung2_2025',
    's2.9' => 'Pruefung2_2025',
    's2.10' => 'Pruefung2_2025',

    // Dritte schriftliche Prüfung - Passwort: Pruefung3_2025
    's3.1' => 'Pruefung3_2025',
    's3.2' => 'Pruefung3_2025',
    's3.3' => 'Pruefung3_2025',
    's3.4' => 'Pruefung3_2025',
    's3.5' => 'Pruefung3_2025',
    's3.6' => 'Pruefung3_2025',
    's3.7' => 'Pruefung3_2025',
    's3.8' => 'Pruefung3_2025',
    's3.9' => 'Pruefung3_2025',
    's3.10' => 'Pruefung3_2025',
];

// PDF-Dateipfade (passe die Pfade an deine echten PDFs an!)
$pdfFiles = [
    // Erste schriftliche Prüfung
    's1.1' => 'pdfs/test.pdf',
    's1.2' => 'pdfs/test.pdf',
    's1.3' => 'pdfs/test.pdf',
    's1.4' => 'pdfs/test.pdf',
    's1.5' => 'pdfs/test.pdf',
    's1.6' => 'pdfs/test.pdf',
    's1.7' => 'pdfs/test.pdf',
    's1.8' => 'pdfs/test.pdf',
    's1.9' => 'pdfs/test.pdf',
    's1.10' => 'pdfs/test.pdf',

    // Zweite schriftliche Prüfung
    's2.1' => 'pdfs/test.pdf',
    's2.2' => 'pdfs/test.pdf',
    's2.3' => 'pdfs/test.pdf',
    's2.4' => 'pdfs/test.pdf',
    's2.5' => 'pdfs/test.pdf',
    's2.6' => 'pdfs/test.pdf',
    's2.7' => 'pdfs/test.pdf',
    's2.8' => 'pdfs/test.pdf',
    's2.9' => 'pdfs/test.pdf',
    's2.10' => 'pdfs/test.pdf',

    // Dritte schriftliche Prüfung
    's3.1' => 'pdfs/test.pdf',
    's3.2' => 'pdfs/test.pdf',
    's3.3' => 'pdfs/test.pdf',
    's3.4' => 'pdfs/test.pdf',
    's3.5' => 'pdfs/test.pdf',
    's3.6' => 'pdfs/test.pdf',
    's3.7' => 'pdfs/test.pdf',
    's3.8' => 'pdfs/test.pdf',
    's3.9' => 'pdfs/test.pdf',
    's3.10' => 'pdfs/test.pdf',
];
