-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 20-Set-2022 às 05:13
-- Versão do servidor: 10.1.32-MariaDB
-- PHP Version: 7.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gerpatri`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `assets`
--

CREATE TABLE `assets` (
  `id` int(11) NOT NULL,
  `tombo` int(15) NOT NULL,
  `description_asset_id` int(15) NOT NULL,
  `types_item_id` int(15) NOT NULL,
  `sector_id` int(15) NOT NULL,
  `localization` varchar(250) DEFAULT NULL,
  `manufacturer_id` int(15) NOT NULL,
  `situation_id` int(15) NOT NULL,
  `provider` varchar(250) DEFAULT NULL,
  `number_nf` varchar(250) DEFAULT NULL,
  `date_aquisition` date DEFAULT NULL,
  `value` varchar(250) DEFAULT NULL,
  `number_serial` varchar(250) DEFAULT NULL,
  `obs` varchar(250) DEFAULT NULL,
  `warranty` date DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `assets`
--

INSERT INTO `assets` (`id`, `tombo`, `description_asset_id`, `types_item_id`, `sector_id`, `localization`, `manufacturer_id`, `situation_id`, `provider`, `number_nf`, `date_aquisition`, `value`, `number_serial`, `obs`, `warranty`, `created_by`, `created_at`, `updated_at`, `updated_by`) VALUES
(1, 1, 1, 919, 1, 'Sala servidores', 1, 1, 'teste', '00012', '2022-09-14', '500,00', '123456789', 'Nada a declarar', NULL, 1, '2022-09-14 00:46:29', NULL, NULL),
(2, 820, 1, 1, 5, 'teste', 1, 5, 'teste', '123456', '2022-09-15', '500', '123456', 'teste', NULL, 1, '2022-09-15 23:51:10', NULL, NULL),
(3, 850, 1, 1, 9, '', 5, 5, '', '', '0000-00-00', '', '', '', NULL, 1, '2022-09-16 00:42:10', NULL, NULL),
(4, 2550, 1, 919, 5, '919', 1, 7, 'eu mesmo', '3333', '2022-09-19', '250,00', '000000', 'nada nada nada nada', NULL, 1, '2022-09-19 22:14:00', '2022-09-20 00:02:27', 1),
(5, 2551, 2, 1, 9, '1', 2, 1, 'MISAEL RODRIGUES DOS ANJOS', '8080', '2022-09-08', '1.000,00', '789456123', 'NADA Ateste', '2022-09-28', 1, '2022-09-19 23:06:35', '2022-09-20 00:01:27', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `description_assets`
--

CREATE TABLE `description_assets` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `description_assets`
--

INSERT INTO `description_assets` (`id`, `name`) VALUES
(15, '12'),
(1, 'CPU BEGE'),
(16, 'ter'),
(7, 'terste'),
(14, 'tes'),
(2, 'teste');

-- --------------------------------------------------------

--
-- Estrutura da tabela `manufacturers`
--

CREATE TABLE `manufacturers` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `manufacturers`
--

INSERT INTO `manufacturers` (`id`, `name`) VALUES
(5, 'CISCO'),
(1, 'DELL'),
(3, 'HP'),
(2, 'LENOVO'),
(4, 'RICOH');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sectors`
--

CREATE TABLE `sectors` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `sectors`
--

INSERT INTO `sectors` (`id`, `name`) VALUES
(5, ' NAC - NÚCLEO DE ATENDIMENTO AO CLIENTE'),
(9, 'CENTRO DE IMAGENS'),
(3, 'DEPARTAMENTO PESSOAL'),
(11, 'DIREÇÃO'),
(2, 'NAF - NÚCLEO ADMINISTRATIVO FINANCEIRO'),
(1, 'NTI - NÚCLEO DE TECNOLOGIA DA INFORMAÇÃO'),
(6, 'OUVIDORIA'),
(4, 'RH - RECURSOS HUMANOS'),
(10, 'SAD - SERVIÇO DE ASSISTÊNCIA DOMICILIAR'),
(8, 'SERVIÇO SOCIAL');

-- --------------------------------------------------------

--
-- Estrutura da tabela `situations`
--

CREATE TABLE `situations` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `situations`
--

INSERT INTO `situations` (`id`, `name`) VALUES
(7, 'BACKUP'),
(6, 'DEVOLVIDO PARA SESA'),
(5, 'EM USO'),
(3, 'FURTADO'),
(4, 'INSERVÍVEL'),
(1, 'OPERACIONAL'),
(2, 'PARADO');

-- --------------------------------------------------------

--
-- Estrutura da tabela `transfers`
--

