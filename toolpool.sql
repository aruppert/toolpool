-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 10, 2020 at 12:28 PM
-- Server version: 5.7.26
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toolpool`
--
CREATE DATABASE IF NOT EXISTS `toolpool` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `toolpool`;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(5) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `description`) VALUES
(1, 'General', 'Alles was in mehrere Kategorien oder keine passt.'),
(2, 'Garten', 'Alles rund um dein grünes Paradies.'),
(3, 'Bauen', 'Alles run um den Bau.');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id` int(5) UNSIGNED ZEROFILL NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `district` varchar(50) NOT NULL,
  `street` varchar(75) DEFAULT NULL,
  `zip_code` int(5) UNSIGNED DEFAULT NULL,
  `city` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `gender` enum('M','F','D','') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id`, `last_name`, `first_name`, `district`, `street`, `zip_code`, `city`, `email`, `password`, `gender`) VALUES
(00001, 'Segura', 'Tommy', 'Poll', 'Am Hof 5', 51105, 'Köln', 'ts@mail.de', '$2y$10$d0wkmyKYxjQZxJ3Sv0rgdeo93Y.5BlXMCrwWatsOq3wAI3j02a6tm', 'M'),
(00002, 'Franklin', 'Tasha', 'Poll', 'Feldstr. 11', 51105, 'Köln', 'ft@mail.de', '$2y$10$0PSKsJAgXCxaZh/NQhXyX.56j7O.cZVTyTv3UGaxkEnBBtN65djFm', 'F'),
(00003, 'Mundo', 'Rodriguez', 'Poll', 'Rainbowstr. 69', 51105, 'Köln', 'mr@mail.de', '$2y$10$XwsMXSsjx7TEVh7gKl/AdOImTP/LJLgXMgI3dqv6OMcu/qAAkfCs2', 'D'),
(00004, 'Müller', 'Maria', 'Deutz', 'Holzweg 92', 50679, 'Köln', 'mm@mail.de', '$2y$10$znQPvTZrOQVS17WMw4n1pOzHIMpFxeC/mAnx1Fg43nvn1n3wo7Ire', 'F'),
(00005, 'Vogel', 'Hans', 'Deutz', 'Niemalsland 66', 50679, 'Köln', 'hv@mail.de', '$2y$10$.O7/t1ceKCdh5qdpO8FCMOfitahfi757y0Y2LmyrTOUipjt9NfvaO', 'M'),
(00006, 'Motte', 'Holly', 'Deutz', 'Glashaus 3', 50679, 'Köln', 'hm@mail.de', '$2y$10$VCkzj88jN7xf4CB6p4oVsOVRAKM.xz7c9AmmsSW5gGeIdfhFO58Fa', 'F');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` tinyint(1) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `name`, `description`) VALUES
(0, 'Ausgeliehen', 'Tool wird gerade von anderem Pooler benutzt'),
(1, 'Verfügbar', 'Funktionsfähig und vorhanden. Kann ausgeliehen werden'),
(5, 'Defekt', 'Tool defekt'),
(6, 'In Reparatur/Wartung', 'Tool wird gerade repariert oder gewartet');

-- --------------------------------------------------------

--
-- Table structure for table `tool`
--

