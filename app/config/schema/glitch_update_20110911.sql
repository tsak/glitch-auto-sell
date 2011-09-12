# New fields to allow consistent calculations for changing rules
ALTER TABLE `auctions` ADD `quantity` INT UNSIGNED NULL ,
ADD `price` INT UNSIGNED NULL ;

# Auction status
ALTER TABLE `auctions` ADD `status` ENUM( 'PENDING', 'SOLD', 'UNSOLD' ) NOT NULL DEFAULT 'PENDING' AFTER `rule_id` ;

