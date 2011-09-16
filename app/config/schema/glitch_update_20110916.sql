ALTER TABLE `listings` ADD `category` VARCHAR( 32 ) NULL AFTER `expires` ;

UPDATE listings SET category = (SELECT category FROM items WHERE listings.item_id = items.id LIMIT 1) WHERE category IS NULL;