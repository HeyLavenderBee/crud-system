create database login_ju;
use login_ju;

create table users(
    username varchar(30) not null primary key,
    name varchar(90) not null,
    email varchar(200) unique not null,
    password varchar(128) not null,
    is_first_time bit,
    user_type char(1),
    status char(1)
);

-- *************************
-- MUITO IMPORTANTE!!!!!!!!!!
-- como nesse site, apenas os administradores podem criar usuários, é necessário um passo a mais:

-- leia o README.md para conseguir entrar na conta de administrador, sem ela, você não
-- conseguirá acessar o sistema completo.
-- ou como nota, aqui está a senha do adm, caso não queira acessar o README.md
-- senha: i@mfr0gDet3ctiv3
-- *************************

insert into users(
username, name, email, password, is_first_time, user_type, status) 
values
('adm', 'Administrador', 'adm@gmail.com', '$2y$10$wdx1rxyJG6ZvQzdJmGtdZenAFuVVoOuFS80Mt7D5kPYmtMMf5PcZm', 0, 'A', 'A');
