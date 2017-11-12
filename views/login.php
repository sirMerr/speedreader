<?php
echo "
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css' integrity='sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb' crossorigin='anonymous'>
";

echo "
<div class='dropdown-menu'>
  <form class='px-4 py-3'>
    <div class='form-group'>
      <label for='username'>Username</label>
      <input type='email' class='form-control' id='username' name='username'>
    </div>
    <div class='form-group'>
      <label for='password'>Password</label>
      <input type='password' class='form-control' id='password' name='password'>
    </div>
    <button type='submit' class='btn btn-primary'>Sign in</button>
  </form>
  <div class='dropdown-divider'></div>
  <a class='dropdown-item' href='register.php'>New around here? Sign up</a>
</div>
";