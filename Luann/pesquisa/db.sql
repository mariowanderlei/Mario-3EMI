CREATE DATABASE projeto_sql;
USE projeto_sql;

-- Tabela funcionarios
CREATE TABLE funcionarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100),
    salario DECIMAL(10,2)
);

INSERT INTO funcionarios (nome, salario) VALUES
('Carlos Silva', 4500.00),
('Ana Paula', 2800.00),
('Pedro Souza', 3200.00),
('Juliana Mendes', 5000.00),
('Roberto Lima', 2900.00);

-- Tabela produtos
CREATE TABLE produtos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100),
    estoque INT
);

INSERT INTO produtos (nome, estoque) VALUES
('Teclado', 15),
('Mouse', 8),
('Monitor', 5),
('Impressora', 12),
('Fone de ouvido', 3);

-- Tabela clientes
CREATE TABLE clientes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100),
    cidade VARCHAR(50),
    idade INT
);

INSERT INTO clientes (nome, cidade, idade) VALUES
('Lucas Santos', 'São Paulo', 35),
('Marina Souza', 'Rio de Janeiro', 28),
('Pedro Oliveira', 'São Paulo', 40),
('Fernanda Costa', 'Belo Horizonte', 33),
('João Almeida', 'São Paulo', 25);

-- tabela pedidos
CREATE TABLE pedidos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_cliente INT,
    data_pedido DATE,
    valor DECIMAL(10,2),
    FOREIGN KEY (id_cliente) REFERENCES clientes(id)
);

-- Inserir dados de exemplo na tabela pedidos
INSERT INTO pedidos (id_cliente, data_pedido, valor) VALUES
(1, '2025-03-15', 200.00),
(3, '2025-03-20', 350.00),
(1, '2025-03-22', 150.00),
(4, '2025-03-23', 400.00);
