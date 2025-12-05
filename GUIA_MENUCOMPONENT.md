# 🚀 Guia de Uso - MenuComponent Dinâmico

## 📌 Visão Geral

O `MenuComponent` agora é um componente totalmente dinâmico que renderiza o menu lateral com base em dados passados. Não há mais HTML estático hardcoded.

---

## 🔧 Como Funciona

### 1. **Estrutura de Dados do Menu**

Cada item do menu é definido como um array com a seguinte estrutura:

```php
[
    'heading' => 'Nome da Seção',  // Opcional - exibe um cabeçalho
    'links' => [
        [
            'href'     => '/url-do-link',           // URL do link
            'icon'     => 'fas fa-icon-name',      // Classe FontAwesome
            'label'    => 'Texto do Item',         // Texto exibido
            'id'       => 'collapseID',            // ID único (necessário para submenus)
            'submenu'  => [                        // Opcional - submenus
                ['href' => '/sub-url', 'label' => 'Item Sub'],
                // ... mais subitens
            ]
        ]
    ]
]
```

### 2. **Exemplo de Uso Completo**

```php
<?php
// No seu template ou controller
$menuItems = [
    [
        'heading' => 'Core',
        'links' => [
            [
                'href' => '/dashboard',
                'icon' => 'fas fa-tachometer-alt',
                'label' => 'Dashboard',
                'id' => ''
            ]
        ]
    ],
    [
        'heading' => 'Gerenciamento',
        'links' => [
            [
                'href' => '#',
                'icon' => 'fas fa-users',
                'label' => 'Usuários',
                'id' => 'collapseUsers',
                'submenu' => [
                    ['href' => '/users/create', 'label' => 'Criar Usuário'],
                    ['href' => '/users', 'label' => 'Listar Usuários'],
                    ['href' => '/users/roles', 'label' => 'Funções']
                ]
            ],
            [
                'href' => '/settings',
                'icon' => 'fas fa-cog',
                'label' => 'Configurações',
                'id' => ''
            ]
        ]
    ]
];

// Renderizar o componente
echo component(App\Components\MenuComponent::class, [
    'items' => $menuItems,
    'user' => auth()->user()->name ?? 'Guest'
])->render();
?>
```

---

## 🎯 Casos de Uso

### Caso 1: Menu Simples (sem submenus)

```php
$menuItems = [
    [
        'heading' => 'Main',
        'links' => [
            ['href' => '/home', 'icon' => 'fas fa-home', 'label' => 'Home', 'id' => ''],
            ['href' => '/about', 'icon' => 'fas fa-info', 'label' => 'About', 'id' => ''],
            ['href' => '/contact', 'icon' => 'fas fa-envelope', 'label' => 'Contact', 'id' => ''],
        ]
    ]
];
```

### Caso 2: Menu com Submenus (colapsável)

```php
$menuItems = [
    [
        'heading' => 'Administrativo',
        'links' => [
            [
                'href' => '#',
                'icon' => 'fas fa-th-large',
                'label' => 'Quartos',
                'id' => 'collapseQuartos',
                'submenu' => [
                    ['href' => '/quartos', 'label' => 'Listar Quartos'],
                    ['href' => '/quartos/create', 'label' => 'Novo Quarto'],
                    ['href' => '/quartos/tipos', 'label' => 'Tipos de Quarto']
                ]
            ]
        ]
    ]
];
```

### Caso 3: Menu Dinâmico com Banco de Dados

```php
// No Controller
public function index()
{
    $menuItems = []; // Array que será preenchido dinamicamente
    
    // Buscar seções do menu do banco de dados
    $sections = DB::table('menu_sections')->get();
    
    foreach ($sections as $section) {
        $links = [];
        $items = DB::table('menu_items')
                    ->where('section_id', $section->id)
                    ->get();
        
        foreach ($items as $item) {
            $link = [
                'href' => $item->url,
                'icon' => $item->icon,
                'label' => $item->label,
                'id' => 'collapse' . ucfirst($item->slug)
            ];
            
            // Se tem submenus
            if ($item->has_submenu) {
                $submenus = DB::table('menu_items')
                            ->where('parent_id', $item->id)
                            ->get();
                
                $link['submenu'] = $submenus->map(fn($sub) => [
                    'href' => $sub->url,
                    'label' => $sub->label
                ])->toArray();
            }
            
            $links[] = $link;
        }
        
        $menuItems[] = [
            'heading' => $section->name,
            'links' => $links
        ];
    }
    
    return view('home', ['menuItems' => $menuItems]);
}
```

