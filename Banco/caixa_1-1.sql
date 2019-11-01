-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 01-Nov-2019 às 12:29
-- Versão do servidor: 10.4.6-MariaDB
-- versão do PHP: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `caixa`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `descricao`
--

CREATE TABLE `descricao` (
  `id` int(11) NOT NULL,
  `texto` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `descricao` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `data_registro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(1, 'Primeiro', 0, 'fechado', 1, '0.00');

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
(1, 'Root', 'root', '202cb962ac59075b964b07152d234b70');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `descricao`
--
ALTER TABLE `descricao`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `movimento`
--
ALTER TABLE `movimento`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `relatorio_mensal`
--
ALTER TABLE `relatorio_mensal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `anterior` (`anterior`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `descricao`
--
ALTER TABLE `descricao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `movimento`
--
ALTER TABLE `movimento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `relatorio_mensal`
--
ALTER TABLE `relatorio_mensal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para despejos de tabelas
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
