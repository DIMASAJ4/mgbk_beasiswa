<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Debug Info</h1>";
echo "PHP Version: " . phpversion() . "<br>";

$logFile = __DIR__ . '/../storage/logs/laravel.log';
if (file_exists($logFile)) {
    echo "<h2>Latest Errors:</h2>";
    $content = file_get_contents($logFile);
    
    // Find all occurrences of "local.ERROR" or "production.ERROR"
    preg_match_all('/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\].*?(?=\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\]|$)/s', $content, $matches);
    
    if (!empty($matches[0])) {
        $errors = array_slice($matches[0], -5); // Get last 5 errors
        foreach ($errors as $error) {
            echo "<pre style='background:#f8d7da; border:1px solid #f5c6cb; padding:10px; margin-bottom:10px; overflow:auto;'>";
            echo htmlspecialchars($error);
            echo "</pre>";
        }
    } else {
        echo "No ERROR logs found in the format [YYYY-MM-DD HH:MM:SS]. Showing last 200 lines:<br>";
        echo "<pre>";
        $lines = file($logFile);
        $lastLines = array_slice($lines, -200);
        foreach ($lastLines as $line) {
            echo htmlspecialchars($line);
        }
        echo "</pre>";
    }
} else {
    echo "Laravel log file does not exist.<br>";
}
