-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 15-Maio-2020 às 16:21
-- Versão do servidor: 10.1.36-MariaDB
-- versão do PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cursos_livres`
--
CREATE DATABASE IF NOT EXISTS `cursos_livres` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `cursos_livres`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `aulas`
--

DROP TABLE IF EXISTS `aulas`;
CREATE TABLE `aulas` (
  `id` int(11) NOT NULL,
  `id_secao` int(11) NOT NULL,
  `titulo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `aulas`
--

INSERT INTO `aulas` (`id`, `id_secao`, `titulo`, `descricao`, `status`) VALUES
(2, 3, 'Compactadores', 'Conhecendo como funciona os compactadores e empacotadores do Linux.', 1),
(3, 3, 'Gerenciador de Pacotes', 'Para que serve e como usar o Gerenciador de Pacotes do Linux (APT)?', 1),
(4, 3, 'Interface Gráfica', 'Como instalar uma interface gráfica no seu Linux.', 1),
(5, 4, 'Processos', 'O que é um processo? Aprenda mais sobre como funciona o processamento de dados.', 1),
(6, 10, 'ECMA Script 2016', 'Intrudução ao ECMAScript.', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cursos`
--

DROP TABLE IF EXISTS `cursos`;
CREATE TABLE `cursos` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `img` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_professor` int(11) NOT NULL,
  `status` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `cursos`
--

INSERT INTO `cursos` (`id`, `nome`, `descricao`, `img`, `id_professor`, `status`) VALUES
(1, 'Debian', 'Debian anteriormente chamado de Debian GNU/Linux e hoje apenas de Debian, é um sistema operacional composto inteiramente de software livre. É mantido oficialmente pelo Projeto Debian. O projeto recebe ainda apoio de outros indivíduos e organizações em todo mundo.', '1', 1, 1),
(2, 'HTML 5', 'HTML5 é uma linguagem de marcação para a World Wide Web e é uma tecnologia chave da Internet, originalmente proposto por Opera Software. É a quinta versão da linguagem HTML.', '2', 2, 1),
(3, 'CSS 3', 'CSS3 é a segunda mais nova versão das famosas Cascading Style Sheets, onde se define estilos para páginas web com efeitos de transição, imagem, e outros, que dão um estilo novo às páginas Web 2.0 em todos os aspectos de design do layout.', '3', 2, 1),
(4, 'JavaScript', 'JavaScript é uma linguagem de programação baseada em scripts e padronizada pela ECMA International (associação especializada na padronização de sistemas de informação). Foi criada por Brendan Eich (Netscape) e surgiu em 1995 como linguagem de script client-side de páginas web.', '4', 2, 1),
(5, 'NodeJS', 'Node.js é um interpretador de código JavaScript com o código aberto, focado em migrar o Javascript do lado do cliente para servidores.', '5', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `secoes`
--

DROP TABLE IF EXISTS `secoes`;
CREATE TABLE `secoes` (
  `id` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `secoes`
--

INSERT INTO `secoes` (`id`, `id_curso`, `nome`, `status`) VALUES
(3, 1, 'Básico', 1),
(4, 1, 'Avançado', 1),
(5, 2, 'HTML Básico', 1),
(9, 4, 'Avançado', 1),
(10, 4, 'Básico', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `sobrenome` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `cel` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tel` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipo` int(11) NOT NULL DEFAULT '1',
  `lastime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `sobrenome`, `email`, `senha`, `cel`, `tel`, `tipo`, `lastime`) VALUES
(1, 'Henrique', 'Bustillos', 'contato@rickybustillos.com.br', '21232f297a57a5a743894a0e4a801fc3', '(11) 94500-0100', '', 3, '2020-10-05 20:23:31'),
(2, 'Elisabete', 'da Silva Santos', 'elisabete.santos@fatec.sp.gov.br', '21232f297a57a5a743894a0e4a801fc3', '', '', 2, '2020-10-05 20:38:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aulas`
--
ALTER TABLE `aulas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `secoes`
--
ALTER TABLE `secoes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aulas`
--
ALTER TABLE `aulas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `secoes`
--
ALTER TABLE `secoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
