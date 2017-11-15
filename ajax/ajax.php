<?php session_start();

require_once(__DIR__ . '/../persistence/DAO.php');

if (isset($_POST['speed'])) {
    $dao = new DAO();
    $dao->updateSpeed($_SESSION['username'], $_POST['speed']);
    $dao->closeConnection();
    return;
}

if (isset($_POST['method'])) {
    $dao = new DAO();
    switch ($_POST['method']) {
        case "getTotalLines":
            $lineId = $dao->findMaxId();
            $dao->closeConnection();
            return $lineId;
        default:
            break;
    }
}
