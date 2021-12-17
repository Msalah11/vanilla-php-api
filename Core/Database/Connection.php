<?php

namespace App\Core\Database;

use PDO;
use PDOException;

class Connection
{

    /**
     * Create a new PDO connection.
     *
     * @param array $databaseConfig
     * @return PDO
     */
    public static function make(array $databaseConfig): PDO
    {
        try {
            return new PDO(
                $databaseConfig['connection'] . ';dbname=' . $databaseConfig['name'],
                $databaseConfig['username'],
                $databaseConfig['password'],
                $databaseConfig['options']
            );
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}