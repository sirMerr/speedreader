<?php
require_once(__DIR__ . '/../persistence/DAO.php');
require_once(__DIR__ . '/../entities/Account.php');

// Validate that access is only through a POST request,
// redirect to index.php if not
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location:/'.'index.php');
    exit();
}

$username = $_POST["username"];
$password = $_POST["password"];

/**
 * Secure login function
 *
 * @param $username
 * @param $password
 */
function login($username, $password) {
    $dao = new DAO();

    // Use DAO to get login attempts
    if ($dao->findLoginAttempts($username) >= 3) {
    // redirect to error page

    } else {
        $hash = $dao->findHash($username);
        // Authenticate user, update time
        if (!password_verify($password, $hash)) {
            // Increment attempts
            $dao->updateLoginAttemptsIncrement($username);
            // Redirect to error page, or back to login with error message
        } else {
            $dao->updateResetLoginAttempts($username);
            // Reset attempts
            // Save in session
            $_SESSION['username'] = $username;
            session_regenerate_id();
            $GLOBALS['profile']->setUsername($_SESSION['username']);
            $GLOBALS['profile']->setLineId($dao->findLineIdForAccount($_SESSION['username']));
        }
    }
}