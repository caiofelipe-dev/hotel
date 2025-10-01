<?php

return [
    'NoAuth' => App\Middlewares\NoAuthenticateMiddleware::class,
    'Auth' => App\Middlewares\AuthenticateMiddleware::class
];