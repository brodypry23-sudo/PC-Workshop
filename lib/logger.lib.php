<?php

// Only start a session if one isn't already running
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function writeLog(string $message, $data = null, string $level = "INFO") {
    $logFolder = __DIR__ . '/../logs';
    $logFile = $logFolder . '/app.log';

    // Does the folder exist? If not, create it
    if (!is_dir($logFolder)) {
        mkdir($logFolder, 0755, true);
    }

    // $userId will be either 'user 12' or 'guest'
    $userId = isset($_SESSION['userId']) ? 'user ' . $_SESSION['userId'] : 'guest';

    // Keep each log entry on one line
    $message = str_replace(["\r", "\n"], ' ', $message);

    // Grab the date and time of the log
    $line = date('Y-m-d H:i:s')
        . ' | ' . str_pad($level, 8)
        . ' | ' . str_pad($userId, 17)
        . ' | ' . ($_SERVER['PHP_SELF'] ?? '')
        . ' | ' . $message;

    // Add optional extra data (arrays/objects become JSON)
    if ($data !== null) {
        $line .= ' | ' . json_encode($data);
    }

    // Write the line to the end of the file
    file_put_contents($logFile, $line . PHP_EOL, FILE_APPEND | LOCK_EX);
}
