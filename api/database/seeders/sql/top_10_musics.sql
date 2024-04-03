-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 03/04/2024 às 01:22
-- Versão do servidor: 8.2.0
-- Versão do PHP: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `akiba`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `top_10_musics`
--

DROP TABLE IF EXISTS `top_10_musics`;
CREATE TABLE IF NOT EXISTS `top_10_musics` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `number_of_requests` int DEFAULT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `anime` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `top_10_musics`
--

INSERT INTO `top_10_musics` (`id`, `created_at`, `updated_at`, `number_of_requests`, `avatar`, `name`, `anime`) VALUES
(1, '2024-04-03 04:21:06', '2024-04-03 04:21:06', NULL, NULL, NULL, NULL),
(2, '2024-04-03 04:21:06', '2024-04-03 04:21:06', NULL, NULL, NULL, NULL),
(3, '2024-04-03 04:21:06', '2024-04-03 04:21:06', NULL, NULL, NULL, NULL),
(4, '2024-04-03 04:21:06', '2024-04-03 04:21:06', NULL, NULL, NULL, NULL),
(5, '2024-04-03 04:21:06', '2024-04-03 04:21:06', NULL, NULL, NULL, NULL),
(6, '2024-04-03 04:21:06', '2024-04-03 04:21:06', NULL, NULL, NULL, NULL),
(7, '2024-04-03 04:21:06', '2024-04-03 04:21:06', NULL, NULL, NULL, NULL),
(8, '2024-04-03 04:21:06', '2024-04-03 04:21:06', NULL, NULL, NULL, NULL),
(9, '2024-04-03 04:21:06', '2024-04-03 04:21:06', NULL, NULL, NULL, NULL),
(10, '2024-04-03 04:21:06', '2024-04-03 04:21:06', NULL, NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
