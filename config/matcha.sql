-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Jeu 07 Septembre 2017 à 16:17
-- Version du serveur :  5.7.11
-- Version de PHP :  7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `matcha`
--

-- --------------------------------------------------------

--
-- Structure de la table `Images`
--

CREATE TABLE `Images` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `img1` varchar(255) DEFAULT 'NULL',
  `img2` varchar(255) DEFAULT 'NULL',
  `img3` varchar(255) DEFAULT 'NULL',
  `img4` varchar(255) DEFAULT 'NULL',
  `img5` varchar(255) DEFAULT 'NULL',
  `img_profil` varchar(255) DEFAULT 'NULL'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Images`
--

INSERT INTO `Images` (`id`, `pseudo`, `img1`, `img2`, `img3`, `img4`, `img5`, `img_profil`) VALUES
(1, 'Rick', 'Rick/pic_1.png', 'NULL', 'NULL', 'NULL', 'NULL', 'Rick/pic_1.png'),
(2, 'Helaman', 'Helaman/pic_1.png', 'Helaman/pic_2.png', 'Helaman/pic_3.png', 'Helaman/pic_4.png', 'Helaman/pic_5.png', 'Helaman/pic_1.png'),
(3, 'Sachou', 'Sachou/pic_1.png', 'NULL', 'NULL', 'NULL', 'NULL', 'Sachou/pic_1.png'),
(4, 'Bob', 'Bob/pic_1.png', 'NULL', 'NULL', 'NULL', 'NULL', 'Bob/pic_1.png'),
(8, 'Billy', 'Billy/pic_1.png', 'NULL', 'NULL', 'NULL', 'NULL', 'Billy/pic_1.png'),
(15, 'Philo', 'Philo/pic_1.png', 'NULL', 'NULL', 'NULL', 'NULL', 'Philo/pic_1.png'),
(16, 'Elo95', 'Elo95/pic_1.png', 'NULL', 'NULL', 'NULL', 'NULL', 'Elo95/pic_1.png'),
(17, 'Juju', 'Juju/pic_1.png', 'NULL', 'NULL', 'NULL', 'NULL', 'Juju/pic_1.png'),
(18, 'Lucy', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL'),
(19, 'Lola', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL'),
(20, 'Brucey62', 'Brucey62/pic_1.png', 'NULL', 'NULL', 'NULL', 'NULL', 'Brucey62/pic_1.png');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `sexe` tinyint(4) DEFAULT '0',
  `orientation` tinyint(4) NOT NULL DEFAULT '0',
  `hobby` varchar(50) DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `email`, `password`, `nom`, `prenom`, `date_naissance`, `sexe`, `orientation`, `hobby`, `latitude`, `longitude`, `created_at`, `updated_at`) VALUES
(1, 'Helaman', 'helaman@gmail.com', '59ebeec764fc0e33302d484b9ef5bc76f645618216d5f951b45debf9499703c536732e00e1d2b1ff5ddf71caf214b08bcfc36728511adb8555fcd7a2ad50143e', 'Brozzu', 'JÃ©rÃ©mie', '1989-05-17', 1, 1, '#cinÃ©ma #chocolat #mode', 48.9816923734087, 1.706430176998083, '2016-10-11 13:45:39', '2016-10-11 13:45:39'),
(2, 'Lola', 'lola@gmail.com', '59ebeec764fc0e33302d484b9ef5bc76f645618216d5f951b45debf9499703c536732e00e1d2b1ff5ddf71caf214b08bcfc36728511adb8555fcd7a2ad50143e', 'Nelson', 'Liliane', NULL, 0, 0, NULL, 48.99135919100202, 1.7059581082114619, '2016-11-08 21:11:38', '0000-00-00 00:00:00'),
(3, 'Bob', 'bob@gmail.com', '59ebeec764fc0e33302d484b9ef5bc76f645618216d5f951b45debf9499703c536732e00e1d2b1ff5ddf71caf214b08bcfc36728511adb8555fcd7a2ad50143e', 'Boucher', 'Robert', '1979-11-21', 0, 0, NULL, 48.99135919100202, 1.7059581082114619, '2016-11-23 11:40:12', '0000-00-00 00:00:00'),
(4, 'Lucy', 'lulu@gmail.com', '59ebeec764fc0e33302d484b9ef5bc76f645618216d5f951b45debf9499703c536732e00e1d2b1ff5ddf71caf214b08bcfc36728511adb8555fcd7a2ad50143e', 'Boulet', 'Lucinda', '1998-09-27', 2, 1, NULL, 48.99130793152949, 1.7058902740477606, '2016-11-23 15:09:14', '0000-00-00 00:00:00'),
(8, 'Billy', 'billy@coucou.com', '59ebeec764fc0e33302d484b9ef5bc76f645618216d5f951b45debf9499703c536732e00e1d2b1ff5ddf71caf214b08bcfc36728511adb8555fcd7a2ad50143e', 'McCoyle', 'Bill', NULL, 0, 0, NULL, 48.967, 1.85, '2016-12-21 16:21:23', '0000-00-00 00:00:00'),
(9, 'Rick', 'eric@hotmail.com', '59ebeec764fc0e33302d484b9ef5bc76f645618216d5f951b45debf9499703c536732e00e1d2b1ff5ddf71caf214b08bcfc36728511adb8555fcd7a2ad50143e', 'Adams', 'Eric', NULL, 1, 1, '', 49.02196463868809, 2.0477539062500227, '2017-01-10 17:38:58', '0000-00-00 00:00:00'),
(10, 'Sachou', 'sacha@gmail.com', '59ebeec764fc0e33302d484b9ef5bc76f645618216d5f951b45debf9499703c536732e00e1d2b1ff5ddf71caf214b08bcfc36728511adb8555fcd7a2ad50143e', 'Ricio', 'Sacha', '2000-10-11', 2, 1, '#hiphop', 48.967, 1.85, '2017-01-11 17:05:43', '0000-00-00 00:00:00'),
(11, 'Philo', 'placheau@gmail.com', '59ebeec764fc0e33302d484b9ef5bc76f645618216d5f951b45debf9499703c536732e00e1d2b1ff5ddf71caf214b08bcfc36728511adb8555fcd7a2ad50143e', 'Lacheau', 'Philippe', '1960-08-10', 0, 0, NULL, 48.967, 1.85, '2017-02-15 11:09:49', '0000-00-00 00:00:00'),
(12, 'Elo95', 'efontan@gmail.com', '59ebeec764fc0e33302d484b9ef5bc76f645618216d5f951b45debf9499703c536732e00e1d2b1ff5ddf71caf214b08bcfc36728511adb8555fcd7a2ad50143e', 'Fontan', 'Elodie', '1975-03-13', 0, 0, NULL, 48.967, 1.85, '2017-02-15 12:10:12', '0000-00-00 00:00:00'),
(13, 'Juju', 'jarruti@gmail.com', '59ebeec764fc0e33302d484b9ef5bc76f645618216d5f951b45debf9499703c536732e00e1d2b1ff5ddf71caf214b08bcfc36728511adb8555fcd7a2ad50143e', 'Arruti', 'Julien', '1944-02-23', 0, 0, NULL, 48.967, 1.85, '2017-02-15 12:20:12', '0000-00-00 00:00:00'),
(14, 'Brucey62', 'bruce62@gmail.com', '59ebeec764fc0e33302d484b9ef5bc76f645618216d5f951b45debf9499703c536732e00e1d2b1ff5ddf71caf214b08bcfc36728511adb8555fcd7a2ad50143e', 'Guacamole', 'Bruce', '1963-05-18', 1, 1, '#limonade #trampoline', 48.98527035462768, 1.8078231887817537, '2017-04-02 15:25:49', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `visite`
--

CREATE TABLE `visite` (
  `user_id` int(11) NOT NULL,
  `user_visit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `visite`
--

INSERT INTO `visite` (`user_id`, `user_visit`) VALUES
(1, 13),
(1, 4),
(1, 14),
(1, 3),
(1, 9);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `Images`
--
ALTER TABLE `Images`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `Images`
--
ALTER TABLE `Images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
