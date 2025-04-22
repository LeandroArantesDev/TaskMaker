-- XAMPP-Lite
-- version 8.4.4
-- https://xampplite.sf.net/
--
-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 22/04/2025 às 15:57
-- Versão do servidor: 11.4.5-MariaDB-log
-- Versão do PHP: 8.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `taskmaker`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `grupos`
--

CREATE TABLE `grupos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tarefas`
--

CREATE TABLE `tarefas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `data_criacao` timestamp NULL DEFAULT current_timestamp(),
  `data_conclusao` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `usuario_id` int(11) NOT NULL,
  `grupo_id` int(11) DEFAULT NULL
) ;

--
-- Despejando dados para a tabela `tarefas`
--

INSERT INTO `tarefas` (`id`, `titulo`, `descricao`, `data_criacao`, `data_conclusao`, `status`, `usuario_id`, `grupo_id`) VALUES
(1, 'Estudar por 1 hora', 'Preciso estudar para a prova de portugues', '2025-04-22 13:21:05', NULL, 1, 2, NULL),
(2, 'Preciso ir no mercado hoje', 'comprar:3 maionese2 ketchup5 pães1 kg de salsicha', '2025-04-22 13:22:43', NULL, 2, 2, NULL),
(4, 'Ir na academia', 'malhar perna', '2025-04-22 15:50:03', NULL, 1, 2, NULL),
(5, 'Mexer no site por 1 hora', 'está pronto o CRUD das tarefas', '2025-04-22 15:52:12', NULL, 3, 2, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `grupo_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `email_confirmado` tinyint(1) DEFAULT 0,
  `codigo_confirmacao` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `grupo_id`, `status`, `email_confirmado`, `codigo_confirmacao`) VALUES
(1, 'Admin', 'adm@adm.com', '123', NULL, 1, 0, NULL),
(2, 'Leandro', 'leandro.arantes0610@gmail.com', '$2y$12$hzsz.8UWqUHXf53v/t/msuxIbvznf/C4g//e12JiZSjzuKrkXW0dq', NULL, 1, 1, NULL),
(5, 'Giulia Batista Miguel Isola', 'giulia@gmail.com', '$2y$12$zO6UN5c8jHpv/xuDQVsacu..q0J.Aj6t6exvV.1Al18tDg76RfAmq', NULL, 1, 0, NULL),
(6, 'Walysson Ribeiro Rosa', 'walysson@gmail.com', '$2y$12$516UmglQfdYkWbjpIC1y/O1wQjbyVy6Ltji5AZ39NoMeQebvvHh9S', NULL, 1, 0, '$2y$12$g8ki9RQyAdOUq1tobJDEQe/8VGnuf/.YV9Q/aT8Oj5FdUse2aNG8u');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_grupos_usuario` (`usuario_id`);

--
-- Índices de tabela `tarefas`
--
ALTER TABLE `tarefas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tarefas_usuario` (`usuario_id`),
  ADD KEY `fk_tarefas_grupo` (`grupo_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_usuarios_grupo` (`grupo_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tarefas`
--
ALTER TABLE `tarefas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `grupos`
--
ALTER TABLE `grupos`
  ADD CONSTRAINT `fk_grupos_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tarefas`
--
ALTER TABLE `tarefas`
  ADD CONSTRAINT `fk_tarefas_grupo` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_tarefas_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_grupo` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
