<?php session_start();

echo "
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css' integrity='sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb' crossorigin='anonymous'>
";

echo "
<div class='container'>
    <div class='card'>
      <div class='card-body'>
        <p class='card-text word'></p>
        <div class='container'>
          <div class='row'>
            <div class='col-sm'>
              <select id='inputState' class='form-control wpmSelector'>
                <option>50 wpm</option>
                <option selected>100 wpm</option>
";

for ($i = 150; $i < 2000; $i+=50) {
    echo "<option>$i wpm</option>";
}

echo "
         </select>
      </div>
            <div class='col-sm'>
              <button type='button' class='btn btn-success btn-start'>Start</button>
            </div>
            <div class='col-sm'>
              <button type='button' class='btn btn-danger btn-stop'>Stop</button>
            </div>
          </div>
        </div>
    </div>
    <a role='button' class='btn btn-link' href='../webapp/logout.php'>Logout</a>
</div>
";

print_r($_SESSION);
$username = $_SESSION['username'];
$lineId = $_SESSION['lineId'];

echo "Username: ".$username;
echo "LineId: ".$lineId;
?>
<script>
    const g = {};
    window.onload=init;

    function init () {
        g.word = document.querySelector(".word");
        g.wpmSelector = document.querySelector(".wpmSelector");
        g.line;
        g.btnStart = document.querySelector(".btn-start");
        g.btnStop = document.querySelector(".btn-stop");

        g.wpmSelector.addEventListener('onchange', setSpeed);
        g.btnStart.addEventListener('click', startLines);
        g.btnStop.addEventListener('click', stopLines);
        getSpeed();
    }

    function startLines() {
        if (!g.line) {
            getLine();
        }
        g.lineArr = g.line.split(" ");
        g.counter = 0;

        g.interval = setInterval(printLine, Math.round(parseInt(g.wpmSelector.value.replace(' wpm', '')) / 360 * 1000));

        // @todo: Handle end of book
        function printLine() {
            if (g.lineArr.length === 0 || g.counter >= g.lineArr.length) {
                getLine();
                g.counter = 0;
                if (g.line.length !== 0) {
                    g.lineArr = g.line.split(" ");

                    if (!g.lineArr || g.lineArr.length === 0) {
                        clearInterval(g.interval);
                    } else {
                        // console.log(lineArr[counter]);
                        g.word.innerHTML = g.lineArr[g.counter];
                        g.counter++;
                    }
                }
            } else {
                // console.log(lineArr[counter]);
                g.word.innerHTML = g.lineArr[g.counter];
                g.counter++;
            }
        }
    }

    function stopLines() {
        if (g.interval) {
            clearInterval(g.interval);
        }
    }

    function getLine() {
        const xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                console.log(this.responseText);
                g.line = this.responseText;
            }
        };
        xhttp.open("GET", "../ajax/line.php", true);
        xhttp.send();
    }

    function getSpeed() {
        const xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                console.log(this.responseText);
                g.wpmSelector.value = this.responseText + " wpm";
            }
        };
        xhttp.open("GET", "../ajax/speed.php", true);
        xhttp.send();
    }

    function setSpeed() {
        const xhttp = new XMLHttpRequest();
        const parameters = `speed=${g.wpmSelector.value}`;

        xhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                console.log(this.responseText);
            }
        };
        xhttp.open("POST", "../ajax/speed.php", true);
        xhttp.send();
    }

</script>
