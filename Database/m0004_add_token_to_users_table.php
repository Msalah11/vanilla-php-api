<?php

namespace App\Database;

use App\Core\Application;

class m0004_add_token_to_users_table
{
    private $builder;

    public function __construct()
    {
        $this->builder = Application::get('database');
    }

    public function up()
    {
        $query = "ALTER TABLE users ADD COLUMN token TEXT NULL AFTER password";

        $this->builder->execute($query);
    }

    public function down()
    {
        $query = "DROP TABLE users;";
        $this->builder->execute($query);
    }
}