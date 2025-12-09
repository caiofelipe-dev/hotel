<?php

if(!function_exists('icon')){
    function icon($name){
        $name = is_array($name) ? $name : func_get_args();
        return \App\Components\IconComponent::addScript($name);
    }
}