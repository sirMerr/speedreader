<?php
require_once(__DIR__ . '/../persistence/DAO.php');

if (isset($_POST['speed'])) {
    $dao = new DAO();

    $dao->updateSpeed('admin', $_GET['speed']);
}