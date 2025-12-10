<?php

namespace App\Components;

use Fmk\Facades\Component as BaseComponent;
use Fmk\Facades\Request;

class SectionNavComponent extends BaseComponent {
    protected $content = [];
    protected $header;
    protected $active_class = 'active';

    public function __construct() {
    }

    public function render(array $data = []) {
        return "<ul class=\"nav nav-secondary\">" . implode('', array_map(function($item) {
            return $item->render();
        }, $this->content)) . "</ul>";
    }

    /**
     * Adiciona um item ao componente
     * @param ItemMenuComponent $item
     * @return $this
     */
    public function addItem(ItemMenuComponent $item) {
        $this->convertItem($item);
        return $this;
    }

    // Override addContent to accept arrays or ItemMenuComponent instances
    public function addContent($content) {
        // If associative array describing a single item
        if (is_array($content) && count($content) && array_keys($content) !== range(0, count($content) - 1)) {
            $label = $content['label'] ?? '?????';
            $route = $content['route'] ?? ($content['url'] ?? null);
            $icon = $content['icon'] ?? null;
            $sub_item = $content['sub_item'] ?? false;
            $tag = $content['tag'] ?? null;
            $classes = $content['classes'] ?? null;
            $active_class = $content['active_class'] ?? null;

            $item = item($label, $route, $icon, $sub_item, $tag, $classes, $active_class);
            $this->convertItem($item);
            return $this;
        }

        // If numeric array of items
        if (is_array($content)) {
            foreach ($content as $c) {
                $this->addContent($c);
            }
            return $this;
        }

        // If already an ItemMenuComponent
        if ($content instanceof ItemMenuComponent) {
            $this->convertItem($content);
            return $this;
        }

        // Fallback to parent behavior
        parent::addContent($content);
        return $this;
    }

    /**
     * Obtém URL amigável do item
     * @param ItemMenuComponent $item
     * @return string
     */
    protected function getItemUrl(ItemMenuComponent &$item) {
        return $item->getRoute() ?? '';
    }

    /*
        <li class="nav-item">
            <a
              data-bs-toggle="collapse"
              href="#dashboard"
              aria-expanded="false"
            >
              <i class="fas fa-home"></i>
              <p>Dashboard</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="dashboard">
              <ul class="nav nav-collapse">
                <li>
                  <a href="../../index.html">
                    <span class="sub-item">Dashboard 1</span>
                  </a>
                </li>
              </ul>
            </div>
        </li>
     */
    protected function convertItem(ItemMenuComponent &$item) {
        $has_subitem = $item->hasSubItem();
        $active = $this->itemActive($item);

        $a = component()->tag('a');
        
        // Set href: do NOT set href for collapse triggers (breaks Bootstrap Collapse);
        // only set for leaf items
        if ($has_subitem) {
            // For collapse triggers: no href, add accessibility attributes
            $a->attr('role', 'button')
              ->attr('tabindex', '0');
        } else {
            // For leaf items: set href to the route
            $a->attr('href', $item->getRoute() ?? "#");
        }
        
        // Add icon and label
        $a->addContent(component()->tag('i')->class(...($item->getIcon() ?? [])))
          ->addContent(component()->tag('p')->addContent("{$item->getLabel()}"));

        // If has submenu, add collapse attributes and caret
        if ($has_subitem) {
            // Add caret
            $a->addContent(component()->tag('span')->class('caret'));
            
            // Add collapse attributes
            $a->attr('data-bs-toggle', 'collapse')
              ->attr('data-bs-target', "#{$item->trimLabel}");
            
            // Don't add 'collapsed' class - kaiadmin.js and Bootstrap 5 handle it
            $a->attr('aria-expanded', $active ? 'true' : 'false');
        }

        // Create li element
        $item->tag('li')->class('nav-item')->setContent($a);
        
        // Add 'active' class if:
        // - It's a leaf item AND active, OR
        // - It has subitems AND at least one subitem is active
        $should_be_active = $active;
        if ($has_subitem && !$active) {
            // Check if any subitem is active
            foreach ($item->getSubItems() as $sub_item) {
                if ($this->itemActive($sub_item)) {
                    $should_be_active = true;
                    break;
                }
            }
        }
        
        if ($should_be_active) {
            $item->class('active');
            // Also add 'submenu' class when has subitems and is active
            // This applies the background styling from kaiadmin.css
            if ($has_subitem) {
                $item->class('submenu');
            }
        }

        // If has subitems, append the collapse div
        if ($has_subitem) {
            // Pass $active so the collapse div can have 'show' class if active
            $item->setContent($this->convertSubItem($item, $a, $active));
        }

        $this->content[] = $item;
        return $item;
    }

    protected function itemActive(ItemMenuComponent &$item) {
        $active = $item->isActive();
        if($active)
            $item->class(($item->getActiveClass() ?? $this->active_class));
        return $active;
    }
    
    protected function convertSubItem(ItemMenuComponent &$item, &$item_a, $active) {
        // The caret was already added in convertItem

        // Add 'show' class to collapse div if any subitem is active
        $div = component()->tag('div')->class('collapse')->id($item->trimLabel);
        if ($active) {
            $div->class('show');
        }

        $ul = component()->tag('ul')->class('nav', 'nav-collapse');

        foreach ($item->getSubItems() as $sub_item) {
            $sub_active = $this->itemActive($sub_item);

            $href = $sub_item->getRoute();
            $href = $href ? (string)$href : '#';
            $a = component()->tag('a')
                ->attr('href', $href)
                ->addContent(component()->tag('span')->addContent($sub_item->getLabel())->class('sub-item'));

            $sub_item->tag('li')->setContent($a);
            
            // Add 'active' class to subitem li when subitem is active
            if ($sub_active) {
                $sub_item->class('active');
            }
            
            $ul->addContent($sub_item);

            if ($sub_item->hasSubItem()) {
                // recursive nesting (max 2 levels supported by template)
                $sub_item->setContent($this->convertSubItem($sub_item, $a, $sub_active));
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
        if($first instanceof BaseComponent && $first->getContents() === $this->header)
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
        return (new BaseComponent())->tag('li')->class('nav-section')
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
