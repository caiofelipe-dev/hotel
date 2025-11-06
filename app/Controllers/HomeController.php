<?php

namespace App\Controllers;

use Fmk\Facades\Controller;

class HomeController extends Controller {
    public function index() {
        
        return view('home', ['user'=>'Caio', 'title' => 'Dashboard']);
    }
}