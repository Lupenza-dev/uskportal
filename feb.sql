ALTER TABLE `stock_past_due` ADD `penalty_paid` FLOAT NOT NULL DEFAULT '0' AFTER `penalty`, ADD `paid_status` BOOLEAN NOT NULL DEFAULT FALSE AFTER `penalty_paid`;
ALTER TABLE `fee_past_dues` ADD `penalty_paid` FLOAT NOT NULL DEFAULT '0' AFTER `penalty`, ADD `paid_status` BOOLEAN NOT NULL DEFAULT FALSE AFTER `penalty_paid`;
ALTER TABLE `stock_past_due` ADD `outstanding_amount` FLOAT NOT NULL DEFAULT '0' AFTER `paid_status`, ADD `current_balance` FLOAT NOT NULL DEFAULT '0' AFTER `outstanding_amount`, ADD `last_paid_amount` FLOAT NOT NULL DEFAULT '0' AFTER `current_balance`;
ALTER TABLE `stock_past_due` ADD `payment_id` INT NULL DEFAULT NULL AFTER `last_paid_amount`;

ALTER TABLE `payment_requests` ADD `comment` TEXT NULL DEFAULT NULL AFTER `payment_for_month`, ADD `attended_date` DATETIME NULL DEFAULT NULL AFTER `comment`;

//above already
ALTER TABLE `member_saving_summaries` ADD `stock_penalty_excess_paid` FLOAT NULL DEFAULT NULL AFTER `last_fee_amount`;
ALTER TABLE `member_saving_summaries` ADD `stock_current_pdd` INT NULL DEFAULT '0' AFTER `stock_penalty_excess_paid`;
ALTER TABLE `fee_past_dues` ADD `current_balance` FLOAT NOT NULL DEFAULT '0' AFTER `paid_status`, ADD `last_paid_amount` FLOAT NOT NULL DEFAULT '0' AFTER `current_balance`, ADD `payment_id` INT NULL DEFAULT NULL AFTER `last_paid_amount`;
ALTER TABLE `member_saving_summaries` ADD `fee_penalty_excess_paid` FLOAT NOT NULL DEFAULT '0' AFTER `stock_current_pdd`, ADD `fee_current_pdd` INT NOT NULL DEFAULT '0' AFTER `fee_penalty_excess_paid`;
ALTER TABLE `fee_past_dues` ADD `outstanding_amount` FLOAT NOT NULL DEFAULT '0' AFTER `current_balance`;


already above
ALTER TABLE `loan_contracts` ADD `highest_past_due_days` INT NOT NULL DEFAULT '0' AFTER `past_due_days`;

