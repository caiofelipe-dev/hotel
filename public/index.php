<?php

use Fmk\Facades\Request;
use Fmk\Facades\Session;

require_once __DIR__ . '/../app/application.php';
echo "<pre>";
Request::exec();
echo "<br>";
echo "<br>";
$sla = Request::all();
var_dump($sla);
// var_dump($_SERVER);