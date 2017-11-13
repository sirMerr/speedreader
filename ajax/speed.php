<?php
require_once(__DIR__ . '/../persistence/DAO.php');

$dao = new DAO();

$speed = $dao->findSpeed('admin');

echo $speed;