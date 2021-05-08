CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(20) DEFAULT NULL,
  `lname` varchar(20) DEFAULT NULL,
  `login` varchar(45) NOT NULL,
  `is_admin` tinyint(4) DEFAULT '0',
  `gender` varchar(10) DEFAULT 'male',
  `pwd` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ;


CREATE TABLE `db_sr03`.`forum` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NOT NULL DEFAULT 'new forum',
  `owner` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `user_owner_idx` (`owner` ASC) VISIBLE,
  CONSTRAINT `user_owner`
    FOREIGN KEY (`owner`)
    REFERENCES `db_sr03`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

    CREATE TABLE `db_sr03`.`message` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `content` MEDIUMTEXT NULL,
  `editor` INT NOT NULL,
  `destination` INT NOT NULL,
  INDEX `FK_editor_idx` (`editor` ASC) VISIBLE,
  INDEX `Fk_dest_idx` (`destination` ASC) VISIBLE,
  PRIMARY KEY (`id`),
  CONSTRAINT `FK_editor`
    FOREIGN KEY (`editor`)
    REFERENCES `db_sr03`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `Fk_dest`
    FOREIGN KEY (`destination`)
    REFERENCES `db_sr03`.`forum` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);

    CREATE TABLE `db_sr03`.`subscriptions` (
  `id_user` INT NOT NULL,
  `id_forum` INT NOT NULL,
  PRIMARY KEY (`id_user`, `id_forum`),
  INDEX `FK_subs_forum_idx` (`id_forum` ASC) VISIBLE,
  CONSTRAINT `FK_subs_user`
    FOREIGN KEY (`id_user`)
    REFERENCES `db_sr03`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_subs_forum`
    FOREIGN KEY (`id_forum`)
    REFERENCES `db_sr03`.`forum` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

ALTER TABLE `db_sr03`.`forum` 
ADD COLUMN `description` MEDIUMTEXT NULL AFTER `owner`;

ALTER TABLE `db_sr03`.`user` 
ADD UNIQUE INDEX `login_UNIQUE` (`login` ASC) VISIBLE;
;