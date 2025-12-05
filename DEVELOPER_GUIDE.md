# MenuComponent - Guia para Desenvolvedores

**Última Atualização:** 05/12/2025  
**Versão:** 3.0 (Refatorado com SOLID)

---

## 🎯 Visão Geral

O `MenuComponent` renderiza o menu lateral da aplicação com detecção automática de rota ativa.

**Características:**
- ✅ Renderização dinâmica baseada em array de dados
- ✅ Detecção automática de rota ativa
- ✅ Submenus colapsáveis
- ✅ XSS prevention integrada
- ✅ 100% SOLID compliant

---

## 📂 Arquivos Relacionados

| Arquivo | Propósito |
|---------|-----------|
| `app/Components/MenuComponent.php` | Componente principal |
| `app/helpers/menu.php` | Helper `is_route_active()` |
| `app/configs/components.php` | Mapeamento do componente |
| `app/views/templates/default.template.php` | Uso do componente |
| `public/assets/css/styles.css` | Estilos para menu ativo |

---

## 🚀 Como Usar

### Uso Básico

```php
// Em uma template
echo component('menu', [
    'items' => $menuItems,
    'user' => auth()->user()->name ?? 'Guest'
])->render();
```

### Estrutura de Dados

```php
$menuItems = [
    [
        'heading' => 'Core',
        'links' => [
            [
                'href' => '/',                    // URL/rota
                'icon' => 'fas fa-tachometer',   // Classe FontAwesome
                'label' => 'Dashboard',          // Texto do link
                'id' => ''                       // Sem submenu
            ]
        ]
    ],
    [
        'heading' => 'Gerenciamento',
        'links' => [
            [
                'href' => '/quartos',
                'icon' => 'fas fa-bed',
                'label' => 'Quartos',
                'id' => 'collapseQuartos',       // ID para collapse
                'submenu' => [                   // Array de sublinks
                    [
                        'href' => '/quartos',
                        'label' => 'Listar Quartos'
                    ],
                    [
                        'href' => '/quartos/novo',
                        'label' => 'Novo Quarto'
                    ]
                ]
            ]
        ]
    ]
];
```

---

## 🏗️ Arquitetura

### Hierarquia de Renderização

```
render()                    ← Orquestra renderização
  │
  └─ renderNav()           ← Estrutura <nav> raiz
      │
      └─ renderMenuItems() ← Iterar sobre seções
          │
          ├─ renderSection()        ← Renderizar seção (heading + links)
          │   │
          │   └─ renderLink()       ← Renderizar link individual
          │       │
          │       └─ renderSubmenu() ← Renderizar submenu colapsável
          │
          └─ renderEmptyState()    ← Se sem items
```

### Método por Responsabilidade

| Método | Responsabilidade |
|--------|------------------|
| `render()` | Buffer de saída, chamar renderNav() |
| `renderNav()` | Estrutura HTML da `<nav>` |
| `renderMenuItems()` | Iterar seções, decidir se vazio |
| `renderSection()` | Renderizar heading + iterar links |
| `renderLink()` | Renderizar um link, verificar submenu |
| `renderSubmenu()` | Renderizar submenu colapsável |
| `renderEmptyState()` | Mensagem quando sem items |

---

## 🔍 Detecção de Rota Ativa

### Como Funciona

```php
// Em renderLink()
$isActive = is_route_active($link['href']);

// Helper menu.php
function is_route_active($routePath) {
    $currentUri = Request::getInstance()->getUri();
    
    // Normalizar (remover /)
    $currentUri = trim($currentUri, '/');
    $routePath = trim($routePath, '/');
    
    // Comparação exata
    return $currentUri === $routePath;
}
```

### Exemplos

```php
// URL atual: /quartos
is_route_active('/')          → false
is_route_active('/quartos')   → true
is_route_active('/quartos/')  → true (normalizado)

// URL atual: /
is_route_active('/')          → true
is_route_active('')           → true (normalizado)
```

---

## 🎨 Styling

### Classes CSS

| Classe | Quando Aplicada | Estilo |
|--------|-----------------|--------|
| `.nav-link` | Sempre | Padrão |
| `.active` | Link ativo | Azul #0d6efd |
| `.collapsed` | Submenu não expandido | Seta colapsada |

### Personalizar Estilo

Edite `public/assets/css/styles.css`:

```css
/* Link ativo */
.sb-sidenav .nav-link.active {
    background-color: #0d6efd;      /* Altere aqui */
    color: white;
    border-left: 3px solid #0d6efd; /* Ou aqui */
}

/* Submenu ativo */
.sb-sidenav-menu-nested .nav-link.active {
    color: #0d6efd;                 /* Altere aqui */
}

/* Collapse expandido */
.sb-sidenav .collapse.show {
    background-color: rgba(13, 110, 253, 0.05); /* Altere aqui */
}
```

---

## 🧪 Como Testar

### Unit Tests Recomendados

