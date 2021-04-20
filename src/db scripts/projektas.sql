-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2021 at 10:23 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projektas`
--

-- --------------------------------------------------------

--
-- Table structure for table `komandos`
--

CREATE TABLE `komandos` (
  `Projekto_id` int(11) NOT NULL,
  `Role` int(11) NOT NULL,
  `Vartotojas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projektai`
--

CREATE TABLE `projektai` (
  `Projekto_id` int(11) NOT NULL,
  `Pavadinimas` varchar(255) COLLATE utf16_lithuanian_ci NOT NULL,
  `Aprasymas` text COLLATE utf16_lithuanian_ci NOT NULL,
  `Vartotojai` varchar(255) COLLATE utf16_lithuanian_ci DEFAULT NULL,
  `Busena` varchar(255) COLLATE utf16_lithuanian_ci NOT NULL,
  `Sukurimo_data` date NOT NULL,
  `Visos_uzduotys` int(11) NOT NULL,
  `Neatliktos_uzduotys` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_lithuanian_ci;

--
-- Dumping data for table `projektai`
--

INSERT INTO `projektai` (`Projekto_id`, `Pavadinimas`, `Aprasymas`, `Vartotojai`, `Busena`, `Sukurimo_data`, `Visos_uzduotys`, `Neatliktos_uzduotys`) VALUES
(1, 'Android Calendar', 'Basic but modern calendar', NULL, 'In progress', '2021-04-19', 5, 2),
(2, 'Platform for Gamers', 'Buy and download video games, etc.', NULL, 'To Do', '2021-02-14', 12, 12),
(3, 'Mood diary', 'mood, thoughts diary with image upload option ', NULL, 'Done', '2020-05-25', 34, 0);

-- --------------------------------------------------------

--
-- Table structure for table `projektu_uzduotys`
--

CREATE TABLE `projektu_uzduotys` (
  `Projekto_id` int(11) NOT NULL,
  `Uzduoties_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `Roles_id` int(11) NOT NULL,
  `Pavadinimas` varchar(255) COLLATE utf16_lithuanian_ci NOT NULL,
  `Aprasymas` varchar(255) COLLATE utf16_lithuanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `uzduotys`
--

CREATE TABLE `uzduotys` (
  `Uzduoties_id` int(11) NOT NULL,
  `Pavadinimas` varchar(255) COLLATE utf16_lithuanian_ci NOT NULL,
  `Aprasymas` varchar(255) COLLATE utf16_lithuanian_ci NOT NULL,
  `Prioritetas` varchar(255) COLLATE utf16_lithuanian_ci NOT NULL,
  `Busena` varchar(255) COLLATE utf16_lithuanian_ci NOT NULL,
  `Sukurimo_data` date NOT NULL,
  `Naujinimo_data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vartotojai`
--

CREATE TABLE `vartotojai` (
  `El_pastas` varchar(255) COLLATE utf16_lithuanian_ci NOT NULL,
  `Slaptazodis` varchar(64) COLLATE utf16_lithuanian_ci NOT NULL,
  `Vardas` varchar(255) COLLATE utf16_lithuanian_ci NOT NULL,
  `Pavarde` varchar(255) COLLATE utf16_lithuanian_ci NOT NULL,
  `Vartotojo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_lithuanian_ci;

--
-- Dumping data for table `vartotojai`
--

INSERT INTO `vartotojai` (`El_pastas`, `Slaptazodis`, `Vardas`, `Pavarde`, `Vartotojo_id`) VALUES
('labas@labas.lt', 'Labas1234', 'labas', 'labius', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `komandos`
--
ALTER TABLE `komandos`
  ADD KEY `Komandos_fk0` (`Projekto_id`),
  ADD KEY `Komandos_fk1` (`Role`),
  ADD KEY `Komandos_fk2` (`Vartotojas`);

--
-- Indexes for table `projektai`
--
ALTER TABLE `projektai`
  ADD PRIMARY KEY (`Projekto_id`);

--
-- Indexes for table `projektu_uzduotys`
--
ALTER TABLE `projektu_uzduotys`
  ADD KEY `Projektu_uzduotys_fk0` (`Projekto_id`),
  ADD KEY `Projektu_uzduotys_fk1` (`Uzduoties_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`Roles_id`);

--
-- Indexes for table `uzduotys`
--
ALTER TABLE `uzduotys`
  ADD PRIMARY KEY (`Uzduoties_id`);

--
-- Indexes for table `vartotojai`
--
ALTER TABLE `vartotojai`
  ADD PRIMARY KEY (`Vartotojo_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `komandos`
--
ALTER TABLE `komandos`
  ADD CONSTRAINT `Komandos_fk0` FOREIGN KEY (`Projekto_id`) REFERENCES `projektai` (`Projekto_id`),
  ADD CONSTRAINT `Komandos_fk1` FOREIGN KEY (`Role`) REFERENCES `roles` (`Roles_id`),
  ADD CONSTRAINT `Komandos_fk2` FOREIGN KEY (`Vartotojas`) REFERENCES `vartotojai` (`Vartotojo_id`);

--
-- Constraints for table `projektu_uzduotys`
--
ALTER TABLE `projektu_uzduotys`
  ADD CONSTRAINT `Projektu_uzduotys_fk0` FOREIGN KEY (`Projekto_id`) REFERENCES `projektai` (`Projekto_id`),
  ADD CONSTRAINT `Projektu_uzduotys_fk1` FOREIGN KEY (`Uzduoties_id`) REFERENCES `uzduotys` (`Uzduoties_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
