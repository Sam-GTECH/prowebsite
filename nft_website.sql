-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Lun 12 Juin 2023 à 01:33
-- Version du serveur :  5.7.11
-- Version de PHP :  5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `nft_website`
--
CREATE DATABASE IF NOT EXISTS `nft_website` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `nft_website`;

-- --------------------------------------------------------

--
-- Structure de la table `auctions`
--

CREATE TABLE `auctions` (
  `id` int(11) NOT NULL,
  `nft_id` int(11) NOT NULL,
  `price` decimal(10,2) UNSIGNED NOT NULL,
  `ongoing` tinyint(1) NOT NULL,
  `enddate` datetime NOT NULL,
  `isMainShown` tinyint(1) NOT NULL DEFAULT '0',
  `isWeeklyShown` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `auctions`
--

INSERT INTO `auctions` (`id`, `nft_id`, `price`, `ongoing`, `enddate`, `isMainShown`, `isWeeklyShown`) VALUES
(1, 1, '0.24', 1, '2023-06-16 00:00:00', 1, 0),
(2, 6, '490.00', 1, '2023-06-16 01:00:59', 0, 1),
(3, 7, '490.00', 1, '2023-06-16 00:00:00', 0, 1),
(4, 14, '490.00', 1, '2023-06-15 18:00:00', 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `auction_id` int(11) DEFAULT NULL,
  `nft_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `comments`
--

INSERT INTO `comments` (`id`, `auction_id`, `nft_id`, `user_id`, `comment`) VALUES
(1, NULL, 5, 1, 'Test comment. It would have displayed in the comments of the NFT Kitsune Mask if the appropriate page was done'),
(2, 1, NULL, 1, 'Test comment. It would have displayed in the comments of the auction of the NFT Cool Glasses if the appropriate page was done');

-- --------------------------------------------------------

--
-- Structure de la table `newsletter`
--

CREATE TABLE `newsletter` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `newsletter`
--

INSERT INTO `newsletter` (`id`, `user_id`, `email`) VALUES
(1, 1, 'testuser@nftmarketplace.com'),
(2, NULL, 'pirate@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `nfts`
--

CREATE TABLE `nfts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` tinytext NOT NULL,
  `description` text NOT NULL,
  `path` tinytext NOT NULL,
  `creation_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `nfts`
--

INSERT INTO `nfts` (`id`, `user_id`, `name`, `description`, `path`, `creation_date`) VALUES
(1, 2, 'Cool Glasses', 'Placeholder Description 1', 'BigNFT', '2023-06-05 08:00:00'),
(2, 2, 'As Seen On Machine', 'Placeholder Description 11', 'contactNFT_1', '2023-06-05 08:00:00'),
(3, 2, 'Cyber Warrior', 'Placeholder Description 111', 'contactNFT_2', '2023-06-05 08:00:00'),
(4, 2, 'AI Went To Far Man', 'Placeholder Description 1111', 'createNFT_1', '2023-06-05 08:00:00'),
(5, 2, 'Kitsune Mask', 'Placeholder Description 11111', 'createNFT_2', '2023-06-05 08:00:00'),
(6, 2, 'Cyberpunk Cocomo', 'Placeholder Description 111111', 'galleryNFT1', '2023-06-05 08:00:00'),
(7, 2, 'Charge, Qi tiao yu', 'Placeholder Description 1111111', 'galleryNFT2', '2023-06-05 08:00:00'),
(8, 4, 'Candy Man', 'Placeholder Description 11111111', 'popularNFT_1', '2023-06-05 08:00:00'),
(9, 5, 'Valorant Team', 'Placeholder Description 1111111111', 'popularNFT_2', '2023-06-05 08:00:00'),
(10, 6, 'Flying A Drone', 'Placeholder Description 11111111111', 'popularNFT_3', '2023-06-05 08:00:00'),
(11, 7, 'Mission Eliminate', 'Placeholder Description 111111111111', 'popularNFT_4', '2023-06-05 08:00:00'),
(13, 8, 'Dragon Robot', 'Placeholder Description 1111111111111', 'popularNFT_5', '2023-06-05 08:00:00'),
(14, 2, 'Surgeon, Josh Rife', 'Placeholder Description 11111111111111', 'galleryNFT3', '2023-06-05 08:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `avatar` tinytext NOT NULL,
  `firstname` tinytext NOT NULL,
  `lastname` tinytext NOT NULL,
  `email` tinytext NOT NULL,
  `password` text NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `avatar`, `firstname`, `lastname`, `email`, `password`, `admin`) VALUES
(1, 'default', 'Test', 'User', 'testuser@nftmarketplace.com', '2a6f3c0e19ddd72eaa9bdf6ec628e2f0132d1306', 0),
(2, 'default', 'John', 'Doe', 'johndoe@unknown.com', '2a6f3c0e19ddd72eaa9bdf6ec628e2f0132d1306', 0),
(3, 'admin', 'Admin', 'User', 'admin@nftmarketplace.com', '412b50fd70aa90378eea5cf39ac612f96a4a61d4', 1),
(4, 'popularAuthor_1', 'Osvaldo', 'Percy', 'osvaldo.percy@gmail.com', '2a6f3c0e19ddd72eaa9bdf6ec628e2f0132d1306', 0),
(5, 'popularAuthor_2', 'Ranson', 'Sqiure', 'squire.ranson@gmail.com', '2a6f3c0e19ddd72eaa9bdf6ec628e2f0132d1306', 0),
(6, 'popularAuthor_3', 'Sebastian', 'waltan', 'sebastian.waltan0@hotmail.fr', '2a6f3c0e19ddd72eaa9bdf6ec628e2f0132d1306', 0),
(7, 'popularAuthor_4', 'Abraham', 'Zack', 'zack.albraham@overdose.ame', '2a6f3c0e19ddd72eaa9bdf6ec628e2f0132d1306', 0),
(8, 'popularAuthor_5', 'Cristio', 'leo', 'leocristio@robinson.end', '2a6f3c0e19ddd72eaa9bdf6ec628e2f0132d1306', 0);

-- --------------------------------------------------------

--
-- Structure de la table `users_bid`
--

CREATE TABLE `users_bid` (
  `user_id` int(11) NOT NULL,
  `auction_id` int(11) NOT NULL,
  `value` decimal(10,2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users_bid`
--

INSERT INTO `users_bid` (`user_id`, `auction_id`, `value`) VALUES
(6, 1, '0.24'),
(3, 1, '0.16'),
(3, 1, '0.42'),
(3, 2, '490.00'),
(3, 3, '490.00'),
(3, 4, '490.00');

-- --------------------------------------------------------

--
-- Structure de la table `website_blocks`
--

CREATE TABLE `website_blocks` (
  `title_main` tinytext NOT NULL,
  `text_main` text NOT NULL,
  `button_main` tinytext NOT NULL,
  `title_marketplace` tinytext NOT NULL,
  `button_marketplace` tinytext NOT NULL,
  `title_create` tinytext NOT NULL,
  `text_create` text NOT NULL,
  `button_create` tinytext NOT NULL,
  `title_popular` tinytext NOT NULL,
  `button_popular` tinytext NOT NULL,
  `title_newsletter` tinytext NOT NULL,
  `text_newsletter` text NOT NULL,
  `text_contact` text NOT NULL,
  `facebook_contact` text NOT NULL,
  `mail_contact` text NOT NULL,
  `twitter_contact` text NOT NULL,
  `linkedin_contact` text NOT NULL,
  `text_second_button` tinytext NOT NULL,
  `title_site` tinytext NOT NULL,
  `description_site` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `website_blocks`
--

INSERT INTO `website_blocks` (`title_main`, `text_main`, `button_main`, `title_marketplace`, `button_marketplace`, `title_create`, `text_create`, `button_create`, `title_popular`, `button_popular`, `title_newsletter`, `text_newsletter`, `text_contact`, `facebook_contact`, `mail_contact`, `twitter_contact`, `linkedin_contact`, `text_second_button`, `title_site`, `description_site`) VALUES
('Découvrez et Collectionnez  les Meilleurs NFTs <span>Digital Art.</span>', 'Commencez avec la plateforme la plus facile et la plus sûre pour acheter et échanger de l\'art numérique et des NFT. Commencez à explorer le monde de l\'art numérique et des NFT dès aujourd\'hui et prenez le contrôle de vos actifs numériques en toute confiance !', 'Explorer', '<span>Incroyables</span> et Super Unique Art de la <span>Semaine</span>', 'Explorer', 'Créez et Vendez Vos Meilleurs <span>NFTs</span>', 'Commencez à explorer le monde de l\'art numérique et des NFT dès aujourd\'hui et prenez le contrôle de vos actifs numériques en toute confiance !', 'Créer maintenant', '<span>Artistes</span> populaires<br>Cette Semaine', 'Explorer', 'S’inscrire et <span>être<br>contacté</span> Chaque Semaine', 'Nous avons un blog lié aux NFT et nous pouvons donc partager nos reflexions sur notre blog qui est mis à jour chaque semaine.', 'Découvrez les NFT par catégorie, suivez les dernières nouveautés et les collections que vous aimez. Profitez-en !', 'https://facebook.com/nft-marketplace', 'contact@nftmarketplace.com', 'https://twitter.com/@NFTMarketplace', 'https://www.linkedin.com/in/nftmarketplace', 'En savoir plus', 'Acceuil - NFT MarketPlace', 'La plateforme la plus facile et la plus sûre pour acheter et échanger de l\'art numérique et des NFT!');

-- --------------------------------------------------------

--
-- Structure de la table `website_nfts`
--

CREATE TABLE `website_nfts` (
  `id` int(11) NOT NULL,
  `nft_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `website_nfts`
--

INSERT INTO `website_nfts` (`id`, `nft_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(12, 13),
(13, 14);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `auctions`
--
ALTER TABLE `auctions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nft_id` (`nft_id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auction_id` (`auction_id`),
  ADD KEY `nft_id` (`nft_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `nfts`
--
ALTER TABLE `nfts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users_bid`
--
ALTER TABLE `users_bid`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `auction_id` (`auction_id`);

--
-- Index pour la table `website_nfts`
--
ALTER TABLE `website_nfts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nft_id` (`nft_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `auctions`
--
ALTER TABLE `auctions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `nfts`
--
ALTER TABLE `nfts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `website_nfts`
--
ALTER TABLE `website_nfts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `auctions`
--
ALTER TABLE `auctions`
  ADD CONSTRAINT `auction_nft` FOREIGN KEY (`nft_id`) REFERENCES `nfts` (`id`);

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `auction_comment_link` FOREIGN KEY (`auction_id`) REFERENCES `auctions` (`id`),
  ADD CONSTRAINT `nft_comment_link` FOREIGN KEY (`nft_id`) REFERENCES `nfts` (`id`),
  ADD CONSTRAINT `user_comment_link` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `nfts`
--
ALTER TABLE `nfts`
  ADD CONSTRAINT `nft_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Contraintes pour la table `website_nfts`
--
ALTER TABLE `website_nfts`
  ADD CONSTRAINT `nft_link` FOREIGN KEY (`nft_id`) REFERENCES `nfts` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
