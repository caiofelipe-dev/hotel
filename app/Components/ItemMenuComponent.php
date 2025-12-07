<?php

namespace App\Components;

use Exception;
use Fmk\Facades\Component;
use Fmk\Facades\Route;
use Fmk\Facades\Router;

class ItemMenuComponent extends Component {
    protected $label;
    protected $route;
    protected $icon;
    protected $sub_item = false;
    protected $active = false;
    protected $active_class;
    protected $items = [];

    public function __construct() {
    }

    // ['label' => 'Início', 'route' => 'home']
    public function addContent($contents) {
        $this->sub_item = $contents['sub_item'] ?? false;
        if(!$this->sub_item) {
            if(!$contents['url']) {
                $route = $contents['route'] ?? throw new Exception('Rota não definida na criação do menu!');
                $this->route = getRouteBy($route) ?? throw new Exception("Rota $route não encontrada na criação do menu!");
            } else {
                $this->route = $contents['url'];
            }
        }
        
        $this->label = $contents['label'] ?? '?????';
        $this->active = ($this->route) ? $this->route->isActive() : false;
        $this->icon = $contents['icon'] ?? NULL;
        $this->active_class = $contents['active_class'] ?? NULL;
        $this->tag = $contents['tag'] ?? NULL;
        $this->classes = $contents['classes'] ?? NULL;
        
        return $this;
    }

    public function setContent($data) {
        parent::addContent($data);
    }

    public function setActiveClass(string $active) {
        $this->active_class = $active;
        return $this;
    }

    public function subItem($label, $route, $icon = NULL, ?string $tag = NULL, NULL|string|array $classes = NULL, ?string $active_class = NULL) {
        $this->items[] = item($label, $route, $icon, false, $tag, $classes, $active_class);
        $this->sub_item = isset($this->items);
        return $this;
    }

    public function getRoute() {
        return $this->route;
    }
    public function getIcon() {
        $icons = explode(' ', $this->icon);
        return $icons;
    }
    public function hasSubItem() {
        return $this->sub_item;
    }
    public function getSubItems() {
        return $this->items;
    }
}