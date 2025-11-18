-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 18 nov. 2025 à 00:57
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bibliotheque_jp_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `lecteurs`
--

CREATE TABLE `lecteurs` (
  `id` int(11) NOT NULL,
  `nom` text NOT NULL,
  `prenom` text NOT NULL,
  `email` text NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `lecteurs`
--

INSERT INTO `lecteurs` (`id`, `nom`, `prenom`, `email`, `mot_de_passe`) VALUES
(1, 'Dupont\r\n', 'Marie', 'dupontmarie48@gmail.com', '$2y$10$6QvlPSO66f3Jxp8xMKVlnet2vzTyGG61L/NxtsAFgHhUFuqX8Ridi'),
(2, 'Laurent', 'Thomas', 'l.thomas48@gmail.com', '$2y$10$6QvlPSO66f3Jxp8xMKVlnet2vzTyGG61L/NxtsAFgHhUFuqX8Ridi'),
(3, 'Bernard', 'Sophie', 'bernards.48@gmail.com', '$2y$10$6QvlPSO66f3Jxp8xMKVlnet2vzTyGG61L/NxtsAFgHhUFuqX8Ridi'),
(4, 'Petit', 'Julien', 'p.julien48@gmail.com', '$2y$10$6QvlPSO66f3Jxp8xMKVlnet2vzTyGG61L/NxtsAFgHhUFuqX8Ridi'),
(5, 'Roux', 'Camille', 'rouxcamille48@gmail.com', '$2y$10$6QvlPSO66f3Jxp8xMKVlnet2vzTyGG61L/NxtsAFgHhUFuqX8Ridi'),
(6, 'Jean Foucant', '', 'jjeanfoucant48@gmail.com', '$2y$10$oPsYRO60VK4wtaREZBPTEOkiAwMYq/v2b/.Tnn0jkCC4iSPbldfnu'),
(7, 'Alexandre', '', 'alexisdumas48@gmail.com', '$2y$10$gRSfOjhLkpeTXTRwgWVS4e1yCFxwhOdV4jM510qN5E2B5n5.g5mLm'),
(8, 'Saint', 'Thomas', 'sainthomas48@gmail.com', '$2y$10$PS1Y8RvNkD4M.5hm5Ab/Bu1C8GXe2PsxQ91fZy51Y9KHDZG46pwDm');

-- --------------------------------------------------------

--
-- Structure de la table `liste_lecture`
--

CREATE TABLE `liste_lecture` (
  `id_livre` int(11) NOT NULL,
  `id_lecteur` int(11) NOT NULL,
  `date_emprunt` date NOT NULL,
  `date_retour` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `liste_lecture`
--

INSERT INTO `liste_lecture` (`id_livre`, `id_lecteur`, `date_emprunt`, `date_retour`) VALUES
(1, 1, '0000-00-00', '0000-00-00'),
(2, 1, '0000-00-00', '0000-00-00'),
(4, 1, '0000-00-00', '0000-00-00'),
(11, 1, '0000-00-00', '0000-00-00'),
(11, 2, '0000-00-00', '0000-00-00'),
(1, 7, '0000-00-00', '0000-00-00'),
(4, 8, '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Structure de la table `livres`
--

CREATE TABLE `livres` (
  `id` int(11) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `auteur` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `maison_edition` varchar(100) NOT NULL,
  `nombre_exemplaire` int(11) NOT NULL,
  `image` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `livres`
--

INSERT INTO `livres` (`id`, `titre`, `auteur`, `description`, `maison_edition`, `nombre_exemplaire`, `image`) VALUES
(1, '1984', 'George Orwell', 'Paru en 1949, Roman dystopique majeur du XXᵉ siècle, 1984 explore un monde totalitaire où la surveillance et la manipulation du langage contrôlent la pensée humaine. Œuvre visionnaire, elle dénonce la perte de liberté individuelle face au pouvoir absolu.', 'Secker & Warburg', 10, 'livre1.jpeg'),
(2, 'Les Misérables', 'Victor Hugo', 'Chef-d’œuvre du romantisme français(1862), ce roman retrace la rédemption de Jean Valjean dans une société marquée par l’injustice sociale. À travers ses personnages, Hugo peint un tableau poignant de la misère, de la morale et de l’espérance.', 'A. Lacroix, Verboeckhoven & Cie', 10, 'livre2.jpeg'),
(3, 'The Catcher in the Rye (L’Attrape-cœurs)', 'J.D. Salinger', 'Ce roman culte paru en 1951 suit Holden Caulfield, un adolescent en crise, errant dans New York après avoir été renvoyé de son école. Symbole du mal-être adolescent, il critique la superficialité du monde adulte.', 'Little, Brown and Company', 8, 'livre3.jpeg'),
(4, 'Cent ans de solitude', 'Gabriel García Márquez', 'Paru en 1967, c\'est un fresque magique et poétique sur la famille Buendía et le village mythique de Macondo, ce roman incarne le réalisme magique latino-américain. Il mêle histoire, politique et légende avec une puissance narrative inégalée.', 'Editorial Sudamericana', 12, 'livre4.jpeg'),
(5, 'La Passe-miroir', 'Christelle Dabos', 'Premier tomme d\'une saga fantastique, ce roman suit Ophélie, une jeune fille dotée du don de lire le passé des objets, dans un monde divisé en arches flotantes. Entre intrigues politique et aventures, le récit mêle magie et réflexion sur l\'identité', 'Gallimard Jeunesse', 25, 'livre5.jpeg'),
(6, 'Harry Potter à l’école des sorciers', 'J.K. Rowling', '1997, Premier tome de la saga mondiale, ce roman introduit le jeune sorcier Harry Potter et son entrée à Poudlard. Mélange de magie, d’amitié et de courage, il a marqué toute une génération.', 'Bloomsbury Publishing', 12, 'livre6.jpeg'),
(7, 'La Terre des hommes', 'Antoine de Saint-Exupéry', '2005, Mêlant récit autobiographique et méditation philosophique, Saint-Exupéry y célèbre le courage, la solidarité et la beauté du monde à travers ses expériences d’aviateur. C’est une ode à la fraternité humaine.', 'Gallimard', 7, 'livre7.jpeg'),
(8, 'L’homme qui voulait être heureux', 'Laurent Gounelle', 'Dans ce roman initiatique (2012), un homme en voyage à Bali rencontre un sage qui bouleverse sa vision de la vie. À travers un dialogue simple et profond, Gounelle invite à la découverte de soi et au bonheur intérieur.', 'Éditions Pocket', 6, 'livre8.jpeg'),
(9, 'American Gods', 'Neil Gaiman', 'Paru en 2000, cet ouvrage mélange de mythologie, fantastique et critique sociale, ce roman suit Shadow Moon dans un monde où les anciens dieux affrontent les nouveaux — ceux de la technologie et des médias. Une réflexion captivante sur la croyance et la modernité.', 'William Morrow', 15, 'livre9.jpeg'),
(10, 'Things Fall Apart (Le monde s’effondre)', 'Chinua Achebe', 'Ce roman africain fondateur de 1958 raconte la chute d’un chef igbo face à la colonisation britannique. Achebe y dépeint avec justesse le choc entre traditions et modernité, ainsi que les drames culturels de l’Afrique coloniale.', 'William Heinemann Ltd', 13, 'livre10.jpeg'),
(11, 'Sapiens : Une brève histoire de l’humanité', 'Yuval Noah Harari', 'Essai percutant de 2019 sur l’évolution de l’humanité, de l’âge de pierre à l’ère numérique. Harari analyse comment la biologie, la culture et les idéologies ont façonné nos sociétés, offrant une vision globale et éclairante de notre espèce.', 'Albin Michel', 10, 'livre11.jpeg'),
(12, 'L\'Etranger', 'Albert Camus', 'Ce roman philosophique raconte l\'histoire de meursault, un homme détaché de la société et confronté à l\'absurdité de la vie et de la mort , explorant les thèmes de l\'absurde et de l\'existentialiste.', 'Gallimard', 15, 'livre12.jpeg'),
(13, 'La Horde du Contrevent', 'Alain Damasio', 'Ce roman de Sciences Fiction raconte l\'épopée d\'une horde de vingt trois personnes dui lutte contre des vents incessants dans un monde hostile. Le récit explore la solidarité, la résistance et la quête e sens dans un univers poétique et inventif.', 'La Volte', 20, 'livre13.jpeg'),
(14, 'La vie de Rouzard', 'Olson P. Rouzard', 'dans ce livre, l\'auteur raconte les aventure de son frère Tchelson Rouzard, jeune haïtien qui lutte pour sa survie dans un pays déchiré par la guerre, le chaos géopolitique et toutes sortes de derives sociopolitiques.', 'Le Piman', 21, 'livre14.jpeg'),
(15, 'L\'Etranger', 'Albert Camus', 'Ce roman philosophique raconte l\'histoire de Meursault, un homme détaché de la société et confronté à l\'absurdité de la vie et de la mort, explorant les thèmes de l\'absurde et de l\'existentialisme.', 'Gallimard', 14, 'livre15.jpeg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `lecteurs`
--
ALTER TABLE `lecteurs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `liste_lecture`
--
ALTER TABLE `liste_lecture`
  ADD PRIMARY KEY (`id_lecteur`,`id_livre`),
  ADD KEY `fk_id_livre` (`id_livre`),
  ADD KEY `fk_id_lecteur` (`id_lecteur`);

--
-- Index pour la table `livres`
--
ALTER TABLE `livres`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `lecteurs`
--
ALTER TABLE `lecteurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `liste_lecture`
--
ALTER TABLE `liste_lecture`
  MODIFY `id_livre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `livres`
--
ALTER TABLE `livres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `liste_lecture`
--
ALTER TABLE `liste_lecture`
  ADD CONSTRAINT `fk_liste_lecteurs` FOREIGN KEY (`id_lecteur`) REFERENCES `lecteurs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_liste_livre` FOREIGN KEY (`id_livre`) REFERENCES `livres` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
