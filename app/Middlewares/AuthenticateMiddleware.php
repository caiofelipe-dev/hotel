<?php

namespace App\Middlewares;

use Fmk\Facades\Router;
use Fmk\Facades\Session;
use Fmk\Interfaces\Middleware;

class AuthenticateMiddleware implements Middleware {
    public function handle() {
        Router::getRouteByName('login')->redirect();
    }
    public function check():bool {
        return Session::userIsRegister();
    }
}