<?php
// Database connection parameters (same as before)
$host = 'dpg-d0lt10gdl3ps73bpinv0-a.oregon-postgres.render.com';  // External hostname
$port = '5432';  // Default PostgreSQL port
$dbname = 'googlemapdb';  // Database name
$user = 'googlemapdb_user';  // Username
$password = 'dZ3k5Fuy16jdYkUIHe2QZD8aSGXzgpWh';  // Password

// Add SSL mode to the connection string for Render
$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";

try {
    // Connect to the database with SSL enabled
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL query to drop the table
    $sql = "DROP TABLE IF EXISTS Accounts";  // This will drop the 'users' table if it exists

    // Prepare the statement
    $stmt = $pdo->prepare($sql);

    // Execute the statement
    $stmt->execute();

    echo "Table 'Accounts' deleted successfully!";
} catch (PDOException $e) {
    // Error handling
    echo "Error: " . $e->getMessage();
}
?>
