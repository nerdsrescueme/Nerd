SET FOREIGN_KEY_CHECKS=0;
SET AUTOCOMMIT=0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


-- ---------------------------------------------------------------------------------
-- Nerd Utility Tables
-- ---------------------------------------------------------------------------------

DROP TABLE IF EXISTS `nerd_sessions`;
CREATE TABLE IF NOT EXISTS `nerd_sessions` (
  `id` char(50) NOT NULL,
  `data` text(4000) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `updated_at` (`updated_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `nerd_keywords`;
CREATE TABLE IF NOT EXISTS `nerd_keywords` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `keyword` char(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `keyword` (`keyword`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `nerd_cities`;
CREATE TABLE IF NOT EXISTS `nerd_cities` (
  `city` char(50) NOT NULL,
  `state` char(2) NOT NULL,
  `zip` int(5) unsigned zerofill NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `county` char(50) NOT NULL,
  PRIMARY KEY (`zip`),
  KEY `county` (`county`),
  KEY `state` (`state`),
  KEY `city` (`city`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `nerd_countries`;
CREATE TABLE IF NOT EXISTS `nerd_countries` (
  `short` char(2) NOT NULL,
  `long` char(3) NOT NULL,
  `numeric` varchar(3) NOT NULL,
  `name` char(50) NOT NULL,
  PRIMARY KEY (`short`),
  UNIQUE KEY `long` (`long`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `nerd_states`;
CREATE TABLE IF NOT EXISTS `nerd_states` (
  `code` char(2) NOT NULL,
  `name` char(32) NOT NULL,
  PRIMARY KEY (`code`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `nerd_states` (`code`, `name`) VALUES ('AL', 'Alabama'),('AK', 'Alaska'),('AZ', 'Arizona'),('AR', 'Arkansas'),('CA', 'California'),('CO', 'Colorado'),('CT', 'Connecticut'),('DE', 'Delaware'),('DC', 'District of Columbia'),('FL', 'Florida'),('GA', 'Georgia'),('HI', 'Hawaii'),('ID', 'Idaho'),('IL', 'Illinois'),('IN', 'Indiana'),('IA', 'Iowa'),('KS', 'Kansas'),('KY', 'Kentucky'),('LA', 'Louisiana'),('ME', 'Maine'),('MD', 'Maryland'),('MA', 'Massachusetts'),('MI', 'Michigan'),('MN', 'Minnesota'),('MS', 'Mississippi'),('MO', 'Missouri'),('MT', 'Montana'),('NE', 'Nebraska'),('NV', 'Nevada'),('NH', 'New Hampshire'),('NJ', 'New Jersey'),('NM', 'New Mexico'),('NY', 'New York'),('NC', 'North Carolina'),('ND', 'North Dakota'),('OH', 'Ohio'),('OK', 'Oklahoma'),('OR', 'Oregon'),('PA', 'Pennsylvania'),('PR', 'Puerto Rico'),('RI', 'Rhode Island'),('SC', 'South Carolina'),('SD', 'South Dakota'),('TN', 'Tennessee'),('TX', 'Texas'),('UT', 'Utah'),('VT', 'Vermont'),('VA', 'Virginia'),('WA', 'Washington'),('WV', 'West Virginia'),('WI', 'Wisconsin'),('WY', 'Wyoming');

DROP TABLE IF EXISTS `nerd_themes`;
CREATE TABLE IF NOT EXISTS `nerd_themes` (
  `id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(32) NOT NULL,
  `description` char(250) DEFAULT NULL, 
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `nerd_layouts`;
CREATE TABLE IF NOT EXISTS `nerd_layouts` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `theme_id` int(2) unsigned NOT NULL,
  `title` char(32) NOT NULL,
  `description` char(250) DEFAULT NULL,
  `source` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY(`id`)
);

DROP TABLE IF EXISTS `nerd_words`;
CREATE TABLE IF NOT EXISTS `nerd_words` (
  `word` char(32) NOT NULL,
  PRIMARY KEY (`word`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ---------------------------------------------------------------------------------
-- Nerd Page Handling
-- ---------------------------------------------------------------------------------

DROP TABLE IF EXISTS `nerd_pages`;
CREATE TABLE IF NOT EXISTS `nerd_pages` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(2) unsigned NOT NULL,
  `type` int(2) NOT NULL DEFAULT 0,
  `layout` char(32) NOT NULL DEFAULT 'default',
  `title` char(160) NOT NULL,
  `subtitle` char(160) DEFAULT NULL,
  `uri` char(200) NOT NULL,
  `description` char(200) DEFAULT NULL,
  `status` int(2) unsigned zerofill NOT NULL DEFAULT '06',
  `priority` int(2) unsigned zerofill NOT NULL DEFAULT '05',
  `change_frequency` int(2) unsigned zerofill NOT NULL DEFAULT '06',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY (`site_id`, `uri`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

  DROP TABLE IF EXISTS `nerd_page_history`;
  CREATE TABLE IF NOT EXISTS `nerd_page_history` (
    `page_id` int(8) unsigned NOT NULL,
    `site_id` int(2) unsigned NOT NULL,
    `title` char(160) NOT NULL,
    `subtitle` char(160) DEFAULT NULL,
    `uri` char(200) NOT NULL,
    `description` char(200) DEFAULT NULL,
    `status` int(2) unsigned zerofill NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`page_id`, `created_at`)
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

  DELIMITER $$
  DROP TRIGGER IF EXISTS `before_nerd_pages`;
  CREATE TRIGGER `before_nerd_pages`
    BEFORE UPDATE ON `nerd_pages` FOR EACH ROW
    BEGIN
   -- INSERT old data into the page history
      INSERT INTO `nerd_page_history` ( `page_id`, `site_id`, `title`, `subtitle`, `uri`, `description`, `status` ) VALUES
      ( OLD.`id`, OLD.`site_id`, OLD.`title`,  OLD.`subtitle`, OLD.`uri`, OLD.`description`, OLD.`status`);

   -- DELETE all but the last 10 versions of this page.
      DELETE FROM `nerd_page_history` WHERE `created_at` NOT IN (
        SELECT `created_at` FROM (
          SELECT `created_at` FROM `nerd_page_history` WHERE `page_id` = OLD.`id` ORDER BY `created_at` DESC LIMIT 10
        ) `history`
      );
    END
  $$
  DELIMITER ;

  DROP TABLE IF EXISTS `nerd_snippets`;
  CREATE TABLE IF NOT EXISTS `nerd_snippets` (
    `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
    `page_id` int(8) unsigned NOT NULL,
    `key` char(32) NOT NULL,
    `data` text NOT NULL,
    PRIMARY KEY (`id`),
    KEY `page_id` (`page_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

  DROP TABLE IF EXISTS `nerd_components`;
  CREATE TABLE IF NOT EXISTS `nerd_components` (
    `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
    `page_id` int(8) unsigned NOT NULL,
    `key` char(32) NOT NULL,
    `data` text NOT NULL,
    PRIMARY KEY (`id`),
    KEY `page_id` (`page_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

  DROP TABLE IF EXISTS `nerd_regions`;
  CREATE TABLE IF NOT EXISTS `nerd_regions` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `page_id` int(8) unsigned NOT NULL,
    `key` char(32) NOT NULL,
    `data` text NOT NULL,
    PRIMARY KEY (`id`),
    KEY `page_id` (`page_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


  DROP TABLE IF EXISTS `nerd_region_history`;
  CREATE TABLE IF NOT EXISTS `nerd_region_history` (
    `region_id` int(11) unsigned NOT NULL,
    `data` text NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`region_id`, `created_at`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

  DELIMITER $$
  DROP TRIGGER IF EXISTS `before_nerd_regions`;
  CREATE TRIGGER `before_nerd_regions`
    BEFORE UPDATE ON `nerd_regions` FOR EACH ROW
    BEGIN
   -- INSERT old data into the region history
      INSERT INTO `nerd_region_history` (`region_id`, `data` ) VALUES
      (OLD.`id`, OLD.`data`);

   -- DELETE all but the last 10 versions of this region.
      DELETE FROM `nerd_region_history` WHERE `created_at` NOT IN (
        SELECT `created_at` FROM (
          SELECT `created_at` FROM `nerd_region_history` WHERE `region_id` = OLD.`id` ORDER BY `created_at` DESC LIMIT 10
        ) `history`
      );
    END
  $$
  DELIMITER ;

  DROP TABLE IF EXISTS `nerd_globals`;
  CREATE TABLE IF NOT EXISTS `nerd_globals` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `key` char(32) NOT NULL,
    `data` text NOT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


  DROP TABLE IF EXISTS `nerd_global_history`;
  CREATE TABLE IF NOT EXISTS `nerd_global_history` (
    `global_id` int(11) unsigned NOT NULL,
    `data` text NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`global_id`, `created_at`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

  DELIMITER $$
  DROP TRIGGER IF EXISTS `before_nerd_globals`;
  CREATE TRIGGER `before_nerd_globals`
    BEFORE UPDATE ON `nerd_globals` FOR EACH ROW
    BEGIN
   -- INSERT old data into the global history
      INSERT INTO `nerd_global_history` (`global_id`, `data`) VALUES
      (OLD.`id`, OLD.`data`);

   -- DELETE all but the last 10 versions of this global.
      DELETE FROM `nerd_global_history` WHERE `created_at` NOT IN (
        SELECT `created_at` FROM (
          SELECT `created_at` FROM `nerd_global_history` WHERE `global_id` = OLD.`id` ORDER BY `created_at` DESC LIMIT 10
        ) `history`
      );
    END
  $$
  DELIMITER ;

  DROP TABLE IF EXISTS `nerd_page_keywords`;
  CREATE TABLE IF NOT EXISTS `nerd_page_keywords` (
    `page_id` int(8) unsigned NOT NULL,
    `keyword_id` int(11) unsigned NOT NULL,
    PRIMARY KEY (`page_id`,`keyword_id`),
    KEY `keyword_id` (`keyword_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


-- ---------------------------------------------------------------------------------
-- Nerd Sites
-- ---------------------------------------------------------------------------------

DROP TABLE IF EXISTS `nerd_sites`;
CREATE TABLE IF NOT EXISTS `nerd_sites` (
  `id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `host` char(180) NOT NULL,
  `theme` char(32) NOT NULL DEFAULT 'default',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `maintaining` tinyint(1) NOT NULL DEFAULT '0',
  `description` char(200) COLLATE utf8_bin NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

  DROP TABLE IF EXISTS `nerd_site_metadata`;
  CREATE TABLE IF NOT EXISTS `nerd_site_metadata` (
    `site_id` int(2) unsigned NOT NULL,
    `blog_enabled` boolean DEFAULT 1,
    `store_enabled` boolean DEFAULT 0,
    PRIMARY KEY (`site_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

  DROP TABLE IF EXISTS `nerd_site_users`;
  CREATE TABLE IF NOT EXISTS `nerd_site_users` (
    `site_id` int(2) unsigned NOT NULL,
    `user_id` int(5) unsigned NOT NULL,
    PRIMARY KEY (`site_id`,`user_id`),
    KEY `user_id` (`user_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

  DELIMITER $$
  DROP TRIGGER IF EXISTS `after_nerd_sites`;
  CREATE TRIGGER `after_nerd_sites`
    AFTER INSERT ON `nerd_sites` FOR EACH ROW
    BEGIN
      -- Create default site metadata record
      INSERT INTO `nerd_site_metadata` (`site_id`) VALUES (NEW.`id`);

      -- Add two default users to this site's admins
      INSERT INTO `nerd_site_users` (`site_id`, `user_id`) VALUES (NEW.`id`, 1), (NEW.`id`, 2), (NEW.`id`, 3);

      -- Create default pages.
      INSERT INTO `nerd_pages` (`site_id`, `layout`, `title`, `subtitle`, `uri`, `description`, `status`, `priority`, `change_frequency`, `updated_at`, `created_at`) VALUES
        (NEW.`id`, 'home', 'Home Page', '', '@@HOME', '', 'one', 10, 'daily', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
        (NEW.`id`, 'login', 'Login', null, '@@LOGIN', '', 'one', 1, 'yearly', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
        (NEW.`id`, 'default', '404', 'Page Not Found', '@@404', '', 'one', 1, 'monthly', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
        (NEW.`id`, 'default', '500', 'Internal Server Error', '@@500', '', 'one', 1, 'monthly', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
    END
  $$
  DELIMITER ;

  DROP TABLE IF EXISTS `nerd_site_keywords`;
  CREATE TABLE IF NOT EXISTS `nerd_site_keywords` (
    `site_id` int(2) unsigned NOT NULL,
    `keyword_id` int(11) unsigned NOT NULL,
    PRIMARY KEY (`site_id`,`keyword_id`),
    KEY `keyword_id` (`keyword_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


-- ---------------------------------------------------------------------------------
-- Comment Objects
-- ---------------------------------------------------------------------------------

DROP TABLE IF EXISTS `nerd_comments`;
CREATE TABLE IF NOT EXISTS `nerd_comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(2) unsigned NOT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `data` text NOT NULL,
  `status` int(2) unsigned zerofill NOT NULL DEFAULT '01',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

  DROP TABLE IF EXISTS `nerd_comment_metadata`;
  CREATE TABLE IF NOT EXISTS `nerd_comment_metadata` (
    `comment_id` int(10) unsigned NOT NULL,
    `user_name` char(64) DEFAULT NULL,
    `user_email` char(255) DEFAULT NULL,
    `user_url` char(255) DEFAULT NULL,
    `user_id` int(5) unsigned DEFAULT NULL,
    `user_ip` char(45) NOT NULL,
    `user_agent` char(255) NOT NULL,
    PRIMARY KEY (`comment_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


-- ---------------------------------------------------------------------------------
-- Blog Objects
-- ---------------------------------------------------------------------------------

DROP TABLE IF EXISTS `nerd_posts`;
CREATE TABLE IF NOT EXISTS `nerd_posts` (
  `id` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(5) unsigned NOT NULL,
  `site_id` int(2) unsigned NOT NULL,
  `title` char(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `data` text NOT NULL,
  `status` int(2) unsigned zerofill NOT NULL DEFAULT '06',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

  DROP TABLE IF EXISTS `nerd_post_metadata`;
  CREATE TABLE IF NOT EXISTS `nerd_post_metadata` (
    `post_id` int(7) unsigned NOT NULL,
    `weight` int(5) unsigned DEFAULT 1,
    PRIMARY KEY (`post_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

  DROP TABLE IF EXISTS `nerd_post_keywords`;
  CREATE TABLE IF NOT EXISTS `nerd_post_keywords` (
    `post_id` int(7) unsigned NOT NULL,
    `keyword_id` int(11) unsigned NOT NULL,
    PRIMARY KEY (`post_id`,`keyword_id`),
    KEY `keyword_id` (`keyword_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


-- ---------------------------------------------------------------------------------
-- User/Permission Objects
-- ---------------------------------------------------------------------------------

DROP TABLE IF EXISTS `nerd_users`;
CREATE TABLE IF NOT EXISTS `nerd_users` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `super` tinyint(1) NOT NULL DEFAULT '0',
  `username` char(32) NOT NULL,
  `email` char(255) NOT NULL,
  `password` char(81) NOT NULL,
  `salt` char(81) DEFAULT NULL,
  `temp_password` char(81) DEFAULT NULL,
  `remember` char(81) DEFAULT NULL,
  `activation_hash` char(81) DEFAULT NULL,
  `ip` char(45) NOT NULL,
  `status` char(16) NOT NULL DEFAULT 'inactive',
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_login` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `locaters` (`username`,`email`,`password`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

  DROP TABLE IF EXISTS `nerd_user_metadata`;
  CREATE TABLE IF NOT EXISTS `nerd_user_metadata` (
    `user_id` int(5) unsigned NOT NULL,
    `first_name` char(36) DEFAULT NULL,
    `last_name` char(36) DEFAULT NULL,
    `zip` int(5) unsigned zerofill DEFAULT NULL,
    PRIMARY KEY (`user_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

  DROP TABLE IF EXISTS `nerd_roles`;
  CREATE TABLE IF NOT EXISTS `nerd_roles` (
    `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
    `name` char(32) NOT NULL,
    `description` char(255) NOT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

  DROP TABLE IF EXISTS `nerd_users_roles`;
  CREATE TABLE IF NOT EXISTS `nerd_users_roles` (
    `user_id` int(5) unsigned NOT NULL,
    `role_id` int(4) unsigned NOT NULL,
    PRIMARY KEY (`user_id`, `role_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

  DROP TABLE IF EXISTS `nerd_permissions`;
  CREATE TABLE IF NOT EXISTS `nerd_permissions` (
    `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
    `name` char(32) NOT NULL,
    `description` char(255) NOT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

  DROP TABLE IF EXISTS `nerd_roles_permissions`;
  CREATE TABLE IF NOT EXISTS `nerd_roles_permissions` (
    `role_id` int(4) unsigned NOT NULL,
    `permission_id` int(4) unsigned NOT NULL,
    PRIMARY KEY (`role_id`, `permission_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

  DELIMITER $$
  DROP TRIGGER IF EXISTS `after_nerd_users`;
  CREATE TRIGGER `after_nerd_users`
    AFTER INSERT ON `nerd_users` FOR EACH ROW
    BEGIN
      -- Create default user metadata entry
      INSERT INTO `nerd_user_metadata` (`user_id`) VALUES (NEW.`id`);
    END
  $$
  DELIMITER ;
-- ---------------------------------------------------------------------------------
-- Let's make some associations
-- ---------------------------------------------------------------------------------

ALTER TABLE `nerd_users_roles`
  ADD CONSTRAINT `nerd_users_roles-role_id-nerd_roles-id` FOREIGN KEY (`role_id`) REFERENCES `nerd_roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nerd_users_roles-user_id-nerd_users-id` FOREIGN KEY (`user_id`) REFERENCES `nerd_users` (`id`) ON DELETE CASCADE;

ALTER TABLE `nerd_roles_permissions`
  ADD CONSTRAINT `nerd_roles_permissions-role_id-nerd_roles-id` FOREIGN KEY (`role_id`) REFERENCES `nerd_roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nerd_roles_permissions-user_id-nerd_permissions-id` FOREIGN KEY (`permission_id`) REFERENCES `nerd_permissions` (`id`) ON DELETE CASCADE;

ALTER TABLE `nerd_pages`
  ADD CONSTRAINT `nerd_pages-site_id-nerd_sites-id` FOREIGN KEY (`site_id`) REFERENCES `nerd_sites` (`id`) ON DELETE RESTRICT;

ALTER TABLE `nerd_posts`
  ADD CONSTRAINT `nerd_posts-site_id-nerd_sites-id` FOREIGN KEY (`site_id`) REFERENCES `nerd_sites` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `nerd_posts-user_id-nerd_users-id` FOREIGN KEY (`user_id`) REFERENCES `nerd_users` (`id`) ON DELETE RESTRICT;

ALTER TABLE `nerd_post_metadata`
  ADD CONSTRAINT `nerd_post_metadata-post_id-nerd_posts-id` FOREIGN KEY (`post_id`) REFERENCES `nerd_posts` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

-- No polymorphic comment abilities...

ALTER TABLE `nerd_comment_metadata`
  ADD CONSTRAINT `nerd_comment_metadata-comment_id-nerd_comments-id` FOREIGN KEY (`comment_id`) REFERENCES `nerd_comments` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;  

ALTER TABLE `nerd_page_keywords`
  ADD CONSTRAINT `nerd_page_keywords-keyword_id-nerd_keywords-id` FOREIGN KEY (`keyword_id`) REFERENCES `nerd_keywords` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nerd_page_keywords-page_id-nerd_pages-id` FOREIGN KEY (`page_id`) REFERENCES `nerd_pages` (`id`) ON DELETE CASCADE;

ALTER TABLE `nerd_regions`
  ADD CONSTRAINT `nerd_regions-page_id-nerd_pages-id` FOREIGN KEY (`page_id`) REFERENCES `nerd_pages` (`id`) ON DELETE CASCADE;

ALTER TABLE `nerd_snippets`
  ADD CONSTRAINT `nerd_snippets-page_id-nerd_pages-id` FOREIGN KEY (`page_id`) REFERENCES `nerd_pages` (`id`) ON DELETE CASCADE;

ALTER TABLE `nerd_components`
  ADD CONSTRAINT `nerd_components-page_id-nerd_pages-id` FOREIGN KEY (`page_id`) REFERENCES `nerd_pages` (`id`) ON DELETE CASCADE;

ALTER TABLE `nerd_site_keywords`
  ADD CONSTRAINT `nerd_site_keywords-keyword_id-nerd_keywords-id` FOREIGN KEY (`keyword_id`) REFERENCES `nerd_keywords` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nerd_site_keywords-site_id-nerd_sites-id` FOREIGN KEY (`site_id`) REFERENCES `nerd_sites` (`id`) ON DELETE CASCADE;

ALTER TABLE `nerd_site_users`
  ADD CONSTRAINT `nerd_site_users-user_id-nerd_users-id` FOREIGN KEY (`user_id`) REFERENCES `nerd_users` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `nerd_site_users-site_id-nerd_sites-id` FOREIGN KEY (`site_id`) REFERENCES `nerd_sites` (`id`) ON DELETE RESTRICT;

ALTER TABLE `nerd_cities`
  ADD CONSTRAINT `nerd_cities-state-nerd_states-code` FOREIGN KEY (`state`) REFERENCES `nerd_states` (`code`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `nerd_layouts`
  ADD CONSTRAINT `nerd_layouts-theme_id-nerd_themes-id` FOREIGN KEY (`theme_id`) REFERENCES `nerd_themes` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `nerd_user_metadata`
  ADD CONSTRAINT `nerd_user_metadata-user_id-nerd_users-id` FOREIGN KEY (`user_id`) REFERENCES `nerd_users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `nerd_site_metadata`
  ADD CONSTRAINT `nerd_site_metadata-site_id-nerd_sites-id` FOREIGN KEY (`site_id`) REFERENCES `nerd_sites` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;


-- ---------------------------------------------------------------------------------
-- Basic data
-- ---------------------------------------------------------------------------------

INSERT INTO `nerd_users` (`id`, `super`, `username`, `email`, `password`, `salt`, `temp_password`, `remember`, `activation_hash`, `ip`, `status`, `activated`, `updated_at`, `created_at`, `last_login`) VALUES
(1, 1, 'nerdsrescueme', 'nerdsrescueme@gmail.com', '64047e87ba25e091c420030e6a379899d68c0e6afbcd28248069ae7cadf24572', '38ec18c00bbd4dca25795f7518fbf613', NULL, NULL, NULL, '::1', 'active', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '0000-00-00 00:00:00'),
(2, 0, 'administrator', 'your@email.com', '64047e87ba25e091c420030e6a379899d68c0e6afbcd28248069ae7cadf24572', '38ec18c00bbd4dca25795f7518fbf613', NULL, NULL, NULL, '::1', 'active', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '0000-00-00 00:00:00'),
(3, 0, 'user', 'user@email.com', '64047e87ba25e091c420030e6a379899d68c0e6afbcd28248069ae7cadf24572', '38ec18c00bbd4dca25795f7518fbf613', NULL, NULL, NULL, '::1', 'active', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '0000-00-00 00:00:00');

UPDATE `nerd_user_metadata` SET `first_name` = 'Nerds', `last_name` = 'Rescue Me!', `zip` = 08097 WHERE `user_id` = 1;
UPDATE `nerd_user_metadata` SET `first_name` = 'Admin' WHERE `user_id` = 2;
UPDATE `nerd_user_metadata` SET `first_name` = 'Site', `last_name` = 'User' WHERE `user_id` = 3;

INSERT INTO `nerd_roles` (`id`, `name`, `description`) VALUES
(1, 'Superuser', 'Full access role'),
(2, 'Administrator', 'Website admin role'),
(3, 'User', 'Website user role'),
(4, 'Guest', 'Limited access role'),
(5, 'Banned', 'No access role');

INSERT INTO `nerd_permissions` (`id`, `name`, `description`) VALUES
(1, 'elavated.login', 'Allows user to perform an elevated login'),
(2, 'admin.login', 'Allows user to perform an admin login'),
(3, 'user.login', 'Allows user to perform a basic login'),
(4, 'site.read', 'Allows read access to site admin area'),
(5, 'site.create', 'Allows creation of sites'),
(6, 'site.update', 'Allows updating of sites'),
(7, 'site.delete', 'Allows deletion of sites');

INSERT INTO `nerd_users_roles` (`user_id`, `role_id`) VALUES
(1, 1), (2, 2), (3, 3);

INSERT INTO `nerd_roles_permissions` (`role_id`, `permission_id`) VALUES
(1, 1), (1, 2), (1, 3), (1, 4), (1, 5), (1, 6), (1, 7),
(2, 2), (2, 3), (2, 4),
(3, 3);

INSERT INTO `nerd_sites` (`id`, `host`, `theme`, `active`, `maintaining`, `description`) VALUES
(1, 'nerd.dev', 'default', 1, 0, 'Default site upon installation. This defaults to a locally hosted site.');


SET FOREIGN_KEY_CHECKS=1;
COMMIT;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;