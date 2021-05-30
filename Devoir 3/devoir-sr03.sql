-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2021 at 01:44 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `devoir-sr03`
--

-- --------------------------------------------------------

--
-- Table structure for table `connection_errors`
--

CREATE TABLE `connection_errors` (
  `ip` varchar(255) NOT NULL,
  `error_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id_msg` int(11) NOT NULL,
  `id_user_to` int(11) NOT NULL,
  `id_user_from` int(11) NOT NULL,
  `sujet_msg` varchar(100) NOT NULL,
  `corps_msg` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id_msg`, `id_user_to`, `id_user_from`, `sujet_msg`, `corps_msg`) VALUES
(1, 2, 1, 'Hello', 'Salut !'),
(2, 1, 2, 'Hello', 'Salut !'),
(21, 2, 1, '<script>alert(\"attaque XSS\");</script>', 'ATTACK XSS !'),
(22, 2, 1, 'hello', '<script>alert(\"attaque XSS\");</script>'),
(23, 2, 1, 'Hello', 'Hello'),
(24, 1, 1, 'Hello', 'Hello'),
(25, 1, 2, 'Hello', 'Hello'),
(26, 1, 2, 'Attack XSS ', '<script>alert(\"attaque XSS\");</script>'),
(28, 3, 1, 'Attack XSS', '<script>alert(\"attaque XSS\");</script>');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `login` varchar(10) NOT NULL,
  `mot_de_passe` varchar(512) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `numero_compte` varchar(20) NOT NULL,
  `profil_user` varchar(10) NOT NULL,
  `solde_compte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `login`, `mot_de_passe`, `nom`, `prenom`, `numero_compte`, `profil_user`, `solde_compte`) VALUES
(1, 'sxie', '$argon2i$v=19$m=1024,t=2,p=2$OWJza1dUdFhhZkd5ci4veA$+To75wTWp8rCF6Vv/I6JFsRDdW/aOSX6ArfrwhIZQg4', 'xie', 'sihan', '54342167579675853', 'EMPLOYE', 1838),
(2, 'user1', '$argon2i$v=19$m=1024,t=2,p=2$OWJza1dUdFhhZkd5ci4veA$+To75wTWp8rCF6Vv/I6JFsRDdW/aOSX6ArfrwhIZQg4', 'nom1', 'prenom1', '675217527221758', 'CLIENT', 4500),
(3, 'user2', '$argon2i$v=19$m=1024,t=2,p=2$OWJza1dUdFhhZkd5ci4veA$+To75wTWp8rCF6Vv/I6JFsRDdW/aOSX6ArfrwhIZQg4', 'nom2', 'prenom2', '463636434566767', 'CLIENT', 1000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `connection_errors`
--
ALTER TABLE `connection_errors`
  ADD PRIMARY KEY (`ip`,`error_date`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id_msg`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id_msg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
