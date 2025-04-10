use emprestimos_db;

select * from equipamentos;

select * from emprestimos;

select * from professores;

select * from solicitacoes WHERE status = 'Aguardando Devolução';

select * from adicionar;

delete from equipamentos where id = 12;

SELECT * FROM solicitacoes WHERE status = 'Aguardando Devolução';


CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL
);
CREATE TABLE solicitacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    professor VARCHAR(255) NOT NULL,
    equipamento VARCHAR(255) NOT NULL,
     data_emprestimo DATE NOT NULL,
    data_devolucao DATE NOT NULL,
    data DATE NOT NULL,
    status ENUM('Pendente', 'Aprovado', 'Rejeitado') DEFAULT 'Pendente'
);


CREATE TABLE adicionar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT NOT NULL,
     status ENUM('disponível', 'indisponível') DEFAULT 'disponível'
     

);
CREATE TABLE equipamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    status ENUM('Disponível', 'Indisponível') DEFAULT 'Disponível'
);




ALTER TABLE equipamentos ADD COLUMN visivel TINYINT(1) DEFAULT 0;




INSERT INTO admins (nome, email, senha) VALUES ('lc', 'luizc@gmail.com','123123');
