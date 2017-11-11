<?php
echo "
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css' integrity='sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb' crossorigin='anonymous'>
";

echo "
<div class='container'>
<h1>Sign In</h1>
<form action='../webapp/registerForm.php' method='POST' id='registerForm'>
  <div class='form-group'>
    <label for='username'>Username</label>
    <input type='text' class='form-control' id='username' name='username' required>
  </div>
  <div class='form-group'>
    <label for='password'>Password</label>
    <input type='password' class='form-control' id='password' name='password' required>
  </div>
  <button type='submit' class='btn btn-primary'>Register</button>
  <a class='btn btn-primary' href='login.php' role='button'>Login Instead</a>
</form>
</div>
";