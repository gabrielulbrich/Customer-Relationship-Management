-- Adminer 4.7.7 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `apis`;
CREATE TABLE `apis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `api` varchar(255) NOT NULL,
  `fields` json NOT NULL,
  `page_id` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  CONSTRAINT `apis_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `apis` (`id`, `api`, `fields`, `page_id`, `weight`, `updated_at`, `created_at`) VALUES
(8,	'static-page',	'[{\"name\": \"nome\", \"type\": {\"code\": \"string\", \"name\": \"Texto\"}, \"description\": \"\"}, {\"name\": \"email\", \"type\": {\"code\": \"string\", \"name\": \"Texto\"}, \"description\": \"\"}, {\"name\": \"telefone\", \"type\": {\"code\": \"string\", \"name\": \"Texto\"}, \"description\": \"\"}, {\"name\": \"mensagem\", \"type\": {\"code\": \"string\", \"name\": \"Texto\"}, \"description\": \"\"}, {\"name\": \"aceito_wpp\", \"type\": {\"code\": \"boolean\", \"name\": \"Checkbox\"}, \"description\": \"\"}, {\"name\": \"aceito_email\", \"type\": {\"code\": \"boolean\", \"name\": \"Checkbox\"}, \"description\": \"\"}, {\"name\": \"termo\", \"type\": {\"code\": \"boolean\", \"name\": \"Checkbox\"}, \"description\": \"\"}]',	1,	1,	'2021-06-04 19:45:16',	'2021-06-04 19:43:52');

DROP TABLE IF EXISTS `brands`;
CREATE TABLE `brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `comment` longtext NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `keywords`;
CREATE TABLE `keywords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `leads`;
CREATE TABLE `leads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `priority_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `api_id` int(11) DEFAULT NULL,
  `data` json DEFAULT NULL,
  `origem` varchar(45) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_LEADS_PAGINA1_idx` (`page_id`),
  KEY `fk_LEAD_STATUS1_idx` (`status_id`),
  KEY `fk_leads_users1_idx` (`user_id`),
  KEY `fk_leads_priorities1_idx` (`priority_id`),
  KEY `api_id` (`api_id`),
  CONSTRAINT `fk_LEADS_PAGINA1` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_LEAD_STATUS1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_leads_priorities1` FOREIGN KEY (`priority_id`) REFERENCES `priorities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_leads_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `leads_ibfk_1` FOREIGN KEY (`api_id`) REFERENCES `apis` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `leads_comments`;
CREATE TABLE `leads_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lead_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lead_id` (`lead_id`),
  KEY `comment_id` (`comment_id`),
  CONSTRAINT `leads_comments_ibfk_2` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`),
  CONSTRAINT `leads_comments_ibfk_3` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `models`;
CREATE TABLE `models` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_id` int(11) NOT NULL,
  `model` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_MODELO_FABRICANTE1_idx` (`brand_id`),
  CONSTRAINT `fk_MODELO_FABRICANTE1` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `site` varchar(45) DEFAULT NULL,
  `epic` varchar(45) DEFAULT NULL,
  `token` varchar(45) NOT NULL,
  `refer` varchar(45) DEFAULT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `site_UNIQUE` (`site`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `pages` (`id`, `name`, `site`, `epic`, `token`, `refer`, `logo_url`, `created_at`, `updated_at`) VALUES
(1,	'Gabriel Ulbrich',	'gabrielulbrich.com.br',	'gabrielulbrich',	'token123',	'gabrielulbrich.com.br',	NULL,	NULL,	NULL);

DROP TABLE IF EXISTS `priorities`;
CREATE TABLE `priorities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `priority` varchar(45) DEFAULT NULL,
  `icon_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `priorities` (`id`, `priority`, `icon_url`) VALUES
(1,	'Baixa',	'https://jira.uhub.biz/images/icons/priorities/low.svg'),
(2,	'Media',	'https://jira.uhub.biz/images/icons/priorities/medium.svg'),
(3,	'Alta',	'https://jira.uhub.biz/images/icons/priorities/high.svg'),
(4,	'Muito Alta',	'https://jira.uhub.biz/images/icons/priorities/highest.svg');

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `preco` decimal(3,2) DEFAULT NULL,
  `ano` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_PRODUTO_PAGINA1_idx` (`page_id`),
  KEY `fk_PRODUTO_MODELO1_idx` (`model_id`),
  CONSTRAINT `fk_PRODUTO_MODELO1` FOREIGN KEY (`model_id`) REFERENCES `models` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_PRODUTO_PAGINA1` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `products_shops`;
CREATE TABLE `products_shops` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`product_id`,`shop_id`),
  KEY `fk_PRODUTO_LOJA_PRODUTO1_idx` (`product_id`),
  KEY `fk_PRODUTO_LOJA_LOJA1_idx` (`shop_id`),
  CONSTRAINT `fk_PRODUTO_LOJA_LOJA1` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_PRODUTO_LOJA_PRODUTO1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `profiles`;
CREATE TABLE `profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profile` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `profiles` (`id`, `profile`) VALUES
(1,	'Administrador'),
(2,	'Usuário'),
(3,	'Em Aprovação'),
(4,	'Inativo'),
(5,	'Master');

