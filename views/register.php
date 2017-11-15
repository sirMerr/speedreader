<?php session_start();
require_once(__DIR__ . '/../persistence/DAO.php');

// Validate that access is only through a POST request,
// redirect to index.php if not
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST["username"];
    $dao = new DAO();

    // Check if username already exists
    if ($dao ->findUsernameTaken($username)) {
        echo "
            <div class='alert alert-danger' role='alert' style='margin-bottom: 0'>
                Username taken!
            </div>";
    } else {
        // Here username does not exist, so hash and create account
        $password = password_hash($_POST["password"],PASSWORD_DEFAULT);
        $dao->insertAccount($username, $password);

        // Save in session
        $_SESSION['username'] = $username;
        $_SESSION['lineId'] = $dao->findLineIdForAccount($_SESSION['username']);
        session_regenerate_id();

        echo "
            <div class='alert alert-success' role='alert' style='margin-bottom: 0'>
                Success! Redirecting you to the reader...
            </div>";

        header('Location:/'.'views/reader.php');
        exit();
    }
}

?>

<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css' integrity='sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb' crossorigin='anonymous'>

<div class='jumbotron' style='display: flex; height: 100vh; align-items: center'>
    <div class='container'>
        <h1>Register</h1>
        <form action='<?php echo htmlentities($_SERVER["PHP_SELF"]);?>' method='POST' id='registerForm'>
          <div class='form-group'>
            <label for='username'>Username</label>
            <input type='text' class='form-control' id='username' name='username' required>
          </div>
          <div class='form-group'>
            <label for='password'>Password</label>
            <input type='password' class='form-control' id='password' name='password' required>
          </div>
          <button type='submit' class='btn btn-primary'>Register</button>
          <div class='dropdown-divider'></div>
          <a class='dropdown-item' href='login.php'>Already have an account? Login instead</a>
        </form>
    </div>
</div>
