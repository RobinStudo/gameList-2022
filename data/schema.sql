# noinspection SqlNoDataSourceInspectionForFile

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Table `game_list`.`company`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `game_list`.`company` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(40) NOT NULL,
  `slug` VARCHAR(50) NOT NULL,
  `logo` VARCHAR(255) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `slug_UNIQUE` (`slug` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `game_list`.`licence`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `game_list`.`licence` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(60) NOT NULL,
  `slug` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `slug_UNIQUE` (`slug` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `game_list`.`game`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `game_list`.`game` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(80) NOT NULL,
  `slug` VARCHAR(90) NOT NULL,
  `released_at` DATETIME NULL,
  `description` TEXT NULL,
  `poster` VARCHAR(255) NULL,
  `main_id` INT NULL,
  `editor_id` INT NULL,
  `licence_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_game_game_idx` (`main_id` ASC),
  UNIQUE INDEX `slug_UNIQUE` (`slug` ASC),
  INDEX `fk_game_company1_idx` (`editor_id` ASC),
  INDEX `fk_game_licence1_idx` (`licence_id` ASC),
  CONSTRAINT `fk_game_game`
    FOREIGN KEY (`main_id`)
    REFERENCES `game_list`.`game` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_game_company1`
    FOREIGN KEY (`editor_id`)
    REFERENCES `game_list`.`company` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_game_licence1`
    FOREIGN KEY (`licence_id`)
    REFERENCES `game_list`.`licence` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `game_list`.`platform`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `game_list`.`platform` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(40) NOT NULL,
  `slug` VARCHAR(40) NOT NULL,
  `icon` VARCHAR(255) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `game_list`.`game_platform`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `game_list`.`game_platform` (
  `game_id` INT NOT NULL,
  `platform_id` INT NOT NULL,
  PRIMARY KEY (`game_id`, `platform_id`),
  INDEX `fk_game_has_platform_platform1_idx` (`platform_id` ASC),
  INDEX `fk_game_has_platform_game1_idx` (`game_id` ASC),
  CONSTRAINT `fk_game_has_platform_game1`
    FOREIGN KEY (`game_id`)
    REFERENCES `game_list`.`game` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_game_has_platform_platform1`
    FOREIGN KEY (`platform_id`)
    REFERENCES `game_list`.`platform` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `game_list`.`developer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `game_list`.`developer` (
  `game_id` INT NOT NULL,
  `company_id` INT NOT NULL,
  PRIMARY KEY (`game_id`, `company_id`),
  INDEX `fk_game_has_company_company1_idx` (`company_id` ASC),
  INDEX `fk_game_has_company_game1_idx` (`game_id` ASC),
  CONSTRAINT `fk_game_has_company_game1`
    FOREIGN KEY (`game_id`)
    REFERENCES `game_list`.`game` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_game_has_company_company1`
    FOREIGN KEY (`company_id`)
    REFERENCES `game_list`.`company` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `game_list`.`genre`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `game_list`.`genre` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(40) NOT NULL,
  `slug` VARCHAR(40) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `slug_UNIQUE` (`slug` ASC),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `game_list`.`game_genre`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `game_list`.`game_genre` (
  `game_id` INT NOT NULL,
  `genre_id` INT NOT NULL,
  PRIMARY KEY (`game_id`, `genre_id`),
  INDEX `fk_game_has_genre_genre1_idx` (`genre_id` ASC),
  INDEX `fk_game_has_genre_game1_idx` (`game_id` ASC),
  CONSTRAINT `fk_game_has_genre_game1`
    FOREIGN KEY (`game_id`)
    REFERENCES `game_list`.`game` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_game_has_genre_genre1`
    FOREIGN KEY (`genre_id`)
    REFERENCES `game_list`.`genre` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `game_list`.`tag`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `game_list`.`tag` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(40) NOT NULL,
  `slug` VARCHAR(40) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `slug_UNIQUE` (`slug` ASC),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `game_list`.`game_tag`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `game_list`.`game_tag` (
  `tag_id` INT NOT NULL,
  `game_id` INT NOT NULL,
  PRIMARY KEY (`tag_id`, `game_id`),
  INDEX `fk_tag_has_game_game1_idx` (`game_id` ASC),
  INDEX `fk_tag_has_game_tag1_idx` (`tag_id` ASC),
  CONSTRAINT `fk_tag_has_game_tag1`
    FOREIGN KEY (`tag_id`)
    REFERENCES `game_list`.`tag` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tag_has_game_game1`
    FOREIGN KEY (`game_id`)
    REFERENCES `game_list`.`game` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `game_list`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `game_list`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(30) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `roles` JSON NOT NULL,
  `created_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `game_list`.`profile`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `game_list`.`profile` (
  `user_id` INT NOT NULL,
  `picture` VARCHAR(255) NULL,
  `favorite_game_id` INT NULL,
  PRIMARY KEY (`user_id`),
  INDEX `fk_profile_user1_idx` (`user_id` ASC),
  INDEX `fk_profile_game1_idx` (`favorite_game_id` ASC),
  CONSTRAINT `fk_profile_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `game_list`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_profile_game1`
    FOREIGN KEY (`favorite_game_id`)
    REFERENCES `game_list`.`game` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `game_list`.`review`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `game_list`.`review` (
  `game_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `is_recommanded` TINYINT(1) NOT NULL,
  `comment` TEXT NULL,
  PRIMARY KEY (`game_id`, `user_id`),
  INDEX `fk_game_has_user_user1_idx` (`user_id` ASC),
  INDEX `fk_game_has_user_game1_idx` (`game_id` ASC),
  CONSTRAINT `fk_game_has_user_game1`
    FOREIGN KEY (`game_id`)
    REFERENCES `game_list`.`game` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_game_has_user_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `game_list`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `game_list`.`library`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `game_list`.`library` (
  `user_id` INT NOT NULL,
  `game_id` INT NOT NULL,
  `status` INT NOT NULL,
  PRIMARY KEY (`user_id`, `game_id`),
  INDEX `fk_user_has_game_game1_idx` (`game_id` ASC),
  INDEX `fk_user_has_game_user1_idx` (`user_id` ASC),
  CONSTRAINT `fk_user_has_game_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `game_list`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_has_game_game1`
    FOREIGN KEY (`game_id`)
    REFERENCES `game_list`.`game` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
