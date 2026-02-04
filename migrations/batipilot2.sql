-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : mer. 04 fév. 2026 à 13:31
-- Version du serveur : 11.4.9-MariaDB
-- Version de PHP : 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `batipilot2`
--

-- --------------------------------------------------------

--
-- Structure de la table `chantier`
--

DROP TABLE IF EXISTS `chantier`;
CREATE TABLE IF NOT EXISTS `chantier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adresse` varchar(150) DEFAULT NULL,
  `copos` varchar(5) DEFAULT NULL,
  `ville` varchar(80) NOT NULL,
  `date_prevue` date DEFAULT NULL,
  `date_demarrage` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `date_reception` date DEFAULT NULL,
  `distance_depot` int(11) DEFAULT NULL,
  `temps_trajet` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `statut_id` int(11) NOT NULL,
  `archive` int(11) NOT NULL,
  `surface_plancher` double DEFAULT NULL,
  `surface_habitable` double DEFAULT NULL,
  `equipe_id` int(11) DEFAULT NULL,
  `alerte` longtext DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_636F27F619EB6921` (`client_id`),
  KEY `IDX_636F27F6F6203804` (`statut_id`),
  KEY `IDX_636F27F66D861B89` (`equipe_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `chantier`
--

INSERT INTO `chantier` (`id`, `adresse`, `copos`, `ville`, `date_prevue`, `date_demarrage`, `date_fin`, `date_reception`, `distance_depot`, `temps_trajet`, `client_id`, `statut_id`, `archive`, `surface_plancher`, `surface_habitable`, `equipe_id`, `alerte`) VALUES
(1, '14 rue de la demeurante', '53000', 'villar', '2025-09-01', '2025-10-01', '2026-01-15', '2026-01-20', 52, 63, 1, 3, 0, 78, 62, 1, 'Vérifier hauteur sous faîtage avant pose placo'),
(2, '6 rue des fossettes', '14123', 'Ifs', '2025-11-10', '2025-12-01', '2026-02-28', '2026-03-05', 24, 22, 2, 1, 0, 82, 65, 2, 'Passage réseaux électriques à coordonner'),
(3, '78 rue des fanons ', '26300', 'bilville', '2025-12-15', '2026-01-01', '2026-03-10', '2026-03-15', 36, 24, 3, 1, 0, 75, 59, 1, 'Isolation renforcée demandée par le client'),
(4, '18 rue de la chausser', '75000', 'Bretteville', '2024-10-01', '2025-01-02', '2026-06-10', '2026-09-18', 52, 45, 4, 1, 0, 90, 71, 2, 'Trémie escalier à ajuster sur site'),
(5, '52 rue des galets ', '16000', 'Vic-Fezensac', '2025-05-01', '2025-06-01', '2026-05-10', '2026-05-15', 22, 25, 5, 1, 0, 68, 53, 1, 'Attention accès chantier étroit'),
(6, '12 rue des Tilleuls', '45120', 'Montfaucon', '2027-01-05', '2027-02-01', '2027-03-15', '2027-03-20', 18, 25, 6, 2, 0, 85, 68, 2, 'Fenêtre de toit à repositionner'),
(7, '8 avenue du Verger', '33240', 'Saint-Laurin', '2027-04-10', '2027-05-01', '2027-06-10', '2027-06-15', 42, 50, 7, 2, 0, 92, 73, 1, 'Délai menuiseries à surveiller'),
(8, '27 impasse des Pins', '68450', 'Valbois', '2027-07-01', '2027-07-15', '2027-08-30', '2027-09-05', 12, 18, 8, 2, 0, 80, 63, 2, 'Prévoir renfort de plancher'),
(9, '5 chemin de la Gare', '59210', 'Nordville', '2027-10-05', '2027-11-01', '2027-12-15', '2027-12-20', 30, 40, 9, 2, 0, 74, 58, 1, 'Gaines VMC à intégrer avant doublage'),
(10, '19 rue du Moulin', '71380', 'Clairval', '2028-01-10', '2028-02-01', '2028-03-10', '2028-03-15', 9, 14, 10, 2, 0, 88, 70, 2, 'Contrôle acoustique entre niveaux'),
(11, '41 boulevard Armand', '26190', 'Rochebrune', '2022-01-05', '2022-02-01', '2022-03-15', '2022-03-20', 55, 65, 13, 3, 0, 69, 55, 1, 'Zone sous pente non comptée habitable'),
(12, '6 allée des Cerisiers', '80470', 'Bellefontaine', '2023-04-10', '2023-05-01', '2023-06-10', '2023-06-15', 22, 28, 15, 3, 0, 95, 76, 2, 'Coordination charpentier / plaquiste'),
(13, '33 rue du Panorama', '11700', 'Hauterive', '2023-07-01', '2023-07-15', '2023-08-30', '2023-09-05', 38, 45, 14, 3, 1, 83, 66, 1, 'Présence d’un poteau à habiller'),
(14, '14 place des Érables', '49560', 'Pontclair', '2024-02-05', '2024-03-01', '2024-04-10', '2024-04-15', 16, 22, 12, 3, 0, 77, 61, 2, 'Vérifier conformité RT en isolation'),
(15, '2 route des Vignes', '90210', 'Valcôte', '2026-07-09', '2026-07-09', '2027-06-11', '2027-06-09', 48, 55, 11, 2, 0, 91, 72, 1, 'Client souhaite cloisons modifiables');

