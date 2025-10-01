<?php

namespace App\Controllers;

use Fmk\Facades\Controller;
use Fmk\Facades\Request;

class HomeController extends Controller {
    public function index(Request $request, $b, $a): void {
        echo "HOMER recebe $a e $b, só falta o Request:<br><pre>";
        var_dump($request);
    }
}