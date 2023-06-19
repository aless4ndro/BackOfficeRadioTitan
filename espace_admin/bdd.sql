CREATE TABLE membres
(
    id int(11) NOT NULL AUTO_INCREMENT,
    pseudo varchar(255) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table podcast
(
    id int NOT NULL AUTO_INCREMENT,
    title varchar(255) NOT NULL,
    file_path varchar(255) NOT NULL,
    rubrique VARCHAR(255),
    emission VARCHAR(255),
    intervue TEXT,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table albums
(
    id int NOT NULL AUTO_INCREMENT,
    title varchar(255) NOT NULL,
    file_path varchar(255) NOT NULL,
    date DATETIME,
    description varchar(255),
    code_color varchar(255),
    img_illustration varchar(255),
    PRIMARY KEY (file_path)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table categorie
(
    id_categorie INT PRIMARY KEY,
    nom_categorie VARCHAR(255) NOT NULL
    title varchar(255) NOT NULL,
    date DATETIME,
    description varchar(255),
    code_color varchar(255),
    img_illustration varchar(255),
    PRIMARY KEY (id_categorie)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table video
(
    id int NOT NULL AUTO_INCREMENT,
    fichier_video varchar(255) NOT NULL,
    titre varchar(255) NOT NULL,
    description varchar(255) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



insert into membres (pseudo) values ('Aless');
insert into membres (pseudo) values ('Benoit');

create TABLE articles
(
    id int(11) NOT NULL AUTO_INCREMENT,
    titre varchar(255) NOT NULL,
    contenu text NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

alter table categorie add id int(11) NOT NULL AUTO_INCREMENT;
alter table membres add email varchar(255) NOT NULL;
alter table membres add pass varchar(255) NOT NULL;
alter table membres add p varchar(255);
alter table membres drop role;
alter table membres add date_inscription datetime NOT NULL;

ALTER TABLE membres ADD COLUMN role ENUM('admin', 'contributeur', 'user') NOT NULL;


ALTER TABLE membres
DROP COLUMN comfirmation_pass;



create table articles
(
    id int(11) NOT NULL AUTO_INCREMENT,
    titre varchar(255) NOT NULL,
    contenu text NOT NULL,
    id int(11) NOT NULL AUTO_INCREMENT,
    id_categorie int(11),
    PRIMARY KEY (id),
    FOREIGN KEY (id_categorie) REFERENCES categorie(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table albums
(
    id int(11) NOT NULL AUTO_INCREMENT,
    title varchar(255) NOT NULL,
    file_path varchar(255) NOT NULL,
    date DATETIME,
    description varchar(255),
    code_color varchar(255),
    img_illustration varchar(255),
    id_categorie int(11),
    PRIMARY KEY (id),
    FOREIGN KEY (id_categorie) REFERENCES categorie(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table video
(
    fichier_video varchar(255) NOT NULL,
    titre varchar(255) NOT NULL,
    description varchar(255) NOT NULL,
    id_categorie int(11),
    PRIMARY KEY (fichier_video),
    FOREIGN KEY (id_categorie) REFERENCES categorie(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




ALTER TABLE articles
ADD COLUMN id_categorie INT;


ALTER TABLE articles
ADD FOREIGN KEY (id_categorie) REFERENCES categories(id_categorie);


-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : mysql
-- Généré le : lun. 19 juin 2023 à 19:53
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

CREATE TABLE `albums` (
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
(3, 'Soleil', 'upload_albums/64904a1bbf5849.93802464.mp3', '2023-06-19 00:00:00', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, ', '#cd2d2d', 'upload_images/64904a1bbfc469.56820130.png', 2);

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id` int NOT NULL,
  `titre` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `id_categorie` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `titre`, `contenu`, `id_categorie`) VALUES
(4, 'zorro le beu', 'fdqqd', 1),
(8, 'Chill', 'lemr uity roro lopus', 3),
(10, 'hello modif', '&lt;p&gt;&lt;span style=&quot;color: #001234; font-family: Mulish, sans-serif; font-size: 16px; background-color: #f5f7ff;&quot;&gt;CKEditor is a WYSIWYG HTML editor that can fit a wide range of use cases: from Word-like documents with large toolbars to simple toolbars with a limited set of features used for emails or instant messaging.&lt;/span&gt;&lt;/p&gt;', 3);

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
  ADD KEY `id_categorie` (`id_categorie`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_categorie`);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`id_categorie`) REFERENCES `categories` (`id_categorie`);

--
-- Contraintes pour la table `podcast`
--
ALTER TABLE `podcast`
  ADD CONSTRAINT `podcast_ibfk_1` FOREIGN KEY (`id_categorie`) REFERENCES `categories` (`id_categorie`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