-- --------------------------------------------------------

--
-- Structure de la table `chantier_etape`
--

DROP TABLE IF EXISTS `chantier_etape`;
CREATE TABLE IF NOT EXISTS `chantier_etape` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `val_text` varchar(50) DEFAULT NULL,
  `val_date` date DEFAULT NULL,
  `val_date_heure` datetime DEFAULT NULL,
  `val_boolean` tinyint(4) DEFAULT NULL,
  `date_decimal` double DEFAULT NULL,
  `chantier_id` int(11) DEFAULT NULL,
  `etape_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3B99027D4A8CA2AD` (`etape_id`),
  KEY `IDX_3B99027DD0C0049D` (`chantier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `chantier_etape`
--

INSERT INTO `chantier_etape` (`id`, `val_text`, `val_date`, `val_date_heure`, `val_boolean`, `date_decimal`, `chantier_id`, `etape_id`) VALUES
(13, NULL, NULL, NULL, 1, NULL, 3, 1),
(14, NULL, NULL, NULL, 0, NULL, 3, 2),
(15, 'M. Dassin', NULL, NULL, NULL, NULL, 3, 7),
(36, NULL, NULL, NULL, 0, NULL, 2, 1),
(37, NULL, '2025-12-22', NULL, NULL, NULL, 2, 3),
(38, NULL, '2025-12-26', NULL, NULL, NULL, 2, 5),
(39, NULL, NULL, NULL, 1, NULL, 2, 6),
(40, NULL, NULL, NULL, 0, NULL, 2, 8),
(41, NULL, NULL, '2025-12-31 10:00:00', NULL, NULL, 2, 9),
(42, NULL, NULL, NULL, 1, NULL, 2, 10),
(43, NULL, '2025-12-31', NULL, NULL, NULL, 2, 14),
(44, NULL, '2025-12-11', NULL, NULL, NULL, 2, 17),
(45, NULL, NULL, NULL, 1, NULL, 2, 19),
(76, NULL, NULL, NULL, 1, NULL, 1, 1),
(77, NULL, NULL, NULL, 1, NULL, 1, 10);

-- --------------------------------------------------------

--
-- Structure de la table `chantier_poste`
--

DROP TABLE IF EXISTS `chantier_poste`;
CREATE TABLE IF NOT EXISTS `chantier_poste` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `montant_ht` double DEFAULT NULL,
  `montant_ttc` double DEFAULT NULL,
  `chantier_id` int(11) DEFAULT NULL,
  `poste_id` int(11) DEFAULT NULL,
  `nb_jours_mo` double DEFAULT NULL,
  `nom_prestataire` varchar(255) DEFAULT NULL,
  `montant_prestataire` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6F4F780BD0C0049D` (`chantier_id`),
  KEY `IDX_6F4F780BA0905086` (`poste_id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `chantier_poste`
--

INSERT INTO `chantier_poste` (`id`, `montant_ht`, `montant_ttc`, `chantier_id`, `poste_id`, `nb_jours_mo`, `nom_prestataire`, `montant_prestataire`) VALUES
(3, 500, 55500, 3, 1, NULL, NULL, NULL),
(4, 5000, NULL, 3, 2, NULL, NULL, NULL),
(5, 5000, 5500, 3, 4, NULL, NULL, NULL),
(6, 4500, 8000, 3, 5, NULL, NULL, NULL),
(32, 5000.23, 5500.45, 1, 1, NULL, NULL, NULL),
(33, 8500, 10000.25, 1, 2, NULL, NULL, NULL),
(72, 452, 423, 15, 8, NULL, 'test', 525);

-- --------------------------------------------------------

--
-- Structure de la table `chantier_presta`
--

DROP TABLE IF EXISTS `chantier_presta`;
CREATE TABLE IF NOT EXISTS `chantier_presta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `montant_presta` double DEFAULT NULL,
  `nom_presta` varchar(150) NOT NULL,
  `chantier_id` int(11) NOT NULL,
  `poste_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C49E4656D0C0049D` (`chantier_id`),
  KEY `IDX_C49E4656A0905086` (`poste_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `chantier_presta`
--

INSERT INTO `chantier_presta` (`id`, `montant_presta`, `nom_presta`, `chantier_id`, `poste_id`) VALUES
(1, 500, 'test_prestataire', 15, 8);

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(80) NOT NULL,
  `prenom` varchar(80) DEFAULT NULL,
  `telephone` varchar(14) DEFAULT NULL,
  `mail` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `nom`, `prenom`, `telephone`, `mail`) VALUES
(1, 'Martin', 'Julie', '06 12 34 56 01', 'julie.martin@example.com'),
(2, 'Duval', 'Laurence', '06.45.65.65.65', 'lduvak@gmail.Com'),
(3, 'Dupont', 'Claire', '06 12 34 56 02', 'claire.dupont@example.com'),
(4, 'Rocher', 'Marta', '0605040506', 'marta.rocher@gmail.com'),
(5, 'Bernard', 'Lucas', '06 12 34 56 03', 'lucas.bernard@example.com'),
(6, 'Petit', 'Emma', '06 12 34 56 04', 'emma.petit@example.com'),
(7, 'Robert', 'Thomas', '06 12 34 56 05', 'thomas.robert@example.com'),
(8, 'Richard', 'Léa', '06 12 34 56 06', 'lea.richard@example.com'),
(9, 'Durand', 'Hugo', '06 12 34 56 07', 'hugo.durand@example.com'),
(10, 'Moreau', 'Chloé', '06 12 34 56 08', 'chloe.moreau@example.com'),
(11, 'Laurent', 'Antoine', '06 12 34 56 09', 'antoine.laurent@example.com'),
(12, 'Simon', 'Camille', '06 12 34 56 10', 'camille.simon@example.com'),
(13, 'Michel', 'Nathan', '06 12 34 56 11', 'nathan.michel@example.com'),
(14, 'Lefèvre', 'Sarah', '06 12 34 56 12', 'sarah.lefevre@example.com'),
(15, 'Garcia', 'Enzo', '06 12 34 56 13', 'enzo.garcia@example.com'),
(21, 'Villain', 'Alexandre', '06.45.65.65.65', 'test.test@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20260106085048', '2026-01-06 08:51:03', 165),
('DoctrineMigrations\\Version20260120152734', '2026-01-20 15:28:31', 271),
('DoctrineMigrations\\Version20260122090915', '2026-01-22 09:09:28', 233),
('DoctrineMigrations\\Version20260122133617', '2026-01-22 13:58:43', 406),
('DoctrineMigrations\\Version20260123092814', '2026-01-23 09:28:23', 84),
('DoctrineMigrations\\Version20260123132223', '2026-01-23 13:22:31', 181),
('DoctrineMigrations\\Version20260127091939', '2026-01-27 09:19:44', 74),
('DoctrineMigrations\\Version20260128144852', '2026-01-28 14:54:14', 96),
('DoctrineMigrations\\Version20260203101313', '2026-02-03 10:14:31', 75);

-- --------------------------------------------------------

--
-- Structure de la table `equipe`
--

DROP TABLE IF EXISTS `equipe`;
CREATE TABLE IF NOT EXISTS `equipe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `montant_mo` double DEFAULT NULL,
  `indice` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `equipe`
--

INSERT INTO `equipe` (`id`, `nom`, `montant_mo`, `indice`) VALUES
(1, 'Equipe Tradi', NULL, NULL),
(2, 'Equipe Fermette', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `etape`
--

DROP TABLE IF EXISTS `etape`;
CREATE TABLE IF NOT EXISTS `etape` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) NOT NULL,
  `display_field` int(11) NOT NULL,
  `archive` int(11) NOT NULL,
  `etape_format_id` int(11) NOT NULL,
  `poste_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_285F75DDFB3A43EA` (`etape_format_id`),
  KEY `IDX_285F75DDA0905086` (`poste_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `etape`
--

INSERT INTO `etape` (`id`, `libelle`, `display_field`, `archive`, `etape_format_id`, `poste_id`) VALUES
(1, 'demande prime CEE', 1, 0, 1, 1),
(2, 'PTZ', 1, 0, 1, 1),
(3, 'date de dépôt DP ou PC', 1, 0, 2, 1),
(4, 'Zone BF ou MH', 0, 0, 1, 1),
(5, 'date de réception arrêté', 1, 0, 2, 1),
(6, 'panneau de chantier', 1, 0, 1, 1),
(7, 'architecte', 0, 0, 4, 1),
(8, 'Commande Dispano effectuée', 1, 0, 1, 2),
(9, 'date et heure de livraison', 1, 0, 3, 2),
(10, 'Commande Velux', 0, 0, 1, 3),
(11, 'DPE', 0, 0, 1, 1),
(12, 'date de livraison', 1, 0, 2, 3),
(13, 'date de commande', 0, 0, 2, 4),
(14, 'date de livraison', 0, 0, 2, 4),
(15, 'Equipe combles et création', 0, 0, 1, 4),
(16, 'fait par', 0, 0, 4, 4),
(17, 'date de prise de cotes', 1, 0, 2, 5),
(18, 'date et heure de pose', 1, 0, 3, 5),
(19, 'balustrade', 1, 0, 1, 5),
(21, 'carrelage', 1, 0, 1, 10),
(23, 'Note', 1, 0, 4, 1);

-- --------------------------------------------------------

--
-- Structure de la table `etape_format`
--

DROP TABLE IF EXISTS `etape_format`;
CREATE TABLE IF NOT EXISTS `etape_format` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `etape_format`
--

INSERT INTO `etape_format` (`id`, `libelle`) VALUES
(1, 'oui ou non'),
(2, 'date'),
(3, 'date et heure'),
(4, 'texte'),
(5, 'nombre entier'),
(6, 'nombre décimal');

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `poste`
--

DROP TABLE IF EXISTS `poste`;
CREATE TABLE IF NOT EXISTS `poste` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(80) NOT NULL,
  `ordre` int(11) NOT NULL,
  `tva` double DEFAULT NULL,
  `archive` int(11) NOT NULL,
  `equipe` int(100) DEFAULT NULL,
  `presta` int(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `poste`
--

INSERT INTO `poste` (`id`, `libelle`, `ordre`, `tva`, `archive`, `equipe`, `presta`) VALUES
(1, 'Pré-chantier', 1, NULL, 0, 0, 1),
(2, 'Charpente', 2, 10, 0, 1, 0),
(3, 'Couverture', 3, NULL, 0, 1, 0),
(4, 'Maçonnerie', 4, 10, 0, 0, 1),
(5, 'Escalier et balustrade', 5, 5, 0, 0, 1),
(6, 'Platrerie et Isolation', 6, 5.5, 0, 1, 0),
(7, 'Platrerie et Cloison', 7, 10, 0, 1, 0),
(8, 'Electricité et chauffage', 8, 10, 0, 0, 1),
(9, 'Plomberie', 9, 10, 0, 0, 1),
(10, 'Revêtement', 10, 10, 0, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `statut`
--

DROP TABLE IF EXISTS `statut`;
CREATE TABLE IF NOT EXISTS `statut` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `statut`
--

INSERT INTO `statut` (`id`, `libelle`) VALUES
(1, 'démarrés'),
(2, 'à venir'),
(3, 'terminés');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `chantier`
--
ALTER TABLE `chantier`
  ADD CONSTRAINT `FK_636F27F619EB6921` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `FK_636F27F66D861B89` FOREIGN KEY (`equipe_id`) REFERENCES `equipe` (`id`),
  ADD CONSTRAINT `FK_636F27F6F6203804` FOREIGN KEY (`statut_id`) REFERENCES `statut` (`id`);

--
-- Contraintes pour la table `chantier_etape`
--
ALTER TABLE `chantier_etape`
  ADD CONSTRAINT `FK_3B99027D4A8CA2AD` FOREIGN KEY (`etape_id`) REFERENCES `etape` (`id`),
  ADD CONSTRAINT `FK_3B99027DD0C0049D` FOREIGN KEY (`chantier_id`) REFERENCES `chantier` (`id`);

--
-- Contraintes pour la table `chantier_poste`
--
ALTER TABLE `chantier_poste`
  ADD CONSTRAINT `FK_6F4F780BA0905086` FOREIGN KEY (`poste_id`) REFERENCES `poste` (`id`),
  ADD CONSTRAINT `FK_6F4F780BD0C0049D` FOREIGN KEY (`chantier_id`) REFERENCES `chantier` (`id`);

--
-- Contraintes pour la table `chantier_presta`
--
ALTER TABLE `chantier_presta`
  ADD CONSTRAINT `FK_C49E4656A0905086` FOREIGN KEY (`poste_id`) REFERENCES `poste` (`id`),
  ADD CONSTRAINT `FK_C49E4656D0C0049D` FOREIGN KEY (`chantier_id`) REFERENCES `chantier` (`id`);

--
-- Contraintes pour la table `etape`
--
ALTER TABLE `etape`
  ADD CONSTRAINT `FK_285F75DDA0905086` FOREIGN KEY (`poste_id`) REFERENCES `poste` (`id`),
  ADD CONSTRAINT `FK_285F75DDFB3A43EA` FOREIGN KEY (`etape_format_id`) REFERENCES `etape_format` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
