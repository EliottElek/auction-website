-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 05 avr. 2021 à 12:50
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `e-sales`
--

-- --------------------------------------------------------

--
-- Structure de la table `adress`
--

DROP TABLE IF EXISTS `adress`;
CREATE TABLE IF NOT EXISTS `adress` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `country` varchar(300) NOT NULL,
  `city` varchar(300) NOT NULL,
  `postal` varchar(300) NOT NULL,
  `adress` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `adress`
--

INSERT INTO `adress` (`id`, `userID`, `country`, `city`, `postal`, `adress`) VALUES
(63, 25, 'France', 'PARIS', '75017', '12 rue des pauvres'),
(64, 2, 'France', 'PARIS', '75017', '23 avenue marchal'),
(50, 2, 'France', 'PARIS', '75017', '12 rue des pauvres'),
(5, 3, 'France', 'PARIS', '75017', '12 rue des pauvres'),
(6, 3, 'France', 'PARIS', '75017', '16 rue thÃ©odule ribot'),
(7, 0, 'France', 'PARIS', '75017', '16 rue thÃ©odule ribot'),
(8, 0, 'France', 'CAVAILLON', '84300', '23 avenue marchal'),
(65, 45, 'France', 'Paris', '75007', '13 rue de la ComÃ¨te'),
(38, 38, 'France', 'PARIS', '75017', '12 rue des pauvres'),
(11, 40, 'France', 'PARIS', '75017', '12 rue des pauvres'),
(66, 25, 'France', 'CAVAILLON', '84300', '45 rue de la campagne'),
(67, 46, 'France', 'CAVAILLON', '84300', '12 rue des pauvres'),
(68, 26, 'France', 'PARIS', '75017', '12 rue des pauvres'),
(69, 5, 'France', 'PARIS', '75017', '12 rue des pauvres'),
(70, 51, 'France', 'PARIS', '75017', '12 rue des pauvres');

-- --------------------------------------------------------

--
-- Structure de la table `auctions`
--

