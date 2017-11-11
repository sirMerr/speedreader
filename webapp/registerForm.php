<?php
require_once(__DIR__ . '/../persistence/DAO.php');

// Validate that access is only through a POST request,
// redirect to index.php if not
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('#');
    exit();
}

if (isset($_POST["username"])) {
    echo $_POST["username"]."\n";
}
$username = $_POST["username"];
$dao = new DAO();

if ($dao ->findUsernameTaken($username)) {
    // Error
} else {
    $password = password_hash($_POST["password"],PASSWORD_DEFAULT);
    $dao->insertAccount($username, $password);
    // Save in session
    $_SESSION['username'] = $username;
    session_regenerate_id();
    $GLOBALS['profile']->setUsername($_SESSION['username']);
    $GLOBALS['profile']->setLineId($dao->findLineIdForAccount($_SESSION['username']));
}