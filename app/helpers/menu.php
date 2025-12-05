<?php

use Fmk\Facades\Request;

/**
 * Detecta se a rota atual é a rota passada como parâmetro
 * 
 * Normaliza ambas as URIs (remove barras) e compara de forma exata.
 * 
 * @param string $routePath Caminho da rota para comparar (ex: '/', '/quartos')
 * @return bool True se a URI atual corresponde à rota
 */
if (!function_exists('is_route_active')) {
    function is_route_active($routePath)
    {
        try {
            $currentUri = Request::getInstance()->getUri();
            
            $currentUri = trim($currentUri, '/');
            $routePath = trim($routePath, '/');
            
            return $currentUri === $routePath;
        } catch (\Exception $e) {
            return false;
        }
    }
}
