-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2021 m. Bal 25 d. 22:56
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

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
-- Sukurta duomenų struktūra lentelei `komandos`
--

CREATE TABLE `komandos` (
  `Projekto_id` int(11) NOT NULL,
  `Role` int(11) NOT NULL,
  `Vartotojas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_lithuanian_ci;

--
-- Sukurta duomenų kopija lentelei `komandos`
--

INSERT INTO `komandos` (`Projekto_id`, `Role`, `Vartotojas`) VALUES
(123, 1, 22),
(1234, 1, 1);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `projektai`
--

CREATE TABLE `projektai` (
  `Projekto_id` int(11) NOT NULL,
  `Pavadinimas` varchar(255) COLLATE utf32_lithuanian_ci NOT NULL,
  `Aprasymas` text COLLATE utf32_lithuanian_ci NOT NULL,
  `Busena` varchar(255) COLLATE utf32_lithuanian_ci NOT NULL,
  `Sukurimo_data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_lithuanian_ci;

--
-- Sukurta duomenų kopija lentelei `projektai`
--

INSERT INTO `projektai` (`Projekto_id`, `Pavadinimas`, `Aprasymas`, `Busena`, `Sukurimo_data`) VALUES
(123, 'Project system', 'Manage projects', 'In progress', '2021-04-25'),
(1234, 'Task system', 'Manage tasks', 'In progress', '2021-04-25');

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `projektu_uzduotys`
--

CREATE TABLE `projektu_uzduotys` (
  `Projekto_id` int(11) NOT NULL,
  `Uzduoties_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_lithuanian_ci;

--
-- Sukurta duomenų kopija lentelei `projektu_uzduotys`
--

INSERT INTO `projektu_uzduotys` (`Projekto_id`, `Uzduoties_id`) VALUES
(123, 11),
(123, 22),
(1234, 33);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `roles`
--

CREATE TABLE `roles` (
  `Roles_id` int(11) NOT NULL,
  `Pavadinimas` varchar(255) COLLATE utf32_lithuanian_ci NOT NULL,
  `Aprasymas` varchar(255) COLLATE utf32_lithuanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_lithuanian_ci;

--
-- Sukurta duomenų kopija lentelei `roles`
--

INSERT INTO `roles` (`Roles_id`, `Pavadinimas`, `Aprasymas`) VALUES
(1, 'Administratorius', 'Turi daug teisiu');

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `uzduotys`
--

CREATE TABLE `uzduotys` (
  `Uzduoties_id` int(11) NOT NULL,
  `Pavadinimas` varchar(255) COLLATE utf32_lithuanian_ci NOT NULL,
  `Aprasymas` varchar(255) COLLATE utf32_lithuanian_ci NOT NULL,
  `Prioritetas` varchar(255) COLLATE utf32_lithuanian_ci NOT NULL,
  `Busena` varchar(255) COLLATE utf32_lithuanian_ci NOT NULL,
  `Sukurimo_data` date NOT NULL,
  `Naujinimo_data` date NOT NULL,
  `projekto_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_lithuanian_ci;

--
-- Sukurta duomenų kopija lentelei `uzduotys`
--

INSERT INTO `uzduotys` (`Uzduoties_id`, `Pavadinimas`, `Aprasymas`, `Prioritetas`, `Busena`, `Sukurimo_data`, `Naujinimo_data`, `projekto_id`) VALUES
(11, 'Atimti', 'Atimtis', 'Medium', 'Finished', '2021-02-02', '2021-03-03', 123),
(22, 'Prideti', 'Sudetis', 'Medius', 'Todo', '2021-02-02', '2021-03-03', 123),
(33, 'Pakeisti', 'Pakeitimas', 'Low', 'Finished', '2021-02-02', '2021-03-03', 1234);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `vartotojai`
--

CREATE TABLE `vartotojai` (
  `El_pastas` varchar(255) COLLATE utf32_lithuanian_ci NOT NULL,
  `Slaptazodis` varchar(64) COLLATE utf32_lithuanian_ci NOT NULL,
  `Vardas` varchar(255) COLLATE utf32_lithuanian_ci NOT NULL,
  `Pavarde` varchar(255) COLLATE utf32_lithuanian_ci NOT NULL,
  `Vartotojo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_lithuanian_ci;

--
-- Sukurta duomenų kopija lentelei `vartotojai`
--

INSERT INTO `vartotojai` (`El_pastas`, `Slaptazodis`, `Vardas`, `Pavarde`, `Vartotojo_id`) VALUES
('labas@labas.lt', 'Labas1234', 'labius', 'methlabius', 1),
('gmail@gmail.com', 'Gmail333', 'Simonas', 'Donskovas', 22);

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
-- Apribojimai eksportuotom lentelėm
--

--
-- Apribojimai lentelei `komandos`
--
ALTER TABLE `komandos`
  ADD CONSTRAINT `Komandos_fk0` FOREIGN KEY (`Projekto_id`) REFERENCES `projektai` (`Projekto_id`),
  ADD CONSTRAINT `Komandos_fk1` FOREIGN KEY (`Role`) REFERENCES `roles` (`Roles_id`),
  ADD CONSTRAINT `Komandos_fk2` FOREIGN KEY (`Vartotojas`) REFERENCES `vartotojai` (`Vartotojo_id`);

--
-- Apribojimai lentelei `projektu_uzduotys`
--
ALTER TABLE `projektu_uzduotys`
  ADD CONSTRAINT `Projektu_uzduotys_fk0` FOREIGN KEY (`Projekto_id`) REFERENCES `projektai` (`Projekto_id`),
  ADD CONSTRAINT `Projektu_uzduotys_fk1` FOREIGN KEY (`Uzduoties_id`) REFERENCES `uzduotys` (`Uzduoties_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
