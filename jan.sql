ALTER TABLE `members` ADD `member_type` INT NULL DEFAULT NULL AFTER `id_number`;
CREATE TABLE `usk`.`member_references` (`id` INT NOT NULL AUTO_INCREMENT , `member_id` INT NOT NULL , `refere_member_id` INT NOT NULL , `uuid` VARCHAR(100) NOT NULL , `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , `updated_at` DATETIME on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ENGINE = InnoDB;
ALTER TABLE `member_references` CHANGE `refere_member_id` `refer_member_id` INT(11) NOT NULL;
ALTER TABLE `loan_contracts` ADD `disbursment_date` DATE NULL DEFAULT NULL AFTER `start_date`;
ALTER TABLE `loan_guarantors` ADD `comment` TEXT NULL DEFAULT NULL AFTER `status`;


