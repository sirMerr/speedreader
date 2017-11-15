<?php session_start();

require_once(__DIR__ . '/../persistence/DAO.php');

$dao = new DAO();

$dao->updateSpeed($_SESSION['username'], $_SESSION['password']);
$dao->closeConnection();
