-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 18 sep. 2018 à 01:22
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
('admin', '$2y$10$2GU/C5psdWNY49dmAjRmH.Qysz3Zs6Nw1LmY8FWYeA9BTjHMqPSJy', b'0', 'admin', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `cour`
--

DROP TABLE IF EXISTS `cour`;
CREATE TABLE IF NOT EXISTS `cour` (
  `Sigle` varchar(10) NOT NULL,
  `NomCours` varchar(100) NOT NULL,
  `Cycle` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Sigle`),
  UNIQUE KEY `Sigle` (`Sigle`)
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

-- --------------------------------------------------------

--
-- Structure de la table `programmes`
--

DROP TABLE IF EXISTS `programmes`;
CREATE TABLE IF NOT EXISTS `programmes` (
  `CodeProgramme` varchar(20) NOT NULL,
  `NomProgramme` varchar(50) NOT NULL,
  `TypeProgramme` varchar(20) NOT NULL,
  `codeUgp_id` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`CodeProgramme`),
  UNIQUE KEY `CodeProgramme` (`CodeProgramme`),
  UNIQUE KEY `NomProgramme` (`NomProgramme`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

DROP TABLE IF EXISTS `projet`;
CREATE TABLE IF NOT EXISTS `projet` (
  `NumProjet` int(11) NOT NULL,
  `DescriptionProjet` varchar(1000) DEFAULT NULL,
  `EtatProjet` varchar(50) DEFAULT NULL,
  `Notes` varchar(2000) DEFAULT NULL,
  `LienDossier` varchar(2098) DEFAULT NULL,
  PRIMARY KEY (`NumProjet`),
  UNIQUE KEY `NumProjet` (`NumProjet`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `receptionreso`
--

DROP TABLE IF EXISTS `receptionreso`;
CREATE TABLE IF NOT EXISTS `receptionreso` (
  `NumReception` varchar(5) NOT NULL,
  `Sujet` varchar(300) DEFAULT NULL,
  `NumProjet_id` int(11) DEFAULT NULL,
  `DateDemande` date NOT NULL,
  `DateReception` date NOT NULL,
  `Traitement` varchar(60) DEFAULT NULL,
  `Notes` varchar(2000) DEFAULT NULL,
  `Departement_id` varchar(10) DEFAULT NULL,
  `codeUgp_id` varchar(10) DEFAULT NULL,
  `agent_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`NumReception`),
  UNIQUE KEY `NumReception` (`NumReception`)
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

-- --------------------------------------------------------

--
-- Structure de la table `ugp`
--

DROP TABLE IF EXISTS `ugp`;
CREATE TABLE IF NOT EXISTS `ugp` (
  `CodeUGP` varchar(10) NOT NULL,
  `NomUGP` varchar(100) NOT NULL,
  `NumDepartement_id` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`CodeUGP`),
  UNIQUE KEY `CodeUGP` (`CodeUGP`),
  UNIQUE KEY `NomUGP` (`NomUGP`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
