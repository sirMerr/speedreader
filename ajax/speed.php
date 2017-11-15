<?php session_start();
require_once(__DIR__ . '/../persistence/DAO.php');

$dao = new DAO();

$speed = $dao->findSpeed($_SESSION['username']);

echo $speed;