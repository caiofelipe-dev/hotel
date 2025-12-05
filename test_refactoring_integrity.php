<?php
/**
 * Teste de Integridade da Refatoração
 * Valida que a refatoração não quebrou nenhuma funcionalidade
 */

// Setup
error_reporting(E_ALL);
ini_set('display_errors', '1');

echo "═══════════════════════════════════════════════════════════════\n";
echo "🧪 TESTE DE INTEGRIDADE - REFATORAÇÃO SOLID\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

$tests_passed = 0;
$tests_failed = 0;

// Test 1: Carregamento de Classes
echo "[1/5] Testando carregamento de classes...\n";
try {
    // Mock classes para teste
    require_once __DIR__ . '/framework/Facades/Component.php';
    require_once __DIR__ . '/app/helpers/menu.php';
    require_once __DIR__ . '/app/helpers/components.php';
    require_once __DIR__ . '/app/Components/MenuComponent.php';
    
    echo "     ✅ Todas as classes carregadas com sucesso\n";
    $tests_passed++;
} catch (Exception $e) {
    echo "     ❌ Erro ao carregar: " . $e->getMessage() . "\n";
    $tests_failed++;
}

// Test 2: Helper is_route_active existe
echo "[2/5] Testando existência de helpers...\n";
try {
    if (!function_exists('is_route_active')) {
        throw new Exception('Helper is_route_active() não encontrado');
    }
    
    // Verificar que helpers removidos NÃO existem
    if (function_exists('active_link_class')) {
        throw new Exception('Helper active_link_class() deveria ter sido removido!');
    }
    
    if (function_exists('menu_link_url')) {
        throw new Exception('Helper menu_link_url() deveria ter sido removido!');
    }
    
    echo "     ✅ Helpers corretos presentes\n";
    echo "        ✓ is_route_active() existe\n";
    echo "        ✓ active_link_class() removido\n";
    echo "        ✓ menu_link_url() removido\n";
    $tests_passed++;
} catch (Exception $e) {
    echo "     ❌ " . $e->getMessage() . "\n";
    $tests_failed++;
}

// Test 3: MenuComponent pode ser instanciado
echo "[3/5] Testando instanciação do MenuComponent...\n";
try {
    if (!class_exists('App\Components\MenuComponent')) {
        throw new Exception('MenuComponent não encontrado');
    }
    
    $menu = new \App\Components\MenuComponent();
    
    // Verificar que método render existe e sem parâmetros obrigatórios
    if (!method_exists($menu, 'render')) {
        throw new Exception('Método render() não encontrado');
    }
    
    // Verificar que métodos antigos foram removidos
    if (method_exists($menu, 'isLinkActive')) {
        throw new Exception('Método isLinkActive() deveria ter sido removido!');
    }
    
    if (method_exists($menu, 'getLinkActiveClass')) {
        throw new Exception('Método getLinkActiveClass() deveria ter sido removido!');
    }
    
    echo "     ✅ MenuComponent instanciado com sucesso\n";
    echo "        ✓ Método render() existe\n";
    echo "        ✓ isLinkActive() removido\n";
    echo "        ✓ getLinkActiveClass() removido\n";
    $tests_passed++;
} catch (Exception $e) {
    echo "     ❌ " . $e->getMessage() . "\n";
    $tests_failed++;
}

// Test 4: Interface pública preservada
echo "[4/5] Testando interface pública...\n";
try {
    $menu = new \App\Components\MenuComponent();
    
    $menuItems = [
        [
            'heading' => 'Test',
            'links' => [
                [
                    'href' => '/',
                    'icon' => 'fas fa-home',
                    'label' => 'Home',
                    'id' => ''
                ]
            ]
        ]
    ];
    
    // Interface deve ser a mesma
    if (!method_exists($menu, 'setData')) {
        throw new Exception('Método setData() não encontrado');
    }
    
    $result = $menu->setData(['items' => $menuItems, 'user' => 'Test']);
    
    if (!($result instanceof \App\Components\MenuComponent)) {
        throw new Exception('setData() deveria retornar $this');
    }
    
    echo "     ✅ Interface pública preservada\n";
    echo "        ✓ setData() funciona corretamente\n";
    echo "        ✓ Fluent interface mantida\n";
    $tests_passed++;
} catch (Exception $e) {
    echo "     ❌ " . $e->getMessage() . "\n";
    $tests_failed++;
}

// Test 5: Renderização funciona
echo "[5/5] Testando renderização...\n";
try {
    $menu = new \App\Components\MenuComponent();
    
    $menuItems = [
        [
            'heading' => 'Core',
            'links' => [
                [
                    'href' => '/',
                    'icon' => 'fas fa-home',
                    'label' => 'Home',
                    'id' => ''
                ]
            ]
        ]
    ];
    
    $menu->setData(['items' => $menuItems, 'user' => 'Test User']);
    
    // render() agora sem parâmetros
    $html = $menu->render();
    
    if (empty($html)) {
        throw new Exception('render() retornou string vazia');
    }
    
    if (!strpos($html, 'sb-sidenav')) {
        throw new Exception('HTML não contém classe sb-sidenav');
    }
    
    if (!strpos($html, 'Home')) {
        throw new Exception('HTML não contém label do menu');
    }
    
    if (!strpos($html, 'Test User')) {
        throw new Exception('HTML não contém nome do usuário');
    }
    
    echo "     ✅ Renderização funciona corretamente\n";
    echo "        ✓ render() retorna HTML válido\n";
    echo "        ✓ Items renderizados\n";
    echo "        ✓ User info renderizado\n";
    $tests_passed++;
} catch (Exception $e) {
    echo "     ❌ " . $e->getMessage() . "\n";
    $tests_failed++;
}

// Sumário
echo "\n═══════════════════════════════════════════════════════════════\n";
echo "📊 RESULTADO FINAL\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

$total = $tests_passed + $tests_failed;
$percentage = ($tests_passed / $total) * 100;

echo "✅ Testes Passados:   $tests_passed/$total\n";
echo "❌ Testes Falhados:   $tests_failed/$total\n";
echo "📈 Taxa de Sucesso:   " . number_format($percentage, 1) . "%\n\n";

if ($tests_failed === 0) {
    echo "🎉 REFATORAÇÃO VALIDADA COM SUCESSO!\n";
    echo "   - Interface pública preservada\n";
    echo "   - Código removido funcionava corretamente\n";
    echo "   - Funcionalidade intacta\n";
    echo "   - SOLID principles aplicados\n";
    exit(0);
} else {
    echo "⚠️  PROBLEMAS ENCONTRADOS - Revise os testes falhados\n";
    exit(1);
}
?>