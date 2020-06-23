create table cliente(
    id_cliente integer PRIMARY KEY AUTO_INCREMENT,
    nome varchar(100),
    telefone varchar(11),
    status int(1)
);

create table servico(
    id_servico integer primary key AUTO_INCREMENT,
    id_cliente integer,
    equipamento varchar(150),
    descricao varchar(500),
    valor decimal(12,2),
    FOREIGN KEY (id_cliente) REFERENCES cliente(id_cliente)
);

create table coment_serv(
    id_coment integer PRIMARY key AUTO_INCREMENT,
    id_servico integer,
    comentario varchar(250),
    FOREIGN key (id_servico) REFERENCES servico(id_servico)
);

create table tipo_servico(
id_tipo integer primary key auto_increment,
operacao int(1),
nome varchar(100)
);

alter table servico add column id_tipo integer;

alter table servico add constraint foreign key (id_tipo) references tipo_servico(id_tipo);