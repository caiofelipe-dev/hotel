<?php
if(!function_exists('getParams')) {
    function getParams(string|object $function, NULL|string|object $class) {
        if(!$function instanceof ReflectionFunctionAbstract) {
            $params = (!$class) ? (new ReflectionFunction($function))->getParameters() 
                                : (new ReflectionClass($class))->getMethod($function)->getParameters() ;
        } else
            $params = $function->getParameters();
        $names = [];
        foreach($params as $param) {
            $names[] = $param->getName();
        }
        return $names;
    }
}

if(!function_exists('getAttributes')) {
    function getAttributes(string|object $class) {
        $attributes = (new ReflectionClass($class))->getAttributes();
        $names = [];
        foreach($attributes as $attr) {
            $names[] = $attr->getName();
        }
        return $names;
    }
}