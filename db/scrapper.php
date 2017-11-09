<?php
require_once('../persistence/DAO.php');

loadDB();

function getLines()
{
    sleep(1);
    $url = "http://www.textfiles.com/etext/FICTION/2000010.txt";
    $lines = file($url);

    removeExtraNewLines($lines);

    $count = sizeof($lines);

    echo "Getting Lines finished.\n";
    echo "Total: ".$count."\n";
    return $lines;
}

/**
 * @param $lines array of strings
 */
function removeExtraNewLines(&$lines) {
    $keys = array_keys($lines, PHP_EOL);

    for ($i = 0; $i < sizeof($keys) - 1; $i++) {
        $line1 = $keys[$i];
        $line2 = $keys[$i + 1];
        if ($line2 === $line1 + 1) {
            unset($lines[$line2]);
            array_values($lines);
        }
    }
}

/**
 *
 */
function loadDB(){
    $dao = new DAO();
    $lines = getLines();

    foreach($lines as $line){
        $dao->insert($line);
    }
    echo "DB load finished";
}