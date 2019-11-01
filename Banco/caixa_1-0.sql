-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 03-Jul-2019 às 23:01
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
-- Database: `igreja`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `descricao`
--

CREATE TABLE `descricao` (
  `id` int(11) NOT NULL,
  `texto` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `descricao`
--

INSERT INTO `descricao` (`id`, `texto`) VALUES
(1, 'ContribuiÃ§Ã£o mensal');

-- --------------------------------------------------------

--
-- Estrutura da tabela `movimento`
--

CREATE TABLE `movimento` (
  `id` int(11) NOT NULL,
  `id_mes` int(11) DEFAULT NULL,
  `data` int(11) DEFAULT NULL,
  `valor` decimal(12,2) DEFAULT NULL,
  `operacao` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descricao` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `movimento`
--

INSERT INTO `movimento` (`id`, `id_mes`, `data`, `valor`, `operacao`, `descricao`) VALUES
(2, 1, 1, '250.00', 'entrada', 'teste'),
(3, 1, 1, '250.00', 'entrada', 'teste'),
(4, 1, 1, '250.00', 'entrada', 'teste'),
(5, 1, 1, '250.00', 'entrada', 'teste'),
(6, 1, 2, '15.00', 'entrada', 'teste'),
(7, 1, 2, '15.00', 'entrada', 'teste'),
(8, 1, 2, '15.00', 'entrada', 'teste'),
(9, 1, 3, '15.00', 'entrada', 'sadf'),
(10, 1, 3, '56.00', 'entrada', 'sdfg'),
(11, 1, 3, '400.00', 'saida', 'testeste'),
(12, 2, 1, '5000.00', 'entrada', 'mais um teste'),
(13, 1, 1, '2006.00', 'entrada', 'asdgsdfhs'),
(14, 1, 10, '2000.00', 'entrada', 'asdgsdfhs'),
(15, 2, 15, '0.00', 'saida', 'saida'),
(16, 6, 1, '10.00', 'entrada', 'teste'),
(17, 6, 3, '10.00', 'entrada', 'teste'),
(18, 6, 0, '10.50', 'entrada', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `relatorio_mensal`
--

CREATE TABLE `relatorio_mensal` (
  `id` int(11) NOT NULL,
  `mes` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ano` int(11) DEFAULT NULL,
  `status` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `anterior` int(11) NOT NULL,
  `saldofinal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `relatorio_mensal`
--

INSERT INTO `relatorio_mensal` (`id`, `mes`, `ano`, `status`, `anterior`, `saldofinal`) VALUES
(1, 'Primeiro', 0, 'lincado', 1, '11450.00'),
(2, 'Janeiro', 2010, 'fechadolincado', 1, '16450.00'),
(3, 'Fevereiro', 2019, 'fechadolincado', 2, '16450.00'),
(4, 'MarÃ§o', 2019, 'fechadolincado', 3, '16450.00'),
(5, 'Abril', 2019, 'lincado', 4, '16450.00'),
(6, 'Maio', 2019, 'aberto', 5, '0.00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usuario` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `senha` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `usuario`, `senha`) VALUES
(1, 'Daniel Castro', 'dcastro', '202cb962ac59075b964b07152d234b70'),
(2, 'Daniel', 'dcastro', '202cb962ac59075b964b07152d234b70');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `descricao`
--
ALTER TABLE `descricao`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movimento`
--
ALTER TABLE `movimento`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `relatorio_mensal`
--
ALTER TABLE `relatorio_mensal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `anterior` (`anterior`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `descricao`
--
ALTER TABLE `descricao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `movimento`
--
ALTER TABLE `movimento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `relatorio_mensal`
--
ALTER TABLE `relatorio_mensal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `relatorio_mensal`
--
ALTER TABLE `relatorio_mensal`
  ADD CONSTRAINT `relatorio_mensal_ibfk_1` FOREIGN KEY (`anterior`) REFERENCES `relatorio_mensal` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
