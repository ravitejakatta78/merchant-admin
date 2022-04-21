ALTER TABLE `food_categeries` ADD `merchant_id` VARCHAR(100) NOT NULL AFTER `food_category`; 

CREATE TABLE food_category_types (
 `ID` INT NOT NULL AUTO_INCREMENT ,
 `food_cat_id` INT(11) NOT NULL ,
 `merchant_id` VARCHAR(100) NOT NULL ,
 `food_type_name` VARCHAR(255) NOT NULL ,
 `reg_date` VARCHAR(50) NOT NULL ,
 PRIMARY KEY (`ID`)) ENGINE = InnoDB; 
 
 ALTER TABLE `product` ADD `food_category_quantity` INT(11) NULL DEFAULT NULL AFTER `status`; 


ALTER TABLE `tablename` ADD `table_status` INT(11) NULL DEFAULT NULL AFTER `status`, ADD `current_order_id` INT(11) NULL DEFAULT NULL AFTER `table_status`; 

ALTER TABLE `merchant_gallery` ADD `status` INT NULL DEFAULT NULL AFTER `image`; 

CREATE TABLE `ingredients` ( `ID` INT(11) NOT NULL AUTO_INCREMENT , `item_name` VARCHAR(255) NOT NULL , `item_type` VARCHAR(255) NULL DEFAULT NULL , `item_price` DOUBLE NULL DEFAULT NULL , `photo` TEXT NULL DEFAULT NULL , `stock_alert` DOUBLE NULL DEFAULT NULL , `status` INT(11) NOT NULL , `reg_date` VARCHAR(50) NOT NULL , `modify_date` VARCHAR(50) NULL DEFAULT NULL , `merchant_id` VARCHAR(50) NOT NULL , PRIMARY KEY (`ID`)) ENGINE = InnoDB;

CREATE TABLE `merchant_recipe` ( `ID` INT NOT NULL AUTO_INCREMENT , `product_id` INT NOT NULL , `ingredient_id` INT NOT NULL , `ingred_quantity` DOUBLE NOT NULL , `ingred_price` DOUBLE NOT NULL , `status` INT NOT NULL , `reg_date` VARCHAR(50) NOT NULL , `modify_date` VARCHAR(50) NOT NULL , PRIMARY KEY (`ID`)) ENGINE = InnoDB; 
ALTER TABLE `merchant_recipe` ADD `merchant_id` INT NOT NULL AFTER `status`; 