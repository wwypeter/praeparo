# Sichere Download-Seite - Anleitung

## Übersicht

Die Download-Seite ist jetzt durch ein **zweistufiges Passwort-System** geschützt:

1. **Erstes Passwort**: Zugang zur gesamten Download-Seite
2. **Zweites Passwort**: Individueller Schutz für jede PDF-Datei

Alle Passwörter werden **serverseitig** gespeichert und sind **nicht mehr im Quellcode sichtbar**.

---

## Dateistruktur

```
/praeparo/
├── downloads.html              # Die sichere Download-Seite
├── config.php                  # Passwort-Konfiguration (geschützt)
├── api_login.php              # API für Login-Validierung
├── api_download.php           # API für PDF-Downloads
├── .htaccess                  # Schutz für sensible Dateien
├── generate_password_hash.php # Hilfsskript zum Hashen von Passwörtern
└── pdfs/                      # PDF-Dateien (geschützt)
```

---

## Sicherheitsfeatures

### 1. Passwort-Hashing
- Alle Passwörter werden mit `password_hash()` (bcrypt) gespeichert
- Selbst bei Zugriff auf `config.php` sind die Original-Passwörter nicht sichtbar

### 2. Serverseitige Validierung
- Passwörter werden nur auf dem Server geprüft
- Keine Passwörter im JavaScript-Code

### 3. Rate-Limiting / Brute-Force-Schutz
- **Login**: Max. 5 Versuche, danach 15 Minuten Sperre
- **PDF-Downloads**: Max. 3 Versuche, danach 5 Minuten Sperre

### 4. Direktzugriff-Schutz
- `.htaccess` verhindert direkten Zugriff auf:
  - `config.php`
  - PDF-Dateien im `pdfs/` Verzeichnis
- Downloads nur über `api_download.php` nach Authentifizierung

### 5. Session-Management
- Sichere Session-Konfiguration
- HttpOnly und SameSite Cookies

---

## Passwörter ändern

### Aktuell eingestellte Passwörter

- **Hauptpasswort (Login)**: `login`
- **PDF-Passwörter**: `test` (für alle PDFs)

### Passwörter ändern - Methode 1: Kommandozeile

1. Passwort-Hash generieren:
```bash
php generate_password_hash.php "meinNeuesPasswort"
```

2. Output kopieren, z.B.:
```
Hash: $2y$10$YQ3vy8Jd5l7xhZ.vN8QhHOxKvJ0TL5VkjJXaXYfGZzCJxKqGWQzK6
```

3. In `config.php` einfügen:
   - Für Hauptpasswort: `MAIN_PASSWORD_HASH` ersetzen
   - Für PDF-Passwörter: Hash im `$pdfPasswords` Array ersetzen

### Passwörter ändern - Methode 2: Online

1. PHP-Code direkt ausführen:
```php
<?php
echo password_hash('meinNeuesPasswort', PASSWORD_DEFAULT);
?>
```

2. Hash kopieren und in `config.php` einfügen

---

## Verschiedene Passwörter für PDFs einrichten

In `config.php` kannst du für jede PDF ein individuelles Passwort setzen:

```php
$pdfPasswords = [
    's1.1' => '$2y$10$hash_für_passwort_1',
    's1.2' => '$2y$10$hash_für_passwort_2',
    's1.3' => '$2y$10$hash_für_passwort_3',
    // usw.
];
```

**Beispiel**: Verschiedene Passwörter für verschiedene Prüfungen

```php
// Passwort "pruefung1" für erste Prüfung
's1.1' => '$2y$10$...hash_für_pruefung1...',
's1.2' => '$2y$10$...hash_für_pruefung1...',

// Passwort "pruefung2" für zweite Prüfung
's2.1' => '$2y$10$...hash_für_pruefung2...',
's2.2' => '$2y$10$...hash_für_pruefung2...',
```

---

## PDF-Dateipfade anpassen

In `config.php` im Array `$pdfFiles`:

```php
$pdfFiles = [
    's1.1' => 'pdfs/erste_pruefung_1.pdf',
    's1.2' => 'pdfs/erste_pruefung_2.pdf',
    // usw.
];
```

---

## Neue PDFs hinzufügen

1. PDF-Datei in `pdfs/` hochladen
2. In `config.php` eintragen:
   - Hash in `$pdfPasswords` hinzufügen
   - Dateipfad in `$pdfFiles` hinzufügen
3. In `downloads.html` einen Download-Button hinzufügen:
```html
<div class="download-card" onclick="openPdfModal('s1.11')">
  <h3>s1.11</h3>
  <p>PDF Download</p>
</div>
```

---

## Rate-Limiting anpassen

In `config.php`:

```php
// Login-Limit
define('MAX_LOGIN_ATTEMPTS', 5);     // Max. Versuche
define('LOGIN_TIMEOUT', 900);        // Sperrzeit in Sekunden (15 Min)

// Download-Limit
define('MAX_DOWNLOAD_ATTEMPTS', 3);  // Max. Versuche
define('DOWNLOAD_TIMEOUT', 300);     // Sperrzeit in Sekunden (5 Min)
```

---

## HTTPS aktivieren (empfohlen)

Für maximale Sicherheit sollte die Seite über HTTPS laufen:

1. SSL-Zertifikat installieren (z.B. Let's Encrypt)
2. In `config.php` ändern:
```php
ini_set('session.cookie_secure', 1);  // Von 0 auf 1 ändern
```

---

## Sicherheitshinweise

### ⚠️ Nach der Einrichtung:

1. **Löschen oder verschieben**: `generate_password_hash.php`
2. **Prüfen**: `.htaccess` ist aktiv (Apache-Server erforderlich)
3. **Backup**: `config.php` sicher aufbewahren
4. **Testen**: Alle Funktionen durchgehen

### ✅ Best Practices:

- Starke Passwörter verwenden (min. 12 Zeichen, gemischt)
- Passwörter regelmäßig ändern
- Verschiedene Passwörter für verschiedene PDF-Gruppen
- Server-Logs regelmäßig prüfen
- PHP und Server aktuell halten

---

## Troubleshooting

### Problem: "Zugriff verweigert" beim Öffnen von config.php
✅ **Das ist korrekt!** Die `.htaccess` schützt diese Datei.

### Problem: PDFs werden nicht heruntergeladen
- Prüfen, ob Dateipfad in `config.php` korrekt ist
- Prüfen, ob PDF-Datei existiert
- Browser-Konsole auf Fehler prüfen (F12)

### Problem: "Zu viele Anmeldeversuche"
- 15 Minuten warten (Login) oder 5 Minuten (PDF-Download)
- Oder Session-Daten auf dem Server löschen

### Problem: .htaccess funktioniert nicht
- Prüfen, ob Apache `mod_rewrite` aktiviert ist
- Prüfen, ob `.htaccess` erlaubt ist (`AllowOverride All`)
- Bei Nginx: Andere Konfiguration erforderlich

---

## Server-Anforderungen

- PHP 7.4 oder höher
- Apache-Server mit `.htaccess` Support (oder entsprechende Nginx-Config)
- Schreibrechte für Session-Verzeichnis
- SSL-Zertifikat (empfohlen)

---

## Support

Bei Fragen zur Konfiguration:
1. Browser-Konsole auf Fehler prüfen (F12 → Console)
2. PHP-Fehlerlog prüfen
3. .htaccess temporär deaktivieren zum Testen

**Wichtig**: Speichere deine Passwörter sicher! Bei Verlust müssen neue Hashes generiert werden.
