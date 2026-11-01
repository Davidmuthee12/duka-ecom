<?php

$dbPassword = getenv('DB_PASSWORD');
if ($dbPassword === false) {
    $envFile = dirname(__DIR__) . '/.env';
    if (is_readable($envFile)) {
        foreach (file($envFile, FILE_IGNORE_NEW_LINES) as $line) {
            $line = trim($line);
            if ($line === '' || $line[0] === '#' || !str_starts_with($line, 'DB_PASSWORD=')) {
                continue;
            }

            $dbPassword = trim(substr($line, strlen('DB_PASSWORD=')));
            if (
                strlen($dbPassword) >= 2
                && (($dbPassword[0] === '"' && $dbPassword[-1] === '"')
                    || ($dbPassword[0] === "'" && $dbPassword[-1] === "'"))
            ) {
                $dbPassword = substr($dbPassword, 1, -1);
            }
            break;
        }
    }
}

if ($dbPassword === false) {
    throw new RuntimeException('Set DB_PASSWORD in the process environment or project .env file.');
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=cms;charset=utf8mb4', 'cms', $dbPassword, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
}
catch (PDOException $e) {
    echo "An error occured while connectin to the database";
    die();
}

return $pdo;