DROP TABLE IF EXISTS `auctions`;
CREATE TABLE IF NOT EXISTS `auctions` (
  `category` varchar(300) NOT NULL,
  `secCategory` varchar(300) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand` varchar(300) NOT NULL,
  `model` varchar(300) NOT NULL,
  `capacity` varchar(300) NOT NULL,
  `size` varchar(300) NOT NULL,
  `price` float NOT NULL,
  `picture` tinytext NOT NULL,
  `description` text NOT NULL,
  `currentBid` float NOT NULL,
  `endingTime` date NOT NULL,
  `bestBidder` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `auctions`
--

INSERT INTO `auctions` (`category`, `secCategory`, `id`, `brand`, `model`, `capacity`, `size`, `price`, `picture`, `description`, `currentBid`, `endingTime`, `bestBidder`) VALUES
('auctions', 'phones', 1, 'Xiaomi', 'Redmi Note 8 Pro', '256Go', '6.5in', 299, 'http://i01.appmifile.com/webfile/globalimg/de-micom/J3S-108-Silvery.png', 'High resolution photos printable on a 3.26m high poster\r\nUltra high resolution 64MP camera\r\nAlmost double the number of pixels at 8K resolution *\r\n25 times more pixels than on the screen. Zoom in for more details.\r\n4K video recording and slow motion video recording 960 frames per second.', 540, '2021-05-04', 'Eliott Morcillo'),
('auctions', 'tablets', 2, 'Apple', 'Ipad Air', '64Go', '10.5in', 609, 'https://image.darty.com/accessoires/electricite_pile/ipad/apple_new_ipad_air_64celar_t1903184642023A_175518538.jpg', '0.5 \"(24.6 cm) Retina LED display - 2224 x 1668 pixel resolution\r\nCapacity 64 GB - Wifi 802.11 a / b / g / n / ac + Bluetooth 5.0 - 4G compatible\r\nUp to 10 hours of battery life - Touch ID fingerprint sensor\r\nUltra thin: 6.1 mm - Weight: 464 g', 618, '2021-04-08', 'Ulysse Burah'),
('auctions', 'phones', 4, 'Samsung', 'Galaxy S20', '8.0Go', '6.2in', 610, 'https://images-na.ssl-images-amazon.com/images/I/71Nq1XZzu2L._AC_SL1500_.jpg', 'The Samsung Galaxy S20 is the new flagship for 2020 of Samsung\'s Galaxy S series. With a 6.2-inch QHD + display and 120Hz refresh rate, the Galaxy S20 is powered by a Snapdragon 865 processor in its US variant or an Exynos 990 processor in its international version. The Galaxy S20 has 8 GB of RAM for the LTE variant and 128 GB of internal storage, expandable via microSD. The Galaxy S20\'s rear camera is triple, with a 12 MP + 12 MP + 64 MP setup, while the selfie camera is 10 megapixels. Rounding out the features of the Galaxy S20 we find an in-display fingerprint reader, 4000mAh battery with support for fast and wireless charging, AKG stereo speakers and runs One UI 2 based on Android 10.', 670, '2021-04-12', 'Paul Moquin');

-- --------------------------------------------------------

--
-- Structure de la table `bestoffers`
--

DROP TABLE IF EXISTS `bestoffers`;
CREATE TABLE IF NOT EXISTS `bestoffers` (
  `category` varchar(300) NOT NULL,
  `secCategory` varchar(300) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand` varchar(300) NOT NULL,
  `model` varchar(300) NOT NULL,
  `capacity` varchar(300) NOT NULL,
  `size` varchar(300) NOT NULL,
  `price` float NOT NULL,
  `picture` tinytext NOT NULL,
  `description` text NOT NULL,
  `sellerID` int(11) NOT NULL,
  `status` varchar(100) DEFAULT NULL,
  `winnerID` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `bestoffers`
--

INSERT INTO `bestoffers` (`category`, `secCategory`, `id`, `brand`, `model`, `capacity`, `size`, `price`, `picture`, `description`, `sellerID`, `status`, `winnerID`) VALUES
('bestoffers', 'tablets', 1, 'Samsung', 'Samsung Galaxy Tab S6 Lite', '64Go', '10.4in', 350, 'https://www.esdorado.com/3012-large_default/tablette-samsung-galaxy-tab-s6-lite-p615-104-lte-64-go-bleu.jpg', 'GENERAL\r\nThe Galaxy Tab S model lineup\r\nPROCESSOR\r\nProcessor Type and Has an Octa-Core Exynos 9611 10nm Quad Core 2.3 GHz processor\r\nQuad Core, 1.7 GHz\r\nTechnology\r\nOperating system: Android + OneUI version 2 10 operating system\r\nTHE MAIN SCREEN\r\nISF screen type Maximum resolution of 2000 pixels and a minimum resolution of 1200 Screen size 26.42 cm / 10.4 \"\r\nCAMERA\r\nFront camera resolution 5 MP, Rear camera resolution (primary) 8 MP Rear camera functions of auto focus\r\nCAMERA\r\nVideo recording resolution rear facing camera 1080p @ 30fps\r\nMEMORY\r\nExternal memory Yes Compatible memory card type Micro SD card capacity of 512 GB, one Internal memory of 64 GB of RAM 4 GB\r\nCONNECTIVITY\r\nConnection type USB 3.1 Type C\r\nWi-Fi 802.11 a / b / g / n / ac 2.4 GHz + 5 GHz\r\nBluetooth 5.0\r\nDRUMS\r\nBattery capacity 7040 mA / h\r\nOTHER FEATURES\r\nOther Features of Removable Battery: No\r\nDIMENSIONS AND WEIGHT\r\nThe size is 154.3 x 244.5 x 7 mm Weight: 460 g\r\nGUARANTEE\r\n2 years warranty', 26, 'complete', 5),
('bestoffers', 'Phones', 12, 'Apple', 'Iphone 8', '128Go', '6in', 499, 'https://store.storeimages.cdn-apple.com/4668/as-images.apple.com/is/refurb-iphone8-spacegray?wid=1144&hei=1144&fmt=jpeg&qlt=95&.v=1541182730534', 'first marketed in September 2017\r\n\r\nModel A1905 unlocked, without SIM card1\r\n\r\n4.7-inch Retina HD display with IPS technology\r\n\r\nA11 Bionic chip with integrated M11 motion coprocessor\r\n\r\nTalk time (wireless): up to 14 hours\r\n\r\n4G LTE and 802.11ac Wi-Fi with MIMO\r\n\r\nBluetooth 5.0 wireless technology\r\n\r\nNFC with reader mode\r\n\r\n12 MP camera\r\n\r\nDigital zoom up to 5x\r\n\r\n1080p HD video recording\r\n\r\nFaceTime HD Camera\r\n\r\nTouch ID\r\n\r\nSiri\r\n\r\nApple Pay\r\n\r\n148 g and 7.3 mm\r\n\r\nApple Certified Refurbished Products\r\nQuality products at competitive prices\r\n\r\nRigorous pre-sale repackaging process\r\n\r\nCovered by limited warranty Opens in a new window. One year Apple\r\n\r\nCovered by return policy Opens in a new window. Within 14 days Apple\r\n\r\nYou can purchase an AppleCare contractOpens a new window.\r\n\r\nEngraving and gift wrap not available for refurbished products\r\n\r\nAvailable quantities are limited\r\n\r\nBox contents\r\niPhone 8 refurbished\r\n\r\nEarPods headphones with Lightning connector\r\n\r\nLightning to USB cable\r\n\r\nUSB power adapter\r\n\r\nDocumentation\r\n\r\nRequired configuration\r\nApple ID (required for some features)\r\n\r\nInternet access 2\r\n\r\nSyncing with iTunes on Mac or PC requires:\r\nMac: OS X v10.10.5 or later\r\n\r\nPC: Windows 7 or later\r\n\r\niTunes 12.7 or later (free download from www.itunes.com/download)\r\n\r\nAmbient conditions\r\nOperating temperature: 0 to 35 Â° C; storage temperature: from -20 to 45 Â° C; relative humidity: 5% to 95% non-condensing; Maximum operating altitude: tested up to 3000 m.\r\n\r\niPhone 8 is designed with the following features to reduce environmental impact:\r\n\r\nArsenic-free display glass\r\n\r\nMercury-free LED-backlit display\r\n\r\nBrominated flame retardant â€“ free\r\n\r\nPVC-free\r\n\r\nBeryllium-free\r\n\r\nHighly recyclable aluminum', 51, 'negotiation', NULL),
('bestoffers', 'earphones', 11, 'Bose', 'Quiet Comfort 35 II', '*', '10in', 233, 'https://static.fnac-static.com/multimedia/Images/FR/NR/f4/3c/88/8928500/1505-1/tsp20170914125020/Casque-sans-fil-Bose-QuietComfort-35-II-Noir.jpg', 'The Bose wireless on-ear headphones are supposed to offer clear and powerful sound according to the manufacturer. Lightweight and comfortable, it can be worn all day long. Enjoy crystal-clear calls in any environment, rugged materials, and up to 15 hours of battery life ... with the freedom of wireless.', 2, 'complete', 5),
('bestoffers', 'laptops', 51, 'Lenovo ', 'Legion Y540-15IRH ', '15Go RAM', '14in', 1399, 'https://images-na.ssl-images-amazon.com/images/I/61L-Np1kzkL._AC_SL1212_.jpg', 'Vestibulum rhoncus lobortis ante vel ultrices. Curabitur nec mauris ullamcorper, sodales turpis vel, dictum tortor. Fusce et laoreet ligula. Aenean imperdiet, sapien eu molestie porttitor, tortor lorem feugiat nisi, at aliquet mi massa nec purus. In eu lacinia magna. Integer pellentesque nulla ultricies, congue nisi sit amet, iaculis nisi. Ut ipsum diam, mattis sed porta eu, volutpat sit amet massa.\r\n\r\nPellentesque euismod erat arcu, a accumsan odio elementum eget. Donec justo turpis, semper sit amet fermentum nec, pretium ut urna. Nam vitae elit ut elit malesuada laoreet. Curabitur sodales, sapien ac finibus scelerisque, nisi lacus bibendum diam, eu pharetra lorem lectus vitae urna. Nunc placerat nec velit eget eleifend. Curabitur quis nunc vel augue bibendum volutpat. Mauris semper arcu eu sapien iaculis, at placerat massa posuere. Nullam sed bibendum lacus. Praesent est tortor, malesuada ut lacus non, egestas consequat elit. Integer facilisis lacinia tristique. Vestibulum finibus tempor ante, eget gravida mauris accumsan vel. Morbi gravida est sit amet nisi porttitor tempus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Maecenas euismod odio ac nisi pharetra eleifend. Cras pretium lacus tortor, eu varius purus condimentum vitae. Donec euismod pellentesque egestas.\r\n\r\nDuis ornare eros urna, sit amet tristique risus volutpat non. Proin magna ipsum, ultricies id neque a, mattis commodo est. Donec fermentum leo ut felis placerat fringilla. Vivamus et luctus risus. Vestibulum tempus bibendum urna eu efficitur. Cras auctor ante tortor, sit amet mattis tortor condimentum nec. Etiam ut placerat tellus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Proin porttitor placerat suscipit. Morbi quis elit a nibh sodales sodales quis eget purus. Sed at eros egestas nisi posuere congue. Praesent viverra dui ex, non consectetur lectus dapibus at. Nulla blandit turpis a mi ornare, luctus posuere libero mattis. Vestibulum lobortis dolor ex, at placerat lectus molestie in. Proin suscipit risus at magna rutrum tempus. In arcu velit, condimentum ac volutpat nec, porta quis dui.', 2, 'negotiation', NULL),
('bestoffers', 'laptops', 52, 'Apple', 'MacBook Air', '256Go', '13in', 1100, 'https://images-na.ssl-images-amazon.com/images/I/71TPda7cwUL._AC_SL1500_.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus rutrum augue neque, et elementum lectus dictum consequat. Morbi porttitor sodales dui, in vestibulum ligula tempus vulputate. Vivamus laoreet, elit vitae pretium vestibulum, est dui volutpat diam, et egestas turpis ligula a tellus. Nulla sed ex est. Sed fringilla felis vitae ex pretium, vel rutrum justo malesuada. Phasellus eu metus lacus. Aliquam erat volutpat. Etiam finibus ligula odio, a consequat purus laoreet vitae. Sed metus quam, tincidunt non nisi et, suscipit scelerisque leo. Quisque vitae bibendum nibh. Suspendisse ut magna ac felis ullamcorper egestas nec vel arcu. Mauris quis magna orci. Praesent efficitur ut lorem in suscipit. Nunc gravida, augue sit amet facilisis blandit, massa augue luctus urna, quis euismod lacus enim sit amet sem. Duis at pretium nisl. Ut ante est, pretium vel ornare vel, porttitor in velit.\r\n\r\nMaecenas auctor elit in mi aliquam tristique. Aenean convallis quam nisl, id accumsan metus pulvinar efficitur. Duis vitae hendrerit leo, id dictum sem. In et arcu urna. Proin laoreet luctus lectus, non viverra massa tempus in. Quisque est turpis, hendrerit in nisl a, sagittis posuere nulla. Donec tincidunt felis orci, vitae tincidunt tortor condimentum id. Etiam commodo ac purus lacinia iaculis. Aliquam id dui nec lacus ultricies consequat a mollis metus. Nulla placerat sapien vitae magna viverra sagittis.\r\n\r\nNulla facilisi. Sed finibus ligula et purus pellentesque, quis pharetra ligula faucibus. Pellentesque porttitor maximus auctor. Nulla nulla quam, mattis vel consectetur eget, porttitor a metus. Phasellus ultrices metus a ultricies molestie. Cras a arcu euismod, lobortis tortor a, tincidunt nisi. Nullam arcu mauris, viverra bibendum sagittis a, interdum ut eros. Phasellus in convallis massa, ac lobortis urna. Morbi ultricies ut turpis nec interdum.', 26, 'complete', 2);

-- --------------------------------------------------------

--
-- Structure de la table `cards`
--

DROP TABLE IF EXISTS `cards`;
CREATE TABLE IF NOT EXISTS `cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `lastname` varchar(300) NOT NULL,
  `digit` varchar(16) NOT NULL,
  `expdate` varchar(50) NOT NULL,
  `crypto` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `cards`
--

INSERT INTO `cards` (`id`, `userID`, `lastname`, `digit`, `expdate`, `crypto`) VALUES
(52, 2, 'Morcillo', '5131808203644365', '2021-01', 232),
(50, 3, 'Burah', '5131808203644365', '2021-07', 232),
(51, 5, 'MORCILLO', '5131808203644365', '2021-02', 232),
(46, 2, 'Moquin', '2324355465657676', '2022-07', 434),
(54, 46, 'MORCILLO', '5131808203644365', '2021-11', 121),
(49, 38, 'Bizet', '5131808203644365', '2021-06', 243),
(53, 51, 'Martin', '5131808203644365', '2021-12', 121);

-- --------------------------------------------------------

--
-- Structure de la table `earphones`
--

DROP TABLE IF EXISTS `earphones`;
CREATE TABLE IF NOT EXISTS `earphones` (
  `category` varchar(300) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand` varchar(300) NOT NULL,
  `model` varchar(300) NOT NULL,
  `capacity` varchar(300) NOT NULL,
  `size` varchar(300) NOT NULL,
  `price` int(11) NOT NULL,
  `picture` tinytext NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `earphones`
--

INSERT INTO `earphones` (`category`, `id`, `brand`, `model`, `capacity`, `size`, `price`, `picture`, `description`) VALUES
('earphones', 1, 'Apple', 'Airpods', '*', '2in', 152, 'https://www.cdiscount.com/pdt2/8/2/9/1/700x700/app190198764829/rw/apple-airpods-2-wireless-blanc.jpg', 'Interdum et malesuada fames ac ante ipsum primis in faucibus. Duis eu sagittis ipsum. Praesent vitae quam in nunc posuere tempor ut eu turpis. Ut quis ornare dui. Sed id quam nunc. Nulla facilisi. Vestibulum elit arcu, faucibus vitae dictum at, tincidunt eu lacus. Nam fermentum massa vitae lorem imperdiet, ac vulputate massa accumsan. Phasellus quam purus, vehicula id imperdiet vitae, dictum nec arcu. Quisque vestibulum urna at blandit dignissim. Ut porta sem sit amet scelerisque laoreet.'),
('earphones', 10, 'Lecover', 'Anti-Bruit CVC 8.0, IPX7', '*', '4in', 49, 'https://images-na.ssl-images-amazon.com/images/I/61aoQgmMi1L._AC_SL1500_.jpg', 'Nunc vehicula porta ligula. Maecenas tempor metus odio, in consequat lectus gravida a. Maecenas aliquet venenatis ex in blandit. Sed ex odio, semper vitae dui non, pulvinar porttitor turpis. Suspendisse vitae vulputate turpis, sit amet condimentum arcu. Aliquam faucibus erat a augue laoreet, ac vestibulum velit commodo. Etiam nisl risus, viverra non dictum sed, ultrices vitae metus. Donec et tempor lorem. Pellentesque blandit auctor venenatis. Donec varius facilisis tortor, rutrum fringilla erat tristique sit amet. Fusce rhoncus at urna ac sollicitudin. Vestibulum ac magna quis elit lacinia egestas. Mauris vulputate tellus at nulla bibendum, non volutpat nunc auctor.\r\n\r\nCurabitur cursus, leo nec convallis hendrerit, sem mauris posuere ante, in dapibus velit mauris eu orci. Proin congue id nisi viverra iaculis. In vulputate augue ac nulla iaculis, eu pretium mi pulvinar. Phasellus rutrum tempor ullamcorper. Fusce id libero ut arcu vulputate dictum dictum eu augue. Sed dolor enim, eleifend eget urna non, ullamcorper convallis neque. In fermentum, purus ac sollicitudin pretium, magna erat viverra diam, sit amet aliquet libero nisi et lectus. Nam vestibulum ac felis sed venenatis. Cras eget ligula justo. Ut sagittis magna sit amet magna eleifend porttitor. Sed dignissim eleifend sollicitudin. Donec nunc sapien, viverra et fermentum sed, cursus quis libero. Suspendisse potenti. Sed accumsan magna ex, nec dictum urna tristique id. Aenean hendrerit nisi ut rhoncus placerat. Nulla in velit pellentesque, consectetur risus a, volutpat neque.\r\n\r\nNullam pretium cursus est ac convallis. Nullam convallis massa vitae volutpat suscipit. Etiam non posuere dolor, at fermentum nunc. Mauris finibus odio quis metus euismod egestas. Pellentesque facilisis felis et mauris porttitor, eu consequat libero dignissim. In hendrerit turpis porttitor ultrices vestibulum. Quisque condimentum, libero sed posuere auctor, nisi purus interdum est, lacinia sollicitudin enim magna eu risus. Suspendisse lacinia massa odio. Praesent vitae gravida lacus. Ut auctor eleifend lorem eu consequat. Nulla tempor placerat nunc, sit amet mattis tortor semper quis. Suspendisse potenti. Donec velit nibh, ullamcorper eget vestibulum et, viverra eu dui. Nunc pharetra, quam non elementum efficitur, nunc nibh laoreet augue, fringilla finibus velit lorem vel magna.');

-- --------------------------------------------------------

--
-- Structure de la table `flashsales`
--

DROP TABLE IF EXISTS `flashsales`;
CREATE TABLE IF NOT EXISTS `flashsales` (
  `category` varchar(300) NOT NULL,
  `secCategory` varchar(300) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand` varchar(300) NOT NULL,
  `model` varchar(300) NOT NULL,
  `capacity` varchar(300) NOT NULL,
  `size` varchar(300) NOT NULL,
  `price` float NOT NULL,
  `picture` tinytext NOT NULL,
  `description` text NOT NULL,
  `discount` int(11) NOT NULL,
  `endingTime` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `flashsales`
--

INSERT INTO `flashsales` (`category`, `secCategory`, `id`, `brand`, `model`, `capacity`, `size`, `price`, `picture`, `description`, `discount`, `endingTime`) VALUES
('flashsales', 'laptops', 1, 'Dell', 'XPS17', '256Go to 2To', '17in (3 840 x 2 400 pixels)', 1799, 'https://cdn.tomsguide.fr/content/uploads/sites/2/2020/05/xps17-right-side-angle-open-fill-2-1024x576.jpg', 'The XPS 17 is touted by Dell as a laptop PC with a 17-inch screen yet smaller than nearly half of today\'s 15.6-inch computers ...\r\n\r\nAfter launching a few weeks ago the new version of its ultrabook in 13.3-inch format, the XPS 13, Dell completes its offer today, with the update of its model in 15.6-inch format, the XPS 15, and the announcement of a whole family member, the XPS 17, equipped as its name suggests with a large 17-inch screen.\r\n\r\nThese two new configurations will be available from May 14 for the XPS 15 (from € 1,799) and from June 11 for the XPS 17 (from € 1,999). They will benefit from the same very high level of finish as the XPS 13, with in particular an aluminum chassis, a carbon fiber palm rest (black or white) and a screen with four very thin edges. And despite this last point, the Webcam (720p compatible Windows Hello) of these laptops of the XPS range is well placed on the upper edge of the screen, and not at the bottom of the screen or in the keyboard as can still be the case. do other builders. There is also the fingerprint reader integrated into the start button.', 30, '2021-04-07'),
('flashsales', 'phones', 2, 'Apple', 'IPhone 10', '256Go', '5.8in', 605, 'https://images-na.ssl-images-amazon.com/images/I/51jpxxd1lNL._AC_SL1024_.jpg', 'Which screen definition is right for you?\r\nIf screen size matters, so does its size. This is because the higher it is, the more details the screen will display on lower definition videos or photos. The best performer in this area is the iPhone XS Max and its 2,688 × 1,242 pixels via its Super Retina OLED display. Just below, the iPhone X or XS offer a definition of 2,436 × 1,125 pixels. Only the iPhone XR, sporting a more classic LCD screen, displays a smaller definition of 1792 × 828 pixels, which nevertheless remains very comfortable while ultimately reducing the price of the phone.\r\n\r\n \r\n\r\nWhat to remember: the definition of the screen is more or less essential depending on your habits: if you like photos / videos, look for products offering the best definition like the iPhone X, XS, and XS Max . But if that\'s not as important, then the XR will be more than enough.\r\n\r\nA suitable storage space\r\nOne of the most important parameters of a smartphone, and especially an iPhone, is the storage space available for videos, photos, music and applications. Here, Apple offers almost the same possibilities on all its models, with a minimum memory of 64 GB regardless of the iPhone X series observed, which is already significant. However, only the XS and XS Max can see their storage space grow to 512 GB of memory, which is only useful here for those who store a very large volume of images and videos.\r\n\r\n \r\n\r\nBottom Line: The entire iPhone X range offers a minimum of 64 GB of memory, which is more than enough for a wide range of activities. But be aware that the iPhone XS and XS Max offer up to 512 GB if you take a lot of photos and videos.', 50, '2021-04-14'),
('flashsales', 'earphones', 3, 'Muzili', 'Muzili IPX7', '*', '3in', 59, 'https://images-na.ssl-images-amazon.com/images/I/413Jt8dtJNS._AC_.jpg', 'Cool earphones', 40, '2021-04-29'),
('flashsales', 'tablets', 8, 'Huawei', 'MediaPad T5 10 Wi-Fi', '32Go ROM', '10.1in', 159, 'https://images-na.ssl-images-amazon.com/images/I/5106KBmwSML._AC_SL1000_.jpg', 'Vestibulum finibus tempor ante, eget gravida mauris accumsan vel. Morbi gravida est sit amet nisi porttitor tempus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Maecenas euismod odio ac nisi pharetra eleifend. Cras pretium lacus tortor, eu varius purus condimentum vitae. Donec euismod pellentesque egestas.\r\n\r\nDuis ornare eros urna, sit amet tristique risus volutpat non. Proin magna ipsum, ultricies id neque a, mattis commodo est. Donec fermentum leo ut felis placerat fringilla. Vivamus et luctus risus. Vestibulum tempus bibendum urna eu efficitur. Cras auctor ante tortor, sit amet mattis tortor condimentum nec. Etiam ut placerat tellus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Proin porttitor placerat suscipit. Morbi quis elit a nibh sodales sodales quis eget purus. Sed at eros egestas nisi posuere congue. Praesent viverra dui ex, non consectetur lectus dapibus at. Nulla blandit turpis a mi ornare, luctus posuere libero mattis. Vestibulum lobortis dolor ex, at placerat lectus molestie in. Proin suscipit risus at magna rutrum tempus. In arcu velit, condimentum ac volutpat nec, porta quis dui.', 55, '2021-05-06');

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `objectID` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `pictureLink` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=98 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `images`
--

INSERT INTO `images` (`id`, `objectID`, `category`, `pictureLink`) VALUES
(3, 13, 'phones', 'https://s3-storage.textopus.nl/wp-content/uploads/2020/10/1263600/14182730/iphone-12-vs-iphone-12-pro.jpg'),
(4, 13, 'phones', 'https://www.leparisien.fr/resizer/FQPQMQ_04mTMSpS4WzEOoqHM48o=/932x582/cloudfront-eu-central-1.images.arcpublishing.com/leparisien/OT2VGWREN5BAZD5T37GS5R7WHU.jpg'),
(5, 13, 'phones', 'https://www.iphon.fr/app/uploads/2019/11/concept-iphone-12-design-ipad-1.jpg'),
(6, 1, 'phones', 'https://images.frandroid.com/wp-content/uploads/2019/02/samsung-galaxy-s10e-1549410658-0-0.jpg'),
(7, 1, 'phones', 'https://images.frandroid.com/wp-content/uploads/2019/02/samsung-galaxy-s10e-essential-frandroid-c_dsc00247.jpg'),
(8, 1, 'phones', 'https://www.mobile24.fr/images/Anti-Slip-TPU-Case-for-Samsung-Galaxy-S10E-lite-Transparent-01042019-01-p.jpg'),
(9, 12, 'phones', 'https://dyw7ncnq1en5l.cloudfront.net/optim/product/52/52757/3164512c-iphone-11-pro__450_400.jpeg'),
(10, 12, 'phones', 'https://images.itnewsinfo.com/lmi/articles/grande/000000068183.jpg'),
(11, 12, 'phones', 'https://store.storeimages.cdn-apple.com/4668/as-images.apple.com/is/iphone11-green-select-2019_AV3?wid=1246&hei=518&fmt=jpeg&qlt=80&op_usm=0.5,0.5&.v=1567202193352'),
(12, 14, 'phones', 'https://images.samsung.com/is/image/samsung/p6pim/fr/galaxy-s21/gallery/fr-galaxy-s21-5g-g996-371638-sm-g996bzrdeuh-369015211?$720_576_PNG$'),
(13, 14, 'phones', 'https://fdn.gsmarena.com/imgroot/news/21/02/galaxy-s21-plus-video-review/-1200w5/gsmarena_001.jpg'),
(14, 14, 'phones', 'https://cdn.movertix.com/media/catalog/product/cache/image/1200x/s/a/samsung-galaxy-s21-plus-5g-phantom-violet-256gb-and-8gb-ram-sm-g996b.jpg'),
(15, 1, 'auctions', 'https://stockphone.fr/1822-large_default/xiaomi-note-8-pro-.jpg'),
(16, 1, 'auctions', 'https://www.maxmovil.fr/media/catalog/product/cache/3/small_image/9df78eab33525d08d6e5fb8d27136e95/c/o/comprar-redmi-note-8-pro-blanco-4-.jpg'),
(17, 1, 'auctions', 'https://www.cdiscount.com/pdt2/6/4/4/1/700x700/red0749390862644/rw/xiaomi-redmi-note-8-pro-128go-vert-foret-processeu.jpg'),
(18, 2, 'auctions', 'https://image.darty.com/accessoires/electricite_pile/ipad/apple_new_ipad_air_64celar_t1903194642023B_151314377.jpg'),
(19, 2, 'auctions', 'https://image.darty.com/accessoires/electricite_pile/ipad/apple_new_ipad_air_64celar_s1903194642023E_151309956.jpg'),
(20, 2, 'auctions', 'https://image.darty.com/accessoires/electricite_pile/ipad/apple_new_ipad_air_64celar_s1903194642023C_151312741.jpg'),
(21, 4, 'auctions', 'https://www.presse-citron.net/app/uploads/2020/02/avis-galaxyS20ultra.jpg'),
(22, 4, 'auctions', 'https://images-na.ssl-images-amazon.com/images/I/811ri11x0GL._AC_SL1500_.jpg'),
(23, 4, 'auctions', 'https://images-na.ssl-images-amazon.com/images/I/81e8QbyKlOL._AC_SL1500_.jpg'),
(24, 2, 'flashsales', 'https://images-na.ssl-images-amazon.com/images/I/61nlT53kRKL._AC_SL1500_.jpg'),
(25, 2, 'flashsales', 'https://images-na.ssl-images-amazon.com/images/I/514YMVAc6NL._AC_SL1024_.jpg'),
(26, 2, 'flashsales', 'https://images-na.ssl-images-amazon.com/images/I/411SxsDFpsL._AC_SL1024_.jpg'),
(27, 1, 'flashsales', 'https://www.notebookcheck.biz/typo3temp/_processed_/6/3/csm_xps17_01_7632529571.jpg'),
(28, 1, 'flashsales', 'https://dyw7ncnq1en5l.cloudfront.net/optim/product/57/57939/d194bb1a-xps-17__450_400.jpeg'),
(29, 1, 'flashsales', 'https://i.dell.com/is/image/DellContent//content/dam/global-asset-library/Products/Notebooks/XPS/17_9700_non-touch/xs9700nt_cnb_00060lb055_gy.psd?fmt=pjpg&pscan=auto&scl=1&hei=402&wid=579&qlt=95,0&resMode=sharp2&op_usm=1.75,0.3,2,0&size=579,402'),
(30, 1, 'tablets', 'https://media.ldlc.com/r1600/ld/products/00/05/49/85/LD0005498565_2_0005499040_0005499090.jpg'),
(31, 1, 'tablets', 'https://www.geckocovers.com/files/thumbnails/v20t10c1-4-keyboard.1000x1000x0.jpg'),
(32, 1, 'tablets', 'https://static.turbosquid.com/Preview/2019/11/05__09_15_04/Microsoft_Surface_Pro7_00.jpg722FA025-321B-45E8-AF75-6DBBB0744A00Large.jpg'),
(33, 38, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/616M20fkyBL._AC_SL1126_.jpg'),
(34, 38, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/616M20fkyBL._AC_SL1126_.jpg'),
(35, 38, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/616M20fkyBL._AC_SL1126_.jpg'),
(36, 45, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/61W9OoKVfTL._AC_SL1126_.jpg'),
(37, 45, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/61W9OoKVfTL._AC_SL1126_.jpg'),
(38, 45, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/61W9OoKVfTL._AC_SL1126_.jpg'),
(39, 45, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/61W9OoKVfTL._AC_SL1126_.jpg'),
(40, 45, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/61W9OoKVfTL._AC_SL1126_.jpg'),
(41, 48, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/61W9OoKVfTL._AC_SL1126_.jpg'),
(42, 48, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/61W9OoKVfTL._AC_SL1126_.jpg'),
(43, 48, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/61W9OoKVfTL._AC_SL1126_.jpg'),
(44, 49, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/61W9OoKVfTL._AC_SL1126_.jpg'),
(45, 49, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/61W9OoKVfTL._AC_SL1126_.jpg'),
(46, 49, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/61W9OoKVfTL._AC_SL1126_.jpg'),
(47, 50, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/61W9OoKVfTL._AC_SL1126_.jpg'),
(48, 50, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/61W9OoKVfTL._AC_SL1126_.jpg'),
(49, 50, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/61W9OoKVfTL._AC_SL1126_.jpg'),
(50, 51, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/61W9OoKVfTL._AC_SL1126_.jpg'),
(51, 51, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/616M20fkyBL._AC_SL1126_.jpg'),
(52, 51, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/61apo1CZkzL._AC_SL1500_.jpg'),
(53, 12, 'bestoffers', 'https://verysmartphones.fr/704-large_default/iphone-8-64gb-gris-sideral-debloque.jpg'),
(54, 12, 'bestoffers', 'https://verysmartphones.fr/705-large_default/iphone-8-64gb-gris-sideral-debloque.jpg'),
(55, 12, 'bestoffers', 'https://verysmartphones.fr/707-large_default/iphone-8-64gb-gris-sideral-debloque.jpg'),
(56, 13, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/81GNqsU7C6L._AC_SL1500_.jpg'),
(57, 13, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/81GNqsU7C6L._AC_SL1500_.jpg'),
(58, 13, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/81GNqsU7C6L._AC_SL1500_.jpg'),
(59, 14, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/81GNqsU7C6L._AC_SL1500_.jpg'),
(60, 14, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/81GNqsU7C6L._AC_SL1500_.jpg'),
(61, 14, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/81GNqsU7C6L._AC_SL1500_.jpg'),
(62, 7, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/71B35zHR4hL._AC_SL1500_.jpg'),
(63, 7, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/71B35zHR4hL._AC_SL1500_.jpg'),
(64, 7, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/71B35zHR4hL._AC_SL1500_.jpg'),
(65, 15, 'tablets', 'https://images-na.ssl-images-amazon.com/images/I/71B35zHR4hL._AC_SL1500_.jpg'),
(66, 15, 'tablets', 'https://images-na.ssl-images-amazon.com/images/I/71r03%2BuI8qL._AC_SL1500_.jpg'),
(67, 15, 'tablets', 'https://images-na.ssl-images-amazon.com/images/I/81PQK7vPoQL._AC_SL1500_.jpg'),
(68, 8, 'flashsales', 'https://images-na.ssl-images-amazon.com/images/I/51zlvVFZgqL._AC_SL1000_.jpg'),
(69, 8, 'flashsales', 'https://images-na.ssl-images-amazon.com/images/I/51oyBwdhc8L._AC_SL1000_.jpg'),
(70, 8, 'flashsales', 'https://images-na.ssl-images-amazon.com/images/I/512Kua73PiL._AC_SL1000_.jpg'),
(71, 10, 'earphones', 'https://images-na.ssl-images-amazon.com/images/I/61kTHZeEJOL._AC_SL1000_.jpg'),
(72, 10, 'earphones', 'https://images-na.ssl-images-amazon.com/images/I/61fEjW2oggL._AC_SL1001_.jpg'),
(73, 10, 'earphones', 'https://images-na.ssl-images-amazon.com/images/I/61kTHZeEJOL._AC_SL1000_.jpg'),
(74, 10, 'earphones', 'https://images-na.ssl-images-amazon.com/images/I/61adKPKROWL._AC_SL1000_.jpg'),
(75, 1, 'earphones', 'https://images-na.ssl-images-amazon.com/images/I/71djnhmfy-L._AC_SL1500_.jpg'),
(76, 1, 'earphones', 'https://images-na.ssl-images-amazon.com/images/I/71NLN1HgFkL._AC_SL1500_.jpg'),
(77, 1, 'earphones', 'https://images-na.ssl-images-amazon.com/images/I/71djnhmfy-L._AC_SL1500_.jpg'),
(78, 1, 'earphones', 'https://images-na.ssl-images-amazon.com/images/I/71NTi82uBEL._AC_SL1500_.jpg'),
(79, 3, 'flashsales', 'https://images-na.ssl-images-amazon.com/images/I/81gbCMW-r-L._AC_SL1500_.jpg'),
(80, 3, 'flashsales', 'https://images-na.ssl-images-amazon.com/images/I/71Si0UcaD3L._AC_SL1500_.jpg'),
(81, 3, 'flashsales', 'https://images-na.ssl-images-amazon.com/images/I/81gbCMW-r-L._AC_SL1500_.jpg'),
(82, 3, 'flashsales', 'https://images-na.ssl-images-amazon.com/images/I/81C27pAidHL._AC_SL1500_.jpg'),
(83, 11, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/71mIBWZJirL._AC_SL1500_.jpg'),
(84, 11, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/71jeeY9g9KL._AC_SL1500_.jpg'),
(85, 11, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/71mIBWZJirL._AC_SL1500_.jpg'),
(86, 11, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/61MWZN6haPL._AC_SL1000_.jpg'),
(87, 28, 'laptops', 'https://images-na.ssl-images-amazon.com/images/I/710DS0KkyzL._AC_SL1500_.jpg'),
(88, 28, 'laptops', 'https://images-na.ssl-images-amazon.com/images/I/71izv25QKVL._AC_SL1500_.jpg'),
(89, 28, 'laptops', 'https://images-na.ssl-images-amazon.com/images/I/710DS0KkyzL._AC_SL1500_.jpg'),
(90, 28, 'laptops', 'https://images-na.ssl-images-amazon.com/images/I/71HCSwTMtrL._AC_SL1500_.jpg'),
(91, 1, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/71DGrIuMdDL._AC_SL1500_.jpg'),
(92, 1, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/814bF7Fq-WL._AC_SL1500_.jpg'),
(93, 1, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/51wthzFX1yL._AC_SL1500_.jpg'),
(94, 1, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/814bF7Fq-WL._AC_SL1500_.jpg'),
(95, 52, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/6155Fp7yaSL._AC_SL1500_.jpg'),
(96, 52, 'bestoffers', 'https://images-na.ssl-images-amazon.com/images/I/61stcFwi0vL._AC_SL1500_.jpg'),
(97, 52, 'bestoffers', 'https://m.media-amazon.com/images/G/08/img15/MarchEye/premiumaplus/FRFR_MacBookAir_Q121_Web_Marketing_Page_Large_1_01._CB413805220_.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `laptops`
--

DROP TABLE IF EXISTS `laptops`;
CREATE TABLE IF NOT EXISTS `laptops` (
  `category` varchar(300) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand` varchar(300) NOT NULL,
  `model` varchar(300) NOT NULL,
  `capacity` varchar(300) NOT NULL,
  `size` varchar(300) NOT NULL,
  `price` int(11) NOT NULL,
  `picture` tinytext NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `laptops`
--

INSERT INTO `laptops` (`category`, `id`, `brand`, `model`, `capacity`, `size`, `price`, `picture`, `description`) VALUES
('laptops', 28, 'Acer', 'Swift FT114-33', '128Go', '14in', 299, 'https://static.acer.com/up/Resource/Acer/Laptops/Swift_3/Image/20200430/Acer-Swift-3_SF314-42_FP_Backlit_Purple_modelmain.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris pretium egestas enim, ut ultrices odio consectetur ut. Duis bibendum eros arcu, nec posuere turpis lobortis at. Integer egestas nibh risus, a posuere libero finibus et. Vestibulum euismod, velit ut ultricies venenatis, nisi purus varius mi, id porta magna tellus in eros. Praesent sed semper nulla. Curabitur venenatis interdum augue et pharetra. Ut non sagittis tortor, nec commodo leo. Nullam non lobortis ligula. Donec ullamcorper ante eu urna dignissim, id lacinia tortor posuere. Cras eget interdum ante, non convallis nulla. Ut vulputate, odio eu tincidunt condimentum, mi dui ultricies turpis, nec volutpat mi ligula vel purus.\r\n\r\nSuspendisse bibendum maximus lorem vitae placerat. Nam vestibulum, libero id pellentesque blandit, lectus nisi vehicula tortor, ac tempus lacus diam vel ipsum. Nam nec enim eu nunc dictum eleifend. Praesent ultrices metus eget venenatis dapibus. Proin sit amet mattis eros. Nullam id odio condimentum, sollicitudin sem eget, tempor massa. Praesent non nulla massa. Aenean vitae odio sed nisl semper fermentum eleifend id leo. Integer magna eros, elementum sit amet iaculis in, blandit id ipsum. Nullam scelerisque odio sit amet luctus tempus. Nam laoreet est leo, sed molestie sem suscipit non. Integer condimentum nibh quis gravida tempus. Maecenas accumsan nulla vitae ligula auctor, ut convallis odio efficitur. Suspendisse quam nibh, dapibus at dictum in, blandit vel lectus.\r\n\r\nSed dictum est sed enim semper rhoncus in a nisi. Pellentesque mattis arcu non odio laoreet eleifend. Quisque auctor odio vitae velit porttitor venenatis. Nunc ultrices rutrum lectus et vehicula. Proin et felis ullamcorper orci pharetra dictum eu eget purus. Praesent luctus gravida tortor, eu faucibus turpis imperdiet et. Vestibulum iaculis felis elit, molestie mollis tellus tincidunt at. Morbi odio eros, maximus ut lobortis sed, cursus nec ex. Aliquam sem tortor, eleifend id tincidunt id, lacinia at sem. Mauris nunc turpis, mollis ac ante consectetur, elementum mollis ipsum. Suspendisse semper lacus magna, ut placerat diam porta et. Sed quis interdum dui, id pretium erat. Donec scelerisque purus ut tempus ullamcorper. Aenean in ultricies eros. Suspendisse fringilla, ligula et blandit pulvinar, leo tortor ultricies lacus, sit amet mattis purus orci ac risus. Suspendisse fringilla lectus eu pellentesque dignissim.');

-- --------------------------------------------------------

--
-- Structure de la table `offersonbestoffers`
--

DROP TABLE IF EXISTS `offersonbestoffers`;
CREATE TABLE IF NOT EXISTS `offersonbestoffers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sellerID` int(11) NOT NULL,
  `buyerID` int(11) NOT NULL,
  `offerID` int(11) NOT NULL,
  `startingprice` float NOT NULL,
  `sellernego` float NOT NULL,
  `buyernego` float NOT NULL,
  `attemptsleft` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `price` int(11) NOT NULL,
  `customerId` int(11) NOT NULL,
  `name` varchar(300) NOT NULL,
  `adress` varchar(500) NOT NULL,
  `orderdate` date NOT NULL,
  `shippingdate` date NOT NULL,
  `comment` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=83 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `price`, `customerId`, `name`, `adress`, `orderdate`, `shippingdate`, `comment`) VALUES
(1, 8142, 25, 'Morcillo', '12 rue des pauvres, PARIS, France', '2012-08-06', '2012-08-06', ''),
(20, 2185, 25, 'Morcillo', '12 rue des pauvres, PARIS, France', '2021-03-28', '2021-03-28', ''),
(19, 699, 25, 'Morcillo', '12 rue des pauvres, PARIS, France', '2021-03-28', '2021-03-28', ''),
(18, 1044, 25, 'Morcillo', '12 rue des pauvres, PARIS, France', '2021-03-28', '2021-03-28', ''),
(17, 6269, 25, 'Morcillo', '12 rue des pauvres, PARIS, France', '2021-03-28', '2021-03-28', ''),
(6, 728, 25, 'Morcillo', '12 rue des pauvres, PARIS, France', '2021-03-24', '2021-03-24', ''),
(7, 884, 2, 'Moquin', '12 rue des pauvres, PARIS, France', '2021-03-24', '2021-03-24', 'first door: 23A32B\r\nring at \'Bebew\''),
(8, 5788, 2, 'Moquin', '12 rue des pauvres, PARIS, France', '2021-03-24', '2021-03-24', ''),
(9, 5463, 2, 'Moquin', '23 avenue marchal, PARIS, France', '2021-03-24', '2021-03-24', ''),
(10, 884, 2, 'Moquin', '12 rue des pauvres, PARIS, France', '2021-03-24', '2021-03-24', ''),
(11, 699, 25, 'Morcillo', '12 rue des pauvres, PARIS, France', '2021-03-24', '2021-03-24', ''),
(12, 728, 3, 'Burah', '16 rue thÃ©odule ribot, PARIS, France', '2021-03-12', '2021-03-24', 'Fais bellek c\'est fragile'),
(13, 1044, 3, 'Burah', '16 rue thÃ©odule ribot, PARIS, France', '2021-03-24', '2021-03-24', ''),
(14, 728, 45, 'Burah', '13 rue de la ComÃ¨te, Paris, France', '2021-03-25', '2021-03-25', 'That was nice you bitch'),
(15, 13266, 45, 'Burah', '13 rue de la ComÃ¨te, Paris, France', '2021-03-25', '2021-03-25', ''),
(16, 2920, 25, 'Morcillo', '12 rue des pauvres, PARIS, France', '2021-03-25', '2021-03-25', ''),
(21, 2653, 25, 'Morcillo', '12 rue des pauvres, PARIS, France', '2021-03-28', '2021-03-28', ''),
(22, 6682, 2, 'Moquin', '23 avenue marchal, PARIS, France', '2021-03-28', '2021-03-28', ''),
(23, 6130, 25, 'Morcillo', '12 rue des pauvres, PARIS, France', '2021-03-28', '2021-03-28', ''),
(24, 2454, 25, 'Morcillo', '12 rue des pauvres, PARIS, France', '2021-03-29', '2021-03-29', ''),
(25, 2975, 25, 'Morcillo', '12 rue des pauvres, PARIS, France', '2021-03-29', '2021-03-29', ''),
(26, 5010, 25, 'Morcillo', '12 rue des pauvres, PARIS, France', '2021-03-29', '2021-03-29', ''),
(27, 4456, 25, 'Morcillo', '45 rue de la campagne, CAVAILLON, France', '2021-03-29', '2021-03-29', ''),
(28, 699, 25, 'Morcillo', '45 rue de la campagne, CAVAILLON, France', '2021-03-29', '2021-03-29', ''),
(29, 2099, 25, 'Morcillo', '12 rue des pauvres, PARIS, France', '2021-03-29', '2021-03-29', ''),
(30, 1044, 2, 'Moquin', '12 rue des pauvres, PARIS, France', '2021-03-29', '2021-03-29', ''),
(31, 735, 2, 'Moquin', '12 rue des pauvres, PARIS, France', '2021-03-29', '2021-03-29', ''),
(32, 554, 2, 'Moquin', '23 avenue marchal, PARIS, France', '2021-03-29', '2021-03-29', ''),
(33, 728, 2, 'Moquin', '23 avenue marchal, PARIS, France', '2021-03-29', '2021-03-29', ''),
(34, 1768, 2, 'Moquin', '12 rue des pauvres, PARIS, France', '2021-03-29', '2021-03-29', ''),
(35, 1044, 46, 'Morcillo', '12 rue des pauvres, CAVAILLON, France', '2021-03-29', '2021-03-29', ''),
(36, 1906, 46, 'Morcillo', '12 rue des pauvres, CAVAILLON, France', '2021-03-29', '2021-03-29', ''),
(37, 1044, 2, 'Moquin', '12 rue des pauvres, PARIS, France', '2021-03-29', '2021-03-29', ''),
(38, 2099, 2, 'Moquin', '12 rue des pauvres, PARIS, France', '2021-03-29', '2021-03-29', ''),
(39, 2914, 2, 'Moquin', '12 rue des pauvres, PARIS, France', '2021-03-29', '2021-03-29', ''),
(40, 2914, 2, 'Moquin', '23 avenue marchal, PARIS, France', '2021-03-29', '2021-03-29', ''),
(41, 699, 2, 'Moquin', '12 rue des pauvres, PARIS, France', '2021-03-29', '2021-03-29', ''),
(42, 3155, 2, 'Moquin', '12 rue des pauvres, PARIS, France', '2021-03-29', '2021-03-29', ''),
(43, 884, 2, 'Moquin', '23 avenue marchal, PARIS, France', '2021-03-29', '2021-03-29', ''),
(44, 3230, 2, 'Moquin', '23 avenue marchal, PARIS, France', '2021-03-29', '2021-03-29', ''),
(45, 884, 2, 'Moquin', '23 avenue marchal, PARIS, France', '2021-03-29', '2021-03-29', ''),
(46, 364, 2, 'Moquin', '23 avenue marchal, PARIS, France', '2021-03-29', '2021-03-29', ''),
(47, 699, 2, 'Moquin', '23 avenue marchal, PARIS, France', '2021-03-30', '2021-03-30', ''),
(48, 2185, 26, 'Cherrey', '12 rue des pauvres, PARIS, France', '2021-03-30', '2021-03-30', ''),
(49, 699, 26, 'Cherrey', '12 rue des pauvres, PARIS, France', '2021-03-30', '2021-03-30', ''),
(50, 364, 26, 'Cherrey', '12 rue des pauvres, PARIS, France', '2021-03-30', '2021-03-30', ''),
(51, 364, 26, 'Cherrey', '12 rue des pauvres, PARIS, France', '2021-03-30', '2021-03-30', ''),
(52, 884, 46, 'Morcillo', '12 rue des pauvres, CAVAILLON, France', '2021-03-30', '2021-03-30', ''),
(53, 884, 46, 'Morcillo', '12 rue des pauvres, CAVAILLON, France', '2021-03-30', '2021-03-30', ''),
(54, 699, 46, 'Morcillo', '12 rue des pauvres, CAVAILLON, France', '2021-03-30', '2021-03-30', ''),
(55, 884, 46, 'Morcillo', '12 rue des pauvres, CAVAILLON, France', '2021-03-30', '2021-03-30', ''),
(56, 0, 46, 'Morcillo', '12 rue des pauvres, CAVAILLON, France', '2021-03-30', '2021-03-30', ''),
(57, 884, 46, 'Morcillo', '12 rue des pauvres, CAVAILLON, France', '2021-03-30', '2021-03-30', ''),
(58, 699, 46, 'Morcillo', '12 rue des pauvres, CAVAILLON, France', '2021-03-30', '2021-03-30', ''),
(59, 884, 46, 'Morcillo', '12 rue des pauvres, CAVAILLON, France', '2021-03-30', '2021-03-30', ''),
(60, 884, 46, 'Morcillo', '12 rue des pauvres, CAVAILLON, France', '2021-03-30', '2021-03-30', ''),
(61, 1044, 46, 'Morcillo', '12 rue des pauvres, CAVAILLON, France', '2021-03-30', '2021-03-30', ''),
(62, 364, 46, 'Morcillo', '12 rue des pauvres, CAVAILLON, France', '2021-03-30', '2021-03-30', ''),
(63, 364, 46, 'Morcillo', '12 rue des pauvres, CAVAILLON, France', '2021-03-30', '2021-03-30', ''),
(64, 884, 46, 'Morcillo', '12 rue des pauvres, CAVAILLON, France', '2021-03-30', '2021-03-30', ''),
(65, 364, 46, 'Morcillo', '12 rue des pauvres, CAVAILLON, France', '2021-03-30', '2021-03-30', ''),
(66, 1044, 46, 'Morcillo', '12 rue des pauvres, CAVAILLON, France', '2021-03-30', '2021-03-30', ''),
(67, 364, 46, 'Morcillo', '12 rue des pauvres, CAVAILLON, France', '2021-03-30', '2021-03-30', ''),
(68, 699, 46, 'Morcillo', '12 rue des pauvres, CAVAILLON, France', '2021-03-30', '2021-03-30', ''),
(69, 1044, 38, 'Bizet', '12 rue des pauvres, PARIS, France', '2021-03-30', '2021-03-30', ''),
(70, 699, 38, 'Bizet', '12 rue des pauvres, PARIS, France', '2021-03-30', '2021-03-30', ''),
(71, 884, 38, 'Bizet', '12 rue des pauvres, PARIS, France', '2021-03-31', '2021-03-31', ''),
(72, 699, 51, 'Martin', '12 rue des pauvres, PARIS, France', '2021-04-02', '2021-04-02', ''),
(73, 2342, 51, 'Martin', '12 rue des pauvres, PARIS, France', '2021-04-03', '2021-04-03', ''),
(74, 735, 51, 'Martin', '12 rue des pauvres, PARIS, France', '2021-04-03', '2021-04-03', ''),
(75, 699, 51, 'Martin', '12 rue des pauvres, PARIS, France', '2021-04-03', '2021-04-03', ''),
(76, 1434, 51, 'Martin', '12 rue des pauvres, PARIS, France', '2021-04-03', '2021-04-03', ''),
(77, 1779, 51, 'Martin', '12 rue des pauvres, PARIS, France', '2021-04-03', '2021-04-03', ''),
(78, 735, 2, 'Moquin', '23 avenue marchal, PARIS, France', '2021-04-03', '2021-04-03', ''),
(79, 363, 46, 'Morcillo', '12 rue des pauvres, CAVAILLON, France', '2021-04-03', '2021-04-03', ''),
(80, 193, 46, 'Morcillo', '12 rue des pauvres, CAVAILLON, France', '2021-04-04', '2021-04-04', ''),
(81, 364, 2, 'Moquin', '12 rue des pauvres, PARIS, France', '2021-04-05', '2021-04-05', ''),
(82, 1044, 2, 'Moquin', '12 rue des pauvres, PARIS, France', '2021-04-05', '2021-04-05', '');

-- --------------------------------------------------------

--
-- Structure de la table `phones`
--

DROP TABLE IF EXISTS `phones`;
CREATE TABLE IF NOT EXISTS `phones` (
  `category` varchar(300) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand` varchar(300) NOT NULL,
  `model` varchar(300) NOT NULL,
  `capacity` varchar(300) NOT NULL,
  `size` varchar(300) NOT NULL,
  `price` float NOT NULL,
  `picture` tinytext NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `phones`
--

INSERT INTO `phones` (`category`, `id`, `brand`, `model`, `capacity`, `size`, `price`, `picture`, `description`) VALUES
('phones', 1, 'Samsung', 'Galaxy S10e', 'Battery capacity : 3100mAh', '6.1in', 299.99, 'https://static.fnac-static.com/multimedia/Images/FR/MDM/6e/9a/a6/10918510/1540-1/tsp20210205141117/Smartphone-Samsung-Galaxy-S10-Double-SIM-128-Go-Blanc-Prisme.jpg', 'The Samsung Galaxy S10 is Samsung\'s flagship for 2019. It is equipped with a Samsung Exynos 9820 SoC engraved in 8 nm, a triple sensor and a new borderless screen with the camera housed in a bubble.The Samsung Galaxy S10 is the new flagship of the Korean manufacturer, equipped with a 6.1-inch Quad HD + Super Amoled screen with an integrated ultrasonic sensor. It embeds the latest in-house processor, the Exynos 9820 (8 cores at 2.7 GHz) with 8 GB of RAM and 128 GB of storage (a 512 GB also exists). On the photo side, there is a triple camera module.'),
('phones', 13, 'Apple', 'Iphone 12', '128go', '6.1in', 727.95, 'https://d1eh9yux7w8iql.cloudfront.net/product_images/None_063e783d-f518-4e74-9a0d-4e63f45c798c.jpg', 'Performance and autonomy: a new peak for Apple ... and for the smartphone world\r\nLess energy, more power ...\r\n\r\nDual 12 MP cameras: ultra wide-angle and wide-angle\r\nUltra wide-angle: 2.4 aperture and 120 field of view\r\nWide-angle: 1.8 aperture\r\n2x optical zoom out\r\nDigital zoom up to 5x\r\nPortrait mode with advanced bokeh effect and Depth control\r\nPortrait lighting with six effects (Natural, Studio, Outline, Stage, Stage mono, High-key mono)\r\nOptical image stabilization (wide angle)\r\nFive element lens (ultra wide angle); six-element lens (wide-angle)\r\nBrighter True Tone Flash with Slow Sync\r\nPanoramic (up to 63 Mpx)\r\nSapphire crystal lens protection\r\n100% Focus Pixels (wide-angle)\r\nNight mode (wide-angle)\r\nDeep Fusion (wide-angle)\r\nNext-generation Smart HDR for stills\r\nWide Color Gamut Photos and Live Photos\r\nAdvanced red-eye correction\r\nAutomatic image stabilization\r\nBurst Mode\r\nGeoreferencing photos\r\nAvailable image formats: HEIF and JPEG\r\nVideo recording\r\n4K video recording at 24, 25, 30 or 60 fps\r\n1080p HD video recording at 25, 30 or 60 fps\r\n720p HD video recording at 30 fps\r\nExtended dynamic range for video up to 60 fps\r\nOptical image stabilization for video (wide-angle)\r\n2x optical zoom out\r\nDigital zoom up to 3x\r\nAudio zoom\r\nBrighter True Tone Flash\r\nQuickTake Video\r\nSupports slow motion in 1080p at 120 or 240 fps\r\nAccelerated with stabilization\r\nCinema-quality video stabilization (4K, 1080p and 720p)\r\nContinuous autofocus\r\nCapture 8 MP photos during 4K video recording\r\nReading zoom\r\nAvailable video formats: HEVC and H.264\r\nStereo recording. Officially, the iPhone 11 Pro can last 4 hours longer than the iPhone XS before collapsing from fatigue. In fact, you can use it for almost two full days with standard usage. The iPhone XR had started the movement, the iPhone 11 Pro confirms it: Apple is back on track in terms of battery life.\r\n\r\nRegarding the charging time, count 1:47 to refuel. It\'s better than the XS Max (3:17), but it\'s still a lot when compared to Android smartphones, like a Huawei P30 Pro for example (53 minutes) or a Samsung Galaxy S10 (1h20).'),
('phones', 12, 'Apple', 'IPhone 11', '64Go', '6.1in', 575.99, 'https://www.carrefour.fr/media/540x540/Photosite/EPCS/RADIOTELEPHONIE/0190199221246_PHOTOSITE_20191128_120510_0.jpg', 'Performance and autonomy: a new peak for Apple ... and for the smartphone world\r\nLess energy, more power ...\r\nAfter the A12 Bionic from the iPhone XR, Apple is breaking new ground with a new chip. Here comes the A13 Bionic! What does that imply? Well mainly greater energy efficiency and better performance in demanding applications, like video games.\r\n\r\nFor everyday use, however, the difference from the previous generation (iPhone XS, XS Max and iPhone XR) is not striking. But we have to admit that it was difficult to do better. No matter what task (or tasks) you ask, the iPhone 11 Pro keeps everything running smoothly. If you are looking for the best smartphone on the planet when it comes to power, as of the date of this test, no need to look any further. The iPhone 11 Pro Max is equipped with the same chip.'),
('phones', 14, 'Samsung', 'Galaxy S21+', '256Go', '6.1in', 859.99, 'https://images.samsung.com/is/image/samsung/p6pim/fr/galaxy-s21/gallery/fr-galaxy-s21-ultra-5g-g988-sm-g998bztgeuh-thumb-369048388', 'The Samsung Galaxy S21 is the flagship of the brand, succeeding the S20 range. It is equipped with an Exynos 2100 SoC (engraved in 5 nm), a 4000 mAh battery and 3 photo sensors: the main one at 12 megapixels, a 12 megapixel sensor and a 64 megapixel telephoto lens.The Samsung Galaxy S21 is a high-end smartphone with a 6.2-inch screen with a refresh rate of 120 Hz. This device is intended for people who seek an elegant design even if it is regrettable that its back is covered with plastic rather than glass. It embeds the Exynos 2100 processor and sports a triple camera module identical to that of its predecessor.');

-- --------------------------------------------------------

--
-- Structure de la table `sellerprofiles`
--

DROP TABLE IF EXISTS `sellerprofiles`;
CREATE TABLE IF NOT EXISTS `sellerprofiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sellerID` int(11) NOT NULL,
  `backgroundindex` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `sellerprofiles`
--

INSERT INTO `sellerprofiles` (`id`, `sellerID`, `backgroundindex`) VALUES
(1, 2, 4),
(2, 3, 2),
(3, 26, 3),
(4, 46, 4),
(5, 5, 3),
(6, 49, 3),
(7, 6, 4),
(8, 50, 2),
(9, 51, 8),
(10, 51, 8),
(11, 52, 2),
(12, 52, 2),
(13, 53, 2);

-- --------------------------------------------------------

--
-- Structure de la table `tablets`
--

DROP TABLE IF EXISTS `tablets`;
CREATE TABLE IF NOT EXISTS `tablets` (
  `category` varchar(300) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand` varchar(300) NOT NULL,
  `model` varchar(300) NOT NULL,
  `capacity` varchar(300) NOT NULL,
  `size` varchar(300) NOT NULL,
  `price` int(11) NOT NULL,
  `picture` tinytext NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tablets`
--

INSERT INTO `tablets` (`category`, `id`, `brand`, `model`, `capacity`, `size`, `price`, `picture`, `description`) VALUES
('tablets', 1, 'Microsoft', 'Surface Pro 7', '256Go', '12.3in', 1569, 'https://dyw7ncnq1en5l.cloudfront.net/optim/product/54/54239/d097aa25-surface-pro-7__450_400.jpeg', ''),
('tablets', 15, 'Lenovo ', 'TAB M10 10HD', '16Go', '10in', 159, 'https://images-na.ssl-images-amazon.com/images/I/81GNqsU7C6L._AC_SL1500_.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean vehicula mi eu nisi tempus pretium. In efficitur tellus vel est aliquet, ultricies molestie neque congue. Morbi eu sapien est. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nunc vitae venenatis mi, quis vulputate tortor. Pellentesque sit amet est turpis. Ut lorem nulla, hendrerit at magna et, iaculis malesuada elit. Curabitur ut erat convallis, placerat tortor eu, luctus lacus. Nullam laoreet, felis nec blandit convallis, nisi felis interdum nunc, eget sagittis orci neque et tortor. Fusce convallis dolor non sem scelerisque, nec suscipit felis mattis.\r\n\r\nVestibulum rhoncus lobortis ante vel ultrices. Curabitur nec mauris ullamcorper, sodales turpis vel, dictum tortor. Fusce et laoreet ligula. Aenean imperdiet, sapien eu molestie porttitor, tortor lorem feugiat nisi, at aliquet mi massa nec purus. In eu lacinia magna. Integer pellentesque nulla ultricies, congue nisi sit amet, iaculis nisi. Ut ipsum diam, mattis sed porta eu, volutpat sit amet massa.');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(300) NOT NULL,
  `lastname` varchar(300) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `isbuyer` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `isbuyer`) VALUES
(2, 'Paul', 'Moquin', 'paul.moquin@edu.ece.fr', '$2y$10$KHE88cJxo59ZN2ldHepcju9VhwCV1b9yYR.4BsIPMixNDDxg9ul.O', 1),
(3, 'Ulysse', 'Burah', 'ulysse.burah@edu.ece.fr', '$2y$10$lvKU4ZMeCXz2hYyHTTQIjeDOkh6f3zK6D.kUy5GnQlFu3qmIB6fse', 1),
(26, 'Apolline', 'Cherrey', 'apolline.cherrey@edu.ece.fr', '$2y$10$k0Rpy3bwwH5BqZaRiNGLQOOaC5p2S3un/CTMwTvSgnCNKwLMIjPxe', 1),
(5, 'Hugo', 'Demeure', 'hugo.demeure@edu.ece.fr', '$2y$10$eK0ZGFOqmO1Hz96g826l3.3y/z4O.mMB9ACgzpWX6aGYuKQEhBnGG', 1),
(6, 'Sophie', 'Giry', 'sophie.giry@edu.ece.fr', '$2y$10$vu.fuFo2kop2sUau.yloRuAu6cmVI.8cGJGbvOcBMZDj0IaYJK9Ga', 1),
(51, 'Hubert', 'Martin', 'hubert.martin@edu.ece.fr', '$2y$10$41N8kiadE2Bo5DustJTi8eZemSHdhDQ3EZC0tFI3m4m5J.xa/Uqiu', 1),
(48, 'THIERRY', 'MORCILLO', 'a@a', '$2y$10$oitDniS.0cZKvFyD3mjK.O3I1IAJoLKY0Jg6fIomIoU1zGqOHsk4K', 1),
(23, 'Benjamin', 'Laurent', 'benjamin.laurent@edu.ece.fr', '$2y$10$AHRjJaLobwBt06vUCt168ugZJOPyigiNeStBWAJEsjnup840E6dZG', 1),
(46, 'Eliott', 'Morcillo', 'eliott.morcillo@gmail.com', '$2y$10$gSGWmYjkAn89QNtr52NJ0O/MPd.f.t9MOJjpg3JtQo25zRshYvcWO', 1),
(52, 'Anthony', 'Martial', 'antho.martial@edu.ece.fr', '$2y$10$3mGVa.t7B505lNvuMKAUDuQNZw/RpgZKb1QCrxbfKnuHDbFbqn1wq', 1),
(38, 'Lou', 'Bizet', 'lou.bizet@edu.ece.fr', '$2y$10$5lEhOOypc31ct.vR60MheOOwQf9T842MPuqD6E2XQBwFigEgSGf.a', 0),
(50, 'Victor', 'Martien', 'victor.martien@edu.ece.fr', '$2y$10$VOGkG.mYrYHKOJ0URoWzlOf1UbiebUICJpBJqo.57KsAIW7LWeGRK', 0),
(49, 'THIERRY', 'MORCILLO', 'aza@aza', '$2y$10$.8lb9jyRtmHwb0nF11yW6eKRPKuGpFHaYPKyu3hKvloFfWxof625S', 1),
(41, 'ZoÃ©', 'Machin', 'zoe@edu.fr', '$2y$10$dsdli3er7HNyrhmZZKgxpOpMdgTCPvmfMZphFVxsNCEexAFzypTFi', 0),
(53, 'Apolline', 'Cherrey', 'apolline.cherrey@gmail.com', '$2y$10$TXh4mw.n2RbvWQ4Op1wonOBycBY4YXNdB4utIvLzACeXl0bNf5lDa', 1),
(45, 'Ulysse', 'Burah', 'ulysse.burah@eliott', '$2y$10$T1VjN4BxebPHjjuy3Z63R.r0MzD6fS61fpmD7w5a8iuGLgl92L9TG', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
