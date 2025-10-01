<?php


require_once __DIR__ . '/../app/application.php';

use Fmk\Facades\Request;
Request::exec();

// echo "<pre>";
// $home = new HomeController();
// $sla = call_user_func_array([$home, 'index'], [Request::getInstance(), 11, '33']);
// var_dump($sla);