<?php

echo "
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css' integrity='sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb' crossorigin='anonymous'>
";

echo "
<div class='container'>
    <div class='card'>
      <div class='card-body'>
        <p class='card-text word'>Word</p>
        <div class='container'>
          <div class='row'>
            <div class='col-sm'>
              <select id='inputState' class='form-control'>
                <option>50 wpm</option>
                <option selected>100 wpm</option>
";

for ($i = 150; $i < 2000; $i+=50) {
    echo "<option>$i wpm</option>";
}

echo "$wat"."<br>";
echo "
         </select>
      </div>
            <div class='col-sm'>
              <button type='button' class='btn btn-success'>Start</button>
            </div>
            <div class='col-sm'>
              <button type='button' class='btn btn-danger'>Stop</button>
            </div>
          </div>
        </div>
    </div>
    <a role='button' class='btn btn-link' href='../webapp/logout.php'>Logout</a>
</div>
";
?>

<script>
    window.onload=init;

    function init () {
        const word = document.querySelector(".word");

        getLine();
    }

    function getLine() {
        const xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                document.querySelector(".word").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "../webapp/line.php", true); // <-- not sure what should be going here
        xhttp.send();
    }
</script>
