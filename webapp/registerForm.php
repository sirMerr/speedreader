<?php
require_once(__DIR__ . '/../persistence/DAO.php');

// Validate that access is only through a POST request,
// redirect to index.php if not
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location:/'.'#');
    exit();
}
echo "
<div class='container'>
<h1>Hallo!</h1>
</div>
";
$username = $_POST["username"];
$dao = new DAO();

if ($dao ->findUsernameTaken($username)) {

    echo "
    <div class='container'>
    <h1>User taken!</h1>
    </div>
    ";
    // Error
} else {
    $password = password_hash($_POST["password"],PASSWORD_DEFAULT);
    $dao->insertAccount($username, $password);
    // Save in session
    $_SESSION['username'] = $username;
    $_SESSION['lineId'] = $dao->findLineIdForAccount($_SESSION['username']);
    session_regenerate_id();

    echo "
    <div class='container'>
    <h1>Created new user!</h1>
    </div>
    ";

    header('Location:/'.'../views/reader.php');
    exit();
}