```php
class MenuComponentTest extends TestCase
{
    public function test_render_returns_string()
    {
        $menu = new MenuComponent();
        $html = $menu->render();
        
        $this->assertIsString($html);
        $this->assertStringContainsString('sb-sidenav', $html);
    }
    
    public function test_render_with_items()
    {
        $menu = new MenuComponent();
        $menu->setData([
            'items' => [
                [
                    'heading' => 'Test',
                    'links' => [
                        [
                            'href' => '/test',
                            'icon' => 'fas fa-test',
                            'label' => 'Test Link',
                            'id' => ''
                        ]
                    ]
                ]
            ]
        ]);
        
        $html = $menu->render();
        
        $this->assertStringContainsString('Test Link', $html);
        $this->assertStringContainsString('/test', $html);
    }
    
    public function test_active_route_detection()
    {
        // Mock Request para retornar /quartos
        // Verificar que class 'active' é adicionada
    }
}
```

### Teste Manual

```php
// Em uma controller
$menuItems = [...];
$html = component('menu', [
    'items' => $menuItems,
    'user' => 'John Doe'
])->render();

echo $html; // Verificar HTML no browser
```

---

## 🔐 Segurança

### XSS Prevention

Todos os dados dinâmicos são sanitizados:

```php
// ✅ SEGURO - htmlspecialchars()
<?= htmlspecialchars($section['heading']) ?>
<?= htmlspecialchars($link['href']) ?>
<?= htmlspecialchars($link['label']) ?>
<?= htmlspecialchars($this->user) ?>
```

### Boas Práticas

1. **Nunca** passe user input diretamente ao componente
2. **Sempre** valide `$menuItems` antes
3. **Use** htmlspecialchars() se adicionar novos campos

---

## 🎓 Como Estender

### Criar Subclasse

```php
namespace App\Components;

class CustomMenuComponent extends MenuComponent
{
    // Override um método privado
    private function renderLink(array $link)
    {
        // Custom logic aqui
        
        // Chamar parent para resto
        parent::renderLink($link);
    }
}
```

### Adicionar Novo Tipo de Link

```php
// Em MenuComponent
private function renderLinkWithBadge(array $link)
{
    // Renderizar com badge
}

private function renderLink(array $link)
{
    if (isset($link['badge'])) {
        $this->renderLinkWithBadge($link);
        return;
    }
    
    // Resto do código
}
```

---

## 🐛 Debugging

### Logs Úteis

```php
// Verificar o que está sendo passado
error_log(json_encode($menuItems, JSON_PRETTY_PRINT));

// Verificar rota atual
error_log('Current URI: ' . Request::getInstance()->getUri());

// Verificar ativa detection
error_log('Is /quartos active? ' . (is_route_active('/quartos') ? 'yes' : 'no'));
```

### Problemas Comuns

| Problema | Causa | Solução |
|----------|-------|---------|
| Menu não renderiza | `items` vazio | Verificar dados |
| Rota nunca "ativa" | URI não bate | Verificar normalização |
| Styles quebrados | CSS não carregado | Verificar `styles.css` |
| XSS warning | Dados não sanitizados | Não passe user input direto |

---

## 📊 Performance

### Otimizações Futuras

1. **Cache**
   ```php
   // Cachear menu renderizado
   $key = 'menu_' . md5(json_encode($items));
   if (Cache::has($key)) {
       return Cache::get($key);
   }
   ```

2. **Lazy Load**
   ```php
   // Carregar submenus via AJAX
   // Apenas quando expandir
   ```

3. **Async Rendering**
   ```php
   // Para menus muito grandes
   // Usar componentes assíncronos
   ```

---

## 📚 Referências

### Documentação

- `REFACTORING_SOLID.md` - Análise SOLID
- `REFACTORING_CHANGELOG.md` - Mudanças
- `REFACTORING_VISUAL_BEFORE_AFTER.md` - Comparações

### Framework

- `framework/Facades/Component.php` - Classe base
- `framework/Facades/Request.php` - Request helper
- `app/configs/components.php` - Configuração

### Padrões

- SOLID Principles
- Template Method Pattern
- Component Pattern

---

## ✅ Checklist para Modificações

Ao modificar MenuComponent:

- [ ] Preservar interface pública (`render()`, `setData()`)
- [ ] Manter SOLID principles
- [ ] Adicionar tests para novos métodos
- [ ] Documentar mudanças
- [ ] Testar XSS prevention
- [ ] Atualizar this guide se necessário
- [ ] Code review com team

---

## 🆘 Suporte

### Dúvidas?

1. Leia a documentação em `REFACTORING_*` files
2. Verifique examples nesse arquivo
3. Procure no código comentários PHPDoc
4. Execute testes para ver comportamento

### Bugs?

1. Crie teste que reproduz bug
2. Adicione log/debug
3. Fixar mantendo SOLID
4. Adicionar teste para prevenir regressão

---

## 🚀 Próximas Ideias

1. **Breadcrumb Automático**
   ```php
   // Baseado em menu ativo
   Dashboard > Gerenciamento > Quartos
   ```

2. **Permission Checks**
   ```php
   // Se user não pode acessar, não renderizar
   if (!auth()->can('access_' . $link['id'])) continue;
   ```

3. **Menu Cache**
   ```php
   // Cache por user role
   ```

4. **Dynamic Routes**
   ```php
   // Suportar rotas com parâmetros
   /quartos/{id}/editar
   ```

---

**Data:** 05/12/2025  
**Versão:** 3.0  
**Status:** Pronto para manutenção e extensão
