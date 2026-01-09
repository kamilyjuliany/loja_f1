-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27/06/2025 às 23:34
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `loja_f1`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `carrinho`
--

CREATE TABLE `carrinho` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `produto_id` int(11) DEFAULT NULL,
  `nome_produto` varchar(100) DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`id`, `nome`, `cpf`, `email`, `senha`) VALUES
(1, 'Juninho', '12345678910', 'teste@gmail.com', '$2y$10$IWRq0ATqeb8f/MOx7NckQ.RcSmcuz3V1r/4NX8wT5Oqu5HzdrDWnG'),
(2, 'Sara Santos', '45632413526', 'sara@gmail.com', '$2y$10$AG.p.kJCAIcA8BI/F6gFOuVZtPu1EiAO5PRtpsyFqhMY37k8HbKzm'),
(3, 'Juliany', '05614636110', 'juliany@gmail.com', '1234'),
(4, 'juliany', '05614636110', 'juliany@gmail.com', '1234');

-- --------------------------------------------------------

--
-- Estrutura para tabela `compras`
--

CREATE TABLE `compras` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `nome_produto` varchar(100) DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL,
  `data_compra` datetime DEFAULT current_timestamp(),
  `quantidade` int(11) NOT NULL DEFAULT 1,
  `forma_pagamento` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `compras`
--

INSERT INTO `compras` (`id`, `id_cliente`, `nome_produto`, `preco`, `data_compra`, `quantidade`, `forma_pagamento`) VALUES
(1, 3, 'Camiseta Visa Cash', 359.90, '2025-06-23 16:05:45', 2, 'Pix'),
(2, 3, 'Camiseta Stake', 299.90, '2025-06-23 16:05:45', 1, 'Pix'),
(3, 3, 'Camiseta Stake', 299.90, '2025-06-23 17:01:46', 3, 'Pix'),
(4, 3, 'Camiseta Haas', 315.00, '2025-06-23 17:01:46', 1, 'Pix'),
(5, 3, 'Camiseta Stake', 299.90, '2025-06-23 17:03:29', 1, 'Boleto'),
(6, 3, 'Camiseta Visa Cash', 359.90, '2025-06-23 17:03:48', 1, 'Pix'),
(7, 3, 'Camiseta Mercedes', 359.90, '2025-06-23 17:04:22', 1, 'Pix'),
(8, 3, 'Camiseta Visa Cash', 359.90, '2025-06-23 17:12:33', 1, 'Pix'),
(9, NULL, 'Camiseta Stake', 299.90, '2025-06-27 17:56:52', 1, 'Pix'),
(10, NULL, 'Camiseta Haas', 315.00, '2025-06-27 17:56:52', 1, 'Pix'),
(11, NULL, 'Camiseta Stake', 299.90, '2025-06-27 17:56:58', 1, 'Boleto'),
(12, NULL, 'Camiseta Haas', 315.00, '2025-06-27 17:56:58', 1, 'Boleto'),
(13, NULL, 'Camiseta Stake', 299.90, '2025-06-27 17:57:00', 1, 'Pix'),
(14, NULL, 'Camiseta Haas', 315.00, '2025-06-27 17:57:00', 1, 'Pix'),
(15, NULL, 'Camiseta Stake', 299.90, '2025-06-27 22:09:22', 1, 'Pix'),
(16, NULL, 'Camiseta Haas', 315.00, '2025-06-27 22:09:22', 1, 'Pix'),
(17, NULL, 'Camiseta Stake', 299.90, '2025-06-27 22:19:46', 1, 'Pix'),
(18, NULL, 'Camiseta Haas', 315.00, '2025-06-27 22:19:46', 1, 'Pix'),
(19, NULL, 'Camiseta Aston Martin', 389.90, '2025-06-27 22:42:17', 1, 'Pix'),
(20, NULL, 'Camiseta Alpine', 359.90, '2025-06-27 22:42:17', 1, 'Pix'),
(21, NULL, 'Camiseta Ferrari', 300.00, '2025-06-27 22:42:17', 1, 'Pix'),
(22, NULL, 'Camiseta Mclaren', 389.99, '2025-06-27 22:42:44', 1, 'Boleto'),
(23, NULL, 'Camiseta Aston Martin', 389.90, '2025-06-27 23:07:54', 1, 'Pix'),
(24, NULL, 'Camiseta Aston Martin', 389.90, '2025-06-27 23:28:16', 2, 'Pix'),
(25, NULL, 'Camiseta Mercedes', 359.90, '2025-06-27 23:28:31', 1, 'Boleto');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `tamanho` varchar(10) DEFAULT NULL,
  `equipe` varchar(50) DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `valor`, `tamanho`, `equipe`, `imagem`) VALUES
(3, 'Camiseta RedBull', 450.00, 'G', 'RedBull', 'rb.jpeg'),
(4, 'Camiseta Ferrari', 300.00, 'M', 'Ferrari', 'ferrari.jpg'),
(5, 'Camiseta Mclaren', 389.99, 'P', 'McLaren', 'mclaren.jpeg'),
(6, 'Camiseta Mercedes', 359.90, 'M', 'Mercedes', 'mercedes.jpg'),
(7, 'Camiseta Williams', 299.90, 'G', 'Williams', 'williams.jpeg'),
(8, 'Camiseta Haas', 315.00, 'GG', 'Haas', 'haas.jpeg'),
(9, 'Camiseta Stake', 299.90, 'M', 'Stake', 'stake.png'),
(10, 'Camiseta Visa Cash', 359.90, 'G', 'Visa Cash', 'visacash.png'),
(11, 'Camiseta Aston Martin', 389.90, 'P', 'Aston Martin', 'aston-martin.png'),
(12, 'Camiseta Alpine', 359.90, 'M', 'Alpine', 'alpine.png');

-- --------------------------------------------------------

--
-- Estrutura para tabela `vendedores`
--

CREATE TABLE `vendedores` (
  `id` int(11) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `vendedores`
--

INSERT INTO `vendedores` (`id`, `cpf`, `senha`) VALUES
(1, '05614636110', '1234');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `carrinho`
--
ALTER TABLE `carrinho`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `vendedores`
--
ALTER TABLE `vendedores`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `carrinho`
--
ALTER TABLE `carrinho`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `vendedores`
--
ALTER TABLE `vendedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
