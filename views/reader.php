<?php

echo "
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css' integrity='sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb' crossorigin='anonymous'>
";

echo "
<div class='container'>
    <div class='card'>
      <div class='card-body'>
        <h4 class='card-title'>Word</h4>
        <p class='card-text'>With supporting text below as a natural lead-in to additional content.</p>
        <select id=\"inputState\" class=\"form-control\">
            <option>50 wpm</option>
            <option selected>100 wpm</option>
";

for ($i = 150; $i < 2000; $i+=50) {
    echo "<option>$i wpm</option>";
}

echo "
         </select>
      </div>
    </div>
</div>
";