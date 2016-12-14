SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `FifaLeague` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `FifaLeague` ;

-- -----------------------------------------------------
-- DROP Tables
-- -----------------------------------------------------
DROP TABLE IF EXISTS `FifaLeague`.`User`;
DROP TABLE IF EXISTS `FifaLeague`.`League`;
DROP TABLE IF EXISTS `FifaLeague`.`Team`;
#DROP TABLE IF EXISTS `FifaLeague`.`Musica_Playlist`;



-- -----------------------------------------------------
-- Table `FifaLeague`.`User`
-- -----------------------------------------------------
/*CREATE  TABLE IF NOT EXISTS `FifaLeague`.`User` (
  `IDUser` INT NOT NULL AUTO_INCREMENT ,
  `Nome` VARCHAR(50) NOT NULL ,
  `Username` VARCHAR(20) UNIQUE NOT NULL ,
  `Password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`IDUser`) ,
  UNIQUE INDEX `username_UNIQUE` (`Username` ASC) )
ENGINE = InnoDB;*/


-- -----------------------------------------------------
-- Table `FifaLeague`.`League`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `FifaLeague`.`League` (
  `IDLeague` INT NOT NULL AUTO_INCREMENT ,
  `Name` VARCHAR(50) NOT NULL ,
  `Location` VARCHAR(50) NULL,
  PRIMARY KEY (`IDLeague`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `FifaLeague`.`Team`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `FifaLeague`.`Team` (
  `IDTeam` INT NOT NULL AUTO_INCREMENT ,
  `Name` VARCHAR(50) NOT NULL ,
  `Logo` VARCHAR (70) NOT NULL ,
  `Url` VARCHAR (70) NULL,
  `RefIDLeague` INT NOT NULL ,
  PRIMARY KEY (`IDTeam`) ,
  CONSTRAINT `fk_Team_League`
    FOREIGN KEY (`RefIDLeague` )
    REFERENCES `FifaLeague`.`League` (`IDLeague` ))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `FifaLeague`.`Musica_Playlist`
-- -----------------------------------------------------
/*CREATE  TABLE IF NOT EXISTS `FifaLeague`.`Musica_Playlist` (
  `RefIDPlaylist` INT NOT NULL ,
  `RefIDMusica` INT NOT NULL ,
  PRIMARY KEY (`RefIDMusica` , `RefIDPlaylist`) ,
  CONSTRAINT `fk_MP_Playlist`
    FOREIGN KEY (`RefIDPlaylist` )
    REFERENCES `FifaLeague`.`Playlist` (`IDPlaylist` ),
  CONSTRAINT `fk_MP_Musica`
    FOREIGN KEY (`RefIDMusica` )
    REFERENCES `FifaLeague`.`Musica` (`IDMusica` ) )
ENGINE = InnoDB;*/

USE `FifaLeague` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;