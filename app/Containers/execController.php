<?php

namespace App\Containers;

use Exception;
use Fmk\Facades\Controller;

class execController extends Container{
    public function __construct(string|Controller $controller_name, string $method_name, ?array $params = NULL) {
        $controller = $this->setController($controller_name);
        if($controller) {
            $this->setCallback($controller, $method_name, $params);
        } else {
            throw new Exception("$controller_name não é uma classe do tipo Controller.");
        }
    }

    /**
     * Verifica se uma classe herda Controller
     * @param string|object $class
     * @return bool|Controller
     */
    private function setController(string|object $class) {
        $class = !is_object($class) ? new $class : $class;
        if($class instanceof Controller) {
            return $this->object = $class;
        }
        return false;
    }
}