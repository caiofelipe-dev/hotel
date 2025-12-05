<?php

namespace App\Components;

use Fmk\Facades\Component;

/**
 * MenuComponent - Renderiza o menu lateral da aplicação
 * 
 * Responsabilidades:
 * - Renderizar estrutura do menu com seções e itens
 * - Detectar rota ativa e aplicar estilos
 * - Renderizar submenus colapsáveis
 * - Sanitizar saídas contra XSS
 */
class MenuComponent extends Component
{
    protected $items = [];
    protected $user = 'Guest';
    protected $activeClass = 'active';

    public function __construct()
    {
        parent::__construct('');
    }

    public function setData(array $data)
    {
        $this->items = $data['items'] ?? [];
        $this->user = $data['user'] ?? 'Guest';
        $this->activeClass = $data['activeClass'] ?? 'active';
        return $this;
    }

    public function render(array $data = [])
    {
        ob_start();
        $this->renderNav();
        return ob_get_clean();
    }

    private function renderNav()
    {
        ?>
<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <?php $this->renderMenuItems(); ?>
        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div class="small">Logged in as:</div>
        <?= htmlspecialchars($this->user) ?>
    </div>
</nav>
        <?php
    }

    private function renderMenuItems()
    {
        if (empty($this->items)) {
            $this->renderEmptyState();
            return;
        }

        foreach ($this->items as $section) {
            $this->renderSection($section);
        }
    }

    private function renderSection(array $section)
    {
        if (!isset($section['heading'], $section['links'])) {
            return;
        }

        ?>
        <div class="sb-sidenav-menu-heading"><?= htmlspecialchars($section['heading']) ?></div>
        <?php

        foreach ($section['links'] as $link) {
            $this->renderLink($link);
        }
    }

    private function renderLink(array $link)
    {
        $href = htmlspecialchars($link['href']);
        $isActive = is_route_active($link['href']);
        $activeClass = $isActive ? ' ' . $this->activeClass : '';
        $hasSubmenu = isset($link['submenu']);
        $collapseClass = $hasSubmenu ? ' collapsed' : '';
        ?>
        <a class="nav-link<?= $activeClass ?><?= $collapseClass ?>" 
           href="<?= $href ?>" 
           <?php if ($hasSubmenu): ?>
           data-bs-toggle="collapse" 
           data-bs-target="#<?= $link['id'] ?>" 
           aria-expanded="<?= $isActive ? 'true' : 'false' ?>"
           <?php endif; ?>>
            <div class="sb-nav-link-icon"><i class="<?= htmlspecialchars($link['icon']) ?>"></i></div>
            <?= htmlspecialchars($link['label']) ?>
            <?php if ($hasSubmenu): ?>
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            <?php endif; ?>
        </a>
        <?php

        if ($hasSubmenu) {
            $this->renderSubmenu($link, $isActive);
        }
    }

    private function renderSubmenu(array $link, $isActive)
    {
        ?>
        <div class="collapse<?= $isActive ? ' show' : '' ?>" id="<?= $link['id'] ?>" data-bs-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
                <?php foreach ($link['submenu'] as $sublink): ?>
                    <?php $subActive = is_route_active($sublink['href']); ?>
                    <a class="nav-link<?= $subActive ? ' ' . $this->activeClass : '' ?>" 
                       href="<?= htmlspecialchars($sublink['href']) ?>">
                        <?= htmlspecialchars($sublink['label']) ?>
                    </a>
                <?php endforeach; ?>
            </nav>
        </div>
        <?php
    }

    private function renderEmptyState()
    {
        ?>
        <div class="sb-sidenav-menu-heading">Menu</div>
        <p class="text-muted ps-3">Nenhum item de menu configurado</p>
        <?php
    }
}