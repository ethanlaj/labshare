-- -----------------------------------------------------
-- Schema labshare
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `labshare`;
USE `labshare` ;

-- -----------------------------------------------------
-- Table `labshare`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `labshare`.`users` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(20) NOT NULL,
  `pwd` VARCHAR(100) NOT NULL,
  `firstName` VARCHAR(45) NOT NULL,
  `lastName` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `phoneNumber` VARCHAR(12) NULL DEFAULT NULL,
  `birthday` DATE NOT NULL,
  `inactive` BIT(1) NOT NULL DEFAULT 0,
  `qualifications` VARCHAR(45) NULL DEFAULT NULL,
  `areaofstudy` VARCHAR(45) NULL DEFAULT NULL,
  `years` VARCHAR(45) NULL DEFAULT NULL,
  `secondarea` VARCHAR(45) NULL DEFAULT NULL,
  `summary` VARCHAR(250) NULL DEFAULT NULL,
  `achievements` VARCHAR(250) NULL DEFAULT NULL,
  `profilepic` VARCHAR(200) NULL DEFAULT NULL,
  `banner` VARCHAR(200) NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE INDEX `username` (`username` ASC) VISIBLE);

-- -----------------------------------------------------
-- Table `labshare`.`posts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `labshare`.`posts` (
  `post_id` INT NOT NULL AUTO_INCREMENT,
  `creationDate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author_id` INT NOT NULL,
  `title` VARCHAR(50) NOT NULL,
  `content` VARCHAR(2000) NOT NULL,
  `inactive` BIT(1) NOT NULL DEFAULT b'0',
  `zip` INT NULL DEFAULT NULL,
  `lat` DECIMAL(6,4) NULL DEFAULT NULL,
  `lon` DECIMAL(6,4) NULL DEFAULT NULL,
  PRIMARY KEY (`post_id`),
  CONSTRAINT `posts_ibfk_1`
    FOREIGN KEY (`author_id`)
    REFERENCES `labshare`.`users` (`user_id`));


-- -----------------------------------------------------
-- Table `labshare`.`applications`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `labshare`.`applications` (
  `user_id` INT NOT NULL,
  `post_id` INT NOT NULL,
  `status` ENUM('AWAIT', 'DECLINE', 'ACCEPT') NOT NULL DEFAULT 'AWAIT',
  PRIMARY KEY (`user_id`, `post_id`),
  CONSTRAINT `applications_ibfk_1`
    FOREIGN KEY (`user_id`)
    REFERENCES `labshare`.`users` (`user_id`),
  CONSTRAINT `applications_ibfk_2`
    FOREIGN KEY (`post_id`)
    REFERENCES `labshare`.`posts` (`post_id`));


-- -----------------------------------------------------
-- Table `labshare`.`comments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `labshare`.`comments` (
  `comment_id` INT NOT NULL AUTO_INCREMENT,
  `post_id` INT NOT NULL,
  `author_id` INT NOT NULL,
  `creationDate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `parent_id` INT NULL DEFAULT NULL,
  `content` VARCHAR(500) NOT NULL,
  `inactive` BIT(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`comment_id`),
  CONSTRAINT `comments_ibfk_1`
    FOREIGN KEY (`post_id`)
    REFERENCES `labshare`.`posts` (`post_id`),
  CONSTRAINT `comments_ibfk_2`
    FOREIGN KEY (`author_id`)
    REFERENCES `labshare`.`users` (`user_id`),
  CONSTRAINT `comments_ibfk_3`
    FOREIGN KEY (`parent_id`)
    REFERENCES `labshare`.`comments` (`comment_id`));


-- -----------------------------------------------------
-- Table `labshare`.`notifications`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `labshare`.`notifications` (
  `notification_id` INT NOT NULL AUTO_INCREMENT,
  `type` ENUM('NEW_APP', 'APP_ACCEPT', 'APP_DECLINE', 'POST_SAVED') NOT NULL,
  `applicant_id` INT NULL DEFAULT NULL,
  `post_id` INT NULL DEFAULT NULL,
  `inactive` BIT(1) NOT NULL DEFAULT b'0',
  `count` INT NULL DEFAULT NULL,
  `creationDate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`notification_id`),
  CONSTRAINT `notifications_ibfk_1`
    FOREIGN KEY (`applicant_id`)
    REFERENCES `labshare`.`users` (`user_id`),
  CONSTRAINT `notifications_ibfk_2`
    FOREIGN KEY (`post_id`)
    REFERENCES `labshare`.`posts` (`post_id`));


