CREATE TABLE `symbol_maps` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `from_symbol` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_symbol` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

ALTER TABLE users ADD COLUMN profile_picture TEXT NULL DEFAULT NULL AFTER email;
ALTER TABLE `settings` ADD COLUMN `use_copytrade` BOOLEAN NULL DEFAULT 1 AFTER should_cancel_plan,
ADD COLUMN `subscription_type` VARCHAR(191) NULL DEFAULT 'Fixed' AFTER should_cancel_plan,
ADD COLUMN `percentage_fee` DECIMAL(8,2) NULL DEFAULT 0 AFTER subscription_type,
ADD COLUMN `billing_period` VARCHAR(11) NULL DEFAULT 'month' AFTER commission_type,
ADD COLUMN `environment` VARCHAR(11) NULL DEFAULT 'local' AFTER `theme`,
ADD COLUMN `debug_mode` BOOLEAN NULL DEFAULT TRUE AFTER environment,
ADD COLUMN `route_cached` BOOLEAN NULL DEFAULT FALSE AFTER  `theme`,
ADD COLUMN `view_cached` BOOLEAN NULL DEFAULT FALSE AFTER `route_cached`,
ADD COLUMN `config_cached` BOOLEAN NULL DEFAULT FALSE AFTER `view_cached`,
ADD COLUMN `themes` JSON NULL AFTER `theme`,
ADD COLUMN `ib_link` TEXT NULL AFTER `theme`;

ALTER TABLE `mt4_details` 
ADD COLUMN `copying_trade` BOOLEAN NULL DEFAULT 0 AFTER status,
ADD COLUMN `provider` VARCHAR(191) NULL AFTER copying_trade,
ADD COLUMN `strategy` TEXT NULL AFTER provider;

UPDATE settings SET theme = 'purpose';
-- update the themes json column with the values purpose and millage
UPDATE settings SET themes = JSON_ARRAY('purpose', 'millage');