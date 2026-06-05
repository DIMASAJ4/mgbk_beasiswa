<?php
// PHP error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Debug Info</h1>";

// 1. PHP Version
echo "PHP Version: " . phpversion() . "<br>";

// 2. .env check
if (file_exists(__DIR__ . '/../.env')) {
    echo ".env file exists!<br>";
    $env = file_get_contents(__DIR__ . '/../.env');
    // Hide passwords before printing
    $lines = explode("\n", $env);
    foreach ($lines as $line) {
        if (strpos($line, 'DB_') === 0 || strpos($line, 'APP_') === 0) {
            if (strpos($line, 'PASSWORD') !== false || strpos($line, 'KEY') !== false) {
                echo explode('=', $line)[0] . "=******<br>";
            } else {
                echo htmlspecialchars($line) . "<br>";
            }
        }
    }
} else {
    echo ".env file DOES NOT exist!<br>";
}

// 3. Check database connection
try {
    // Parse .env manually to get DB details
    $host = null;
    $db = null;
    $user = null;
    $pass = null;
    if (file_exists(__DIR__ . '/../.env')) {
        $lines = file(__DIR__ . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) continue;
            list($key, $val) = explode('=', $line, 2) + [NULL, NULL];
            if ($key === 'DB_HOST') $host = trim($val);
            if ($key === 'DB_DATABASE') $db = trim($val);
            if ($key === 'DB_USERNAME') $user = trim($val);
            if ($key === 'DB_PASSWORD') $pass = trim($val);
        }
    }
    
    echo "Connecting to DB: host=$host, db=$db, user=$user...<br>";
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    echo "Database connection successful!<br>";
} catch (Exception $e) {
    echo "Database connection failed: " . htmlspecialchars($e->getMessage()) . "<br>";
}

// 4. Laravel Logs
$logFile = __DIR__ . '/../storage/logs/laravel.log';
if (file_exists($logFile)) {
    echo "<h2>Laravel Log (Last 30 lines):</h2>";
    echo "<pre>";
    $lines = file($logFile);
    $lastLines = array_slice($lines, -30);
    foreach ($lastLines as $line) {
        echo htmlspecialchars($line);
    }
    echo "</pre>";
} else {
    echo "Laravel log file does not exist.<br>";
}
