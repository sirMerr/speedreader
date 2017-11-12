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

login($username, $password);

/**
 * Secure login function
 *
 * @param $username
 * @param $password
 */
function login($username, $password) {
    $dao = new DAO();

    echo "
    <div class='container'>
    <h1>In login: $username , $password</h1>
    </div>
    ";
    // Use DAO to get login attempts
    if ($dao->findLoginAttempts($username) >= 3) {
        // redirect to error page
        echo "
        <div class='container'>
        <h1>More than 3 login attempts</h1>
        </div>
        ";

    } else {
        $hash = $dao->findHash($username);
        echo "
            <div class='container'>
            <h1>Hash: $hash</h1>
            </div>
            ";
        // Authenticate user, update time
        if (!password_verify($password, $hash)) {
            // Increment attempts
            $dao->updateLoginAttemptsIncrement($username);
            // Redirect to error page, or back to login with error message
            echo "
            <div class='container'>
            <h1>Invalid login, incrementing login attempts.</h1>
            </div>
            ";
        } else {
            $dao->updateResetLoginAttempts($username);
            // Reset attempts
            // Save in session
            $_SESSION['username'] = $username;
            session_regenerate_id();
            $GLOBALS['profile']->setUsername($_SESSION['username']);
            $GLOBALS['profile']->setLineId($dao->findLineIdForAccount($_SESSION['username']));

            echo "
            <div class='container'>
            <h1>Logging in!</h1>
            </div>
            ";
            header('Location:/'.'../views/reader.php');
            exit();
        }
    }
}