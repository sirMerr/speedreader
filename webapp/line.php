<?php
require_once(__DIR__ . '/../persistence/DAO.php');

$dao = new DAO();

$line = $dao->findLineForAccount($_GET['username']);
$dao->updateLineIdIncrement();

return $line;