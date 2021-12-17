<?php

namespace App\Database;

use App\Core\Application;

class m0001_create_users_table
{
    private $builder;

    public function __construct()
    {
        $this->builder = Application::get('database');
    }

    public function up()
    {
        $query = "CREATE TABLE users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(255) NOT NULL,
                name VARCHAR(255) NOT NULL,
                password VARCHAR(512) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )  ENGINE=INNODB;";

        $this->builder->execute($query);
    }

    public function down()
    {
        $query = "DROP TABLE users;";
        $this->builder->execute($query);
    }
}