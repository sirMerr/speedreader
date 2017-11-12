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
        include (__DIR__.'/../Credentials.php');
        try {
            $this->pdo = new PDO("pgsql:dbname=$dbname;host=$host", $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
            // Uncomment the next two lines if trying to recreate table
//             $this->createTableLines();
//             $this->createTableAccounts();
        } catch (PDOException $e) {
            echo "Error could not connect to db\n";
            echo $e->getMessage();
        }
    }

    /**
     * Create table for lines
     */
    function createTableLines() {
        $exist = "DROP TABLE IF EXISTS Lines CASCADE ;";
        $this->pdo->exec($exist);
        $create = "CREATE TABLE Lines (id serial PRIMARY KEY, text VARCHAR(255));";
        $this->pdo->exec($create);
    }

    /**
     * Create table for accounts
     */
    function createTableAccounts() {
        $exist = "DROP TABLE IF EXISTS Accounts CASCADE ;";
        $this->pdo->exec($exist);
        $create = "CREATE TABLE Accounts (
                    id serial PRIMARY KEY, 
                    username VARCHAR(50) NOT NULL UNIQUE, 
                    password VARCHAR(255) NOT NULL,
                    line_id int DEFAULT 1,
                    wpm int DEFAULT 100,
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

            echo ".";
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

    /**
     * Checks if an account with a given username and password exists
     *
     * @param $username
     * @param $password
     * @return bool true if found, false if not
     */
    function findAccount($username, $password) {
        $query = "SELECT count(*)
                    FROM accounts
                    WHERE username = ? AND password = ?
                 ";

        $stmt = $this -> pdo -> prepare($query);
        $stmt -> bindParam(1, $username);
        $stmt -> bindParam(2, $password);

        $stmt -> execute();

        $userExists = $stmt -> fetch();

        return boolval($userExists);

    }

    /**
     * Finds the hash for a username
     *
     * @param $username
     * @return the found hash
     */
    function findHash($username) {
        $query = "SELECT password
                    FROM accounts
                    WHERE username = ?
                 ";

        $stmt = $this -> pdo -> prepare($query);
        $stmt -> bindParam(1, $username);

        $stmt -> execute();

        $password = $stmt -> fetch();

        return $password[0];

    }

    /**
     * Checks if a username was already taken
     *
     * @param $username
     * @return bool true if found, false if not
     */
    function findUsernameTaken($username) {
        $query = "SELECT count(*)
                    FROM accounts
                    WHERE username = ?
                 ";

        $stmt = $this -> pdo -> prepare($query);
        $stmt -> bindParam(1, $username);

        $stmt -> execute();

        $usernameExists = $stmt -> fetch();

        return boolval($usernameExists[0]);

    }

    /**
     * Find line text of the book that a user is at
     * @param $username
     * @return int line id
     * @internal param $password
     */
    function findLineIdForAccount($username) {
        $query = "SELECT line_id FROM accounts 
                  WHERE username=?
                 ";

        $stmt = $this -> pdo -> prepare($query);
        $stmt -> bindParam(1, $username);

        $stmt -> execute();

        $lineId = $stmt -> fetch();

        return $lineId;
    }

    /**
     * Find line text of the book that a user is at
     * @param $username
     * @return text of the line
     * @internal param $password
     */
    function findLineForAccount($username) {
        $query = "SELECT text FROM Lines 
                  WHERE id=(SELECT line_id
                    FROM Accounts
                    WHERE username = ?)
                 ";

        $stmt = $this -> pdo -> prepare($query);
        $stmt -> bindParam(1, $username);

        $stmt -> execute();

        $line = $stmt -> fetch();

        return $line;
    }

    /**
     * Find number of login attempts for a user
     *
     * @param $username
     * @return mixed number of login attempts
     */
    function findLoginAttempts($username) {
        $query = "SELECT login_attempts
                    FROM accounts
                    WHERE username = ?
                 ";

        $stmt = $this -> pdo -> prepare($query);
        $stmt -> bindParam(1, $username);

        $stmt -> execute();

        $loginAttempts = $stmt -> fetch();

        return $loginAttempts[0];
    }
    /**
     * Increments login attempts
     *
     * @param $username
     */
    function updateLoginAttemptsIncrement($username) {
        $query = "UPDATE accounts SET login_attempts=login_attempts+1 WHERE username=?";

        $stmt = $this -> pdo -> prepare($query);
        $stmt -> bindParam(1, $username);

        $stmt->execute();
    }

    /**
     * Resets the login attempts to 0
     *
     * @param $username
     */
    function updateResetLoginAttempts($username) {
        $query = "UPDATE accounts SET login_attempts=0 WHERE username=?";

        $stmt = $this -> pdo -> prepare($query);
        $stmt -> bindParam(1, $username);

        $stmt->execute();
    }

    function closeConnection() {
        unset($this->pdo);
    }
}