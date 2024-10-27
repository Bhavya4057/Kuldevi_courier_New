<?php
include 'connection.php';  // Ensure this file is included

// Backup directory
$backupDir = 'F:\Backup\Delhievery/';
if (!is_dir($backupDir)) {
    mkdir($backupDir, 0777, true);
}

// Using the correct variable names from connection.php
$backupFile = $backupDir . $dbname . '_backup_' . date('d-m-y') . '.sql';

// Command to execute mysqldump
$command = "C:/xampp/mysql/bin/mysqldump --user=$username --password=$password --host=$servername $dbname > $backupFile";

// Execute the command
$output = null; // Initialize output variable
$returnVar = null; // Initialize return variable
exec($command, $output, $returnVar); // Use exec to capture return status

// Check if the backup was successful
if ($returnVar === 0) {
    echo "<script>
        alert('Backup created successfully');
        window.location.href = 'display.php'; // Redirect to the display page
    </script>";
} else {
    echo "<script>
        alert('No Backup Made. Error: Unable to create backup.');
       window.location.href = 'display.php';  Redirect to the display page
    </script>";
}
