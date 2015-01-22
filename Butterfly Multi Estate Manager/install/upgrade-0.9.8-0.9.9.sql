ALTER TABLE `settings` 
	ADD `email_paypal` TEXT NOT NULL, 
	ADD `email_notify` TEXT NOT NULL, 
	ADD `price` TEXT NOT NULL, 
	ADD `free_listing` TINYINT (1) NOT NULL;

UPDATE `settings` SET 
	`email_paypal` = 'you@youremail.com', 
	`email_notify` = 'you@youremail.com', 
	`price` = '1.99', 
	`free_listing` = '1' WHERE `sid` = 1 
LIMIT 1;
