-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 19 nov. 2018 à 17:11
-- Version du serveur :  5.7.21
-- Version de PHP :  5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `decanat`
--

-- --------------------------------------------------------

--
-- Structure de la table `agent`
--

DROP TABLE IF EXISTS `agent`;
CREATE TABLE IF NOT EXISTS `agent` (
  `Id` varchar(50) NOT NULL,
  `Password` varchar(500) NOT NULL,
  `Actif` bit(1) NOT NULL,
  `Prenom` varchar(100) NOT NULL,
  `Nom` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `agent`
--

INSERT INTO `agent` (`Id`, `Password`, `Actif`, `Prenom`, `Nom`, `Email`) VALUES
('colf03', '$2y$10$s3kEcTBAZW7E1..pWDMZsuuI56o6Fng7iwoGG34Oor5qP.MBEiaKC', b'1', 'Florian', 'Colly', 'colf03@uqo.ca'),
('admin', '$2y$10$2GU/C5psdWNY49dmAjRmH.Qysz3Zs6Nw1LmY8FWYeA9BTjHMqPSJy', b'0', 'admin', 'admin', 'admin'),
('lionel', '$2y$10$IKYz5/dwGqr8Cdk0GZWdHexbMFr08ov0JQCgqM/lP2Bo9JkSbQsCC', b'1', 'Lionel', 'test', 'test');

-- --------------------------------------------------------

--
-- Structure de la table `agentresponsable_decanatreso`
--

DROP TABLE IF EXISTS `agentresponsable_decanatreso`;
CREATE TABLE IF NOT EXISTS `agentresponsable_decanatreso` (
  `NumReso_id` int(5) NOT NULL,
  `agent_id` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `cour`
--

DROP TABLE IF EXISTS `cour`;
CREATE TABLE IF NOT EXISTS `cour` (
  `Sigle` varchar(10) NOT NULL,
  `NomCours` varchar(100) NOT NULL,
  `Cycle` int(2) DEFAULT NULL,
  PRIMARY KEY (`Sigle`),
  UNIQUE KEY `Sigle` (`Sigle`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `cour`
--

INSERT INTO `cour` (`Sigle`, `NomCours`, `Cycle`) VALUES
('ADM1003', 'Analyse des systèmes d\'information', 1),
('BEA5031', 'Séminaire d’intégration IV', 1),
('ANG1273', 'Rédaction anglaise - Avancé II', 1),
('MAT1053', 'Algèbre linéaire', 1),
('INF4103', 'Architecture des ordinateurs II', 1),
('IXI458', 'INFO test', 2);

-- --------------------------------------------------------

--
-- Structure de la table `cour_decanatreso`
--

DROP TABLE IF EXISTS `cour_decanatreso`;
CREATE TABLE IF NOT EXISTS `cour_decanatreso` (
  `decanatReso_id` int(5) NOT NULL,
  `cour_id` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `cour_receptionreso`
--

DROP TABLE IF EXISTS `cour_receptionreso`;
CREATE TABLE IF NOT EXISTS `cour_receptionreso` (
  `cour_id` varchar(10) NOT NULL,
  `receptionReso_id` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `cour_receptionreso`
--

INSERT INTO `cour_receptionreso` (`cour_id`, `receptionReso_id`) VALUES
('ADM1003', 5),
('ANG1273', 5),
('ANG1273', 6),
('BEA5031', 6),
('ADM1003', 8);

-- --------------------------------------------------------

--
-- Structure de la table `decanatreso`
--

DROP TABLE IF EXISTS `decanatreso`;
CREATE TABLE IF NOT EXISTS `decanatreso` (
  `Id` int(5) NOT NULL AUTO_INCREMENT,
  `NumReso` varchar(20) NOT NULL,
  `NumUniqueInstance` varchar(30) NOT NULL,
  `seance_id` int(30) NOT NULL,
  `projet_id` int(11) NOT NULL,
  `ResumeReso` varchar(200) NOT NULL,
  `DateReso` date NOT NULL,
  `DescriptionReso` varchar(2000) NOT NULL,
  `DateEffective` date NOT NULL,
  `Campus` varchar(50) NOT NULL COMMENT 'Alexandre-Taché, Lucien-Brault, Saint-Jérôme',
  `Note` varchar(3000) NOT NULL,
  `VariaSuivi` varchar(300) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `departement`
--

DROP TABLE IF EXISTS `departement`;
CREATE TABLE IF NOT EXISTS `departement` (
  `NumDepartement` varchar(10) NOT NULL,
  `NomDepartement` varchar(60) NOT NULL,
  `NomSecteur_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`NumDepartement`),
  UNIQUE KEY `NumDepartement` (`NumDepartement`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `departement`
--

INSERT INTO `departement` (`NumDepartement`, `NomDepartement`, `NomSecteur_id`) VALUES
('DCTB', 'Département des sciences comptables', 'Sciences comptables'),
('EMI', 'École multidisciplinaire de l\'image', 'Arts'),
('DII', 'Département d\'informatique et d\'ingénierie', 'Informatique/Ingénierie');

-- --------------------------------------------------------

--
-- Structure de la table `programmes`
--

DROP TABLE IF EXISTS `programmes`;
CREATE TABLE IF NOT EXISTS `programmes` (
  `CodeProgramme` varchar(20) NOT NULL,
  `NomProgramme` varchar(100) NOT NULL,
  `TypeProgramme` varchar(50) NOT NULL,
  `codeUgp_id` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`CodeProgramme`),
  UNIQUE KEY `CodeProgramme` (`CodeProgramme`),
  UNIQUE KEY `NomProgramme` (`NomProgramme`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `programmes`
--

INSERT INTO `programmes` (`CodeProgramme`, `NomProgramme`, `TypeProgramme`, `codeUgp_id`) VALUES
('0028', 'Programme court de premier cycle en enseignement de l\'initiation à l\'informatique', 'court de premier cycle', NULL),
('0014', 'Programme court de premier cycle: cours supplémentaires pour l\'obtention du diplôme', 'court de premier cycle', NULL),
('0048', 'Programme court de premier cycle en enseignement des matières administratives et commerciales', 'court de premier cycle', NULL),
('dafaDAF', 'DAA', 'none', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `programme_decanatreso`
--

DROP TABLE IF EXISTS `programme_decanatreso`;
CREATE TABLE IF NOT EXISTS `programme_decanatreso` (
  `programme_id` varchar(20) NOT NULL,
  `decanatReso_id` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `programme_receptionreso`
--

DROP TABLE IF EXISTS `programme_receptionreso`;
CREATE TABLE IF NOT EXISTS `programme_receptionreso` (
  `programme_id` varchar(20) NOT NULL,
  `receptionReso_id` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `programme_receptionreso`
--

INSERT INTO `programme_receptionreso` (`programme_id`, `receptionReso_id`) VALUES
('0028', 5),
('0014', 5),
('0014', 6),
('', 6),
('0014', 8);

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

DROP TABLE IF EXISTS `projet`;
CREATE TABLE IF NOT EXISTS `projet` (
  `NumProjet` int(11) NOT NULL AUTO_INCREMENT,
  `agent_id` varchar(50) DEFAULT NULL,
  `DescriptionProjet` varchar(1000) DEFAULT NULL,
  `EtatProjet` varchar(50) DEFAULT NULL,
  `Notes` varchar(2000) DEFAULT NULL,
  `LienDossier` varchar(2098) DEFAULT NULL,
  PRIMARY KEY (`NumProjet`),
  UNIQUE KEY `NumProjet` (`NumProjet`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `projet`
--

INSERT INTO `projet` (`NumProjet`, `agent_id`, `DescriptionProjet`, `EtatProjet`, `Notes`, `LienDossier`) VALUES
(1, '', 'Suppression programme court', 'ouvert', 'voir monsieur x', NULL),
(2, '', 'dsds', 'fermé', 'dsds', 'ds'),
(3, '', 'gsds', 'ouvert', 'dsfs', ''),
(4, '', 'dsa', 'fermé', 'sa', ''),
(5, '', 'dss', 'ouvert', 'ds', 'dfsf'),
(6, '', 'dss', 'ouvert', 'ds', 'dfsf'),
(7, '', 'dssa', 'fermé', 'sasa', 'sa'),
(8, '', 'sasa', 'fermé', 'sfd', ''),
(9, '', 'ds', 'fermé', 'sa', 'sa'),
(10, '', 'ds', 'fermé', 'sa', 'sa'),
(11, '', 'Fermeture', 'ouvert', 'test numero 1', 'ada'),
(12, '', 'Fermeture', 'ouvert', 'test numero 1', 'ada'),
(13, '', 'Fermeture', 'ouvert', 'test numero 1', 'ada'),
(14, '', 'f', 'ouvert', 'sasa', 'sasa'),
(15, '', 'f', 'ouvert', 'sasa', 'sasa'),
(16, '', 'f', 'ouvert', 'sasa', 'sasa'),
(17, '', 'f', 'ouvert', 'sasa', 'sasa'),
(18, '', 'f', 'ouvert', 'sasa', 'sasa'),
(19, '', 'f', 'ouvert', 'sasa', 'sasa'),
(20, '', 'f', 'ouvert', 'sasa', 'sasa'),
(21, '', 'f', 'ouvert', 'sasa', 'sasa'),
(22, '', 'f', 'ouvert', 'sasa', 'sasa'),
(23, '', 'f', 'ouvert', 'sasa', 'sasa'),
(24, '', 'f', 'ouvert', 'sasa', 'sasa'),
(25, '', 'f', 'ouvert', 'sasa', 'sasa'),
(26, '', 'Changement de pré requis', 'ouvert', 'Liée a l gup 1CTB', '');

-- --------------------------------------------------------

--
-- Structure de la table `receptionreso`
--

DROP TABLE IF EXISTS `receptionreso`;
CREATE TABLE IF NOT EXISTS `receptionreso` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `NumReception` varchar(10) NOT NULL,
  `Sujet` varchar(300) DEFAULT NULL,
  `NumProjet_id` int(11) DEFAULT NULL,
  `DateDemande` date NOT NULL,
  `DateReception` date DEFAULT NULL,
  `Traitement` varchar(60) DEFAULT NULL,
  `Notes` varchar(2000) DEFAULT NULL,
  `Departement_id` varchar(10) DEFAULT NULL,
  `codeUgp_id` varchar(10) DEFAULT NULL,
  `agent_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `NumReception` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `receptionreso`
--

INSERT INTO `receptionreso` (`id`, `NumReception`, `Sujet`, `NumProjet_id`, `DateDemande`, `DateReception`, `Traitement`, `Notes`, `Departement_id`, `codeUgp_id`, `agent_id`) VALUES
(5, 'CTB1X', 'Changement pré requis', 26, '2018-11-07', NULL, 'En attente de la prise en charge par un agent', 'none', 'DII', '1CTB', NULL),
(6, 'CTB6X4', 'Fermeture cour', 11, '2018-11-08', NULL, 'En attente de la prise en charge par un agent', 'voir conseil de septembre', 'DII', '1CTB', NULL),
(7, 'UGX18', 'Association cour', 11, '2018-11-15', NULL, 'Pris en charge', 'A debatre', 'DII', '1CTB', 'colf03'),
(8, 'test185', 'dadag', 1, '2018-11-19', NULL, 'En attente de la prise en charge par un agent', 'dafgf', 'DCTB', '1CTB', NULL),
(9, 'fada', 'sada', 29, '2018-11-19', NULL, 'Enregistré', 'dags', 'DCTB', '1CTB', NULL),
(10, 'afgg', 'a', 30, '2018-11-19', NULL, 'Enregistré', 'fdhg', 'DCTB', '1CTB', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `receptionreso_decanatreso`
--

DROP TABLE IF EXISTS `receptionreso_decanatreso`;
CREATE TABLE IF NOT EXISTS `receptionreso_decanatreso` (
  `receptionReso_id` int(5) NOT NULL,
  `decanatReso_id` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `seance`
--

DROP TABLE IF EXISTS `seance`;
CREATE TABLE IF NOT EXISTS `seance` (
  `NumSeance` int(30) NOT NULL AUTO_INCREMENT,
  `DateSeance` date DEFAULT NULL,
  `Instance` varchar(3) NOT NULL COMMENT '(''CA'', ''CE'', ''SCE'')',
  PRIMARY KEY (`NumSeance`),
  UNIQUE KEY `NumSeance` (`NumSeance`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `seance`
--

INSERT INTO `seance` (`NumSeance`, `DateSeance`, `Instance`) VALUES
(1, '2018-09-27', 'CA');

-- --------------------------------------------------------

--
-- Structure de la table `secteur`
--

DROP TABLE IF EXISTS `secteur`;
CREATE TABLE IF NOT EXISTS `secteur` (
  `NomSecteur` varchar(50) NOT NULL,
  PRIMARY KEY (`NomSecteur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `secteur`
--

INSERT INTO `secteur` (`NomSecteur`) VALUES
('Arts'),
('Études langagières'),
('Informatique'),
('Ingénierie'),
('Sciences comptables');

-- --------------------------------------------------------

--
-- Structure de la table `suivi`
--

DROP TABLE IF EXISTS `suivi`;
CREATE TABLE IF NOT EXISTS `suivi` (
  `NomSuivi` varchar(200) NOT NULL,
  `Processus` varchar(2000) NOT NULL,
  PRIMARY KEY (`NomSuivi`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `typeresolution`
--

DROP TABLE IF EXISTS `typeresolution`;
CREATE TABLE IF NOT EXISTS `typeresolution` (
  `TypeReso` varchar(200) NOT NULL,
  `Priorite` varchar(6) DEFAULT NULL COMMENT '(''URGENT'', ''HAUT'', ''MOYEN'', ''BAS'')',
  `LienProcedure` varchar(2098) DEFAULT NULL,
  PRIMARY KEY (`TypeReso`),
  UNIQUE KEY `TypeReso` (`TypeReso`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `typeresolution`
--

INSERT INTO `typeresolution` (`TypeReso`, `Priorite`, `LienProcedure`) VALUES
('Contingentement', NULL, NULL),
('Creation de cours', NULL, NULL),
('Administration, Politique, Reglement', NULL, NULL),
('Ouverture des admissions', NULL, NULL),
('Modification de cours', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `typeresolution_decanatreso`
--

DROP TABLE IF EXISTS `typeresolution_decanatreso`;
CREATE TABLE IF NOT EXISTS `typeresolution_decanatreso` (
  `TypeReso_id` varchar(200) NOT NULL,
  `NumReso_id` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `typeresolution_receptionreso`
--

DROP TABLE IF EXISTS `typeresolution_receptionreso`;
CREATE TABLE IF NOT EXISTS `typeresolution_receptionreso` (
  `TypeReso_id` varchar(200) NOT NULL,
  `NumReception_id` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `typereso_suivi`
--

DROP TABLE IF EXISTS `typereso_suivi`;
CREATE TABLE IF NOT EXISTS `typereso_suivi` (
  `Suivi_id` varchar(200) NOT NULL,
  `TypeReso_id` varchar(200) NOT NULL,
  `priorite` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ugp`
--

DROP TABLE IF EXISTS `ugp`;
CREATE TABLE IF NOT EXISTS `ugp` (
  `CodeUGP` varchar(10) NOT NULL,
  `NomUGP` varchar(100) NOT NULL,
  `cycle` int(2) NOT NULL,
  `NumDepartement_id` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`CodeUGP`),
  UNIQUE KEY `CodeUGP` (`CodeUGP`),
  UNIQUE KEY `NomUGP` (`NomUGP`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ugp`
--

INSERT INTO `ugp` (`CodeUGP`, `NomUGP`, `cycle`, `NumDepartement_id`) VALUES
('1CTB', 'Module des sciences comptables', 1, 'DCTB'),
('1EMI', 'UGP de 1er cycle en arts', 1, 'EMI'),
('1INF', 'Module de l\'informatique', 1, 'DII'),
('1ING', 'Module de l\'ingénierie', 1, 'DII');

-- --------------------------------------------------------

--
-- Structure de la table `ugp_decanatreso`
--

DROP TABLE IF EXISTS `ugp_decanatreso`;
CREATE TABLE IF NOT EXISTS `ugp_decanatreso` (
  `ugp_id` varchar(10) NOT NULL,
  `decanatReso_id` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
