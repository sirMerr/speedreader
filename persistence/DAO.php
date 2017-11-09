<?php

class DAO{
    private $pdo;

    function __construct(){
        include ('../Credentials.php');
        try {
            $this->pdo = new PDO("pgsql:dbname=$dbname;host=$host", $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
            $this->createTable();
        } catch (PDOException $e) {
            echo "Error could not connect to db\n";
            echo $e->getMessage();
        }
    }

    function createTable() {
        $exist = "DROP TABLE IF EXISTS Lines;";
        $this->pdo->exec($exist);
        $create = "CREATE TABLE Lines (id serial PRIMARY KEY, text varchar(255));";
        $this->pdo->exec($create);
    }

    function insert($line) {
        $query = "INSERT INTO Lines (text) values (?);";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(1, $line);

            $stmt->execute();
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    //maybe have getConnection so dont have to make multiple dao
    function closeConnection() {
        unset($this->pdo);
    }
}