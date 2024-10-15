-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 02, 2014 at 11:25 PM
-- Server version: 5.5.37-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `villes_tests`
--

-- --------------------------------------------------------

--
-- Table structure for table `villes_france_free`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `ville_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ville_departement` varchar(3) DEFAULT NULL,
  `ville_slug` varchar(255) DEFAULT NULL,
  `ville_nom` varchar(45) DEFAULT NULL,
  `ville_nom_simple` varchar(45) DEFAULT NULL,
  `ville_nom_reel` varchar(45) DEFAULT NULL,
  `ville_nom_soundex` varchar(20) DEFAULT NULL,
  `ville_nom_metaphone` varchar(22) DEFAULT NULL,
  `ville_code_postal` varchar(255) DEFAULT NULL,
  `ville_commune` varchar(3) DEFAULT NULL,
  `ville_code_commune` varchar(5) NOT NULL,
  `ville_arrondissement` smallint(3) unsigned DEFAULT NULL,
  `ville_canton` varchar(4) DEFAULT NULL,
  `ville_amdi` smallint(5) unsigned DEFAULT NULL,
  `ville_population_2010` mediumint(11) unsigned DEFAULT NULL,
  `ville_population_1999` mediumint(11) unsigned DEFAULT NULL,
  `ville_population_2012` mediumint(10) unsigned DEFAULT NULL COMMENT 'approximatif',
  `ville_densite_2010` int(11) DEFAULT NULL,
  `ville_surface` float DEFAULT NULL,
  `ville_longitude_deg` float DEFAULT NULL,
  `ville_latitude_deg` float DEFAULT NULL,
  `ville_longitude_grd` varchar(9) DEFAULT NULL,
  `ville_latitude_grd` varchar(8) DEFAULT NULL,
  `ville_longitude_dms` varchar(9) DEFAULT NULL,
  `ville_latitude_dms` varchar(8) DEFAULT NULL,
  `ville_zmin` mediumint(4) DEFAULT NULL,
  `ville_zmax` mediumint(4) DEFAULT NULL,
  PRIMARY KEY (`ville_id`),
  UNIQUE KEY `ville_code_commune_2` (`ville_code_commune`),
  UNIQUE KEY `ville_slug` (`ville_slug`),
  KEY `ville_departement` (`ville_departement`),
  KEY `ville_nom` (`ville_nom`),
  KEY `ville_nom_reel` (`ville_nom_reel`),
  KEY `ville_code_commune` (`ville_code_commune`),
  KEY `ville_code_postal` (`ville_code_postal`),
  KEY `ville_longitude_latitude_deg` (`ville_longitude_deg`,`ville_latitude_deg`),
  KEY `ville_nom_soundex` (`ville_nom_soundex`),
  KEY `ville_nom_metaphone` (`ville_nom_metaphone`),
  KEY `ville_population_2010` (`ville_population_2010`),
  KEY `ville_nom_simple` (`ville_nom_simple`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36831 ;

--
-- Dumping data for table `villes_france_free`
--

INSERT INTO `cities` (`ville_id`, `ville_departement`, `ville_slug`, `ville_nom`, `ville_nom_simple`, `ville_nom_reel`, `ville_nom_soundex`, `ville_nom_metaphone`, `ville_code_postal`, `ville_commune`, `ville_code_commune`, `ville_arrondissement`, `ville_canton`, `ville_amdi`, `ville_population_2010`, `ville_population_1999`, `ville_population_2012`, `ville_densite_2010`, `ville_surface`, `ville_longitude_deg`, `ville_latitude_deg`, `ville_longitude_grd`, `ville_latitude_grd`, `ville_longitude_dms`, `ville_latitude_dms`, `ville_zmin`, `ville_zmax`) VALUES
(1, '01', 'ozan', 'OZAN', 'ozan', 'Ozan', 'O250', 'OSN', '01190', '284', '01284', 2, '26', 6, 618, 469, 500, 93, 6.6, 4.91667, 46.3833, '2866', '51546', '+45456', '462330', 170, 205),
(2, '01', 'cormoranche-sur-saone', 'CORMORANCHE-SUR-SAONE', 'cormoranche sur saone', 'Cormoranche-sur-Saône', 'C65652625', 'KRMRNXSRSN', '01290', '123', '01123', 2, '27', 6, 1058, 903, 1000, 107, 9.85, 4.83333, 46.2333, '2772', '51379', '+44953', '461427', 168, 211),
(3, '01', 'plagne-01', 'PLAGNE', 'plagne', 'Plagne', 'P425', 'PLKN', '01130', '298', '01298', 4, '03', 6, 129, 83, 100, 20, 6.2, 5.73333, 46.1833, '3769', '51324', '+54342', '461131', 560, 922),
(4, '01', 'tossiat', 'TOSSIAT', 'tossiat', 'Tossiat', 'T230', 'TST', '01250', '422', '01422', 2, '25', 6, 1406, 1111, 1400, 138, 10.17, 5.31667, 46.1333, '3309', '51268', '+51854', '460828', 244, 501),
(5, '01', 'pouillat', 'POUILLAT', 'pouillat', 'Pouillat', 'P430', 'PLT', '01250', '309', '01309', 2, '33', 6, 88, 58, 100, 14, 6.23, 5.43333, 46.3333, '3435', '51475', '+52542', '461938', 333, 770),
(6, '01', 'torcieu', 'TORCIEU', 'torcieu', 'Torcieu', 'T620', 'TRS', '01230', '421', '01421', 1, '28', 6, 698, 643, 700, 65, 10.72, 5.4, 45.9167, '3398', '51025', '+52343', '455521', 257, 782),
(7, '01', 'replonges', 'REPLONGES', 'replonges', 'Replonges', 'R1452', 'RPLNJS', '01620', '320', '01320', 2, '02', 6, 3500, 2841, 3300, 210, 16.6, 4.88333, 46.3, '2833', '51456', '+45310', '461837', 169, 207),
(8, '01', 'corcelles', 'CORCELLES', 'corcelles', 'Corcelles', 'C6242', 'KRSLS', '01110', '119', '01119', 4, '06', 6, 243, 222, 200, 17, 14.16, 5.58333, 46.0333, '3597', '51151', '+53428', '460208', 780, 1081),
(9, '01', 'peron', 'PERON', 'peron', 'Péron', 'P650', 'PRN', '01630', '288', '01288', 3, '12', 6, 2143, 1578, 1900, 82, 26.01, 5.93333, 46.2, '3989', '51322', '+55535', '461124', 411, 1501),
(10, '01', 'relevant', 'RELEVANT', 'relevant', 'Relevant', 'R4153', 'RLFNT', '01990', '319', '01319', 2, '30', 6, 466, 367, 400, 37, 12.38, 4.95, 46.0833, '2903', '51211', '+45658', '460525', 235, 282),
(11, '01', 'chaveyriat', 'CHAVEYRIAT', 'chaveyriat', 'Chaveyriat', 'C163', 'XFRT', '01660', '096', '01096', 2, '10', 6, 927, 810, 900, 54, 16.87, 5.06667, 46.1833, '3026', '51331', '+50338', '461152', 188, 260),
(12, '01', 'vaux-en-bugey', 'VAUX-EN-BUGEY', 'vaux en bugey', 'Vaux-en-Bugey', 'V2512', 'FKSNBJ', '01150', '431', '01431', 1, '17', 6, 1169, 1003, 1100, 142, 8.22, 5.35, 45.9167, '3352', '51031', '+52113', '455541', 252, 681),
(13, '01', 'maillat', 'MAILLAT', 'maillat', 'Maillat', 'M430', 'MLT', '01430', '228', '01228', 4, '22', 6, 668, 664, 700, 59, 11.31, 5.55, 46.1333, '3557', '51255', '+53217', '460745', 497, 825),
(14, '01', 'faramans-01', 'FARAMANS', 'faramans', 'Faramans', 'F652', 'FRMNS', '01800', '156', '01156', 2, '19', 6, 681, 591, 600, 60, 11.22, 5.11667, 45.9, '3099', '51002', '+50732', '455407', 255, 306),
(15, '01', 'beon-01', 'BEON', 'beon', 'Béon', 'B500', 'BN', '01350', '039', '01039', 1, '09', 6, 373, 364, 400, 36, 10.3, 5.75, 45.8333, '3798', '50950', '+54519', '455117', 228, 1412);


