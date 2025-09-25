<?php

namespace App\Middlewares;

use Fmk\Facades\Router;
use Fmk\Facades\Session;
use Fmk\Interfaces\Middleware;

class NoAuthenticateMiddleware implements Middleware {
    public function handle() {
        Router::getRouteByName('home')->redirect();
    }

    public function check(): bool {
        return !Session::userIsRegister();
    }
}