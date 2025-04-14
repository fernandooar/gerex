-- Schema gerex
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `gerex` DEFAULT CHARACTER SET utf8 ;
USE `gerex` ;

-- -----------------------------------------------------
-- Table `gerex`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gerex`.`usuarios` (
  `id_usuario` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(120) NOT NULL,
  `email` VARCHAR(120) NOT NULL,
  `senha_hash` VARCHAR(255) NOT NULL,
  `token_recuperacao` VARCHAR(255) NULL DEFAULT NULL,
  `token_expiracao` DATETIME NULL DEFAULT NULL,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE,
  PRIMARY KEY (`id_usuario`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gerex`.`servicos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gerex`.`servicos` (
  `id_servico` INT NOT NULL AUTO_INCREMENT,
  `nome_servico` VARCHAR(120) NOT NULL,
  `login_servico` VARCHAR(120) NULL,
  `email_servico` VARCHAR(120) NOT NULL,
  `telefone_servico` VARCHAR(25) NOT NULL,
  `senha_criptografada` VARCHAR(255) NOT NULL,
  `data_cadastro` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_alteracao` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_usuario` INT NOT NULL,
  INDEX `fk_servicos_usuarios1_idx` (`id_usuario` ASC) VISIBLE,
  PRIMARY KEY (`id_servico`),
  CONSTRAINT `fk_servicos_usuarios1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `gerex`.`usuarios` (`id_usuario`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gerex`.`imagens_servico`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gerex`.`imagens_servico` (
  `id_imagem` INT NOT NULL AUTO_INCREMENT,
  `caminho_imagem` VARCHAR(255) NOT NULL,
  `id_servico` INT NOT NULL,
  PRIMARY KEY (`id_imagem`),
  UNIQUE INDEX `id_imagens_servico_UNIQUE` (`id_imagem` ASC) VISIBLE,
  INDEX `fk_imagens_servico_servicos_idx` (`id_servico` ASC) VISIBLE,
  CONSTRAINT `fk_imagens_servico_servicos`
    FOREIGN KEY (`id_servico`)
    REFERENCES `gerex`.`servicos` (`id_servico`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;
