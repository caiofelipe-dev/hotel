<?php

// Inicialização do framework
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../framework/Initialize.php';
\Fmk\Initialize::run();

use Fmk\Facades\Config;
use Fmk\Facades\Database\DB;

// Bloquear acesso se não for terminal
if (php_sapi_name() !== 'cli')
    die("Acesso negado. Este script só pode ser executado via terminal.\n");

// Verificar se está em modo desenvolvimento
$debug = Config::get('app.APPLICATION_DEBUG', false);
if (!$debug)
    die("Acesso negado. O script só pode ser executado em modo de desenvolvimento.\n");

// Diretório dos arquivos SQL
$sqlDir = __DIR__ . '/sql';
if (!is_dir($sqlDir)) 
    die("Diretório de arquivos SQL não encontrado: $sqlDir\n");

$sqlFiles = glob($sqlDir . '/*.sql');
if (empty($sqlFiles))
    die("Nenhum arquivo SQL encontrado em $sqlDir\n");


echo "Arquivos SQL disponíveis:\n";
foreach ($sqlFiles as $i => $file) {
    echo "[{$i}] " . basename($file) . "\n";
}

echo "Selecione o número do arquivo a ser executado: ";
$selected = trim(fgets(STDIN));
if (!isset($sqlFiles[$selected]))
    die("Seleção inválida.\n");

$sqlFile = $sqlFiles[$selected];
echo "Executando: " . basename($sqlFile) . "\n";

// Obter nome da conexão padrão
$connection = Config::get('database.connection_default', 'hotel');

try {
    // Obter conexão PDO através do DB facade
    $pdo = (new DB($connection))->getDriver()->getConnection();
} catch (Exception $e) {
    die("Erro ao conectar ao banco: " . $e->getMessage() . "\n");
}

$sql = file_get_contents($sqlFile);
if ($sql === false) die("Erro ao ler o arquivo SQL.\n");

try {
    // Executa instruções SQL
    $pdo->exec($sql);
    echo "Arquivo SQL executado com sucesso!\n";
} catch (PDOException $e) {
    die("Erro ao executar SQL: " . $e->getMessage() . "\n");
}