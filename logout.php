<?php
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
if (session_id() !== '' || isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/'); // Delete the session cookie
    session_destroy(); // Destroy the session
}

// Redirect to the login page or homepage
header('Location: index.php'); // Change 'index.php' to your desired redirect page
exit();
?>
