<?php

namespace App\Components;

use Exception;
use Fmk\Facades\Component;
use Fmk\Facades\Route;
use Fmk\Facades\Router;

class SectionNavComponent extends Component {
    protected $header;
    protected $tag = '';

    protected $active_class = 'active';

    public function __construct() {
    }

    /*
        $items[] = item('Página Inicial', 'home', 'fas fa-home');
        $items[] = item('Menuzin', '')
        echo component('section', $items)->header('Principal');
    */
    public function addContent($items) {
        if(is_array($items)) {
            if((array_key_exists('label', $items) || array_key_exists('route', $items) || array_key_exists('url', $items)))
                return $this->addContent(item(($items['label'] ?? NULL), ($items['route'] ?? $items['url']), ($items['icon'] ?? NULL)));
            foreach($items as $item)
                $this->addContent($item);
            return $this;
        }
        if(!($items instanceof ItemMenuComponent))
            parent::addContent($items);
        else
            $this->convertItem($items);
        
        return $this;
    }

    /*
     <li class="nav-item">
        <a href="widgets.html">
            <i class="fas fa-desktop"></i>
            <p>Widgets</p>
            <span class="badge badge-success">4</span>
        </a>
        </li>
     */
    protected function convertItem(ItemMenuComponent &$item) {
        $active = $this->itemActive($item);
        
        $a = component()->tag('a')->attr('href', ($item->getRoute() ?? "#"))
            ->addContent(/* Div do ícone */ component()->tag('i')->class(...($item->getIcon() ?? [])))
            ->addContent(/* Label */ component()->tag('p')->addContent("{$item->getLabel()}"));
        $item->tag('li')->class('nav-item')->setContent($a);
        
        if($item->hasSubItem()) {
            $item->setContent($this->convertSubItem($item, $a, $active));
            $a->attr('data-bs-target',"#$item->trimLabel")->attr("aria-expanded", "true");
        }
        return $this->content[] = $item;
    }

    protected function itemActive(ItemMenuComponent &$item) {
        $active = $item->isActive();
        if($active)
            $item->class(($item->getActiveClass() ?? $this->active_class));
        return $active;
    }
    
    protected function convertSubItem(ItemMenuComponent &$item, &$item_a, $active) {
        $item_a->attr('data-bs-toggle','collapse')
                ->addContent(/* SETINHA */ component()->tag("span")->class('caret'));
                    
                    $div = component()->tag('div')->class('collapse')->id($item->trimLabel)->class(($active ? "show" : NULL));
        $ul = component()->tag('ul')->class('nav', 'nav-collapse');
        
        foreach($item->getSubItems() as $sub_item) {
            $active = $this->itemActive($sub_item);
            $a = component()->tag("a")->addContent(
                    component()->tag('span')->addContent($sub_item->getLabel())->class('sub-item')
                )->attr('href', "".$sub_item->getRoute());
            $sub_item->setContent($a)->tag("li");
            $ul->addContent($sub_item);
            
            if($sub_item->hasSubItem()) {
                $sub_item->setContent($this->convertSubItem($sub_item, $a, $active));
                $ul->class('subnav');
            }
        }
        return $div->addContent($ul);
    }

    /**
     * Cria um componente Header e o joga pra riba do array $content
     * @param string $header
     * @return static
     */
    public function header(string $header) {
        if(is_null($this->header)) {
            $this->header = $header;
            array_unshift($this->content, $this->body());
            return $this;
        }
        if($header === $this->header)
            return $this;

        $first = &$this->getContentFirst();
        if($first instanceof Component && $first->renderContents() === $this->header)
            $first->updateContent($header);
        return $this;
    }
    
    /*
        <li class="nav-section">
            <span class="sidebar-mini-icon">
                <i class="fa fa-ellipsis-h"></i>
            </span>
            <h4 class="text-section">Components</h4>
        </li>
    */
    protected function body() {
        return (new Component())->tag('li')->class('nav-section')
            ->addContent(
                component()->tag('span')->class('sidebar-mini-icon')->addContent(
                    component()->tag('i')->class("fa", "fa-ellipsis-h")
                )
            )->addContent(
                component()->tag("h4")->class('text-section')->addContent("{$this->header}")
            );
    }

    public function setActiveClass(string $active) {
        $this->active_class = $active;
        return $this;
    }
}