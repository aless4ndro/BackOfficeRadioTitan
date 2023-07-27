-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : mysql
-- Généré le : sam. 01 juil. 2023 à 13:30
-- Version du serveur : 8.0.33
-- Version de PHP : 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `espace_admin_altameos`
--

-- --------------------------------------------------------

--
-- Structure de la table `albums`
--

CREATE TABLE `audio` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `date` datetime DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `code_color` varchar(255) DEFAULT NULL,
  `img_illustration` varchar(255) DEFAULT NULL,
  `id_categorie` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `albums`
--

INSERT INTO `albums` (`id`, `title`, `file_path`, `date`, `description`, `code_color`, `img_illustration`, `id_categorie`) VALUES
(4, 'Titan', 'upload_albums/6491aed15a3b22.34141841.mp3', '2023-06-20 00:00:00', 'Lorem ipsum doler sit', '#df3030', 'upload_images/6491aed15a68e2.99858735.png', 2);

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id` int NOT NULL,
  `titre` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `id_categorie` int DEFAULT NULL,
  `is_approved` int NOT NULL DEFAULT '0',
  `id_membre` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `titre`, `contenu`, `id_categorie`, `is_approved`, `id_membre`) VALUES
(35, 'Plage', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam et ultricies ante. Morbi placerat nunc at tortor elementum, eu blandit lorem tempor. Mauris interdum mattis massa quis tristique. Sed sollicitudin eleifend dui et consequat. Sed elementum at neque at rutrum. Nullam quis enim volutpat, pharetra quam sed, porta metus. Ut lacus magna, commodo quis eleifend finibus, gravida id urna. Suspendisse nec nibh turpis. Aliquam erat volutpat. Suspendisse libero nisi, facilisis ullamcorper mollis in, ornare sit amet justo. Mauris at nisi et neque condimentum gravida non eget tortor. Quisque posuere vitae erat vel rutrum. Cras elementum augue sed massa vestibulum, rhoncus imperdiet felis blandit. Suspendisse ornare dui nec ante convallis pretium.', 1, 1, 39),
(47, 'faucibus magna.', 'Etiam molestie elit euismod pharetra convallis. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Ut et sapien imperdiet libero iaculis elementum id a arcu. Nullam vel leo egestas, tristique neque in, faucibus magna.\r\n\r\n \r\n', 1, 1, 39),
(50, 'Aliquam facilisis', 'Mauris viverra nunc eget nulla congue maximus. Proin ut metus risus. Sed quam massa, auctor ac molestie vel, dapibus id odio. Curabitur venenatis cursus sollicitudin. Mauris accumsan ultricies suscipit. In et tincidunt enim. Quisque massa arcu, sollicitudin ut nisl ac, fringilla gravida mi. Suspendisse mattis ac elit at maximus. Suspendisse bibendum non sem eget pretium.', 1, 1, 39),
(51, 'Lorem ipsum', 'dolor sit amet, consectetur adipiscing elit. Aliquam facilisis blandit urna congue interdum. Cras ut ex laoreet, mattis ligula a, mollis dui. Suspendisse consectetur rhoncus erat, non sodales nisi aliquam sit amet. In a ligula vel erat aliquet tempus. Curabitur at volutpat tellus. Nulla facilisi. Maecenas a lorem non massa venenatis fermentum quis nec nulla. Suspendisse egestas dui vitae nulla accumsan, et elementum urna consectetur. Sed luctus massa eu felis volutpat, eget lacinia mi rhoncus.', 1, 1, 39),
(52, 'Donec consectetur', 'luctus arcu. Sed cursus elementum ipsum, nec accumsan nisl tincidunt ac. Phasellus vel lacinia ipsum. Ut sed elementum nibh. In molestie tincidunt augue, hendrerit viverra arcu ultrices a. Proin tempus, libero quis blandit pellentesque, urna nisl venenatis magna, fringilla tempus felis leo eget magna. Nullam enim nulla, elementum non lectus sed, gravida aliquam justo. Nullam aliquam suscipit nunc, vel viverra velit. Praesent eget ex arcu.', 1, 0, 39);

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id_categorie` int NOT NULL,
  `nom_categorie` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id_categorie`, `nom_categorie`) VALUES
(1, 'Article'),
(2, 'Album'),
(3, 'Podcast'),
(4, 'Video');

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

CREATE TABLE `events` (
  `id` int NOT NULL,
  `titre` varchar(255) NOT NULL,
  `contenu` text,
  `heure` time NOT NULL,
  `date` date DEFAULT NULL,
  `id_categorie` int DEFAULT NULL,
  `id_membre` int DEFAULT NULL,
  `eventNumber` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `events`
--

INSERT INTO `events` (`id`, `titre`, `contenu`, `heure`, `date`, `id_categorie`, `id_membre`, `eventNumber`) VALUES
(4, 'hello', 'Various versions have evolved over the years, sometimes, Various versions have evolved over the years', '17:30:00', '1970-01-01', 1, 21, 4),
(5, 'iekolo', 'fsqesfsf', '16:21:00', '1970-01-01', 1, 21, 5),
(7, 'zorro le beu', 'gh;hjlk!llm', '21:25:00', '2023-07-28', 1, 21, 7);

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

CREATE TABLE `membres` (
  `id` int NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `role` enum('admin','contributeur','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `membres`
--

INSERT INTO `membres` (`id`, `pseudo`, `email`, `pass`, `role`) VALUES
(21, 'Aless333', 'kiki@live.fr', '$2y$10$fk0rpT2g5ug1IBz2VJJDTeFUVgGoM4kNfdo/L8XEptU/inTuTGPuO', 'admin'),
(38, 'Aless000', 'roro@live.fr', '$2y$10$dDnW.NJ94FbGnkuQtv.UvO0BcDEZfaomf5qPCeLTUeWrdgmR.9Gim', 'contributeur'),
(39, 'Aless222', 'nono@live.fr', '$2y$10$IDOXWiyBflzTGpHtGS647u.kwRiiZ/NT5evYK/X8lf6Lm48LmCTQG', 'contributeur');

-- --------------------------------------------------------

--
-- Structure de la table `podcast`
--

CREATE TABLE `podcast` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `rubrique` varchar(255) DEFAULT NULL,
  `emission` varchar(255) DEFAULT NULL,
  `intervue` text,
  `id_categorie` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `podcast`
--

INSERT INTO `podcast` (`id`, `title`, `file_path`, `rubrique`, `emission`, `intervue`, `id_categorie`) VALUES
(2, 'Chill&Hill', 'uploads/64900eb20bd722.91771519.mp3', 'Fun', 'TF1', 't is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed ', 3);

-- --------------------------------------------------------

--
-- Structure de la table `video`
--

CREATE TABLE `video` (
  `id` int NOT NULL,
  `fichier_video` varchar(255) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categorie` (`id_categorie`);

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categorie` (`id_categorie`),
  ADD KEY `id_membre` (`id_membre`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Index pour la table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_membre` (`id_membre`,`eventNumber`),
  ADD KEY `id_categorie` (`id_categorie`);

