ALTER TABLE `movimento` ADD `id_usuario` INT AFTER `descricao`;
ALTER TABLE `movimento` ADD `data_registro` datetime default now() AFTER `id_usuario`;
alter table movimento add constraint foreign key (id_usuario) references usuarios(id);
