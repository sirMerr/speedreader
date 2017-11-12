<?php

echo "
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css' integrity='sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb' crossorigin='anonymous'>
";


if (isset($_SESSION['username'])) {
    // Set profile
    $_SESSION['lineId'] = $dao->findLineIdForAccount($_SESSION['username']);

    echo "
    <div class='container'>
        <h1>Found session</h1>
    </div>
    ";
    header('Location:/'.'views/reader.php');
    exit();
} else {
    echo "
    <div class='container'>
        <h1>No session</h1>
    </div>
    ";
    header('Location:/'.'views/login.php');
    exit();
}