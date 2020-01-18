-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 18-Jan-2020 às 22:45
-- Versão do servidor: 5.7.28-cll-lve
-- versão do PHP: 7.2.26

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
  `data_registro` datetime DEFAULT CURRENT_TIMESTAMP
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
(3, 'Victor Xavier', 'victor', '5405e59c116660e8fd93d6d2da21aea4'),
(4, 'Anesi', 'danesi', 'b7af6315a02ddd6c0b52511522db6d79'),
(5, 'Lucas Lima', 'lima', 'e15ebeb7184ea5fa5307133f8679ca89'),
(6, 'Daniel Castro', 'dcastro', '3c2031ac53dea3dacb733041d55e322d');

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `movimento`
--
ALTER TABLE `movimento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `relatorio_mensal`
--
ALTER TABLE `relatorio_mensal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
