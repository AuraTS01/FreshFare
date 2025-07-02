CREATE TABLE fresh_fare_signup (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `mob_num` bigint(200) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` varchar(2000) NOT NULL,
  `category` varchar(2000) NOT NULL,
  `access` int(100) NOT NULL,
  `country` varchar(2000) NOT NULL,
  `Address_1` varchar(2000) NOT NULL,
  `Address_2` varchar(2000) NOT NULL,
  `town` varchar(2000) NOT NULL,
  `state` varchar(2000) NOT NULL,
  `zipCode` int(200) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
ALTER TABLE `fresh_fare_signup` ADD `country` varchar(2000) NOT NULL
ALTER TABLE `fresh_fare_signup` ADD `Address_1` varchar(2000) NOT NULL
ALTER TABLE `fresh_fare_signup` ADD `Address_2` varchar(2000) NOT NULL
ALTER TABLE `fresh_fare_signup` ADD `town` varchar(2000) NOT NULL
ALTER TABLE `fresh_fare_signup` ADD `state` varchar(2000) NOT NULL
ALTER TABLE `fresh_fare_signup` ADD `zipCode` varchar(2000) NOT NULL
ALTER TABLE `fresh_fare_signup` ADD `zipCode` INT(11) NOT NULL;

