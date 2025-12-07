<?php

use App\Components\ItemMenuComponent;

if(!function_exists('item')) {
    function item($label, $route, $icon = NULL, ?bool $sub_item = NULL, ?string $tag = NULL, NULL|string|array $classes = NULL, ?string $active_class = NULL) {
        $data = array_filter(compact($label, $route, $icon));
        $componente = component('item', $data);
        if($classes)
            $componente->class($classes);
        if($tag)
            $componente->tag($tag);
            
        return $componente;
    }
}