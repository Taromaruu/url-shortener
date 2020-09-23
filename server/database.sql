CREATE TABLE `url` (
    `id` INT(21) NOT NULL AUTO_INCREMENT,
    `identifier` VARCHAR(5) NOT NULL,
    `url` TEXT NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE (`identifier`)
) ENGINE = InnoDB; 