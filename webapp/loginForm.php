<?php session_start();

require_once(__DIR__ . '/../persistence/DAO.php');

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
        $loginErr = "You've had too login attempts. This account is now locked";
        // redirect to error page
        echo "
        <div class='container'>
        <h1>More than 3 login attempts</h1>
        </div>
        ";

    } else {
        $hash = $dao->findHash($username);
        // Authenticate user, update time
        if (!password_verify($password, $hash)) {
            // Increment attempts
            $dao->updateLoginAttemptsIncrement($username);
            // Redirect to error page, or back to login with error message
            $loginErr = "Wrong password. Please try again.";
        } else {
            $dao->updateResetLoginAttempts($username);

            // Save in session
            $_SESSION['username'] = $username;
            $_SESSION['lineId'] = $dao->findLineIdForAccount($_SESSION['username']);
            session_regenerate_id();

            header('Location:/'.'../views/reader.php');
            exit();
        }
    }
}