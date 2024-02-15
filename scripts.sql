CREATE DATABASE rede_social;

USE rede_social;

CREATE TABLE usuarios (
    id INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(40) NOT NULL,
    senha VARCHAR(40) NOT NULL,
    nome VARCHAR(20) NOT NULL,
    sobrenome VARCHAR(20) NOT NULL,
    nascimento DATE NOT NULL,
    codigo VARCHAR(95) NOT NULL,
    url VARCHAR(110) NOT NULL,
    aprovado TINYINT NOT NULL DEFAULT 0,
    PRIMARY KEY(id),
    UNIQUE(email),
    UNIQUE(codigo),
    UNIQUE(url)
);

CREATE TABLE mensagens (
    id INT NOT NULL AUTO_INCREMENT,
    mensagem VARCHAR(100) NOT NULL,
    emissor_id INT NOT NULL,
    receptor_id INT NOT NULL,
    data TIMESTAMP NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY (emissor_id) REFERENCES usuarios(id),
    FOREIGN KEY (receptor_id) REFERENCES usuarios(id)
);

CREATE TABLE amizades (
    id INT NOT NULL AUTO_INCREMENT,
    solicitante_id INT NOT NULL,
    solicitado_id INT NOT NULL,
    confirmado TINYINT NOT NULL DEFAULT 0,
    PRIMARY KEY(id),
    FOREIGN KEY (solicitante_id) REFERENCES usuarios(id),
    FOREIGN KEY (solicitado_id) REFERENCES usuarios(id)
);

CREATE TABLE fotos (
    id INT NOT NULL AUTO_INCREMENT,
    screenshot VARCHAR(65) NOT NULL DEFAULT '../fotos/foto_padrao/foto_padrao.png',
    usuario_id INT NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE perfis_pessoais (
    id INT NOT NULL AUTO_INCREMENT,
    relacionamento VARCHAR(15) NOT NULL DEFAULT '',
    interesse ENUM('', 'Amizades','Namoro','Contatos Profissionais','Nada','Outros Interesses') NOT NULL DEFAULT '',
    religiao VARCHAR(20) NOT NULL DEFAULT '',
    cidade VARCHAR(30) NOT NULL DEFAULT '',
    morando VARCHAR(30) NOT NULL DEFAULT '',
    citacao VARCHAR(200) NOT NULL DEFAULT '',
    sobre VARCHAR(300) NOT NULL DEFAULT '',
    livro VARCHAR(30) NOT NULL DEFAULT '',
    filme VARCHAR(30) NOT NULL DEFAULT '',
    serie VARCHAR(30) NOT NULL DEFAULT '',
    musica VARCHAR(30) NOT NULL DEFAULT '',
    cantor VARCHAR(35) NOT NULL DEFAULT '',
    esporte VARCHAR(30) NOT NULL DEFAULT '',
    time VARCHAR(30) NOT NULL DEFAULT '',
    personalidade VARCHAR(40) NOT NULL DEFAULT '',
    assunto VARCHAR(40) NOT NULL DEFAULT '',
    presente VARCHAR(35) NOT NULL DEFAULT '',  
    usuario_id INT NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE perfis_educacionais (
    id INT NOT NULL AUTO_INCREMENT,
    escolaridade VARCHAR(35) NOT NULL DEFAULT '',
    cursando VARCHAR(45) NOT NULL DEFAULT '',
    medio VARCHAR(35) NOT NULL DEFAULT '',
    superior VARCHAR(80) NOT NULL DEFAULT '',
    habilidades VARCHAR(45) NOT NULL DEFAULT '',
    usuario_id INT NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);