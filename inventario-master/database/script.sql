-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 10.32.128.14
-- Tempo de geração: 01/09/2020 às 20:52
-- Versão do servidor: 10.3.22-MariaDB-0+deb10u1
-- Versão do PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `inventario`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `equipments`
--

CREATE TABLE `equipments` (
  `id` int(11) NOT NULL,
  `tombo` int(11) NOT NULL,
  `specifications` varchar(250) NOT NULL,
  `obs` varchar(250) DEFAULT NULL,
  `types_equip_id` int(11) NOT NULL,
  `manufacturer_id` int(11) NOT NULL,
  `situation_id` int(11) NOT NULL,
  `warranty` date DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `equipments`
--

INSERT INTO `equipments` (`id`, `tombo`, `specifications`, `obs`, `types_equip_id`, `manufacturer_id`, `situation_id`, `created_by`, `created_at`, `updated_at`, `updated_by`) VALUES
(1, 801, 'notebook 01', '', 1, 1, 1, 1, '2020-08-31 13:46:55', NULL, NULL),
(2, 802, 'nobreak 01', '', 7, 5, 1, 1, '2020-08-31 13:47:40', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `transfers`
--

CREATE TABLE `transfers` (
  `id` int(11) NOT NULL,
  `equipment_id` int(11) NOT NULL,
  `responsible_user` varchar(50) NOT NULL,
  `sector_id` int(11) NOT NULL,
  `transfer_date` date NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `transfers`
--

INSERT INTO `transfers` (`id`, `equipment_id`, `responsible_user`, `sector_id`, `transfer_date`, `created_by`, `created_at`, `updated_at`, `updated_by`) VALUES
(1, 1, 'Carlos andré', 4, '2020-08-31', 1, '2020-08-31 13:48:09', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `transfer_historys`
--

CREATE TABLE `transfer_historys` (
  `id` int(11) NOT NULL,
  `equipment_id` int(11) NOT NULL,
  `responsible_user` varchar(50) NOT NULL,
  `sector_id` int(11) NOT NULL,
  `transfer_date` date NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `manufacturers`
--

CREATE TABLE `manufacturers` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `manufacturers`
--

INSERT INTO `manufacturers` (`id`, `name`) VALUES
(5, 'Cisco'),
(1, 'DELL'),
(3, 'HP'),
(2, 'Lenovo'),
(4, 'RICOH');

-- --------------------------------------------------------

--
-- Estrutura para tabela `sectors`
--

CREATE TABLE `sectors` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `sectors`
--

INSERT INTO `sectors` (`id`, `name`) VALUES
(4, 'LOGÍSTICA'),
(3, 'RH'),
(2, 'MARKET'),
(1, 'INFORMÁTICA');

-- --------------------------------------------------------

--
-- Estrutura para tabela `situations`
--

CREATE TABLE `situations` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `situations`
--

INSERT INTO `situations` (`id`, `name`) VALUES
(4, 'Inservível'),
(3, 'Furtado'),
(2, 'Parado'),
(1, 'Operacional');

-- --------------------------------------------------------

--
-- Estrutura para tabela `types_equips`
--

CREATE TABLE `types_equips` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `types_equips`
--

INSERT INTO `types_equips` (`id`, `name`) VALUES
(14, 'Access Point'),
(11, 'All in One'),
(2, 'Computador PC'),
(6, 'Estabilizador'),
(10, 'Gravador externo de CD/DVD'),
(9, 'Hub'),
(3, 'Impressora'),
(12, 'Monitor'),
(7, 'Nobreak'),
(1, 'Notebook'),
(4, 'Scanner'),
(13, 'Servidor'),
(5, 'Smartphone'),
(8, 'Switch');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(60) CHARACTER SET utf8 NOT NULL,
  `username` varchar(50) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `user_level` int(11) NOT NULL,
  `image` varchar(255) DEFAULT 'no_image.jpg',
  `status` int(1) NOT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `user_level`, `image`, `status`, `last_login`) VALUES
(1, 'Administrador', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 'no_image.jpg', 1, '2020-09-01 15:51:28'),
(2, 'Usuário Operacional', 'user', '12dea96fec20593566ab75692c9949596833adc9', 2, 'no_image.jpg', 1, '2020-08-14 16:42:28');

-- --------------------------------------------------------

--
-- Estrutura para tabela `user_groups`
--

CREATE TABLE `user_groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(150) CHARACTER SET utf8 NOT NULL,
  `group_level` int(11) NOT NULL,
  `group_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `user_groups`
--

INSERT INTO `user_groups` (`id`, `group_name`, `group_level`, `group_status`) VALUES
(1, 'Administrador', 1, 1),
(2, 'Operacional', 2, 1);

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `equipments`
--
ALTER TABLE `equipments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_tombo` (`tombo`),
  ADD KEY `fk_equipments_manufacturer` (`manufacturer_id`),
  ADD KEY `fk_equipments_types_equip` (`types_equip_id`),
  ADD KEY `fk_equipments_situation` (`situation_id`),
  ADD KEY `fk_equipments_created_user` (`created_by`),
  ADD KEY `fk_equipments_updated_user` (`updated_by`);

--
-- Índices de tabela `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_transfer_equipment` (`equipment_id`),
  ADD KEY `fk_transfer_sector` (`sector_id`),
  ADD KEY `fk_transfer_created_user` (`created_by`),
  ADD KEY `fk_transfer_updated_user` (`updated_by`);

--
-- Índices de tabela `transfer_historys`
--
ALTER TABLE `transfer_historys`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_transfer_historys_equipment` (`equipment_id`),
  ADD KEY `fk_transfer_historys_created_user` (`created_by`),
  ADD KEY `fk_transfer_historys_sector` (`sector_id`);

--
-- Índices de tabela `manufacturers`
--
ALTER TABLE `manufacturers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Índices de tabela `sectors`
--
ALTER TABLE `sectors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Índices de tabela `situations`
--
ALTER TABLE `situations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Índices de tabela `types_equips`
--
ALTER TABLE `types_equips`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_user_groups` (`user_level`);

--
-- Índices de tabela `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `group_level` (`group_level`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `equipments`
--
ALTER TABLE `equipments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `transfer_historys`
--
ALTER TABLE `transfer_historys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `manufacturers`
--
ALTER TABLE `manufacturers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `sectors`
--
ALTER TABLE `sectors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `situations`
--
ALTER TABLE `situations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `types_equips`
--
ALTER TABLE `types_equips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `equipments`
--
ALTER TABLE `equipments`
  ADD CONSTRAINT `fk_equipments_created_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_equipments_manufacturer` FOREIGN KEY (`manufacturer_id`) REFERENCES `manufacturers` (`id`),
  ADD CONSTRAINT `fk_equipments_situation` FOREIGN KEY (`situation_id`) REFERENCES `situations` (`id`),
  ADD CONSTRAINT `fk_equipments_types_equip` FOREIGN KEY (`types_equip_id`) REFERENCES `types_equips` (`id`),
  ADD CONSTRAINT `fk_equipments_updated_user` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Restrições para tabelas `transfers`
--
ALTER TABLE `transfers`
  ADD CONSTRAINT `fk_transfers_created_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_transfers_equipment` FOREIGN KEY (`equipment_id`) REFERENCES `equipments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_transfers_sector` FOREIGN KEY (`sector_id`) REFERENCES `sectors` (`id`),
  ADD CONSTRAINT `fk_transfers_updated_user` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Restrições para tabelas `transfer_historys`
--
ALTER TABLE `transfer_historys`
  ADD CONSTRAINT `fk_transfer_historys_created_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_transfer_historys_equipment` FOREIGN KEY (`equipment_id`) REFERENCES `equipments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_transfer_historys_sector` FOREIGN KEY (`sector_id`) REFERENCES `sectors` (`id`);

--
-- Restrições para tabelas `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_user_groups` FOREIGN KEY (`user_level`) REFERENCES `user_groups` (`group_level`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
