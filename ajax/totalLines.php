<?php session_start();

require_once(__DIR__ . '/../persistence/DAO.php');

$dao = new DAO();

$lineId = $dao->findMaxId();
$dao->closeConnection();

echo $lineId;