CREATE TABLE `tool` (
  `id` int(5) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(750) DEFAULT NULL,
  `status_id` tinyint(1) UNSIGNED NOT NULL,
  `picture` varchar(150) DEFAULT NULL,
  `link` varchar(450) DEFAULT NULL,
  `requirements` varchar(500) DEFAULT NULL,
  `year` int(4) UNSIGNED DEFAULT NULL,
  `category_id` int(5) UNSIGNED NOT NULL,
  `owner_id` int(5) UNSIGNED ZEROFILL NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tool`
--

INSERT INTO `tool` (`id`, `name`, `description`, `status_id`, `picture`, `link`, `requirements`, `year`, `category_id`, `owner_id`) VALUES
(1, 'Laserentfernungsmesser', 'Messbereich: 0,05 - 50 m, Bluetooth 4.0, ± 2 mm (Entfernung)\r\n\r\n    Messentfernung bis 50 m\r\n    Tochscreen für einfachste Bedienung\r\n    Bluetooth-Funktion zum Übertragen der Ergebnisse an Tablet oder Smartphone\r\n    Längen, Flächen und Volumen messbar\r\n    Apps in App Store und Play Store erhältlich\r\n\r\n', 1, '1.jpg', 'https://www.bauhaus.info/entfernungsmesser/bosch-laserentfernungsmesser-plr-50-c/p/23038877', '2AA', 2020, 1, 00004),
(2, 'Schlagbohrmaschine', '900 W, Leerlaufdrehzahl: 50 U/min - 2.850 U/min\r\n\r\n    900 W-Motor mit Bosch Constant Electronic für konstante Drehzahl unter starker Belastung\r\n    2-Gang-Getriebe bietet hohes Drehmoment im 1. Gang und eine hohe Drehzahl im 2.Gang\r\n    Eignet sich zum Bearbeiten von Holz, Metall, Stahl und Beton\r\n    Dauerlauf-Funktion für ausdauernden Betrieb\r\n    Bosch Kickback Control schaltet Gerät bei Blockierung ab\r\n\r\n', 1, '2.jpg', 'https://www.bauhaus.info/bohrmaschinen/bosch-schlagbohrmaschine-advancedimpact-900/p/25453555', '230V', 2019, 1, 00006),
(3, 'Werkzeugkoffer Professional ', '160-tlg., Steckschlüsselsatz: ½ + ¼″\r\n\r\n    Umfangreiche Ausstattung für Heimwerker und Handwerker\r\n    Zahlreiche Werkzeuge für breites Anwendungsspektrum\r\n    Hohe Qualität der enthaltenen Einzelteile\r\n    Übersichtliche Aufbewahrung mit eigenem Platz für jedes Teil\r\n    Robuster Koffer mit stabilen Verschlüssen\r\n\r\n', 0, '3.jpg', 'https://www.bauhaus.info/werkzeugkoffer/wisent-werkzeugkoffer-professional/p/20323954', NULL, 2018, 1, 00003),
(4, 'Hybrid-Rasenmäher ', '\r\n\r\n18 V, Li-Ionen, 2,5 Ah, 2 Akkus, Schnittbreite: 34 cm\r\n\r\n    Hybrid-Gerät: Betrieb mit Akku oder Kabel möglich\r\n    Zuverlässiger Antrieb durch 2 ONE+ 18 V Li-Ionen Akku mit jeweils 2,5 Ah\r\n    Ideal für Rasenflächen bis zu 400 m²\r\n    Zentrale Schnitthöhenverstellung in 5 Stufen von 20 bis 70 mm\r\n    Vertebrae-Komforthandgriff für hohen Komfort und gute Ergonomie\r\n\r\n', 1, '4.jpg', 'https://www.bauhaus.info/elektro-rasenmaeher/ryobi-hybrid-rasenmaeher-rlm18c36h225f/p/25619409', '230 V, Kabeltrommel', 2018, 2, 00005),
(5, 'Poolreiniger', 'Geeignet für: Pools\r\n\r\n    Optimale Reinigung\r\n    Extra großer Reinigungskopf\r\n    Leichtes Handling\r\n    Auswaschbarer Filtersack', 1, '5.jpg', 'https://www.bauhaus.info/poolsauger/mypool-poolreiniger-pool-blaster-centennial/p/24514228?adb_search=pool', '', 2016, 2, 00001),
(6, 'Handkreissäge', '1.050 W, Sägeblatt: Ø 165 mm, Leerlaufdrehzahl: 0 U/min - 5.200 U/min\r\n\r\n    Handlich und kompakt\r\n    Integrierter Sägeblattschutz\r\n    Schnittanzeige von 0° bis 45°\r\n    Schnittplatte aus Aluminium-Druckguss\r\n    Inklusive Parallelanschlag\r\n\r\n', 1, '6.jpg', 'https://www.bauhaus.info/handkreissaegen/makita-handkreissaege-hs6601j/p/26054128', '230V', 2019, 1, 00002),
(7, 'Luftentfeuchter', '400 W, Entfeuchtungsleistung: 20 l/Tag, L x B x H: 26,2 x 26,2 x 59 cm, Rollen\r\n\r\n    Anzeige der Luftfeuchtigkeit per Lichtindikator\r\n    Beugt Schimmelbildung vor\r\n    24 h Timer\r\n    Mit Laufrollen und Tragegriff\r\n    Abnehmbarer Wassertank', 6, '7.jpg', 'https://www.bauhaus.info/luftentfeuchter/proklima-luftentfeuchter/p/26500171?adb_search=luftent', '230V', 2019, 3, 00005),
(8, 'Vertikutierer (Benzin)', '1,3 kW, Arbeitsbreite: Lüfterwalze 37 cm\r\n\r\n    Ausgestattet mit 1,3 kW (entspricht ca. 1,69 PS) starkem Benzin-Motor\r\n    Praktische 3 in 1 Funktion\r\n    Inklusive Lüfterwalze\r\n\r\n', 1, '8.jpg', 'https://www.bauhaus.info/vertikutierer-rasenluefter/al-ko-benzin-vertikutierer/p/21089426', 'Benzin', 2020, 2, 00001),
(9, 'Zementmischer', 'Durchmesser Rührer: 140 mm, Aufnahme: M14, 1.300 W\r\n\r\n    Drehzahl elektronisch regulierbar\r\n    Robuster Handgriff\r\n    Integrierter Wieder-Einschalt-Schutz\r\n    Für Rühr- und Mischarbeiten \r\n\r\n', 0, '9.jpg', 'https://www.bauhaus.info/ruehrwerke/makita-farb-moertelruehrer-ut1400/p/26205801', '230V', 2018, 3, 00001),
(10, 'Rüttelplatte ', 'Motorleistung: 4,8 kW, Verdichtungsdruck: 1.500 kg\r\n\r\n    Vielseitig einsetzbare Rüttelplatte mit Grundplatte aus hochfestem Stahl\r\n    In Verbindung mit beiliegender Gummimatte selbst für die Verdichtung von Pflastersteinen geeignet\r\n    Schneller Arbeitsfortschritt dank hoher Vorlaufgeschwindigkeit von 25 m/min\r\n    Leistungsstarker 4-Takt-Benzinmotor mit 4,8 kW (≙ 6,5 PS)\r\n    Wendige Maschinenführung durch praktische Fahrvorrichtung\r\n\r\n', 1, '10.jpg', 'https://www.bauhaus.info/ruettelplatten-vibrationsstampfer/herkules-ruettelplatte-rp1200/p/27431900', 'Benzin', 2019, 3, 00003),
(11, 'Bauschubkarre', 'Fassungsvermögen: 100 l, Material Wanne: Stahl\r\n\r\n    Verzinkte Tiefbettmulde\r\n    Sehr stabiler Stahlrahmen\r\n    Luftrad mit massiver Achse\r\n    Muldenrand doppelt gebördelt\r\n\r\n', 1, '11.jpg', 'https://www.bauhaus.info/schubkarren/bauschubkarre-ts100-kt/p/20157445', NULL, 2015, 3, 00003),
(12, 'Akku-Heckenschere', '60 V, Li-Ionen, Ohne Akku, Schnittlänge: 58 cm\r\n\r\n    Kraftvolle Heckenschere für stark verholzte Hecken\r\n    27 mm Schnittstärke\r\n    Leistungsstarker bürstenloser Motor\r\n    Lasergeschnitten und -geschliffen für beste Messerqualität\r\n    Zufriedenheitsgarantie für alle POWERWORKS Geräte oder Geld zurück', 1, '12.jpg', 'https://www.bauhaus.info/akku-heckenscheren/powerworks-akku-heckenschere-pd60ht/p/25674745', '', 2018, 2, 00006);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tool`
--
ALTER TABLE `tool`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id` (`owner_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `status_id` (`status_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tool`
--
ALTER TABLE `tool`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tool`
--
ALTER TABLE `tool`
  ADD CONSTRAINT `tool_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `member` (`id`),
  ADD CONSTRAINT `tool_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `tool_ibfk_3` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
