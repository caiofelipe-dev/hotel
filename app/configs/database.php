<?php

return [
    'connection_default' => 'hotel',
    'hotel' => [
        'driver' => 'mariadb',
        'host' => 'localhost',
        'port' => 3306,
        'database' => 'hotel', // nome do schema usado pelo projeto
        'username' => 'root',
        'password' => 'admin',
        'options' => [],
    ]
];