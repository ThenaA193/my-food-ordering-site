<?php
// Database connection settings
$host = 'localhost';  // Host of your MySQL server
$db   = 'snack_haven'; // Database name
$user = 'root';  // Database username (usually 'root' for local MySQL)
$pass = ''; // Password for your database (usually empty for localhost)
$charset = 'utf8mb4';  // Character set for database connection

// DSN (Data Source Name) for connecting to the MySQL server
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Options for PDO to manage errors and fetch data
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  // Throw exceptions on errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,  // Fetch data as an associative array by default
];

// Attempt to create a PDO connection
try {
    $pdo = new PDO($dsn, $user, $pass, $options);  // Create the PDO instance
} catch (PDOException $e) {
    // If there is an error, display it
    echo 'Database connection failed: ' . $e->getMessage();
    exit;  // Stop the script execution if connection fails
}
?>
