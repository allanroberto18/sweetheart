CREATE SCHEMA IF NOT EXISTS `facebook_db`;

CREATE TABLE  IF NOT EXISTS `facebook_db`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `facebook_id` VARCHAR(255) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `image` VARCHAR(255) NOT NULL,
  `is_active` BOOLEAN DEFAULT TRUE,
  PRIMARY KEY(`id`)
) Engine=InnoDB;

CREATE TABLE  IF NOT EXISTS `facebook_db`.`access_token` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  PRIMARY KEY(`id`),
  CONSTRAINT `fk_user_access_tooken` FOREIGN KEY(`user_id`) REFERENCES `facebook_db`.`users`(`id`)
) Engine=InnoDB;