CREATE TABLE `transfers` (
  `id` int(11) NOT NULL,
  `asset_id` int(11) NOT NULL,
  `responsible_user` varchar(50) NOT NULL,
  `sector_id` int(11) NOT NULL,
  `transfer_date` date NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `transfer_historys`
--

CREATE TABLE `transfer_historys` (
  `id` int(11) NOT NULL,
  `asset_id` int(11) NOT NULL,
  `responsible_user` varchar(50) NOT NULL,
  `sector_id` int(11) NOT NULL,
  `transfer_date` date NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `types_itens`
--

CREATE TABLE `types_itens` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `types_itens`
--

INSERT INTO `types_itens` (`id`, `name`) VALUES
(931, ' UTENSÍLIOS'),
(1, 'BENS DE REDUZIDO VALOR'),
(932, 'depessas'),
(915, 'DESPESAS'),
(916, 'DOAÇÃO'),
(917, 'ELETRO ELETRONICOS'),
(918, 'EQUIPAMENTOS BIOMÉDICOS'),
(919, 'EQUIPAMENTOS DE INFORMÁTICA'),
(920, 'EQUIPAMENTOS E PROCESSAMENTO DE DADOS'),
(921, 'FERRAMENTAS E FERRAGENS'),
(914, 'MÁQUINAS E EQUIPAMENTOS'),
(923, 'MATERIAL DE INFORMÁTICA'),
(924, 'MATERIAL DE MANUTENÇÃO'),
(926, 'MATERIAL MÉDICO'),
(925, 'MATERIAL MÉDICO HOSPITALAR DURADOURO'),
(930, 'MATERIAL SESMT'),
(928, 'MOBÍLIA  HOSPITALAR'),
(929, 'MOBÍLIA GERAL'),
(913, 'MÓVEIS E UTENSÍLIOS'),
(927, 'VEÍCULOS');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
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
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `user_level`, `image`, `status`, `last_login`) VALUES
(1, 'Administrador', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 'g5es6q1.jpg', 1, '2022-09-19 20:36:26'),
(2, 'Usuário Operacional', 'user', '12dea96fec20593566ab75692c9949596833adc9', 2, 'no_image.jpg', 1, '2020-08-14 16:42:28');

-- --------------------------------------------------------

--
-- Estrutura da tabela `user_groups`
--

CREATE TABLE `user_groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(150) CHARACTER SET utf8 NOT NULL,
  `group_level` int(11) NOT NULL,
  `group_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `user_groups`
--

INSERT INTO `user_groups` (`id`, `group_name`, `group_level`, `group_status`) VALUES
(1, 'Administrador', 1, 1),
(2, 'Operacional', 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_tombo` (`tombo`),
  ADD KEY `fk_asset_manufacturer` (`manufacturer_id`),
  ADD KEY `fk_asset_sector` (`sector_id`),
  ADD KEY `fk_asset_situation` (`situation_id`),
  ADD KEY `fk_asset_created_user` (`created_by`),
  ADD KEY `fk_asset_updated_user` (`updated_by`),
  ADD KEY `fk_asset_types_item` (`types_item_id`),
  ADD KEY `fk_asset_description_asset` (`description_asset_id`);

--
-- Indexes for table `description_assets`
--
ALTER TABLE `description_assets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `manufacturers`
--
ALTER TABLE `manufacturers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `sectors`
--
ALTER TABLE `sectors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `situations`
--
ALTER TABLE `situations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_transfer_asset` (`asset_id`),
  ADD KEY `fk_transfer_sector` (`sector_id`),
  ADD KEY `fk_transfer_created_user` (`created_by`),
  ADD KEY `fk_transfer_updated_user` (`updated_by`);

--
-- Indexes for table `transfer_historys`
--
ALTER TABLE `transfer_historys`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_transfer_historys_asset` (`asset_id`),
  ADD KEY `fk_transfer_historys_created_user` (`created_by`),
  ADD KEY `fk_transfer_historys_sector` (`sector_id`);

--
-- Indexes for table `types_itens`
--
ALTER TABLE `types_itens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_user_groups` (`user_level`);

--
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `group_level` (`group_level`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `description_assets`
--
ALTER TABLE `description_assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `manufacturers`
--
ALTER TABLE `manufacturers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sectors`
--
ALTER TABLE `sectors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `situations`
--
ALTER TABLE `situations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transfer_historys`
--
ALTER TABLE `transfer_historys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `types_itens`
--
ALTER TABLE `types_itens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=933;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `assets`
--
ALTER TABLE `assets`
  ADD CONSTRAINT `assets_ibfk_1` FOREIGN KEY (`types_item_id`) REFERENCES `types_itens` (`id`),
  ADD CONSTRAINT `assets_ibfk_2` FOREIGN KEY (`situation_id`) REFERENCES `situations` (`id`),
  ADD CONSTRAINT `assets_ibfk_3` FOREIGN KEY (`manufacturer_id`) REFERENCES `manufacturers` (`id`),
  ADD CONSTRAINT `assets_ibfk_4` FOREIGN KEY (`sector_id`) REFERENCES `sectors` (`id`),
  ADD CONSTRAINT `assets_ibfk_5` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `assets_ibfk_6` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `assets_ibfk_7` FOREIGN KEY (`description_asset_id`) REFERENCES `description_assets` (`id`);

--
-- Limitadores para a tabela `transfers`
--
ALTER TABLE `transfers`
  ADD CONSTRAINT `fk_transfers_asset` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_transfers_created_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_transfers_sector` FOREIGN KEY (`sector_id`) REFERENCES `sectors` (`id`),
  ADD CONSTRAINT `fk_transfers_updated_user` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Limitadores para a tabela `transfer_historys`
--
ALTER TABLE `transfer_historys`
  ADD CONSTRAINT `fk_transfer_historys_asset` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_transfer_historys_created_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_transfer_historys_sector` FOREIGN KEY (`sector_id`) REFERENCES `sectors` (`id`);

--
-- Limitadores para a tabela `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_user_groups` FOREIGN KEY (`user_level`) REFERENCES `user_groups` (`group_level`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
