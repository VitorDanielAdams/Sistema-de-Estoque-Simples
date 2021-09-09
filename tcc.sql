-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 09-Set-2021 às 20:38
-- Versão do servidor: 10.4.20-MariaDB
-- versão do PHP: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `tcc`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecedor`
--

CREATE TABLE `fornecedor` (
  `id` int(11) NOT NULL,
  `nome` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cep` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone` int(11) NOT NULL,
  `cnpj` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `fornecedor`
--

INSERT INTO `fornecedor` (`id`, `nome`, `email`, `cep`, `telefone`, `cnpj`) VALUES
(1, 'teste', 'vitor.adams@outlook.com', '85853-600', 991317498, '11.111.111/0001-11');

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionarios`
--

CREATE TABLE `funcionarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cargo` int(11) NOT NULL,
  `turno` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `funcionarios`
--

INSERT INTO `funcionarios` (`id`, `nome`, `cargo`, `turno`, `telefone`) VALUES
(1, 'teste', 0, 'Manhã', 991317498),
(2, 'gerente', 1, 'Tarde', 991317498),
(3, 'funcionario', 2, 'Manhã', 991317498);

-- --------------------------------------------------------

--
-- Estrutura da tabela `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `user` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `login`
--

INSERT INTO `login` (`id`, `user`, `password`, `type`) VALUES
(1, 'admin', '25d55ad283aa400af464c76d713c07ad', 0),
(2, 'gerente', '25d55ad283aa400af464c76d713c07ad', 1),
(3, 'funcionario', '25d55ad283aa400af464c76d713c07ad', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `produto` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo` int(11) NOT NULL,
  `fornecedor` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoria` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantidade` int(11) NOT NULL,
  `valor` int(11) NOT NULL,
  `descricao` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datacad` date NOT NULL,
  `data` date NOT NULL,
  `entrada` int(11) NOT NULL,
  `saida` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id`, `produto`, `codigo`, `fornecedor`, `categoria`, `quantidade`, `valor`, `descricao`, `user`, `datacad`, `data`, `entrada`, `saida`) VALUES
(1, 'teste numero 1', 454641, 'teste', 'Laticínios/Frios', 50, 10, 'isso é um teste', 'admin', '2021-09-07', '2021-09-08', 50, 40);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
