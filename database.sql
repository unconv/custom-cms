CREATE TABLE `elements` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `page` BIGINT NOT NULL , `type` TINYINT NOT NULL , `data` TEXT NOT NULL , PRIMARY KEY (`id`), INDEX (`page`)) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_swedish_ci;
ALTER TABLE `elements` ADD `weight` INT NOT NULL AFTER `data`;
CREATE TABLE `pages` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `name` VARCHAR(64) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_swedish_ci;
