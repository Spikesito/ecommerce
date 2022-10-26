-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 25 oct. 2022 à 13:28
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `e commerce`
--

-- --------------------------------------------------------

--
-- Structure de la table `address`
--

DROP TABLE IF EXISTS `address`;
CREATE TABLE IF NOT EXISTS `address` (
  `AddressId` int(11) NOT NULL AUTO_INCREMENT,
  `AddressNumber` int(11) DEFAULT NULL,
  `AddressName` varchar(50) DEFAULT NULL,
  `ZipCode` varchar(50) DEFAULT NULL,
  `Region` varchar(50) DEFAULT NULL,
  `Country` varchar(50) DEFAULT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`AddressId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `card`
--

DROP TABLE IF EXISTS `card`;
CREATE TABLE IF NOT EXISTS `card` (
  `CustomerId` int(11) NOT NULL,
  `PaymentId` int(11) NOT NULL,
  `CardId` int(50) NOT NULL AUTO_INCREMENT,
  `CardOwner` varchar(50) DEFAULT NULL,
  `CardNumber` varchar(50) DEFAULT NULL,
  `ExpirationDate` varchar(50) DEFAULT NULL,
  `CVV` int(11) DEFAULT NULL,
  PRIMARY KEY (`CustomerId`,`PaymentId`,`CardId`),
  UNIQUE KEY `CustomerId` (`CustomerId`,`PaymentId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `CategoryId` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`CategoryId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `command`
--

DROP TABLE IF EXISTS `command`;
CREATE TABLE IF NOT EXISTS `command` (
  `CommandId` int(11) NOT NULL AUTO_INCREMENT,
  `CustomerId` int(11) NOT NULL,
  PRIMARY KEY (`CommandId`),
  KEY `CustomerId` (`CustomerId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `command_product`
--

DROP TABLE IF EXISTS `command_product`;
CREATE TABLE IF NOT EXISTS `command_product` (
  `ProductId` int(11) NOT NULL,
  `CommandId` int(11) NOT NULL,
  `Quantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`ProductId`,`CommandId`),
  KEY `CommandId` (`CommandId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `CustomerId` int(11) NOT NULL AUTO_INCREMENT,
  `LastName` varchar(50) DEFAULT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `PhoneNumber` varchar(50) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`CustomerId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `customer_address`
--

DROP TABLE IF EXISTS `customer_address`;
CREATE TABLE IF NOT EXISTS `customer_address` (
  `AddressId` int(11) NOT NULL,
  `CustomerId` int(11) NOT NULL,
  PRIMARY KEY (`AddressId`,`CustomerId`),
  KEY `CustomerId` (`CustomerId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
CREATE TABLE IF NOT EXISTS `invoices` (
  `InvoiceId` int(11) NOT NULL AUTO_INCREMENT,
  `CustomerId` int(11) DEFAULT NULL,
  `ProductId` int(11) DEFAULT NULL,
  `InvoiceDate` date DEFAULT NULL,
  `CommandNumber` varchar(50) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`InvoiceId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `payment`
--

DROP TABLE IF EXISTS `payment`;
CREATE TABLE IF NOT EXISTS `payment` (
  `CustomerId` int(11) NOT NULL,
  `PaymentId` int(11) NOT NULL AUTO_INCREMENT,
  `PaymentMethod` varchar(50) DEFAULT NULL,
  `PaymentAdress` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`PaymentId`),
  KEY `CustomerId` (`CustomerId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `photop`
--

DROP TABLE IF EXISTS `photop`;
CREATE TABLE IF NOT EXISTS `photop` (
  `ProductId` int(11) NOT NULL,
  `PhotoId` int(11) NOT NULL AUTO_INCREMENT,
  `Link` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ProductId`,`PhotoId`),
  UNIQUE KEY `ProductId` (`ProductId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `photou`
--

DROP TABLE IF EXISTS `photou`;
CREATE TABLE IF NOT EXISTS `photou` (
  `CustomerId` int(11) NOT NULL,
  `PhotoId` int(11) NOT NULL AUTO_INCREMENT,
  `Link` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`CustomerId`,`PhotoId`),
  UNIQUE KEY `CustomerId` (`CustomerId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `ProductId` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) DEFAULT NULL,
  `Price` decimal(15,2) DEFAULT NULL,
  `CreationDate` date DEFAULT NULL,
  `Supplier` varchar(50) DEFAULT NULL,
  `Stock` varchar(50) DEFAULT NULL,
  `CategoryId` int(11) NOT NULL,
  PRIMARY KEY (`ProductId`),
  KEY `CategoryId` (`CategoryId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `rate`
--

DROP TABLE IF EXISTS `rate`;
CREATE TABLE IF NOT EXISTS `rate` (
  `RateId` int(11) NOT NULL AUTO_INCREMENT,
  `Rate` varchar(50) DEFAULT NULL,
  `Text` varchar(250) DEFAULT NULL,
  `ProductId` int(11) NOT NULL,
  `CustomerId` int(11) NOT NULL,
  PRIMARY KEY (`RateId`),
  KEY `ProductId` (`ProductId`),
  KEY `CustomerId` (`CustomerId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
