<?php

if(!function_exists('getRouteBy')) {
    function getRouteBy($route) {
        if(!($route instanceof Fmk\Facades\Route))
            return route($route) || Fmk\Facades\Router::getRouteByUri($route);
        return $route;
    }
}