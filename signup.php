<?php
session_start();

// Database connection parameters
$host = 'dpg-d0lt10gdl3ps73bpinv0-a.oregon-postgres.render.com';
$port = '5432';
$dbname = 'googlemapdb';
$user = 'googlemapdb_user';
$password = 'dZ3k5Fuy16jdYkUIHe2QZD8aSGXzgpWh';

$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create Accounts table if it doesn't exist
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

    // Check if username exists
    $checkStmt = $pdo->prepare("SELECT * FROM Accounts WHERE username = :username");
    $checkStmt->bindParam(':username', $username);
    $checkStmt->execute();

    if ($checkStmt->rowCount() > 0) {
        echo "Username already exists. Please choose a different one.";
        exit;
    }

    // Hash password
    $hashedPassword = password_hash($plainPassword, PASSWORD_BCRYPT);

    // Insert new user
    $insertStmt = $pdo->prepare("INSERT INTO Accounts (username, password) VALUES (:username, :password)");
    $insertStmt->bindParam(':username', $username);
    $insertStmt->bindParam(':password', $hashedPassword);
    $insertStmt->execute();

    echo "User registered successfully.";

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
