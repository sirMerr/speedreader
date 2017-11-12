<?php

// This is to help see where the errors are in the web server
// Source: https://stackoverflow.com/questions/1475297/phps-white-screen-of-death
ini_set('display_errors', 'On');
ini_set('html_errors', 0);
error_reporting(-1);

function ShutdownHandler()
{
    if(@is_array($error = @error_get_last()))
    {
        return(@call_user_func_array('ErrorHandler', $error));
    };

    return(TRUE);
};

register_shutdown_function('ShutdownHandler');

// ----------------------------------------------------------------------------------------------------
// - Error Handler
// ----------------------------------------------------------------------------------------------------
function ErrorHandler($type, $message, $file, $line)
{
    $_ERRORS = Array(
        0x0001 => 'E_ERROR',
        0x0002 => 'E_WARNING',
        0x0004 => 'E_PARSE',
        0x0008 => 'E_NOTICE',
        0x0010 => 'E_CORE_ERROR',
        0x0020 => 'E_CORE_WARNING',
        0x0040 => 'E_COMPILE_ERROR',
        0x0080 => 'E_COMPILE_WARNING',
        0x0100 => 'E_USER_ERROR',
        0x0200 => 'E_USER_WARNING',
        0x0400 => 'E_USER_NOTICE',
        0x0800 => 'E_STRICT',
        0x1000 => 'E_RECOVERABLE_ERROR',
        0x2000 => 'E_DEPRECATED',
        0x4000 => 'E_USER_DEPRECATED'
    );

    if(!@is_string($name = @array_search($type, @array_flip($_ERRORS))))
    {
        $name = 'E_UNKNOWN';
    };

    return(print(@sprintf("%s Error in file \xBB%s\xAB at line %d: %s\n", $name, @basename($file), $line, $message)));
};

$old_error_handler = set_error_handler("ErrorHandler");
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

            // Start session
            session_start();

            // Save in session
            $_SESSION['username'] = $username;
            $_SESSION['lineId'] = $dao->findLineIdForAccount($_SESSION['username']);
            session_regenerate_id();

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