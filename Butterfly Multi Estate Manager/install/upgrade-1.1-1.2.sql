CREATE TABLE `upload` (
	`upload_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`upload_name` TEXT NOT NULL,
	`upload_parent` INT NOT NULL,
	INDEX (`upload_parent`) 
) ENGINE = MYISAM ;
