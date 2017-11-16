<?php session_start();
/**
 * Start of app. Checks if there is a session and
 * redirects accordingly
 *
 * @author Tiffany Le-Nguyen
 */
require_once(__DIR__ . '/persistence/DAO.php');

echo "
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css' integrity='sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb' crossorigin='anonymous'>
";


if (isset($_SESSION['username'])) {
    $dao = new DAO();
    $username = $_SESSION['username'];

    // Set profile
    echo "Username: ".$username;

    $_SESSION['lineId'] = $dao->findLineIdForAccount($_SESSION['username']);

    $lineId = $_SESSION['lineId'];

    echo "Line ID: ".$lineId;
    header('Location:/'.'app/reader.php');
    exit();
} else {
    header('Location:/'.'app/login.php');
    exit();
}