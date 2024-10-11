-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 08 oct. 2024 à 12:08
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion`
--

-- --------------------------------------------------------

--
-- Structure de la table `courriers`
--

CREATE TABLE `courriers` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `numero` varchar(255) NOT NULL,
  `annexe` varchar(255) DEFAULT NULL,
  `expediteur` varchar(255) DEFAULT NULL,
  `resume` text DEFAULT NULL,
  `observation` text NOT NULL,
  `fichier_pdf` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `courriers`
--

INSERT INTO `courriers` (`id`, `date`, `numero`, `annexe`, `expediteur`, `resume`, `observation`, `fichier_pdf`) VALUES
(1, '2024-10-07', '001', '2', 'D.G/INBTP', 'bonjour; bonjour , bonjour , bonjour , bonjour, bonjour ', 'COGE', '');

-- --------------------------------------------------------

--
-- Structure de la table `editor_permissions`
--

CREATE TABLE `editor_permissions` (
  `editor_id` int(11) NOT NULL,
  `courrier_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `editor_permissions`
--

INSERT INTO `editor_permissions` (`editor_id`, `courrier_id`) VALUES
(3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT 'viewer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `username`, `email`, `password`, `role`) VALUES
(1, 'kayeye', 'godetkayeye@gmail.com', '202cb962ac59075b964b07152d234b70', 'admin'),
(2, 'vale', 'vale@gmail.com', '202cb962ac59075b964b07152d234b70', 'viewer'),
(3, 'french', 'french@gmail.com', '202cb962ac59075b964b07152d234b70', 'editor');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `courriers`
--
ALTER TABLE `courriers`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `editor_permissions`
--
ALTER TABLE `editor_permissions`
  ADD PRIMARY KEY (`editor_id`,`courrier_id`),
  ADD KEY `courrier_id` (`courrier_id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `courriers`
--
ALTER TABLE `courriers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `editor_permissions`
--
ALTER TABLE `editor_permissions`
  ADD CONSTRAINT `editor_permissions_ibfk_1` FOREIGN KEY (`editor_id`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `editor_permissions_ibfk_2` FOREIGN KEY (`courrier_id`) REFERENCES `courriers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
