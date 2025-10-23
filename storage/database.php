<?php

namespace Storage;

if (php_sapi_name() === 'cli') {
    // Usage: php storage/database.php <database_name> [path/to/file.sql]
    $argv = isset($GLOBALS['argv']) ? $GLOBALS['argv'] : [];

    if (!isset($argv[1]) || empty($argv[1])) {
        fwrite(STDERR, "Erro: informe o nome do banco de dados.\n");
        fwrite(STDERR, "Uso: php storage/database.php <database_name> [path/to/file.sql]\n");
        exit(1);
    }

    $dbName = $argv[1];
    $sqlFile = isset($argv[2]) && !empty($argv[2]) ? $argv[2] : __DIR__ . DIRECTORY_SEPARATOR . 'schema.sql';

    // Read DB connection info from environment variables with sensible defaults
    $dbHost = getenv('DB_HOST') ?: '127.0.0.1';
    $dbUser = getenv('DB_USER') ?: 'root';
    $dbPass = getenv('DB_PASS') ?: '';
    $dbPort = getenv('DB_PORT') ?: '3306';

    // Connect to MySQL server (no database selected)
    $mysqli = @new \mysqli($dbHost, $dbUser, $dbPass, '', (int)$dbPort);
    if ($mysqli->connect_errno) {
        fwrite(STDERR, "Erro ao conectar ao MySQL: ({$mysqli->connect_errno}) {$mysqli->connect_error}\n");
        exit(2);
    }

    // Create database if not exists
    $createSql = "CREATE DATABASE IF NOT EXISTS `" . $mysqli->real_escape_string($dbName) . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    if (!$mysqli->query($createSql)) {
        fwrite(STDERR, "Erro ao criar banco de dados: ({$mysqli->errno}) {$mysqli->error}\n");
        $mysqli->close();
        exit(3);
    }

    fwrite(STDOUT, "Banco de dados '{$dbName}' criado/confirmado com sucesso.\n");

    // If SQL file exists, execute it against the new database
    if ($sqlFile && file_exists($sqlFile) && is_readable($sqlFile)) {
        fwrite(STDOUT, "Executando script SQL: {$sqlFile}\n");

        // Select the created database
        if (!$mysqli->select_db($dbName)) {
            fwrite(STDERR, "Erro ao selecionar o banco '{$dbName}': ({$mysqli->errno}) {$mysqli->error}\n");
            $mysqli->close();
            exit(4);
        }

        $sql = file_get_contents($sqlFile);
        if ($sql === false) {
            fwrite(STDERR, "Erro ao ler o arquivo SQL: {$sqlFile}\n");
            $mysqli->close();
            exit(5);
        }

        // Split statements by semicolon followed by a newline. This is a simple splitter and may not work for all SQL files
        $statements = array_filter(array_map('trim', preg_split('/;\s*\n/', $sql)));
        $failed = 0;
        foreach ($statements as $stmt) {
            if ($stmt === '') continue;
            if (!$mysqli->query($stmt)) {
                fwrite(STDERR, "Erro ao executar statement: ({$mysqli->errno}) {$mysqli->error}\nStatement: {$stmt}\n");
                $failed++;
            }
        }

        if ($failed === 0) {
            fwrite(STDOUT, "Script SQL executado com sucesso.\n");
        } else {
            fwrite(STDERR, "Script SQL executado com {$failed} erro(s).\n");
            $mysqli->close();
            exit(6);
        }
    } else {
        fwrite(STDOUT, "Nenhum arquivo SQL encontrado para execução (usando: {$sqlFile}).\n");
    }

    $mysqli->close();
    exit(0);
    
} else {
    echo "Somente via terminal";
}