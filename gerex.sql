CREATE DATABASE IF NOT EXISTS gerex;
USE gerex;

-- Tabela de Usuários
CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    senha_hash VARCHAR(255) NOT NULL,
    token_recuperacao VARCHAR(255) NULL,
    token_expiracao DATETIME NULL
) ENGINE=InnoDB;

-- Tabela de Serviços
CREATE TABLE IF NOT EXISTS servicos (
    id_servico INT AUTO_INCREMENT PRIMARY KEY,
    nome_servico VARCHAR(120) NOT NULL,
    email_servico VARCHAR(120) NOT NULL,
    telefone_servico VARCHAR(25) NOT NULL,
    senha_criptografada VARCHAR(255) NOT NULL,
    data_cadastro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    data_alteracao DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    id_usuario INT NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Tabela de Imagens de Serviços
CREATE TABLE IF NOT EXISTS imagens_servico (
    id_imagem INT AUTO_INCREMENT PRIMARY KEY,
    caminho_imagem VARCHAR(255) NOT NULL,
    id_servico INT NOT NULL,
    FOREIGN KEY (id_servico) REFERENCES servicos(id_servico) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;
