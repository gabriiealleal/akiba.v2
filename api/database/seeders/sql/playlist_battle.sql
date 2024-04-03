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
-- Estrutura para tabela `playlist_battle`
--

DROP TABLE IF EXISTS `playlist_battle`;
CREATE TABLE IF NOT EXISTS `playlist_battle` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `playlist_battle`
--

INSERT INTO `playlist_battle` (`id`, `created_at`, `updated_at`, `image`) VALUES
(1, '2024-04-03 04:21:06', '2024-04-03 04:21:06', NULL),
(2, '2024-04-03 04:21:06', '2024-04-03 04:21:06', NULL),
(3, '2024-04-03 04:21:06', '2024-04-03 04:21:06', NULL),
(4, '2024-04-03 04:21:06', '2024-04-03 04:21:06', NULL),
(5, '2024-04-03 04:21:06', '2024-04-03 04:21:06', NULL),
(6, '2024-04-03 04:21:06', '2024-04-03 04:21:06', NULL),
(7, '2024-04-03 04:21:06', '2024-04-03 04:21:06', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
