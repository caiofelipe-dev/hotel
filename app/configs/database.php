<?php

return [
    'connection_default' => 'hotel',
    'hotel' => [
        'driver' => 'mariadb',
        'host' => 'localhost',
        'port' => 3306,
        'database' => 'hotel', // nome padrão, pode ser sobrescrito pelo SQL
        'username' => 'root',
        'password' => 'admin',
        'options' => [],
    ]
];