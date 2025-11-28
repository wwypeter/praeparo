<?php
// Sicherheitsmaßnahme: Direkten Zugriff verhindern
if (!defined('ACCESS_ALLOWED')) {
    http_response_code(403);
    die('Zugriff verweigert');
}

// Hauptpasswort für den Zugang zur Seite (gehashed mit password_hash)
// Aktuelles Passwort: "login"
// Um das Passwort zu ändern, führe aus: echo password_hash('deinPasswort', PASSWORD_DEFAULT);
define('MAIN_PASSWORD_HASH', '$2y$10$YQ3vy8Jd5l7xhZ.vN8QhHOxKvJ0TL5VkjJXaXYfGZzCJxKqGWQzK6');

// PDF-Passwörter (gehashed)
// Format: 'dateiname' => 'password_hash'
// Aktuelles Passwort für alle: "test"
$pdfPasswords = [
    // Erste schriftliche Prüfung
    's1.1' => '$2y$10$8F0oYqK9X/jZ5ZpJZX7QO.LMvjQhPzVgKCjYZ5FQZpJYqKjZX7QOu',
    's1.2' => '$2y$10$8F0oYqK9X/jZ5ZpJZX7QO.LMvjQhPzVgKCjYZ5FQZpJYqKjZX7QOu',
    's1.3' => '$2y$10$8F0oYqK9X/jZ5ZpJZX7QO.LMvjQhPzVgKCjYZ5FQZpJYqKjZX7QOu',
    's1.4' => '$2y$10$8F0oYqK9X/jZ5ZpJZX7QO.LMvjQhPzVgKCjYZ5FQZpJYqKjZX7QOu',
    's1.5' => '$2y$10$8F0oYqK9X/jZ5ZpJZX7QO.LMvjQhPzVgKCjYZ5FQZpJYqKjZX7QOu',
    's1.6' => '$2y$10$8F0oYqK9X/jZ5ZpJZX7QO.LMvjQhPzVgKCjYZ5FQZpJYqKjZX7QOu',
    's1.7' => '$2y$10$8F0oYqK9X/jZ5ZpJZX7QO.LMvjQhPzVgKCjYZ5FQZpJYqKjZX7QOu',
    's1.8' => '$2y$10$8F0oYqK9X/jZ5ZpJZX7QO.LMvjQhPzVgKCjYZ5FQZpJYqKjZX7QOu',
    's1.9' => '$2y$10$8F0oYqK9X/jZ5ZpJZX7QO.LMvjQhPzVgKCjYZ5FQZpJYqKjZX7QOu',
    's1.10' => '$2y$10$8F0oYqK9X/jZ5ZpJZX7QO.LMvjQhPzVgKCjYZ5FQZpJYqKjZX7QOu',

    // Zweite schriftliche Prüfung
    's2.1' => '$2y$10$8F0oYqK9X/jZ5ZpJZX7QO.LMvjQhPzVgKCjYZ5FQZpJYqKjZX7QOu',
    's2.2' => '$2y$10$8F0oYqK9X/jZ5ZpJZX7QO.LMvjQhPzVgKCjYZ5FQZpJYqKjZX7QOu',
    's2.3' => '$2y$10$8F0oYqK9X/jZ5ZpJZX7QO.LMvjQhPzVgKCjYZ5FQZpJYqKjZX7QOu',
    's2.4' => '$2y$10$8F0oYqK9X/jZ5ZpJZX7QO.LMvjQhPzVgKCjYZ5FQZpJYqKjZX7QOu',
    's2.5' => '$2y$10$8F0oYqK9X/jZ5ZpJZX7QO.LMvjQhPzVgKCjYZ5FQZpJYqKjZX7QOu',
    's2.6' => '$2y$10$8F0oYqK9X/jZ5ZpJZX7QO.LMvjQhPzVgKCjYZ5FQZpJYqKjZX7QOu',
    's2.7' => '$2y$10$8F0oYqK9X/jZ5ZpJZX7QO.LMvjQhPzVgKCjYZ5FQZpJYqKjZX7QOu',
    's2.8' => '$2y$10$8F0oYqK9X/jZ5ZpJZX7QO.LMvjQhPzVgKCjYZ5FQZpJYqKjZX7QOu',
    's2.9' => '$2y$10$8F0oYqK9X/jZ5ZpJZX7QO.LMvjQhPzVgKCjYZ5FQZpJYqKjZX7QOu',
    's2.10' => '$2y$10$8F0oYqK9X/jZ5ZpJZX7QO.LMvjQhPzVgKCjYZ5FQZpJYqKjZX7QOu',

    // Dritte schriftliche Prüfung
    's3.1' => '$2y$10$8F0oYqK9X/jZ5ZpJZX7QO.LMvjQhPzVgKCjYZ5FQZpJYqKjZX7QOu',
    's3.2' => '$2y$10$8F0oYqK9X/jZ5ZpJZX7QO.LMvjQhPzVgKCjYZ5FQZpJYqKjZX7QOu',
    's3.3' => '$2y$10$8F0oYqK9X/jZ5ZpJZX7QO.LMvjQhPzVgKCjYZ5FQZpJYqKjZX7QOu',
    's3.4' => '$2y$10$8F0oYqK9X/jZ5ZpJZX7QO.LMvjQhPzVgKCjYZ5FQZpJYqKjZX7QOu',
    's3.5' => '$2y$10$8F0oYqK9X/jZ5ZpJZX7QO.LMvjQhPzVgKCjYZ5FQZpJYqKjZX7QOu',
    's3.6' => '$2y$10$8F0oYqK9X/jZ5ZpJZX7QO.LMvjQhPzVgKCjYZ5FQZpJYqKjZX7QOu',
    's3.7' => '$2y$10$8F0oYqK9X/jZ5ZpJZX7QO.LMvjQhPzVgKCjYZ5FQZpJYqKjZX7QOu',
    's3.8' => '$2y$10$8F0oYqK9X/jZ5ZpJZX7QO.LMvjQhPzVgKCjYZ5FQZpJYqKjZX7QOu',
    's3.9' => '$2y$10$8F0oYqK9X/jZ5ZpJZX7QO.LMvjQhPzVgKCjYZ5FQZpJYqKjZX7QOu',
    's3.10' => '$2y$10$8F0oYqK9X/jZ5ZpJZX7QO.LMvjQhPzVgKCjYZ5FQZpJYqKjZX7QOu',
];

// Zuordnung von PDF-IDs zu tatsächlichen Dateipfaden
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

// Rate-Limiting-Konfiguration (Schutz vor Brute-Force)
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_TIMEOUT', 900); // 15 Minuten in Sekunden
define('MAX_DOWNLOAD_ATTEMPTS', 3);
define('DOWNLOAD_TIMEOUT', 300); // 5 Minuten in Sekunden
