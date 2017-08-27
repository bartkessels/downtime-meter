<?php

namespace Controllers;

use PDO;

class Database
{
    /**
     * Create the tables needed by the application
     *
     * @return void
     */
    public function createTables()
    {
        $pdo = $this->connect();

        $pdo->exec('
            CREATE TABLE IF NOT EXISTS downtime (
                time DATETIME NOT NULL,
                down INT(1) NOT NULL,

                CONSTRAINT pk_downtime PRIMARY KEY (time, down)
            );
        ');
    }

    /**
     * Insert the current status of the internet downtime
     *
     * @param int $status
     * @return void
     */
    public function insertDownTime(int $status)
    {
        $pdo = $this->connect();

        $stmt = $pdo->prepare('INSERT INTO downtime (time, down) VALUES (NOW(), :status)');
        $stmt->execute([
            'status'    => $status  
        ]);
    }

    /**
     * Create a connection to the database
     *
     * @return void
     */
    public function connect()
    {
        $connection = new PDO('mysql:host='.DATABASE_HOST.';dbname='.DATABASE_NAME, DATABASE_USER, DATABASE_PASSWORD);

        return $connection;
    }
}