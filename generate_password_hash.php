<?php
/**
 * Hilfsskript zum Generieren von Passwort-Hashes
 *
 * Verwendung:
 * 1. Über Kommandozeile: php generate_password_hash.php "meinPasswort"
 * 2. Über Browser: Kommentiere die Zeilen unten aus und öffne die Datei im Browser
 */

// WARNUNG: Diese Datei sollte nach Verwendung gelöscht oder aus dem Web-Verzeichnis entfernt werden!

if (php_sapi_name() === 'cli') {
    // Kommandozeilen-Modus
    if ($argc < 2) {
        echo "Verwendung: php generate_password_hash.php \"ihr-passwort\"\n";
        exit(1);
    }

    $password = $argv[1];
    $hash = password_hash($password, PASSWORD_DEFAULT);

    echo "\n";
    echo "Passwort: {$password}\n";
    echo "Hash:     {$hash}\n";
    echo "\n";
    echo "Kopieren Sie den Hash in die config.php\n";
    echo "\n";
} else {
    // Browser-Modus (nur für Entwicklung verwenden!)

    // WICHTIG: Kommentiere diese Zeile aus, um das Skript über den Browser nutzen zu können
    die('Zugriff verweigert. Bitte über Kommandozeile verwenden oder diese Sicherheitsprüfung auskommentieren.');

    /*
    // Kommentiere diesen Block ein, um das Skript über den Browser zu verwenden

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
        $password = $_POST['password'];
        $hash = password_hash($password, PASSWORD_DEFAULT);

        echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Passwort Hash Generator</title></head><body>";
        echo "<h2>Passwort Hash Generator</h2>";
        echo "<p><strong>Passwort:</strong> " . htmlspecialchars($password) . "</p>";
        echo "<p><strong>Hash:</strong> <code>" . htmlspecialchars($hash) . "</code></p>";
        echo "<p><a href=''>Neues Passwort generieren</a></p>";
        echo "</body></html>";
        exit;
    }

    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Passwort Hash Generator</title>
        <style>
            body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; }
            input[type="password"], input[type="text"] { width: 100%; padding: 10px; margin: 10px 0; box-sizing: border-box; }
            button { padding: 10px 20px; background: #4CAF50; color: white; border: none; cursor: pointer; }
            button:hover { background: #45a049; }
            .warning { background: #ffebee; border-left: 4px solid #f44336; padding: 10px; margin: 20px 0; }
        </style>
    </head>
    <body>
        <h2>Passwort Hash Generator</h2>
        <div class="warning">
            <strong>Warnung:</strong> Diese Datei sollte nur während der Entwicklung verwendet werden.
            Löschen oder verschieben Sie sie nach der Verwendung aus dem Web-Verzeichnis!
        </div>
        <form method="POST">
            <label for="password">Passwort eingeben:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <button type="submit">Hash generieren</button>
        </form>
    </body>
    </html>
    <?php
    */
}
?>
