-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 22, 2022 at 05:27 PM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cabinet`
--

-- --------------------------------------------------------

--
-- Table structure for table `consultation`
--

DROP TABLE IF EXISTS `consultation`;
CREATE TABLE IF NOT EXISTS `consultation` (
  `id_consult` int(11) NOT NULL AUTO_INCREMENT,
  `date_rdv` date NOT NULL,
  `heure_rdv` time NOT NULL,
  `duree` int(11) NOT NULL DEFAULT '30',
  `id_medecin` int(11) NOT NULL,
  `id_patient` int(11) NOT NULL,
  PRIMARY KEY (`id_consult`),
  KEY `id_medecin` (`id_medecin`,`id_patient`),
  KEY `id_patient` (`id_patient`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `consultation`
--

INSERT INTO `consultation` (`id_consult`, `date_rdv`, `heure_rdv`, `duree`, `id_medecin`, `id_patient`) VALUES
(6, '2021-12-30', '12:30:00', 30, 5, 9),
(8, '2022-01-08', '16:55:00', 10, 4, 13),
(10, '2022-01-10', '14:20:00', 30, 4, 9),
(13, '2022-01-09', '08:20:00', 20, 6, 14),
(14, '2022-01-27', '18:00:00', 50, 5, 10);

-- --------------------------------------------------------

--
-- Table structure for table `medecin`
--

DROP TABLE IF EXISTS `medecin`;
CREATE TABLE IF NOT EXISTS `medecin` (
  `id_medecin` int(11) NOT NULL AUTO_INCREMENT,
  `civilite` char(1) COLLATE latin1_general_ci NOT NULL,
  `nom` varchar(250) COLLATE latin1_general_ci NOT NULL,
  `prenom` varchar(250) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id_medecin`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `medecin`
--

INSERT INTO `medecin` (`id_medecin`, `civilite`, `nom`, `prenom`) VALUES
(4, 'F', 'Roltaaa', 'Emilie'),
(5, 'H', 'Fistaa', 'Mama'),
(6, 'F', 'Coquinou', 'duzÃ©rosix'),
(8, 'F', 'Drogua', 'Monique'),
(10, 'H', 'DE', 'DE'),
(11, 'H', 'DE', 'DE');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

DROP TABLE IF EXISTS `patient`;
CREATE TABLE IF NOT EXISTS `patient` (
  `id_patient` int(11) NOT NULL AUTO_INCREMENT,
  `civilite` char(1) COLLATE latin1_general_ci NOT NULL,
  `nom` varchar(250) COLLATE latin1_general_ci NOT NULL,
  `prenom` varchar(250) COLLATE latin1_general_ci NOT NULL,
  `adresse` varchar(250) COLLATE latin1_general_ci NOT NULL,
  `code` int(5) NOT NULL,
  `ville` varchar(250) COLLATE latin1_general_ci NOT NULL,
  `date_n` date NOT NULL,
  `lieux_n` varchar(250) COLLATE latin1_general_ci NOT NULL,
  `num_secu` int(10) NOT NULL,
  `id_medecin` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_patient`),
  KEY `id_medecin` (`id_medecin`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`id_patient`, `civilite`, `nom`, `prenom`, `adresse`, `code`, `ville`, `date_n`, `lieux_n`, `num_secu`, `id_medecin`) VALUES
(9, 'H', 'Berretta', 'Baptisteu', '221 Avenue', 31200, 'Toulouse', '2002-09-09', 'Cannes', 1234567890, 5),
(10, 'F', 'Stacy', 'Gwen', '31 Avenue', 39600, 'New-York', '2012-12-20', 'New-York', 1234567899, 4),
(13, 'H', 'Raoult', 'Didier', '5 Bloc', 93200, 'Marseille', '1970-07-11', 'Marseille', 1234567790, 5),
(14, 'F', 'DUPONT', 'MAGALI', '5 RUE DES BLABLA', 31400, 'TOULOUSE', '2002-12-06', 'GRASSE', 1234567899, 5);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `consultation`
--
ALTER TABLE `consultation`
  ADD CONSTRAINT `consultation_ibfk_1` FOREIGN KEY (`id_patient`) REFERENCES `patient` (`id_patient`),
  ADD CONSTRAINT `consultation_ibfk_2` FOREIGN KEY (`id_medecin`) REFERENCES `medecin` (`id_medecin`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
