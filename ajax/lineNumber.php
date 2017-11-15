<?php session_start();

require_once(__DIR__ . '/../persistence/DAO.php');

$dao = new DAO();

$lineId = $dao->findLineIdForAccount($_SESSION['username']);
$dao->closeConnection();

echo $lineId;