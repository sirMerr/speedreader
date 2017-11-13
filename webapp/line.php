<?php
require_once(__DIR__ . '/../persistence/DAO.php');

$dao = new DAO();

$line = $dao->findLineForAccount('admin');
$dao->updateLineIdIncrement();

echo "
<script>
    document.querySelector(\".word\").innerHTML = $line;
</script>
";