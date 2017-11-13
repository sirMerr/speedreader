<?php session_start();

require_once(__DIR__ . '/../persistence/DAO.php');

echo "
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css' integrity='sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb' crossorigin='anonymous'>
";


if (isset($_SESSION['username'])) {
    // Set profile
    $_SESSION['lineId'] = $dao->findLineIdForAccount($_SESSION['username']);

    header('Location:/'.'views/reader.php');
    exit();
} else {
    header('Location:/'.'views/login.php');
    exit();
}