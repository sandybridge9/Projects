-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018 m. Grd 10 d. 15:46
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `is`
--

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `ataskaita`
--

CREATE TABLE `ataskaita` (
  `id` int(11) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `atsiliepimas`
--

CREATE TABLE `atsiliepimas` (
  `id` int(11) NOT NULL,
  `tekstas` text,
  `ivertinimas` int(11) DEFAULT NULL,
  `fk_vartotojas` int(11) NOT NULL,
  `fk_zaidimas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Sukurta duomenų kopija lentelei `atsiliepimas`
--

INSERT INTO `atsiliepimas` (`id`, `tekstas`, `ivertinimas`, `fk_vartotojas`, `fk_zaidimas`) VALUES
(13, 'sdfsdfsdfdsf', 6, 4, 2),
(14, 'LIT 420', 9, 4, 17),
(15, 'This game is awesome', 8, 1, 4),
(16, 'Never played before', 8, 1, 13),
(17, 'More like just cause 1 + dlc', 3, 1, 8),
(18, 'Cool game', 6, 8, 1);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `draugai`
--

CREATE TABLE `draugai` (
  `fk_vartotojas` int(11) NOT NULL,
  `fk_vartotojas1` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Sukurta duomenų kopija lentelei `draugai`
--

INSERT INTO `draugai` (`fk_vartotojas`, `fk_vartotojas1`) VALUES
(1, 4),
(8, 1);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `klientu_ataskaita`
--

CREATE TABLE `klientu_ataskaita` (
  `id` int(11) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `komentaras`
--

CREATE TABLE `komentaras` (
  `id` int(11) NOT NULL,
  `tekstas` text NOT NULL,
  `data` date NOT NULL,
  `fk_vartotojas` int(11) NOT NULL,
  `fk_nuotrauku_galerija` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `kurejas`
--

CREATE TABLE `kurejas` (
  `id` int(11) NOT NULL,
  `pavadinimas` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Sukurta duomenų kopija lentelei `kurejas`
--

INSERT INTO `kurejas` (`id`, `pavadinimas`) VALUES
(1, 'Riot'),
(2, 'Treyarch'),
(3, 'Adt');

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `megstamiausiu_zaidimu_sarasas`
--

CREATE TABLE `megstamiausiu_zaidimu_sarasas` (
  `id` int(11) NOT NULL,
  `data` date NOT NULL,
  `fk_vartotojo_profilis` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Sukurta duomenų kopija lentelei `megstamiausiu_zaidimu_sarasas`
--

INSERT INTO `megstamiausiu_zaidimu_sarasas` (`id`, `data`, `fk_vartotojo_profilis`) VALUES
(1, '2018-12-10', 4),
(3, '2018-12-10', 1),
(9, '2018-12-10', 12);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `megstamiausiu_zaidimu_sarasas_zaidimas`
--

CREATE TABLE `megstamiausiu_zaidimu_sarasas_zaidimas` (
  `fk_megstamiausiu_zaidimu_sarasas` int(11) NOT NULL,
  `fk_zaidimas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Sukurta duomenų kopija lentelei `megstamiausiu_zaidimu_sarasas_zaidimas`
--

INSERT INTO `megstamiausiu_zaidimu_sarasas_zaidimas` (`fk_megstamiausiu_zaidimu_sarasas`, `fk_zaidimas`) VALUES
(1, 15),
(3, 4),
(3, 13),
(9, 8),
(9, 14);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `mokejimas`
--

CREATE TABLE `mokejimas` (
  `id` int(11) NOT NULL,
  `suma` decimal(10,0) NOT NULL,
  `data` date NOT NULL,
  `mokejimas_ijungtas` tinyint(1) NOT NULL,
  `fk_mokejimo_budas` int(11) DEFAULT NULL,
  `fk_nuolaidos_kuponas` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `mokejimo_budas`
--

CREATE TABLE `mokejimo_budas` (
  `id` int(11) NOT NULL,
  `pavadinimas` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Sukurta duomenų kopija lentelei `mokejimo_budas`
--

INSERT INTO `mokejimo_budas` (`id`, `pavadinimas`) VALUES
(1, 'Pay Pal'),
(3, 'SEB');

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `naujienlaiskis`
--

CREATE TABLE `naujienlaiskis` (
  `id` int(11) NOT NULL,
  `pavadinimas` varchar(255) NOT NULL,
  `pranesimas` varchar(255) NOT NULL,
  `data` date NOT NULL,
  `fk_zaidimas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Sukurta duomenų kopija lentelei `naujienlaiskis`
--

INSERT INTO `naujienlaiskis` (`id`, `pavadinimas`, `pranesimas`, `data`, `fk_zaidimas`) VALUES
(1, 'Adventure Time !', 'Galite Ä¯sigyti uÅ¾ pusÄ™ kainos !', '2018-12-18', 15),
(2, 'Hey Heyyyy !', 'Dabar nemokamai visiem perkatiems Fallaut 4 !', '2018-12-19', 15);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `nuolaida`
--

CREATE TABLE `nuolaida` (
  `id` int(11) NOT NULL,
  `pavadinimas` varchar(255) NOT NULL,
  `kiekis` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Sukurta duomenų kopija lentelei `nuolaida`
--

INSERT INTO `nuolaida` (`id`, `pavadinimas`, `kiekis`) VALUES
(1, 'dhbvshj', 10),
(7, 'Wabau', 30),
(8, 'Noname', 40),
(9, 'Kaledinis 50', 50),
(11, 'newYears', 50);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `nuolaidos_kuponas`
--

CREATE TABLE `nuolaidos_kuponas` (
  `kodas` varchar(255) NOT NULL,
  `fk_nuolaida` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Sukurta duomenų kopija lentelei `nuolaidos_kuponas`
--

INSERT INTO `nuolaidos_kuponas` (`kodas`, `fk_nuolaida`) VALUES
('ag67c9n', 1),
('gnr41nr', 7),
('abcd', 8),
('christmas50', 9),
('newY', 11);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `nuotrauka`
--

CREATE TABLE `nuotrauka` (
  `id` int(11) NOT NULL,
  `nuoroda` varchar(255) NOT NULL,
  `data` date NOT NULL,
  `fk_zaidimas` int(11) DEFAULT NULL,
  `fk_nuotrauku_galerija` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Sukurta duomenų kopija lentelei `nuotrauka`
--

INSERT INTO `nuotrauka` (`id`, `nuoroda`, `data`, `fk_zaidimas`, `fk_nuotrauku_galerija`) VALUES
(6, 'https://qph.fs.quoracdn.net/main-qimg-6f549d49a9ddb0766f351177c3add966', '2018-12-10', NULL, 10),
(7, 'https://data.whicdn.com/images/53825135/large.jpg', '2018-12-10', NULL, 10),
(8, 'http://i.imgur.com/KDhzQlj.png', '2018-12-10', NULL, 16),
(9, 'https://pm1.narvii.com/6363/64ca1931fd9726619b827a6db2627c4dec809242_hq.jpg', '2018-12-10', NULL, 16);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `nuotrauku_galerija`
--

CREATE TABLE `nuotrauku_galerija` (
  `id` int(11) NOT NULL,
  `pavadinimas` varchar(255) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `fk_vartotojo_profilis` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Sukurta duomenų kopija lentelei `nuotrauku_galerija`
--

INSERT INTO `nuotrauku_galerija` (`id`, `pavadinimas`, `data`, `fk_vartotojo_profilis`) VALUES
(10, 'Anime', '2018-12-10', 4),
(16, 'Nuotraukos', '2018-12-10', 12),
(17, 'Nuotraukos', '2018-12-10', 12),
(18, 'Nuotraukos', '2018-12-10', 12);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `pasiekimas`
--

CREATE TABLE `pasiekimas` (
  `id` int(11) NOT NULL,
  `pavadinimas` varchar(255) NOT NULL,
  `aprasymas` varchar(255) NOT NULL,
  `isigyjimo_data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Sukurta duomenų kopija lentelei `pasiekimas`
--

INSERT INTO `pasiekimas` (`id`, `pavadinimas`, `aprasymas`, `isigyjimo_data`) VALUES
(1, 'Me likey!', 'Added a game to your favorites list', '2018-12-10'),
(2, 'Look!', 'Added a picture to a gallery', '2018-12-10'),
(3, 'Friends!', 'Added a friend to your friends list', '2018-12-10'),
(4, 'Harsh, but fair', 'Reviewed a game', '2018-12-10');

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `pasiekimas_vartotojo_profilis`
--

CREATE TABLE `pasiekimas_vartotojo_profilis` (
  `fk_pasiekimas` int(11) NOT NULL,
  `fk_vartotojo_profilis` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Sukurta duomenų kopija lentelei `pasiekimas_vartotojo_profilis`
--

INSERT INTO `pasiekimas_vartotojo_profilis` (`fk_pasiekimas`, `fk_vartotojo_profilis`) VALUES
(1, 12),
(3, 12),
(4, 1),
(4, 4);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `uzsakymas`
--

CREATE TABLE `uzsakymas` (
  `id` int(11) NOT NULL,
  `uzsakymo_data` date NOT NULL,
  `kaina` decimal(10,0) NOT NULL,
  `apmoketa` tinyint(1) NOT NULL,
  `fk_vartotojas` int(11) NOT NULL,
  `fk_mokejimas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Sukurta duomenų kopija lentelei `uzsakymas`
--

INSERT INTO `uzsakymas` (`id`, `uzsakymo_data`, `kaina`, `apmoketa`, `fk_vartotojas`, `fk_mokejimas`) VALUES
(4, '2018-12-09', '45', 0, 7, NULL),
(10, '2018-12-09', '36', 0, 7, NULL),
(15, '2018-12-11', '101', 0, 1, NULL);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `uzsakymas_ataskaita`
--

CREATE TABLE `uzsakymas_ataskaita` (
  `fk_uzsakymas` int(11) NOT NULL,
  `fk_ataskaita` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `uzsakymas_zaidimas`
--

CREATE TABLE `uzsakymas_zaidimas` (
  `fk_uzsakymas` int(11) NOT NULL,
  `fk_zaidimas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Sukurta duomenų kopija lentelei `uzsakymas_zaidimas`
--

INSERT INTO `uzsakymas_zaidimas` (`fk_uzsakymas`, `fk_zaidimas`) VALUES
(4, 4),
(10, 10);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `vartotojas`
--

CREATE TABLE `vartotojas` (
  `id` int(11) NOT NULL,
  `vardas` varchar(255) NOT NULL,
  `pavarde` varchar(255) NOT NULL,
  `gimimo_data` date NOT NULL,
  `prisijungimo_vardas` varchar(255) NOT NULL,
  `slaptazodis` varchar(255) NOT NULL,
  `el_pastas` varchar(255) NOT NULL,
  `vartotojo_lygis` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Sukurta duomenų kopija lentelei `vartotojas`
--

INSERT INTO `vartotojas` (`id`, `vardas`, `pavarde`, `gimimo_data`, `prisijungimo_vardas`, `slaptazodis`, `el_pastas`, `vartotojo_lygis`) VALUES
(1, 'Jonas', 'Jonaitis', '2018-12-05', 'Jonas', 'jonas', 'jonas@gmail.com', 'registruotas_vartotojas'),
(2, 'admin', 'admin', '2018-12-05', 'admin', 'admin', 'admin@gmail.com', 'administratorius'),
(3, 'buhalteris', 'buhalteris', '2018-12-05', 'buhalteris', 'buhalteris', 'buhalteris@gmail.com', 'buhalteris'),
(4, 'Rimas', 'rimas', '2018-12-02', 'rimas', 'rimas', 'rimas@gmail.com', 'registruotas_vartotojas'),
(7, 'Matas', 'Jonaitis', '1992-06-16', 'matas', 'matas', 'matas@gmail.com', 'registruotas_vartotojas'),
(8, 'Tadas', 'Laurinaitis', '1993-06-01', 'tadas', 'tadas', 'tadas@gmail.com', 'registruotas_vartotojas');

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `vartotojas_klientu_ataskaita`
--

CREATE TABLE `vartotojas_klientu_ataskaita` (
  `fk_vartotojas` int(11) NOT NULL,
  `fk_klientu_ataskaita` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `vartotojo_profilis`
--

CREATE TABLE `vartotojo_profilis` (
  `id` int(11) NOT NULL,
  `paveikslelio_nuoroda` varchar(255) DEFAULT NULL,
  `aprasas` varchar(255) DEFAULT NULL,
  `fk_vartotojas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Sukurta duomenų kopija lentelei `vartotojo_profilis`
--

INSERT INTO `vartotojo_profilis` (`id`, `paveikslelio_nuoroda`, `aprasas`, `fk_vartotojas`) VALUES
(1, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ59JjyB5jtWwaMf2PK7q8vFdvMkOdEzmV2dsxnHGfEzu0Eg0jAMQ', 'Hello', 1),
(2, 'https://litreactor.com/sites/default/files/imagecache/header/images/column/headers/viz-blog_saitama.jpg', 'One punch admin', 2),
(3, 'https://cloud.netlifyusercontent.com/assets/344dbf88-fdf9-42bb-adb4-46f01eedd629/242ce817-97a3-48fe-9acd-b1bf97930b01/09-posterization-opt.jpg', NULL, 3),
(4, 'https://pm1.narvii.com/6363/64ca1931fd9726619b827a6db2627c4dec809242_hq.jpg', 'Lit boi', 4),
(10, 'http://i.imgur.com/KDhzQlj.png', 'sdfdsf', 7),
(12, 'http://i.imgur.com/KDhzQlj.png', 'Labas', 8);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `zaidimas`
--

CREATE TABLE `zaidimas` (
  `id` int(11) NOT NULL,
  `pavadinimas` varchar(255) NOT NULL,
  `isleidimo_data` date NOT NULL,
  `kaina` decimal(10,0) NOT NULL,
  `aprasymas` text NOT NULL,
  `virselio_nuoroda` varchar(255) NOT NULL,
  `turimas_kiekis` int(11) NOT NULL,
  `parduotas_kiekis` int(11) NOT NULL,
  `fk_nuolaida` int(11) DEFAULT NULL,
  `fk_kurejas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Sukurta duomenų kopija lentelei `zaidimas`
--

INSERT INTO `zaidimas` (`id`, `pavadinimas`, `isleidimo_data`, `kaina`, `aprasymas`, `virselio_nuoroda`, `turimas_kiekis`, `parduotas_kiekis`, `fk_nuolaida`, `fk_kurejas`) VALUES
(1, 'League Of Legends', '2018-12-05', '15', 'Nerf irelia', 'https://news-a.akamaihd.net/public/images/misc/GameBox.jpg', 10, 2, NULL, 1),
(2, 'Black Ops 2', '2018-12-05', '45', 'Panic knife.', 'https://images.g2a.com/newlayout/323x433/1x1x0/cee86c61442a/59886485ae653acb850d4532', 45, 0, NULL, 2),
(4, 'Mega Man', '2018-12-05', '45', 'Nerf irelia', 'https://images-na.ssl-images-amazon.com/images/I/81TmYu4ZHrL._SY500_.jpg', 45, 2, NULL, 2),
(7, 'ABP', '2018-12-04', '38', 'Action RPG', 'https://upload.wikimedia.org/wikipedia/en/thumb/f/f1/All_Points_Bulletin.jpg/220px-All_Points_Bulletin.jpg', 45, 0, NULL, 3),
(8, 'Just Cause 2', '2018-12-05', '45', 'Action shooting game', 'https://upload.wikimedia.org/wikipedia/en/thumb/3/3b/Just_Cause_2.jpg/220px-Just_Cause_2.jpg', 18, 0, NULL, 3),
(9, 'Just Cause 4', '2018-09-10', '60', 'Action shooting game', 'https://upload.wikimedia.org/wikipedia/en/thumb/0/0f/Just_Cause_4_cover.jpg/220px-Just_Cause_4_cover.jpg', 9, 0, NULL, 3),
(10, 'Arma 3', '2015-06-16', '36', 'War simulator', 'https://www.tarasgames.lt/image/cache/data/%C5%BDaidimai/Arma%203/Arma-3-pc-400x564.jpg', 30, 5, NULL, 3),
(11, 'Arma 2', '2018-08-01', '40', 'War simulator', 'https://upload.wikimedia.org/wikipedia/en/thumb/b/bc/Arma-2-cover.jpg/220px-Arma-2-cover.jpg', 12, 0, NULL, 3),
(12, 'Crash Bandicoot', '2018-06-10', '15', 'Crash', 'http://www.skytech.lt/images/large/8/1839308.jpg', 12, 0, NULL, 1),
(13, 'Metro Exodus', '2019-02-19', '70', 'Action apocalyptic survival game', 'https://buypcgame.eu/5408-large_default/metro-exodus.jpg', 16, 0, NULL, 3),
(14, 'Metro Last Light', '2018-06-11', '30', 'Survivial apocalyptic game', 'https://www.tarasgames.lt/image/cache/data/%C5%BDaidimai/Metro/Last%20Light/pc-400x564.jpg', 30, 10, NULL, 3),
(15, 'Fallout New Vegas', '2018-03-11', '35', 'Apocalyptic survival RPG', 'https://www.tarasgames.lt/image/cache/data/%C5%BDaidimai/Fallout/New%20Vegas/pc-400x564.jpg', 12, 0, NULL, 3),
(16, 'Fallout 4', '2018-06-10', '20', 'Apocalyptic survival RPG', 'https://www.tarasgames.lt/image/cache/data/%C5%BDaidimai--SEO/Fallout/4/fallout-4-pc-400x564.jpg', 20, 0, NULL, 3),
(17, 'Far Cry 5', '2018-06-18', '35', 'Survival game', 'https://www.tarasgames.lt/image/cache/data/%C5%BDaidimai--SEO/Far%20Cry/5/Far-cry-5-pc-tarasgames.lt_683x960-400x564.jpg', 10, 0, NULL, 3);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `zaidimas_vartotojas`
--

CREATE TABLE `zaidimas_vartotojas` (
  `fk_zaidimas` int(11) NOT NULL,
  `fk_vartotojas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Sukurta duomenų kopija lentelei `zaidimas_vartotojas`
--

INSERT INTO `zaidimas_vartotojas` (`fk_zaidimas`, `fk_vartotojas`) VALUES
(1, 8),
(2, 1),
(2, 4),
(4, 1),
(8, 1),
(8, 8),
(10, 1),
(11, 1),
(13, 1),
(14, 8),
(15, 4),
(17, 4);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `zaidimu_rinkinys`
--

CREATE TABLE `zaidimu_rinkinys` (
  `id` int(11) NOT NULL,
  `pavadinimas` varchar(255) NOT NULL,
  `kaina` decimal(10,0) NOT NULL,
  `virselio_nuoroda` varchar(255) NOT NULL,
  `turimas_kiekis` int(11) NOT NULL,
  `parduotas_kiekis` int(11) NOT NULL,
  `fk_nuolaida` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Sukurta duomenų kopija lentelei `zaidimu_rinkinys`
--

INSERT INTO `zaidimu_rinkinys` (`id`, `pavadinimas`, `kaina`, `virselio_nuoroda`, `turimas_kiekis`, `parduotas_kiekis`, `fk_nuolaida`) VALUES
(1, 'Game it', '330', 'nuoroda', 20, 10, 7),
(2, 'hjsbcha', '151', 'nuoroda', 4, 9, 8);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `zaidimu_rinkinys_zaidimas`
--

CREATE TABLE `zaidimu_rinkinys_zaidimas` (
  `fk_zaidimu_rinkinys` int(11) NOT NULL,
  `fk_zaidimas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Sukurta duomenų kopija lentelei `zaidimu_rinkinys_zaidimas`
--

INSERT INTO `zaidimu_rinkinys_zaidimas` (`fk_zaidimu_rinkinys`, `fk_zaidimas`) VALUES
(1, 10),
(1, 11),
(2, 16),
(2, 17);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `zanras`
--

CREATE TABLE `zanras` (
  `id` int(11) NOT NULL,
  `pavadinimas` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `zanras_zaidimas`
--

CREATE TABLE `zanras_zaidimas` (
  `fk_zanras` int(11) NOT NULL,
  `fk_zaidimas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ataskaita`
--
ALTER TABLE `ataskaita`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `atsiliepimas`
--
ALTER TABLE `atsiliepimas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkc_vartotojas5` (`fk_vartotojas`),
  ADD KEY `fkc_zaidimas2` (`fk_zaidimas`);

--
-- Indexes for table `draugai`
--
ALTER TABLE `draugai`
  ADD PRIMARY KEY (`fk_vartotojas`,`fk_vartotojas1`),
  ADD KEY `fkc_vartotojas1` (`fk_vartotojas1`);

--
-- Indexes for table `klientu_ataskaita`
--
ALTER TABLE `klientu_ataskaita`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `komentaras`
--
ALTER TABLE `komentaras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkc_vartotojas2` (`fk_vartotojas`),
  ADD KEY `fkc_nuotrauku_galerija` (`fk_nuotrauku_galerija`);

--
-- Indexes for table `kurejas`
--
ALTER TABLE `kurejas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `megstamiausiu_zaidimu_sarasas`
--
ALTER TABLE `megstamiausiu_zaidimu_sarasas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fk_vartotojo_profilis` (`fk_vartotojo_profilis`);

--
-- Indexes for table `megstamiausiu_zaidimu_sarasas_zaidimas`
--
ALTER TABLE `megstamiausiu_zaidimu_sarasas_zaidimas`
  ADD PRIMARY KEY (`fk_megstamiausiu_zaidimu_sarasas`,`fk_zaidimas`),
  ADD KEY `fkc_zaidimas4` (`fk_zaidimas`);

--
-- Indexes for table `mokejimas`
--
ALTER TABLE `mokejimas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkc_nuolaidos_kuponas` (`fk_nuolaidos_kuponas`),
  ADD KEY `fkc_mokejimo_budas` (`fk_mokejimo_budas`);

--
-- Indexes for table `mokejimo_budas`
--
ALTER TABLE `mokejimo_budas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `naujienlaiskis`
--
ALTER TABLE `naujienlaiskis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkc_zaidimas7` (`fk_zaidimas`);

--
-- Indexes for table `nuolaida`
--
ALTER TABLE `nuolaida`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nuolaidos_kuponas`
--
ALTER TABLE `nuolaidos_kuponas`
  ADD PRIMARY KEY (`kodas`),
  ADD KEY `fkc_nuolaida` (`fk_nuolaida`);

--
-- Indexes for table `nuotrauka`
--
ALTER TABLE `nuotrauka`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkc_zaidimas5` (`fk_zaidimas`),
  ADD KEY `fkc_nuotrauku_galerija1` (`fk_nuotrauku_galerija`);

--
-- Indexes for table `nuotrauku_galerija`
--
ALTER TABLE `nuotrauku_galerija`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkc_vartotojo_profilis2` (`fk_vartotojo_profilis`);

--
-- Indexes for table `pasiekimas`
--
ALTER TABLE `pasiekimas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pasiekimas_vartotojo_profilis`
--
ALTER TABLE `pasiekimas_vartotojo_profilis`
  ADD PRIMARY KEY (`fk_pasiekimas`,`fk_vartotojo_profilis`),
  ADD KEY `fkc_vartotojo_profilis` (`fk_vartotojo_profilis`);

--
-- Indexes for table `uzsakymas`
--
ALTER TABLE `uzsakymas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fk_mokejimas` (`fk_mokejimas`),
  ADD KEY `fkc_vartotojas7` (`fk_vartotojas`);

--
-- Indexes for table `uzsakymas_ataskaita`
--
ALTER TABLE `uzsakymas_ataskaita`
  ADD PRIMARY KEY (`fk_uzsakymas`,`fk_ataskaita`),
  ADD KEY `fkc_ataskaita` (`fk_ataskaita`);

--
-- Indexes for table `uzsakymas_zaidimas`
--
ALTER TABLE `uzsakymas_zaidimas`
  ADD PRIMARY KEY (`fk_uzsakymas`,`fk_zaidimas`),
  ADD KEY `fkc_zaidimas1` (`fk_zaidimas`);

--
-- Indexes for table `vartotojas`
--
ALTER TABLE `vartotojas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vartotojas_klientu_ataskaita`
--
ALTER TABLE `vartotojas_klientu_ataskaita`
  ADD PRIMARY KEY (`fk_vartotojas`,`fk_klientu_ataskaita`),
  ADD KEY `fkc_klientu_ataskaita` (`fk_klientu_ataskaita`);

--
-- Indexes for table `vartotojo_profilis`
--
ALTER TABLE `vartotojo_profilis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fk_vartotojas` (`fk_vartotojas`);

--
-- Indexes for table `zaidimas`
--
ALTER TABLE `zaidimas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkc_nuolaida2` (`fk_nuolaida`),
  ADD KEY `fkc_kurejas` (`fk_kurejas`);

--
-- Indexes for table `zaidimas_vartotojas`
--
ALTER TABLE `zaidimas_vartotojas`
  ADD PRIMARY KEY (`fk_zaidimas`,`fk_vartotojas`),
  ADD KEY `fkc_vartotojas4` (`fk_vartotojas`);

--
-- Indexes for table `zaidimu_rinkinys`
--
ALTER TABLE `zaidimu_rinkinys`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkc_nuolaida1` (`fk_nuolaida`);

--
-- Indexes for table `zaidimu_rinkinys_zaidimas`
--
ALTER TABLE `zaidimu_rinkinys_zaidimas`
  ADD PRIMARY KEY (`fk_zaidimu_rinkinys`,`fk_zaidimas`),
  ADD KEY `fkc_zaidimas` (`fk_zaidimas`);

--
-- Indexes for table `zanras`
--
ALTER TABLE `zanras`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zanras_zaidimas`
--
ALTER TABLE `zanras_zaidimas`
  ADD PRIMARY KEY (`fk_zanras`,`fk_zaidimas`),
  ADD KEY `fkc_zaidimas6` (`fk_zaidimas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `atsiliepimas`
--
ALTER TABLE `atsiliepimas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `klientu_ataskaita`
--
ALTER TABLE `klientu_ataskaita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `komentaras`
--
ALTER TABLE `komentaras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kurejas`
--
ALTER TABLE `kurejas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `megstamiausiu_zaidimu_sarasas`
--
ALTER TABLE `megstamiausiu_zaidimu_sarasas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `mokejimas`
--
ALTER TABLE `mokejimas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mokejimo_budas`
--
ALTER TABLE `mokejimo_budas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `naujienlaiskis`
--
ALTER TABLE `naujienlaiskis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `nuolaida`
--
ALTER TABLE `nuolaida`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `nuotrauka`
--
ALTER TABLE `nuotrauka`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `nuotrauku_galerija`
--
ALTER TABLE `nuotrauku_galerija`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `pasiekimas`
--
ALTER TABLE `pasiekimas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `uzsakymas`
--
ALTER TABLE `uzsakymas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `vartotojas`
--
ALTER TABLE `vartotojas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `vartotojo_profilis`
--
ALTER TABLE `vartotojo_profilis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `zaidimas`
--
ALTER TABLE `zaidimas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `zaidimu_rinkinys`
--
ALTER TABLE `zaidimu_rinkinys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `zanras`
--
ALTER TABLE `zanras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Apribojimai eksportuotom lentelėm
--

--
-- Apribojimai lentelei `atsiliepimas`
--
ALTER TABLE `atsiliepimas`
  ADD CONSTRAINT `fkc_vartotojas5` FOREIGN KEY (`fk_vartotojas`) REFERENCES `vartotojas` (`id`),
  ADD CONSTRAINT `fkc_zaidimas2` FOREIGN KEY (`fk_zaidimas`) REFERENCES `zaidimas` (`id`);

--
-- Apribojimai lentelei `draugai`
--
ALTER TABLE `draugai`
  ADD CONSTRAINT `fkc_vartotojas` FOREIGN KEY (`fk_vartotojas`) REFERENCES `vartotojas` (`id`),
  ADD CONSTRAINT `fkc_vartotojas1` FOREIGN KEY (`fk_vartotojas1`) REFERENCES `vartotojas` (`id`);

--
-- Apribojimai lentelei `komentaras`
--
ALTER TABLE `komentaras`
  ADD CONSTRAINT `fkc_nuotrauku_galerija` FOREIGN KEY (`fk_nuotrauku_galerija`) REFERENCES `nuotrauku_galerija` (`id`),
  ADD CONSTRAINT `fkc_vartotojas2` FOREIGN KEY (`fk_vartotojas`) REFERENCES `vartotojas` (`id`);

--
-- Apribojimai lentelei `megstamiausiu_zaidimu_sarasas`
--
ALTER TABLE `megstamiausiu_zaidimu_sarasas`
  ADD CONSTRAINT `fkc_vartotojo_profilis1` FOREIGN KEY (`fk_vartotojo_profilis`) REFERENCES `vartotojo_profilis` (`id`);

--
-- Apribojimai lentelei `megstamiausiu_zaidimu_sarasas_zaidimas`
--
ALTER TABLE `megstamiausiu_zaidimu_sarasas_zaidimas`
  ADD CONSTRAINT `fkc_megstamiausiu_zaidimu_sarasas` FOREIGN KEY (`fk_megstamiausiu_zaidimu_sarasas`) REFERENCES `megstamiausiu_zaidimu_sarasas` (`id`),
  ADD CONSTRAINT `fkc_zaidimas4` FOREIGN KEY (`fk_zaidimas`) REFERENCES `zaidimas` (`id`);

--
-- Apribojimai lentelei `mokejimas`
--
ALTER TABLE `mokejimas`
  ADD CONSTRAINT `fkc_mokejimo_budas` FOREIGN KEY (`fk_mokejimo_budas`) REFERENCES `mokejimo_budas` (`id`),
  ADD CONSTRAINT `fkc_nuolaidos_kuponas` FOREIGN KEY (`fk_nuolaidos_kuponas`) REFERENCES `nuolaidos_kuponas` (`kodas`);

--
-- Apribojimai lentelei `naujienlaiskis`
--
ALTER TABLE `naujienlaiskis`
  ADD CONSTRAINT `fkc_zaidimas7` FOREIGN KEY (`fk_zaidimas`) REFERENCES `zaidimas` (`id`);

--
-- Apribojimai lentelei `nuolaidos_kuponas`
--
ALTER TABLE `nuolaidos_kuponas`
  ADD CONSTRAINT `fkc_nuolaida` FOREIGN KEY (`fk_nuolaida`) REFERENCES `nuolaida` (`id`);

--
-- Apribojimai lentelei `nuotrauka`
--
ALTER TABLE `nuotrauka`
  ADD CONSTRAINT `fkc_nuotrauku_galerija1` FOREIGN KEY (`fk_nuotrauku_galerija`) REFERENCES `nuotrauku_galerija` (`id`),
  ADD CONSTRAINT `fkc_zaidimas5` FOREIGN KEY (`fk_zaidimas`) REFERENCES `zaidimas` (`id`);

--
-- Apribojimai lentelei `nuotrauku_galerija`
--
ALTER TABLE `nuotrauku_galerija`
  ADD CONSTRAINT `fkc_vartotojo_profilis2` FOREIGN KEY (`fk_vartotojo_profilis`) REFERENCES `vartotojo_profilis` (`id`);

--
-- Apribojimai lentelei `pasiekimas_vartotojo_profilis`
--
ALTER TABLE `pasiekimas_vartotojo_profilis`
  ADD CONSTRAINT `fkc_pasiekimas` FOREIGN KEY (`fk_pasiekimas`) REFERENCES `pasiekimas` (`id`),
  ADD CONSTRAINT `fkc_vartotojo_profilis` FOREIGN KEY (`fk_vartotojo_profilis`) REFERENCES `vartotojo_profilis` (`id`);

--
-- Apribojimai lentelei `uzsakymas`
--
ALTER TABLE `uzsakymas`
  ADD CONSTRAINT `fkc_mokejimas` FOREIGN KEY (`fk_mokejimas`) REFERENCES `mokejimas` (`id`),
  ADD CONSTRAINT `fkc_vartotojas7` FOREIGN KEY (`fk_vartotojas`) REFERENCES `vartotojas` (`id`);

--
-- Apribojimai lentelei `uzsakymas_ataskaita`
--
ALTER TABLE `uzsakymas_ataskaita`
  ADD CONSTRAINT `fkc_ataskaita` FOREIGN KEY (`fk_ataskaita`) REFERENCES `ataskaita` (`id`),
  ADD CONSTRAINT `fkc_uzsakymas` FOREIGN KEY (`fk_uzsakymas`) REFERENCES `uzsakymas` (`id`);

--
-- Apribojimai lentelei `uzsakymas_zaidimas`
--
ALTER TABLE `uzsakymas_zaidimas`
  ADD CONSTRAINT `fkc_uzsakymas1` FOREIGN KEY (`fk_uzsakymas`) REFERENCES `uzsakymas` (`id`),
  ADD CONSTRAINT `fkc_zaidimas1` FOREIGN KEY (`fk_zaidimas`) REFERENCES `zaidimas` (`id`);

--
-- Apribojimai lentelei `vartotojas_klientu_ataskaita`
--
ALTER TABLE `vartotojas_klientu_ataskaita`
  ADD CONSTRAINT `fkc_klientu_ataskaita` FOREIGN KEY (`fk_klientu_ataskaita`) REFERENCES `klientu_ataskaita` (`id`),
  ADD CONSTRAINT `fkc_vartotojas6` FOREIGN KEY (`fk_vartotojas`) REFERENCES `vartotojas` (`id`);

--
-- Apribojimai lentelei `vartotojo_profilis`
--
ALTER TABLE `vartotojo_profilis`
  ADD CONSTRAINT `fkc_vartotojas3` FOREIGN KEY (`fk_vartotojas`) REFERENCES `vartotojas` (`id`);

--
-- Apribojimai lentelei `zaidimas`
--
ALTER TABLE `zaidimas`
  ADD CONSTRAINT `fkc_kurejas` FOREIGN KEY (`fk_kurejas`) REFERENCES `kurejas` (`id`),
  ADD CONSTRAINT `fkc_nuolaida2` FOREIGN KEY (`fk_nuolaida`) REFERENCES `nuolaida` (`id`);

--
-- Apribojimai lentelei `zaidimas_vartotojas`
--
ALTER TABLE `zaidimas_vartotojas`
  ADD CONSTRAINT `fkc_vartotojas4` FOREIGN KEY (`fk_vartotojas`) REFERENCES `vartotojas` (`id`),
  ADD CONSTRAINT `fkc_zaidimas3` FOREIGN KEY (`fk_zaidimas`) REFERENCES `zaidimas` (`id`);

--
-- Apribojimai lentelei `zaidimu_rinkinys`
--
ALTER TABLE `zaidimu_rinkinys`
  ADD CONSTRAINT `fkc_nuolaida1` FOREIGN KEY (`fk_nuolaida`) REFERENCES `nuolaida` (`id`);

--
-- Apribojimai lentelei `zaidimu_rinkinys_zaidimas`
--
ALTER TABLE `zaidimu_rinkinys_zaidimas`
  ADD CONSTRAINT `fkc_zaidimas` FOREIGN KEY (`fk_zaidimas`) REFERENCES `zaidimas` (`id`),
  ADD CONSTRAINT `fkc_zaidimu_rinkinys` FOREIGN KEY (`fk_zaidimu_rinkinys`) REFERENCES `zaidimu_rinkinys` (`id`);

--
-- Apribojimai lentelei `zanras_zaidimas`
--
ALTER TABLE `zanras_zaidimas`
  ADD CONSTRAINT `fkc_zaidimas6` FOREIGN KEY (`fk_zaidimas`) REFERENCES `zaidimas` (`id`),
  ADD CONSTRAINT `fkc_zanras` FOREIGN KEY (`fk_zanras`) REFERENCES `zanras` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
