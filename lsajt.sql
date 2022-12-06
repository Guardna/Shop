-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2022 at 10:16 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lsajt`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `CategoryId` int(11) NOT NULL,
  `Name` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CategoryId`, `Name`) VALUES
(1, 'Alstroemeria'),
(2, 'Calla Lily'),
(3, 'Daisy'),
(4, 'Gardenia'),
(5, 'Carnation'),
(6, 'Gerbera Daisy'),
(7, 'Orchid'),
(8, 'Tulip'),
(9, 'Peony'),
(10, 'Dahlia');

-- --------------------------------------------------------

--
-- Table structure for table `color`
--

CREATE TABLE `color` (
  `ColorId` int(11) NOT NULL,
  `Name` varchar(120) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `color`
--

INSERT INTO `color` (`ColorId`, `Name`) VALUES
(1, 'Red'),
(2, 'Yellow'),
(3, 'Blue'),
(4, 'Orange'),
(5, 'Green'),
(6, 'Violet'),
(7, 'Black'),
(8, 'White'),
(9, 'Gray'),
(10, 'Brown');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(50) NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `post_id` int(50) NOT NULL,
  `user_id` int(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `InvoiceId` int(11) NOT NULL,
  `CustomerId` int(11) NOT NULL,
  `ImePrezime` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `InvoiceDate` datetime NOT NULL,
  `BillingAddress` varchar(70) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `BillingCity` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `BillingState` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `BillingPostalCode` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Phone` varchar(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`InvoiceId`, `CustomerId`, `ImePrezime`, `InvoiceDate`, `BillingAddress`, `BillingCity`, `BillingState`, `BillingPostalCode`, `Phone`, `email`, `Total`) VALUES
(1, 10, 'Neko Nekic', '2022-10-30 17:42:34', 'Neka Ulica', 'Beograd', 'Zvezdara', '11000', '0600000000', 'nekitamo@gmail.com', '190.00');

-- --------------------------------------------------------

--
-- Table structure for table `invoiceline`
--

CREATE TABLE `invoiceline` (
  `InvoiceLineId` int(11) NOT NULL,
  `InvoiceId` int(11) NOT NULL,
  `PostId` int(11) NOT NULL,
  `UnitPrice` decimal(10,2) NOT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoiceline`
--

INSERT INTO `invoiceline` (`InvoiceLineId`, `InvoiceId`, `PostId`, `UnitPrice`, `Quantity`) VALUES
(1, 1, 90, '62.00', 1),
(2, 1, 89, '64.00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE `korisnik` (
  `id` int(50) NOT NULL,
  `korisnicko_ime` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ImePrezime` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `lozinka` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slika` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `BillingAddress` varchar(70) COLLATE utf8_unicode_ci DEFAULT NULL,
  `BillingCity` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `BillingState` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `BillingPostalCode` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Phone` varchar(24) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `uloga_id` int(50) NOT NULL,
  `created_at` int(255) DEFAULT NULL,
  `updated_at` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`id`, `korisnicko_ime`, `ImePrezime`, `lozinka`, `slika`, `BillingAddress`, `BillingCity`, `BillingState`, `BillingPostalCode`, `Phone`, `email`, `uloga_id`, `created_at`, `updated_at`) VALUES
(9, 'admin', 'Stefan Popovic', '2e33a9b0b06aa0a01ede70995674ee23', 'images/1521518929.jpg', 'androidxx8@gmail.com', 'Beograd', 'Zvezdara', '11000', '0694017734', 'stefan.popovic.328.15@ict.edu.rs', 1, 1521518929, 1667153217),
(10, 'Korisnik', 'Neko Nekic', 'd7e9276b8f896de9fb13769f5a03910b', 'images/1521521281.jpg', 'Neka Ulica', 'Beograd', 'Zvezdara', '11000', '0600000000', 'nekitamo@gmail.com', 2, 1521521281, 1667153271);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(50) NOT NULL,
  `user` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `action` text COLLATE utf8_unicode_ci NOT NULL,
  `time` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user`, `action`, `time`) VALUES
(15, 'admin', 'Added Korisnik nanana', 1615739748),
(20, 'Admin', 'Login Korisnik Admin', 1615740674),
(39, 'admin', 'Updated post Wwww', 1615818818),
(334, 'admin', 'Login Korisnik admin', 1667147672),
(335, 'Korisnik', 'Login Korisnik Korisnik', 1667149895),
(336, 'Korisnik', 'Login Korisnik Korisnik', 1667149909),
(337, 'admin', 'Login Korisnik admin', 1667150365),
(338, 'Korisnik', 'Login Korisnik Korisnik', 1667151747),
(339, 'admin', 'Login Korisnik admin', 1667151770),
(340, 'admin', 'Added Uloga nesto', 1667152413),
(342, 'admin', 'Added Uloga eqweq', 1667152573),
(345, 'admin', 'Updated Korisnik admin', 1667152778),
(346, 'admin', 'Updated Korisnik Korisnik', 1667152803),
(347, 'Korisnik', 'Login Korisnik Korisnik', 1667152818),
(348, 'admin', 'Login Korisnik admin', 1667152841),
(349, 'admin', 'Login Korisnik admin', 1667152848),
(350, 'admin', 'Login Korisnik admin', 1667152883),
(351, 'admin', 'Login Korisnik admin', 1667152910),
(352, 'admin', 'Updated Korisnik admin', 1667152935),
(353, 'admin', 'Updated Korisnik Korisnik', 1667152953),
(354, 'admin', 'Updated Korisnik admin', 1667153217),
(355, 'admin', 'Updated Korisnik Korisnik', 1667153227),
(356, 'admin', 'Login Korisnik admin', 1667153242),
(357, 'Korisnik', 'Login Korisnik Korisnik', 1667153252),
(358, 'Korisnik', 'Updated Korisnik Korisnik', 1667153271),
(359, 'Korisnik', 'Login Korisnik Korisnik', 1667153284),
(360, 'admin', 'Login Korisnik admin', 1667153295),
(361, 'admin', 'Login Korisnik admin', 1667164313),
(362, 'admin', 'Updated post Melastomataceae', 1667164329),
(363, 'Novi', 'Added Korisnik Novi', 1667164404),
(364, 'admin', 'Deleted Korisnik Novi', 1667164413);

-- --------------------------------------------------------

--
-- Table structure for table `meni`
--

CREATE TABLE `meni` (
  `id` int(50) NOT NULL,
  `naziv` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `meni`
--

INSERT INTO `meni` (`id`, `naziv`, `link`) VALUES
(1, 'Home', '/'),
(2, 'Gallery', '/gallery'),
(3, 'Contact', '/contact-us');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(50) NOT NULL,
  `naslov` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sadrzaj` text COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `slika_id` int(255) NOT NULL,
  `korisnik_id` int(255) NOT NULL,
  `ColorId` int(11) NOT NULL,
  `CategoryId` int(11) NOT NULL,
  `popust` decimal(10,2) DEFAULT NULL,
  `created_at` int(255) DEFAULT NULL,
  `updated_at` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `naslov`, `sadrzaj`, `price`, `slika_id`, `korisnik_id`, `ColorId`, `CategoryId`, `popust`, `created_at`, `updated_at`) VALUES
(64, 'Ant Manarara', 'Vasadsad', '111.00', 118, 9, 4, 4, '25.00', 1615665268, 1667126748),
(81, 'Calyx', 'The sepals, collectively called the calyx, are modified leaves that occur on the outermost whorl of the flower. They are leaf-like, in that they have a broad base, stomata, stipules, and chlorophyll. Sepals are often waxy and tough, and grow quickly to protect the flower as it develops. They may be deciduous, but will more commonly grow on to assist in fruit dispersal. If the calyx is fused together it is called gamosepalous', '25.00', 131, 9, 6, 1, NULL, 1667144964, NULL),
(82, 'Corolla', 'The petals, together the corolla, are almost or completely fiberless leaf-like structures that form the innermost whorl of the perianth. They are often delicate and thin, and are usually coloured, shaped, or scented to encourage pollination. Although similar to leaves in shape, they are more comparable to stamens in that they form almost simultaneously with one another, but their subsequent growth is delayed. If the corolla is fused together it is called sympetalous.', '23.00', 132, 9, 8, 2, NULL, 1667145007, NULL),
(83, 'Androecium', 'The androecium, or stamens, is the whorl of pollen producing male parts. Stamens consist typically of an anther, made up of four pollen sacs arranged in two thecae, connected to a filament, or stalk. The anther contains microsporocytes which become pollen, the male gametophyte, after undergoing meiosis. Although they exhibit the widest variation among floral organs, the androecium is usually confined just to one whorl and to two whorls only in rare cases. Stamens range in number, size, shape, orientation, and in their point of connection to the flower.', '21.00', 133, 9, 1, 3, NULL, 1667145049, NULL),
(84, 'Gynoecium', 'The gynoecium, or the carpels, is the female part of the flower found on the innermost whorl. Each carpel consists of a stigma, which receives pollen, a style, which acts as a stalk, and an ovary, which contains the ovules. Carpels may occur in one to several whorls, and when fused together are often described as a pistil. Inside the ovary, the ovules are suspended off of pieces of tissue called placenta.', '30.00', 134, 9, 2, 4, NULL, 1667145100, NULL),
(85, 'Inflorescence', 'In those species that have more than one flower on an axis, the collective cluster of flowers is called an inflorescence. Some inflorescences are composed of many small flowers arranged in a formation that resembles a single flower. The common example of this is most members of the very large composite (Asteraceae) group. A single daisy or sunflower, for example, is not a flower but a flower head—an inflorescence composed of numerous flowers (or florets). An inflorescence may include specialized stems and modified leaves known as bracts', '23.00', 135, 9, 8, 4, NULL, 1667145140, NULL),
(86, 'Asteraceae', 'Most species of Asteraceae are annual, biennial, or perennial herbaceous plants, but there are also shrubs, vines, and trees. The family has a widespread distribution, from subpolar to tropical regions in a wide variety of habitats. Most occur in hot desert and cold or hot semi-desert climates, and they are found on every continent but Antarctica. The primary common characteristic is the existence of sometimes hundreds of tiny individual florets which are held together by protective involucres in flower heads, or more technically, capitula.', '42.00', 136, 9, 6, 6, NULL, 1667145241, NULL),
(87, 'Orchid', 'Orchids are plants that belong to the family Orchidaceae, a diverse and widespread group of flowering plants with blooms that are often colourful and fragrant.', '22.00', 137, 9, 8, 7, '25.00', 1667145294, 1667145605),
(88, 'Fabaceae', 'The Fabaceae or Leguminosae, commonly known as the legume, pea, or bean family, are a large and agriculturally important family of flowering plants. It includes trees, shrubs, and perennial or annual herbaceous plants, which are easily recognized by their fruit (legume) and their compound, stipulate leaves. The family is widely distributed, and is the third-largest land plant family in number of species, behind only the Orchidaceae and Asteraceae, with about 765 genera and nearly 20,000 known species', '53.00', 138, 9, 1, 10, NULL, 1667145340, NULL),
(89, 'Rubiaceae', 'The Rubiaceae are a family of flowering plants, commonly known as the coffee, madder, or bedstraw family. It consists of terrestrial trees, shrubs, lianas, or herbs that are recognizable by simple, opposite leaves with interpetiolar stipules and sympetalous actinomorphic flowers.', '64.00', 139, 9, 6, 9, NULL, 1667145385, NULL),
(90, 'Lamiaceae', 'The Lamiaceae or Labiatae are a family of flowering plants commonly known as the mint or deadnettle or sage family. Many of the plants are aromatic in all parts and include widely used culinary herbs like basil, mint, rosemary, sage, savory, marjoram, oregano, hyssop, thyme, lavender, and perilla, as well as other medicinal herbs such as catnip, salvia, bee balm, wild dagga, and oriental motherwort. Some species are shrubs, trees (such as teak), or, rarely, vines. Many members of the family are widely cultivated, not only for their aromatic qualities, but also their ease of cultivation, since they are readily propagated by stem cuttings.', '62.00', 140, 9, 1, 8, NULL, 1667145435, NULL),
(91, 'Melastomataceae', 'Melastomataceae is a family of dicotyledonous flowering plants found mostly in the tropics (two-thirds of the genera are from the New World tropics) comprising c. 175 genera and c. 5115 known species. Melastomes are annual or perennial herbs, shrubs, or small trees.', '26.00', 141, 9, 8, 6, NULL, 1667145478, 1667164329);

-- --------------------------------------------------------

--
-- Table structure for table `slika`
--

CREATE TABLE `slika` (
  `id` int(255) NOT NULL,
  `putanja` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `slika`
--

INSERT INTO `slika` (`id`, `putanja`) VALUES
(108, 'images/1615820272.jpg'),
(131, 'images/1667144964.jpg'),
(132, 'images/1667145007.jpg'),
(133, 'images/1667145049.jpg'),
(134, 'images/1667145100.jpg'),
(135, 'images/1667145140.jpg'),
(136, 'images/1667145241.jpg'),
(137, 'images/1667145294.jpg'),
(138, 'images/1667145340.jpg'),
(139, 'images/1667145385.jpg'),
(140, 'images/1667145435.jpg'),
(141, 'images/1667145478.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `uloga`
--

CREATE TABLE `uloga` (
  `id` int(50) NOT NULL,
  `naziv` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `uloga`
--

INSERT INTO `uloga` (`id`, `naziv`) VALUES
(1, 'admin'),
(2, 'korisnik');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CategoryId`);

--
-- Indexes for table `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`ColorId`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IFK_post_id` (`post_id`),
  ADD KEY `IFK_user_id` (`user_id`) USING BTREE;

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`InvoiceId`),
  ADD KEY `IFK_InvoiceCustomerId` (`CustomerId`);

--
-- Indexes for table `invoiceline`
--
ALTER TABLE `invoiceline`
  ADD PRIMARY KEY (`InvoiceLineId`),
  ADD KEY `IFK_InvoiceLineInvoiceId` (`InvoiceId`) USING BTREE,
  ADD KEY `IFK_InvoiceLinePostId` (`PostId`);

--
-- Indexes for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IFK_uloga_id` (`uloga_id`) USING BTREE;

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meni`
--
ALTER TABLE `meni`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IFK_korisnik_id` (`korisnik_id`),
  ADD KEY `IFK_category_id` (`CategoryId`),
  ADD KEY `IFK_slika_id` (`slika_id`) USING BTREE,
  ADD KEY `IFK_color_id` (`ColorId`) USING BTREE;

--
-- Indexes for table `slika`
--
ALTER TABLE `slika`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uloga`
--
ALTER TABLE `uloga`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `CategoryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `color`
--
ALTER TABLE `color`
  MODIFY `ColorId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT for table `korisnik`
--
ALTER TABLE `korisnik`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=365;

--
-- AUTO_INCREMENT for table `meni`
--
ALTER TABLE `meni`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `slika`
--
ALTER TABLE `slika`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT for table `uloga`
--
ALTER TABLE `uloga`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `korisnik` (`id`);

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`CustomerId`) REFERENCES `korisnik` (`id`);

--
-- Constraints for table `invoiceline`
--
ALTER TABLE `invoiceline`
  ADD CONSTRAINT `invoiceline_ibfk_1` FOREIGN KEY (`InvoiceId`) REFERENCES `invoice` (`InvoiceId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `invoiceline_ibfk_2` FOREIGN KEY (`PostId`) REFERENCES `post` (`id`);

--
-- Constraints for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD CONSTRAINT `korisnik_ibfk_1` FOREIGN KEY (`uloga_id`) REFERENCES `uloga` (`id`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`korisnik_id`) REFERENCES `korisnik` (`id`),
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`CategoryId`) REFERENCES `category` (`CategoryId`),
  ADD CONSTRAINT `post_ibfk_3` FOREIGN KEY (`ColorId`) REFERENCES `color` (`ColorId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
