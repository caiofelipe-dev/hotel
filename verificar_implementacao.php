#!/usr/bin/env php
<?php
/**
 * Script de Verificação Rápida - Implementação MenuComponent
 * 
 * Execute: php verificar_implementacao.php
 */

echo "\n";
echo "╔════════════════════════════════════════════════════════╗\n";
echo "║     VERIFICAÇÃO DE IMPLEMENTAÇÃO - MENUCOMPONENT      ║\n";
echo "╚════════════════════════════════════════════════════════╝\n\n";

$checks = [];

// 1. Verificar carregamento de helpers em application.php
echo "📋 Verificando carregamento de helpers...\n";
$app_content = file_get_contents(__DIR__ . '/app/application.php');
$checks['Helpers carregados'] = strpos($app_content, 'glob(__DIR__') !== false && 
                                       strpos($app_content, 'helpers') !== false;

// 2. Verificar MenuComponent existe
echo "📋 Verificando MenuComponent...\n";
$menu_file = __DIR__ . '/app/Components/MenuComponent.php';
$checks['MenuComponent existe'] = file_exists($menu_file);

if ($checks['MenuComponent existe']) {
    $menu_content = file_get_contents($menu_file);
    $checks['MenuComponent tem __construct'] = strpos($menu_content, '__construct') !== false;
    $checks['MenuComponent tem setData'] = strpos($menu_content, 'setData') !== false;
    $checks['MenuComponent tem render'] = strpos($menu_content, 'render') !== false;
}

// 3. Verificar helper components.php
echo "📋 Verificando helper components...\n";
$helper_file = __DIR__ . '/app/helpers/components.php';
$checks['Helper components existe'] = file_exists($helper_file);

if ($checks['Helper components existe']) {
    $helper_content = file_get_contents($helper_file);
    $checks['Helper tem function component'] = strpos($helper_content, 'function component') !== false;
    $checks['Helper tem try/catch'] = strpos($helper_content, 'try {') !== false;
    $checks['Helper documentado'] = strpos($helper_content, '@param') !== false;
}

// 4. Verificar template default
echo "📋 Verificando template default...\n";
$template_file = __DIR__ . '/app/views/templates/default.template.php';
$checks['Template default existe'] = file_exists($template_file);

if ($checks['Template default existe']) {
    $template_content = file_get_contents($template_file);
    $checks['Template usa component()'] = strpos($template_content, 'component(') !== false;
    $checks['Template tem menuItems'] = strpos($template_content, 'menuItems') !== false;
}

// 5. Verificar que menu.view.php foi removido
echo "📋 Verificando remoção de menu estático...\n";
$old_menu = __DIR__ . '/app/views/components/menu.view.php';
$checks['menu.view.php removido'] = !file_exists($old_menu);

// 6. Verificar documentação
echo "📋 Verificando documentação...\n";
$checks['README_IMPLEMENTACAO.md'] = file_exists(__DIR__ . '/README_IMPLEMENTACAO.md');
$checks['MUDANCAS_REALIZADAS.md'] = file_exists(__DIR__ . '/MUDANCAS_REALIZADAS.md');
$checks['GUIA_MENUCOMPONENT.md'] = file_exists(__DIR__ . '/GUIA_MENUCOMPONENT.md');

// 7. Teste de sintaxe
echo "📋 Validando sintaxe PHP...\n";
exec('php -l ' . escapeshellarg($menu_file) . ' 2>&1', $output, $return);
$checks['Sintaxe MenuComponent'] = $return === 0;

exec('php -l ' . escapeshellarg($helper_file) . ' 2>&1', $output, $return);
$checks['Sintaxe Helper'] = $return === 0;

exec('php -l ' . escapeshellarg($template_file) . ' 2>&1', $output, $return);
$checks['Sintaxe Template'] = $return === 0;

// Exibir resultados
echo "\n╔════════════════════════════════════════════════════════╗\n";
echo "║                    RESULTADOS                          ║\n";
echo "╠════════════════════════════════════════════════════════╣\n";

$passed = 0;
$failed = 0;

foreach ($checks as $check => $result) {
    $symbol = $result ? '✓' : '✗';
    $status = $result ? 'OK' : 'FALHA';
    echo "║ $symbol $check" . str_repeat(' ', 46 - strlen($check)) . "$status ║\n";
    $result ? $passed++ : $failed++;
}

echo "╠════════════════════════════════════════════════════════╣\n";
$total = count($checks);
echo "║ Total: $passed/$total passaram" . str_repeat(' ', 27 - strlen("Total: $passed/$total passaram")) . "║\n";
echo "╚════════════════════════════════════════════════════════╝\n";

if ($failed === 0) {
    echo "\n🎉 TODAS AS VERIFICAÇÕES PASSARAM!\n";
    echo "✅ Sistema está pronto para uso.\n\n";
    exit(0);
} else {
    echo "\n⚠️  Alguns problemas foram encontrados.\n";
    echo "❌ Verifique os itens marcados com ✗\n\n";
    exit(1);
}
