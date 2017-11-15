<?php session_start();
/**
 * Main application, has the spritz reader which
 * will read out each word of a chosen book at a
 * certain speed for its user.
 *
 * @author Tiffany Le-Nguyen
 */

echo "
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css' integrity='sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb' crossorigin='anonymous'>
";

echo "
<style>
    .pivot {
        color: red;
        text-decoration: overline underline;
        width: ;
    }
    
    .word-container {
        display: flex;
        justify-content: center;
        min-height: 66px;
        padding-top: 9px;
        padding-bottom: 9px;
    }
    
    .word {
        text-align: left;
        width: 200px;
        white-space: pre;
        font-size: 32px;
        font-family: 'Courier', sans-serif;

    }
    
    .vertical-center {
        min-height: 100vh;
        display: flex;
        align-items: center;
    }
</style>
";

echo "
<div class='jumbotron vertical-center'>
<div class='container'>
    <div class='card'>
      <div class='card-body'>
        <div class='card-text word-container'>
            <div class='word'></div>
        </div>
        <div class='container'>
          <div class='row' style='justify-content: center'>
            <div class='col-md-auto'>
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
                <div class='col-md-auto'>
                  <button type='button' class='btn btn-success btn-start'>Start</button>
                </div>
                <div class='col-md-auto'>
                  <button type='button' class='btn btn-danger btn-stop'>Stop</button>
                </div>
              </div>
            </div>
        </div>
    </div>
    <a role='button' class='btn btn-link' href='../webapp/logout.php'>Logout</a>
    <a role='button' class='btn btn-link' href='http://www.textfiles.com/etext/FICTION/2000010.txt'>Full Text</a>
</div>
";
?>
<script>
    const g = {};
    window.onload=init;

    /**
     * This function runs on window load,
     * declares and sets the global vars and sets the
     * wpm.
     */
    function init () {
        g.wordCanvas = document.querySelector("wordCanvas");
        g.wpmSelector = document.querySelector(".wpmSelector");
        g.word = document.querySelector(".word");
        g.line = '';
        g.counter = 0;

        g.btnStart = document.querySelector(".btn-start");
        g.btnStop = document.querySelector(".btn-stop");

        g.wpmSelector.addEventListener('change', setSpeed);
        g.btnStart.addEventListener('click', startLines);
        g.btnStop.addEventListener('click', stopLines);
        g.btnStop.disabled = true;

        getSpeed();
    }

    /**
     * Start spritzing lines
     */
    function startLines() {
        // Disable button so user does not have multiple intervals
        g.btnStart.disabled = true;

        // Make sure first iterance of line is set
        if (g.line === '') {
            getLine();
        }

        // Split per word
        g.lineArr = g.line.split(" ");

        g.perMS = 60000/parseInt(g.wpmSelector.value.replace(' wpm', '');
        // Set interval based on wpm
        g.interval = setInterval(printLine, g.perMS);

        // Enable stop button
        g.btnStop.disabled = false;

        // Start printing lines
        printLine();

    }

    // @todo: Handle end of book
    // Print each line at x interval
    function printLine() {
        // Gets a new line if the line is an empty line
        if (g.line.length === 0 || g.lineArr.length === 0 || g.counter >= g.lineArr.length) {
            getLine();

            // Reset counter
            g.counter = 0;

            // Do nothing this interval if the new line is also empty
            if (g.line.length === 0) {
                setTimeout(()=> {console.log('Waited because of new line');}, g.perMS * 4);
            } else {
                g.lineArr = g.line.split(" ");

                // @todo Handle end of book (if $dao->findLineId >= max lines)
                if (!g.lineArr || g.lineArr.length === 0) {
                    clearInterval(g.interval);
                } else {
                    // console.log(lineArr[counter]);
                    g.word.innerHTML = position(g.lineArr[g.counter]);
                    g.counter++;

                    if (g.lineArr[g.counter].match(/[.,;?!]$/)) {
                        setTimeout(()=> {console.log('Waited because of a period');}, g.perMS * 2);
                    }
                }
            }
        } else {
            // console.log(lineArr[counter]);
            g.word.innerHTML = position(g.lineArr[g.counter]);
            g.counter++;

            if (g.lineArr[g.counter].match(/[.,;?!]$/)) {
                setTimeout(()=> {console.log('Waited because of a period');}, g.perMS * 2);
            }
        }
    }
    /**
     * Stop button handler
     */
    function stopLines() {
        // Disable stop button
        g.btnStop.disabled = true;

        // Clear interval
        if (g.interval) {
            clearInterval(g.interval);
        }

        // Enable start button
        g.btnStart.disabled = false;
    }

    /**
     * Get the next line
     */
    function getLine() {
        const xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                g.line = this.responseText;
            }
        };
        xhttp.open("GET", "../ajax/line.php", true);
        xhttp.send();
    }

    /**
     * Get the wpm
     */
    function getSpeed() {
        const xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                g.wpmSelector.value = this.responseText + " wpm";
            }
        };
        xhttp.open("GET", "../ajax/speed.php", true);
        xhttp.send();
    }

    /**
     *  Set the wpm
     */
    function setSpeed() {
        clearInterval(g.interval);

        const xhttp = new XMLHttpRequest();
        const parameters = `speed=${parseInt(g.wpmSelector.value.replace(' wpm', ''))}`;

        xhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                console.log(this.responseText);
            }
        };
        xhttp.open("POST", "../ajax/updateSpeed.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(parameters);

        startLines();
    }

    /**
     * Positions the word for display
     *
     * length = 1 => 1st letter    // ____a or 4 spaces before
     * length = 2-5 => 2nd letter  // ___four or 3 spaces before
     * length = 6-9 => third letter      // __embassy 2 spaces
     * length = 10-13 => fourth letter   // _playground 1 spaces
     * length >13 => fifth letter        // acknowledgement no spaces
     * @param word
     * @returns {string}
     */
    function position(word) {
       const length = word.length;
       let result = "<span class='wordStart'>";
       if (length === 1) {
           result += `    </span>`;
           result += `<span class='pivot'>${word}</span>`;
       } else if (length >=2 && length <=5) {
           result += `   ${word.slice(0,1)}</span>`;
           result += `<span class='pivot'>${word.charAt(1)}`;
           if (length > 2) {
               result += `</span><span class='wordEnd'>${word.slice(2)}`;
           }
       } else if (length >=6 && length <=9) {
           result += `  ${word.slice(0,2)}</span>`;
           result += `<span class='pivot'>${word.charAt(2)}</span>`;
           result += `<span class='wordEnd'>${word.slice(3)}`;
       } else if (length >=10 && length <=13) {
           result += ` ${word.slice(0,3)}</span>`;
           result += `<span class='pivot'>${word.charAt(3)}</span>`;
           result += `<span class='wordEnd'>${word.slice(4)}`;
       } else if (length > 13) {
           result += `${word.slice(0,4)}</span>`;
           result += `<span class='pivot'>${word.charAt(4)}</span>`;
           result += `<span class='wordEnd'>${word.slice(5)}`;
       }

       return result + '</span>';
    }

</script>
