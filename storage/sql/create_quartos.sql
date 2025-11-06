-- create_quartos.sql
-- Cria a tabela `quartos` com os atributos solicitados.
-- Observação: este arquivo pode ser executado com o script PHP em storage/database.php (modo development) ou importado diretamente no MySQL.

CREATE TABLE IF NOT EXISTS `quartos` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `descricao` TEXT,
  `numero` VARCHAR(50) NOT NULL,
  `cama_casal_min` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `cama_casal_max` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `cama_solteiro_min` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `cama_solteiro_max` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `arcondicionado` TINYINT(1) NOT NULL DEFAULT 0,
  `banheiro` TINYINT(1) NOT NULL DEFAULT 0,
  `frigobar` TINYINT(1) NOT NULL DEFAULT 0,
  `tm` TINYINT(1) NOT NULL DEFAULT 0,
  `secador` TINYINT(1) NOT NULL DEFAULT 0,
  `agua_quente` TINYINT(1) NOT NULL DEFAULT 0,
  `hidro` TINYINT(1) NOT NULL DEFAULT 0,
  `valor` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_numero` (`numero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