--
-- Index pour la table `membres`
--
ALTER TABLE `membres`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `podcast`
--
ALTER TABLE `podcast`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categorie` (`id_categorie`);

--
-- Index pour la table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `albums`
--
ALTER TABLE `albums`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT pour la table `events`
--
ALTER TABLE `events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `membres`
--
ALTER TABLE `membres`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT pour la table `podcast`
--
ALTER TABLE `podcast`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `video`
--
ALTER TABLE `video`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `albums`
--
ALTER TABLE `albums`
  ADD CONSTRAINT `albums_ibfk_1` FOREIGN KEY (`id_categorie`) REFERENCES `categories` (`id_categorie`);

--
-- Contraintes pour la table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`id_categorie`) REFERENCES `categories` (`id_categorie`),
  ADD CONSTRAINT `articles_ibfk_2` FOREIGN KEY (`id_membre`) REFERENCES `membres` (`id`);

--
-- Contraintes pour la table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`id_categorie`) REFERENCES `categories` (`id_categorie`),
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`id_membre`) REFERENCES `membres` (`id`);

--
-- Contraintes pour la table `podcast`
--
ALTER TABLE `podcast`
  ADD CONSTRAINT `podcast_ibfk_1` FOREIGN KEY (`id_categorie`) REFERENCES `categories` (`id_categorie`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
