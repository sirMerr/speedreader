<?php
require_once(__DIR__ . '/../persistence/DAO.php');

if (isset($_GET['username'])) {
    $dao = new DAO();

    $line = $dao->findLineForAccount($_GET['username']);

    return $line;
}