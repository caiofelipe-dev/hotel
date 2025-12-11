<?php

namespace App\Components;

use Fmk\Facades\Component;

class CardComponent extends Component {
    protected $tag = 'div';
    protected $header;
    protected $body;
    protected $tab_content;
    protected $attributes = ["class"=>["card"]];

    /**
     * $exem = [
     *      "header" => "Titulo",
     *      "nav"
     * ]
     */
    // component("titulo")
    public function addContent($content)
    {   
        return parent::addContent($content);
    }

    public function header($header) {
        if(!isset($this->header)) {
            
            $this->header = &$this->addContent(
                component()->tag('div')->class("card-header")->addContent("<h4>$header</h4>")
            )->getContentFirst();
            
            $this->body = &$this->addContent(
                component()->tag('div')->class('card-body')
            )->$this->getContentByKey(1);

        } else $this->header->updateContent("<h4>$header</h4>");
        
        return $this;
    }
    
    public function navLine() {}
    public function navPills() {}

    protected function tabContent(string $p) {
        $this->tab_content = component()->tag('div')->class("tab-content");
    }
    public function p(string ...$p) {
        if(is_array($p)) {

        }
    }
}