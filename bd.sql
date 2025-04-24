CREATE DATABASE IF NOT EXISTS mercadinho;
USE mercadinho;


CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL
);


CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10,2) NOT NULL,
    quantidade_estoque INT NOT NULL,
    categoria_id INT,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);


CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(20),
    cpf VARCHAR(14) UNIQUE,
    email VARCHAR(100)
);

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    login VARCHAR(50) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL
);


CREATE TABLE vendas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT,
    data_venda DATETIME DEFAULT CURRENT_TIMESTAMP,
    valor_total DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id)
);


INSERT INTO categorias (nome) VALUES
('Alimentos'),
('Bebidas'),
('Limpeza'),
('Higiene'), 
('Outros'), 
('Padaria'),
('Frios'),
('Açougue'),
('Congelados'),
('Mercearia'),
('Pet'),
('Bazar'),
('Utilidades Domésticas'),
('Eletrônicos'),
('Papelaria');


INSERT INTO produtos (nome, descricao, preco, quantidade_estoque, categoria_id) VALUES
('Arroz ', 'Arroz branco tipo 1', 24.90, 100, 1),
('Feijão Carioca ', 'Feijão tipo 1', 7.50, 80, 1),
('Coca-Cola ', 'Refrigerante sabor cola', 8.99, 50, 2),
('Detergente Neutro', 'Detergente líquido 500ml', 2.79, 150, 3),
('Shampoo ', 'Shampoo para cabelos normais', 12.49, 60, 4),
('Papel Higiênico ', 'Folha dupla', 18.90, 40, 4),
('Sabão em pó ', 'Limpeza pesada', 9.90, 90, 3),
('Presunto ', 'Presunto fatiado', 6.50, 30, 7),
('Queijo Mussarela ', 'Fatiado', 7.90, 25, 7),
('Pão francês ', 'Fresco do dia', 10.00, 70, 6),
('Carne bovina ', 'Corte de primeira', 35.00, 20, 8),
('Pizza Congelada', 'Sabor calabresa', 18.50, 35, 9),
('Ração para cães ', 'Adulto - carne', 49.90, 40, 11),
('Esponja de limpeza', 'Pacote com 3', 3.50, 100, 10),
('Lâmpada LED ', 'Branca', 8.00, 55, 13);

INSERT INTO clientes (nome, telefone, cpf, email) VALUES
('João Silva', '11999999999', '123.456.789-00', 'joao@email.com'),
('Maria Souza', '21988888888', '987.654.321-00', 'maria@email.com'),
('Carlos Lima', '31977777777', '456.789.123-00', 'carlos@email.com'),
('Fernanda Rocha', '41966666666', '789.123.456-00', 'fernanda@email.com'),
('Paulo Oliveira', '51955555555', '321.654.987-00', 'paulo@email.com'),
('Ana Costa', '61944444444', '741.852.963-00', 'ana@email.com'),
('Luciana Silva', '11933333333', '852.963.741-00', 'luciana@email.com'),
('Rafael Torres', '21922222222', '963.741.852-00', 'rafael@email.com'),
('Camila Dias', '31911111111', '159.357.486-00', 'camila@email.com'),
('Bruno Mendes', '41900000000', '357.159.486-00', 'bruno@email.com'),
('Mariana Alves', '51999998888', '258.147.369-00', 'mariana@email.com'),
('André Souza', '61999997777', '369.258.147-00', 'andre@email.com'),
('Tatiane Lopes', '11988887777', '147.258.369-00', 'tatiane@email.com'),
('Thiago Nunes', '21977776666', '753.159.456-00', 'thiago@email.com'),
('Juliana Martins', '31966665555', '456.753.159-00', 'juliana@email.com');

INSERT INTO usuarios (nome, login, senha) VALUES
('João', 'joao', 'senha123'),
('Maria', 'maria', 'senha123'),
('Carlos', 'carlos', 'senha123'),
('Ana', 'ana', 'senha123'),
('Pedro', 'pedro', 'senha123'),
('Bruna', 'bruna', 'senha123'),
('Felipe', 'felipe', 'senha123'),
('Lucia', 'lucia', 'senha123'),
('Ricardo', 'ricardo', 'senha123'),
('Sandra ', 'sandra', 'senha123'),
('Julio', 'julio', 'senha123'),
('Tereza', 'tereza', 'senha123'),
('Fábio', 'fabio', 'senha123'),
('Clara', 'clara', 'senha123');

INSERT INTO vendas (cliente_id, data_venda, valor_total) VALUES
(1, '2025-04-01 10:00:00', 89.90),
(2, '2025-04-01 11:00:00', 45.50),
(3, '2025-04-01 12:30:00', 120.00),
(4, '2025-04-02 09:45:00', 34.99),
(5, '2025-04-02 14:20:00', 78.60),
(6, '2025-04-03 08:10:00', 67.00),
(7, '2025-04-03 13:40:00', 102.75),
(8, '2025-04-04 16:00:00', 59.90),
(9, '2025-04-04 17:30:00', 92.80),
(10, '2025-04-05 10:50:00', 105.10),
(11, '2025-04-05 15:15:00', 33.30),
(12, '2025-04-06 09:00:00', 150.00),
(13, '2025-04-06 11:45:00', 86.25),
(14, '2025-04-07 13:00:00', 49.99),
(15, '2025-04-07 18:30:00', 73.60);
