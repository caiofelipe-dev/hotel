<?php

namespace App\Components;

use Fmk\Components\ScriptsComponent;

class IconComponent extends ScriptsComponent
{
    protected static $instance;
    protected function __construct(){
        parent::__construct('imgs.php');
    }
  
    public static function renderScript($src){
        return "<link rel=\"icon\" href=\"$src\" type=\"image/x-icon\">\n";
    }

    
}