<?php

namespace App\Controllers;

use Fmk\Facades\Controller;
use Fmk\Facades\Request;
use Fmk\Facades\Session;

class HomeController extends Controller {
    public function index(): void {
        $db = new Mysql(['username'=>'root', 'password'=>'', 'database'=>'']);
        $db->getConnection();
        return view('home', ['user'=>'Caio']);
    }
}