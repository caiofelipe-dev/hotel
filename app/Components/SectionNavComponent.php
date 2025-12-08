<?php

namespace App\Components;

use Exception;
use Fmk\Facades\Component;
use Fmk\Facades\Route;
use Fmk\Facades\Router;

class SectionNavComponent extends Component {
    protected $items = [];
    protected $header;
    protected $tag = '';
    

    protected function __construct() {
    }

    /*
        $items[] = item('Página Inicial', 'home', 'fas fa-home');
        $items[] = item('Menuzin', '')
        echo component('section', $items)->header('Principal');
    */
    public function addContent($items) {
        if(is_array($items)) {
            foreach($items as $item) {
                if($item instanceof ItemMenuComponent) {
                    $this->item = $this->convertItem($item);
                    continue;
                }
                $this->items[] = component('item', $item);
            }
        }
        $this->items[] = ($items instanceof ItemMenuComponent) ? $items : throw new Exception("$items não é um argumento válido para o método addContent() do componente 'section'.");
        
        return $this;
    }
    /*
    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="true" aria-controls="collapseLayouts">
        <div class="sb-nav-link-icon"><svg class="svg-inline--fa fa-table-columns" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="table-columns" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M0 96C0 60.7 28.7 32 64 32H448c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96zm64 64V416H224V160H64zm384 0H288V416H448V160z"></path></svg><!-- <i class="fas fa-columns"></i> Font Awesome fontawesome.com --></div>
        Layouts
        <div class="sb-sidenav-collapse-arrow"><svg class="svg-inline--fa fa-angle-down" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg=""><path fill="currentColor" d="M169.4 342.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 274.7 54.6 137.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z"></path></svg><!-- <i class="fas fa-angle-down"></i> Font Awesome fontawesome.com --></div>
    </a>
    */
    protected $sub_a_attrs = [
        "data-bs-toggle"=>"collapse",
        "data-bs-target"=>"#collapseLayouts",
        "aria-expanded"=>"true",
        "aria-controls"=>"collapseLayouts",
    ];
    protected $sub_div_attrs = [
        "aria-labelledby"=>"headingOne",
        "data-bs-parent"=>"#sidenavAccordion",
        "style"=>"",
    ];
    protected $sub_arrow_icon = ['fas, fa-angle-down'];

    protected function convertItem(ItemMenuComponent $item) {
        $item->tag('a')->class('nav-link')->attr('href', "{$item->getRoute()}");            
        if ($item->hasSubItem()) {
            $icon = component()->tag('div')->class('sb-nav-link-icon')
                ->addContent(component()->tag('i')->class(...$item->getIcon()));
            $arrow = component()->tag('div')->class('sb-sidenav-collapse-arrow')
                ->addContent(component()->tag('i')->class(...$this->sub_arrow_icon));
            
            //<div class="collapse show" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion" style="">
            $collapse = component()->tag('div')->class("collapse", "show")->id("collapseLayouts")->attrs($this->sub_div_attrs);
            $nav = component()->tag('nav')->class('sb-sidenav-menu-nested nav');
            
            $item->attrs($this->sub_a_attrs)->setContent([$icon, $arrow]);
        } 
    }

    public function header(string $header) {
        $this->header = $header;
        return $this;
    }
    
    /*
    <div class="sb-sidenav-menu-heading">Principal</div>
    <a class="nav-link active collapsed" href="http://hotel.test/">
        <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
        Início
    </a>
    */
    protected function body() {
        $heading = (new Component())->tag('div')->addContent($this->header)->class('sb-sidenav-menu-heading');
        
        
    }
}