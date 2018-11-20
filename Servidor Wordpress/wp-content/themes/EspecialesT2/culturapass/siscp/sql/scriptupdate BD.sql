ALTER TABLE `muestragastro`.`encuestacocineros_2018` 
ADD COLUMN `esa_lengua_ind` INT(11) NULL DEFAULT NULL AFTER `esa_lengua`;

ALTER TABLE `muestragastro`.`encuestacocineros_2018` 

ADD COLUMN `esa_trans_quien` VARCHAR(100) NULL DEFAULT NULL AFTER `esa_trans_par`;


ALTER TABLE `muestragastro`.`encuestaartesanos_2018` 
ADD COLUMN `asa_lengua_ind` INT(11) NULL DEFAULT NULL AFTER `asa_lengua`;

CREATE TABLE IF NOT EXISTS `muestragastro`.`lenguasind` (
  `idlenguaind` INT(11) NOT NULL,
  `lenguaind` VARCHAR(45) NULL DEFAULT NULL,
  `status` TINYINT(1) NULL DEFAULT NULL,
  PRIMARY KEY (`idlenguaind`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


insert into lenguasind values(1,'Otomí',1),(2,'Hñähñu',1),(3,'Náhuatl',1),(4,'Tepehua',1),(5,'Otro',1);


delete from parentescos where idparentesco<=9;

insert into parentescos values (1,'Papá',1),(2,'Mamá',1),(3,'Abuela',1),(4,'Abuelo',1),(5,'Esposa',1),(6,'Esposo',1),(7,'Suegra',1),(8,'Suegro',1),(9,'Otro',1)
