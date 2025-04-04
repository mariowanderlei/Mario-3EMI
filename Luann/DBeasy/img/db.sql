create database exemplo_db character set utf8mb4 collate utf8mb4_unicode_ci;

use exemplo_db;

create table usuarios (
    id int auto_increment primary key,
    nome varchar(255) not null,
    email varchar(255) not null unique,
    senha varchar(255) not null,
    criado_em timestamp default current_timestamp    
);

select * from usuarios;