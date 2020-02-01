create table if not exists anexo(
id_anexo integer PRIMARY KEY AUTO_INCREMENT,
    id_movimento integer,
    caminho varchar(200),
    foreign key (id_movimento) REFERENCES movimento(id)
)