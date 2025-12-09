-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema hotel
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `hotel` ;

-- -----------------------------------------------------
-- Schema hotel
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `hotel` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci ;
USE `hotel` ;

-- -----------------------------------------------------
-- Table `adicionais_tipos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `adicionais_tipos` ;

CREATE TABLE IF NOT EXISTS `adicionais_tipos` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(100) NOT NULL,
  `icone` VARCHAR(100) NULL DEFAULT NULL,
  `valor_referencia` DECIMAL(10,2) NOT NULL,
  `disponivel` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `quartos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `quartos` ;

CREATE TABLE IF NOT EXISTS `quartos` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `numero` VARCHAR(20) NOT NULL,
  `descricao` VARCHAR(100) NOT NULL,
  `preco_diaria` DECIMAL(10,2) NOT NULL,
  `status` ENUM('livre', 'reservado', 'manutencao', 'indisponivel', 'sujo') NOT NULL DEFAULT 'livre',
  `qtd_camas_casal` TINYINT UNSIGNED NULL DEFAULT '0',
  `qtd_camas_solteiro` TINYINT UNSIGNED NULL DEFAULT '0',
  `max_camas_casal` TINYINT UNSIGNED NULL DEFAULT '0',
  `max_camas_solteiro` TINYINT UNSIGNED NULL DEFAULT '0',
  `tem_ventilador` TINYINT(1) NULL DEFAULT '0',
  `tem_ar_condicionado` TINYINT(1) NULL DEFAULT '0',
  `tem_agua_quente` TINYINT(1) NULL DEFAULT '0',
  `tem_banheira` TINYINT(1) NULL DEFAULT '0',
  `tem_wifi` TINYINT(1) NULL DEFAULT '0',
  `tem_frigobar` TINYINT(1) NULL DEFAULT '0',
  `tem_tv` TINYINT(1) NULL DEFAULT '0',
  `e_friendly_pet` TINYINT(1) NULL DEFAULT '0',
  `e_acessivel` TINYINT(1) NULL DEFAULT '0',
  `criacao_data` DATETIME NULL DEFAULT CURRENT_TIMESTAMP(),
  `alteracao_data` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  UNIQUE INDEX `numero_UNIQUE` (`numero` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `quarto_adicionais`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `quarto_adicionais` ;

CREATE TABLE IF NOT EXISTS `quarto_adicionais` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `quartos_id` BIGINT NOT NULL,
  `adicionais_tipos_id` BIGINT NOT NULL,
  `qtd_min` TINYINT UNSIGNED NULL DEFAULT '0',
  `qtd_max` TINYINT UNSIGNED NULL DEFAULT '1',
  `valor_referencia` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `quartos_id` (`quartos_id` ASC) VISIBLE,
  INDEX `adicionais_tipos_id` (`adicionais_tipos_id` ASC) VISIBLE,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  CONSTRAINT `quartos_adicionais_ibfk_1`
    FOREIGN KEY (`quartos_id`)
    REFERENCES `quartos` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `quartos_adicionais_ibfk_2`
    FOREIGN KEY (`adicionais_tipos_id`)
    REFERENCES `adicionais_tipos` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `cargos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cargos` ;

CREATE TABLE IF NOT EXISTS `cargos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(50) NOT NULL,
  `descricao` TINYTEXT NULL DEFAULT NULL,
  `nivel_acesso` TINYINT(1) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  UNIQUE INDEX `nome_UNIQUE` (`nome` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `funcionarios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `funcionarios` ;

CREATE TABLE IF NOT EXISTS `funcionarios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(45) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  `nome` VARCHAR(125) NOT NULL,
  `email` VARCHAR(125) NOT NULL,
  `ativo` TINYINT(1) NOT NULL DEFAULT 1,
  `nivel_acesso` TINYINT(1) NOT NULL,
  `confirma_email` TINYINT(1) NOT NULL DEFAULT 0,
  `cpf` VARCHAR(11) NOT NULL,
  `rg` VARCHAR(20) NULL DEFAULT NULL,
  `rg_expedidor` VARCHAR(20) NULL DEFAULT NULL,
  `telefone` VARCHAR(15) NULL DEFAULT NULL,
  `criacao_data` DATETIME NULL DEFAULT CURRENT_TIMESTAMP(),
  `exclusao_data` DATETIME NULL DEFAULT NULL,
  `alteracao_data` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cargos_id` INT NOT NULL,
  PRIMARY KEY (`id`, `cargos_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_funcionarios_cargos1_idx` (`cargos_id` ASC) VISIBLE,
  CONSTRAINT `fk_funcionarios_cargos1`
    FOREIGN KEY (`cargos_id`)
    REFERENCES `cargos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hospedes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `hospedes` ;

CREATE TABLE IF NOT EXISTS `hospedes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(125) NOT NULL,
  `email` VARCHAR(125) NOT NULL,
  `confirma_email` TINYINT(1) NOT NULL DEFAULT 0,
  `telefone` VARCHAR(15) NOT NULL,
  `endereco` TEXT NOT NULL,
  `nacionalidade` VARCHAR(50) NOT NULL,
  `data_nascimento` DATE NOT NULL,
  `cpf` VARCHAR(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `reservas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `reservas` ;

CREATE TABLE IF NOT EXISTS `reservas` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `hospedes_id` INT NOT NULL,
  `token_acesso` VARCHAR(64) NOT NULL,
  `data_checkin` DATE NOT NULL,
  `data_checkout` DATE NOT NULL,
  `status` ENUM("esperando", "confirmada", "encerrada", "cancelada") NOT NULL,
  `pago_em` DATETIME NULL DEFAULT NULL,
  `confirma_pagamento` TINYINT(1) NOT NULL DEFAULT 0,
  `valor_total` DECIMAL(10,2) NOT NULL,
  `origem_reserva` ENUM("online", "presencial") NOT NULL,
  PRIMARY KEY (`id`, `hospedes_id`),
  UNIQUE INDEX `token_acesso_UNIQUE` (`token_acesso` ASC) VISIBLE,
  INDEX `hospedes_id_idx` (`hospedes_id` ASC) VISIBLE,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  CONSTRAINT `hospedes_id`
    FOREIGN KEY (`hospedes_id`)
    REFERENCES `hospedes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `servico_tipos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `servico_tipos` ;

CREATE TABLE IF NOT EXISTS `servico_tipos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(125) NOT NULL,
  `descricao` TINYTEXT NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `funcionario_servicos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `funcionario_servicos` ;

CREATE TABLE IF NOT EXISTS `funcionario_servicos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `servico_tipos_id` INT NOT NULL,
  `funcionarios_id` INT NOT NULL,
  `quartos_id` BIGINT NOT NULL,
  PRIMARY KEY (`id`, `servico_tipos_id`, `funcionarios_id`, `quartos_id`),
  INDEX `fk_servico_tipos_has_funcionarios_funcionarios1_idx` (`funcionarios_id` ASC) VISIBLE,
  INDEX `fk_servico_tipos_has_funcionarios_servico_tipos1_idx` (`servico_tipos_id` ASC) VISIBLE,
  INDEX `fk_funcionario_servicos_quartos1_idx` (`quartos_id` ASC) VISIBLE,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  CONSTRAINT `servico_tipos_id`
    FOREIGN KEY (`servico_tipos_id`)
    REFERENCES `servico_tipos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `funcionarios_id`
    FOREIGN KEY (`funcionarios_id`)
    REFERENCES `funcionarios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_funcionario_servicos_quartos1`
    FOREIGN KEY (`quartos_id`)
    REFERENCES `quartos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `documentos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `documentos` ;

CREATE TABLE IF NOT EXISTS `documentos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `reservas_id` INT NOT NULL,
  `reservas_hospedes_id` INT NOT NULL,
  `nome_arquivo` VARCHAR(255) NOT NULL,
  `tipo_conteudo` VARCHAR(50) NOT NULL,
  `caminho_arquivo` TEXT NULL,
  `tamanho_bytes` BIGINT NULL,
  `criacao_data` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP(),
  `hash` VARCHAR(64) NULL,
  PRIMARY KEY (`id`, `reservas_id`, `reservas_hospedes_id`),
  INDEX `fk_documentos_reservas1_idx` (`reservas_id` ASC, `reservas_hospedes_id` ASC) VISIBLE,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  CONSTRAINT `fk_documentos_reservas1`
    FOREIGN KEY (`reservas_id` , `reservas_hospedes_id`)
    REFERENCES `reservas` (`id` , `hospedes_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `reserva_quartos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `reserva_quartos` ;

CREATE TABLE IF NOT EXISTS `reserva_quartos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `valor_cobrado` DECIMAL(10,2) NOT NULL,
  `reservas_id` INT NOT NULL,
  `reservas_hospedes_id` INT NOT NULL,
  `quartos_id` BIGINT NOT NULL,
  PRIMARY KEY (`id`, `reservas_id`, `reservas_hospedes_id`, `quartos_id`),
  INDEX `fk_reserva_quartos_reservas1_idx` (`reservas_id` ASC, `reservas_hospedes_id` ASC) VISIBLE,
  INDEX `fk_reserva_quartos_quartos1_idx` (`quartos_id` ASC) VISIBLE,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  CONSTRAINT `fk_reserva_quartos_reservas1`
    FOREIGN KEY (`reservas_id` , `reservas_hospedes_id`)
    REFERENCES `reservas` (`id` , `hospedes_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_reserva_quartos_quartos1`
    FOREIGN KEY (`quartos_id`)
    REFERENCES `quartos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `reserva_quarto_adicionais`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `reserva_quarto_adicionais` ;

CREATE TABLE IF NOT EXISTS `reserva_quarto_adicionais` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `valor_cobrado` DECIMAL(10,2) NOT NULL,
  `reserva_quartos_id` INT NOT NULL,
  `reserva_quartos_reservas_id` INT NOT NULL,
  `reserva_quartos_reservas_hospedes_id` INT NOT NULL,
  `reserva_quartos_quartos_id` BIGINT NOT NULL,
  `quarto_adicionais_id` BIGINT NOT NULL,
  `descricao` VARCHAR(100) NULL,
  PRIMARY KEY (`id`, `reserva_quartos_id`, `reserva_quartos_reservas_id`, `reserva_quartos_reservas_hospedes_id`, `reserva_quartos_quartos_id`, `quarto_adicionais_id`),
  INDEX `fk_reserva_quarto_adicionais_reserva_quartos1_idx` (`reserva_quartos_id` ASC, `reserva_quartos_reservas_id` ASC, `reserva_quartos_reservas_hospedes_id` ASC, `reserva_quartos_quartos_id` ASC) VISIBLE,
  INDEX `fk_reserva_quarto_adicionais_quarto_adicionais1_idx` (`quarto_adicionais_id` ASC) VISIBLE,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  CONSTRAINT `fk_reserva_quarto_adicionais_reserva_quartos1`
    FOREIGN KEY (`reserva_quartos_id` , `reserva_quartos_reservas_id` , `reserva_quartos_reservas_hospedes_id` , `reserva_quartos_quartos_id`)
    REFERENCES `reserva_quartos` (`id` , `reservas_id` , `reservas_hospedes_id` , `quartos_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_reserva_quarto_adicionais_quarto_adicionais1`
    FOREIGN KEY (`quarto_adicionais_id`)
    REFERENCES `quarto_adicionais` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
