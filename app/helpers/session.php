<?php

use Fmk\Facades\Session;

/**
 * Helpers simples para manipular dados de sessão de forma consistente
 * Encapsula o uso de Session::getInstance() para que o restante da
 * aplicação não precise chamar getInstance() diretamente.
 * Comentários e nomes em português (pt-BR).
 */
if (!function_exists('session_get')) {
    function session_get(string $key, $default = null)
    {
        $val = Session::getInstance()->$key ?? $default;
        return $val;
    }
}

if (!function_exists('session_set')) {
    function session_set(string $key, $value): void
    {
        Session::getInstance()->$key = $value;
    }
}

if (!function_exists('session_has')) {
    function session_has(string $key): bool
    {
        return isset(Session::getInstance()->$key);
    }
}

if (!function_exists('session_forget')) {
    function session_forget(string $key): void
    {
        unset(Session::getInstance()->$key);
    }
}

if (!function_exists('session_push')) {
    function session_push(string $key, $value): void
    {
        $arr = Session::getInstance()->$key ?? [];
        $arr[] = $value;
        Session::getInstance()->$key = $arr;
    }
}
