<?php session_start();

require_once(__DIR__ . '/../persistence/DAO.php');

$dao = new DAO();

$line = $dao->findLineForAccount($_SESSION['username']);
$dao->updateLineIdIncrement($_SESSION['username']);

$_SESSION['lineId'] = $dao-> findLineIdForAccount($_SESSION['username']);

echo $line;