---

## 🔐 Segurança

O componente implementa sanitização automática:

- ✅ Todos os textos são escapados com `htmlspecialchars()`
- ✅ Validação de dados antes de renderizar
- ✅ Fallback para menu vazio se não houver dados

```php
// Seguro! XSS é prevenido
$menuItems = [
    [
        'heading' => '<script>alert("XSS")</script>',  // Será escapado
        'links' => [
            ['href' => 'javascript:alert("XSS")', 'label' => 'Click <b>me</b>', 'icon' => 'fas fa-test']
        ]
    ]
];
```

---

## 🎨 Customização

### Alterar Estrutura HTML

Para alterar o HTML renderizado, modifique o método `render()` em `app/Components/MenuComponent.php`:

```php
public function render(array $data = [])
{
    // ... seu código HTML customizado aqui
}
```

### Adicionar Atributos Extras

Estenda a classe e sobrescreva o método:

```php
namespace App\Components;

class MenuComponent extends Component
{
    // ... código existente ...
    
    // Seu método customizado
    protected function getMenuClass(): string
    {
        return 'custom-menu-class sb-sidenav-dark';
    }
}
```

---

## 📊 Exemplo Real - Template Hotel

No template default do hotel (`app/views/templates/default.template.php`):

```php
<?php
$menuItems = [
    [
        'heading' => 'Core',
        'links' => [
            [
                'href' => '#',
                'icon' => 'fas fa-tachometer-alt',
                'label' => 'Dashboard',
                'id' => ''
            ]
        ]
    ],
    [
        'heading' => 'Interface',
        'links' => [
            [
                'href' => '#',
                'icon' => 'fas fa-columns',
                'label' => 'Layouts',
                'id' => 'collapseLayouts',
                'submenu' => [
                    ['href' => 'layout-static.html', 'label' => 'Static Navigation'],
                    ['href' => 'layout-sidenav-light.html', 'label' => 'Light Sidenav']
                ]
            ],
            [
                'href' => '#',
                'icon' => 'fas fa-book-open',
                'label' => 'Pages',
                'id' => 'collapsePages',
                'submenu' => [
                    ['href' => 'login.html', 'label' => 'Login'],
                    ['href' => 'register.html', 'label' => 'Register'],
                    ['href' => 'password.html', 'label' => 'Forgot Password']
                ]
            ]
        ]
    ],
    [
        'heading' => 'Addons',
        'links' => [
            [
                'href' => 'charts.html',
                'icon' => 'fas fa-chart-area',
                'label' => 'Charts',
                'id' => ''
            ],
            [
                'href' => 'tables.html',
                'icon' => 'fas fa-table',
                'label' => 'Tables',
                'id' => ''
            ]
        ]
    ]
];
echo component(App\Components\MenuComponent::class, ['items' => $menuItems, 'user' => $user ?? 'Guest'])->render();
?>
```

---

## 🛠️ Método Helper

O helper `component()` em `app/helpers/components.php` oferece 3 formas de instanciar componentes:

### 1. Por Classe Completa
```php
component(App\Components\MenuComponent::class, $data)->render()
```

### 2. Por Chave em Config
```php
// Em app/configs/components.php
return [
    'menu' => App\Components\MenuComponent::class,
];

// No template
component('menu', $data)->render()
```

### 3. Por Arquivo View (Fallback)
```php
component('components.menu', $data)->render()
// Procura em: app/views/components/menu.view.php
```

---

## ✅ Checklist de Implementação

- [x] Helper `component()` carregado automaticamente
- [x] MenuComponent implementado e dinâmico
- [x] Suporte a submenus/collapsiveis
- [x] Sanitização de XSS
- [x] Documentação PHPDoc
- [x] Testes de funcionalidade
- [x] Integração no template default
- [x] Fallback para menu vazio

---

## 📞 Suporte

Se encontrar problemas:

1. Verifique se os helpers estão carregados em `app/application.php`
2. Confirme que `MenuComponent` estende `Component`
3. Verifique a sintaxe do array de `$menuItems`
4. Use `php -l` para validar sintaxe dos arquivos

---

**Status**: ✅ Pronto para produção!
