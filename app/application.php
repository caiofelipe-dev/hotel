<?php

use Fmk\Initialize;

require_once __DIR__ . DIRECTORY_SEPARATOR . '../vendor/autoload.php';

Initialize::createConstants(require __DIR__ . '/configs/app.php');
Initialize::run();

// Carregar helpers do aplicativo
foreach (glob(__DIR__ . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . '*.php') as $helper_file) {
    require_once $helper_file;
}

require_once __DIR__ . '/configs/routes.php';