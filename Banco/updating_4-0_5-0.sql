create table contribuidor(
id_contribuidor integer primary key AUTO_INCREMENT,
    nome varchar (150),
    valor decimal(10,2)
);

create table contribuicao(
    id_contribuicao integer PRIMARY key AUTO_INCREMENT,
    id_contribuidor integer,
    data date,
    valor decimal (10,2),
    FOREIGN KEY (id_contribuidor) references contribuidor(id_contribuidor)
    )