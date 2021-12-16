<?php

return [
    'mysql' => [
        'name' => 'vanilla_php', // Database Name
        'username' => 'root', // Database Username
        'password' => '', // Database Password
        'connection' => 'mysql:host=127.0.0.1', // Database Connection
        'options' => [ // Database Connection Options
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    ]
];