-- -----------------------------------------------------
-- Table `labshare`.`reports`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `labshare`.`reports` (
  `reporter_id` INT NOT NULL,
  `id` INT NOT NULL,
  `type` INT NOT NULL,
  PRIMARY KEY (`reporter_id`, `id`, `type`),
  CONSTRAINT `reports_ibfk_1`
    FOREIGN KEY (`reporter_id`)
    REFERENCES `labshare`.`users` (`user_id`));


-- -----------------------------------------------------
-- Table `labshare`.`saves`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `labshare`.`saves` (
  `user_id` INT NOT NULL,
  `post_id` INT NOT NULL,
  PRIMARY KEY (`user_id`, `post_id`),
  CONSTRAINT `saves_ibfk_1`
    FOREIGN KEY (`user_id`)
    REFERENCES `labshare`.`users` (`user_id`),
  CONSTRAINT `saves_ibfk_2`
    FOREIGN KEY (`post_id`)
    REFERENCES `labshare`.`posts` (`post_id`));

-- -----------------------------------------------------
-- View `labshare`.`advanced_application`
-- -----------------------------------------------------
USE `labshare`;
CREATE OR REPLACE VIEW `labshare`.`advanced_application` AS select `a`.`status` AS `status`,`a`.`post_id` AS `post_id`,`applicant`.`user_id` AS `applicant_id`,`applicant`.`username` AS `applicant_username`,`applicant`.`profilepic` AS `applicant_pic`,`poster`.`user_id` AS `poster_id`,`poster`.`username` AS `poster_username`,`poster`.`profilepic` AS `posterpic` from (((`labshare`.`applications` `a` join `labshare`.`users` `applicant` on((`a`.`user_id` = `applicant`.`user_id`))) join `labshare`.`posts` `p` on((`a`.`post_id` = `p`.`post_id`))) join `labshare`.`users` `poster` on((`p`.`author_id` = `poster`.`user_id`)));

-- -----------------------------------------------------
-- View `labshare`.`advanced_comment`
-- -----------------------------------------------------
USE `labshare`;
CREATE OR REPLACE VIEW `labshare`.`advanced_comment` AS select `c`.`comment_id` AS `comment_id`,`c`.`post_id` AS `post_id`,`c`.`author_id` AS `author_id`,`c`.`creationDate` AS `creationDate`,`c`.`parent_id` AS `parent_id`,`c`.`content` AS `content`,`c`.`inactive` AS `inactive`,`u`.`username` AS `username`,`u`.`profilepic` AS `profilepic`,concat(`u`.`firstName`,' ',`u`.`lastName`) AS `fullName`,(select count(0) from `labshare`.`reports` `r` where ((`r`.`id` = `c`.`comment_id`) and (`r`.`type` = 2))) AS `reports` from (`labshare`.`comments` `c` join `labshare`.`users` `u` on((`c`.`author_id` = `u`.`user_id`)));

-- -----------------------------------------------------
-- View `labshare`.`advanced_notification`
-- -----------------------------------------------------
USE `labshare`;
CREATE OR REPLACE VIEW `labshare`.`advanced_notification` AS select `n`.`notification_id` AS `notification_id`,`n`.`creationDate` AS `notification_date`,`n`.`type` AS `type`,`n`.`post_id` AS `post_id`,`n`.`count` AS `count`,`p`.`title` AS `title`,`p`.`author_id` AS `poster_id`,`poster`.`username` AS `poster`,`poster`.`email` AS `posterEmail`,`poster`.`phoneNumber` AS `posterPhone`,`n`.`applicant_id` AS `applicant_id`,`applicant`.`username` AS `applicant`,`applicant`.`email` AS `applicantEmail`,`applicant`.`phoneNumber` AS `applicantPhone`,`n`.`inactive` AS `inactive` from (((`labshare`.`notifications` `n` join `labshare`.`posts` `p` on((`n`.`post_id` = `p`.`post_id`))) join `labshare`.`users` `poster` on((`p`.`author_id` = `poster`.`user_id`))) left join `labshare`.`users` `applicant` on((`n`.`applicant_id` = `applicant`.`user_id`)));

