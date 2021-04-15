-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost_db:3306
-- Generation Time: Apr 15, 2021 at 08:34 AM
-- Server version: 10.3.27-MariaDB-1:10.3.27+maria~focal
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `task_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `Komandos`
--

CREATE TABLE `Komandos` (
  `Projekto_id` int(11) NOT NULL,
  `Role` int(11) NOT NULL,
  `Vartotojas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Projektai`
--

CREATE TABLE `Projektai` (
  `Projekto_id` int(11) NOT NULL,
  `Pavadinimas` varchar(255) COLLATE utf16_lithuanian_ci NOT NULL,
  `Aprasymas` text COLLATE utf16_lithuanian_ci NOT NULL,
  `Busena` varchar(255) COLLATE utf16_lithuanian_ci NOT NULL,
  `Sukurimo_data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Projektu_uzduotys`
--

CREATE TABLE `Projektu_uzduotys` (
  `Projekto_id` int(11) NOT NULL,
  `Uzduoties_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Roles`
--

CREATE TABLE `Roles` (
  `Roles_id` int(11) NOT NULL,
  `Pavadinimas` varchar(255) COLLATE utf16_lithuanian_ci NOT NULL,
  `Aprasymas` varchar(255) COLLATE utf16_lithuanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Uzduotys`
--

CREATE TABLE `Uzduotys` (
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
-- Table structure for table `Vartotojai`
--

CREATE TABLE `Vartotojai` (
  `El_pastas` varchar(255) COLLATE utf16_lithuanian_ci NOT NULL,
  `Slaptazodis` varchar(64) COLLATE utf16_lithuanian_ci NOT NULL,
  `Vardas` varchar(255) COLLATE utf16_lithuanian_ci NOT NULL,
  `Pavarde` varchar(255) COLLATE utf16_lithuanian_ci NOT NULL,
  `Vartotojo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_lithuanian_ci;

--
-- Dumping data for table `Vartotojai`
--

INSERT INTO `Vartotojai` (`El_pastas`, `Slaptazodis`, `Vardas`, `Pavarde`, `Vartotojo_id`) VALUES
('labas@labas.lt', 'Labas1234', 'labas', 'labius', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Komandos`
--
ALTER TABLE `Komandos`
  ADD KEY `Komandos_fk0` (`Projekto_id`),
  ADD KEY `Komandos_fk1` (`Role`),
  ADD KEY `Komandos_fk2` (`Vartotojas`);

--
-- Indexes for table `Projektai`
--
ALTER TABLE `Projektai`
  ADD PRIMARY KEY (`Projekto_id`);

--
-- Indexes for table `Projektu_uzduotys`
--
ALTER TABLE `Projektu_uzduotys`
  ADD KEY `Projektu_uzduotys_fk0` (`Projekto_id`),
  ADD KEY `Projektu_uzduotys_fk1` (`Uzduoties_id`);

--
-- Indexes for table `Roles`
--
ALTER TABLE `Roles`
  ADD PRIMARY KEY (`Roles_id`);

--
-- Indexes for table `Uzduotys`
--
ALTER TABLE `Uzduotys`
  ADD PRIMARY KEY (`Uzduoties_id`);

--
-- Indexes for table `Vartotojai`
--
ALTER TABLE `Vartotojai`
  ADD PRIMARY KEY (`Vartotojo_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Komandos`
--
ALTER TABLE `Komandos`
  ADD CONSTRAINT `Komandos_fk0` FOREIGN KEY (`Projekto_id`) REFERENCES `Projektai` (`Projekto_id`),
  ADD CONSTRAINT `Komandos_fk1` FOREIGN KEY (`Role`) REFERENCES `Roles` (`Roles_id`),
  ADD CONSTRAINT `Komandos_fk2` FOREIGN KEY (`Vartotojas`) REFERENCES `Vartotojai` (`Vartotojo_id`);

--
-- Constraints for table `Projektu_uzduotys`
--
ALTER TABLE `Projektu_uzduotys`
  ADD CONSTRAINT `Projektu_uzduotys_fk0` FOREIGN KEY (`Projekto_id`) REFERENCES `Projektai` (`Projekto_id`),
  ADD CONSTRAINT `Projektu_uzduotys_fk1` FOREIGN KEY (`Uzduoties_id`) REFERENCES `Uzduotys` (`Uzduoties_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
