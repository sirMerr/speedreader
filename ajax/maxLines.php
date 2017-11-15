<?php

require_once(__DIR__ . '/../persistence/DAO.php');

$dao = new DAO();

$totalLines = $dao->findMaxId();
$dao->closeConnection();

echo $totalLines;