-- -----------------------------------------------------
-- View `labshare`.`advanced_post`
-- -----------------------------------------------------
USE `labshare`;
CREATE OR REPLACE VIEW `labshare`.`advanced_post` AS select `p`.`post_id` AS `post_id`,`p`.`creationDate` AS `creationDate`,`p`.`author_id` AS `author_id`,`p`.`title` AS `title`,`p`.`content` AS `content`,`p`.`inactive` AS `inactive`,`u`.`username` AS `username`,`u`.`profilepic` AS `profilepic`,concat(`u`.`firstName`,' ',`u`.`lastName`) AS `fullName`,`p`.`zip` AS `zip`,`p`.`lat` AS `lat`,`p`.`lon` AS `lon`,(select count(0) from `labshare`.`reports` `r` where ((`r`.`id` = `p`.`post_id`) and (`r`.`type` = 1))) AS `reports` from (`labshare`.`posts` `p` join `labshare`.`users` `u` on((`p`.`author_id` = `u`.`user_id`)));

-- -----------------------------------------------------
-- View `labshare`.`post_saves`
-- -----------------------------------------------------
USE `labshare`;
CREATE OR REPLACE VIEW `labshare`.`post_saves` AS select `p`.`post_id` AS `post_id`,(select count(0) from `labshare`.`saves` where (`labshare`.`saves`.`post_id` = `p`.`post_id`)) AS `count` from `labshare`.`posts` `p`;
USE `labshare`;

DELIMITER $$
USE `labshare`$$
CREATE
TRIGGER `labshare`.`application_created`
AFTER INSERT ON `labshare`.`applications`
FOR EACH ROW
BEGIN
	INSERT INTO notifications(type, applicant_id, post_id)
    VALUES ('NEW_APP', NEW.user_id, NEW.post_id);
END$$

USE `labshare`$$
CREATE
TRIGGER `labshare`.`application_updated`
AFTER UPDATE ON `labshare`.`applications`
FOR EACH ROW
BEGIN
	IF (NEW.status = 'DECLINE')
    THEN
		INSERT INTO notifications(type, applicant_id, post_id)
		VALUES ('APP_DECLINE', NEW.user_id, NEW.post_id);
	ELSE IF (NEW.status = 'ACCEPT')
    THEN
		INSERT INTO notifications(type, applicant_id, post_id)
		VALUES ('APP_ACCEPT', NEW.user_id, NEW.post_id);
    END IF;
END IF;
END$$

USE `labshare`$$
CREATE
TRIGGER `labshare`.`after_report`
AFTER INSERT ON `labshare`.`reports`
FOR EACH ROW
BEGIN
	IF (NEW.type=1) THEN
		IF (SELECT reports FROM advanced_post WHERE post_id=NEW.id) > 4 THEN
			UPDATE posts SET inactive=1 WHERE post_id=NEW.id;
		END IF;
    END IF;
	IF (NEW.type=2) THEN
		IF (SELECT reports FROM advanced_comment WHERE comment_id=NEW.id) > 4 THEN
			UPDATE comments SET inactive=1 WHERE comment_id=NEW.id;
		END IF;
	END IF;
END$$

USE `labshare`$$
CREATE
TRIGGER `labshare`.`new_save`
AFTER INSERT ON `labshare`.`saves`
FOR EACH ROW
BEGIN
	SET @count = (SELECT `count` FROM post_saves WHERE post_id=NEW.post_id);
    IF (MOD(@count, 5) = 0)
    THEN
		IF EXISTS (SELECT notification_id 
        FROM notifications n 
        WHERE n.post_id = new.post_id 
        AND type = 'POST_SAVED' 
        AND inactive = 0)
        THEN
			UPDATE notifications n
            SET `count` = @count
            WHERE n.post_id = new.post_id 
			AND type = 'POST_SAVED' 
			AND inactive = 0;
		ELSE
			INSERT INTO notifications (type, post_id, `count`)
            VALUES ('POST_SAVED', new.post_id, @count);
		END IF;
        END IF;
END$$


DELIMITER ;
