<?php

use Fmk\Initialize;

require_once __DIR__ . DIRECTORY_SEPARATOR . '../vendor/autoload.php';

Initialize::createConstants(require __DIR__ . '/configs/constants.php');
Initialize::run();

require_once __DIR__ . '/configs/routes.php';