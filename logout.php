<?php
session_start();        // Start the session
session_unset();        // Unset all session variables
session_destroy();      // Destroy the session completely

// Optional: Prevent browser from caching the logged-in page
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

header("Location: index.php");   // Redirect to login page
exit();
?>
