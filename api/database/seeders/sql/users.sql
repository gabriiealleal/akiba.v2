-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 03/04/2024 às 01:19
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
-- Estrutura para tabela `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `login` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_levels` json NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nickname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `age` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `biography` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `social_networks` json DEFAULT NULL,
  `likes` json DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_login_unique` (`login`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `created_at`, `updated_at`, `slug`, `is_active`, `login`, `password`, `access_levels`, `avatar`, `name`, `nickname`, `email`, `age`, `city`, `state`, `country`, `biography`, `social_networks`, `likes`) VALUES
(1, '2024-04-03 04:19:00', '2024-04-03 04:19:00', 'neko-kirame', 1, 'neko', '$2y$10$7VxrjWfXn60VZjcgukQj0esKxF/qhxVdcychyr24JsBEOy.E3Ywc6', '[\"administrador\"]', NULL, 'Ellyson Santos', 'Neko Kirame', NULL, NULL, 'Guarabira', 'Paraíba', 'Brasil', 'Sou essencialmente um Designer Gráfico, mas também edito vídeos. Minha empreitada pelo mundo dos animes começou com D.Gray-Man, Katekyo Hitman Reborn e Fairy Tail. Daí para frente, as coisas desandaram, e não é à toa que hoje sou um dos administradores desta rede. E não só isso, como também faço todas as artes daqui, gerencio as redes sociais e é isso, acho que só!', NULL, NULL),
(2, '2024-04-03 04:19:00', '2024-04-03 04:19:00', 'suzuh', 1, 'suzuh', '$2y$10$/0KERMTcM9I.LMi/NHbZneSNfYHNTuiorxgMNUlpgyhoRl.1WCmNy', '[\"administrador\"]', NULL, 'João Gabriel', 'Suzuh', NULL, NULL, 'Cabo Frio', 'Rio de Janeiro', 'Brasil', 'Sou um desenvolvedor em desenvolvimento e um amante de animes e doramas. Meu primeiro anime foi Mirai Nikki e desde então estou sempre nesse mundo. Atualmente sou e responsável pelo desenvolvimento e manutenção do site.', NULL, NULL),
(3, '2024-04-03 04:19:00', '2024-04-03 04:19:00', 'takashi', 1, 'takashi', '$2y$10$2hY8aa2Q4rTsXWJyx1miiO/HTCjZK0B5J0yt5dHypS9Ky8wGaZflu', '[\"administrador\"]', NULL, 'Antônio Medeiros Lopes', 'Takashi', NULL, NULL, 'Pelotas', 'Rio Grande do Sul', 'Brasil', 'Minha jornada no mundo otaku começou há menos tempo do que a maioria das pessoas de hoje, foi pesquisando sobre séries de zumbis que me deparei com High School of the Dead e hoje sou o que sou e não tenho intenções de mudar.', NULL, NULL),
(4, '2024-04-03 04:19:00', '2024-04-03 04:19:00', 'nhk', 1, 'nhk', '$2y$10$y6Fd7e6viyRjBlAnZvECQ.i6IGXb/x43UJWZOgRQxZYRNduPLNiDu', '[\"redator\"]', NULL, 'Eduardo Borges', 'NHK', NULL, NULL, 'Itaguaí', 'Rio de Janeiro', 'Brasil', 'Olá Jovem! Como vai? Eu sou o NHK, e posso dizer que hoje sou um grande senpai dos animes. Mas cara, como é bom assistir um animezinho com um suco de laranja geladinho! Ah, de fato, isso é muito bom! Se for assistir, é só me convidar. Vai um café também?.', NULL, NULL),
(5, '2024-04-03 04:19:00', '2024-04-03 04:19:00', 'jojo', 1, 'jojo', '$2y$10$ca/0cFYuMoMi6W1Ie5uYcOviIhgD2BpB1dbNUuSvtMe9OluPtmpFy', '[\"locutor\"]', NULL, 'Jordanna Maria', 'Jojo', NULL, NULL, 'Goiás', 'Goiás', 'Brasil', 'Apaixonada pela cultura asiática desde sempre! Amo animes (ação, comédia, yuri, yaoi, ecchi, enfim... Se eu curtir, não importa o gênero!), coisas fofinhas, filmes de terror (Amo assassinatos! Sangue, sangue, sangue! XD), enfim, \"meus gostos são peculiares, você não me entenderia\" kkkk! Sou uma pessoa muito tímida, por incrível que pareça! Gosto de ficar em casa, jogar vídeo game, desenhar, assistir animes e doramas, e ler meus mangás/light novels! ^^.', NULL, NULL),
(6, '2024-04-03 04:19:00', '2024-04-03 04:19:00', 'luh', 1, 'luh', '$2y$10$PfV7rrMNp4VWQgUFL/OTRefLoxQtcqJCvcd8w.k1RuOZog0OK317a', '[\"locutor\", \"redator\"]', NULL, 'Luiz Fernando', 'Luh', NULL, NULL, 'Minas Gerais', 'Minas Gerais', 'Brasil', '(L)indo por natureza</br>(U)ma fonte de beleza</br>(I)Inteligente, só que não</br>(Z)Zoeiro e sem noção', NULL, NULL),
(7, '2024-04-03 04:19:00', '2024-04-03 04:19:00', 'mizaki', 1, 'mizaki', '$2y$10$zcL6Qh28UX3qMFCcG2IgyOxnzoESAhHKrOuelnj7sfODTyPT7PZHu', '[\"locutor\", \"redator\"]', NULL, 'Leonora', 'Mizaki', NULL, NULL, 'Capoeiras', 'Pernambuco', 'Brasil', 'Gosto muito de contar histórias (especialmente mitologia e lendas urbanas). Sou do tipo que adora compartilhar meus gostos e saber o que os outros têm a me dizer', NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