DROP TABLE IF EXISTS `shops`;
CREATE TABLE `shops` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `uf` varchar(45) NOT NULL,
  `cidade` varchar(45) NOT NULL,
  `rua` varchar(45) NOT NULL,
  `numero` varchar(45) NOT NULL,
  `cep` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `status`;
CREATE TABLE `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `status` (`id`, `status`) VALUES
(1,	'Aberto'),
(2,	'Em Progresso'),
(3,	'Bloqueado'),
(4,	'Finalizado');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `cpf` varchar(45) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `avatar_url` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `CPF_UNIQUE` (`cpf`),
  UNIQUE KEY `EMAIL_UNIQUE` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `name`, `email`, `cpf`, `password`, `avatar_url`, `updated_at`, `created_at`) VALUES
(1,	'Ninguém',	'unasigned@example.com',	'000.000.000-00',	'$2y$10$uY.5YNishjGsTKyONvHKA.4aXGN.r.ctFK0iL3mCqpSBH4oG0l0bW',	'/assets/user_icons/avatar-default.png',	'2020-10-07 01:38:12',	'2020-10-28 01:38:12'),
(2,	'Gabriel',	'gabriel.u10@hotmail.com',	'10396460933',	'$2y$10$hQut50gdBA.4pgSUS3WKou5Y/kDCjiIDIJkRDMKQRl27/RRtmXb.m',	'/assets/user_icons/boy.png',	'2021-06-06 02:28:40',	'2020-10-04 19:56:05'),
(35,	NULL,	NULL,	NULL,	'$2y$10$nLn0SEJhSwoJk4jAcj4YaOu4axMs5XGICu2S.StpdtsNCdDXx0ndS',	'/assets/user_icons/user.png',	'2021-06-05 16:13:51',	'2021-06-05 16:13:51'),
(36,	NULL,	NULL,	NULL,	'$2y$10$E3IFkgkUrC2WxBvH5NPE3uOIssDIhQqarqQ.YBydYmOd6sBgGRJB6',	'/assets/user_icons/user.png',	'2021-06-05 16:14:24',	'2021-06-05 16:14:24'),
(37,	NULL,	NULL,	NULL,	'$2y$10$D2VXb9Yp7O9HQ0EEgklvD.sMMlvbY3mGhFH5bgjTLZ5AjBUBMCVqa',	'/assets/user_icons/user.png',	'2021-06-05 16:15:40',	'2021-06-05 16:15:40'),
(38,	NULL,	NULL,	NULL,	'$2y$10$loGPtrzLiCWMxFh1/6Yb8Oo2WP49ADPNaVwnaVh3B1EEls7oNdXZ6',	'/assets/user_icons/user.png',	'2021-06-05 16:16:54',	'2021-06-05 16:16:54'),
(39,	NULL,	NULL,	NULL,	'$2y$10$fg/cNE7qrODUyfjvnGCpjeqv5M5GPWx27O6JEtVjKr3H8vw6V29LG',	'/assets/user_icons/user.png',	'2021-06-05 16:51:17',	'2021-06-05 16:51:17'),
(40,	NULL,	NULL,	NULL,	'$2y$10$AM7KguWUR3qK/JlYQKwOSOdMRPryHTUarPX3EdTa.OxFhp5HFn5su',	'/assets/user_icons/user.png',	'2021-06-05 16:51:44',	'2021-06-05 16:51:44'),
(41,	NULL,	NULL,	NULL,	'$2y$10$w/F4G9cAVekx16BZNArkk.oCK3GX.pjjuWeL30u2QJ6/YO0Qr0Axi',	'/assets/user_icons/user.png',	'2021-06-05 16:52:38',	'2021-06-05 16:52:38'),
(42,	NULL,	NULL,	NULL,	'$2y$10$Z3gJ.KkOeKZHv/6A73UOkuUX60QNcOuJGAhoy/8yo2SBiIuU48OC2',	'/assets/user_icons/user.png',	'2021-06-05 16:53:34',	'2021-06-05 16:53:34'),
(43,	NULL,	NULL,	NULL,	'$2y$10$4E.bQyvo0wXLtNwMDw7oieg7OAY7/5gU0WTLh5YUSvPgSUXVBYSP.',	'/assets/user_icons/user.png',	'2021-06-05 17:26:36',	'2021-06-05 17:26:36'),
(44,	NULL,	NULL,	NULL,	'$2y$10$BAazuDNu2qSkKNVJnCIlKuu94PZtBK0F2feac1e9LRQxwU22RCFfG',	'/assets/user_icons/user.png',	'2021-06-05 22:45:28',	'2021-06-05 22:45:28');

DROP TABLE IF EXISTS `users_pages`;
CREATE TABLE `users_pages` (
  `user_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`page_id`),
  KEY `fk_USUARIO_PAGINA_USUARIO1_idx` (`user_id`),
  KEY `fk_USUARIO_PAGINA_PAGINA1_idx` (`page_id`),
  KEY `fk_users_pages_profiles1_idx` (`profile_id`),
  CONSTRAINT `fk_USUARIO_PAGINA_PAGINA1` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_USUARIO_PAGINA_USUARIO1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_pages_profiles1` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users_pages` (`user_id`, `page_id`, `profile_id`) VALUES
(2,	1,	1);

-- 2021-06-06 02:31:21
