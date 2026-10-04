-- Run this file only when upgrading the completed TFA3 database to TFA4.
USE `it0049_pos`;

ALTER TABLE `users`
ADD COLUMN `password` VARCHAR(255) NULL AFTER `username`;

-- All existing classroom accounts use TFA4pass123! for initial testing.
-- Only the password hash is stored in the database.
UPDATE `users`
SET `password` = '$2y$12$JHnCjP8guQgimkl8ewVYr.yvx2/JMQFod57TUubFNheqa7EWAB6ay'
WHERE `password` IS NULL;

ALTER TABLE `users`
MODIFY COLUMN `password` VARCHAR(255) NOT NULL;
