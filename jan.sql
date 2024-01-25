ALTER TABLE `members` ADD `member_type` INT NULL DEFAULT NULL AFTER `id_number`;
CREATE TABLE `usk`.`member_references` (`id` INT NOT NULL AUTO_INCREMENT , `member_id` INT NOT NULL , `refere_member_id` INT NOT NULL , `uuid` VARCHAR(100) NOT NULL , `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , `updated_at` DATETIME on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ENGINE = InnoDB;
ALTER TABLE `member_references` CHANGE `refere_member_id` `refer_member_id` INT(11) NOT NULL;
ALTER TABLE `loan_contracts` ADD `disbursment_date` DATE NULL DEFAULT NULL AFTER `start_date`;
ALTER TABLE `loan_guarantors` ADD `comment` TEXT NULL DEFAULT NULL AFTER `status`;
ALTER TABLE `member_saving_summaries` ADD `past_due_days` INT NOT NULL DEFAULT '0' AFTER `fees`;
ALTER TABLE `member_saving_summaries` ADD `stock_for_month` VARCHAR(255) NULL DEFAULT NULL AFTER `last_purchase_date`;
ALTER TABLE `member_saving_summaries` ADD `stock_penalty` FLOAT NOT NULL DEFAULT '0' AFTER `past_due_days`;
ALTER TABLE `member_saving_summaries` ADD `fee_for_month` VARCHAR(100) NULL DEFAULT NULL AFTER `stock_for_month`;
ALTER TABLE `member_saving_summaries` ADD `fee_past_due_days` INT NOT NULL DEFAULT '0' AFTER `stock_penalty`, ADD `fee_penalty` FLOAT NULL DEFAULT '0' AFTER `fee_past_due_days`;
ALTER TABLE `member_saving_summaries` ADD `last_fee_purchase_date` DATE NULL DEFAULT NULL ;

