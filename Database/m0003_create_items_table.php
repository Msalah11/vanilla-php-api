<?php

namespace App\Database;

use App\Core\Application;

class m0003_create_items_table
{
    private $builder;

    public function __construct()
    {
        $this->builder = Application::get('database');
    }

    public function up()
    {
        $query = "CREATE TABLE items (
                id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
                list_id VARCHAR(36) NOT NULL,
                name VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (list_id) REFERENCES lists(id)
            )  ENGINE=INNODB;";

        $this->builder->execute($query);
    }

    public function down()
    {
        $query = "DROP TABLE items;";
        $this->builder->execute($query);
    }
}
