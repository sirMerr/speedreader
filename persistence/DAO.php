<?php

/**
 * Class DAO
 *
 * @author Tiffany Le-Nguyen
 */
class DAO{
    private $pdo;

    /**
     * DAO constructor. Makes connection to database
     * and creates tables if specified
     */
    function __construct(){
        include (_DIR_.'/../Credentials.php');
        try {
            $this->pdo = new PDO("pgsql:dbname=$dbname;host=$host", $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
            // Uncomment the next two lines if trying to recreate table
            // $this->createTableLines();
            // $this->createTableAccounts();

        } catch (PDOException $e) {
            echo "Error could not connect to db\n";
            echo $e->getMessage();
        }
    }

    /**
     * Create table for lines
     */
    function createTableLines() {
        $exist = "DROP TABLE IF EXISTS Lines;";
        $this->pdo->exec($exist);
        $create = "CREATE TABLE Lines (id serial PRIMARY KEY, text VARCHAR(255));";
        $this->pdo->exec($create);
    }

    /**
     * Create table for accounts
     */
    function createTableAccounts() {
        $exist = "DROP TABLE IF EXISTS Accounts;";
        $this->pdo->exec($exist);
        $create = "CREATE TABLE Accounts (
                    id serial PRIMARY KEY, 
                    username VARCHAR(50) NOT NULL UNIQUE, 
                    password VARCHAR(50) NOT NULL,
                    line_id int,
                    login_attempts int DEFAULT 0,
                    FOREIGN KEY (line_id) REFERENCES Lines(id)
                   );";
        $this->pdo->exec($create);
    }

    /**
     * Insert line from book into table
     *
     * @param $line
     */
    function insertLine($line) {
        $query = "INSERT INTO Lines (text) values (?);";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(1, $line);

            $stmt->execute();
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    /**
     * Inserts account into table
     *
     * @param $username
     * @param $password
     */
    function insertAccount($username, $password) {
        $query = "INSERT INTO Accounts (username, password) values (?, ?);";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(1, $username);
            $stmt->bindValue(2, $password);

            $stmt->execute();
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    function closeConnection() {
        unset($this->pdo);
    }
}