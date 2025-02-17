CREATE DATABASE IF NOT EXISTS loja_magica;
USE loja_magica;

CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE,
    data_ultimo_pedido DATE DEFAULT NULL,
    valor_ultimo_pedido DECIMAL(10,2) DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT,
    produtos TEXT NOT NULL,
    data_pedido DATE NULL,
    valor DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS pedidos_parceiros (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_loja VARCHAR(50),
  nome_loja VARCHAR(255),
  localizacao VARCHAR(255),
  produto VARCHAR(255),
  quantidade INT
);

