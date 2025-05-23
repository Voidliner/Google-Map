<?php
// Database connection parameters
$host = 'dpg-d0lt10gdl3ps73bpinv0-a.oregon-postgres.render.com';
$port = '5432';
$dbname = 'googlemapdb';
$user = 'googlemapdb_user';
$password = 'dZ3k5Fuy16jdYkUIHe2QZD8aSGXzgpWh';

// Add SSL mode to the connection string for Render
$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";

try {
    // Connect to the database
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create table if it doesn't exist
    $sql = "
        CREATE TABLE IF NOT EXISTS Accounts (
            id SERIAL PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL
        );
    ";
    $pdo->exec($sql);

    // Get POST data
    $username = $_POST['username'] ?? '';
    $plainPassword = $_POST['password'] ?? '';

    if (!$username || !$plainPassword) {
        echo "Username and password are required.";
        exit;
    }
    
    $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);
    
    // Check if username exists
    $checkStmt = $pdo->prepare("SELECT * FROM Accounts WHERE username = :username AND password = :password");
    $checkStmt->bindParam(':username', $username);
    $checkStmt->bindParam(':password', $hashedPassword);
    $checkStmt->execute();

    if ($checkStmt->rowCount() > 0) {
        echo "Confirmed";
        exit;
    } else {
        echo "Denied";
        exit;
        }

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
