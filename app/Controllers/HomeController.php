<?php

namespace App\Controllers;

use Fmk\Facades\Controller;
use Fmk\Facades\Request;
use Fmk\Facades\Session;

class HomeController extends Controller {
    public function index(Session $request, $b, $a): void {
        echo "HOMER recebe $a e $b, e o Request:<br><pre>";
        var_dump($request);
    }
}