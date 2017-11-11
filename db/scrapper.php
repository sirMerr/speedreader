<?php
require_once(__DIR__ . '/../persistence/DAO.php');

loadDB();

function getLines()
{
    sleep(1);
    $url = "http://www.textfiles.com/etext/FICTION/2000010.txt";
    $lines = file_get_contents($url);

    // This took forever to figure out because [\n] didn't work and [\r\n] kind of worked,
    // finally [\r?\n] worked (? being 0 or 1 instances)!
    // I replace with \n\n so that when I explode it, it keeps only one \n
    $lines = preg_replace("/(\r?\n){2,}/", "\n\n", $lines);
    $linesArr = array_map('trim', explode("\n", $lines));

    $count = sizeof($linesArr);

    echo "Count start: ".$count;
    // So that heroku doesn't hate us
    $linesArr = array_slice($linesArr, 0,8000);

    $count = sizeof($linesArr);

    echo "Count done: ".$count;

    echo "\nGetting Lines finished.\n";
    return $linesArr;
}

/**
 * Loads the dao and inserts line from the book
 */
function loadDB(){
    $dao = new DAO();
    $linesArr = getLines();

    foreach($linesArr as $line){
        $dao->insertLine($line);
    }
    echo "DB load finished";
}
