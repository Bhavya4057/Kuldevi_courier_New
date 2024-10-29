<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "delhievery_2024";
$conn = mysqli_connect($servername, $username, $password, $dbname);
error_reporting(0);
if (!$conn) {
    die("Connection Failed!!!!  " . mysqli_connect_error());
}

// Backup directory
$backupDir = 'F:/Backup/';
if (!is_dir($backupDir)) {
    mkdir($backupDir, 0777, true);
}

// Define databases
$databases = [
    'tirupati_2024',
    'delhievery_2024'
];

$allBackupsSuccessful = true; // To track if all backups are successful

// Loop through each database to create backups
foreach ($databases as $dbname) {
    // Backup file path
    $backupFile = $backupDir . $dbname . '_backup_' . date('d-m-y') . '.sql';

    // Command to execute mysqldump
    $command = "C:/xampp/mysql/bin/mysqldump --user=$username --password=$password --host=$servername $dbname > $backupFile";

    // Execute the command
    $output = null; // Initialize output variable
    $returnVar = null; // Initialize return variable
    exec($command, $output, $returnVar); // Use exec to capture return status

    // Check if the backup was successful
    if ($returnVar !== 0) {
        $allBackupsSuccessful = false; // Set flag to false if any backup fails
        echo "<script>
            alert('No Backup Made for $dbname. Error: Unable to create backup.');
        </script>";
    }
}

// Final success message if all backups are successful
if ($allBackupsSuccessful) {
    echo "<script>
        alert('Backups created successfully for all databases');
        window.location.href = 'index.php'; // Redirect to the display page
    </script>";
} else {
    echo "<script>
        alert('Some backups failed. Check error messages.');
        window.location.href = 'index.php'; // Redirect to the display page
    </script>";
}
?>
