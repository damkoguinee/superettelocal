-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 20 jan. 2024 à 10:48
-- Version du serveur : 10.5.19-MariaDB-cll-lve
-- Version de PHP : 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `u166723045_alsenyciaokind`
--

-- --------------------------------------------------------

--
-- Structure de la table `achat`
--

CREATE TABLE `achat` (
  `id` int(11) NOT NULL,
  `id_produitfac` int(50) DEFAULT NULL,
  `codebarre` varchar(50) DEFAULT NULL,
  `numcmd` varchar(15) NOT NULL,
  `numfact` varchar(50) DEFAULT NULL,
  `fournisseur` varchar(60) DEFAULT NULL,
  `designation` varchar(60) NOT NULL,
  `quantite` float NOT NULL,
  `quantiteliv` int(11) NOT NULL DEFAULT 0,
  `taux` float NOT NULL DEFAULT 1,
  `pachat` double NOT NULL,
  `previent` double DEFAULT NULL,
  `pvente` double DEFAULT NULL,
  `etat` varchar(15) NOT NULL,
  `idstockliv` int(11) NOT NULL,
  `datefact` date DEFAULT NULL,
  `datecmd` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `achat`
--

INSERT INTO `achat` (`id`, `id_produitfac`, `codebarre`, `numcmd`, `numfact`, `fournisseur`, `designation`, `quantite`, `quantiteliv`, `taux`, `pachat`, `previent`, `pvente`, `etat`, `idstockliv`, `datefact`, `datecmd`) VALUES
(16, 16, NULL, '008', '008', '4', 'Jus Zaza Fraiche Detail', 15, 0, 1, 2067, 2073, 0, 'livre', 1, '2024-01-13', '2024-01-17 22:30:29'),
(11, 1, NULL, '008', '008', '4', 'Jus Messi Rouge', 3264, 0, 1, 65000, 65200, 0, 'livre', 1, '2024-01-13', '2024-01-17 22:05:23'),
(12, 2, NULL, '008', '008', '4', 'Jus Messi Rouge Detail', 15, 0, 1, 2167, 0, 0, 'livre', 1, '2024-01-13', '2024-01-17 22:09:47'),
(13, 5, NULL, '008', '008', '4', 'Jus Messi Orange', 1363, 0, 1, 65000, 65200, 0, 'livre', 1, '2024-01-13', '2024-01-17 22:16:36'),
(14, 15, NULL, '008', '008', '4', 'Jus Zaza Fraiche', 2577, 0, 1, 62000, 62200, 0, 'livre', 1, '2024-01-13', '2024-01-17 22:19:47'),
(15, 15, NULL, '008', '008', '4', 'Jus Zaza Fraiche', 2577, 0, 1, 62000, 62200, 0, 'livre', 1, '2024-01-13', '2024-01-17 22:20:20'),
(17, 13, NULL, '008', '008', '4', 'Jus Zaza Orange', 600, 0, 1, 62000, 62200, 0, 'livre', 1, '2024-01-13', '2024-01-17 22:41:10'),
(18, 7, NULL, '008', '008', '4', 'Jus Messi  Cocteil', 235, 0, 1, 65000, 65200, 0, 'livre', 1, '2024-01-13', '2024-01-17 22:43:11'),
(19, 8, NULL, '008', '008', '4', 'Jus Messi  Cocteil Detail', 15, 0, 1, 2167, 2173, 0, 'livre', 1, '2024-01-13', '2024-01-17 22:44:43'),
(20, 3, NULL, '008', '008', '4', 'Jus Messi Ananas', 65, 0, 1, 62000, 62200, 0, 'livre', 1, '2024-01-13', '2024-01-17 23:40:38'),
(21, 9, NULL, '008', '008', '4', 'Jus Messi Tamaraine', 361, 0, 1, 62000, 62200, 0, 'livre', 1, '2024-01-13', '2024-01-17 23:42:44'),
(22, 10, NULL, '008', '008', '4', 'Jus Messi Tamaraine Detail', 15, 0, 1, 2067, 2073, 0, 'livre', 1, '2024-01-13', '2024-01-17 23:43:55'),
(23, 62, NULL, '008', '008', '4', 'Jus Rama Cocteil Sipa', 2873, 0, 1, 41000, 41200, 0, 'livre', 1, '2024-01-13', '2024-01-17 23:46:41'),
(24, 74, NULL, '008', '008', '4', '3jours Gros', 3361, 0, 1, 32000, 32200, 0, 'livre', 1, '2024-01-13', '2024-01-17 23:49:52'),
(25, 78, NULL, '008', '008', '4', '3jours Petit', 4738, 0, 1, 28000, 28200, 0, 'livre', 1, '2024-01-13', '2024-01-17 23:56:29'),
(26, 64, NULL, '008', '008', '4', 'Jus Rama Cocteil Boite', 1447, 0, 1, 76000, 76200, 0, 'livre', 1, '2024-01-13', '2024-01-18 00:02:36'),
(27, 112, NULL, '008', '008', '4', 'Tonic Messi Cipa', 32, 0, 1, 33000, 33200, 0, 'livre', 1, '2024-01-13', '2024-01-18 00:07:01'),
(28, 114, NULL, '008', '008', '4', 'Savon Ciao Petit Rouge', 403, 0, 1, 104000, 104300, 0, 'livre', 1, '2024-01-13', '2024-01-18 00:15:57'),
(29, 115, NULL, '008', '008', '4', 'Savon Ciao Petit Blanc', 12, 0, 1, 104000, 104300, 0, 'livre', 1, '2024-01-13', '2024-01-18 00:17:12'),
(30, 66, NULL, '008', '008', '4', 'Jus Rama Orang Boite', 183, 0, 1, 102000, 102200, 0, 'livre', 1, '2024-01-13', '2024-01-18 00:20:12'),
(31, 67, NULL, '008', '008', '4', 'Jus Rama Orang Boite Detail', 6, 0, 1, 4000, 4000, 0, 'livre', 1, '2024-01-13', '2024-01-18 00:21:25'),
(32, 23, NULL, '008', '008', '4', 'Jus Vandam Sipa Grand', 2726, 0, 1, 35000, 35200, 0, 'livre', 1, '2024-01-13', '2024-01-18 00:27:01'),
(33, 72, NULL, '008', '008', '4', 'Jus Planete Cocteil', 1723, 0, 1, 32000, 32200, 0, 'livre', 1, '2024-01-13', '2024-01-18 00:30:21'),
(34, 84, NULL, '008', '008', '4', 'Jus Reactore', 533, 0, 1, 35000, 35200, 0, 'livre', 1, '2024-01-13', '2024-01-18 00:32:30'),
(35, 80, NULL, '008', '008', '4', 'Jus Americain Cola', 59, 0, 1, 32000, 32200, 0, 'livre', 1, '2024-01-13', '2024-01-18 00:33:55'),
(36, 38, NULL, '008', '008', '4', 'Jus Tonic 24h Petit', 419, 0, 1, 32000, 32200, 0, 'livre', 1, '2024-01-13', '2024-01-18 00:35:13'),
(37, 76, NULL, '008', '008', '4', 'Jus Planete Orange', 16, 0, 1, 32000, 32200, 0, 'livre', 1, '2024-01-13', '2024-01-18 00:36:54'),
(38, 37, NULL, '008', '008', '4', 'Jus 24h Grand', 433, 0, 1, 36000, 36200, 0, 'livre', 1, '2024-01-13', '2024-01-18 00:38:29'),
(39, 36, NULL, '008', '008', '4', '24h Petit', 124, 0, 1, 32000, 32200, 0, 'livre', 1, '2024-01-13', '2024-01-18 00:40:07'),
(40, 44, NULL, '008', '008', '4', 'Jus Sprete 24h', 20, 0, 1, 32000, 32200, 0, 'livre', 1, '2024-01-13', '2024-01-18 00:43:44'),
(41, 121, NULL, '008', '008', '4', 'Tonic Blanc', 117, 0, 1, 32000, 32200, 0, 'livre', 1, '2024-01-13', '2024-01-18 00:45:54'),
(42, 122, NULL, '008', '008', '4', 'Play Petit', 58, 0, 1, 42000, 42200, 0, 'livre', 1, '2024-01-13', '2024-01-18 00:48:44'),
(43, 123, NULL, '008', '008', '4', 'Xxl Boite', 429, 0, 1, 120000, 120200, 0, 'livre', 1, '2024-01-13', '2024-01-18 00:51:24'),
(44, 124, NULL, '008', '008', '4', 'Xxl Boite Detail', 12, 0, 1, 4000, 4200, 0, 'livre', 1, '2024-01-13', '2024-01-18 00:52:09'),
(45, 47, NULL, '008', '008', '4', 'Jus Fanta Bonagui', 40, 0, 1, 42000, 42200, 0, 'livre', 1, '2024-01-13', '2024-01-18 00:53:25'),
(46, 94, NULL, '008', '008', '4', 'Jus Fruit  Arafa Ananas', 19, 0, 1, 110000, 110300, 0, 'livre', 1, '2024-01-13', '2024-01-18 00:54:53'),
(53, 33, NULL, '008', '008', '4', 'Jus Fruit Arafa Tamarin', 5, 0, 1, 110000, 110000, 0, 'livre', 1, '2024-01-13', '2024-01-18 01:09:17'),
(52, 101, NULL, '008', '008', '4', 'Jus Fruit Arafa Cocktail Detail', 12, 0, 1, 5000, 5500, 0, 'livre', 1, '2024-01-13', '2024-01-18 01:05:47'),
(54, 34, NULL, '008', '008', '4', 'Jus Fruit Arafa Tamarin Detail', 12, 0, 1, 4200, 4300, 0, 'livre', 1, '2024-01-13', '2024-01-18 01:10:54'),
(55, 98, NULL, '008', '008', '4', 'Jus Fruit Arafa Mangue', 3, 0, 1, 110000, 110000, 0, 'livre', 1, '2024-01-13', '2024-01-18 01:12:41'),
(56, 99, NULL, '008', '008', '4', 'Jus Fruit Arafa Mangue Detail', 12, 0, 1, 4200, 4300, 0, 'livre', 1, '2024-01-13', '2024-01-18 01:13:40'),
(57, 31, NULL, '008', '008', '4', 'Jus Fruitalos Ananas', 3, 0, 1, 105000, 105000, 0, 'livre', 1, '2024-01-13', '2024-01-18 01:14:36'),
(58, 104, NULL, '008', '008', '4', 'Jus Fruitalos Cocktail', 11, 0, 1, 105000, 105000, 0, 'livre', 1, '2024-01-13', '2024-01-18 01:15:18'),
(59, 102, NULL, '008', '008', '4', 'Jus Fruitalos Tamarin', 13, 0, 1, 105000, 105000, 0, 'livre', 1, '2024-01-13', '2024-01-18 01:15:48'),
(60, 110, NULL, '008', '008', '4', 'Jus Fruitalos Soursop ', 8, 0, 1, 105000, 105000, 0, 'livre', 1, '2024-01-13', '2024-01-18 01:16:47'),
(61, 111, NULL, '008', '008', '4', 'Jus Fruitalos Soursop  Detail', 12, 0, 1, 105000, 105000, 0, 'livre', 1, '2024-01-13', '2024-01-18 01:17:40'),
(62, 125, NULL, '008', '008', '4', 'Vimto Boite', 2, 0, 1, 120000, 120000, 0, 'livre', 1, '2024-01-13', '2024-01-18 01:20:41'),
(63, 126, NULL, '008', '008', '4', 'Vimto Boite Detail', 12, 0, 1, 7000, 7000, 0, 'livre', 1, '2024-01-13', '2024-01-18 01:21:07'),
(64, 127, NULL, '008', '008', '4', 'Jus Arafa Soursop', 8, 0, 1, 120000, 120000, 0, 'livre', 1, '2024-01-13', '2024-01-18 01:23:29'),
(65, 129, NULL, '008', '008', '4', 'Jus Vinut Ananas', 3, 0, 1, 110000, 110000, 0, 'livre', 1, '2024-01-13', '2024-01-18 01:29:59'),
(66, 130, NULL, '008', '008', '4', 'Jus Vinut Ananas Detail', 12, 0, 1, 110000, 110000, 0, 'livre', 1, '2024-01-13', '2024-01-18 01:30:24'),
(67, 131, NULL, '008', '008', '4', 'Jus Vinut Soursop', 1, 0, 1, 110000, 110000, 0, 'livre', 1, '2024-01-13', '2024-01-18 01:30:46'),
(68, 132, NULL, '008', '008', '4', 'Jus Vinut Soursop Detail', 12, 0, 1, 110000, 110000, 0, 'livre', 1, '2024-01-13', '2024-01-18 01:31:04'),
(69, 133, NULL, '008', '008', '4', 'Jus Arafa Guave', 1, 0, 1, 110000, 110000, 0, 'livre', 1, '2024-01-13', '2024-01-18 01:32:52'),
(70, 39, NULL, '008', '008', '4', 'Jus Tamerine 24h Petit', 10, 0, 1, 110000, 110000, 0, 'livre', 1, '2024-01-13', '2024-01-18 01:33:42'),
(71, 135, NULL, '008', '008', '4', 'U-fresh Orange', 829, 0, 1, 20000, 20200, 0, 'livre', 1, '2024-01-13', '2024-01-18 01:40:01'),
(72, 136, NULL, '008', '008', '4', 'U-fresh Ananas', 421, 0, 1, 20000, 20200, 0, 'livre', 1, '2024-01-13', '2024-01-18 01:40:49'),
(73, 137, NULL, '008', '008', '4', 'U-fresh Energie', 362, 0, 1, 20000, 20200, 0, 'livre', 1, '2024-01-13', '2024-01-18 01:41:17'),
(75, 139, NULL, '008', '008', '4', 'U-fresh Cipa Grand', 68, 0, 1, 15000, 15200, 0, 'livre', 1, '2024-01-13', '2024-01-18 01:42:49'),
(76, 140, NULL, '008', '008', '4', 'U-fresh Cipa Petit', 4, 0, 1, 30000, 30000, 0, 'livre', 1, '2024-01-13', '2024-01-18 07:20:33'),
(77, 46, NULL, '008', '008', '4', 'Jus Fanta Boite', 34, 0, 1, 120000, 120000, 0, 'livre', 1, '2024-01-13', '2024-01-18 07:21:27'),
(78, 45, NULL, '008', '008', '4', 'Jus Coca Boite', 1, 0, 1, 120000, 120000, 0, 'livre', 1, '2024-01-13', '2024-01-18 07:22:29'),
(79, 138, NULL, '008', '008', '4', 'U-fresh Petit Ananas', 108, 0, 1, 120000, 120000, 0, 'livre', 1, '2024-01-13', '2024-01-18 07:23:31'),
(81, 141, NULL, '008', '008', '4', 'U-fresh Pega Orange', 107, 0, 1, 12000, 12000, 0, 'livre', 1, '2024-01-13', '2024-01-18 07:31:12'),
(82, 142, NULL, '008', '008', '4', 'Tiktok', 3488, 0, 1, 32000, 32200, 0, 'livre', 1, '2024-01-13', '2024-01-18 07:34:54'),
(83, 68, NULL, '008', '008', '4', 'Jus Rama Ananas Boite', 624, 0, 1, 110000, 110200, 0, 'livre', 1, '2024-01-13', '2024-01-18 07:36:29'),
(84, 25, NULL, '008', '008', '4', 'Jus Vandam Sipa Petit', 2421, 0, 1, 33000, 33200, 0, 'livre', 1, '2024-01-13', '2024-01-18 07:38:09'),
(85, 11, NULL, '008', '008', '4', 'Beurre Ciao900g', 38, 0, 1, 130000, 130200, 0, 'livre', 1, '2024-01-13', '2024-01-18 07:39:16'),
(86, 27, NULL, '008', '008', '4', 'Jus Vandam Boite', 261, 0, 1, 140000, 140000, 0, 'livre', 1, '2024-01-13', '2024-01-18 07:40:13'),
(87, 49, NULL, '008', '008', '4', 'Mayonaise Ciao 5l', 1253, 0, 1, 140000, 140000, 0, 'livre', 1, '2024-01-13', '2024-01-18 07:41:22'),
(88, 52, NULL, '008', '008', '4', 'Mayonaise Ciao 32', 15, 0, 1, 150000, 150000, 0, 'livre', 1, '2024-01-13', '2024-01-18 07:43:34'),
(89, 58, NULL, '008', '008', '4', 'Beurre Ciao 4.5kg', 375, 0, 1, 75000, 75000, 0, 'livre', 1, '2024-01-13', '2024-01-18 07:44:48'),
(90, 118, NULL, '008', '008', '4', 'Savon Ciao Grand Blanc', 182, 0, 1, 134000, 134300, 0, 'livre', 1, '2024-01-13', '2024-01-18 08:55:30'),
(91, 116, NULL, '008', '008', '4', 'Savon Ciao Moyen Blanc', 75, 0, 1, 119000, 119000, 0, 'livre', 1, '2024-01-13', '2024-01-18 08:57:00'),
(92, 125, NULL, '005JEUDI', '005JEUDI', '179', 'Vimto Boite', 200, 0, 1, 142500, 143024.75247525, 0, 'livre', 1, '2024-01-18', '2024-01-18 11:43:06'),
(93, 20, NULL, '008', '008', '4', 'Huile Ciao 10l', 9, 0, 1, 126000, 126200, 0, 'livre', 1, '2024-01-13', '2024-01-18 13:01:47'),
(94, 60, NULL, '008', '008', '4', 'Huile Ciao 5l', 4, 0, 1, 252000, 252200, 0, 'livre', 1, '2024-01-13', '2024-01-18 13:06:24'),
(95, 61, NULL, '008', '008', '4', 'Huile Ciao 5l Detail', 1, 0, 1, 0, 0, 0, 'livre', 1, '2024-01-13', '2024-01-18 13:08:00'),
(96, 19, NULL, '008', '008', '4', 'Huile 20l', 6, 0, 1, 251000, 251200, 0, 'livre', 1, '2024-01-13', '2024-01-18 13:09:59');

-- --------------------------------------------------------

--
-- Structure de la table `adresse`
--

CREATE TABLE `adresse` (
  `id` int(11) NOT NULL,
  `nom_mag` varchar(255) NOT NULL,
  `type_mag` varchar(255) NOT NULL,
  `adresse` varchar(500) NOT NULL,
  `initial` varchar(5) DEFAULT NULL,
  `lieuvente` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `adresse`
--

INSERT INTO `adresse` (`id`, `nom_mag`, `type_mag`, `adresse`, `initial`, `lieuvente`) VALUES
(1, 'ETS ALSENY CIAO & FRERES', 'Vendeur des boissons non alcoolisées & divers', 'Marché de kindia / Centre commercial 3 avril. Tél: (00224) 623 59 18 17 /620 58 89 68', 'acf', 1);

-- --------------------------------------------------------

--
-- Structure de la table `banque`
--

CREATE TABLE `banque` (
  `id` int(11) NOT NULL,
  `id_banque` varchar(20) NOT NULL DEFAULT '80',
  `numero` varchar(15) NOT NULL,
  `typeent` varchar(50) DEFAULT NULL,
  `libelles` varchar(150) NOT NULL,
  `montant` float DEFAULT NULL,
  `devise` varchar(50) NOT NULL DEFAULT 'gnf',
  `typep` varchar(50) NOT NULL DEFAULT 'espèces',
  `numeropaie` varchar(50) DEFAULT NULL,
  `banqcheque` varchar(50) DEFAULT NULL,
  `lieuvente` varchar(10) DEFAULT NULL,
  `date_versement` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `banque`
--

INSERT INTO `banque` (`id`, `id_banque`, `numero`, `typeent`, `libelles`, `montant`, `devise`, `typep`, `numeropaie`, `banqcheque`, `lieuvente`, `date_versement`) VALUES
(152, '1', 'venteacf240031', 'vente', 'vente n°acf240031', 0, 'us', 'espèces', NULL, NULL, '1', '2024-01-18 20:32:00'),
(150, '1', 'venteacf240031', 'vente', 'vente n°acf240031', 6566990, 'gnf', 'espèces', NULL, NULL, '1', '2024-01-18 20:32:00'),
(151, '1', 'venteacf240031', 'vente', 'vente n°acf240031', 0, 'eu', 'espèces', NULL, NULL, '1', '2024-01-18 20:32:00'),
(149, '1', 'dep14', NULL, 'Depot(Payement facture )', 30000000, 'gnf', 'espèces', '', '', '1', '2024-01-18 00:00:00'),
(148, '1', 'venteacf240030', 'vente', 'vente n°acf240030', NULL, 'cfa', 'espèces', NULL, NULL, '1', '2024-01-18 00:00:00'),
(147, '1', 'venteacf240030', 'vente', 'vente n°acf240030', NULL, 'us', 'espèces', NULL, NULL, '1', '2024-01-18 00:00:00'),
(146, '1', 'venteacf240030', 'vente', 'vente n°acf240030', NULL, 'eu', 'espèces', NULL, NULL, '1', '2024-01-18 00:00:00'),
(145, '1', 'venteacf240030', 'vente', 'vente n°acf240030', NULL, 'gnf', 'espèces', NULL, NULL, '1', '2024-01-18 00:00:00'),
(143, '1', 'venteacf240029', 'vente', 'vente n°acf240029', 0, 'us', 'espèces', NULL, NULL, '1', '2024-01-18 00:00:00'),
(141, '1', 'venteacf240029', 'vente', 'vente n°acf240029', 3900000, 'gnf', 'espèces', NULL, NULL, '1', '2024-01-18 00:00:00'),
(142, '1', 'venteacf240029', 'vente', 'vente n°acf240029', 0, 'eu', 'espèces', NULL, NULL, '1', '2024-01-18 00:00:00'),
(140, '1', 'dep13', NULL, 'Depot(Payement facture )', 150000, 'gnf', 'espèces', '', '', '1', '2024-01-18 16:31:00'),
(139, '1', 'venteacf240028', 'vente', 'vente n°acf240028', 0, 'cfa', 'espèces', NULL, NULL, '1', '2024-01-18 16:06:57'),
(138, '1', 'venteacf240028', 'vente', 'vente n°acf240028', 0, 'us', 'espèces', NULL, NULL, '1', '2024-01-18 16:06:57'),
(137, '1', 'venteacf240028', 'vente', 'vente n°acf240028', 0, 'eu', 'espèces', NULL, NULL, '1', '2024-01-18 16:06:57'),
(136, '1', 'venteacf240028', 'vente', 'vente n°acf240028', 0, 'gnf', 'espèces', NULL, NULL, '1', '2024-01-18 16:06:57'),
(134, '1', 'venteacf240027', 'vente', 'vente n°acf240027', 0, 'us', 'espèces', NULL, NULL, '1', '2024-01-18 13:58:35'),
(135, '1', 'venteacf240027', 'vente', 'vente n°acf240027', 0, 'cfa', 'espèces', NULL, NULL, '1', '2024-01-18 13:58:35'),
(110, '1', 'venteacf240022', 'vente', 'vente n°acf240022', 498000, 'gnf', 'espèces', NULL, NULL, '1', '2024-01-18 09:34:01'),
(109, '1', 'venteacf240021', 'vente', 'vente n°acf240021', 0, 'cfa', 'espèces', NULL, NULL, '1', '2024-01-18 09:21:54'),
(144, '1', 'venteacf240029', 'vente', 'vente n°acf240029', 0, 'cfa', 'espèces', NULL, NULL, '1', '2024-01-18 00:00:00'),
(133, '1', 'venteacf240027', 'vente', 'vente n°acf240027', 0, 'eu', 'espèces', NULL, NULL, '1', '2024-01-18 13:58:35'),
(132, '1', 'venteacf240027', 'vente', 'vente n°acf240027', 240000, 'gnf', 'espèces', NULL, NULL, '1', '2024-01-18 13:58:35'),
(131, '1', 'dep12', NULL, 'Depot(payement facture)', 4000000, 'gnf', 'espèces', '', '', '1', '2024-01-18 13:18:56'),
(130, '1', 'venteacf240026', 'vente', 'vente n°acf240026', 0, 'cfa', 'espèces', NULL, NULL, '1', '2024-01-18 13:16:00'),
(129, '1', 'venteacf240026', 'vente', 'vente n°acf240026', 0, 'us', 'espèces', NULL, NULL, '1', '2024-01-18 13:16:00'),
(128, '1', 'venteacf240026', 'vente', 'vente n°acf240026', 0, 'eu', 'espèces', NULL, NULL, '1', '2024-01-18 13:16:00'),
(127, '1', 'venteacf240026', 'vente', 'vente n°acf240026', 572000, 'gnf', 'espèces', NULL, NULL, '1', '2024-01-18 13:16:00'),
(126, '1', 'venteacf240025', 'vente', 'vente n°acf240025', 0, 'cfa', 'espèces', NULL, NULL, '1', '2024-01-18 12:56:56'),
(125, '1', 'venteacf240025', 'vente', 'vente n°acf240025', 0, 'us', 'espèces', NULL, NULL, '1', '2024-01-18 12:56:56'),
(124, '1', 'venteacf240025', 'vente', 'vente n°acf240025', 0, 'eu', 'espèces', NULL, NULL, '1', '2024-01-18 12:56:56'),
(123, '1', 'venteacf240025', 'vente', 'vente n°acf240025', 1698000, 'gnf', 'espèces', NULL, NULL, '1', '2024-01-18 12:56:56'),
(122, '1', 'venteacf240024', 'vente', 'vente n°acf240024', 0, 'cfa', 'espèces', NULL, NULL, '1', '2024-01-18 12:30:34'),
(121, '1', 'venteacf240024', 'vente', 'vente n°acf240024', 0, 'us', 'espèces', NULL, NULL, '1', '2024-01-18 12:30:34'),
(120, '1', 'venteacf240024', 'vente', 'vente n°acf240024', 0, 'eu', 'espèces', NULL, NULL, '1', '2024-01-18 12:30:34'),
(119, '1', 'venteacf240024', 'vente', 'vente n°acf240024', 1025000, 'gnf', 'espèces', NULL, NULL, '1', '2024-01-18 12:30:34'),
(118, '1', 'venteacf240023', 'vente', 'vente n°acf240023', 0, 'cfa', 'espèces', NULL, NULL, '1', '2024-01-18 09:54:35'),
(117, '1', 'venteacf240023', 'vente', 'vente n°acf240023', 0, 'us', 'espèces', NULL, NULL, '1', '2024-01-18 09:54:35'),
(116, '1', 'venteacf240023', 'vente', 'vente n°acf240023', 0, 'eu', 'espèces', NULL, NULL, '1', '2024-01-18 09:54:35'),
(115, '1', 'venteacf240023', 'vente', 'vente n°acf240023', 735000, 'gnf', 'espèces', NULL, NULL, '1', '2024-01-18 09:54:35'),
(114, '1', 'dep11', NULL, 'Depot(Payment Facture)', 5100000, 'gnf', 'espèces', '', '', '1', '2024-01-18 09:49:01'),
(113, '1', 'venteacf240022', 'vente', 'vente n°acf240022', 0, 'cfa', 'espèces', NULL, NULL, '1', '2024-01-18 09:34:01'),
(111, '1', 'venteacf240022', 'vente', 'vente n°acf240022', 0, 'eu', 'espèces', NULL, NULL, '1', '2024-01-18 09:34:01'),
(112, '1', 'venteacf240022', 'vente', 'vente n°acf240022', 0, 'us', 'espèces', NULL, NULL, '1', '2024-01-18 09:34:01'),
(91, '1', 'dep8', NULL, 'Depot(PAYEMENT FACTUR)', 2000000, 'gnf', 'espèces', '', '', '1', '2024-01-15 15:57:01'),
(92, '1', 'dep9', NULL, 'Depot(Payement facture )', 1600000, 'gnf', 'espèces', '', '', '1', '2024-01-16 00:00:00'),
(93, '1', 'dep10', NULL, 'Depot(Payement facture )', 2942000, 'gnf', 'espèces', '', '', '1', '2024-01-16 20:06:25'),
(94, '1', 'venteacf240018', 'vente', 'vente n°acf240018', 468000, 'gnf', 'espèces', NULL, NULL, '1', '2024-01-18 09:04:35'),
(95, '1', 'venteacf240018', 'vente', 'vente n°acf240018', 0, 'eu', 'espèces', NULL, NULL, '1', '2024-01-18 09:04:35'),
(96, '1', 'venteacf240018', 'vente', 'vente n°acf240018', 0, 'us', 'espèces', NULL, NULL, '1', '2024-01-18 09:04:35'),
(97, '1', 'venteacf240018', 'vente', 'vente n°acf240018', 0, 'cfa', 'espèces', NULL, NULL, '1', '2024-01-18 09:04:35'),
(98, '1', 'venteacf240019', 'vente', 'vente n°acf240019', 45000, 'gnf', 'espèces', NULL, NULL, '1', '2024-01-18 09:09:52'),
(99, '1', 'venteacf240019', 'vente', 'vente n°acf240019', 0, 'eu', 'espèces', NULL, NULL, '1', '2024-01-18 09:09:52'),
(100, '1', 'venteacf240019', 'vente', 'vente n°acf240019', 0, 'us', 'espèces', NULL, NULL, '1', '2024-01-18 09:09:52'),
(101, '1', 'venteacf240019', 'vente', 'vente n°acf240019', 0, 'cfa', 'espèces', NULL, NULL, '1', '2024-01-18 09:09:52'),
(102, '1', 'venteacf240020', 'vente', 'vente n°acf240020', 695000, 'gnf', 'espèces', NULL, NULL, '1', '2024-01-18 09:11:41'),
(103, '1', 'venteacf240020', 'vente', 'vente n°acf240020', 0, 'eu', 'espèces', NULL, NULL, '1', '2024-01-18 09:11:41'),
(104, '1', 'venteacf240020', 'vente', 'vente n°acf240020', 0, 'us', 'espèces', NULL, NULL, '1', '2024-01-18 09:11:41'),
(105, '1', 'venteacf240020', 'vente', 'vente n°acf240020', 0, 'cfa', 'espèces', NULL, NULL, '1', '2024-01-18 09:11:41'),
(106, '1', 'venteacf240021', 'vente', 'vente n°acf240021', 50000, 'gnf', 'espèces', NULL, NULL, '1', '2024-01-18 09:21:54'),
(107, '1', 'venteacf240021', 'vente', 'vente n°acf240021', 0, 'eu', 'espèces', NULL, NULL, '1', '2024-01-18 09:21:54'),
(108, '1', 'venteacf240021', 'vente', 'vente n°acf240021', 0, 'us', 'espèces', NULL, NULL, '1', '2024-01-18 09:21:54'),
(90, '1', 'dep1', NULL, 'Depot(peyement facture)', 8030000, 'gnf', 'espèces', '', '', '1', '2024-01-15 10:43:39'),
(153, '1', 'venteacf240031', 'vente', 'vente n°acf240031', 0, 'cfa', 'espèces', NULL, NULL, '1', '2024-01-18 20:32:00'),
(154, '1', 'venteacf240032', 'vente', 'vente n°acf240032', 416988, 'gnf', 'espèces', NULL, NULL, '1', '2024-01-18 20:45:39'),
(155, '1', 'venteacf240032', 'vente', 'vente n°acf240032', 0, 'eu', 'espèces', NULL, NULL, '1', '2024-01-18 20:45:39'),
(156, '1', 'venteacf240032', 'vente', 'vente n°acf240032', 0, 'us', 'espèces', NULL, NULL, '1', '2024-01-18 20:45:39'),
(157, '1', 'venteacf240032', 'vente', 'vente n°acf240032', 0, 'cfa', 'espèces', NULL, NULL, '1', '2024-01-18 20:45:39'),
(158, '1', 'venteacf240033', 'vente', 'vente n°acf240033', 3972000, 'gnf', 'espèces', NULL, NULL, '1', '2024-01-18 21:20:47'),
(159, '1', 'venteacf240033', 'vente', 'vente n°acf240033', 0, 'eu', 'espèces', NULL, NULL, '1', '2024-01-18 21:20:47'),
(160, '1', 'venteacf240033', 'vente', 'vente n°acf240033', 0, 'us', 'espèces', NULL, NULL, '1', '2024-01-18 21:20:47'),
(161, '1', 'venteacf240033', 'vente', 'vente n°acf240033', 0, 'cfa', 'espèces', NULL, NULL, '1', '2024-01-18 21:20:47'),
(162, '1', 'venteacf240034', 'vente', 'vente n°acf240034', NULL, 'gnf', 'espèces', NULL, NULL, '1', '2024-01-18 21:23:10'),
(163, '1', 'venteacf240034', 'vente', 'vente n°acf240034', NULL, 'eu', 'espèces', NULL, NULL, '1', '2024-01-18 21:23:10'),
(164, '1', 'venteacf240034', 'vente', 'vente n°acf240034', NULL, 'us', 'espèces', NULL, NULL, '1', '2024-01-18 21:23:10'),
(165, '1', 'venteacf240034', 'vente', 'vente n°acf240034', NULL, 'cfa', 'espèces', NULL, NULL, '1', '2024-01-18 21:23:10');

-- --------------------------------------------------------

--
-- Structure de la table `bon_commande`
--

CREATE TABLE `bon_commande` (
  `id` int(11) NOT NULL,
  `numedit` varchar(150) DEFAULT NULL,
  `id_client` int(10) DEFAULT NULL,
  `libelle` varchar(150) DEFAULT NULL,
  `bl` varchar(150) DEFAULT NULL,
  `montant` double DEFAULT NULL,
  `devise` varchar(10) DEFAULT NULL,
  `lieuvente` int(2) DEFAULT NULL,
  `dateop` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `bon_commande_produit`
--

CREATE TABLE `bon_commande_produit` (
  `id` int(11) NOT NULL,
  `id_prod` int(10) DEFAULT NULL,
  `id_bon` varchar(100) DEFAULT NULL,
  `quantite` float DEFAULT 0,
  `prix_achat` double DEFAULT NULL,
  `dateop` datetime DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `bulletin`
--

CREATE TABLE `bulletin` (
  `id` int(11) NOT NULL,
  `nom_client` varchar(155) NOT NULL,
  `libelles` varchar(155) NOT NULL,
  `numero` varchar(155) NOT NULL,
  `montant` double NOT NULL,
  `devise` varchar(10) NOT NULL DEFAULT 'gnf',
  `caissebul` int(11) NOT NULL,
  `lieuvente` varchar(10) NOT NULL,
  `date_versement` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `bulletin`
--

INSERT INTO `bulletin` (`id`, `nom_client`, `libelles`, `numero`, `montant`, `devise`, `caissebul`, `lieuvente`, `date_versement`) VALUES
(1, '1', 'report solde', 'ret', 0, 'gnf', 1, '1', '2024-01-11 00:00:00'),
(2, '2', 'report solde', 'ret', -14000000, 'gnf', 1, '1', '2024-01-11 00:00:00'),
(3, '3', 'report solde', 'ret', -10500000, 'gnf', 1, '1', '2024-01-11 00:00:00'),
(4, '4', 'report solde', 'ret', 0, 'gnf', 1, '1', '2024-01-11 00:00:00'),
(5, '5', 'report solde', 'ret', 0, 'gnf', 1, '1', '2024-01-11 00:00:00'),
(6, '6', 'report solde', 'ret', 8000000, 'gnf', 1, '1', '2024-01-11 00:00:00'),
(8, '7', 'report solde', 'ret', -25000000, 'gnf', 1, '1', '2024-01-11 00:00:00'),
(9, '8', 'report solde', 'ret', 0, 'gnf', 1, '1', '2024-01-11 00:00:00'),
(10, '6', 'ajustement solde', 'ret', 10000000, 'gnf', 1, '1', '2024-01-11 00:00:00'),
(86, '35', 'report solde', 'ret', -13275000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(12, '9', 'report solde', 'ret', 0, 'gnf', 1, '1', '2024-01-11 00:00:00'),
(13, '10', 'report solde', 'ret', 0, 'gnf', 1, '1', '2024-01-11 00:00:00'),
(14, '11', 'report solde', 'ret', 0, 'gnf', 1, '1', '2024-01-11 00:00:00'),
(15, '12', 'report solde', 'ret', 0, 'gnf', 1, '1', '2024-01-11 00:00:00'),
(16, '13', 'report solde', 'ret', 0, 'gnf', 1, '1', '2024-01-11 00:00:00'),
(17, '14', 'report solde', 'ret', 0, 'gnf', 1, '1', '2024-01-11 00:00:00'),
(18, '15', 'report solde', 'ret', 0, 'gnf', 1, '1', '2024-01-11 00:00:00'),
(19, '16', 'report solde', 'ret', 0, 'gnf', 1, '1', '2024-01-11 00:00:00'),
(82, '32', 'report solde', 'ret', -15630000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(22, '17', 'report solde', 'ret', 0, 'gnf', 1, '1', '2024-01-12 00:00:00'),
(23, '18', 'report solde', 'ret', 0, 'gnf', 1, '1', '2024-01-12 00:00:00'),
(24, '19', 'report solde', 'ret', 0, 'gnf', 1, '1', '2024-01-12 00:00:00'),
(25, '20', 'report solde', 'ret', 0, 'gnf', 1, '1', '2024-01-12 00:00:00'),
(26, '21', 'report solde', 'ret', 0, 'gnf', 1, '1', '2024-01-12 00:00:00'),
(27, '22', 'report solde', 'ret', 0, 'gnf', 1, '1', '2024-01-12 00:00:00'),
(81, '31', 'report solde', 'ret', -28680000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(80, '30', 'report solde', 'ret', -9930000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(32, '23', 'report solde', 'ret', 0, 'gnf', 1, '1', '2024-01-12 00:00:00'),
(33, '24', 'report solde', 'ret', 0, 'gnf', 1, '1', '2024-01-12 00:00:00'),
(34, '25', 'report solde', 'ret', 0, 'gnf', 1, '1', '2024-01-12 00:00:00'),
(78, '28', 'report solde', 'ret', -3860000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(77, '27', 'report solde', 'ret', -3900000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(76, '6', 'ajustement solde', 'ret', 18000000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(75, '5', 'ajustement solde', 'ret', 1000000000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(72, '6', 'ajustement solde', 'ret', -18000000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(71, '6', 'ajustement solde', 'ret', -18000000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(69, '5', 'ajustement solde', 'ret', -500000000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(70, '4', 'ajustement solde', 'ret', -1, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(85, '15', 'ajustement solde', 'ret', -17670000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(84, '34', 'report solde', 'ret', -3140000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(79, '29', 'report solde', 'ret', -21180000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(68, '26', 'ajustement solde', 'ret', -35500000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(73, '26', 'ajustement solde', 'ret', 35500000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(55, '4', 'inventeur1', 'editf5', 1, 'gnf', 1, '1', '2024-01-13 19:28:56'),
(83, '33', 'report solde', 'ret', -10350000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(60, '26', 'report solde', 'ret', 0, 'gnf', 1, '1', '2024-01-13 00:00:00'),
(67, '2', 'ajustement solde', 'ret', 14000000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(66, '3', 'ajustement solde', 'ret', 10500000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(65, '7', 'ajustement solde', 'ret', 25000000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(74, '5', 'ajustement solde', 'ret', -500000000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(87, '36', 'report solde', 'ret', -15650000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(88, '2', 'ajustement solde', 'ret', -6600000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(89, '37', 'report solde', 'ret', -10860000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(90, '38', 'report solde', 'ret', -11000000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(91, '39', 'report solde', 'ret', -15340000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(92, '40', 'report solde', 'ret', -4329000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(93, '41', 'report solde', 'ret', -19177000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(94, '42', 'report solde', 'ret', -3012000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(95, '3', 'ajustement solde', 'ret', -17815000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(96, '43', 'report solde', 'ret', -16240000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(97, '44', 'report solde', 'ret', -7484000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(98, '45', 'report solde', 'ret', -3625000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(99, '46', 'report solde', 'ret', -8030000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(100, '47', 'report solde', 'ret', -7295000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(101, '48', 'report solde', 'ret', -3660000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(102, '49', 'report solde', 'ret', -1600000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(103, '50', 'report solde', 'ret', -1235000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(104, '7', 'ajustement solde', 'ret', -15750000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(105, '51', 'report solde', 'ret', -6150000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(106, '52', 'report solde', 'ret', -48080000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(107, '16', 'ajustement solde', 'ret', -2942000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(108, '53', 'report solde', 'ret', -11520000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(109, '54', 'report solde', 'ret', -3200000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(110, '55', 'report solde', 'ret', -6150000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(111, '56', 'report solde', 'ret', -1911000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(112, '57', 'report solde', 'ret', -27534000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(113, '58', 'report solde', 'ret', -20100000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(114, '59', 'report solde', 'ret', 4800000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(115, '60', 'report solde', 'ret', 5485000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(116, '19', 'ajustement solde', 'ret', -5650000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(117, '61', 'report solde', 'ret', -8450000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(118, '62', 'report solde', 'ret', 1335000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(119, '63', 'report solde', 'ret', -4930000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(120, '64', 'report solde', 'ret', -3885000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(121, '65', 'report solde', 'ret', -3210000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(122, '66', 'report solde', 'ret', -1300000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(123, '60', 'ajustement solde', 'ret', -5485000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(124, '62', 'ajustement solde', 'ret', -1335000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(125, '60', 'ajustement solde', 'ret', -5485000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(126, '62', 'ajustement solde', 'ret', -1335000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(127, '67', 'report solde', 'ret', -800000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(128, '68', 'report solde', 'ret', 3198000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(129, '69', 'report solde', 'ret', -12000000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(130, '70', 'report solde', 'ret', -12815000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(131, '68', 'ajustement solde', 'ret', -6396000, 'gnf', 1, '1', '2024-01-14 00:00:00'),
(132, '28', 'ajustement solde', 'ret', -20725000, 'gnf', 1, '1', '2024-01-15 00:00:00'),
(133, '28', 'ajustement solde', 'ret', -49170000, 'gnf', 1, '1', '2024-01-15 00:00:00'),
(134, '28', 'ajustement solde', 'ret', -3245000, 'gnf', 1, '1', '2024-01-15 00:00:00'),
(135, '28', 'ajustement solde', 'ret', 60000000, 'gnf', 1, '1', '2024-01-15 00:00:00'),
(136, '71', 'report solde', 'ret', 0, 'gnf', 1, '1', '2024-01-15 00:00:00'),
(137, '46', 'peyement facture', 'dep1', 8030000, 'gnf', 1, '1', '2024-01-15 10:43:39'),
(138, '72', 'report solde', 'ret', -666000, 'gnf', 1, '1', '2024-01-15 00:00:00'),
(139, '73', 'report solde', 'ret', -552000, 'gnf', 1, '1', '2024-01-15 00:00:00'),
(140, '14', 'ajustement solde', 'ret', -21775000, 'gnf', 1, '1', '2024-01-15 00:00:00'),
(141, '71', 'ajustement solde', 'ret', -5410000, 'gnf', 1, '1', '2024-01-15 00:00:00'),
(142, '74', 'report solde', 'ret', -4000000, 'gnf', 1, '1', '2024-01-15 00:00:00'),
(143, '75', 'report solde', 'ret', -45625000, 'gnf', 1, '1', '2024-01-15 00:00:00'),
(144, '76', 'report solde', 'ret', -2180000, 'gnf', 1, '1', '2024-01-15 00:00:00'),
(145, '77', 'report solde', 'ret', -3600000, 'gnf', 1, '1', '2024-01-15 00:00:00'),
(146, '78', 'report solde', 'ret', -4445000, 'gnf', 1, '1', '2024-01-15 00:00:00'),
(147, '10', 'ajustement solde', 'ret', -11210000, 'gnf', 1, '1', '2024-01-15 00:00:00'),
(148, '79', 'report solde', 'ret', -2500000, 'gnf', 1, '1', '2024-01-15 00:00:00'),
(149, '80', 'report solde', 'ret', 0, 'gnf', 1, '1', '2024-01-15 00:00:00'),
(150, '81', 'report solde', 'ret', -2167000, 'gnf', 1, '1', '2024-01-15 00:00:00'),
(151, '82', 'report solde', 'ret', -1105000, 'gnf', 1, '1', '2024-01-15 00:00:00'),
(152, '83', 'report solde', 'ret', -11755500, 'gnf', 1, '1', '2024-01-15 00:00:00'),
(153, '84', 'report solde', 'ret', -25373000, 'gnf', 1, '1', '2024-01-15 00:00:00'),
(154, '85', 'report solde', 'ret', -14240000, 'gnf', 1, '1', '2024-01-15 00:00:00'),
(155, '77', 'PAYEMENT FACTUR', 'dep8', 2000000, 'gnf', 1, '1', '2024-01-15 15:57:01'),
(156, '86', 'report solde', 'ret', -7600000, 'gnf', 1, '1', '2024-01-15 00:00:00'),
(157, '17', 'ajustement solde', 'ret', -5900000, 'gnf', 1, '1', '2024-01-15 00:00:00'),
(158, '87', 'report solde', 'ret', -1340000, 'gnf', 1, '1', '2024-01-15 00:00:00'),
(159, '88', 'report solde', 'ret', -2000000, 'gnf', 1, '1', '2024-01-15 00:00:00'),
(160, '89', 'report solde', 'ret', -11310000, 'gnf', 1, '1', '2024-01-15 00:00:00'),
(161, '90', 'report solde', 'ret', 0, 'gnf', 1, '1', '2024-01-15 00:00:00'),
(162, '91', 'report solde', 'ret', 0, 'gnf', 1, '1', '2024-01-15 00:00:00'),
(163, '92', 'report solde', 'ret', 0, 'gnf', 1, '1', '2024-01-15 00:00:00'),
(164, '93', 'report solde', 'ret', 0, 'gnf', 1, '1', '2024-01-15 00:00:00'),
(165, '94', 'report solde', 'ret', 0, 'gnf', 1, '1', '2024-01-15 00:00:00'),
(166, '95', 'report solde', 'ret', 0, 'gnf', 1, '1', '2024-01-15 00:00:00'),
(167, '96', 'report solde', 'ret', 0, 'gnf', 1, '1', '2024-01-15 00:00:00'),
(168, '97', 'report solde', 'ret', 0, 'gnf', 1, '1', '2024-01-15 00:00:00'),
(169, '98', 'report solde', 'ret', 0, 'gnf', 1, '1', '2024-01-15 00:00:00'),
(170, '99', 'report solde', 'ret', 3600000, 'gnf', 1, '1', '2024-01-16 00:00:00'),
(171, '100', 'report solde', 'ret', -20055000, 'gnf', 1, '1', '2024-01-16 00:00:00'),
(172, '99', 'ajustement solde', 'ret', -7200000, 'gnf', 1, '1', '2024-01-16 00:00:00'),
(173, '101', 'report solde', 'ret', -13270000, 'gnf', 1, '1', '2024-01-16 00:00:00'),
(174, '102', 'report solde', 'ret', -26985000, 'gnf', 1, '1', '2024-01-16 00:00:00'),
(175, '103', 'report solde', 'ret', -2580000, 'gnf', 1, '1', '2024-01-16 00:00:00'),
(176, '77', 'Payement facture ', 'dep9', 1600000, 'gnf', 1, '1', '2024-01-16 00:00:00'),
(177, '104', 'report solde', 'ret', -1250000, 'gnf', 1, '1', '2024-01-16 00:00:00'),
(178, '105', 'report solde', 'ret', -8470000, 'gnf', 1, '1', '2024-01-16 00:00:00'),
(179, '106', 'report solde', 'ret', -4190000, 'gnf', 1, '1', '2024-01-16 00:00:00'),
(180, '107', 'report solde', 'ret', -1500000, 'gnf', 1, '1', '2024-01-16 00:00:00'),
(181, '108', 'report solde', 'ret', -3450000, 'gnf', 1, '1', '2024-01-16 00:00:00'),
(182, '109', 'report solde', 'ret', -10381000, 'gnf', 1, '1', '2024-01-16 00:00:00'),
(183, '110', 'report solde', 'ret', -2430000, 'gnf', 1, '1', '2024-01-16 00:00:00'),
(184, '111', 'report solde', 'ret', -5000000, 'gnf', 1, '1', '2024-01-16 00:00:00'),
(185, '112', 'report solde', 'ret', -800000, 'gnf', 1, '1', '2024-01-16 00:00:00'),
(186, '113', 'report solde', 'ret', -3150000, 'gnf', 1, '1', '2024-01-16 00:00:00'),
(187, '114', 'report solde', 'ret', -7475000, 'gnf', 1, '1', '2024-01-16 00:00:00'),
(188, '115', 'report solde', 'ret', -3825000, 'gnf', 1, '1', '2024-01-16 00:00:00'),
(189, '116', 'report solde', 'ret', -25850000, 'gnf', 1, '1', '2024-01-16 00:00:00'),
(190, '117', 'report solde', 'ret', -1980000, 'gnf', 1, '1', '2024-01-16 00:00:00'),
(191, '118', 'report solde', 'ret', -1850000, 'gnf', 1, '1', '2024-01-16 00:00:00'),
(192, '11', 'ajustement solde', 'ret', -5965000, 'gnf', 1, '1', '2024-01-16 00:00:00'),
(193, '119', 'report solde', 'ret', -29825000, 'gnf', 1, '1', '2024-01-16 00:00:00'),
(194, '120', 'report solde', 'ret', -1360000, 'gnf', 1, '1', '2024-01-16 00:00:00'),
(195, '121', 'report solde', 'ret', -1800000, 'gnf', 1, '1', '2024-01-16 00:00:00'),
(196, '122', 'report solde', 'ret', -4380000, 'gnf', 1, '1', '2024-01-16 00:00:00'),
(197, '123', 'report solde', 'ret', -2212000, 'gnf', 1, '1', '2024-01-16 00:00:00'),
(198, '16', 'Payement facture ', 'dep10', 2942000, 'gnf', 1, '1', '2024-01-16 20:06:25'),
(199, '16', 'ajustement solde', 'ret', -3970000, 'gnf', 1, '1', '2024-01-16 00:00:00'),
(200, '124', 'report solde', 'ret', -5860000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(201, '94', 'ajustement solde', 'ret', -4811500, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(202, '125', 'report solde', 'ret', -11985000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(203, '126', 'report solde', 'ret', -3786000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(204, '127', 'report solde', 'ret', -800000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(205, '128', 'report solde', 'ret', -400000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(206, '129', 'report solde', 'ret', -54000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(207, '130', 'report solde', 'ret', -30000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(208, '131', 'report solde', 'ret', -250000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(209, '132', 'report solde', 'ret', -400000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(210, '133', 'report solde', 'ret', -6161000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(211, '134', 'report solde', 'ret', -1688000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(212, '135', 'report solde', 'ret', -4300000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(213, '95', 'ajustement solde', 'ret', -360000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(214, '136', 'report solde', 'ret', -482000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(215, '137', 'report solde', 'ret', -180000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(216, '138', 'report solde', 'ret', -400000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(217, '139', 'report solde', 'ret', -628824421, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(218, '140', 'report solde', 'ret', -500000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(219, '141', 'report solde', 'ret', -2000000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(220, '98', 'ajustement solde', 'ret', -2766000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(221, '142', 'report solde', 'ret', -328000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(222, '143', 'report solde', 'ret', -472000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(223, '144', 'report solde', 'ret', -367000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(224, '145', 'report solde', 'ret', -1495000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(225, '146', 'report solde', 'ret', -331000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(226, '147', 'report solde', 'ret', -255000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(227, '148', 'report solde', 'ret', -2563000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(228, '149', 'report solde', 'ret', -1800000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(229, '150', 'report solde', 'ret', -800000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(230, '151', 'report solde', 'ret', -1230000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(231, '97', 'ajustement solde', 'ret', -1760000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(232, '152', 'report solde', 'ret', -300000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(233, '153', 'report solde', 'ret', -340000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(234, '154', 'report solde', 'ret', -4395000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(235, '155', 'report solde', 'ret', -1580000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(236, '156', 'report solde', 'ret', -83000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(237, '157', 'report solde', 'ret', 0, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(238, '157', 'ajustement solde', 'ret', -280000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(239, '158', 'report solde', 'ret', -2774000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(240, '91', 'ajustement solde', 'ret', -3564000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(241, '159', 'report solde', 'ret', -1120000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(242, '159', 'ajustement solde', 'ret', -2120000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(243, '159', 'ajustement solde', 'ret', 1120000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(244, '160', 'report solde', 'ret', -400000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(245, '161', 'report solde', 'ret', -1820000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(246, '162', 'report solde', 'ret', -2048000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(247, '96', 'ajustement solde', 'ret', -1908000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(248, '163', 'report solde', 'ret', -2525000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(249, '164', 'report solde', 'ret', -35000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(250, '90', 'ajustement solde', 'ret', -800000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(251, '165', 'report solde', 'ret', -1400000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(252, '166', 'report solde', 'ret', -1000000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(253, '167', 'report solde', 'ret', -1400000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(254, '168', 'report solde', 'ret', -2506000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(255, '169', 'report solde', 'ret', -1560000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(256, '170', 'report solde', 'ret', -2380000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(257, '171', 'report solde', 'ret', -1149000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(258, '172', 'report solde', 'ret', -1325000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(259, '173', 'report solde', 'ret', -4600000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(260, '174', 'report solde', 'ret', -280000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(261, '175', 'report solde', 'ret', -7655000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(262, '176', 'report solde', 'ret', -90000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(263, '177', 'report solde', 'ret', -534000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(264, '178', 'report solde', 'ret', -1000000, 'gnf', 1, '1', '2024-01-17 00:00:00'),
(265, '1', 'reste à payer', 'acf240018', 0, 'gnf', 1, '1', '2024-01-18 09:04:35'),
(266, '1', 'reste à payer', 'acf240019', 0, 'gnf', 1, '1', '2024-01-18 09:09:52'),
(267, '1', 'reste à payer', 'acf240020', 0, 'gnf', 1, '1', '2024-01-18 09:11:41'),
(268, '1', 'reste à payer', 'acf240021', 0, 'gnf', 1, '1', '2024-01-18 09:21:54'),
(269, '1', 'reste à payer', 'acf240022', 0, 'gnf', 1, '1', '2024-01-18 09:34:01'),
(270, '38', 'ajustement solde', 'ret', 5900000, 'gnf', 1, '1', '2024-01-18 00:00:00'),
(271, '38', 'Payment Facture', 'dep11', 5100000, 'gnf', 1, '1', '2024-01-18 09:49:01'),
(272, '1', 'reste à payer', 'acf240023', 0, 'gnf', 1, '1', '2024-01-18 09:54:35'),
(273, '179', 'report solde', 'ret', 0, 'gnf', 1, '1', '2024-01-18 00:00:00'),
(274, '179', 'Achat de vimto', 'editf7', 28500000, 'gnf', 1, '1', '2024-01-18 11:41:14'),
(275, '1', 'reste à payer', 'acf240024', 0, 'gnf', 1, '1', '2024-01-18 12:30:34'),
(276, '180', 'report solde', 'ret', -1835000, 'gnf', 1, '1', '2024-01-18 00:00:00'),
(277, '1', 'reste à payer', 'acf240025', 0, 'gnf', 1, '1', '2024-01-18 12:56:56'),
(278, '1', 'reste à payer', 'acf240026', 0, 'gnf', 1, '1', '2024-01-18 13:16:00'),
(279, '51', 'payement facture', 'dep12', 4000000, 'gnf', 1, '1', '2024-01-18 13:18:56'),
(280, '1', 'reste à payer', 'acf240027', 0, 'gnf', 1, '1', '2024-01-18 13:58:35'),
(281, '52', 'reste à payer', 'acf240028', -7800000, 'gnf', 1, '1', '2024-01-18 16:06:57'),
(282, '81', 'Payement facture ', 'dep13', 150000, 'gnf', 1, '1', '2024-01-18 16:31:00'),
(283, '1', 'reste à payer', 'acf240029', 0, 'gnf', 1, '1', '2024-01-18 00:00:00'),
(284, '41', 'reste à payer', 'acf240030', -9155000, 'gnf', 1, '1', '2024-01-18 00:00:00'),
(285, '12', 'ajustement solde', 'ret', -3150000, 'gnf', 1, '1', '2024-01-18 00:00:00'),
(286, '52', 'Payement facture ', 'dep14', 30000000, 'gnf', 1, '1', '2024-01-18 00:00:00'),
(287, '1', 'reste à payer', 'acf240031', 0, 'gnf', 1, '1', '2024-01-18 20:32:00'),
(288, '1', 'reste à payer', 'acf240032', 0, 'gnf', 1, '1', '2024-01-18 20:45:39'),
(289, '1', 'reste à payer', 'acf240033', 0, 'gnf', 1, '1', '2024-01-18 21:20:47'),
(290, '38', 'reste à payer', 'acf240034', -9150000, 'gnf', 1, '1', '2024-01-18 21:23:10');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `nom` varchar(150) NOT NULL,
  `nbrevente` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `nom`, `nbrevente`) VALUES
(1, 'JUS MESSI', NULL),
(2, 'JUS ZAZA', NULL),
(3, 'JUS VANDAM', NULL),
(4, 'JUS RAMA', NULL),
(5, 'JUS', NULL),
(6, 'MAYONNAISE CIAO', NULL),
(7, 'Beurre Ciao', NULL),
(8, 'JUS TROIS JOURS', NULL),
(17, 'Savon Ciao', NULL),
(11, 'JUS DE FRUITS', NULL),
(15, 'Tiktok', NULL),
(14, 'Huile Ciao', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `categoriedep`
--

CREATE TABLE `categoriedep` (
  `id` int(11) NOT NULL,
  `nom` varchar(150) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `categoriedep`
--

INSERT INTO `categoriedep` (`id`, `nom`) VALUES
(1, 'Depense journaliere'),
(2, 'Debarquement'),
(3, 'Déplacement de stock'),
(4, 'Transport et embarquement'),
(5, 'Payement de loyer magasin'),
(6, 'Payement de loyer stock de Alseny'),
(7, 'Payement de loyer de stock du patron'),
(8, 'Electricité'),
(9, 'EAU'),
(10, 'Depense Famille'),
(11, 'Depense Personnel');

-- --------------------------------------------------------

--
-- Structure de la table `categorieperte`
--

CREATE TABLE `categorieperte` (
  `id` int(11) NOT NULL,
  `nom` varchar(150) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `categorieperte`
--

INSERT INTO `categorieperte` (`id`, `nom`) VALUES
(1, 'Ajustement du stock');

-- --------------------------------------------------------

--
-- Structure de la table `categorierecette`
--

CREATE TABLE `categorierecette` (
  `id` int(11) NOT NULL,
  `nom` varchar(150) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `chequedepasse`
--

CREATE TABLE `chequedepasse` (
  `id` int(11) NOT NULL,
  `numcheque` varchar(50) NOT NULL,
  `montant` double NOT NULL,
  `dateencaissement` datetime NOT NULL,
  `id_banque` int(11) NOT NULL,
  `lieuvente` varchar(50) DEFAULT NULL,
  `dateop` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `nom_client` varchar(155) NOT NULL,
  `telephone` varchar(15) NOT NULL,
  `adresse` varchar(100) DEFAULT NULL,
  `typeclient` varchar(100) NOT NULL,
  `mail` varchar(50) DEFAULT NULL,
  `positionc` int(11) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `nom_client`, `telephone`, `adresse`, `typeclient`, `mail`, `positionc`) VALUES
(1, 'Client Journalier', '001', 'Trois Avril', 'client', '', 1),
(2, 'IBRAHIMA HABILAYA', '622010085', 'HABILAYA', 'client', '', 1),
(3, 'ALADJI MOUSSA HABILAYA', '627019461', 'HABILAYA', 'client', '', 1),
(4, 'Fournisseur Cash', '002', '3 Avril', 'fournisseur', '', 1),
(5, 'mamadou alpha sow', '621816667', 'conakry cobaya', 'fournisseur', '', 1),
(6, 'badara', '003', 'comoya', 'Employer', '', 1),
(7, 'Aladji abdoulaye bisigui', '628592347', 'Bisigui', 'client', '', 1),
(8, 'chinois U-Freche', '666772222', 'coyah', 'fournisseur', '', 1),
(9, 'Aladji fode', '622210070', 'boucheri', 'client', '', 1),
(10, 'hadia aista boucheri', '627909543', 'boucheri', 'client', '', 1),
(11, 'Moussa drame boucheri', '626366947', 'boucheri', 'client', '', 1),
(12, 'kadiatou koulibali', '621967890', 'calefour bad boy', 'client', '', 1),
(71, 'marouwana bisigui', '624180811', 'bisigui', 'client', '', 1),
(14, 'Thierno mamadou trois avrile', '627291029', 'Trois Avril', 'client', '', 1),
(15, 'Oustage aliou yenguema', '622219522', 'yenguem', 'client', '', 1),
(16, 'Habit habilaya ', '622443181', 'HABILAYA', 'client', '', 1),
(17, 'Thierno dian leycompognie', '620692060', 'Au marche leycompognie', 'client', '', 1),
(18, 'younoussa bisigui', '627060930', 'bisigui', 'client', '', 1),
(19, 'saliou  pti fre  de tella', '626014597', 'Bisigui', 'client', '', 1),
(20, 'Kaba boucheri', '625829496', 'boucheri', 'client', '', 1),
(21, 'kaba kalefour', '622641212', 'kalefour', 'client', '', 1),
(22, 'ALSENY 24H', '626464616', 'Conakry kindia', 'clientf', '', 1),
(23, 'BANQUE MARCO', '622988619', 'Badboy', 'Banque', '', 1),
(24, 'BANQUE ISLAMIQUE', '620193139', 'BOUCHERIE', 'Banque', '', 1),
(25, 'VISTA GUI', '005', 'Leycompognie', 'Banque', '', 1),
(26, 'mamadou bhoye banga', '628882839', 'sambaya', 'clientf', '', 1),
(27, 'Souabou EDG', '620971288', 'EDG', 'client', '', 1),
(28, 'Mamadou saliou caravance', '628205013', 'Caravanceraye', 'client', '', 1),
(29, 'Tahirou labe1', '625063146', 'CEFAO', 'client', '', 1),
(30, 'Mariama telly', '628965505', 'Acote pharmaci djogo', 'client', '', 1),
(31, 'Boubacar fils de Aladji abdoulaye', '628690706', 'Bisigui', 'client', '', 1),
(32, 'Madam barry  salimatou', '620985752', '03avrile', 'client', '', 1),
(33, 'Petit barry 1', '620694314', 'Bisigui', 'client', '', 1),
(34, 'Th oumar boucheri', '624802649', 'Trois Avril', 'client', '', 1),
(35, 'souleymane orange money', '622089602', 'yewole', 'client', '', 1),
(36, 'Malike contournente', '625834444', 'contournente', 'client', '', 1),
(37, 'Alpha oumare couzbela', '629269609', 'garvature telimile', 'client', '', 1),
(38, 'Aladji abdramane kabakadou', '628118544', 'CEFAO', 'client', '', 1),
(39, 'Thierno saidou leycompogni', '620690025', 'Leycompognie', 'client', '', 1),
(40, 'Mamadoou saliou tapiyoka', '624321142', 'tapiyoka', 'client', '', 1),
(41, 'Mamadou barka', '625421442', 'livraport', 'client', '', 1),
(42, 'Aladji ibrahima gart', '625647224', 'gart', 'client', '', 1),
(43, 'Lansana kaba boucheri', '629536612', 'boucheri', 'client', '', 1),
(44, 'Mody bobo yenguema', '623332233', 'yenguema', 'client', '', 1),
(45, 'Ibrahima sory dadiya', '627178000', 'Dadiya', 'client', '', 1),
(46, 'Boubacar petit frere de Arian comoya', '622985506', 'comoya virage dangereux', 'client', '', 1),
(47, 'Moustafa', '625118603', 'wondi', 'client', '', 1),
(48, 'ALADJI KALILOU PKLANETE', '628543137', 'Leycompognie', 'client', '', 1),
(49, 'LAMINE 3X', '628881944', 'Acote pharmaci djogo', 'client', '', 1),
(50, 'MAMADOU BENTAIT', '628370396', 'garvature telimile', 'client', '', 1),
(51, 'MODY AMADOU YEWOLE VIEUX', '621354540', 'yewole', 'client', '', 1),
(52, 'ALADJI TELLA BISIGUI', '621995871', 'Bisigui', 'client', '', 1),
(53, 'IBRAHIMA SORY BISIGUI', '626151304', 'Bisigui', 'client', '', 1),
(54, 'MAMADOU LAMINE DEGOLE', '626135556', 'sambaya', 'client', '', 1),
(55, 'IBRAHIMA BILESIMPI', '620114374', 'CEFAO', 'client', '', 1),
(56, 'MADAM DIALLO AISTA CONTOURNENTE', '628448649', 'contournente', 'client', '', 1),
(57, 'MAMADOU DIAN COMOYA', '623660859', 'comoya', 'client', '', 1),
(58, 'MAJIDE SALAME', '627171712', 'Trois Avril', 'client', '', 1),
(59, 'ANAFIOU SALL ROYAL', '625732336', 'boucheri', 'autres', '', 1),
(60, 'ALADJI ALIOU GARGASAKI', '623119203', 'HABILAYA', 'client', '', 1),
(61, 'ALADJI SOULEYMANE YEWOLE', '620632968', 'yewole', 'client', '', 1),
(62, 'ALADJI AMADOU YENGUEMA  VIEUX', '621206311', 'HABILAYA', 'client', '', 1),
(63, 'ALPHA BARRY PITA', '625825773', 'Wambelle', 'client', '', 1),
(64, 'OUSTAGE BOUBACAR LEYCOMPOGNI', '621776741', 'Leycompognie', 'client', '', 1),
(65, 'BOUBACAR BARRY LEYCOMPOGNI', '629257180', 'Leycompognie', 'client', '', 1),
(66, 'OURY YENGUEMA', '621079556', 'yenguema', 'client', '', 1),
(67, 'IBRHIMA SAOUDIEN', '620299059', 'CEFAO', 'client', '', 1),
(68, 'MANSARE DADIYA', '620963739', 'Dadiya', 'client', '', 1),
(69, 'MOUSTAFA LEYCOMPOGNI', '629191312', 'Leycompognie', 'client', '', 1),
(70, 'AMADOU SADIO HOREKELIWOL', '628574913/62311', 'HOREKILIWOL', 'client', '', 1),
(72, 'Mere de adama kaniagic debelle', '620694151', 'debelle', 'client', '', 1),
(73, 'mere de adama debellen', '625244847', 'debellen', 'client', '', 1),
(74, 'Idrissa contournante', '625920433', 'contournente', 'client', '', 1),
(75, 'Alhassana contournante', '623466920', 'contournente', 'client', '', 1),
(76, 'Atigou Dadiya', '628283118', 'Dadiya', 'client', '', 1),
(77, 'Mouctar Cosmetique', '620768261', 'Wambelle', 'client', '', 1),
(78, 'Oumar a cote de Saoudien', '625009220', 'Leycompognie', 'client', '', 1),
(79, 'mounir bad boye', '625225905', 'bad boye', 'client', '', 1),
(80, 'Kadiatou Worgoto', '629123819', 'En face Pharmacie Djogo', 'client', '', 1),
(81, 'Mister Barry Sambaya', '621597246', 'sambaya', 'client', '', 1),
(82, 'mousier diallo Africana', '621185168', 'Africana', 'client', '', 1),
(83, 'Alpha Pipool', '621654450', 'Caravance', 'client', '', 1),
(84, 'Souleymane Jus', '623118128', 'Pavion Bleu', 'client', '', 1),
(85, 'Ousmane Hénéré', '628503799', 'livraport', 'client', '', 1),
(86, 'RAMADANE HORE KOUMA', '622689602', 'CONTOURNANTE', 'client', '', 1),
(87, 'ALPHA IBRAHIMA V DE LIBANAI', '624512674', 'TROIS AVRIL', 'client', '', 1),
(88, 'OUSTAGE A COTE DE MAROUANE', '662602846', 'Bisigui', 'client', '', 1),
(89, 'YAYA HABILAYA', '625931247', 'HABILAYA', 'client', '', 1),
(90, 'Mr Mamadou alpha Telimil&eacute; ', '621402149', 'Comoya ', 'client', '', 1),
(91, 'Hadia Bintou Casia ', '623668082', 'Casia ', 'client', '', 1),
(92, 'Bintou Galiagori ', '624217571', 'Galiagori ', 'client', '', 1),
(93, 'Oncle ABdoulaye kourou', '623591817', 'Comoya virage dangereux ', 'client', '', 1),
(94, 'Oury mon amis depuis Dallaba ', '620135516', 'Comoya virage dangereux ', 'client', '', 1),
(95, 'Diadia Oumou Dallaba comoya', '628630516', 'Comoya ', 'client', '', 1),
(96, 'Oumou Hawa Bisigui ', '1817', 'Bisigui ', 'client', '', 1),
(97, 'Madam barry Colenten ', '622137353', 'Colenten ', 'client', '', 1),
(98, 'Syla Caravanceraye ', '623272774', 'Caravanceraye ', 'client', '', 1),
(99, 'Thierno Guidho ', '624252318', 'CEFAO ', 'client', '', 1),
(100, 'Yousoufou Leycompagni ', '621275332', 'Leycompagni ', 'client', '', 1),
(101, 'Thierno Thiougué Bounanya', '623115598', 'En face Pharmacie Djogo', 'client', '', 1),
(102, 'Baillo Dounké', '621071003', 'Leycompognie', 'client', '', 1),
(103, 'Ly Djoungole', '628626991', 'Leycompognie', 'client', '', 1),
(104, 'Fatoumata Diaby', '007', 'En face 3 avril', 'client', '', 1),
(105, 'Thierno Mamadou Yéro', '623325732', 'CEFAO', 'client', '', 1),
(106, 'Djénabou Kaba', '624626385', 'Bad boye', 'client', '', 1),
(107, 'Madiou Yenguéma', '622136513', 'Yengu&eacute;ma', 'client', '', 1),
(108, 'Boubacar Nestlé', '625002626', 'Wambelle', 'client', '', 1),
(109, 'Ibrahima Kilé', '623717284', 'CEFAO', 'client', '', 1),
(110, 'Thierno Boubacar ly', '623180009', 'Banque Islamique', 'client', '', 1),
(111, 'Alhassane Dramé Guaranti Kabagai', '628511561', 'CEFAO', 'client', '', 1),
(112, 'Alpha Amadou Baldé', '008', 'yenguema', 'client', '', 1),
(113, 'kadiatou koulibali et Binta', '621979447', 'Bad boye', 'client', '', 1),
(114, 'Oumar Barry Boucherie', '623094344', 'Boucherie', 'client', '', 1),
(115, 'Petit Frère de Thierno Nouhou', '628858057', 'HABILAYA', 'client', '', 1),
(116, 'Oury Kaliyakhori', '610132336', 'Kaliyakhori', 'client', '', 1),
(117, 'Kaba Bagin', '621861796', 'Wambelle', 'client', '', 1),
(118, 'Ibrahima Café ', '628005525', 'yewole', 'client', '', 1),
(119, 'Thierno sadou Comoya', '623404160', 'Leycompognie', 'client', '', 1),
(120, 'Boubacar Bounanya', '009', 'Leycompognie', 'client', '', 1),
(121, 'Nen Bilguissa', '624506555', 'comoya virage dangereux', 'client', '', 1),
(122, 'Mamoudou Dihoye', '625110526', 'Leycompognie', 'client', '', 1),
(123, 'Abdoulaye Diallo Djoma Diawdi', '624093453', 'Leycompognie', 'client', '', 1),
(124, 'Mouctar Contournente ', '622966591', 'Contournante ', 'client', '', 1),
(125, 'djenabou livraison', '25', 'livraport', 'client', '', 1),
(126, 'djenabou drame madina woula', '628992828', 'madina woula', 'client', '', 1),
(127, 'Alphadjo barry comoya', '620785924', 'comoya ', 'client', '', 1),
(128, 'boubacar diallo habilaya', '628778834', 'HABILAYA', 'client', '', 1),
(129, 'Oumare beavogui sinaniya', '620751534', 'sinaniya', 'client', '', 1),
(130, 'Boubacar  diallo police routier', '627021943', 'AU MARCHE', 'client', '', 1),
(131, 'Mody boubacar CEFAO', '622560073', 'CEFAO', 'client', '', 1),
(132, 'Mody ibrahima barry bounenya', '55', 'CEFAO', 'client', '', 1),
(133, 'Yagouba diallo wondi enseignant', '628956621', 'wondi', 'client', '', 1),
(134, 'Alpha oumare comoya a cote dian', '627811428', 'comoya banbo keba', 'client', '', 1),
(135, 'Vieux linsant ', '621198812', 'Linsan', 'client', '', 1),
(136, 'Kadiatou comoya ', '623788833', 'Comoya ', 'client', '', 1),
(137, 'Abdoulaye camara Dambagania ', '622439282', 'Dambagania ', 'client', '', 1),
(138, 'Mamadou bobo katakata', '627959598', 'Sambaya ', 'client', '', 1),
(139, 'Saidou yaiki Sambaya ', '628824421', 'Sambaya ', 'client', '', 1),
(140, 'Toure orange money', '626864646', 'Gart', 'client', '', 1),
(141, 'Oncle Sadialiou à côté de lamine', '620996893', '&Agrave; c&ocirc;t&eacute; pharmacie djogo', 'client', '', 1),
(142, 'Idiatou Bisigui ', '623179625', 'Bisigui ', 'client', '', 1),
(143, 'Alpha Aliou Comoya ', '06', 'Comoya virage dangereux ', 'client', '', 1),
(144, 'Dianee Mangoya ', '622801631', 'Mangoya ', 'client', '', 1),
(145, 'Americain Boucheri ', '08', 'Boucheri ', 'client', '', 1),
(146, 'Ibrahima Kilee à côté tob', '98', '&Agrave; c&ocirc;t&eacute; tobe', 'client', '', 1),
(147, 'Fofana Condeta3 ', '625829892', 'Condeta3 ', 'client', '', 1),
(148, 'Yaya camokouye ', '099', 'Kenpou camkouye', 'client', '', 1),
(149, 'Mamadou alpha voix', '623784017', 'Habilaya ', 'client', '', 1),
(150, 'Thieoro  dadiya', '628892588', 'Dadiya ecole', 'client', '', 1),
(151, 'Habibatou Diallo Fuirguiabe ', '626402697', 'Fuirguiabe ', 'client', '', 1),
(152, 'Tanti Fatoumata Maitresse  comoya ', '664432642', 'Comya ', 'client', '', 1),
(153, 'Ibrahima barry comoya jeune ', '626950213', 'Comoya ', 'client', '', 1),
(154, 'Thierno Mawiatou comoya ', '627252809', 'Comoya virage dangereux ', 'client', '', 1),
(155, 'Thierno Saidou amis de kourou ', '90', 'Yenguema ', 'client', '', 1),
(156, 'Vieux Koumbourou ', '622085697', 'Koumbourou ', 'client', '', 1),
(157, 'Bah Mamadou Saliou mogoya', '621182679', 'Mangoya ', 'client', '', 1),
(158, 'Tanti Aissa Livraport ', '621408292', 'Livraport ', 'client', '', 1),
(159, 'Alpha Oumar barry cohien', '89', 'Boucherie ', 'client', '', 1),
(160, 'Thierno Saidou sow kourawi ', '45', 'Bisigui ', 'client', '', 1),
(161, 'Boubacar fils de galle Bourouwi ', '623178297', 'Comoya bambo Keba ', 'client', '', 1),
(162, 'Ibrahima Kendouma ', '628879239', 'En ville Bananie ', 'client', '', 1),
(163, 'Monsieur Souleymane Foulayah ', '622747454', 'Galiagori ', 'client', '', 1),
(164, 'Diariou cliente d’étaile ', '78', 'March&eacute; ', 'client', '', 1),
(165, 'Ansoumane syla Wondi ', '611318427', 'Wondi ', 'client', '', 1),
(166, 'Sow orange money ', '622989967', 'Leycompagni ', 'client', '', 1),
(167, 'Monsieur ly à côté de Soul jus ', '610047174', 'Bavion-bleu', 'client', '', 1),
(168, 'Ibrahima comoya ', '623946830', 'Kalifour Yewole', 'client', '', 1),
(169, 'Frère de Aladji moussa Habilaya ', '627137418', 'Bisigui ', 'client', '', 1),
(170, 'Mamadou Djoulde boucheri', '610429239', 'Boucherie ', 'client', '', 1),
(171, 'Hawa Thiam ', '620269367', 'Kalefour Mangoya ', 'client', '', 1),
(172, 'Bobo Pouly ', '633784094', 'Wambel ', 'client', '', 1),
(173, 'Ismael Leycompagni ', '628330795', 'Leycompagni ', 'client', '', 1),
(174, 'Kadiatou bah 03avrile ', '11', '03avril ', 'client', '', 1),
(175, 'Aista Phalesarai  TapiyoKa ', '7655000', 'Tapiyoka ', 'client', '', 1),
(176, 'Ma binty planète ', '620042040', 'Flamboyant ', 'client', '', 1),
(177, 'Ramatoulaye Sambaya ', '628457208', 'Sambaya ', 'client', '', 1),
(178, 'Mamadou alpha Winda ', '612877074', 'CEFAO ', 'client', '', 1),
(179, 'Thierno Abdoule', '622025654', 'Bisigui', 'clientf', '', 1),
(180, 'Diarahie comoya', '622276378', 'comoya estation ', 'client', '', 1);

-- --------------------------------------------------------

--
-- Structure de la table `clientrelance`
--

CREATE TABLE `clientrelance` (
  `id` int(11) NOT NULL,
  `idclient` int(10) NOT NULL,
  `idpers` int(10) NOT NULL,
  `message` varchar(500) NOT NULL,
  `rappel` int(11) NOT NULL DEFAULT 0,
  `daterelance` date DEFAULT NULL,
  `dateop` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cloture`
--

CREATE TABLE `cloture` (
  `id` int(11) NOT NULL,
  `date_cloture` date NOT NULL,
  `nbre_cmd` int(15) NOT NULL,
  `tot_cmd` float NOT NULL,
  `benefice` float NOT NULL,
  `tot_caisse` float NOT NULL,
  `tot_saisie` float NOT NULL,
  `difference` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id` int(11) NOT NULL,
  `id_produit` int(11) DEFAULT NULL,
  `prix_vente` double NOT NULL,
  `prix_achat` double DEFAULT 0,
  `prix_revient` double DEFAULT 0,
  `quantity` int(11) NOT NULL,
  `qtiteliv` int(11) DEFAULT 0,
  `etatlivcmd` varchar(10) DEFAULT 'nonlivre',
  `num_cmd` varchar(50) NOT NULL,
  `id_client` int(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id`, `id_produit`, `prix_vente`, `prix_achat`, `prix_revient`, `quantity`, `qtiteliv`, `etatlivcmd`, `num_cmd`, `id_client`) VALUES
(108, 49, 360000, 0, 354300, 10, 10, 'livre', 'acf240030', 41),
(107, 137, 20500, 0, 18200, 15, 15, 'livre', 'acf240030', 41),
(106, 136, 20500, 0, 18200, 15, 15, 'livre', 'acf240030', 41),
(105, 135, 20500, 0, 18200, 20, 20, 'livre', 'acf240030', 41),
(104, 23, 39000, 0, 38200, 100, 100, 'livre', 'acf240029', 1),
(103, 23, 39000, 0, 38200, 200, 200, 'livre', 'acf240028', 52),
(102, 23, 40000, 0, 38200, 3, 3, 'livre', 'acf240027', 1),
(101, 37, 40000, 0, 38200, 3, 3, 'livre', 'acf240027', 1),
(100, 135, 20500, 0, 18200, 4, 4, 'livre', 'acf240026', 1),
(99, 143, 44000, 0, 43200, 5, 5, 'livre', 'acf240026', 1),
(98, 122, 50000, 0, 48200, 2, 2, 'livre', 'acf240026', 1),
(97, 142, 40000, 0, 34200, 1, 1, 'livre', 'acf240026', 1),
(96, 20, 130000, 0, 126200, 1, 1, 'livre', 'acf240026', 1),
(90, 23, 40000, 0, 38200, 3, 3, 'livre', 'acf240025', 1),
(89, 39, 37000, 0, 34200, 2, 2, 'livre', 'acf240025', 1),
(88, 122, 53000, 0, 48200, 3, 3, 'livre', 'acf240025', 1),
(87, 142, 40000, 0, 34200, 1, 1, 'livre', 'acf240025', 1),
(86, 59, 75000, 0, 0, 1, 1, 'livre', 'acf240025', 1),
(85, 84, 40000, 0, 35700, 1, 1, 'livre', 'acf240025', 1),
(84, 80, 35000, 0, 33200, 1, 1, 'livre', 'acf240025', 1),
(83, 62, 35000, 0, 32200, 1, 1, 'livre', 'acf240025', 1),
(82, 143, 45000, 0, 43200, 2, 2, 'livre', 'acf240025', 1),
(81, 37, 45000, 0, 38200, 1, 1, 'livre', 'acf240025', 1),
(80, 114, 110000, 0, 104300, 4, 4, 'livre', 'acf240025', 1),
(79, 125, 150000, 0, 143024.75247525, 1, 1, 'livre', 'acf240025', 1),
(78, 137, 20500, 0, 18200, 15, 15, 'livre', 'acf240024', 1),
(75, 52, 260000, 0, 150000, 1, 1, 'livre', 'acf240023', 1),
(77, 135, 20500, 0, 18200, 20, 20, 'livre', 'acf240024', 1),
(76, 136, 20500, 0, 18200, 15, 15, 'livre', 'acf240024', 1),
(74, 11, 95000, 0, 89200, 5, 5, 'livre', 'acf240023', 1),
(95, 25, 37000, 0, 32700, 1, 1, 'livre', 'acf240025', 1),
(94, 11, 100000, 0, 89200, 1, 1, 'livre', 'acf240025', 1),
(93, 38, 35000, 0, 34200, 2, 2, 'livre', 'acf240025', 1),
(92, 53, 50000, 0, 0, 2, 2, 'livre', 'acf240025', 1),
(91, 135, 22000, 0, 18200, 4, 4, 'livre', 'acf240025', 1),
(73, 52, 260000, 0, 150000, 1, 1, 'livre', 'acf240022', 1),
(72, 114, 110000, 0, 104300, 1, 1, 'livre', 'acf240022', 1),
(71, 62, 33000, 0, 41200, 2, 2, 'livre', 'acf240022', 1),
(70, 48, 62000, 0, 59200, 1, 1, 'livre', 'acf240022', 1),
(69, 122, 50000, 0, 42200, 1, 1, 'livre', 'acf240021', 1),
(68, 11, 95000, 0, 130200, 1, 1, 'livre', 'acf240020', 1),
(67, 23, 40000, 0, 35200, 15, 15, 'livre', 'acf240020', 1),
(66, 143, 45000, 0, 43200, 1, 1, 'livre', 'acf240019', 1),
(65, 5, 70000, 0, 65200, 2, 2, 'livre', 'acf240018', 1),
(64, 1, 70000, 0, 65200, 1, 1, 'livre', 'acf240018', 1),
(63, 84, 40000, 0, 35200, 2, 2, 'livre', 'acf240018', 1),
(62, 23, 45000, 0, 35200, 2, 2, 'livre', 'acf240018', 1),
(61, 135, 22000, 0, 20200, 4, 4, 'livre', 'acf240018', 1),
(109, 38, 35000, 0, 34200, 10, 10, 'livre', 'acf240030', 41),
(110, 143, 44000, 0, 43200, 20, 20, 'livre', 'acf240030', 41),
(111, 23, 40000, 0, 38200, 50, 50, 'livre', 'acf240030', 41),
(112, 58, 260000, 0, 254200, 5, 5, 'livre', 'acf240030', 41),
(113, 13, 65000, 0, 62200, 9, 9, 'livre', 'acf240031', 1),
(114, 15, 65000, 0, 62200, 8, 8, 'livre', 'acf240031', 1),
(115, 114, 110000, 0, 104300, 1, 1, 'livre', 'acf240031', 1),
(116, 84, 40000, 0, 35700, 3, 3, 'livre', 'acf240031', 1),
(117, 80, 35000, 0, 33200, 3, 3, 'livre', 'acf240031', 1),
(118, 52, 260000, 0, 254300, 2, 2, 'livre', 'acf240031', 1),
(119, 25, 34000, 0, 32700, 2, 2, 'livre', 'acf240031', 1),
(120, 62, 35000, 0, 32200, 2, 2, 'livre', 'acf240031', 1),
(121, 142, 35000, 0, 34200, 1, 1, 'livre', 'acf240031', 1),
(122, 19, 255000, 0, 251200, 2, 2, 'livre', 'acf240031', 1),
(123, 36, 37000, 0, 34200, 1, 1, 'livre', 'acf240031', 1),
(124, 1, 70000, 0, 65200, 5, 5, 'livre', 'acf240031', 1),
(125, 5, 70000, 0, 65200, 6, 6, 'livre', 'acf240031', 1),
(126, 3, 66000, 0, 62200, 1, 1, 'livre', 'acf240031', 1),
(127, 59, 67500, 0, 0, 2, 2, 'livre', 'acf240031', 1),
(128, 122, 53000, 0, 48200, 2, 2, 'livre', 'acf240031', 1),
(129, 64, 95000, 0, 79200, 6, 6, 'livre', 'acf240031', 1),
(130, 68, 100000, 0, 79200, 1, 1, 'livre', 'acf240031', 1),
(131, 67, 4167, 0, 4000, 6, 6, 'livre', 'acf240031', 1),
(132, 20, 135000, 0, 126200, 1, 1, 'livre', 'acf240031', 1),
(133, 49, 360000, 0, 354300, 2, 2, 'livre', 'acf240031', 1),
(134, 50, 90000, 0, 0, 2, 2, 'livre', 'acf240031', 1),
(135, 143, 45000, 0, 43200, 2, 2, 'livre', 'acf240031', 1),
(136, 7, 70000, 0, 65200, 5, 5, 'livre', 'acf240031', 1),
(137, 125, 150000, 0, 143024.75247525, 1, 1, 'livre', 'acf240031', 1),
(138, 136, 20500, 0, 18200, 5, 5, 'livre', 'acf240031', 1),
(139, 135, 20500, 0, 18200, 5, 5, 'livre', 'acf240031', 1),
(140, 23, 45000, 0, 38200, 2, 2, 'livre', 'acf240031', 1),
(141, 31, 120000, 0, 115500, 1, 1, 'livre', 'acf240031', 1),
(142, 126, 6666, 0, 7000, 6, 6, 'livre', 'acf240031', 1),
(143, 10, 2333, 0, 2073, 15, 15, 'livre', 'acf240031', 1),
(144, 84, 38000, 0, 35700, 9, 9, 'livre', 'acf240032', 1),
(145, 65, 4166, 0, 0, 18, 18, 'livre', 'acf240032', 1),
(146, 23, 40000, 0, 38200, 20, 20, 'livre', 'acf240033', 1),
(147, 114, 105000, 0, 104300, 2, 2, 'livre', 'acf240033', 1),
(148, 62, 35000, 0, 32200, 2, 2, 'livre', 'acf240033', 1),
(149, 84, 40000, 0, 35700, 3, 3, 'livre', 'acf240033', 1),
(150, 72, 34000, 0, 32200, 2, 2, 'livre', 'acf240033', 1),
(151, 80, 34000, 0, 33200, 1, 1, 'livre', 'acf240033', 1),
(152, 13, 63000, 0, 62200, 2, 2, 'livre', 'acf240033', 1),
(153, 15, 63000, 0, 62200, 2, 2, 'livre', 'acf240033', 1),
(154, 116, 120000, 0, 119300, 2, 2, 'livre', 'acf240033', 1),
(155, 143, 44000, 0, 43200, 10, 10, 'livre', 'acf240033', 1),
(156, 118, 140000, 0, 134300, 5, 5, 'livre', 'acf240033', 1),
(157, 3, 68000, 0, 62200, 2, 2, 'livre', 'acf240033', 1),
(158, 1, 68000, 0, 65200, 2, 2, 'livre', 'acf240033', 1),
(159, 5, 68000, 0, 65200, 2, 2, 'livre', 'acf240033', 1),
(160, 64, 85000, 0, 79200, 5, 5, 'livre', 'acf240033', 1),
(161, 135, 20500, 0, 18200, 5, 5, 'livre', 'acf240033', 1),
(162, 136, 20500, 0, 18200, 5, 5, 'livre', 'acf240033', 1),
(163, 116, 120000, 0, 119300, 10, 10, 'livre', 'acf240034', 38),
(164, 114, 105000, 0, 104300, 50, 50, 'livre', 'acf240034', 38),
(165, 118, 135000, 0, 134300, 20, 20, 'livre', 'acf240034', 38);

-- --------------------------------------------------------

--
-- Structure de la table `decaissement`
--

CREATE TABLE `decaissement` (
  `id` int(11) NOT NULL,
  `numdec` varchar(50) DEFAULT NULL,
  `montant` double NOT NULL,
  `devisedec` varchar(20) NOT NULL,
  `payement` varchar(30) NOT NULL,
  `numcheque` varchar(50) DEFAULT NULL,
  `banquecheque` varchar(50) DEFAULT NULL,
  `cprelever` varchar(50) DEFAULT NULL,
  `coment` varchar(150) DEFAULT NULL,
  `client` varchar(155) DEFAULT NULL,
  `lieuvente` varchar(10) DEFAULT NULL,
  `date_payement` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `decdepense`
--

CREATE TABLE `decdepense` (
  `id` int(11) NOT NULL,
  `numdec` varchar(50) DEFAULT 'retd26',
  `categorie` varchar(100) DEFAULT 'autres',
  `montant` double NOT NULL,
  `devisedep` varchar(20) NOT NULL,
  `payement` varchar(30) NOT NULL,
  `cprelever` varchar(50) DEFAULT 'caisse',
  `coment` varchar(150) DEFAULT NULL,
  `client` varchar(155) DEFAULT NULL,
  `lieuvente` varchar(10) DEFAULT NULL,
  `date_payement` datetime NOT NULL,
  `montantav` double DEFAULT NULL,
  `montantpr` double DEFAULT NULL,
  `montantcot` double DEFAULT NULL,
  `periodep` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `decloyer`
--

CREATE TABLE `decloyer` (
  `id` int(11) NOT NULL,
  `numdec` varchar(50) DEFAULT NULL,
  `montant` double NOT NULL,
  `payement` varchar(30) NOT NULL,
  `cprelever` varchar(50) NOT NULL,
  `coment` varchar(150) DEFAULT NULL,
  `client` varchar(155) DEFAULT NULL,
  `date_payement` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `decpersonnel`
--

CREATE TABLE `decpersonnel` (
  `id` int(11) NOT NULL,
  `numdec` varchar(50) DEFAULT NULL,
  `montant` double NOT NULL,
  `payement` varchar(30) NOT NULL,
  `cprelever` varchar(50) NOT NULL,
  `coment` varchar(150) DEFAULT NULL,
  `client` varchar(155) DEFAULT NULL,
  `date_payement` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `devise`
--

CREATE TABLE `devise` (
  `iddevise` int(11) NOT NULL,
  `nomdevise` varchar(10) NOT NULL,
  `montantdevise` float NOT NULL,
  `idvente` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `devisevente`
--

CREATE TABLE `devisevente` (
  `id` int(11) NOT NULL,
  `numcmd` varchar(10) DEFAULT NULL,
  `client` varchar(155) NOT NULL,
  `montant` double NOT NULL,
  `devise` varchar(20) NOT NULL,
  `taux` float NOT NULL DEFAULT 1,
  `motif` varchar(150) DEFAULT NULL,
  `typep` varchar(15) NOT NULL,
  `compte` varchar(50) DEFAULT NULL,
  `lieuvente` varchar(10) DEFAULT NULL,
  `dateop` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `editionfacture`
--

CREATE TABLE `editionfacture` (
  `id` int(11) NOT NULL,
  `numedit` varchar(150) DEFAULT NULL,
  `id_client` int(10) DEFAULT NULL,
  `libelle` varchar(150) DEFAULT NULL,
  `bl` varchar(150) DEFAULT NULL,
  `nature` varchar(150) DEFAULT NULL,
  `montant` double DEFAULT NULL,
  `devise` varchar(10) DEFAULT NULL,
  `lieuvente` int(2) DEFAULT NULL,
  `dateop` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `editionfournisseur`
--

CREATE TABLE `editionfournisseur` (
  `id` int(11) NOT NULL,
  `numedit` varchar(150) DEFAULT NULL,
  `id_client` int(10) DEFAULT NULL,
  `libelle` varchar(150) DEFAULT NULL,
  `bl` varchar(150) DEFAULT NULL,
  `nature` varchar(150) DEFAULT NULL,
  `montant` double DEFAULT NULL,
  `devise` varchar(10) DEFAULT NULL,
  `lieuvente` int(2) DEFAULT NULL,
  `dateop` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `editionfournisseur`
--

INSERT INTO `editionfournisseur` (`id`, `numedit`, `id_client`, `libelle`, `bl`, `nature`, `montant`, `devise`, `lieuvente`, `dateop`) VALUES
(9, 'editf7', 179, 'Achat de vimto', '005JEUDI', 'achat', 28500000, 'gnf', 1, '2024-01-18 11:41:14'),
(6, 'editf5', 4, 'inventeur1', '008', 'achat', 1, 'gnf', 1, '2024-01-13 19:28:56');

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

CREATE TABLE `facture` (
  `id` int(11) NOT NULL,
  `numfact` varchar(50) NOT NULL,
  `numcmd` varchar(50) NOT NULL,
  `datefact` date NOT NULL,
  `fournisseur` varchar(60) NOT NULL,
  `taux` float NOT NULL DEFAULT 1,
  `montantht` double NOT NULL,
  `montantva` double DEFAULT NULL,
  `montantpaye` double DEFAULT NULL,
  `frais` double DEFAULT NULL,
  `fraistrans` double DEFAULT 0,
  `modep` varchar(50) NOT NULL DEFAULT 'gnf',
  `lieuvente` int(11) NOT NULL,
  `datepaye` datetime DEFAULT NULL,
  `datecmd` datetime NOT NULL,
  `etatcf` varchar(50) DEFAULT NULL,
  `payement` varchar(15) DEFAULT 'especes',
  `type` varchar(50) DEFAULT 'fournisseur'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `fraisup`
--

CREATE TABLE `fraisup` (
  `id` int(11) NOT NULL,
  `numcmd` varchar(50) DEFAULT NULL,
  `montant` double NOT NULL,
  `modep` varchar(50) NOT NULL DEFAULT 'gnf',
  `typep` varchar(50) NOT NULL DEFAULT 'espèces',
  `motif` varchar(500) NOT NULL,
  `client` varchar(155) DEFAULT NULL,
  `lieuvente` varchar(10) DEFAULT NULL,
  `date_payement` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `gaindevise`
--

CREATE TABLE `gaindevise` (
  `id` int(11) NOT NULL,
  `montant` double NOT NULL,
  `coment` varchar(150) NOT NULL,
  `lieuvente` int(11) NOT NULL,
  `dateop` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `historique`
--

CREATE TABLE `historique` (
  `id` int(11) NOT NULL,
  `num_cmd` varchar(15) NOT NULL,
  `montant` double NOT NULL,
  `payement` varchar(155) NOT NULL,
  `nom_client` varchar(155) DEFAULT NULL,
  `date_cmd` datetime NOT NULL,
  `date_regul` datetime DEFAULT NULL,
  `remboursement` varchar(155) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `histpaiefrais`
--

CREATE TABLE `histpaiefrais` (
  `id` int(11) NOT NULL,
  `num_cmd` varchar(15) NOT NULL,
  `montant` double DEFAULT NULL,
  `payement` varchar(155) NOT NULL,
  `devise` varchar(20) NOT NULL DEFAULT 'gnf',
  `nom_client` varchar(155) DEFAULT NULL,
  `lieuvente` int(11) NOT NULL,
  `date_cmd` datetime NOT NULL,
  `date_regul` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `intertopproduit`
--

CREATE TABLE `intertopproduit` (
  `id` int(11) NOT NULL,
  `idprod` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `benefice` double NOT NULL DEFAULT 0,
  `pseudo` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `inventaire`
--

CREATE TABLE `inventaire` (
  `id` int(11) NOT NULL,
  `dettegnf` double DEFAULT 0,
  `creancegnf` double DEFAULT 0,
  `comptegnf` double DEFAULT 0,
  `stock` double DEFAULT 0,
  `pertes` double DEFAULT 0,
  `gain` double DEFAULT 0,
  `solde` double DEFAULT 0,
  `depenses` double DEFAULT 0,
  `lieuvente` int(2) DEFAULT 1,
  `anneeinv` int(4) DEFAULT 0,
  `dateop` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `inventaire`
--

INSERT INTO `inventaire` (`id`, `dettegnf`, `creancegnf`, `comptegnf`, `stock`, `pertes`, `gain`, `solde`, `depenses`, `lieuvente`, `anneeinv`, `dateop`) VALUES
(9, 0, 0, 0, 0, NULL, NULL, 0, NULL, 1, 2024, '2024-01-14');

-- --------------------------------------------------------

--
-- Structure de la table `licence`
--

CREATE TABLE `licence` (
  `id` int(11) NOT NULL,
  `num_licence` varchar(155) NOT NULL,
  `nom_societe` varchar(255) NOT NULL,
  `date_souscription` date NOT NULL,
  `date_fin` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `licence`
--

INSERT INTO `licence` (`id`, `num_licence`, `nom_societe`, `date_souscription`, `date_fin`) VALUES
(1, 'L000056', 'damko', '2024-01-10', '2025-01-10');

-- --------------------------------------------------------

--
-- Structure de la table `limitecredit`
--

CREATE TABLE `limitecredit` (
  `id` int(11) NOT NULL,
  `montant` double NOT NULL DEFAULT 1000000000000,
  `idclient` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `limitecredit`
--

INSERT INTO `limitecredit` (`id`, `montant`, `idclient`) VALUES
(1, 1000000000, 1),
(2, 1000000000, 2),
(3, 1000000000, 3),
(4, 1000000000, 7),
(5, 1000000000, 9),
(6, 1000000000, 10),
(7, 1000000000, 13),
(8, 1000000000, 16),
(9, 1000000000, 12),
(10, 1000000000, 11),
(11, 1000000000, 15),
(12, 1000000000, 14),
(13, 1000000000, 17),
(14, 1000000000, 18),
(15, 1000000000, 22),
(16, 1000000000, 20),
(17, 1000000000, 21),
(18, 1000000000, 19),
(19, 1000000000, 26),
(20, 1000000000, 28),
(21, 1000000000, 27),
(22, 1000000000, 29),
(23, 1000000000, 31),
(24, 1000000000, 32),
(25, 1000000000, 30),
(26, 1000000000, 33),
(27, 1000000000, 34),
(28, 1000000000, 38),
(29, 1000000000, 60),
(30, 1000000000, 62),
(31, 1000000000, 42),
(32, 1000000000, 48),
(33, 1000000000, 61),
(34, 1000000000, 52),
(35, 1000000000, 63),
(36, 1000000000, 37),
(37, 1000000000, 65),
(38, 1000000000, 46),
(39, 1000000000, 55),
(40, 1000000000, 53),
(41, 1000000000, 45),
(42, 1000000000, 49),
(43, 1000000000, 43),
(44, 1000000000, 56),
(45, 1000000000, 58),
(46, 1000000000, 36),
(47, 1000000000, 40),
(48, 1000000000, 41),
(49, 1000000000, 50),
(50, 1000000000, 57),
(51, 1000000000, 54),
(52, 1000000000, 51),
(53, 1000000000, 44),
(54, 1000000000, 47),
(55, 1000000000, 66),
(56, 1000000000, 64),
(57, 1000000000, 35),
(58, 1000000000, 39),
(59, 1000000000, 70),
(60, 1000000000, 67),
(61, 1000000000, 68),
(62, 1000000000, 69),
(63, 1000000000, 71),
(64, 1000000000, 72),
(65, 1000000000, 73),
(66, 1000000000, 75),
(67, 1000000000, 87),
(68, 1000000000, 83),
(69, 1000000000, 76),
(70, 1000000000, 74),
(71, 1000000000, 80),
(72, 1000000000, 81),
(73, 1000000000, 77),
(74, 1000000000, 79),
(75, 1000000000, 82),
(76, 1000000000, 78),
(77, 1000000000, 85),
(78, 1000000000, 88),
(79, 1000000000, 86),
(80, 1000000000, 84),
(81, 1000000000, 89),
(82, 1000000000, 90),
(83, 1000000000, 92),
(84, 1000000000, 95),
(85, 1000000000, 91),
(86, 1000000000, 93),
(87, 1000000000, 94),
(88, 1000000000, 97),
(89, 1000000000, 96),
(90, 1000000000, 98),
(91, 1000000000, 99),
(92, 1000000000, 100),
(93, 1000000000, 102),
(94, 1000000000, 103),
(95, 1000000000, 101),
(96, 1000000000, 111),
(97, 1000000000, 112),
(98, 1000000000, 108),
(99, 1000000000, 106),
(100, 1000000000, 104),
(101, 1000000000, 109),
(102, 1000000000, 113),
(103, 1000000000, 107),
(104, 1000000000, 114),
(105, 1000000000, 116),
(106, 1000000000, 115),
(107, 1000000000, 110),
(108, 1000000000, 105),
(109, 1000000000, 123),
(110, 1000000000, 120),
(111, 1000000000, 118),
(112, 1000000000, 117),
(113, 1000000000, 122),
(114, 1000000000, 121),
(115, 1000000000, 119),
(116, 1000000000, 124),
(117, 1000000000, 134),
(118, 1000000000, 127),
(119, 1000000000, 130),
(120, 1000000000, 128),
(121, 1000000000, 126),
(122, 1000000000, 125),
(123, 1000000000, 131),
(124, 1000000000, 132),
(125, 1000000000, 129),
(126, 1000000000, 133),
(127, 1000000000, 135),
(128, 1000000000, 137),
(129, 1000000000, 136),
(130, 1000000000, 138),
(131, 1000000000, 141),
(132, 1000000000, 139),
(133, 1000000000, 140),
(134, 1000000000, 143),
(135, 1000000000, 145),
(136, 1000000000, 144),
(137, 1000000000, 147),
(138, 1000000000, 151),
(139, 1000000000, 146),
(140, 1000000000, 142),
(141, 1000000000, 149),
(142, 1000000000, 150),
(143, 1000000000, 148),
(144, 1000000000, 153),
(145, 1000000000, 152),
(146, 1000000000, 154),
(147, 1000000000, 155),
(148, 1000000000, 156),
(149, 1000000000, 159),
(150, 1000000000, 157),
(151, 1000000000, 158),
(152, 1000000000, 161),
(153, 1000000000, 162),
(154, 1000000000, 160),
(155, 1000000000, 164),
(156, 1000000000, 163),
(157, 1000000000, 165),
(158, 1000000000, 168),
(159, 1000000000, 167),
(160, 1000000000, 166),
(161, 1000000000, 172),
(162, 1000000000, 169),
(163, 1000000000, 171),
(164, 1000000000, 170),
(165, 1000000000, 175),
(166, 1000000000, 173),
(167, 1000000000, 174),
(168, 1000000000, 176),
(169, 1000000000, 177),
(170, 1000000000, 178),
(171, 1000000000, 179),
(172, 1000000000, 180);

-- --------------------------------------------------------

--
-- Structure de la table `livraison`
--

CREATE TABLE `livraison` (
  `id` int(11) NOT NULL,
  `idcmd` int(11) DEFAULT NULL,
  `id_produitliv` int(11) DEFAULT NULL,
  `quantiteliv` int(11) DEFAULT 0,
  `numcmdliv` varchar(50) NOT NULL,
  `id_clientliv` int(10) DEFAULT NULL,
  `livreur` varchar(50) NOT NULL,
  `idstockliv` int(11) DEFAULT NULL,
  `dateliv` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `livraison`
--

INSERT INTO `livraison` (`id`, `idcmd`, `id_produitliv`, `quantiteliv`, `numcmdliv`, `id_clientliv`, `livreur`, `idstockliv`, `dateliv`) VALUES
(109, 110, 143, 20, 'acf240030', 41, '2', 1, '2024-01-18 17:43:12'),
(108, 109, 38, 10, 'acf240030', 41, '2', 1, '2024-01-18 17:43:12'),
(107, 108, 49, 10, 'acf240030', 41, '2', 1, '2024-01-18 17:43:12'),
(106, 107, 137, 15, 'acf240030', 41, '2', 1, '2024-01-18 17:43:12'),
(105, 106, 136, 15, 'acf240030', 41, '2', 1, '2024-01-18 17:43:12'),
(104, 105, 135, 20, 'acf240030', 41, '2', 1, '2024-01-18 17:43:12'),
(103, 104, 23, 100, 'acf240029', 1, '2', 1, '2024-01-18 16:49:32'),
(102, 103, 23, 200, 'acf240028', 52, '2', 1, '2024-01-18 16:06:57'),
(101, 102, 23, 3, 'acf240027', 1, '2', 1, '2024-01-18 13:58:35'),
(100, 101, 37, 3, 'acf240027', 1, '2', 1, '2024-01-18 13:58:35'),
(97, 98, 122, 2, 'acf240026', 1, '2', 1, '2024-01-18 13:16:00'),
(98, 99, 143, 5, 'acf240026', 1, '2', 1, '2024-01-18 13:16:00'),
(99, 100, 135, 4, 'acf240026', 1, '2', 1, '2024-01-18 13:16:00'),
(92, 93, 38, 2, 'acf240025', 1, '2', 1, '2024-01-18 12:56:56'),
(91, 92, 53, 2, 'acf240025', 1, '2', 1, '2024-01-18 12:56:56'),
(90, 91, 135, 4, 'acf240025', 1, '2', 1, '2024-01-18 12:56:56'),
(89, 90, 23, 3, 'acf240025', 1, '2', 1, '2024-01-18 12:56:56'),
(88, 89, 39, 2, 'acf240025', 1, '2', 1, '2024-01-18 12:56:56'),
(87, 88, 122, 3, 'acf240025', 1, '2', 1, '2024-01-18 12:56:56'),
(86, 87, 142, 1, 'acf240025', 1, '2', 1, '2024-01-18 12:56:56'),
(85, 86, 59, 1, 'acf240025', 1, '2', 1, '2024-01-18 12:56:56'),
(84, 85, 84, 1, 'acf240025', 1, '2', 1, '2024-01-18 12:56:56'),
(83, 84, 80, 1, 'acf240025', 1, '2', 1, '2024-01-18 12:56:56'),
(82, 83, 62, 1, 'acf240025', 1, '2', 1, '2024-01-18 12:56:56'),
(81, 82, 143, 2, 'acf240025', 1, '2', 1, '2024-01-18 12:56:56'),
(79, 80, 114, 4, 'acf240025', 1, '2', 1, '2024-01-18 12:56:56'),
(80, 81, 37, 1, 'acf240025', 1, '2', 1, '2024-01-18 12:56:56'),
(78, 79, 125, 1, 'acf240025', 1, '2', 1, '2024-01-18 12:56:56'),
(77, 78, 137, 15, 'acf240024', 1, '9', 1, '2024-01-18 12:30:34'),
(75, 76, 136, 15, 'acf240024', 1, '9', 1, '2024-01-18 12:30:34'),
(76, 77, 135, 20, 'acf240024', 1, '9', 1, '2024-01-18 12:30:34'),
(96, 97, 142, 1, 'acf240026', 1, '2', 1, '2024-01-18 13:16:00'),
(95, 96, 20, 1, 'acf240026', 1, '2', 1, '2024-01-18 13:16:00'),
(94, 95, 25, 1, 'acf240025', 1, '2', 1, '2024-01-18 12:56:56'),
(93, 94, 11, 1, 'acf240025', 1, '2', 1, '2024-01-18 12:56:56'),
(74, 75, 52, 1, 'acf240023', 1, '2', 1, '2024-01-18 09:54:35'),
(73, 74, 11, 5, 'acf240023', 1, '2', 1, '2024-01-18 09:54:35'),
(72, 73, 52, 1, 'acf240022', 1, '2', 1, '2024-01-18 09:34:01'),
(71, 72, 114, 1, 'acf240022', 1, '2', 1, '2024-01-18 09:34:01'),
(70, 71, 62, 2, 'acf240022', 1, '2', 1, '2024-01-18 09:34:01'),
(69, 70, 48, 1, 'acf240022', 1, '2', 1, '2024-01-18 09:34:01'),
(68, 69, 122, 1, 'acf240021', 1, '2', 1, '2024-01-18 09:21:54'),
(67, 68, 11, 1, 'acf240020', 1, '2', 1, '2024-01-18 09:11:41'),
(66, 67, 23, 15, 'acf240020', 1, '2', 1, '2024-01-18 09:11:41'),
(65, 66, 143, 1, 'acf240019', 1, '2', 1, '2024-01-18 09:09:52'),
(64, 65, 5, 2, 'acf240018', 1, '2', 1, '2024-01-18 09:04:35'),
(63, 64, 1, 1, 'acf240018', 1, '2', 1, '2024-01-18 09:04:35'),
(62, 63, 84, 2, 'acf240018', 1, '2', 1, '2024-01-18 09:04:35'),
(61, 62, 23, 2, 'acf240018', 1, '2', 1, '2024-01-18 09:04:35'),
(60, 61, 135, 4, 'acf240018', 1, '2', 1, '2024-01-18 09:04:35'),
(110, 111, 23, 50, 'acf240030', 41, '2', 1, '2024-01-18 17:43:12'),
(111, 112, 58, 5, 'acf240030', 41, '2', 1, '2024-01-18 17:43:12'),
(112, 113, 13, 9, 'acf240031', 1, '9', 1, '2024-01-18 20:32:00'),
(113, 114, 15, 8, 'acf240031', 1, '9', 1, '2024-01-18 20:32:00'),
(114, 115, 114, 1, 'acf240031', 1, '9', 1, '2024-01-18 20:32:00'),
(115, 116, 84, 3, 'acf240031', 1, '9', 1, '2024-01-18 20:32:00'),
(116, 117, 80, 3, 'acf240031', 1, '9', 1, '2024-01-18 20:32:00'),
(117, 118, 52, 2, 'acf240031', 1, '9', 1, '2024-01-18 20:32:00'),
(118, 119, 25, 2, 'acf240031', 1, '9', 1, '2024-01-18 20:32:00'),
(119, 120, 62, 2, 'acf240031', 1, '9', 1, '2024-01-18 20:32:00'),
(120, 121, 142, 1, 'acf240031', 1, '9', 1, '2024-01-18 20:32:00'),
(121, 122, 19, 2, 'acf240031', 1, '9', 1, '2024-01-18 20:32:00'),
(122, 123, 36, 1, 'acf240031', 1, '9', 1, '2024-01-18 20:32:00'),
(123, 124, 1, 5, 'acf240031', 1, '9', 1, '2024-01-18 20:32:00'),
(124, 125, 5, 6, 'acf240031', 1, '9', 1, '2024-01-18 20:32:00'),
(125, 126, 3, 1, 'acf240031', 1, '9', 1, '2024-01-18 20:32:00'),
(126, 127, 59, 2, 'acf240031', 1, '9', 1, '2024-01-18 20:32:00'),
(127, 128, 122, 2, 'acf240031', 1, '9', 1, '2024-01-18 20:32:00'),
(128, 129, 64, 6, 'acf240031', 1, '9', 1, '2024-01-18 20:32:00'),
(129, 130, 68, 1, 'acf240031', 1, '9', 1, '2024-01-18 20:32:00'),
(130, 131, 67, 6, 'acf240031', 1, '9', 1, '2024-01-18 20:32:00'),
(131, 132, 20, 1, 'acf240031', 1, '9', 1, '2024-01-18 20:32:00'),
(132, 133, 49, 2, 'acf240031', 1, '9', 1, '2024-01-18 20:32:00'),
(133, 134, 50, 2, 'acf240031', 1, '9', 1, '2024-01-18 20:32:00'),
(134, 135, 143, 2, 'acf240031', 1, '9', 1, '2024-01-18 20:32:00'),
(135, 136, 7, 5, 'acf240031', 1, '9', 1, '2024-01-18 20:32:00'),
(136, 137, 125, 1, 'acf240031', 1, '9', 1, '2024-01-18 20:32:00'),
(137, 138, 136, 5, 'acf240031', 1, '9', 1, '2024-01-18 20:32:00'),
(138, 139, 135, 5, 'acf240031', 1, '9', 1, '2024-01-18 20:32:00'),
(139, 140, 23, 2, 'acf240031', 1, '9', 1, '2024-01-18 20:32:00'),
(140, 141, 31, 1, 'acf240031', 1, '9', 1, '2024-01-18 20:32:00'),
(141, 142, 126, 6, 'acf240031', 1, '9', 1, '2024-01-18 20:32:00'),
(142, 143, 10, 15, 'acf240031', 1, '9', 1, '2024-01-18 20:32:00'),
(143, 144, 84, 9, 'acf240032', 1, '9', 1, '2024-01-18 20:45:39'),
(144, 145, 65, 18, 'acf240032', 1, '9', 1, '2024-01-18 20:45:39'),
(145, 146, 23, 20, 'acf240033', 1, '2', 1, '2024-01-18 21:20:47'),
(146, 147, 114, 2, 'acf240033', 1, '2', 1, '2024-01-18 21:20:47'),
(147, 148, 62, 2, 'acf240033', 1, '2', 1, '2024-01-18 21:20:47'),
(148, 149, 84, 3, 'acf240033', 1, '2', 1, '2024-01-18 21:20:47'),
(149, 150, 72, 2, 'acf240033', 1, '2', 1, '2024-01-18 21:20:47'),
(150, 151, 80, 1, 'acf240033', 1, '2', 1, '2024-01-18 21:20:47'),
(151, 152, 13, 2, 'acf240033', 1, '2', 1, '2024-01-18 21:20:47'),
(152, 153, 15, 2, 'acf240033', 1, '2', 1, '2024-01-18 21:20:47'),
(153, 154, 116, 2, 'acf240033', 1, '2', 1, '2024-01-18 21:20:47'),
(154, 155, 143, 10, 'acf240033', 1, '2', 1, '2024-01-18 21:20:47'),
(155, 156, 118, 5, 'acf240033', 1, '2', 1, '2024-01-18 21:20:47'),
(156, 157, 3, 2, 'acf240033', 1, '2', 1, '2024-01-18 21:20:47'),
(157, 158, 1, 2, 'acf240033', 1, '2', 1, '2024-01-18 21:20:47'),
(158, 159, 5, 2, 'acf240033', 1, '2', 1, '2024-01-18 21:20:47'),
(159, 160, 64, 5, 'acf240033', 1, '2', 1, '2024-01-18 21:20:47'),
(160, 161, 135, 5, 'acf240033', 1, '2', 1, '2024-01-18 21:20:47'),
(161, 162, 136, 5, 'acf240033', 1, '2', 1, '2024-01-18 21:20:47'),
(162, 163, 116, 10, 'acf240034', 38, '2', 1, '2024-01-18 21:23:10'),
(163, 164, 114, 50, 'acf240034', 38, '2', 1, '2024-01-18 21:23:10'),
(164, 165, 118, 20, 'acf240034', 38, '2', 1, '2024-01-18 21:23:10');

-- --------------------------------------------------------

--
-- Structure de la table `livraisondelete`
--

CREATE TABLE `livraisondelete` (
  `id` int(11) NOT NULL,
  `id_produitliv` int(11) DEFAULT NULL,
  `quantiteliv` int(11) DEFAULT 0,
  `numcmdliv` varchar(50) NOT NULL,
  `id_clientliv` int(10) DEFAULT NULL,
  `idpersonnel` varchar(50) NOT NULL,
  `idstockliv` int(11) DEFAULT NULL,
  `datedelete` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `livraisondelete`
--

INSERT INTO `livraisondelete` (`id`, `id_produitliv`, `quantiteliv`, `numcmdliv`, `id_clientliv`, `idpersonnel`, `idstockliv`, `datedelete`) VALUES
(1, 1, 58, 'acf240001', 1, '1', 1, '2024-01-11 20:39:44'),
(2, 32, 1, 'acf240016', 1, '2', 1, '2024-01-13 19:06:54'),
(3, 3, 50, 'acf240002', 7, '2', 1, '2024-01-14 17:18:18'),
(4, 7, 60, 'acf240002', 7, '2', 1, '2024-01-14 17:18:18'),
(5, 9, 100, 'acf240002', 7, '2', 1, '2024-01-14 17:18:18'),
(6, 5, 18, 'acf240003', 15, '2', 1, '2024-01-14 17:18:41'),
(7, 4, 1, 'acf240003', 15, '2', 1, '2024-01-14 17:18:41'),
(8, 1, 1, 'acf240003', 15, '2', 1, '2024-01-14 17:18:41'),
(9, 10, 1, 'acf240003', 15, '2', 1, '2024-01-14 17:18:41'),
(10, 9, 20, 'acf240004', 14, '2', 1, '2024-01-14 17:21:04'),
(11, 3, 100, 'acf240004', 14, '2', 1, '2024-01-14 17:21:04'),
(12, 12, 1, 'acf240004', 14, '2', 1, '2024-01-14 17:21:04'),
(13, 1, 150, 'acf240005', 21, '2', 1, '2024-01-14 17:22:14'),
(14, 12, 1, 'acf240005', 21, '2', 1, '2024-01-14 17:22:14'),
(15, 17, 50, 'acf240005', 21, '2', 1, '2024-01-14 17:22:14'),
(16, 12, 1, 'acf240006', 2, '2', 1, '2024-01-14 17:22:37'),
(17, 11, 1, 'acf240006', 2, '2', 1, '2024-01-14 17:22:37'),
(18, 11, 10, 'acf240014', 14, '2', 1, '2024-01-14 17:23:02'),
(19, 19, 20, 'acf240014', 14, '2', 1, '2024-01-14 17:23:02'),
(20, 20, 1, 'acf240014', 14, '2', 1, '2024-01-14 17:23:02'),
(21, 2, 1, 'acf240014', 14, '2', 1, '2024-01-14 17:23:02'),
(22, 8, 1, 'acf240014', 14, '2', 1, '2024-01-14 17:23:02'),
(23, 1, 1, 'acf240014', 14, '2', 1, '2024-01-14 17:23:02'),
(24, 19, 10, 'acf240007', 21, '2', 1, '2024-01-14 17:23:19'),
(25, 20, 1, 'acf240007', 21, '2', 1, '2024-01-14 17:23:19'),
(26, 1, 1, 'acf240007', 21, '2', 1, '2024-01-14 17:23:19'),
(27, 11, 1, 'acf240007', 21, '2', 1, '2024-01-14 17:23:19'),
(28, 12, 12, 'acf240008', 13, '2', 1, '2024-01-14 17:23:33'),
(29, 6, 13, 'acf240008', 13, '2', 1, '2024-01-14 17:23:33'),
(30, 20, 12, 'acf240008', 13, '2', 1, '2024-01-14 17:23:33'),
(31, 5, 1, 'acf240009', 9, '2', 1, '2024-01-14 17:24:02'),
(32, 12, 1, 'acf240009', 9, '2', 1, '2024-01-14 17:24:02'),
(33, 19, 1, 'acf240009', 9, '2', 1, '2024-01-14 17:24:02'),
(34, 19, 15, 'acf240010', 22, '2', 1, '2024-01-14 17:24:17'),
(35, 11, 1, 'acf240011', 15, '2', 1, '2024-01-14 17:24:29'),
(36, 6, 1, 'acf240011', 15, '2', 1, '2024-01-14 17:24:29'),
(37, 19, 1, 'acf240011', 15, '2', 1, '2024-01-14 17:24:29'),
(38, 20, 1, 'acf240012', 21, '2', 1, '2024-01-14 17:24:39'),
(39, 11, 1, 'acf240012', 21, '2', 1, '2024-01-14 17:24:39'),
(40, 19, 50, 'acf240013', 11, '2', 1, '2024-01-14 17:24:49'),
(41, 5, 10, 'acf240015', 1, '2', 1, '2024-01-14 17:25:01'),
(42, 19, 1, 'acf240015', 1, '2', 1, '2024-01-14 17:25:01'),
(43, 11, 5, 'acf240015', 1, '2', 1, '2024-01-14 17:25:01'),
(44, 4, 2, 'acf240015', 1, '2', 1, '2024-01-14 17:25:01'),
(45, 10, 1, 'acf240015', 1, '2', 1, '2024-01-14 17:25:01'),
(46, 12, 2, 'acf240017', 18, '2', 1, '2024-01-14 17:25:12'),
(47, 11, 20, 'acf240017', 18, '2', 1, '2024-01-14 17:25:12'),
(48, 29, 50, 'acf240017', 18, '2', 1, '2024-01-14 17:25:12'),
(49, 32, 2, 'acf240017', 18, '2', 1, '2024-01-14 17:25:12'),
(50, 36, 4, 'acf240017', 18, '2', 1, '2024-01-14 17:25:12'),
(51, 39, 45, 'acf240017', 18, '2', 1, '2024-01-14 17:25:12'),
(52, 37, 50, 'acf240017', 18, '2', 1, '2024-01-14 17:25:12'),
(53, 1, 70, 'acf240017', 18, '2', 1, '2024-01-14 17:25:12'),
(54, 4, 2, 'acf240017', 18, '2', 1, '2024-01-14 17:25:12'),
(55, 10, 2, 'acf240017', 18, '2', 1, '2024-01-14 17:25:12');

-- --------------------------------------------------------

--
-- Structure de la table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `identifiant` int(10) DEFAULT NULL,
  `nom` varchar(100) NOT NULL,
  `telephone` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `pseudo` varchar(15) NOT NULL,
  `mdp` text NOT NULL,
  `level` int(10) NOT NULL,
  `statut` varchar(100) NOT NULL,
  `lieuvente` int(11) NOT NULL,
  `type` varchar(50) DEFAULT 'personnel',
  `dateenreg` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `login`
--

INSERT INTO `login` (`id`, `identifiant`, `nom`, `telephone`, `email`, `pseudo`, `mdp`, `level`, `statut`, `lieuvente`, `type`, `dateenreg`) VALUES
(1, 1, 'admin', '628196628', 'd.amadoumouctar@yahoo.fr', 'damkoguinee@', '$2y$10$SEjMzpjmCN0wJqBIfTC4WOzzooTYsEx6IM7/1/fq4mEbN80eF9J26', 7, 'admin', 1, 'admin', '2022-03-25 13:57:28'),
(2, 2, 'Alseny Sow', '623 59 18 17', '', 'Alseny Sow', '$2y$10$KTF9joQT6YytTZUHyN2Ule8oWUKKqXQMzW1itEHc.lR1lThZ9lDaC', 7, 'responsable', 1, 'personnel', '2022-03-25 13:58:15'),
(3, NULL, 'Client Journalier', '001', '', '001', '$2y$10$Y6YLjR7gRPYj2muS91u40en7iXM8rbpqSrAfEmtcG/rTwNJpXYV66', 1, 'client', 1, 'client', '2024-01-11 19:20:30'),
(4, NULL, 'IBRAHIMA HABILAYA', '622010085', '', '622010085', '$2y$10$PI42R5deXWzERCc.3TGjgu8vl3B4aYQQWqRgAmStcqOeCa7Wulxv.', 1, 'client', 1, 'client', '2024-01-11 19:25:15'),
(5, NULL, 'ALADJI MOUSSA HABILAYA', '627019461', '', '627019461', '$2y$10$0tVpJ2zkTcE/r7xwk4yLduUG2C.VktGjCj2C8BlxhZwkpZjuYzLNm', 1, 'client', 1, 'client', '2024-01-11 19:31:56'),
(6, NULL, 'Fournisseur Cash', '002', '', '002', '$2y$10$5exw1gVg0yH3xVU71Kzl4O5vi08oqgsqMmwZOU5Qx75HcUBH6GMwS', 1, 'fournisseur', 1, 'fournisseur', '2024-01-11 19:36:11'),
(7, NULL, 'mamadou alpha sow', '621816667', '', '621816667', '$2y$10$XZM1QB0mn24Aq.iPSK4lnu/Ni/UYHSIWB9XOWSTceOjkAV/P2Eu6e', 1, 'fournisseur', 1, 'fournisseur', '2024-01-11 19:42:49'),
(8, NULL, 'badara', '003', '', '003', '$2y$10$5uxYARlV9omIyJPDbXVBFOQ8Bg2DPqB2NZXqbcileNlNxqTI883Ei', 1, 'Employer', 1, 'Employer', '2024-01-11 19:47:37'),
(9, 9, 'Ramadane Sow', '627 86 14 61', '', 'Ramadane Sow', '$2y$10$Toptgoz/Y4prZ3jxKy7X/.gUHldzTgTyib0sDpb.7krN8CeYeMilq', 6, 'vendeur', 1, 'personnel', '2024-01-11 20:55:31'),
(10, NULL, 'Aladji abdoulaye bisigui', '628592347', '', '628592347', '$2y$10$1lQFGcGhY0dgv393Y9H7cOAMLOyY6jhyM5jwz9nh0cUAFRLDaTyo.', 1, 'client', 1, 'client', '2024-01-11 21:17:48'),
(11, NULL, 'chinois U-Freche', '666772222', '', '666772222', '$2y$10$6bg7R/xsX77/GsE23PxrOOvsReeb7KKkCAdwjmSX8UDv4S0RmrG7i', 1, 'fournisseur', 1, 'fournisseur', '2024-01-11 21:20:37'),
(12, NULL, 'Aladji fode', '622210070', '', '622210070', '$2y$10$h4YdwjKmZPsEgVqlj6OvLuoxLN5DE8qQ6URSb.u9H3LdfBTitbCN6', 1, 'client', 1, 'client', '2024-01-11 21:49:37'),
(13, NULL, 'hadia aista boucheri', '627909543', '', '627909543', '$2y$10$Te6Ux6yW2q.xvAUgGmdauONW/bjEtUm0iyOQtzacoozBrshCbp1AO', 1, 'client', 1, 'client', '2024-01-11 23:02:56'),
(14, NULL, 'Moussa drame boucheri', '626366947', '', '626366947', '$2y$10$ockQY57F74nhf6U0RnS9D.y7B6.vDGf/JHULjjn5t.kronAz8IS/i', 1, 'client', 1, 'client', '2024-01-11 23:32:42'),
(15, NULL, 'kadiatou koulibali', '621967890', '', '621967890', '$2y$10$HQ5OscTtIN7lU9kpDgBIq.wIjD2K8SdEahmmDTzm9k3.bRzN9mL/u', 1, 'client', 1, 'client', '2024-01-11 23:35:10'),
(74, NULL, 'marouwana bisigui', '624180811', '', '624180811', '$2y$10$v1/Sxo1DYVXjlft4aOZ.7.g7RoKU6vNFYGLo0mo4NmJK7amVQcE8W', 1, 'client', 1, 'client', '2024-01-15 09:45:57'),
(17, NULL, 'Thierno mamadou trois avrile', '627291029', '', '627291029', '$2y$10$svlsZgiiNB6snRM1sugIYecIQ2//TBOu3SIl25AZJh9jJ6.5o95Iy', 1, 'client', 1, 'client', '2024-01-11 23:39:58'),
(18, NULL, 'Oustage aliou yenguema', '622219522', '', '622219522', '$2y$10$jpOrKkPhmfVRMPWp0V8wceliAu1zElFVzHto.WBWt1jixDzkOhMei', 1, 'client', 1, 'client', '2024-01-11 23:42:25'),
(19, NULL, 'Habit habilaya ', '622443181', '', '622443181', '$2y$10$eraFrdaEHs8fFk2CzPnnwe9UPgHoBJo4/nrgoTGDY2hjCRoqBf6Je', 1, 'client', 1, 'client', '2024-01-11 23:44:31'),
(20, NULL, 'Thierno dian leycompognie', '620692060', '', '620692060', '$2y$10$wJ2NRh3gEFwXHLUr.c8YMOzfgeZjO/qMoWWTLNvWUNIH4VECKiVYm', 1, 'client', 1, 'client', '2024-01-12 09:22:53'),
(21, NULL, 'younoussa bisigui', '627060930', '', '627060930', '$2y$10$ygdBdxjztxErLBy8F12xIeIa.ixOtndofTQbLalt5KHpa/K5Ct7A.', 1, 'client', 1, 'client', '2024-01-12 09:29:24'),
(22, NULL, 'saliou  pti fre  de tella', '626014597', '', '626014597', '$2y$10$RVlxBPFbs1Mr/aIogzKCye6xRDNkm16j1VXPOKpYTBLdSfy/b8x42', 1, 'client', 1, 'client', '2024-01-12 09:34:51'),
(23, NULL, 'Kaba boucheri', '625829496', '', '625829496', '$2y$10$yT94aMovsQsAKoUOKNVEueQ44kJsP83aBExAm3InJidYqyumr8XFG', 1, 'client', 1, 'client', '2024-01-12 09:36:26'),
(24, NULL, 'kaba kalefour', '622641212', '', '622641212', '$2y$10$WpHP2vpvAfwgnd3qDCYPC.1Tp7j/Kb8Sp0SdAgHm7jYMliPu5qnGa', 1, 'client', 1, 'client', '2024-01-12 09:38:05'),
(25, NULL, 'ALSENY 24H', '626464616', '', '626464616', '$2y$10$BNxnMaF210jh6vkFVWSpsuKjkU/HQiyopC2SPotBY28mesCl0/YlG', 1, 'clientf', 1, 'clientf', '2024-01-12 09:41:19'),
(26, NULL, 'BANQUE MARCO', '622988619', '', '622988619', '$2y$10$bmSKcok9rI202oNfSSmGMetiSgCg3gacCx7DFgyhRzjqeybNqy0uW', 1, 'Banque', 1, 'Banque', '2024-01-12 20:03:33'),
(27, NULL, 'BANQUE ISLAMIQUE', '620193139', '', '620193139', '$2y$10$JTFi5XgeRBUL96cOHTiWjeeWCZeIH/q/ZCASfunrouXbF6OwYhsZ2', 1, 'Banque', 1, 'Banque', '2024-01-12 20:05:20'),
(28, NULL, 'VISTA GUI', '005', '', '005', '$2y$10$WIXXuV.3uy6vdkYlwvF8yub01B68Zao6gpJdrlA9YOilA8B3G9VtW', 1, 'Banque', 1, 'Banque', '2024-01-12 20:06:30'),
(29, NULL, 'mamadou bhoye banga', '628882839', '', '628882839', '$2y$10$nQNIpCGubXYt8J.CiJLXH.EkhlKlkXeKspUzNdmlKDINpekg3qh/O', 1, 'clientf', 1, 'clientf', '2024-01-13 20:25:34'),
(30, NULL, 'Souabou EDG', '620971288', '', '620971288', '$2y$10$ilZ1Fk8yHTFLTKV5nk18jOLHgMCjHffhQHb0fgUAOaX3iDoJfob22', 1, 'client', 1, 'client', '2024-01-14 18:10:03'),
(31, NULL, 'Mamadou saliou caravance', '628205013', '', '628205013', '$2y$10$S0C4fsRVBTYpELsRR0Kcle5Uw9evMwablcr8R/qWiTGbqpo/440Vu', 1, 'client', 1, 'client', '2024-01-14 18:12:37'),
(32, NULL, 'Tahirou labe1', '625063146', '', '625063146', '$2y$10$VKpGC2bKAvln/.oySwEuseNa4Y7dauSQyir74D0bxiK5wcasJDTue', 1, 'client', 1, 'client', '2024-01-14 18:15:45'),
(33, NULL, 'Mariama telly', '628965505', '', '628965505', '$2y$10$Mfp22w0vZ1tEwzF6EE3AuewkUSMzkVYE..Z.pFpe7csPU1TJdCQWq', 1, 'client', 1, 'client', '2024-01-14 18:20:15'),
(34, NULL, 'Boubacar fils de Aladji abdoulaye', '628690706', '', '628690706', '$2y$10$CwZ7hLPMOE2kSMDvFawSOeG7VbgIQ9OwkAa3rCtRW/IScFLoLQwOa', 1, 'client', 1, 'client', '2024-01-14 18:24:10'),
(35, NULL, 'Madam barry  salimatou', '620985752', '', '620985752', '$2y$10$v/bfJB.JkZ0dsuRbSDcPreN7xx/vugY.KfdOwcynxlx/68W6Q3B2u', 1, 'client', 1, 'client', '2024-01-14 18:33:30'),
(36, NULL, 'Petit barry 1', '620694314', '', '620694314', '$2y$10$3Q9RAuZGZjYMUkEPtLr13.H/dg6zOWo.k3yzHrmsdl3E9OPbWsd2q', 1, 'client', 1, 'client', '2024-01-14 18:37:34'),
(37, NULL, 'Th oumar boucheri', '624802649', '', '624802649', '$2y$10$O2WirdZBWD42Ei6zOZnSGu7CCrXI5OeUQji/Z7Bd72/o10CJZxn16', 1, 'client', 1, 'client', '2024-01-14 18:40:46'),
(38, NULL, 'souleymane orange money', '622089602', '', '622089602', '$2y$10$/SmAF/UA4QNlMJwLUfXCL./ESBn7wbcK5pTRbP10yrV5lOCzgGfyW', 1, 'client', 1, 'client', '2024-01-14 18:47:27'),
(39, NULL, 'Malike contournente', '625834444', '', '625834444', '$2y$10$9Ghn2Q2RBeYxOTxEZO4T2uTtBGkD11O8hvorHu1qDEpTBEJcXnYfW', 1, 'client', 1, 'client', '2024-01-14 18:49:28'),
(40, NULL, 'Alpha oumare couzbela', '629269609', '', '629269609', '$2y$10$9f0FVplSRgs9gf8C6yBCUO7bZ4zUKSLT0K11QebDyBkN6RyYwpJ1q', 1, 'client', 1, 'client', '2024-01-14 18:51:55'),
(41, NULL, 'Aladji abdramane kabakadou', '628118544', '', '628118544', '$2y$10$QjHeeRN.XpcgBiTD89/7Se7qpTJIDYzCa8kW3dMU5V9D6Oj3KRMsS', 1, 'client', 1, 'client', '2024-01-14 18:53:51'),
(42, NULL, 'Thierno saidou leycompogni', '620690025', '', '620690025', '$2y$10$u1ewX0W74e.EkX8owwRlnO.d7kDJu5gCcXSrp3yIKRhKeTryg1vPG', 1, 'client', 1, 'client', '2024-01-14 18:56:35'),
(43, NULL, 'Mamadoou saliou tapiyoka', '624321142', '', '624321142', '$2y$10$5iJfS1q7E.WxHTNRzifzfuclgDngqQTU4Es2Rk12JnWQTmFVVkOOW', 1, 'client', 1, 'client', '2024-01-14 18:58:21'),
(44, NULL, 'Mamadou barka', '625421442', '', '625421442', '$2y$10$Gii1LiKFJaB4UADYix7XpuAKPUl3kdA6VD6UdR2EexUxNCdcV5.ti', 1, 'client', 1, 'client', '2024-01-14 19:00:38'),
(45, NULL, 'Aladji ibrahima gart', '625647224', '', '625647224', '$2y$10$/3P9nkO7sirEDTL1TC9Fq.5tb/2nHCneEIpkSkom6J0RsPsLblZ32', 1, 'client', 1, 'client', '2024-01-14 19:02:01'),
(46, NULL, 'Lansana kaba boucheri', '629536612', '', '629536612', '$2y$10$0RUU9x5kv.fjKmNHR68kzewOliK1UZlbUkfGGOzFa.Yl08bHyH7ee', 1, 'client', 1, 'client', '2024-01-14 19:15:31'),
(47, NULL, 'Mody bobo yenguema', '623332233', '', '623332233', '$2y$10$LMLEJmZbp2DPFAUyi3lwYeWPfz8Opvlz7MDjltkz1Kg3egkHvTDF2', 1, 'client', 1, 'client', '2024-01-14 19:17:29'),
(48, NULL, 'Ibrahima sory dadiya', '627178000', '', '627178000', '$2y$10$kr138A37/J0O/UsgzT7DFuHyKd5Tu6WsnVGqOT9fPFKg94h6hqg5C', 1, 'client', 1, 'client', '2024-01-14 19:19:17'),
(49, NULL, 'Boubacar petit frere de Arian comoya', '622985506', '', '622985506', '$2y$10$XEW0.a/dDf2FGJD73GTfI.JZtiaAr.8S7siiHokMJ8GVpA7r87Gs2', 1, 'client', 1, 'client', '2024-01-14 19:22:15'),
(50, NULL, 'Moustafa', '625118603', '', '625118603', '$2y$10$7QHcydgwbrf5KvKnMVwYJ.5gBKxCuEN29T1L6d6lyiH80shJ8ViL.', 1, 'client', 1, 'client', '2024-01-14 19:25:10'),
(51, NULL, 'ALADJI KALILOU PKLANETE', '628543137', '', '628543137', '$2y$10$jNO1LDypCcWUJKdhVAYBRu2gU4H6lgXg45N.r2ci9GvT/BBWJbT.u', 1, 'client', 1, 'client', '2024-01-14 19:26:59'),
(52, NULL, 'LAMINE 3X', '628881944', '', '628881944', '$2y$10$s844WRhLA1epkTzef2moQ.iVXKq9RpqUmqn9wxXZWZsXnrX3eMa3i', 1, 'client', 1, 'client', '2024-01-14 19:28:51'),
(53, NULL, 'MAMADOU BENTAIT', '628370396', '', '628370396', '$2y$10$ARejt/EfJPceFQbT8x6CvOXCzM1Sy01i51MBr5gRZXd4lZrm/3aNe', 1, 'client', 1, 'client', '2024-01-14 19:30:03'),
(54, NULL, 'MODY AMADOU YEWOLE VIEUX', '621354540', '', '621354540', '$2y$10$ChEQtY3Z9mSPAMiL2foc2OFXw57ZxE/CzHsd5Zu8Do1mFtvQyAsc2', 1, 'client', 1, 'client', '2024-01-14 19:34:39'),
(55, NULL, 'ALADJI TELLA BISIGUI', '621995871', '', '621995871', '$2y$10$X.BWniup886cnMeXF9KG.ujqHBNhAlxi4Z/PzH5IJX6ZuJahzH5xK', 1, 'client', 1, 'client', '2024-01-14 19:38:58'),
(56, NULL, 'IBRAHIMA SORY BISIGUI', '626151304', '', '626151304', '$2y$10$KeAZvkUWKGSs6NU9jGd/7eu2kfzbuX0Bze2tJR0uLi4N3sB6VNTli', 1, 'client', 1, 'client', '2024-01-14 19:41:46'),
(57, NULL, 'MAMADOU LAMINE DEGOLE', '626135556', '', '626135556', '$2y$10$EXNVoDyW5IbIQerJulOws.VwsFBRteGTUof7whTKof1VOWI0WlkZe', 1, 'client', 1, 'client', '2024-01-14 19:43:29'),
(58, NULL, 'IBRAHIMA BILESIMPI', '620114374', '', '620114374', '$2y$10$3x6KyRqWX/hnDuWkIVYw7egwGvknbyEpvowtZRmJQZVqNDZ4vQ126', 1, 'client', 1, 'client', '2024-01-14 19:46:00'),
(59, NULL, 'MADAM DIALLO AISTA CONTOURNENTE', '628448649', '', '628448649', '$2y$10$8nBDKnAQBcxDrfxwJyyn5uF5dnYSlhQxmVf3IqTwudnQPOVBh9TKG', 1, 'client', 1, 'client', '2024-01-14 19:47:23'),
(60, NULL, 'MAMADOU DIAN COMOYA', '623660859', '', '623660859', '$2y$10$pxuRUhVPWlzcXqGSVtoO/ubri1nG77rIw.P0dlM6k6mi0cAp6zKEO', 1, 'client', 1, 'client', '2024-01-14 19:50:21'),
(61, NULL, 'MAJIDE SALAME', '627171712', '', '627171712', '$2y$10$DyIEvI1E70xK7f0uq4rS3usge4sDSoZCivL5sEr5OVGfxhIRLWY8a', 1, 'client', 1, 'client', '2024-01-14 19:53:40'),
(62, NULL, 'ANAFIOU SALL ROYAL', '625732336', '', '625732336', '$2y$10$Uff3fQ0z3ufiDB7Fj71KNu3kqv3LGebIM.ZLkru0eUIJr4StIM9Sq', 1, 'autres', 1, 'autres', '2024-01-14 19:56:58'),
(63, NULL, 'ALADJI ALIOU GARGASAKI', '623119203', '', '623119203', '$2y$10$p7A8H0TLIVSZ01DHTiO/6uvr9vDG.lJpya/10weXatMaDir0MXzgK', 1, 'client', 1, 'client', '2024-01-14 20:00:22'),
(64, NULL, 'ALADJI SOULEYMANE YEWOLE', '620632968', '', '620632968', '$2y$10$Xb2MrpbHYqi.eQ/LD3LWhete9pu/IsFG4S3q/s//MqXopQ2xL5ydq', 1, 'client', 1, 'client', '2024-01-14 20:05:29'),
(65, NULL, 'ALADJI AMADOU YENGUEMA  VIEUX', '621206311', '', '621206311', '$2y$10$XSz19R8ch97hUJIdu8NoL.SoWXFpwiGaQP2E0mqPQcWzOFoM5h7aq', 1, 'client', 1, 'client', '2024-01-14 20:07:08'),
(66, NULL, 'ALPHA BARRY PITA', '625825773', '', '625825773', '$2y$10$re/UqRfoGwpdGP/OekZvSui9lo.vF3zAMYT9hpmTtqrB433PSV8Lu', 1, 'client', 1, 'client', '2024-01-14 20:10:29'),
(67, NULL, 'OUSTAGE BOUBACAR LEYCOMPOGNI', '621776741', '', '621776741', '$2y$10$gxpYH6QxMi4JsldnHnEC3OcRRW6Pl4TTSNtrjTyHv8o3N8KFIzGDS', 1, 'client', 1, 'client', '2024-01-14 20:15:16'),
(68, NULL, 'BOUBACAR BARRY LEYCOMPOGNI', '629257180', '', '629257180', '$2y$10$gd/kM/u6KKFaOaZBWpYBP.hPdyaB7kUA..XDeDNdxRdTvyp/iwjA.', 1, 'client', 1, 'client', '2024-01-14 20:16:26'),
(69, NULL, 'OURY YENGUEMA', '621079556', '', '621079556', '$2y$10$zZpX7qLJh/IBmGX5uW9zu.LYnhD/1gLEAABJp6PIlUiNANu5GXoOW', 1, 'client', 1, 'client', '2024-01-14 20:18:04'),
(70, NULL, 'IBRHIMA SAOUDIEN', '620299059', '', '620299059', '$2y$10$vXwth/E/nPSpUtPpdGonpe2lHcrAI4gTlYsNbr3KZDP9L2jAX7Ds2', 1, 'client', 1, 'client', '2024-01-14 20:30:32'),
(71, NULL, 'MANSARE DADIYA', '620963739', '', '620963739', '$2y$10$Xh1SnfTaFvE982E.RZmLP.jcvpPa94q1UDEYo5.bfZI7PnBuVuXOC', 1, 'client', 1, 'client', '2024-01-14 20:31:44'),
(72, NULL, 'MOUSTAFA LEYCOMPOGNI', '629191312', '', '629191312', '$2y$10$i/CvAWahrI3MO73J6J/Ot.LHRgA8loWHpOcPLr7nfYaOE6WHvjS.S', 1, 'client', 1, 'client', '2024-01-14 20:33:28'),
(73, NULL, 'AMADOU SADIO HOREKELIWOL', '628574913/62311', '', '628574913/62311', '$2y$10$0lO00craQag9RHyxPHalEeR93wbol7Mr5QEcng6qgNDDgx4Uvkffu', 1, 'client', 1, 'client', '2024-01-14 20:36:39'),
(75, NULL, 'Mere de adama kaniagic debelle', '620694151', '', '620694151', '$2y$10$AATtY22sVJBV6bf3S6IQWuwvrCfCBO0xMv.9ddHgkVkWHK6xvT8kK', 1, 'client', 1, 'client', '2024-01-15 13:23:22'),
(76, NULL, 'mere de adama debellen', '625244847', '', '625244847', '$2y$10$wj4bSrLl40V98QnD1WhOOeCMagGrQutFZCJpdpgLvVAcnBPWaXEp.', 1, 'client', 1, 'client', '2024-01-15 14:36:41'),
(77, NULL, 'Idrissa contournante', '625920433', '', '625920433', '$2y$10$FUjR8flaX860mWth3GumIutlCFLiUvfz0N1xAjxxrNj/nv0nhIVbm', 1, 'client', 1, 'client', '2024-01-15 14:41:57'),
(78, NULL, 'Alhassana contournante', '623466920', '', '623466920', '$2y$10$qjlG0Qz0jyU7oMUSvcLxeu2Yi2.hbA.OG0YLYA58VINRajcn.v2oC', 1, 'client', 1, 'client', '2024-01-15 14:43:33'),
(79, NULL, 'Atigou Dadiya', '628283118', '', '628283118', '$2y$10$vFCsH8RTBYIc875T7pO1W.hrAzb7hR2CTpMUC5D6F8UN/j.ykDx/G', 1, 'client', 1, 'client', '2024-01-15 14:45:36'),
(80, NULL, 'Mouctar Cosmetique', '620768261', '', '620768261', '$2y$10$i4EGThn0U//MkHvgwrcMuuDyUIvEu2HLmYdTLTaDvmyrpXrt1HTTi', 1, 'client', 1, 'client', '2024-01-15 14:47:39'),
(81, NULL, 'Oumar a cote de Saoudien', '625009220', '', '625009220', '$2y$10$oFsZCnfLYXly/pb6LjOce.DrtqGLxgeL5vIIvDe8Xb96XQT24bz4O', 1, 'client', 1, 'client', '2024-01-15 14:50:04'),
(82, NULL, 'mounir bad boye', '625225905', '', '625225905', '$2y$10$JOiNoGoKvuWKorEf1T.V8e1Fr90VF6ZlIWfs9rTUArI5fnqkaMUvG', 1, 'client', 1, 'client', '2024-01-15 15:07:15'),
(83, NULL, 'Kadiatou Worgoto', '629123819', '', '629123819', '$2y$10$JxieaJo1Nf4kETWdC3UJ5u0dJBVGjIJbAVkSeW/Su001INubg0DVW', 1, 'client', 1, 'client', '2024-01-15 15:11:30'),
(84, NULL, 'Mister Barry Sambaya', '621597246', '', '621597246', '$2y$10$hQqqhbQkxFil4xJGGtAvEe4UjQEYF6l1dayqExYvswJbLAjBh/e6y', 1, 'client', 1, 'client', '2024-01-15 15:15:47'),
(85, NULL, 'mousier diallo Africana', '621185168', '', '621185168', '$2y$10$Inmn624RDJsgkIpzqL9PY.yt/EXpu.4ztr4airxEY6tv.AvvLyI1S', 1, 'client', 1, 'client', '2024-01-15 15:22:08'),
(86, NULL, 'Alpha Pipool', '621654450', '', '621654450', '$2y$10$hVCbM8t597CqKN9y91qc9e.Rp8dc/V1ugC9/LoRnXKmVGveo5ajiS', 1, 'client', 1, 'client', '2024-01-15 15:28:01'),
(87, NULL, 'Souleymane Jus', '623118128', '', '623118128', '$2y$10$TIFiP/KLacjb65nc8zKK0ewekNG56Iq1aBgJVn9sO9ckC02Iiz.YG', 1, 'client', 1, 'client', '2024-01-15 15:30:27'),
(88, NULL, 'Ousmane Hénéré', '628503799', '', '628503799', '$2y$10$IZQpVs.JgFQPhRSIqEFswOBSJFbwvo2ZNAjR8CnlB3ARR82SOYNyq', 1, 'client', 1, 'client', '2024-01-15 15:32:24'),
(89, NULL, 'RAMADANE HORE KOUMA', '622689602', '', '622689602', '$2y$10$5/fKfnlgsNal51NxqLj7o.2JOEZ32ewpFBZUZXP2.RfHRVtsG2Doy', 1, 'client', 1, 'client', '2024-01-15 16:13:13'),
(90, NULL, 'ALPHA IBRAHIMA V DE LIBANAI', '624512674', '', '624512674', '$2y$10$0b1UpVypUQxi3JybG5X0KO2M3eCvwYc02O5suzqn423lEmC6U8RX6', 1, 'client', 1, 'client', '2024-01-15 16:19:46'),
(91, NULL, 'OUSTAGE A COTE DE MAROUANE', '662602846', '', '662602846', '$2y$10$XGA7EQUPpk8Kzsi73DP6GOWhGmNyadC9rV9/HI9o6lnPz46lWuDO2', 1, 'client', 1, 'client', '2024-01-15 16:23:45'),
(92, NULL, 'YAYA HABILAYA', '625931247', '', '625931247', '$2y$10$mySOyLB4ONebEMtKIO.aoOFuCM9egQBPdelhhevomDrYJ6fheb9Za', 1, 'client', 1, 'client', '2024-01-15 16:27:48'),
(93, NULL, 'Mr Mamadou alpha Telimilé ', '621402149', '', '621402149', '$2y$10$beignpoGK0f3gOkbCy3kf.CEWLCvUtdUvCSMaxPIJdpVMi6D7nEI.', 1, 'client', 1, 'client', '2024-01-15 17:45:09'),
(94, NULL, 'Hadia Bintou Casia ', '623668082', '', '623668082', '$2y$10$RRX1RTHUF7iH5KiC69pFROXiUO4Od3a7yhhpoPq2.ogJDEhj3Hwya', 1, 'client', 1, 'client', '2024-01-15 17:58:48'),
(95, NULL, 'Bintou Galiagori ', '624217571', '', '624217571', '$2y$10$Bx1yzh9kMGLtEneMVC5ucOCG6Q37HCqjcRZsEsyd8jKr3mLxIX5Ye', 1, 'client', 1, 'client', '2024-01-15 18:00:14'),
(96, NULL, 'Oncle ABdoulaye kourou', '623591817', '', '623591817', '$2y$10$QaLiUD0d04a0EU4GGwnEQeb1d19lRMffeZqeKiSVkCct.cIthM9h2', 1, 'client', 1, 'client', '2024-01-15 18:01:16'),
(97, NULL, 'Oury mon amis depuis Dallaba ', '620135516', '', '620135516', '$2y$10$iUt9TkxLc.bF33XbuOu2lO4yA9qVqQc5Vk6su7o205DglXSXdirY.', 1, 'client', 1, 'client', '2024-01-15 18:03:06'),
(98, NULL, 'Diadia Oumou Dallaba comoya', '628630516', '', '628630516', '$2y$10$PfYgG64v7BvGXUhnfqmHwuKERPgJ7neK0CRjprs2i96Nt6WzHGbcu', 1, 'client', 1, 'client', '2024-01-15 18:04:31'),
(99, NULL, 'Oumou Hawa Bisigui ', '1817', '', '1817', '$2y$10$u5a7Vz2IwlrtmqVw.RpuRuxpZXHBNgEnWTys/yatXuxQE4vcc8bIK', 1, 'client', 1, 'client', '2024-01-15 18:07:06'),
(100, NULL, 'Madam barry Colenten ', '622137353', '', '622137353', '$2y$10$xjBfY7kp7FM5aQiNUXCFtOa37MgirEN7SGSV4BItMrHL9byU9rBam', 1, 'client', 1, 'client', '2024-01-15 18:08:59'),
(101, NULL, 'Syla Caravanceraye ', '623272774', '', '623272774', '$2y$10$.dwgTwG6bvXQbqcNfl62geymt1lkFn1aIps6/jpJibR4vUggZ381W', 1, 'client', 1, 'client', '2024-01-15 20:46:01'),
(102, NULL, 'Thierno Guidho ', '624252318', '', '624252318', '$2y$10$JzTCKtR9OCCiLa4tsejD1euK/RmBFlkOdgoB6WHj1fY4L27dOuxzK', 1, 'client', 1, 'client', '2024-01-16 09:33:37'),
(103, NULL, 'Yousoufou Leycompagni ', '621275332', '', '621275332', '$2y$10$XVREWJ5xQEJSOf0fOx51GOebcDE42U2MtapGoplAvZKU0ZE4ZBNIm', 1, 'client', 1, 'client', '2024-01-16 10:00:09'),
(104, NULL, 'Thierno Thiougué Bounanya', '623115598', '', '623115598', '$2y$10$ZQdrLeDmEBTxcpYLxUfOHulrPaw.PCMXDOxXF0rJ1We3CzVc3jjoS', 1, 'client', 1, 'client', '2024-01-16 11:16:35'),
(105, NULL, 'Baillo Dounké', '621071003', '', '621071003', '$2y$10$hQluXBwJ6XFQlyUTMfV9s.71MICEV2wpWfuExCEqcjv8rShAbWkGm', 1, 'client', 1, 'client', '2024-01-16 11:19:49'),
(106, NULL, 'Ly Djoungole', '628626991', '', '628626991', '$2y$10$vdmlDhNIEy0huVrvlgomGuPlR07VgbIxtuHM/vzNdVTzYizG8ROAW', 1, 'client', 1, 'client', '2024-01-16 11:22:11'),
(107, NULL, 'Fatoumata Diaby', '007', '', '007', '$2y$10$3XqAQbhXFT2YfFKjb9L0s.lVq8zUk0ugHWqxZAb900s.nOWik6lU6', 1, 'client', 1, 'client', '2024-01-16 11:51:08'),
(108, NULL, 'Thierno Mamadou Yéro', '623325732', '', '623325732', '$2y$10$8qpPSpIvyYoO2bAemuuQBu3r1bcOiHaatLpA5I36ZRoscwnLUdmtS', 1, 'client', 1, 'client', '2024-01-16 11:53:19'),
(109, NULL, 'Djénabou Kaba', '624626385', '', '624626385', '$2y$10$0d5XzJdHEvdK3WvZSlzSk.ngZ0OtoTeOA8IpSEmiwfY2yoYQV60P6', 1, 'client', 1, 'client', '2024-01-16 11:54:31'),
(110, NULL, 'Madiou Yenguéma', '622136513', '', '622136513', '$2y$10$8qpiwZty239zzlDmcEhm9.LacaZMsytJtd6xFypkSpTdMuVplMVXK', 1, 'client', 1, 'client', '2024-01-16 11:56:12'),
(111, NULL, 'Boubacar Nestlé', '625002626', '', '625002626', '$2y$10$qtO.YpEo1y8M1hj6z./O5uG9LJk7vZsNbAwWgH89ZjoTZrZ0k8DRy', 1, 'client', 1, 'client', '2024-01-16 11:57:59'),
(112, NULL, 'Ibrahima Kilé', '623717284', '', '623717284', '$2y$10$bgtWIgrIX8oMoGh6LWFtneSZtYHYkAVZahoq5lfZv.M01UANiL6gC', 1, 'client', 1, 'client', '2024-01-16 12:00:11'),
(113, NULL, 'Thierno Boubacar ly', '623180009', '', '623180009', '$2y$10$oCbLUKUoESmK3xZ8Y18G8OLwOSO1bTg9Y1AkwJrzi8khZwnlRKK.m', 1, 'client', 1, 'client', '2024-01-16 12:03:59'),
(114, NULL, 'Alhassane Dramé Guaranti Kabagai', '628511561', '', '628511561', '$2y$10$WBaXd7h3UUtDjZnvWNkvYeKxsjfm9xWiJ6UG5g154vkMt7mjrLNE6', 1, 'client', 1, 'client', '2024-01-16 12:06:39'),
(115, NULL, 'Alpha Amadou Baldé', '008', '', '008', '$2y$10$IjSXBefEhBsZXqTRHIkRUeGkp5MEP/m4rnoJE3Zv/aQkDfcZU0B6y', 1, 'client', 1, 'client', '2024-01-16 12:10:52'),
(116, NULL, 'kadiatou koulibali et Binta', '621979447', '', '621979447', '$2y$10$SdHCKBXtgeDLmzRt0Bcth..xq3d2nFZwgcoNZISP5EVlp4fTNmEv2', 1, 'client', 1, 'client', '2024-01-16 12:15:46'),
(117, NULL, 'Oumar Barry Boucherie', '623094344', '', '623094344', '$2y$10$3Bzk.ZvNlEqC7mcTRBZyFuKhBRsPl.3V9hB/PMyCdUzhEQDEddaWC', 1, 'client', 1, 'client', '2024-01-16 12:17:28'),
(118, NULL, 'Petit Frère de Thierno Nouhou', '628858057', '', '628858057', '$2y$10$IfpNlCRb210j4PsIIPOzWeJZGrunyrHjbEQeG2QvYNuf5OEytJhQO', 1, 'client', 1, 'client', '2024-01-16 12:28:04'),
(119, NULL, 'Oury Kaliyakhori', '610132336', '', '610132336', '$2y$10$Y5IXL6wwVgDHJ1rrk00z4ujc26ch6aNKBZ8fql3u6x7EqMfjFJj0O', 1, 'client', 1, 'client', '2024-01-16 12:29:58'),
(120, NULL, 'Kaba Bagin', '621861796', '', '621861796', '$2y$10$M8Gg8tZ9yvvPB2Lf3gGB1eQ3/s.kv.Z/q.8ZsRhYqi26BmqaHs1wK', 1, 'client', 1, 'client', '2024-01-16 12:43:32'),
(121, NULL, 'Ibrahima Café ', '628005525', '', '628005525', '$2y$10$grljZ/3GzyGqyqhj9vTjBevWt/2RLKdlenI8jaS1VkqxTwXd9ggiC', 1, 'client', 1, 'client', '2024-01-16 13:01:35'),
(122, NULL, 'Thierno sadou Comoya', '623404160', '', '623404160', '$2y$10$4g8P8gt4mzOXzKWdQPGptuZIm4yGONGYDtxFYvP08IwTIDrCHfjZq', 1, 'client', 1, 'client', '2024-01-16 13:07:39'),
(123, NULL, 'Boubacar Bounanya', '009', '', '009', '$2y$10$F0sACrq2aCgvr9L6w3IoTuPPR7R9ir5EqIv/33oMpgIJAvELWC86G', 1, 'client', 1, 'client', '2024-01-16 13:09:35'),
(124, NULL, 'Nen Bilguissa', '624506555', '', '624506555', '$2y$10$HrFJTmNk/IZt.cyA4BBqn.iRNKylMtZ5uy4cddkGz7n64zEXqcFM.', 1, 'client', 1, 'client', '2024-01-16 13:13:33'),
(125, NULL, 'Mamoudou Dihoye', '625110526', '', '625110526', '$2y$10$QVSGAF2ACkJOmsrMrex/ouhdQby7.fIh8n4AuX/JvajrXMyKZ56IG', 1, 'client', 1, 'client', '2024-01-16 13:16:16'),
(126, NULL, 'Abdoulaye Diallo Djoma Diawdi', '624093453', '', '624093453', '$2y$10$2d.oM0UbnUx3JMfGgv2thuACe2j7UULaXk20hfjr1b0aN5yykW.PO', 1, 'client', 1, 'client', '2024-01-16 13:18:44'),
(127, NULL, 'Mouctar Contournente ', '622966591', '', '622966591', '$2y$10$v3qLPOJafr.hOezuWINOAuQpyDwnk313.ylZXO8N8TjojByFNebnO', 1, 'client', 1, 'client', '2024-01-17 16:38:11'),
(128, NULL, 'djenabou livraison', '25', '', '25', '$2y$10$pGz4Zx1b4DtRvn471f0dt.WvLNRKi0/vPjYJW.rsIM2QSoLo.yNXq', 1, 'client', 1, 'client', '2024-01-17 17:38:55'),
(129, NULL, 'djenabou drame madina woula', '628992828', '', '628992828', '$2y$10$FcSjrT01XWdtL52AI.VjKOj9KcWfs4sUX1AIXjpdhqeFEpr0nwZC2', 1, 'client', 1, 'client', '2024-01-17 17:42:52'),
(130, NULL, 'Alphadjo barry comoya', '620785924', '', '620785924', '$2y$10$yEPmW3yVRW/R2E6jT/pmEOjCXkXUstCyn7zual17rUWFlvv6O9dui', 1, 'client', 1, 'client', '2024-01-17 17:45:02'),
(131, NULL, 'boubacar diallo habilaya', '628778834', '', '628778834', '$2y$10$zqCo1.CmbgJKBsbtgAwECOWhSI5YoXvv.v60aqnrosQ5xXPth4KRC', 1, 'client', 1, 'client', '2024-01-17 17:48:48'),
(132, NULL, 'Oumare beavogui sinaniya', '620751534', '', '620751534', '$2y$10$5DZjYdLU8IJWYEh2NHyphuP3qK03TTXGMZ/20oLm1kZdYbc/i5v.O', 1, 'client', 1, 'client', '2024-01-17 17:53:04'),
(133, NULL, 'Boubacar  diallo police routier', '627021943', '', '627021943', '$2y$10$rCWydt0Qgaq63hchdQ3ipepUoLus/5F0xax06kY3fW5Wya3e25HCK', 1, 'client', 1, 'client', '2024-01-17 17:59:05'),
(134, NULL, 'Mody boubacar CEFAO', '622560073', '', '622560073', '$2y$10$QLAx07e3xlUMJj2gX9sQAu678ZimpOPlKLN.9Wmn6bT7C4..j2l6S', 1, 'client', 1, 'client', '2024-01-17 18:00:25'),
(135, NULL, 'Mody ibrahima barry bounenya', '55', '', '55', '$2y$10$r6vkHcF/6d/D4WRVINrEUe.hYzHVOUHZztWCUuqLP/KxR0g6Rh9nK', 1, 'client', 1, 'client', '2024-01-17 18:02:02'),
(136, NULL, 'Yagouba diallo wondi enseignant', '628956621', '', '628956621', '$2y$10$LkNm.07QAJ1HqJ3rcaHK4eyrtfiGNMQIhLw07CWLoPrRAinRhGZdq', 1, 'client', 1, 'client', '2024-01-17 18:05:45'),
(137, NULL, 'Alpha oumare comoya a cote dian', '627811428', '', '627811428', '$2y$10$hBKQ4ncUM.j8dM0KX0PxIO4SX6/z.5ZQIoa9UuL2TP.Ho5Q1XTaoS', 1, 'client', 1, 'client', '2024-01-17 18:27:43'),
(138, NULL, 'Vieux linsant ', '621198812', '', '621198812', '$2y$10$ArVy5UUw38OCwmYQAaP1lOv7AvFURfwY05T9gaUHi0//kn4YNZ4Ca', 1, 'client', 1, 'client', '2024-01-17 19:36:36'),
(139, NULL, 'Kadiatou comoya ', '623788833', '', '623788833', '$2y$10$6/lEoxtOb.XYc8KUEIzJ.Od1ZjgD6Q33S7okIEO7zhTAR7tLKdWBu', 1, 'client', 1, 'client', '2024-01-17 19:55:25'),
(140, NULL, 'Abdoulaye camara Dambagania ', '622439282', '', '622439282', '$2y$10$M5Xqc0J58j9Azm2jO33ZM.ldLtMqPkfxgxUPS0BjU1SN2p72ciMRm', 1, 'client', 1, 'client', '2024-01-17 19:56:38'),
(141, NULL, 'Mamadou bobo katakata', '627959598', '', '627959598', '$2y$10$LP87QcNVNwj6FZE0NsmdEeHLuyRApryVyvNA6dH8n6GryLkYGRmuS', 1, 'client', 1, 'client', '2024-01-17 19:58:24'),
(142, NULL, 'Saidou yaiki Sambaya ', '628824421', '', '628824421', '$2y$10$sz//XCxBpU8F1BJW2W/kP.b8jAhy7ajvlFO0CD6R76P9XoknIpq1i', 1, 'client', 1, 'client', '2024-01-17 19:59:46'),
(143, NULL, 'Toure orange money', '626864646', '', '626864646', '$2y$10$LorMP3O59cuTFDznzY7d2.wj1z0kuDc4/XBfaSQwIG7NrKQ7SluNe', 1, 'client', 1, 'client', '2024-01-17 20:00:53'),
(144, NULL, 'Oncle Sadialiou à côté de lamine', '620996893', '', '620996893', '$2y$10$2Kykk7PJurfjI60iCGOQVelI9/FwDLQCO0YlnW.thx0ETP.6QI5wG', 1, 'client', 1, 'client', '2024-01-17 20:03:30'),
(145, NULL, 'Idiatou Bisigui ', '623179625', '', '623179625', '$2y$10$jdGL44Si8JHhr1a.V3ipCe7zYImFb2cUcahpv9ruhtZzdXphXyRXi', 1, 'client', 1, 'client', '2024-01-17 20:08:36'),
(146, NULL, 'Alpha Aliou Comoya ', '06', '', '06', '$2y$10$zbDIcLSPK0Zwo4MOhbeEtOlkDZ9YcA7qz6aZw2A2.Lyil72LbcZS2', 1, 'client', 1, 'client', '2024-01-17 20:10:02'),
(147, NULL, 'Dianee Mangoya ', '622801631', '', '622801631', '$2y$10$fd.TABMroeY82VwanO0OAOvaZgl9BXeLHyehfNssg0PlxAl2ulUI2', 1, 'client', 1, 'client', '2024-01-17 20:11:02'),
(148, NULL, 'Americain Boucheri ', '08', '', '08', '$2y$10$KJlxYUwxk5AIf5k0RUEa9OwjMjxQf2xg/eXxgWZmPgVE7kFUq2Mh2', 1, 'client', 1, 'client', '2024-01-17 20:12:18'),
(149, NULL, 'Ibrahima Kilee à côté tob', '98', '', '98', '$2y$10$bQJkCyBl3y8nOqrqmfipZOnK3HLAdwkFTT2cMQf7WGAm8LzNXkUwm', 1, 'client', 1, 'client', '2024-01-17 20:13:25'),
(150, NULL, 'Fofana Condeta3 ', '625829892', '', '625829892', '$2y$10$aQOb4C0gYmbCuhwNXpO5.eiYzS9yZXhr5Ncg7ilJPOJ0Z1VV7f.IS', 1, 'client', 1, 'client', '2024-01-17 20:15:13'),
(151, NULL, 'Yaya camokouye ', '099', '', '099', '$2y$10$beQWod4B89h2Ft9jGCult.hAiiwblevkwCU9zLBzSL1ALelDpOgQ6', 1, 'client', 1, 'client', '2024-01-17 20:16:23'),
(152, NULL, 'Mamadou alpha voix', '623784017', '', '623784017', '$2y$10$UzhJhdiPQ4fznegvEG3HxuE7lDJhwZtOg.NJX5RhQ2GVGZB2sv06y', 1, 'client', 1, 'client', '2024-01-17 20:18:05'),
(153, NULL, 'Thieoro  dadiya', '628892588', '', '628892588', '$2y$10$TshbGLfIb73BaSiwXzR1n.pUjEJpp9E6jZOibUb/5e986E0rsOjhG', 1, 'client', 1, 'client', '2024-01-17 20:20:53'),
(154, NULL, 'Habibatou Diallo Fuirguiabe ', '626402697', '', '626402697', '$2y$10$2fNA4RTedjk6OmSKrcT10.S9Q2pUpGlEWfFor.UAUbE3ZTttrdVpG', 1, 'client', 1, 'client', '2024-01-17 20:24:24'),
(155, NULL, 'Tanti Fatoumata Maitresse  comoya ', '664432642', '', '664432642', '$2y$10$weJC1nu7uLgQ.n/m.iW6De.MuAmNkcZiFdYqB9VH5TuZFlmxk2sCK', 1, 'client', 1, 'client', '2024-01-17 20:32:28'),
(156, NULL, 'Ibrahima barry comoya jeune ', '626950213', '', '626950213', '$2y$10$kRqLz95AeKFUt90klk3CU.XNbgPhgQTFWZWekgfkhIQ7dF/E7FQFC', 1, 'client', 1, 'client', '2024-01-17 20:35:17'),
(157, NULL, 'Thierno Mawiatou comoya ', '627252809', '', '627252809', '$2y$10$J6EEkOnJdE0CPW7STMm6ZeQ6EL5mYCT/3Dg3hBbywLSs.QGuM6p2S', 1, 'client', 1, 'client', '2024-01-17 20:36:29'),
(158, NULL, 'Thierno Saidou amis de kourou ', '90', '', '90', '$2y$10$svApVxRZs3mpEMTatUOxyOc9NBRUkWWw1sFVTc7sZbTE6eZPIeEZu', 1, 'client', 1, 'client', '2024-01-17 20:37:36'),
(159, NULL, 'Vieux Koumbourou ', '622085697', '', '622085697', '$2y$10$RED/pvdumQpb94Ec/2eCm.aqj4tjcbu6CzxEk00CLRMgxpSDnBCQ6', 1, 'client', 1, 'client', '2024-01-17 20:38:35'),
(160, NULL, 'Bah Mamadou Saliou mogoya', '621182679', '', '621182679', '$2y$10$kMJjaQk8STi92U0bQk2vUOJq8psfkQ1ZQYyvGzjyasvjpI1aJ8OFy', 1, 'client', 1, 'client', '2024-01-17 20:43:15'),
(161, NULL, 'Tanti Aissa Livraport ', '621408292', '', '621408292', '$2y$10$9Qq9qEgHq2rFfAI.CGMr3eIJ5LB7r5LuGXgezBDyqMNApiqQtuLMe', 1, 'client', 1, 'client', '2024-01-17 20:45:37'),
(162, NULL, 'Alpha barry cohien', '89', '', '89', '$2y$10$McDqfSkCuavs246Sy.lDxuVZA5SoYe87OyIf7s/FIZ36V7z0sbRtC', 1, 'client', 1, 'client', '2024-01-17 20:47:34'),
(163, NULL, 'Thierno Saidou sow kourawi ', '45', '', '45', '$2y$10$R0JqH83XDcQd8NV5Kn4eg.sCAoIRWonaNetJHCLmK8gbt9FMFt6eS', 1, 'client', 1, 'client', '2024-01-17 20:59:24'),
(164, NULL, 'Boubacar fils de galle Bourouwi ', '623178297', '', '623178297', '$2y$10$RPQFcN/BsirQUN/NkoSYxeTj5PWYz055Ri3Liroyaaj6/f9.eEh7u', 1, 'client', 1, 'client', '2024-01-17 21:01:36'),
(165, NULL, 'Ibrahima Kendouma ', '628879239', '', '628879239', '$2y$10$49oD1CLkz/b2BJpTSaOfde/t.kndHcwI5w7eBmwsiq0zqBmx4d61a', 1, 'client', 1, 'client', '2024-01-17 21:04:24'),
(166, NULL, 'Monsieur Souleymane Foulayah ', '622747454', '', '622747454', '$2y$10$WpNTx0THXo/ARZbiyIVAC.TI9I1sqFuRWpRqHUxE4rYgLKfhGVLpW', 1, 'client', 1, 'client', '2024-01-17 21:12:38'),
(167, NULL, 'Diariou cliente d’étaile ', '78', '', '78', '$2y$10$P0eJFa6//3OEn.lp49bhR.ooLCGVxWFa8a61o21Mc3LgKuEp0dS1C', 1, 'client', 1, 'client', '2024-01-17 21:14:01'),
(168, NULL, 'Ansoumane syla Wondi ', '611318427', '', '611318427', '$2y$10$FC/oUWlggF9UWI1AQOy7W.Ei/6e54dUZiux2k8/Cclj25t.I0MWy.', 1, 'client', 1, 'client', '2024-01-17 21:22:12'),
(169, NULL, 'Sow orange money ', '622989967', '', '622989967', '$2y$10$DF7FjyrCNB.tqtptFO8R/.G41/575mytlKfdQYIKeoRQUZMocPEUq', 1, 'client', 1, 'client', '2024-01-17 21:26:48'),
(170, NULL, 'Monsieur ly à côté de Soul jus ', '610047174', '', '610047174', '$2y$10$Fncnx3PYTqQCc2knZ9Cux.lI55qk.Q2IZZbGOUebJrxFQgFYagZtS', 1, 'client', 1, 'client', '2024-01-17 21:29:09'),
(171, NULL, 'Ibrahima comoya ', '623946830', '', '623946830', '$2y$10$Xe.luFksKEVsB7.7JAWIqu9/A1nIhOgB1XeJbaiXi1u96s43hZuCm', 1, 'client', 1, 'client', '2024-01-17 21:32:38'),
(172, NULL, 'Frère de Aladji moussa Habilaya ', '627137418', '', '627137418', '$2y$10$ilTfsEvK8Lu3gs4scgBcT.OzSUmzssDsi9QWn.fBMqIAPoslYmAxe', 1, 'client', 1, 'client', '2024-01-17 21:36:48'),
(173, NULL, 'Mamadou Djoulde boucheri', '610429239', '', '610429239', '$2y$10$bHAz.8ZNgUd8ROr.QnkUYurlsS7We39FvTNJ1P4XZUPQe5zehWsUC', 1, 'client', 1, 'client', '2024-01-17 21:41:54'),
(174, NULL, 'Hawa Thiam ', '620269367', '', '620269367', '$2y$10$287NjP/liGl8aZQY5FhGQOIXrbUThA7jjAXh/wvj./I622oQoTClm', 1, 'client', 1, 'client', '2024-01-17 21:43:43'),
(175, NULL, 'Bobo Pouly ', '633784094', '', '633784094', '$2y$10$8zxfYKKrizpQYC6csU2.Duqpmjxg7WNernEj9nArpAdVPa5L5sLny', 1, 'client', 1, 'client', '2024-01-17 21:46:39'),
(176, NULL, 'Ismael Leycompagni ', '628330795', '', '628330795', '$2y$10$q2XAKcAEpTQcRgJtaSmBze5JwU9fU4WBJRcwHf0TylYRPpjGgPc.W', 1, 'client', 1, 'client', '2024-01-17 21:52:42'),
(177, NULL, 'Kadiatou bah 03avrile ', '11', '', '11', '$2y$10$uiU1RHY71Zp5bxnMwS1lG.FsH/LN498oFjnrvD6pBNuz1ljLVc9Je', 1, 'client', 1, 'client', '2024-01-17 21:54:16'),
(178, NULL, 'Aista Phalesarai  TapiyoKa ', '7655000', '', '7655000', '$2y$10$FAiLXELHfFCzkVC5ihPUOu/BsalipqHgLttJUL0BT6Cur3cp/2pb2', 1, 'client', 1, 'client', '2024-01-17 21:56:10'),
(179, NULL, 'Ma binty planète ', '620042040', '', '620042040', '$2y$10$lJIk/d8S6.T80cFSCj.JLe5DK95VvIoCIo0/OdIVQcYUl4Tkzx44i', 1, 'client', 1, 'client', '2024-01-17 21:58:59'),
(180, NULL, 'Ramatoulaye Sambaya ', '628457208', '', '628457208', '$2y$10$OcZrX1fcVsRRpcoTEB3Q0.JZaF0MJFImnRAMXErJfw6DGelky0Ru2', 1, 'client', 1, 'client', '2024-01-17 22:00:31'),
(181, NULL, 'Mamadou alpha Winda ', '612877074', '', '612877074', '$2y$10$vJCE5CvIfsYIaFJVzNBiJucnwguY/uSAkcswfLQsueB4DycBFkR6W', 1, 'client', 1, 'client', '2024-01-17 22:02:01'),
(182, NULL, 'Thierno Abdoule', '622025654', '', '622025654', '$2y$10$fW6r7NBl4Yo7WbwKqjgEgOyDu58mXIkzw1R9BCeHs5sVCPwTMQ.Ke', 1, 'clientf', 1, 'clientf', '2024-01-18 10:27:45'),
(183, NULL, 'Diarahie comoya', '622276378', '', '622276378', '$2y$10$rGzal9fMnr6cVjF5jZEO1uDDeK0yPa0s2F.J/1K8MQ.p4c/7ypmaO', 1, 'client', 1, 'client', '2024-01-18 12:53:46');

-- --------------------------------------------------------

--
-- Structure de la table `logo`
--

CREATE TABLE `logo` (
  `id` int(11) NOT NULL,
  `name` varchar(155) NOT NULL,
  `nbrevente` float DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `modep`
--

CREATE TABLE `modep` (
  `id` int(11) NOT NULL,
  `numpaiep` varchar(50) NOT NULL,
  `caisse` varchar(20) DEFAULT NULL,
  `client` int(11) DEFAULT NULL,
  `montant` double DEFAULT NULL,
  `modep` varchar(20) NOT NULL,
  `taux` float DEFAULT NULL,
  `numerocheque` varchar(50) DEFAULT NULL,
  `banquecheque` varchar(100) DEFAULT NULL,
  `etatcheque` varchar(50) DEFAULT 'non traite',
  `datefact` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `modep`
--

INSERT INTO `modep` (`id`, `numpaiep`, `caisse`, `client`, `montant`, `modep`, `taux`, `numerocheque`, `banquecheque`, `etatcheque`, `datefact`) VALUES
(29, 'acf240024', '1', 1, 1025000, 'gnf', 1, NULL, NULL, 'non traite', '2024-01-18 12:30:34'),
(26, 'acf240022', '1', 1, 498000, 'gnf', 1, NULL, NULL, 'non traite', '2024-01-18 09:34:01'),
(24, 'acf240020', '1', 1, 695000, 'gnf', 1, NULL, NULL, 'non traite', '2024-01-18 09:11:41'),
(23, 'acf240019', '1', 1, 45000, 'gnf', 1, NULL, NULL, 'non traite', '2024-01-18 09:09:52'),
(22, 'acf240018', '1', 1, 468000, 'gnf', 1, NULL, NULL, 'non traite', '2024-01-18 09:04:35'),
(20, 'dep9', '1', 77, 1600000, 'espèces', 1, '', '', 'non traite', '2024-01-16 00:00:00'),
(21, 'dep10', '1', 16, 2942000, 'espèces', 1, '', '', 'non traite', '2024-01-16 20:06:25'),
(28, 'acf240023', '1', 1, 735000, 'gnf', 1, NULL, NULL, 'non traite', '2024-01-18 09:54:35'),
(27, 'dep11', '1', 38, 5100000, 'espèces', 1, '', '', 'non traite', '2024-01-18 09:49:01'),
(25, 'acf240021', '1', 1, 50000, 'gnf', 1, NULL, NULL, 'non traite', '2024-01-18 09:21:54'),
(19, 'dep8', '1', 77, 2000000, 'espèces', 1, '', '', 'non traite', '2024-01-15 15:57:01'),
(18, 'dep1', '1', 46, 8030000, 'espèces', 1, '', '', 'non traite', '2024-01-15 10:43:39'),
(30, 'acf240025', '1', 1, 1698000, 'gnf', 1, NULL, NULL, 'non traite', '2024-01-18 12:56:56'),
(31, 'acf240026', '1', 1, 572000, 'gnf', 1, NULL, NULL, 'non traite', '2024-01-18 13:16:00'),
(32, 'dep12', '1', 51, 4000000, 'espèces', 1, '', '', 'non traite', '2024-01-18 13:18:56'),
(33, 'acf240027', '1', 1, 240000, 'gnf', 1, NULL, NULL, 'non traite', '2024-01-18 13:58:35'),
(34, 'dep13', '1', 81, 150000, 'espèces', 1, '', '', 'non traite', '2024-01-18 16:31:00'),
(35, 'acf240029', '1', 1, 3900000, 'gnf', 1, NULL, NULL, 'non traite', '2024-01-18 00:00:00'),
(36, 'dep14', '1', 52, 30000000, 'espèces', 1, '', '', 'non traite', '2024-01-18 00:00:00'),
(37, 'acf240031', '1', 1, 6566993, 'gnf', 1, NULL, NULL, 'non traite', '2024-01-18 20:32:00'),
(38, 'acf240032', '1', 1, 416988, 'gnf', 1, NULL, NULL, 'non traite', '2024-01-18 20:45:39'),
(39, 'acf240033', '1', 1, 3972000, 'gnf', 1, NULL, NULL, 'non traite', '2024-01-18 21:20:47');

-- --------------------------------------------------------

--
-- Structure de la table `modifcommande`
--

CREATE TABLE `modifcommande` (
  `id` int(11) NOT NULL,
  `num_cmd` varchar(50) NOT NULL,
  `exec` int(11) NOT NULL,
  `dateop` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `modifcommande`
--

INSERT INTO `modifcommande` (`id`, `num_cmd`, `exec`, `dateop`) VALUES
(1, 'acf240004', 2, '2024-01-12 19:13:08');

-- --------------------------------------------------------

--
-- Structure de la table `modifpayement`
--

CREATE TABLE `modifpayement` (
  `id` int(11) NOT NULL,
  `num_cmd` varchar(50) NOT NULL,
  `Total` double NOT NULL,
  `fraisup` double DEFAULT 0,
  `montantpaye` double DEFAULT 0,
  `remise` double DEFAULT 0,
  `reste` double NOT NULL,
  `etat` varchar(155) NOT NULL,
  `etatliv` varchar(20) NOT NULL DEFAULT 'nonlivre',
  `vendeur` varchar(155) DEFAULT NULL,
  `num_client` int(10) DEFAULT NULL,
  `nomclient` varchar(150) DEFAULT NULL,
  `caisse` int(11) NOT NULL,
  `lieuvente` varchar(10) DEFAULT NULL,
  `date_cmd` datetime NOT NULL,
  `date_regul` datetime DEFAULT NULL,
  `datealerte` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `modifpayement`
--

INSERT INTO `modifpayement` (`id`, `num_cmd`, `Total`, `fraisup`, `montantpaye`, `remise`, `reste`, `etat`, `etatliv`, `vendeur`, `num_client`, `nomclient`, `caisse`, `lieuvente`, `date_cmd`, `date_regul`, `datealerte`) VALUES
(1, 'acf240004', 12465000, 0, 0, 0, 12465000, 'credit', 'nonlivre', '2', 14, NULL, 1, '1', '2024-01-12 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `modifpayementprod`
--

CREATE TABLE `modifpayementprod` (
  `id` int(11) NOT NULL,
  `id_produit` int(11) DEFAULT NULL,
  `prix_vente` double DEFAULT NULL,
  `prix_achat` double DEFAULT 0,
  `prix_revient` double DEFAULT 0,
  `quantity` int(11) NOT NULL,
  `qtiteliv` int(11) DEFAULT 0,
  `etatlivcmd` varchar(10) DEFAULT 'nonlivre',
  `num_cmd` varchar(50) NOT NULL,
  `id_client` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `modifpayementprod`
--

INSERT INTO `modifpayementprod` (`id`, `id_produit`, `prix_vente`, `prix_achat`, `prix_revient`, `quantity`, `qtiteliv`, `etatlivcmd`, `num_cmd`, `id_client`) VALUES
(1, 12, 45000, 0, 0, 1, 0, 'nonlivre', 'acf240004', 14),
(2, 11, 90000, 0, 85000, 50, 0, 'nonlivre', 'acf240004', 14),
(3, 9, 66000, 0, 65000, 20, 0, 'nonlivre', 'acf240004', 14),
(4, 3, 66000, 0, 65000, 100, 0, 'nonlivre', 'acf240004', 14);

-- --------------------------------------------------------

--
-- Structure de la table `modifprix`
--

CREATE TABLE `modifprix` (
  `id` int(11) NOT NULL,
  `id_produit` int(10) NOT NULL,
  `prix_vente` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `nombanque`
--

CREATE TABLE `nombanque` (
  `id` int(11) NOT NULL,
  `nomb` varchar(50) NOT NULL,
  `numero` varchar(100) DEFAULT NULL,
  `type` varchar(50) DEFAULT 'banque',
  `lieuvente` int(11) DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `nombanque`
--

INSERT INTO `nombanque` (`id`, `nomb`, `numero`, `type`, `lieuvente`) VALUES
(1, 'caisse général', NULL, 'caisse', 1),
(23, 'BANQUE MARCO', '23', 'banque', 1),
(24, 'BANQUE ISLAMIQUE', '24', 'banque', 1),
(25, 'VISTA GUI', '25', 'banque', 1);

-- --------------------------------------------------------

--
-- Structure de la table `numerocommande`
--

CREATE TABLE `numerocommande` (
  `id` int(11) NOT NULL,
  `numero` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `numerocommande`
--

INSERT INTO `numerocommande` (`id`, `numero`) VALUES
(1, 'acf240001'),
(2, 'acf240002'),
(3, 'acf240003'),
(4, 'acf240004'),
(5, 'acf240005'),
(6, 'acf240006'),
(7, 'acf240007'),
(8, 'acf240008'),
(9, 'acf240009'),
(10, 'acf240010'),
(11, 'acf240011'),
(12, 'acf240012'),
(13, 'acf240013'),
(14, 'acf240014'),
(15, 'acf240015'),
(16, 'acf240016'),
(17, 'acf240017'),
(18, 'acf240018'),
(19, 'acf240019'),
(20, 'acf240020'),
(21, 'acf240021'),
(22, 'acf240022'),
(23, 'acf240023'),
(24, 'acf240024'),
(25, 'acf240025'),
(26, 'acf240026'),
(27, 'acf240027'),
(28, 'acf240028'),
(29, 'acf240029'),
(30, 'acf240030'),
(31, 'acf240031'),
(32, 'acf240032'),
(33, 'acf240033'),
(34, 'acf240034');

-- --------------------------------------------------------

--
-- Structure de la table `paiecred`
--

CREATE TABLE `paiecred` (
  `id` int(11) NOT NULL,
  `numero` varchar(50) NOT NULL,
  `montant` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `paiecredcmd`
--

CREATE TABLE `paiecredcmd` (
  `id` int(11) NOT NULL,
  `numero` varchar(50) NOT NULL,
  `montant` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `payement`
--

CREATE TABLE `payement` (
  `id` int(11) NOT NULL,
  `num_cmd` varchar(50) NOT NULL,
  `Total` double NOT NULL,
  `fraisup` double DEFAULT 0,
  `montantpaye` double DEFAULT 0,
  `remise` double DEFAULT 0,
  `reste` double NOT NULL,
  `etat` varchar(155) NOT NULL,
  `etatliv` varchar(20) NOT NULL DEFAULT 'nonlivre',
  `vendeur` varchar(155) DEFAULT NULL,
  `num_client` int(10) DEFAULT NULL,
  `nomclient` varchar(150) DEFAULT NULL,
  `caisse` int(11) NOT NULL,
  `lieuvente` varchar(10) DEFAULT NULL,
  `date_cmd` datetime NOT NULL,
  `date_regul` datetime DEFAULT NULL,
  `datealerte` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `payement`
--

INSERT INTO `payement` (`id`, `num_cmd`, `Total`, `fraisup`, `montantpaye`, `remise`, `reste`, `etat`, `etatliv`, `vendeur`, `num_client`, `nomclient`, `caisse`, `lieuvente`, `date_cmd`, `date_regul`, `datealerte`) VALUES
(32, 'acf240031', 6566993, 0, 6566993, 0, 0, 'totalite', 'livre', '9', 1, NULL, 1, '1', '2024-01-18 20:32:00', NULL, NULL),
(31, 'acf240030', 9155000, 0, 0, 0, 9155000, 'credit', 'livre', '2', 41, NULL, 1, '1', '2024-01-18 00:00:00', NULL, '2024-01-18'),
(30, 'acf240029', 3900000, 0, 3900000, 0, 0, 'totalite', 'livre', '2', 1, NULL, 1, '1', '2024-01-18 00:00:00', NULL, '2024-01-18'),
(29, 'acf240028', 7800000, 0, 0, 0, 7800000, 'credit', 'livre', '2', 52, NULL, 1, '1', '2024-01-18 16:06:57', NULL, NULL),
(28, 'acf240027', 240000, 0, 240000, 0, 0, 'totalite', 'livre', '2', 1, NULL, 1, '1', '2024-01-18 13:58:35', NULL, NULL),
(27, 'acf240026', 572000, 0, 572000, 0, 0, 'totalite', 'livre', '2', 1, NULL, 1, '1', '2024-01-18 13:16:00', NULL, NULL),
(26, 'acf240025', 1698000, 0, 1698000, 0, 0, 'totalite', 'livre', '2', 1, NULL, 1, '1', '2024-01-18 12:56:56', NULL, NULL),
(25, 'acf240024', 1025000, 0, 1025000, 0, 0, 'totalite', 'livre', '9', 1, NULL, 1, '1', '2024-01-18 12:30:34', NULL, NULL),
(24, 'acf240023', 735000, 0, 735000, 0, 0, 'totalite', 'livre', '2', 1, NULL, 1, '1', '2024-01-18 09:54:35', NULL, NULL),
(23, 'acf240022', 498000, 0, 498000, 0, 0, 'totalite', 'livre', '2', 1, NULL, 1, '1', '2024-01-18 09:34:01', NULL, NULL),
(21, 'acf240020', 695000, 0, 695000, 0, 0, 'totalite', 'livre', '2', 1, NULL, 1, '1', '2024-01-18 09:11:41', NULL, NULL),
(22, 'acf240021', 50000, 0, 50000, 0, 0, 'totalite', 'livre', '2', 1, NULL, 1, '1', '2024-01-18 09:21:54', NULL, NULL),
(20, 'acf240019', 45000, 0, 45000, 0, 0, 'totalite', 'livre', '2', 1, NULL, 1, '1', '2024-01-18 09:09:52', NULL, NULL),
(19, 'acf240018', 468000, 0, 468000, 0, 0, 'totalite', 'livre', '2', 1, NULL, 1, '1', '2024-01-18 09:04:35', NULL, NULL),
(33, 'acf240032', 416988, 0, 416988, 0, 0, 'totalite', 'livre', '9', 1, NULL, 1, '1', '2024-01-18 20:45:39', NULL, NULL),
(34, 'acf240033', 3972000, 0, 3972000, 0, 0, 'totalite', 'livre', '2', 1, NULL, 1, '1', '2024-01-18 21:20:47', NULL, NULL),
(35, 'acf240034', 9150000, 0, 0, 0, 9150000, 'credit', 'livre', '2', 38, NULL, 1, '1', '2024-01-18 21:23:10', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `personnel`
--

CREATE TABLE `personnel` (
  `id` int(11) NOT NULL,
  `identifiant` int(10) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `telephone` varchar(15) DEFAULT NULL,
  `lieuvente` int(11) NOT NULL,
  `pseudo` varchar(15) NOT NULL,
  `mdp` mediumtext NOT NULL,
  `level` int(10) NOT NULL,
  `statut` varchar(100) NOT NULL,
  `dateenreg` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `pertes`
--

CREATE TABLE `pertes` (
  `id` int(11) NOT NULL,
  `idpertes` int(11) NOT NULL,
  `idnomstockp` int(11) NOT NULL,
  `prix_achat` double DEFAULT NULL,
  `prix_revient` double DEFAULT NULL,
  `prix_vente` double DEFAULT NULL,
  `quantite` float DEFAULT NULL,
  `motifperte` varchar(150) DEFAULT NULL,
  `datepertes` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `pertes`
--

INSERT INTO `pertes` (`id`, `idpertes`, `idnomstockp`, `prix_achat`, `prix_revient`, `prix_vente`, `quantite`, `motifperte`, `datepertes`) VALUES
(1, 0, 1, 0, 0, 0, 1, '1', '2024-01-14'),
(2, 11, 1, 0, 0, 0, 1, '1', '2024-01-14'),
(3, 12, 1, 0, 0, 0, -2, '1', '2024-01-14'),
(4, 31, 1, 0, 0, 0, 1, '1', '2024-01-14'),
(5, 32, 1, 0, 0, 0, -2, '1', '2024-01-14'),
(6, 9, 1, 0, 0, 0, 1, '1', '2024-01-14'),
(7, 10, 1, 0, 0, 0, -2, '1', '2024-01-14'),
(8, 139, 1, 0, 0, 0, 68000, '1', '2024-01-18'),
(9, 100, 1, 0, 0, 0, 51, '1', '2024-01-18'),
(10, 100, 1, 0, 0, 0, 5, '1', '2024-01-18'),
(13, 0, 1, 0, 0, 0, -34, '1', '2024-01-18'),
(14, 25, 1, 0, 0, 0, -34, '1', '2024-01-18');

-- --------------------------------------------------------

--
-- Structure de la table `productslist`
--

CREATE TABLE `productslist` (
  `id` int(11) NOT NULL,
  `codeb` varchar(150) DEFAULT NULL,
  `Marque` varchar(150) NOT NULL,
  `designation` varchar(150) NOT NULL,
  `pventel` double DEFAULT 0,
  `codecat` int(10) DEFAULT NULL,
  `nbrevente` int(10) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `qtiteint` varchar(10) DEFAULT '0',
  `qtiteintp` int(10) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `productslist`
--

INSERT INTO `productslist` (`id`, `codeb`, `Marque`, `designation`, `pventel`, `codecat`, `nbrevente`, `type`, `qtiteint`, `qtiteintp`) VALUES
(1, '', 'Jmr', 'Jus Messi Rouge', 66000, 1, 0, 'en_gros', '30', 0),
(2, '', 'Jmr', 'Jus Messi Rouge Detail', 3000, 1, 0, 'detail', '0', 0),
(3, '', 'Jma', 'Jus Messi Ananas', 66000, 1, 0, 'en_gros', '30', 0),
(4, '', 'Jma', 'Jus Messi Ananas Detail', 3000, 1, 0, 'detail', '0', 0),
(5, '', 'Jmo', 'Jus Messi Orange', 66000, 1, 0, 'en_gros', '30', 0),
(6, '', 'Jmo', 'Jus Messi Orange Detail', 3000, 1, 0, 'detail', '0', 0),
(7, '', 'Jmc', 'Jus Messi  Cocteil', 66000, 1, 0, 'en_gros', '30', 0),
(8, '', 'Jmc', 'Jus Messi  Cocteil Detail', 3000, 1, 0, 'detail', '0', 0),
(9, '', 'Jmt', 'Jus Messi Tamaraine', 66000, 1, 0, 'en_gros', '30', 0),
(10, '', 'Jmt', 'Jus Messi Tamaraine Detail', 3000, 1, 0, 'detail', '0', 0),
(11, '', 'Berciaop', 'Beurre Ciao900g', 90000, 7, 0, 'en_gros', '2', 1),
(12, '', 'Berciaop', 'Beurre Ciao900g Detail', 45000, 7, 0, 'detail', '0', 1),
(13, '', 'Zazao', 'Jus Zaza Orange', 63000, 2, 0, 'en_gros', '30', 0),
(14, '', 'zazao', 'jus zaza orange detail', 0, 2, 0, 'detail', '0', 0),
(15, '', 'Zazaf', 'Jus Zaza Fraiche', 63000, 2, 0, 'en_gros', '30', 0),
(16, '', 'zazaf', 'jus zaza fraiche detail', 0, 2, 0, 'detail', '0', 0),
(17, '', 'Zazavp', 'Jus Zaza Vimto Petit', 63000, 2, 0, 'en_gros', '30', 0),
(18, '', 'zazavp', 'jus zaza vimto petit detail', 0, 2, 0, 'detail', '0', 0),
(19, '', 'Huile Ciao 20l', 'Huile 20l', 255000, 14, 0, 'en_gros', '0', 0),
(20, '', 'HUILE CIAO 10L', 'Huile ciao 10l', 135000, 14, 0, 'en_gros', '0', 0),
(21, '', 'eo', 'eau petit', 20000, 13, 0, 'en_gros', '', 1),
(22, '', 'eo', 'eau petit paquet', 0, 13, 0, 'paquet', '', 0),
(23, '', 'Jvdm', 'Jus Vandam Sipa Grand', 39000, 3, 0, 'en_gros', '12', 0),
(24, '', 'Jvdm', 'Jus Vandam Sipa Grand Detail', 0, 3, 0, 'detail', '0', 0),
(25, '', 'Jvdp', 'Jus Vandam Sipa Petit', 34000, 3, 0, 'en_gros', '12', 0),
(26, '', 'jvdp', 'jus vandam sipa petit detail', 0, 3, 0, 'detail', '0', 0),
(27, '', 'Jvdb', 'Jus Vandam Boite', 85000, 3, 0, 'en_gros', '24', 0),
(28, '', 'jvdb', 'jus vandam boite detail', 0, 3, 0, 'detail', '0', 0),
(29, '', 'Jsk', 'Jus Sagiko Mangue', 155000, 5, 0, 'en_gros', '24', 0),
(30, '', 'Jsk', 'Jus Sagiko Mangue Detail', 0, 5, 0, 'detail', '0', 0),
(31, '', 'Ftalos', 'Jus Fruitalos Ananas', 120000, 5, 0, 'en_gros', '24', 0),
(32, '', 'Ftalos', 'Jus Fruitalos Ananas Detail', 0, 5, 0, 'detail', '0', 0),
(33, '', 'Arf', 'Jus Fruit Arafa Tamarin', 135000, 5, 0, 'en_gros', '24', 0),
(34, '', 'Arf', 'Jus Fruit Arafa Tamarin Detail', 0, 5, 0, 'detail', '0', 0),
(35, '', 'Wfa', 'Jus Wofa ananas', 50000, 5, 0, 'en_gros', '0', 0),
(36, '', 'jus24', '24h petit', 35000, 10, 0, 'en_gros', '0', 0),
(37, '', '24g', 'jus 24h grand', 40000, 10, 0, 'en_gros', '0', 0),
(38, '', 't24', 'jus tonic 24h petit', 35000, 10, 0, 'en_gros', '0', 0),
(39, '', 'tm24', 'jus tamerine 24h petit', 35000, 10, 0, 'en_gros', '0', 0),
(59, '', 'Beurre 4kg', 'Beurre Ciao 4.5kg Detail', 75000, 7, 0, 'detail', '0', 0),
(58, '', 'Beurre 4KG', 'Beurre Ciao 4.5kg', 260000, 7, 0, 'en_gros', '4', 0),
(44, '', 'Jsp', 'Jus sprete 24h', 35000, 10, 0, 'en_gros', '0', 0),
(45, '', 'Jcb', 'Jus Coca Boite', 125000, 5, 0, 'en_gros', '24', 0),
(46, '', 'Jfb', 'Jus fanta boite', 125000, 10, 0, 'en_gros', '0', 0),
(47, '', 'Jbona', 'jus fanta bonagui', 63000, 5, 0, 'en_gros', '0', 0),
(48, '', 'Jccbn', 'Jus Coca Bonagui', 63000, 5, 0, 'en_gros', '0', 0),
(49, '', 'My5l', 'Mayonaise ciao 5l', 355000, 6, 0, 'en_gros', '2', 4),
(50, '', 'My5l', 'Mayonaise Ciao 5l Detail', 0, 6, 0, 'detail', '4', 0),
(51, '', 'My5l', 'Mayonaise ciao 5l paquet', 0, 6, 0, 'paquet', '2', 0),
(52, '', 'My32', 'Mayonaise Ciao 32', 255000, 6, 0, 'en_gros', '12', 6),
(53, '', 'My32', 'Mayonaise Ciao 32 Detail', 0, 6, 0, 'detail', '12', 0),
(54, '', 'My32', 'Mayonaise Ciao 32 Paquet', 0, 6, 0, 'paquet', '6', 0),
(55, '', 'Myglon', 'Mayonaise ciao gallon', 305000, 6, 0, 'en_gros', '2', 4),
(56, '', 'Myglon', 'Mayonaise Ciao Gallon Detail', 0, 6, 0, 'detail', '4', 0),
(57, '', 'Myglon', 'Mayonaise ciao gallon paquet', 0, 6, 0, 'paquet', '2', 0),
(60, '', 'HC5L', 'Huile ciao 5l', 260000, 14, 0, 'en_gros', '4', 0),
(61, '', 'Hc5l', 'Huile Ciao 5l Detail', 70000, 14, 0, 'detail', '0', 0),
(62, '', 'jrmc', 'jus rama cocteil sipa', 33000, 4, 0, 'en_gros', '12', 0),
(63, '', 'jrmc', 'jus rama cocteil sipa detail', 0, 4, 0, 'detail', '0', 0),
(64, '', 'jrmb', 'jus rama cocteil boite', 80000, 4, 0, 'en_gros', '24', 0),
(65, '', 'jrmb', 'jus rama cocteil boite detail', 0, 4, 0, 'detail', '0', 0),
(66, '', 'jrmbo', 'Jus rama orang boite', 80000, 4, 0, 'en_gros', '24', 0),
(67, '', 'jrmbo', 'Jus rama orang boite detail', 0, 4, 0, 'detail', '0', 0),
(68, '', 'jrmb A', 'jus rama ananas boite', 80000, 4, 0, 'en_gros', '24', 0),
(69, '', 'jrmb A', 'jus rama ananas boite detail', 0, 4, 0, 'detail', '0', 0),
(70, '', 'jrmb t', 'jus rama tamerine boite', 80000, 4, 0, 'en_gros', '24', 0),
(71, '', 'jrmb t', 'jus rama tamerine boite detail', 0, 4, 0, 'detail', '0', 0),
(72, '', 'Plnc', 'Jus Planete Cocteil', 35000, 5, 0, 'en_gros', '12', 0),
(73, '', 'Plnc', 'Jus Planete Cocteil Detail', 0, 5, 0, 'detail', '0', 0),
(74, '', '3JRG', '3JOURS GROS', 38000, 8, 0, 'en_gros', '12', 0),
(75, '', '3JRG', '3JOURS GROS detail', 0, 8, 0, 'detail', '0', 0),
(76, '', 'pln0', 'Jus planete orange', 35000, 5, 0, 'en_gros', '12', 0),
(77, '', 'pln0', 'Jus planete orange detail', 0, 5, 0, 'detail', '0', 0),
(78, '', '3JRP', '3JOURS PETIT', 33000, 8, 0, 'en_gros', '12', 0),
(79, '', '3JRP', '3JOURS PETIT detail', 0, 8, 0, 'detail', '0', 0),
(80, '', 'AMCLA', 'Jus Americain cola', 35000, 5, 0, 'en_gros', '12', 0),
(81, '', 'AMCLA', 'Jus Americain cola detail', 0, 5, 0, 'detail', '0', 0),
(82, '', 'ZVG', 'ZAZA VIMTO GRAND', 80000, 2, 0, 'en_gros', '24', 0),
(83, '', 'ZVG', 'ZAZA VIMTO GRAND detail', 0, 2, 0, 'detail', '0', 0),
(84, '', 'RCTR', 'Jus reactore', 40000, 5, 0, 'en_gros', '12', 0),
(85, '', 'RCTR', 'Jus reactore detail', 0, 5, 0, 'detail', '0', 0),
(86, '', 'Jrsgko', 'Jus Sagiko Tamerine', 150000, 5, 0, 'en_gros', '24', 0),
(87, '', 'Jrsgko', 'Jus Sagiko tamerine detail', 0, 5, 0, 'detail', '0', 0),
(88, '', 'Jsgko A', 'Jus Sagiko Ananas ', 150000, 5, 0, 'en_gros', '24', 0),
(89, '', 'Jsgko a', 'Jus Sagiko ananas  detail', 0, 5, 0, 'detail', '0', 0),
(90, '', 'Jsgko M', 'Jus Sagiko Mix', 150000, 5, 0, 'en_gros', '24', 0),
(91, '', 'Jsgko m', 'Jus Sagiko mix detail', 0, 5, 0, 'detail', '0', 0),
(92, '', 'Sagiko O', 'Jus Sagiko Orang ', 150000, 5, 0, 'en_gros', '24', 0),
(93, '', 'Sagiko o', 'Jus Sagiko Orang  detail', 0, 5, 0, 'detail', '0', 0),
(94, '', 'Jfra', 'Jus Fruit  Arafa Ananas', 140000, 5, 0, 'en_gros', '24', 0),
(95, '', 'Jfra', 'Jus Fruit  Arafa Ananas  Detail', 0, 5, 0, 'detail', '0', 0),
(96, '', 'Jus Fruit Arafa Orange', 'Jus Fruit Arafa Orange', 135000, 5, 0, 'en_gros', '24', 0),
(97, '', 'Jus Fruit Arafa Orange', 'Jus Fruit Arafa Orange detail', 0, 5, 0, 'detail', '0', 0),
(98, '', 'Jus Fruit Arafa Mangue', 'Jus Fruit Arafa Mangue', 135000, 5, 0, 'en_gros', '24', 0),
(99, '', 'Jus Fruit Arafa Mangue', 'Jus Fruit Arafa Mangue detail', 0, 5, 0, 'detail', '0', 0),
(100, '', 'Jus Fruit Arafa Cocktail', 'Jus Fruit Arafa Cocktail', 135000, 5, 0, 'en_gros', '24', 0),
(101, '', 'Jus Fruit Arafa Cocktail', 'Jus Fruit Arafa Cocktail detail', 0, 5, 0, 'detail', '0', 0),
(102, '', 'Jus Fruitalos Tamarin', 'Jus Fruitalos Tamarin', 120000, 5, 0, 'en_gros', '24', 0),
(103, '', 'Jus Fruitalos Tamarin', 'Jus Fruitalos Tamarin detail', 0, 5, 0, 'detail', '0', 0),
(104, '', 'Jus Fruitalos Cocktail', 'Jus Fruitalos Cocktail', 120000, 5, 0, 'en_gros', '24', 0),
(105, '', 'Jus Fruitalos Cocktail', 'Jus Fruitalos Cocktail detail', 0, 5, 0, 'detail', '0', 0),
(106, '', 'Jus Fruitalos Orange', 'Jus Fruitalos Orange', 120000, 5, 0, 'en_gros', '24', 0),
(107, '', 'Jus Fruitalos Orange', 'Jus Fruitalos Orange detail', 0, 5, 0, 'detail', '0', 0),
(108, '', 'Jus Fruitalos Mangue', 'Jus Fruitalos Mangue', 0, 5, 0, 'en_gros', '24', 0),
(109, '', 'Jus Fruitalos Mangue', 'Jus Fruitalos Mangue detail', 0, 5, 0, 'detail', '0', 0),
(110, '', 'Jus Fruitalos Sopsop ', 'Jus Fruitalos Soursop ', 0, 5, 0, 'en_gros', '24', 0),
(111, '', 'Jus Fruitalos Sopsop ', 'Jus Fruitalos Soursop  detail', 0, 5, 0, 'detail', '0', 0),
(112, '', 'Tonic Messi Cipa', 'Tonic Messi Cipa', 34000, 1, 0, 'en_gros', '12', 0),
(113, '', 'Tonic Messi Cipa', 'Tonic Messi Cipa detail', 0, 1, 0, 'detail', '0', 0),
(114, '', 'Savon Ciao Petit Rouge', 'Savon Ciao Petit Rouge', 0, 17, 0, 'en_gros', '', 0),
(115, '', 'Savon Ciao Petit Blanc', 'Savon Ciao Petit Blanc', 0, 17, 0, 'en_gros', '0', 0),
(116, '', 'Savon Ciao Moyen Blanc', 'Savon Ciao Moyen Blanc', 0, 17, 0, 'en_gros', '0', 0),
(117, '', 'Savon Ciao Moyen Rouge', 'Savon Ciao Moyen Rouge', 0, 17, 0, 'en_gros', '0', 0),
(118, '', 'Savon Ciao Grand Blanc', 'Savon Ciao Grand Blanc', 0, 7, 0, 'en_gros', '0', 0),
(119, '', 'Savon Ciao Grand Rouge', 'Savon Ciao Grand Rouge', 0, 17, 0, 'en_gros', '0', 0),
(120, '', 'Sprite ', 'Sprite ', 0, 5, 0, 'en_gros', '0', 0),
(121, '', 'Tonic Blanc', 'Tonic Blanc', 0, 5, 0, 'en_gros', '0', 0),
(122, '', 'Play Petit', 'Play Petit', 0, 5, 0, 'en_gros', '0', 0),
(123, '', 'XXL Boite', 'XXL Boite', 0, 5, 0, 'en_gros', '24', 0),
(124, '', 'XXL Boite', 'XXL Boite detail', 0, 5, 0, 'detail', '0', 0),
(125, '', 'Vimto Boite', 'Vimto Boite', 0, 5, 0, 'en_gros', '24', 0),
(126, '', 'Vimto Boite', 'Vimto Boite detail', 0, 5, 0, 'detail', '0', 0),
(127, '', 'Jus Arafa Soursop', 'Jus Arafa Soursop', 0, 5, 0, 'en_gros', '24', 0),
(128, '', 'Jus Arafa Soursop', 'Jus Arafa Soursop detail', 0, 5, 0, 'detail', '0', 0),
(129, '', 'Jus Vinut Ananas', 'jus Vinut Ananas', 0, 5, 0, 'en_gros', '24', 0),
(130, '', 'Jus Vinut Ananas', 'jus Vinut Ananas detail', 0, 5, 0, 'detail', '0', 0),
(131, '', 'Jus Vinut Soursop', 'Jus Vinut Soursop', 0, 5, 0, 'en_gros', '24', 0),
(132, '', 'Jus Vinut Soursop', 'Jus Vinut Soursop detail', 0, 5, 0, 'detail', '0', 0),
(133, '', 'Jus Arafa Guave', 'Jus Arafa Guave', 0, 5, 0, 'en_gros', '24', 0),
(134, '', 'Jus Arafa Guave', 'Jus Arafa Guave detail', 0, 5, 0, 'detail', '0', 0),
(135, '', 'U-Fresh Orange', 'U-Fresh Orange', 0, 5, 0, 'en_gros', '0', 0),
(136, '', 'U-Fresh Ananas', 'U-Fresh Ananas', 0, 5, 0, 'en_gros', '0', 0),
(137, '', 'U-Fresh Energie', 'U-Fresh Energie', 0, 5, 0, 'en_gros', '0', 0),
(138, '', 'U-fresh Petit Ananas', 'U-fresh Pega Ananas', 0, 5, 0, 'en_gros', '0', 0),
(139, '', 'U-Fresh cipa grand', 'U-Fresh cipa grand', 0, 5, 0, 'en_gros', '0', 0),
(140, '', 'U-Fresh Cipa petit', 'U-Fresh Cipa petit', 0, 5, 0, 'en_gros', '', 0),
(141, '', 'U-Fresh Pega Orange', 'U-Fresh Pega Orange', 0, 5, 0, 'en_gros', '0', 0),
(142, '', 'Tiktok', 'Tiktok', 0, 15, 0, 'en_gros', '0', 0),
(143, '', 'Jus Commando Cipa Grand', 'Jus Commando Cipa Grand', 0, 5, 0, 'en_gros', '12', 0),
(144, '', 'Jus Commando Cipa Grand', 'Jus Commando Cipa Grand detail', 0, 5, 0, 'detail', '0', 0);

-- --------------------------------------------------------

--
-- Structure de la table `proformat`
--

CREATE TABLE `proformat` (
  `id` int(11) NOT NULL,
  `id_produit` int(11) DEFAULT NULL,
  `num_pro` varchar(50) NOT NULL,
  `prix_vente` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `vendeur` varchar(100) NOT NULL,
  `id_client` int(10) DEFAULT NULL,
  `nomclient` varchar(150) DEFAULT NULL,
  `lieuvente` varchar(10) DEFAULT NULL,
  `datepro` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `proformat`
--

INSERT INTO `proformat` (`id`, `id_produit`, `num_pro`, `prix_vente`, `quantity`, `vendeur`, `id_client`, `nomclient`, `lieuvente`, `datepro`) VALUES
(1, 1, 'acfp240001', 66000, 1, '2', 7, NULL, '1', '2024-01-12 19:17:12'),
(2, 19, 'acfp240002', 250000, 10, '2', 21, NULL, '1', '2024-01-12 20:41:25'),
(3, 20, 'acfp240002', 130000, 1, '2', 21, NULL, '1', '2024-01-12 20:41:25'),
(4, 1, 'acfp240002', 66000, 1, '2', 21, NULL, '1', '2024-01-12 20:41:25'),
(5, 11, 'acfp240002', 90000, 1, '2', 21, NULL, '1', '2024-01-12 20:41:25'),
(6, 11, 'acfp240006', 90000, 10, '2', 14, NULL, '1', '2024-01-13 09:53:24'),
(7, 19, 'acfp240006', 255000, 20, '2', 14, NULL, '1', '2024-01-13 09:53:24'),
(8, 20, 'acfp240006', 135000, 1, '2', 14, NULL, '1', '2024-01-13 09:53:24'),
(9, 2, 'acfp240006', 33000, 1, '2', 14, NULL, '1', '2024-01-13 09:53:24'),
(10, 8, 'acfp240006', 35000, 1, '2', 14, NULL, '1', '2024-01-13 09:53:24'),
(11, 1, 'acfp240006', 66000, 1, '2', 14, NULL, '1', '2024-01-13 09:53:24');

-- --------------------------------------------------------

--
-- Structure de la table `promotion`
--

CREATE TABLE `promotion` (
  `id` int(11) NOT NULL,
  `idprod` int(11) NOT NULL,
  `achatmin` int(11) NOT NULL,
  `achatmax` int(11) NOT NULL,
  `qtite` float NOT NULL,
  `dated` date NOT NULL,
  `datef` date NOT NULL,
  `idnomstock` int(11) DEFAULT NULL,
  `dateop` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `recette`
--

CREATE TABLE `recette` (
  `id` int(11) NOT NULL,
  `numdec` varchar(50) DEFAULT 'retd26',
  `categorie` varchar(100) DEFAULT 'autres',
  `montant` double NOT NULL,
  `devisedep` varchar(20) NOT NULL,
  `payement` varchar(30) NOT NULL,
  `cprelever` varchar(50) DEFAULT 'caisse',
  `coment` varchar(150) DEFAULT NULL,
  `client` varchar(155) DEFAULT NULL,
  `lieuvente` varchar(10) DEFAULT NULL,
  `date_payement` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `retourlist`
--

CREATE TABLE `retourlist` (
  `id` int(11) NOT NULL,
  `numero` varchar(50) NOT NULL,
  `idprod` int(11) NOT NULL,
  `stockret` int(11) NOT NULL,
  `quantiteret` float NOT NULL,
  `pa` int(11) NOT NULL,
  `client` int(11) NOT NULL,
  `exect` int(11) NOT NULL,
  `dateop` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `retourlistclient`
--

CREATE TABLE `retourlistclient` (
  `id` int(11) NOT NULL,
  `numero` varchar(50) NOT NULL,
  `idprod` int(11) NOT NULL,
  `stockret` int(11) NOT NULL,
  `quantiteret` float NOT NULL,
  `pa` int(11) NOT NULL,
  `client` int(11) NOT NULL,
  `exect` int(11) NOT NULL,
  `dateop` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `statproduit`
--

CREATE TABLE `statproduit` (
  `id` int(11) NOT NULL,
  `idprod` int(11) NOT NULL,
  `qtitevendus` float DEFAULT NULL,
  `qtiteachat` float DEFAULT NULL,
  `montantvendus` double DEFAULT NULL,
  `montantachat` double DEFAULT NULL,
  `prvente` double DEFAULT NULL,
  `prachat` double DEFAULT NULL,
  `pseudo` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `nomstock` varchar(150) NOT NULL,
  `nombdd` varchar(150) NOT NULL,
  `coderesp` int(11) NOT NULL,
  `position` varchar(150) NOT NULL,
  `surface` float DEFAULT NULL,
  `nbrepiece` int(2) DEFAULT NULL,
  `adresse` varchar(200) NOT NULL,
  `lieuvente` int(11) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `stock`
--

INSERT INTO `stock` (`id`, `nomstock`, `nombdd`, `coderesp`, `position`, `surface`, `nbrepiece`, `adresse`, `lieuvente`) VALUES
(1, 'magasin principal', 'stock1', 2, 'kindia', 1500, 1, 'kindia', 1);

-- --------------------------------------------------------

--
-- Structure de la table `stock1`
--

CREATE TABLE `stock1` (
  `id` int(11) NOT NULL,
  `codeb` varchar(100) DEFAULT NULL,
  `idprod` int(10) NOT NULL,
  `prix_achat` double DEFAULT 0,
  `prix_revient` double DEFAULT 0,
  `prix_vente` double DEFAULT 0,
  `type` varchar(20) DEFAULT NULL,
  `quantite` float DEFAULT 0,
  `qtiteintd` int(11) DEFAULT 0,
  `qtiteintp` int(11) DEFAULT 0,
  `nbrevente` float DEFAULT 0,
  `dateperemtion` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `stock1`
--

INSERT INTO `stock1` (`id`, `codeb`, `idprod`, `prix_achat`, `prix_revient`, `prix_vente`, `type`, `quantite`, `qtiteintd`, `qtiteintp`, `nbrevente`, `dateperemtion`) VALUES
(1, '', 1, 65000, 65200, 66000, 'en_gros', 3256, 30, 0, 0, NULL),
(2, NULL, 2, 2167, 2173, 3000, 'detail', 15, 0, 0, 0, NULL),
(7, '', 7, 65000, 65200, 66000, 'en_gros', 230, 30, 0, 0, NULL),
(3, '', 3, 65000, 62200, 66000, 'en_gros', 62, 30, 0, -100, NULL),
(4, NULL, 4, 0, 0, 3000, 'detail', 0, 0, 0, 0, NULL),
(5, '', 5, 65000, 65200, 66000, 'en_gros', 1353, 30, 0, 0, NULL),
(6, NULL, 6, 0, 0, 3000, 'detail', 0, 0, 0, 0, NULL),
(8, NULL, 8, 2167, 2173, 3000, 'detail', 15, 0, 0, 0, NULL),
(9, '', 9, 65000, 62200, 66000, 'en_gros', 360, 30, 0, -20, NULL),
(10, NULL, 10, 2167, 2073, 3000, 'detail', 30, 0, 0, 0, NULL),
(61, NULL, 61, 0, 0, 70000, 'detail', 1, 0, 0, 0, NULL),
(11, '', 11, 89000, 89200, 90000, 'en_gros', 31, 2, 1, -50, NULL),
(12, NULL, 12, 0, 0, 45000, 'detail', 0, 0, 1, -1, NULL),
(13, '', 13, 62000, 62200, 63000, 'en_gros', 589, 30, 0, 0, NULL),
(14, NULL, 14, 0, 0, 0, 'detail', 0, 0, 0, 0, NULL),
(15, '', 15, 62000, 62200, 63000, 'en_gros', 5144, 30, 0, 0, NULL),
(16, NULL, 16, 2167, 2073, 3000, 'detail', 15, 0, 0, 0, NULL),
(17, '', 17, 62000, 62000, 63000, 'en_gros', 0, 30, 0, 0, NULL),
(18, NULL, 18, 0, 0, 0, 'detail', 0, 0, 0, 0, NULL),
(19, '', 19, 251000, 251200, 255000, 'en_gros', 4, 0, 0, 0, NULL),
(20, '', 20, 126000, 126200, 130000, 'en_gros', 7, 0, 0, 0, NULL),
(59, NULL, 59, 0, 0, 75000, 'detail', 1, 0, 0, 0, NULL),
(58, '', 58, 254000, 254200, 260000, 'en_gros', 369, 4, 0, 0, NULL),
(21, '', 21, 18000, 18500, 20000, 'en_gros', 0, 0, 1, 0, NULL),
(22, NULL, 22, 0, 0, 0, 'paquet', 0, 0, 0, 0, NULL),
(23, '', 23, 38000, 38200, 39000, 'en_gros', 2331, 12, 0, 0, NULL),
(24, NULL, 24, 0, 0, 0, 'detail', 0, 0, 0, 0, NULL),
(25, '', 25, 32500, 32700, 33000, 'en_gros', 2384, 12, 0, 0, NULL),
(26, NULL, 26, 0, 0, 0, 'detail', 0, 0, 0, 0, NULL),
(27, '', 27, 82000, 82200, 85000, 'en_gros', 261, 24, 0, 0, NULL),
(28, NULL, 28, 0, 0, 0, 'detail', 0, 0, 0, 0, NULL),
(29, '', 29, 145000, 148200, 155000, 'en_gros', 0, 24, 0, 0, NULL),
(30, NULL, 30, 0, 0, 0, 'detail', 0, 0, 0, 0, NULL),
(31, '', 31, 105000, 105500, 120000, 'en_gros', 2, 24, 0, 0, NULL),
(32, NULL, 32, 0, 0, 0, 'detail', 0, 0, 0, 0, NULL),
(33, '', 33, 125000, 125500, 135000, 'en_gros', 5, 24, 0, 0, NULL),
(34, NULL, 34, 0, 0, 35000, 'detail', 12, 0, 0, 0, NULL),
(35, '', 35, 48000, 48200, 50000, 'en_gros', 0, 0, 0, 0, NULL),
(36, '', 36, 34000, 34200, 35000, 'en_gros', 123, 0, 0, 0, NULL),
(37, '', 37, 38000, 38200, 45000, 'en_gros', 429, 0, 0, 0, NULL),
(38, '', 38, 34000, 34200, 35000, 'en_gros', 407, 0, 0, 0, NULL),
(39, '', 39, 34000, 34200, 35000, 'en_gros', 8, 0, 0, 0, NULL),
(60, '', 60, 253000, 252200, 260000, 'en_gros', 4, 4, 0, 0, NULL),
(40, 'Planete cocteile', 40, 33000, 33400, 35000, 'en_gros', 0, 0, 0, 0, NULL),
(41, '', 41, 33000, 334000, 35000, 'en_gros', 0, 0, 0, 0, NULL),
(42, '', 42, 33000, 33400, 35000, 'en_gros', 0, 0, 0, 0, NULL),
(43, '', 43, 35500, 36000, 40000, 'en_gros', 0, 0, 0, 0, NULL),
(44, '', 44, 34000, 34200, 35000, 'en_gros', 20, 0, 0, 0, NULL),
(45, '', 45, 120000, 120500, 125000, 'en_gros', 1, 24, 0, 0, NULL),
(46, '', 46, 120000, 120500, 125000, 'en_gros', 34, 0, 0, 0, NULL),
(47, '', 47, 59000, 59200, 63000, 'en_gros', 40, 0, 0, 0, NULL),
(48, '', 48, 59000, 59200, 63000, 'en_gros', 1, 0, 0, 0, NULL),
(49, '', 49, 354000, 354300, 355000, 'en_gros', 1240, 2, 4, 0, NULL),
(50, NULL, 50, 0, 0, 0, 'detail', 0, 4, 0, 0, NULL),
(51, NULL, 51, 0, 0, 0, 'paquet', 0, 2, 0, 0, NULL),
(52, '', 52, 254000, 254300, 255000, 'en_gros', 10, 12, 6, 0, NULL),
(53, NULL, 53, 0, 0, 0, 'detail', 10, 12, 0, 0, NULL),
(54, NULL, 54, 0, 0, 0, 'paquet', 0, 6, 0, 0, NULL),
(55, '', 55, 300000, 300400, 305000, 'en_gros', 0, 2, 4, 0, NULL),
(56, NULL, 56, 0, 0, 0, 'detail', 0, 4, 0, 0, NULL),
(57, NULL, 57, 0, 0, 0, 'paquet', 0, 2, 0, 0, NULL),
(62, '', 62, 32000, 32200, 35000, 'en_gros', 2866, 12, 0, 0, NULL),
(63, NULL, 63, 0, 0, 0, 'detail', 0, 0, 0, 0, NULL),
(64, '', 64, 79000, 79200, 80000, 'en_gros', 1435, 24, 0, 0, NULL),
(65, NULL, 65, 0, 0, 0, 'detail', 6, 0, 0, 0, NULL),
(66, '', 66, 79000, 79200, 80000, 'en_gros', 182, 24, 0, 0, NULL),
(67, NULL, 67, 0, 4000, 7000, 'detail', 24, 0, 0, 0, NULL),
(68, '', 68, 79000, 79200, 80000, 'en_gros', 623, 24, 0, 0, NULL),
(69, NULL, 69, 0, 0, 0, 'detail', 0, 0, 0, 0, NULL),
(70, '', 70, 78000, 78300, 80000, 'en_gros', 0, 24, 0, 0, NULL),
(71, NULL, 71, 0, 0, 0, 'detail', 0, 0, 0, 0, NULL),
(72, 'Planete cocteile', 72, 33000, 32200, 35000, 'en_gros', 1721, 12, 0, 0, NULL),
(73, NULL, 73, 0, 0, 0, 'detail', 0, 0, 0, 0, NULL),
(74, '', 74, 37000, 37200, 38000, 'en_gros', 3361, 12, 0, 0, NULL),
(75, NULL, 75, 0, 0, 0, 'detail', 0, 0, 0, 0, NULL),
(76, '', 76, 33000, 32200, 35000, 'en_gros', 16, 12, 0, 0, NULL),
(77, NULL, 77, 0, 0, 0, 'detail', 0, 0, 0, 0, NULL),
(78, '', 78, 32000, 32200, 33000, 'en_gros', 4738, 12, 0, 0, NULL),
(79, NULL, 79, 0, 0, 0, 'detail', 0, 0, 0, 0, NULL),
(80, '', 80, 33000, 33200, 35000, 'en_gros', 54, 12, 0, 0, NULL),
(81, NULL, 81, 0, 0, 0, 'detail', 0, 0, 0, 0, NULL),
(82, '', 82, 78000, 78300, 80000, 'en_gros', 0, 24, 0, 0, NULL),
(83, NULL, 83, 0, 0, 0, 'detail', 0, 0, 0, 0, NULL),
(84, '', 84, 35500, 35700, 40000, 'en_gros', 515, 12, 0, 0, NULL),
(85, NULL, 85, 0, 0, 0, 'detail', 0, 0, 0, 0, NULL),
(86, '', 86, 145000, 14500, 150000, 'en_gros', 0, 24, 0, 0, NULL),
(87, NULL, 87, 0, 0, 0, 'detail', 0, 0, 0, 0, NULL),
(88, '', 88, 145000, 145500, 150000, 'en_gros', 0, 24, 0, 0, NULL),
(89, NULL, 89, 0, 0, 0, 'detail', 0, 0, 0, 0, NULL),
(90, '', 90, 145000, 145500, 150000, 'en_gros', 0, 24, 0, 0, NULL),
(91, NULL, 91, 0, 0, 0, 'detail', 0, 0, 0, 0, NULL),
(92, '', 92, 145000, 145500, 150000, 'en_gros', 0, 24, 0, 0, NULL),
(93, NULL, 93, 0, 0, 0, 'detail', 0, 0, 0, 0, NULL),
(94, '', 94, 125000, 125500, 135000, 'en_gros', 19, 24, 0, 0, NULL),
(95, NULL, 95, 0, 0, 0, 'detail', 0, 0, 0, 0, NULL),
(96, '', 96, 125000, 125500, 135000, 'en_gros', 0, 24, 0, 0, NULL),
(97, NULL, 97, 0, 0, 0, 'detail', 0, 0, 0, 0, NULL),
(98, '', 98, 125000, 125500, 135000, 'en_gros', 3, 24, 0, 0, NULL),
(99, NULL, 99, 0, 0, 35000, 'detail', 12, 0, 0, 0, NULL),
(100, '', 100, 125000, 125500, 135000, 'en_gros', 5, 24, 0, 0, NULL),
(101, NULL, 101, 0, 0, 35000, 'detail', 12, 0, 0, 0, NULL),
(102, '', 102, 115000, 115500, 120000, 'en_gros', 13, 24, 0, 0, NULL),
(103, NULL, 103, 0, 0, 0, 'detail', 0, 0, 0, 0, NULL),
(104, '', 104, 105000, 105500, 120000, 'en_gros', 11, 24, 0, 0, NULL),
(105, NULL, 105, 0, 0, 0, 'detail', 0, 0, 0, 0, NULL),
(106, '', 106, 105000, 105500, 120000, 'en_gros', 0, 24, 0, 0, NULL),
(107, NULL, 107, 0, 0, 0, 'detail', 0, 0, 0, 0, NULL),
(108, '', 108, 0, 0, 0, 'en_gros', 0, 24, 0, 0, NULL),
(109, NULL, 109, 0, 0, 0, 'detail', 0, 0, 0, 0, NULL),
(110, '', 110, 105000, 105500, 120000, 'en_gros', 8, 24, 0, 0, NULL),
(111, NULL, 111, 0, 0, 7000, 'detail', 12, 0, 0, 0, NULL),
(112, '', 112, 32500, 35000, 35000, 'en_gros', 32, 12, 0, 0, NULL),
(113, NULL, 113, 0, 0, 0, 'detail', 0, 0, 0, 0, NULL),
(114, '', 114, 104000, 104300, 105000, 'en_gros', 345, 0, 0, 0, NULL),
(115, '', 115, 104000, 104300, 105000, 'en_gros', 12, 0, 0, 0, NULL),
(116, '', 116, 119000, 119300, 120000, 'en_gros', 63, 0, 0, 0, NULL),
(117, '', 117, 0, 0, 0, 'en_gros', 0, 0, 0, 0, NULL),
(118, '', 118, 134000, 134300, 135000, 'en_gros', 157, 0, 0, 0, NULL),
(119, '', 119, 0, 0, 0, 'en_gros', 0, 0, 0, 0, NULL),
(120, '', 120, 0, 0, 0, 'en_gros', 0, 0, 0, 0, NULL),
(121, '', 121, 27000, 27200, 30000, 'en_gros', 117, 0, 0, 0, NULL),
(122, '', 122, 48000, 48200, 50000, 'en_gros', 50, 0, 0, 0, NULL),
(123, '', 123, 135500, 136000, 140000, 'en_gros', 429, 24, 0, 0, NULL),
(124, NULL, 124, 0, 4200, 7000, 'detail', 12, 0, 0, 0, NULL),
(125, '', 125, 145000, 143024.75247525, 150000, 'en_gros', 200, 24, 0, 0, NULL),
(126, NULL, 126, 0, 7000, 8000, 'detail', 6, 0, 0, 0, NULL),
(127, '', 127, 125000, 125500, 130000, 'en_gros', 8, 24, 0, 0, NULL),
(128, NULL, 128, 0, 0, 0, 'detail', 0, 0, 0, 0, NULL),
(129, '', 129, 125000, 125500, 135000, 'en_gros', 3, 24, 0, 0, NULL),
(130, NULL, 130, 0, 0, 7000, 'detail', 12, 0, 0, 0, NULL),
(131, '', 131, 125000, 125500, 135000, 'en_gros', 1, 24, 0, 0, NULL),
(132, NULL, 132, 0, 110000, 35000, 'detail', 12, 0, 0, 0, NULL),
(133, '', 133, 125000, 125500, 130000, 'en_gros', 1, 24, 0, 0, NULL),
(134, NULL, 134, 0, 0, 0, 'detail', 0, 0, 0, 0, NULL),
(135, '', 135, 18000, 18200, 20500, 'en_gros', 767, 0, 0, 0, NULL),
(136, '', 136, 18000, 18200, 20500, 'en_gros', 381, 0, 0, 0, NULL),
(137, '', 137, 18000, 18200, 20500, 'en_gros', 332, 0, 0, 0, NULL),
(138, '', 138, 18000, 18200, 20500, 'en_gros', 108, 0, 0, 0, NULL),
(139, '', 139, 27000, 28200, 33000, 'en_gros', 68, 0, 0, 0, NULL),
(140, '', 140, 18000, 19200, 23000, 'en_gros', 4, 0, 0, 0, NULL),
(141, '', 141, 18000, 18200, 20500, 'en_gros', 107, 0, 0, 0, NULL),
(142, '', 142, 34000, 34200, 35000, 'en_gros', 3485, 0, 0, 0, NULL),
(143, '', 143, 43000, 43200, 45000, 'en_gros', 1224, 12, 0, 0, NULL),
(144, NULL, 144, 0, 0, 0, 'detail', 0, 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `stockmouv`
--

CREATE TABLE `stockmouv` (
  `id` int(11) NOT NULL,
  `idstock` int(11) NOT NULL,
  `numeromouv` varchar(100) DEFAULT NULL,
  `libelle` varchar(150) NOT NULL,
  `quantitemouv` float NOT NULL,
  `idnomstock` int(11) NOT NULL DEFAULT 1,
  `dateop` datetime NOT NULL,
  `coment` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `stockmouv`
--

INSERT INTO `stockmouv` (`id`, `idstock`, `numeromouv`, `libelle`, `quantitemouv`, `idnomstock`, `dateop`, `coment`) VALUES
(1, 1, 'livacf240001', 'sortie', 0, 1, '2024-01-11 20:15:22', NULL),
(2, 3, 'livacf240002', 'sortie', 0, 1, '2024-01-11 21:34:47', NULL),
(3, 7, 'livacf240002', 'sortie', 0, 1, '2024-01-11 21:34:48', NULL),
(4, 9, 'livacf240002', 'sortie', 0, 1, '2024-01-11 21:34:48', NULL),
(5, 5, 'livacf240003', 'sortie', 0, 1, '2024-01-11 23:56:23', NULL),
(6, 4, 'livacf240003', 'sortie', 0, 1, '2024-01-11 23:56:23', NULL),
(7, 1, 'livacf240003', 'sortie', 0, 1, '2024-01-11 23:56:23', NULL),
(8, 10, 'livacf240003', 'sortie', 0, 1, '2024-01-11 23:56:23', NULL),
(19, 9, 'livacf240004', 'sortie', 0, 1, '2024-01-12 19:37:58', NULL),
(18, 3, 'livacf240004', 'sortie', 0, 1, '2024-01-12 19:37:43', NULL),
(17, 12, 'livacf240004', 'sortie', 0, 1, '2024-01-12 19:37:32', NULL),
(16, 12, 'livacf240006', 'sortie', 0, 1, '2024-01-12 19:34:33', NULL),
(13, 1, 'livacf240005', 'sortie', 0, 1, '2024-01-12 10:05:38', NULL),
(14, 12, 'livacf240005', 'sortie', 0, 1, '2024-01-12 10:05:38', NULL),
(15, 17, 'livacf240005', 'sortie', 0, 1, '2024-01-12 10:05:38', NULL),
(20, 19, 'livacf240007', 'sortie', 0, 1, '2024-01-12 20:44:01', NULL),
(21, 20, 'livacf240007', 'sortie', 0, 1, '2024-01-12 20:44:01', NULL),
(22, 1, 'livacf240007', 'sortie', 0, 1, '2024-01-12 20:44:01', NULL),
(23, 11, 'livacf240007', 'sortie', 0, 1, '2024-01-12 20:44:01', NULL),
(24, 12, 'livacf240008', 'sortie', 0, 1, '2024-01-12 20:47:01', NULL),
(25, 6, 'livacf240008', 'sortie', 0, 1, '2024-01-12 20:47:01', NULL),
(26, 20, 'livacf240008', 'sortie', 0, 1, '2024-01-12 20:47:01', NULL),
(27, 5, 'livacf240009', 'sortie', 0, 1, '2024-01-12 20:49:58', NULL),
(28, 12, 'livacf240009', 'sortie', 0, 1, '2024-01-12 20:49:58', NULL),
(29, 19, 'livacf240009', 'sortie', 0, 1, '2024-01-12 20:49:58', NULL),
(30, 19, 'livacf240010', 'sortie', 0, 1, '2024-01-12 20:52:26', NULL),
(31, 11, 'livacf240011', 'sortie', 0, 1, '2024-01-12 20:53:45', NULL),
(32, 6, 'livacf240011', 'sortie', 0, 1, '2024-01-12 20:53:45', NULL),
(33, 19, 'livacf240011', 'sortie', 0, 1, '2024-01-12 20:53:45', NULL),
(34, 11, 'livacf240006', 'sortie', 0, 1, '2024-01-12 21:43:25', NULL),
(35, 20, 'livacf240012', 'sortie', 0, 1, '2024-01-12 21:44:18', NULL),
(36, 11, 'livacf240012', 'sortie', 0, 1, '2024-01-12 21:45:32', NULL),
(37, 19, 'livacf240013', 'sortie', 0, 1, '2024-01-12 22:59:46', NULL),
(38, 11, 'livacf240014', 'sortie', 0, 1, '2024-01-13 12:33:12', NULL),
(39, 19, 'livacf240014', 'sortie', 0, 1, '2024-01-13 12:33:12', NULL),
(40, 20, 'livacf240014', 'sortie', 0, 1, '2024-01-13 12:33:12', NULL),
(41, 2, 'livacf240014', 'sortie', 0, 1, '2024-01-13 12:33:12', NULL),
(42, 8, 'livacf240014', 'sortie', 0, 1, '2024-01-13 12:33:12', NULL),
(43, 1, 'livacf240014', 'sortie', 0, 1, '2024-01-13 12:33:12', NULL),
(44, 5, 'livacf240015', 'sortie', 0, 1, '2024-01-13 12:56:31', NULL),
(45, 19, 'livacf240015', 'sortie', 0, 1, '2024-01-13 12:56:31', NULL),
(46, 11, 'livacf240015', 'sortie', 0, 1, '2024-01-13 12:56:31', NULL),
(47, 4, 'livacf240015', 'sortie', 0, 1, '2024-01-13 12:56:31', NULL),
(48, 10, 'livacf240015', 'sortie', 0, 1, '2024-01-13 12:56:31', NULL),
(79, 12, 'per3', 'pertes', -2, 1, '2024-01-14 17:59:01', NULL),
(51, 31, 'ouvcacf240016', 'sortie', -1, 1, '2024-01-13 19:02:59', NULL),
(52, 32, 'ouvcacf240016', 'entree', 0, 1, '2024-01-13 19:02:59', NULL),
(53, 32, 'livacf240016', 'sortie', 0, 1, '2024-01-13 19:02:59', NULL),
(78, 11, 'per2', 'pertes', 1, 1, '2024-01-14 17:58:26', NULL),
(77, 0, 'per1', 'pertes', 1, 1, '2024-01-14 17:57:05', NULL),
(58, 11, 'ouvcacf240017', 'sortie', 0, 1, '2024-01-13 20:35:37', NULL),
(59, 12, 'ouvcacf240017', 'entree', 0, 1, '2024-01-13 20:35:37', NULL),
(60, 12, 'livacf240017', 'sortie', 0, 1, '2024-01-13 20:35:37', NULL),
(61, 11, 'livacf240017', 'sortie', 0, 1, '2024-01-13 20:35:37', NULL),
(62, 29, 'livacf240017', 'sortie', 0, 1, '2024-01-13 20:35:37', NULL),
(63, 32, 'livacf240017', 'sortie', 0, 1, '2024-01-13 20:35:37', NULL),
(64, 36, 'livacf240017', 'sortie', 0, 1, '2024-01-13 20:35:37', NULL),
(65, 39, 'livacf240017', 'sortie', 0, 1, '2024-01-13 20:35:37', NULL),
(66, 37, 'livacf240017', 'sortie', 0, 1, '2024-01-13 20:35:37', NULL),
(67, 1, 'livacf240017', 'sortie', 0, 1, '2024-01-13 20:35:37', NULL),
(68, 4, 'livacf240017', 'sortie', 0, 1, '2024-01-13 20:35:37', NULL),
(69, 9, 'ouvcacf240017', 'sortie', -1, 1, '2024-01-13 20:35:37', NULL),
(70, 10, 'ouvcacf240017', 'entree', 0, 1, '2024-01-13 20:35:37', NULL),
(71, 10, 'livacf240017', 'sortie', 0, 1, '2024-01-13 20:35:37', NULL),
(84, 1, 'recepf', 'entree', 3264, 1, '2024-01-17 22:05:23', '008'),
(83, 10, 'per7', 'pertes', -2, 1, '2024-01-14 18:01:14', NULL),
(82, 9, 'per6', 'pertes', 1, 1, '2024-01-14 18:00:44', NULL),
(81, 32, 'per5', 'pertes', -2, 1, '2024-01-14 18:00:04', NULL),
(80, 31, 'per4', 'pertes', 1, 1, '2024-01-14 17:59:35', NULL),
(85, 2, 'recepf', 'entree', 15, 1, '2024-01-17 22:09:47', '008'),
(86, 5, 'recepf', 'entree', 1363, 1, '2024-01-17 22:16:36', '008'),
(87, 15, 'recepf', 'entree', 2577, 1, '2024-01-17 22:19:47', '008'),
(88, 15, 'recepf', 'entree', 2577, 1, '2024-01-17 22:20:20', '008'),
(89, 16, 'recepf', 'entree', 15, 1, '2024-01-17 22:30:29', '008'),
(90, 13, 'recepf', 'entree', 600, 1, '2024-01-17 22:41:10', '008'),
(91, 7, 'recepf', 'entree', 235, 1, '2024-01-17 22:43:11', '008'),
(92, 8, 'recepf', 'entree', 15, 1, '2024-01-17 22:44:43', '008'),
(93, 3, 'recepf', 'entree', 65, 1, '2024-01-17 23:40:38', '008'),
(94, 9, 'recepf', 'entree', 361, 1, '2024-01-17 23:42:44', '008'),
(95, 10, 'recepf', 'entree', 15, 1, '2024-01-17 23:43:55', '008'),
(96, 62, 'recepf', 'entree', 2873, 1, '2024-01-17 23:46:41', '008'),
(97, 74, 'recepf', 'entree', 3361, 1, '2024-01-17 23:49:52', '008'),
(98, 78, 'recepf', 'entree', 4738, 1, '2024-01-17 23:56:29', '008'),
(99, 64, 'recepf', 'entree', 1447, 1, '2024-01-18 00:02:36', '008'),
(100, 112, 'recepf', 'entree', 32, 1, '2024-01-18 00:07:01', '008'),
(101, 114, 'recepf', 'entree', 403, 1, '2024-01-18 00:15:57', '008'),
(102, 115, 'recepf', 'entree', 12, 1, '2024-01-18 00:17:12', '008'),
(103, 66, 'recepf', 'entree', 183, 1, '2024-01-18 00:20:12', '008'),
(104, 67, 'recepf', 'entree', 6, 1, '2024-01-18 00:21:25', '008'),
(105, 23, 'recepf', 'entree', 2726, 1, '2024-01-18 00:27:01', '008'),
(106, 72, 'recepf', 'entree', 1723, 1, '2024-01-18 00:30:21', '008'),
(107, 84, 'recepf', 'entree', 533, 1, '2024-01-18 00:32:30', '008'),
(108, 80, 'recepf', 'entree', 59, 1, '2024-01-18 00:33:55', '008'),
(109, 38, 'recepf', 'entree', 419, 1, '2024-01-18 00:35:13', '008'),
(110, 76, 'recepf', 'entree', 16, 1, '2024-01-18 00:36:54', '008'),
(111, 37, 'recepf', 'entree', 433, 1, '2024-01-18 00:38:29', '008'),
(112, 36, 'recepf', 'entree', 124, 1, '2024-01-18 00:40:07', '008'),
(113, 44, 'recepf', 'entree', 20, 1, '2024-01-18 00:43:44', '008'),
(114, 121, 'recepf', 'entree', 117, 1, '2024-01-18 00:45:54', '008'),
(115, 122, 'recepf', 'entree', 58, 1, '2024-01-18 00:48:44', '008'),
(116, 123, 'recepf', 'entree', 429, 1, '2024-01-18 00:51:24', '008'),
(117, 124, 'recepf', 'entree', 12, 1, '2024-01-18 00:52:09', '008'),
(118, 47, 'recepf', 'entree', 40, 1, '2024-01-18 00:53:25', '008'),
(119, 94, 'recepf', 'entree', 19, 1, '2024-01-18 00:54:53', '008'),
(126, 33, 'recepf', 'entree', 5, 1, '2024-01-18 01:09:17', '008'),
(127, 34, 'recepf', 'entree', 12, 1, '2024-01-18 01:10:54', '008'),
(125, 101, 'recepf', 'entree', 12, 1, '2024-01-18 01:05:47', '008'),
(128, 98, 'recepf', 'entree', 3, 1, '2024-01-18 01:12:41', '008'),
(129, 99, 'recepf', 'entree', 12, 1, '2024-01-18 01:13:40', '008'),
(130, 31, 'recepf', 'entree', 3, 1, '2024-01-18 01:14:36', '008'),
(131, 104, 'recepf', 'entree', 11, 1, '2024-01-18 01:15:18', '008'),
(132, 102, 'recepf', 'entree', 13, 1, '2024-01-18 01:15:48', '008'),
(133, 110, 'recepf', 'entree', 8, 1, '2024-01-18 01:16:47', '008'),
(134, 111, 'recepf', 'entree', 12, 1, '2024-01-18 01:17:40', '008'),
(135, 125, 'recepf', 'entree', 2, 1, '2024-01-18 01:20:41', '008'),
(136, 126, 'recepf', 'entree', 12, 1, '2024-01-18 01:21:07', '008'),
(137, 127, 'recepf', 'entree', 8, 1, '2024-01-18 01:23:29', '008'),
(138, 129, 'recepf', 'entree', 3, 1, '2024-01-18 01:29:59', '008'),
(139, 130, 'recepf', 'entree', 12, 1, '2024-01-18 01:30:24', '008'),
(140, 131, 'recepf', 'entree', 1, 1, '2024-01-18 01:30:46', '008'),
(141, 132, 'recepf', 'entree', 12, 1, '2024-01-18 01:31:04', '008'),
(142, 133, 'recepf', 'entree', 1, 1, '2024-01-18 01:32:52', '008'),
(143, 39, 'recepf', 'entree', 10, 1, '2024-01-18 01:33:42', '008'),
(144, 135, 'recepf', 'entree', 829, 1, '2024-01-18 01:40:01', '008'),
(145, 136, 'recepf', 'entree', 421, 1, '2024-01-18 01:40:49', '008'),
(146, 137, 'recepf', 'entree', 362, 1, '2024-01-18 01:41:17', '008'),
(148, 139, 'recepf', 'entree', 68, 1, '2024-01-18 01:42:49', '008'),
(149, 139, 'per8', 'pertes', 68000, 1, '2024-01-18 07:00:18', NULL),
(150, 100, 'per9', 'pertes', 51, 1, '2024-01-18 07:01:54', NULL),
(151, 100, 'per10', 'pertes', 5, 1, '2024-01-18 07:03:44', NULL),
(152, 10, 'per11', 'pertes', 2, 1, '2024-01-18 07:10:47', NULL),
(153, 10, 'per12', 'pertes', 2, 1, '2024-01-18 07:11:43', NULL),
(154, 10, 'suppertes', 'pertes', -2, 1, '2024-01-18 07:12:02', NULL),
(155, 10, 'suppertes', 'pertes', -2, 1, '2024-01-18 07:13:58', NULL),
(156, 140, 'recepf', 'entree', 4, 1, '2024-01-18 07:20:33', '008'),
(157, 46, 'recepf', 'entree', 34, 1, '2024-01-18 07:21:27', '008'),
(158, 45, 'recepf', 'entree', 1, 1, '2024-01-18 07:22:29', '008'),
(159, 138, 'recepf', 'entree', 108, 1, '2024-01-18 07:23:31', '008'),
(161, 141, 'recepf', 'entree', 107, 1, '2024-01-18 07:31:12', '008'),
(162, 142, 'recepf', 'entree', 3488, 1, '2024-01-18 07:34:54', '008'),
(163, 68, 'recepf', 'entree', 624, 1, '2024-01-18 07:36:29', '008'),
(164, 25, 'recepf', 'entree', 2421, 1, '2024-01-18 07:38:09', '008'),
(165, 11, 'recepf', 'entree', 38, 1, '2024-01-18 07:39:16', '008'),
(166, 27, 'recepf', 'entree', 261, 1, '2024-01-18 07:40:13', '008'),
(167, 49, 'recepf', 'entree', 1253, 1, '2024-01-18 07:41:22', '008'),
(168, 52, 'recepf', 'entree', 15, 1, '2024-01-18 07:43:34', '008'),
(169, 58, 'recepf', 'entree', 375, 1, '2024-01-18 07:44:48', '008'),
(170, 118, 'recepf', 'entree', 182, 1, '2024-01-18 08:55:30', '008'),
(171, 116, 'recepf', 'entree', 75, 1, '2024-01-18 08:57:00', '008'),
(172, 135, 'livacf240018', 'sortie', -4, 1, '2024-01-18 09:04:35', NULL),
(173, 23, 'livacf240018', 'sortie', -2, 1, '2024-01-18 09:04:35', NULL),
(174, 84, 'livacf240018', 'sortie', -2, 1, '2024-01-18 09:04:35', NULL),
(175, 1, 'livacf240018', 'sortie', -1, 1, '2024-01-18 09:04:35', NULL),
(176, 5, 'livacf240018', 'sortie', -2, 1, '2024-01-18 09:04:35', NULL),
(177, 143, 'recepf', 'entree', 1264, 1, '2024-01-18 09:08:58', NULL),
(178, 143, 'livacf240019', 'sortie', -1, 1, '2024-01-18 09:09:52', NULL),
(179, 23, 'livacf240020', 'sortie', -15, 1, '2024-01-18 09:11:41', NULL),
(180, 11, 'livacf240020', 'sortie', -1, 1, '2024-01-18 09:11:41', NULL),
(181, 122, 'livacf240021', 'sortie', -1, 1, '2024-01-18 09:21:54', NULL),
(182, 48, 'recepf', 'entree', 2, 1, '2024-01-18 09:26:16', NULL),
(183, 48, 'livacf240022', 'sortie', -1, 1, '2024-01-18 09:34:01', NULL),
(184, 62, 'livacf240022', 'sortie', -2, 1, '2024-01-18 09:34:01', NULL),
(185, 114, 'livacf240022', 'sortie', -1, 1, '2024-01-18 09:34:01', NULL),
(186, 52, 'livacf240022', 'sortie', -1, 1, '2024-01-18 09:34:01', NULL),
(187, 11, 'livacf240023', 'sortie', -5, 1, '2024-01-18 09:54:35', NULL),
(188, 52, 'livacf240023', 'sortie', -1, 1, '2024-01-18 09:54:35', NULL),
(189, 125, 'recepf', 'entree', 200, 1, '2024-01-18 11:43:06', '005JEUDI'),
(190, 0, 'per11', 'pertes', -34, 1, '2024-01-18 12:09:02', NULL),
(191, 25, 'per12', 'pertes', -34, 1, '2024-01-18 12:10:54', NULL),
(192, 136, 'livacf240024', 'sortie', -15, 1, '2024-01-18 12:30:34', NULL),
(193, 135, 'livacf240024', 'sortie', -20, 1, '2024-01-18 12:30:34', NULL),
(194, 137, 'livacf240024', 'sortie', -15, 1, '2024-01-18 12:30:34', NULL),
(195, 125, 'livacf240025', 'sortie', -1, 1, '2024-01-18 12:56:56', NULL),
(196, 114, 'livacf240025', 'sortie', -4, 1, '2024-01-18 12:56:56', NULL),
(197, 37, 'livacf240025', 'sortie', -1, 1, '2024-01-18 12:56:56', NULL),
(198, 143, 'livacf240025', 'sortie', -2, 1, '2024-01-18 12:56:56', NULL),
(199, 62, 'livacf240025', 'sortie', -1, 1, '2024-01-18 12:56:56', NULL),
(200, 80, 'livacf240025', 'sortie', -1, 1, '2024-01-18 12:56:56', NULL),
(201, 84, 'livacf240025', 'sortie', -1, 1, '2024-01-18 12:56:56', NULL),
(202, 58, 'ouvcacf240025', 'sortie', -1, 1, '2024-01-18 12:56:56', NULL),
(203, 59, 'ouvcacf240025', 'entree', 4, 1, '2024-01-18 12:56:56', NULL),
(204, 59, 'livacf240025', 'sortie', -1, 1, '2024-01-18 12:56:56', NULL),
(205, 142, 'livacf240025', 'sortie', -1, 1, '2024-01-18 12:56:56', NULL),
(206, 122, 'livacf240025', 'sortie', -3, 1, '2024-01-18 12:56:56', NULL),
(207, 39, 'livacf240025', 'sortie', -2, 1, '2024-01-18 12:56:56', NULL),
(208, 23, 'livacf240025', 'sortie', -3, 1, '2024-01-18 12:56:56', NULL),
(209, 135, 'livacf240025', 'sortie', -4, 1, '2024-01-18 12:56:56', NULL),
(210, 52, 'ouvcacf240025', 'sortie', -1, 1, '2024-01-18 12:56:56', NULL),
(211, 53, 'ouvcacf240025', 'entree', 12, 1, '2024-01-18 12:56:56', NULL),
(212, 53, 'livacf240025', 'sortie', -2, 1, '2024-01-18 12:56:56', NULL),
(213, 38, 'livacf240025', 'sortie', -2, 1, '2024-01-18 12:56:56', NULL),
(214, 11, 'livacf240025', 'sortie', -1, 1, '2024-01-18 12:56:56', NULL),
(215, 25, 'livacf240025', 'sortie', -1, 1, '2024-01-18 12:56:56', NULL),
(216, 20, 'recepf', 'entree', 9, 1, '2024-01-18 13:01:47', '008'),
(217, 60, 'recepf', 'entree', 4, 1, '2024-01-18 13:06:24', '008'),
(218, 61, 'recepf', 'entree', 1, 1, '2024-01-18 13:08:00', '008'),
(219, 19, 'recepf', 'entree', 6, 1, '2024-01-18 13:09:59', '008'),
(220, 20, 'livacf240026', 'sortie', -1, 1, '2024-01-18 13:16:00', NULL),
(221, 142, 'livacf240026', 'sortie', -1, 1, '2024-01-18 13:16:00', NULL),
(222, 122, 'livacf240026', 'sortie', -2, 1, '2024-01-18 13:16:00', NULL),
(223, 143, 'livacf240026', 'sortie', -5, 1, '2024-01-18 13:16:00', NULL),
(224, 135, 'livacf240026', 'sortie', -4, 1, '2024-01-18 13:16:00', NULL),
(225, 37, 'livacf240027', 'sortie', -3, 1, '2024-01-18 13:58:35', NULL),
(226, 23, 'livacf240027', 'sortie', -3, 1, '2024-01-18 13:58:35', NULL),
(227, 23, 'livacf240028', 'sortie', -200, 1, '2024-01-18 16:06:57', NULL),
(228, 23, 'livacf240029', 'sortie', -100, 1, '2024-01-18 16:49:32', NULL),
(229, 135, 'livacf240030', 'sortie', -20, 1, '2024-01-18 17:43:12', NULL),
(230, 136, 'livacf240030', 'sortie', -15, 1, '2024-01-18 17:43:12', NULL),
(231, 137, 'livacf240030', 'sortie', -15, 1, '2024-01-18 17:43:12', NULL),
(232, 49, 'livacf240030', 'sortie', -10, 1, '2024-01-18 17:43:12', NULL),
(233, 38, 'livacf240030', 'sortie', -10, 1, '2024-01-18 17:43:12', NULL),
(234, 143, 'livacf240030', 'sortie', -20, 1, '2024-01-18 17:43:12', NULL),
(235, 23, 'livacf240030', 'sortie', -50, 1, '2024-01-18 17:43:12', NULL),
(236, 58, 'livacf240030', 'sortie', -5, 1, '2024-01-18 17:43:12', NULL),
(237, 13, 'livacf240031', 'sortie', -9, 1, '2024-01-18 20:32:00', NULL),
(238, 15, 'livacf240031', 'sortie', -8, 1, '2024-01-18 20:32:00', NULL),
(239, 114, 'livacf240031', 'sortie', -1, 1, '2024-01-18 20:32:00', NULL),
(240, 84, 'livacf240031', 'sortie', -3, 1, '2024-01-18 20:32:00', NULL),
(241, 80, 'livacf240031', 'sortie', -3, 1, '2024-01-18 20:32:00', NULL),
(242, 52, 'livacf240031', 'sortie', -2, 1, '2024-01-18 20:32:00', NULL),
(243, 25, 'livacf240031', 'sortie', -2, 1, '2024-01-18 20:32:00', NULL),
(244, 62, 'livacf240031', 'sortie', -2, 1, '2024-01-18 20:32:00', NULL),
(245, 142, 'livacf240031', 'sortie', -1, 1, '2024-01-18 20:32:00', NULL),
(246, 19, 'livacf240031', 'sortie', -2, 1, '2024-01-18 20:32:00', NULL),
(247, 36, 'livacf240031', 'sortie', -1, 1, '2024-01-18 20:32:00', NULL),
(248, 1, 'livacf240031', 'sortie', -5, 1, '2024-01-18 20:32:00', NULL),
(249, 5, 'livacf240031', 'sortie', -6, 1, '2024-01-18 20:32:00', NULL),
(250, 3, 'livacf240031', 'sortie', -1, 1, '2024-01-18 20:32:00', NULL),
(251, 59, 'livacf240031', 'sortie', -2, 1, '2024-01-18 20:32:00', NULL),
(252, 122, 'livacf240031', 'sortie', -2, 1, '2024-01-18 20:32:00', NULL),
(253, 64, 'livacf240031', 'sortie', -6, 1, '2024-01-18 20:32:00', NULL),
(254, 68, 'livacf240031', 'sortie', -1, 1, '2024-01-18 20:32:00', NULL),
(255, 66, 'ouvcacf240031', 'sortie', -1, 1, '2024-01-18 20:32:00', NULL),
(256, 67, 'ouvcacf240031', 'entree', 24, 1, '2024-01-18 20:32:00', NULL),
(257, 67, 'livacf240031', 'sortie', -6, 1, '2024-01-18 20:32:00', NULL),
(258, 20, 'livacf240031', 'sortie', -1, 1, '2024-01-18 20:32:00', NULL),
(259, 49, 'livacf240031', 'sortie', -2, 1, '2024-01-18 20:32:00', NULL),
(260, 49, 'ouvcacf240031', 'sortie', -1, 1, '2024-01-18 20:32:00', NULL),
(261, 50, 'ouvcacf240031', 'entree', 2, 1, '2024-01-18 20:32:00', NULL),
(262, 50, 'livacf240031', 'sortie', -2, 1, '2024-01-18 20:32:00', NULL),
(263, 143, 'livacf240031', 'sortie', -2, 1, '2024-01-18 20:32:00', NULL),
(264, 7, 'livacf240031', 'sortie', -5, 1, '2024-01-18 20:32:00', NULL),
(265, 125, 'livacf240031', 'sortie', -1, 1, '2024-01-18 20:32:00', NULL),
(266, 136, 'livacf240031', 'sortie', -5, 1, '2024-01-18 20:32:00', NULL),
(267, 135, 'livacf240031', 'sortie', -5, 1, '2024-01-18 20:32:00', NULL),
(268, 23, 'livacf240031', 'sortie', -2, 1, '2024-01-18 20:32:00', NULL),
(269, 31, 'livacf240031', 'sortie', -1, 1, '2024-01-18 20:32:00', NULL),
(270, 126, 'livacf240031', 'sortie', -6, 1, '2024-01-18 20:32:00', NULL),
(271, 9, 'ouvcacf240031', 'sortie', -1, 1, '2024-01-18 20:32:00', NULL),
(272, 10, 'ouvcacf240031', 'entree', 30, 1, '2024-01-18 20:32:00', NULL),
(273, 10, 'livacf240031', 'sortie', -15, 1, '2024-01-18 20:32:00', NULL),
(274, 84, 'livacf240032', 'sortie', -9, 1, '2024-01-18 20:45:39', NULL),
(275, 64, 'ouvcacf240032', 'sortie', -1, 1, '2024-01-18 20:45:39', NULL),
(276, 65, 'ouvcacf240032', 'entree', 24, 1, '2024-01-18 20:45:39', NULL),
(277, 65, 'livacf240032', 'sortie', -18, 1, '2024-01-18 20:45:39', NULL),
(278, 23, 'livacf240033', 'sortie', -20, 1, '2024-01-18 21:20:47', NULL),
(279, 114, 'livacf240033', 'sortie', -2, 1, '2024-01-18 21:20:47', NULL),
(280, 62, 'livacf240033', 'sortie', -2, 1, '2024-01-18 21:20:47', NULL),
(281, 84, 'livacf240033', 'sortie', -3, 1, '2024-01-18 21:20:47', NULL),
(282, 72, 'livacf240033', 'sortie', -2, 1, '2024-01-18 21:20:47', NULL),
(283, 80, 'livacf240033', 'sortie', -1, 1, '2024-01-18 21:20:47', NULL),
(284, 13, 'livacf240033', 'sortie', -2, 1, '2024-01-18 21:20:47', NULL),
(285, 15, 'livacf240033', 'sortie', -2, 1, '2024-01-18 21:20:47', NULL),
(286, 116, 'livacf240033', 'sortie', -2, 1, '2024-01-18 21:20:47', NULL),
(287, 143, 'livacf240033', 'sortie', -10, 1, '2024-01-18 21:20:47', NULL),
(288, 118, 'livacf240033', 'sortie', -5, 1, '2024-01-18 21:20:47', NULL),
(289, 3, 'livacf240033', 'sortie', -2, 1, '2024-01-18 21:20:47', NULL),
(290, 1, 'livacf240033', 'sortie', -2, 1, '2024-01-18 21:20:47', NULL),
(291, 5, 'livacf240033', 'sortie', -2, 1, '2024-01-18 21:20:47', NULL),
(292, 64, 'livacf240033', 'sortie', -5, 1, '2024-01-18 21:20:47', NULL),
(293, 135, 'livacf240033', 'sortie', -5, 1, '2024-01-18 21:20:47', NULL),
(294, 136, 'livacf240033', 'sortie', -5, 1, '2024-01-18 21:20:47', NULL),
(295, 116, 'livacf240034', 'sortie', -10, 1, '2024-01-18 21:23:10', NULL),
(296, 114, 'livacf240034', 'sortie', -50, 1, '2024-01-18 21:23:10', NULL),
(297, 118, 'livacf240034', 'sortie', -20, 1, '2024-01-18 21:23:10', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `topclient`
--

CREATE TABLE `topclient` (
  `id` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `montant` double DEFAULT NULL,
  `benefice` float NOT NULL,
  `pseudo` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `topclient`
--

INSERT INTO `topclient` (`id`, `id_client`, `montant`, `benefice`, `pseudo`) VALUES
(31, 1, 20881981, 0, 0),
(32, 52, 7800000, 0, 0),
(33, 41, 9155000, 0, 0),
(34, 38, 9150000, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `transferfond`
--

CREATE TABLE `transferfond` (
  `id` int(11) NOT NULL,
  `numero` int(11) DEFAULT NULL,
  `caissedep` varchar(11) NOT NULL,
  `montant` float NOT NULL,
  `caisseret` varchar(11) NOT NULL,
  `devise` varchar(10) DEFAULT NULL,
  `lieuvente` int(10) DEFAULT NULL,
  `exect` int(11) NOT NULL,
  `coment` text DEFAULT NULL,
  `dateop` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `transferprod`
--

CREATE TABLE `transferprod` (
  `id` int(11) NOT NULL,
  `idprod` int(11) NOT NULL,
  `stockdep` int(11) NOT NULL,
  `quantitemouv` float NOT NULL,
  `stockrecep` int(11) NOT NULL,
  `dateop` datetime NOT NULL,
  `exect` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `validcomande`
--

CREATE TABLE `validcomande` (
  `id` int(11) NOT NULL,
  `id_produit` int(50) DEFAULT NULL,
  `codebvc` varchar(50) DEFAULT NULL,
  `designation` varchar(60) NOT NULL,
  `quantite` float NOT NULL,
  `pachat` double NOT NULL,
  `pvente` double DEFAULT NULL,
  `previent` double DEFAULT NULL,
  `frais` double DEFAULT NULL,
  `etat` varchar(15) NOT NULL,
  `pseudo` varchar(50) DEFAULT NULL,
  `datecmd` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `validcomandefrais`
--

CREATE TABLE `validcomandefrais` (
  `id` int(11) NOT NULL,
  `id_produit` int(50) DEFAULT NULL,
  `codebvc` varchar(50) DEFAULT NULL,
  `designation` varchar(60) NOT NULL,
  `quantite` float NOT NULL,
  `pachat` double NOT NULL,
  `pvente` double DEFAULT NULL,
  `previent` double DEFAULT NULL,
  `frais` double DEFAULT NULL,
  `etat` varchar(15) NOT NULL,
  `pseudo` varchar(50) DEFAULT NULL,
  `datecmd` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `validpaie`
--

CREATE TABLE `validpaie` (
  `id` int(11) NOT NULL,
  `id_produit` int(50) DEFAULT NULL,
  `codebvc` varchar(50) DEFAULT NULL,
  `quantite` float NOT NULL,
  `pvente` double DEFAULT NULL,
  `pseudov` varchar(50) DEFAULT NULL,
  `datecmd` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `validpaiemodif`
--

CREATE TABLE `validpaiemodif` (
  `id` int(11) NOT NULL,
  `id_produit` int(50) DEFAULT NULL,
  `codebvc` varchar(50) DEFAULT NULL,
  `quantite` float NOT NULL,
  `pvente` double DEFAULT NULL,
  `pseudov` varchar(50) DEFAULT NULL,
  `datecmd` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `validvente`
--

CREATE TABLE `validvente` (
  `id` int(11) NOT NULL,
  `remise` double DEFAULT 0,
  `montantpgnf` double DEFAULT 0,
  `montantpeu` double DEFAULT 0,
  `montantpus` double DEFAULT 0,
  `montantpcfa` double DEFAULT 0,
  `virement` double DEFAULT 0,
  `cheque` double DEFAULT 0,
  `numcheque` varchar(50) DEFAULT NULL,
  `banqcheque` varchar(50) DEFAULT NULL,
  `pseudop` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `validventemodif`
--

CREATE TABLE `validventemodif` (
  `id` int(11) NOT NULL,
  `remise` double DEFAULT 0,
  `montantpgnf` double DEFAULT 0,
  `montantpeu` double DEFAULT 0,
  `montantpus` double DEFAULT 0,
  `montantpcfa` double DEFAULT 0,
  `virement` double DEFAULT 0,
  `cheque` double DEFAULT 0,
  `numcheque` varchar(50) DEFAULT NULL,
  `banqcheque` varchar(50) DEFAULT NULL,
  `pseudop` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ventedelete`
--

CREATE TABLE `ventedelete` (
  `id` int(11) NOT NULL,
  `id_produit` int(11) DEFAULT NULL,
  `prix_vente` double NOT NULL,
  `prix_revient` double DEFAULT 0,
  `quantity` int(11) NOT NULL,
  `num_cmd` varchar(50) NOT NULL,
  `id_client` int(10) DEFAULT NULL,
  `idpersonnel` int(11) NOT NULL,
  `idstock` int(11) NOT NULL,
  `datedelete` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `ventedelete`
--

INSERT INTO `ventedelete` (`id`, `id_produit`, `prix_vente`, `prix_revient`, `quantity`, `num_cmd`, `id_client`, `idpersonnel`, `idstock`, `datedelete`) VALUES
(1, 1, 70000, 65000, 58, 'acf240001', 1, 1, 1, '2024-01-11 20:39:44'),
(2, 32, 60000, 0, 1, 'acf240016', 1, 2, 1, '2024-01-13 19:06:54'),
(3, 7, 66000, 65000, 60, 'acf240002', 7, 2, 1, '2024-01-14 17:18:18'),
(4, 3, 66000, 65000, 50, 'acf240002', 7, 2, 1, '2024-01-14 17:18:18'),
(5, 9, 66000, 65000, 100, 'acf240002', 7, 2, 1, '2024-01-14 17:18:18'),
(6, 5, 70000, 65000, 18, 'acf240003', 15, 2, 1, '2024-01-14 17:18:41'),
(7, 4, 70000, 0, 1, 'acf240003', 15, 2, 1, '2024-01-14 17:18:41'),
(8, 1, 66000, 65000, 1, 'acf240003', 15, 2, 1, '2024-01-14 17:18:41'),
(9, 10, 35000, 0, 1, 'acf240003', 15, 2, 1, '2024-01-14 17:18:41'),
(10, 3, 66000, 65000, 100, 'acf240004', 14, 2, 1, '2024-01-14 17:21:04'),
(11, 9, 66000, 65000, 20, 'acf240004', 14, 2, 1, '2024-01-14 17:21:04'),
(12, 11, 90000, 85000, 50, 'acf240004', 14, 2, 1, '2024-01-14 17:21:04'),
(13, 12, 45000, 0, 1, 'acf240004', 14, 2, 1, '2024-01-14 17:21:04'),
(14, 1, 66000, 65000, 150, 'acf240005', 21, 2, 1, '2024-01-14 17:22:14'),
(15, 12, 45000, 0, 1, 'acf240005', 21, 2, 1, '2024-01-14 17:22:14'),
(16, 17, 63000, 62000, 50, 'acf240005', 21, 2, 1, '2024-01-14 17:22:14'),
(17, 12, 45000, 0, 1, 'acf240006', 2, 2, 1, '2024-01-14 17:22:37'),
(18, 11, 100000, 85000, 1, 'acf240006', 2, 2, 1, '2024-01-14 17:22:37'),
(19, 11, 90000, 85000, 10, 'acf240014', 14, 2, 1, '2024-01-14 17:23:02'),
(20, 19, 255000, 253200, 20, 'acf240014', 14, 2, 1, '2024-01-14 17:23:02'),
(21, 20, 135000, 126200, 1, 'acf240014', 14, 2, 1, '2024-01-14 17:23:02'),
(22, 2, 33000, 32500, 1, 'acf240014', 14, 2, 1, '2024-01-14 17:23:02'),
(23, 8, 35000, 0, 1, 'acf240014', 14, 2, 1, '2024-01-14 17:23:02'),
(24, 1, 66000, 65000, 1, 'acf240014', 14, 2, 1, '2024-01-14 17:23:02'),
(25, 19, 250000, 253200, 10, 'acf240007', 21, 2, 1, '2024-01-14 17:23:19'),
(26, 20, 130000, 126200, 1, 'acf240007', 21, 2, 1, '2024-01-14 17:23:19'),
(27, 1, 66000, 65000, 1, 'acf240007', 21, 2, 1, '2024-01-14 17:23:19'),
(28, 11, 90000, 85000, 1, 'acf240007', 21, 2, 1, '2024-01-14 17:23:19'),
(29, 12, 45000, 0, 12, 'acf240008', 13, 2, 1, '2024-01-14 17:23:33'),
(30, 6, 33000, 0, 13, 'acf240008', 13, 2, 1, '2024-01-14 17:23:33'),
(31, 20, 135000, 126200, 12, 'acf240008', 13, 2, 1, '2024-01-14 17:23:33'),
(32, 5, 66000, 65000, 1, 'acf240009', 9, 2, 1, '2024-01-14 17:24:02'),
(33, 12, 45000, 0, 1, 'acf240009', 9, 2, 1, '2024-01-14 17:24:02'),
(34, 19, 255000, 253200, 1, 'acf240009', 9, 2, 1, '2024-01-14 17:24:02'),
(35, 19, 255000, 253200, 15, 'acf240010', 22, 2, 1, '2024-01-14 17:24:17'),
(36, 11, 90000, 85000, 1, 'acf240011', 15, 2, 1, '2024-01-14 17:24:29'),
(37, 6, 33000, 0, 1, 'acf240011', 15, 2, 1, '2024-01-14 17:24:29'),
(38, 19, 255000, 253200, 1, 'acf240011', 15, 2, 1, '2024-01-14 17:24:29'),
(39, 20, 135000, 126200, 1, 'acf240012', 21, 2, 1, '2024-01-14 17:24:39'),
(40, 11, 90000, 85000, 1, 'acf240012', 21, 2, 1, '2024-01-14 17:24:39'),
(41, 19, 255000, 253200, 50, 'acf240013', 11, 2, 1, '2024-01-14 17:24:49'),
(42, 5, 66000, 65000, 10, 'acf240015', 1, 2, 1, '2024-01-14 17:25:01'),
(43, 19, 255000, 253200, 1, 'acf240015', 1, 2, 1, '2024-01-14 17:25:01'),
(44, 11, 90000, 85000, 5, 'acf240015', 1, 2, 1, '2024-01-14 17:25:01'),
(45, 4, 35000, 0, 2, 'acf240015', 1, 2, 1, '2024-01-14 17:25:01'),
(46, 10, 33000, 0, 1, 'acf240015', 1, 2, 1, '2024-01-14 17:25:01'),
(47, 11, 90000, 85500, 20, 'acf240017', 18, 2, 1, '2024-01-14 17:25:12'),
(48, 12, 45000, 0, 2, 'acf240017', 18, 2, 1, '2024-01-14 17:25:12'),
(49, 29, 155000, 148200, 50, 'acf240017', 18, 2, 1, '2024-01-14 17:25:12'),
(50, 32, 0, 0, 2, 'acf240017', 18, 2, 1, '2024-01-14 17:25:12'),
(51, 36, 35000, 0, 4, 'acf240017', 18, 2, 1, '2024-01-14 17:25:12'),
(52, 39, 35000, 34400, 45, 'acf240017', 18, 2, 1, '2024-01-14 17:25:12'),
(53, 37, 40000, 38500, 50, 'acf240017', 18, 2, 1, '2024-01-14 17:25:12'),
(54, 1, 66000, 65000, 70, 'acf240017', 18, 2, 1, '2024-01-14 17:25:12'),
(55, 4, 33000, 0, 2, 'acf240017', 18, 2, 1, '2024-01-14 17:25:12'),
(56, 10, 35000, 0, 2, 'acf240017', 18, 2, 1, '2024-01-14 17:25:12');

-- --------------------------------------------------------

--
-- Structure de la table `versement`
--

CREATE TABLE `versement` (
  `id` int(11) NOT NULL,
  `numcmd` varchar(10) DEFAULT NULL,
  `nom_client` varchar(155) NOT NULL,
  `montant` double NOT NULL,
  `devisevers` varchar(20) NOT NULL,
  `taux` float NOT NULL DEFAULT 1,
  `numcheque` varchar(50) DEFAULT NULL,
  `banquecheque` varchar(100) DEFAULT NULL,
  `motif` varchar(150) DEFAULT NULL,
  `type_versement` varchar(15) NOT NULL,
  `comptedep` varchar(50) DEFAULT NULL,
  `lieuvente` varchar(10) DEFAULT NULL,
  `date_versement` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `versement`
--

INSERT INTO `versement` (`id`, `numcmd`, `nom_client`, `montant`, `devisevers`, `taux`, `numcheque`, `banquecheque`, `motif`, `type_versement`, `comptedep`, `lieuvente`, `date_versement`) VALUES
(10, 'dep10', '16', 2942000, 'gnf', 1, '', '', 'Payement facture ', 'espèces', '1', '1', '2024-01-16 20:06:25'),
(9, 'dep9', '77', 1600000, 'gnf', 1, '', '', 'Payement facture ', 'espèces', '1', '1', '2024-01-16 00:00:00'),
(7, 'dep1', '46', 8030000, 'gnf', 1, '', '', 'peyement facture', 'espèces', '1', '1', '2024-01-15 10:43:39'),
(8, 'dep8', '77', 2000000, 'gnf', 1, '', '', 'PAYEMENT FACTUR', 'espèces', '1', '1', '2024-01-15 15:57:01'),
(11, 'dep11', '38', 5100000, 'gnf', 1, '', '', 'Payment Facture', 'espèces', '1', '1', '2024-01-18 09:49:01'),
(12, 'dep12', '51', 4000000, 'gnf', 1, '', '', 'payement facture', 'espèces', '1', '1', '2024-01-18 13:18:56'),
(13, 'dep13', '81', 150000, 'gnf', 1, '', '', 'Payement facture ', 'espèces', '1', '1', '2024-01-18 16:31:00'),
(14, 'dep14', '52', 30000000, 'gnf', 1, '', '', 'Payement facture ', 'espèces', '1', '1', '2024-01-18 00:00:00');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `achat`
--
ALTER TABLE `achat`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `adresse`
--
ALTER TABLE `adresse`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `banque`
--
ALTER TABLE `banque`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `bon_commande`
--
ALTER TABLE `bon_commande`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `bon_commande_produit`
--
ALTER TABLE `bon_commande_produit`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `bulletin`
--
ALTER TABLE `bulletin`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `categoriedep`
--
ALTER TABLE `categoriedep`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `categorieperte`
--
ALTER TABLE `categorieperte`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `categorierecette`
--
ALTER TABLE `categorierecette`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `chequedepasse`
--
ALTER TABLE `chequedepasse`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `clientrelance`
--
ALTER TABLE `clientrelance`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cloture`
--
ALTER TABLE `cloture`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `decaissement`
--
ALTER TABLE `decaissement`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `decdepense`
--
ALTER TABLE `decdepense`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `decloyer`
--
ALTER TABLE `decloyer`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `decpersonnel`
--
ALTER TABLE `decpersonnel`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `devise`
--
ALTER TABLE `devise`
  ADD PRIMARY KEY (`iddevise`);

--
-- Index pour la table `devisevente`
--
ALTER TABLE `devisevente`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `editionfacture`
--
ALTER TABLE `editionfacture`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `editionfournisseur`
--
ALTER TABLE `editionfournisseur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `facture`
--
ALTER TABLE `facture`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `fraisup`
--
ALTER TABLE `fraisup`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `gaindevise`
--
ALTER TABLE `gaindevise`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `historique`
--
ALTER TABLE `historique`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `histpaiefrais`
--
ALTER TABLE `histpaiefrais`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `intertopproduit`
--
ALTER TABLE `intertopproduit`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `inventaire`
--
ALTER TABLE `inventaire`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `licence`
--
ALTER TABLE `licence`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `limitecredit`
--
ALTER TABLE `limitecredit`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `livraison`
--
ALTER TABLE `livraison`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `livraisondelete`
--
ALTER TABLE `livraisondelete`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `logo`
--
ALTER TABLE `logo`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `modep`
--
ALTER TABLE `modep`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `modifcommande`
--
ALTER TABLE `modifcommande`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `modifpayement`
--
ALTER TABLE `modifpayement`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `modifpayementprod`
--
ALTER TABLE `modifpayementprod`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `modifprix`
--
ALTER TABLE `modifprix`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `nombanque`
--
ALTER TABLE `nombanque`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `numerocommande`
--
ALTER TABLE `numerocommande`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `paiecred`
--
ALTER TABLE `paiecred`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `paiecredcmd`
--
ALTER TABLE `paiecredcmd`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `payement`
--
ALTER TABLE `payement`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `personnel`
--
ALTER TABLE `personnel`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pertes`
--
ALTER TABLE `pertes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `productslist`
--
ALTER TABLE `productslist`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `proformat`
--
ALTER TABLE `proformat`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `promotion`
--
ALTER TABLE `promotion`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `recette`
--
ALTER TABLE `recette`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `retourlist`
--
ALTER TABLE `retourlist`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `retourlistclient`
--
ALTER TABLE `retourlistclient`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `statproduit`
--
ALTER TABLE `statproduit`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `stock1`
--
ALTER TABLE `stock1`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `stockmouv`
--
ALTER TABLE `stockmouv`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `topclient`
--
ALTER TABLE `topclient`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `transferfond`
--
ALTER TABLE `transferfond`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `transferprod`
--
ALTER TABLE `transferprod`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `validcomande`
--
ALTER TABLE `validcomande`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `validcomandefrais`
--
ALTER TABLE `validcomandefrais`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `validpaie`
--
ALTER TABLE `validpaie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `validpaiemodif`
--
ALTER TABLE `validpaiemodif`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `validvente`
--
ALTER TABLE `validvente`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `validventemodif`
--
ALTER TABLE `validventemodif`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ventedelete`
--
ALTER TABLE `ventedelete`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `versement`
--
ALTER TABLE `versement`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `achat`
--
ALTER TABLE `achat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT pour la table `adresse`
--
ALTER TABLE `adresse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `banque`
--
ALTER TABLE `banque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT pour la table `bon_commande`
--
ALTER TABLE `bon_commande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `bon_commande_produit`
--
ALTER TABLE `bon_commande_produit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `bulletin`
--
ALTER TABLE `bulletin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=291;

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `categoriedep`
--
ALTER TABLE `categoriedep`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `categorieperte`
--
ALTER TABLE `categorieperte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `categorierecette`
--
ALTER TABLE `categorierecette`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `chequedepasse`
--
ALTER TABLE `chequedepasse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- AUTO_INCREMENT pour la table `clientrelance`
--
ALTER TABLE `clientrelance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `cloture`
--
ALTER TABLE `cloture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT pour la table `decaissement`
--
ALTER TABLE `decaissement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `decdepense`
--
ALTER TABLE `decdepense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `decloyer`
--
ALTER TABLE `decloyer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `decpersonnel`
--
ALTER TABLE `decpersonnel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `devise`
--
ALTER TABLE `devise`
  MODIFY `iddevise` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `devisevente`
--
ALTER TABLE `devisevente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `editionfacture`
--
ALTER TABLE `editionfacture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `editionfournisseur`
--
ALTER TABLE `editionfournisseur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `facture`
--
ALTER TABLE `facture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `fraisup`
--
ALTER TABLE `fraisup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `gaindevise`
--
ALTER TABLE `gaindevise`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `historique`
--
ALTER TABLE `historique`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `histpaiefrais`
--
ALTER TABLE `histpaiefrais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `intertopproduit`
--
ALTER TABLE `intertopproduit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `inventaire`
--
ALTER TABLE `inventaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `licence`
--
ALTER TABLE `licence`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `limitecredit`
--
ALTER TABLE `limitecredit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- AUTO_INCREMENT pour la table `livraison`
--
ALTER TABLE `livraison`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT pour la table `livraisondelete`
--
ALTER TABLE `livraisondelete`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT pour la table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- AUTO_INCREMENT pour la table `logo`
--
ALTER TABLE `logo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `modep`
--
ALTER TABLE `modep`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT pour la table `modifcommande`
--
ALTER TABLE `modifcommande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `modifpayement`
--
ALTER TABLE `modifpayement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `modifpayementprod`
--
ALTER TABLE `modifpayementprod`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `modifprix`
--
ALTER TABLE `modifprix`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `nombanque`
--
ALTER TABLE `nombanque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `numerocommande`
--
ALTER TABLE `numerocommande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `paiecred`
--
ALTER TABLE `paiecred`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `paiecredcmd`
--
ALTER TABLE `paiecredcmd`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `payement`
--
ALTER TABLE `payement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT pour la table `personnel`
--
ALTER TABLE `personnel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pertes`
--
ALTER TABLE `pertes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `productslist`
--
ALTER TABLE `productslist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT pour la table `proformat`
--
ALTER TABLE `proformat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `promotion`
--
ALTER TABLE `promotion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `recette`
--
ALTER TABLE `recette`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `retourlist`
--
ALTER TABLE `retourlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `retourlistclient`
--
ALTER TABLE `retourlistclient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `statproduit`
--
ALTER TABLE `statproduit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `stock1`
--
ALTER TABLE `stock1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT pour la table `stockmouv`
--
ALTER TABLE `stockmouv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=298;

--
-- AUTO_INCREMENT pour la table `topclient`
--
ALTER TABLE `topclient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `transferfond`
--
ALTER TABLE `transferfond`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `transferprod`
--
ALTER TABLE `transferprod`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `validcomande`
--
ALTER TABLE `validcomande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `validcomandefrais`
--
ALTER TABLE `validcomandefrais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `validpaie`
--
ALTER TABLE `validpaie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=219;

--
-- AUTO_INCREMENT pour la table `validpaiemodif`
--
ALTER TABLE `validpaiemodif`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `validvente`
--
ALTER TABLE `validvente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `validventemodif`
--
ALTER TABLE `validventemodif`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `ventedelete`
--
ALTER TABLE `ventedelete`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT pour la table `versement`
--
ALTER TABLE `versement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
