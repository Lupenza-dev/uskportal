ALTER TABLE `stock_past_due` ADD `penalty_paid` FLOAT NOT NULL DEFAULT '0' AFTER `penalty`, ADD `paid_status` BOOLEAN NOT NULL DEFAULT FALSE AFTER `penalty_paid`;
ALTER TABLE `fee_past_dues` ADD `penalty_paid` FLOAT NOT NULL DEFAULT '0' AFTER `penalty`, ADD `paid_status` BOOLEAN NOT NULL DEFAULT FALSE AFTER `penalty_paid`;
ALTER TABLE `stock_past_due` ADD `outstanding_amount` FLOAT NOT NULL DEFAULT '0' AFTER `paid_status`, ADD `current_balance` FLOAT NOT NULL DEFAULT '0' AFTER `outstanding_amount`, ADD `last_paid_amount` FLOAT NOT NULL DEFAULT '0' AFTER `current_balance`;
ALTER TABLE `stock_past_due` ADD `payment_id` INT NULL DEFAULT NULL AFTER `last_paid_amount`;
