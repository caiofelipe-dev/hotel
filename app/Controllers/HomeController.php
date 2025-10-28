<?php

namespace App\Controllers;

use Fmk\Facades\Controller;
use Fmk\Facades\Database\Drivers\Mysql;
use Fmk\Facades\Request;
use Fmk\Facades\Session;

class HomeController extends Controller {
    public function index() {
        
        return view('home', ['user'=>'Caio']);
    }
}