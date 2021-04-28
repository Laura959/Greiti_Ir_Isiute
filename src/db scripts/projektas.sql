-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2021 at 08:08 PM
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
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_lithuanian_ci;

--
-- Dumping data for table `komandos`
--

INSERT INTO `komandos` (`Projekto_id`, `Role`, `Vartotojas`) VALUES
(537531672, 1, 1),
(673025365, 1, 1),
(988244639, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `projektai`
--

CREATE TABLE `projektai` (
  `Projekto_id` int(11) NOT NULL,
  `Pavadinimas` varchar(255) COLLATE utf32_lithuanian_ci NOT NULL,
  `Aprasymas` text COLLATE utf32_lithuanian_ci NOT NULL,
  `Busena` varchar(255) COLLATE utf32_lithuanian_ci NOT NULL,
  `Sukurimo_data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_lithuanian_ci;

--
-- Dumping data for table `projektai`
--

INSERT INTO `projektai` (`Projekto_id`, `Pavadinimas`, `Aprasymas`, `Busena`, `Sukurimo_data`) VALUES
(537531672, 'Project', 'Duombaze', 'In Progress', '2021-04-27'),
(673025365, 'sacassa', 'sacascascascsacas', 'In Progress', '2021-04-27'),
(988244639, 'yuvyuvyuv', 'yucuccucu', 'In Progress', '2021-04-27');

-- --------------------------------------------------------

--
-- Table structure for table `projektu_uzduotys`
--

CREATE TABLE `projektu_uzduotys` (
  `Projekto_id` int(11) NOT NULL,
  `Uzduoties_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_lithuanian_ci;

--
-- Dumping data for table `projektu_uzduotys`
--

INSERT INTO `projektu_uzduotys` (`Projekto_id`, `Uzduoties_id`) VALUES
(537531672, 1),
(537531672, 2),
(537531672, 3),
(537531672, 4),
(537531672, 5),
(673025365, 6),
(673025365, 7),
(673025365, 8),
(673025365, 9),
(673025365, 10);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `Roles_id` int(11) NOT NULL,
  `Pavadinimas` varchar(255) COLLATE utf32_lithuanian_ci NOT NULL,
  `Aprasymas` varchar(255) COLLATE utf32_lithuanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_lithuanian_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`Roles_id`, `Pavadinimas`, `Aprasymas`) VALUES
(1, 'Administratorius', 'Turi daug teisiu');

-- --------------------------------------------------------

--
-- Table structure for table `uzduotys`
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
-- Dumping data for table `uzduotys`
--

INSERT INTO `uzduotys` (`Uzduoties_id`, `Pavadinimas`, `Aprasymas`, `Prioritetas`, `Busena`, `Sukurimo_data`, `Naujinimo_data`, `projekto_id`) VALUES
(1, 'Uzduotis', 'Nauja', 'Vienas', 'To Do', '0000-00-00', '0000-00-00', 537531672),
(2, 'Uzduotis', 'Nauja', 'Vienas', 'To Do', '0000-00-00', '0000-00-00', 537531672),
(3, 'Uzduotis', 'Nauja', 'Vienas', 'Done', '0000-00-00', '0000-00-00', 537531672),
(4, 'Uzduotis', 'Nauja', 'Vienas', 'Done', '0000-00-00', '0000-00-00', 537531672),
(5, 'Uzduotis', 'Nauja', 'Vienas', 'To Do', '0000-00-00', '0000-00-00', 537531672),
(6, 'Uzduotis', 'Nauja', 'Vienas', 'To Do', '0000-00-00', '0000-00-00', 673025365),
(7, 'Uzduotis', 'Nauja', 'Vienas', 'To Do', '0000-00-00', '0000-00-00', 673025365),
(8, 'Uzduotis', 'Nauja', 'Vienas', 'Done', '0000-00-00', '0000-00-00', 673025365),
(9, 'Uzduotis', 'Nauja', 'Vienas', 'Done', '0000-00-00', '0000-00-00', 673025365),
(10, 'Uzduotis', 'Nauja', 'Vienas', 'Done', '0000-00-00', '0000-00-00', 673025365);

-- --------------------------------------------------------

--
-- Table structure for table `vartotojai`
--

CREATE TABLE `vartotojai` (
  `El_pastas` varchar(255) COLLATE utf32_lithuanian_ci NOT NULL,
  `Slaptazodis` varchar(64) COLLATE utf32_lithuanian_ci NOT NULL,
  `Vardas` varchar(255) COLLATE utf32_lithuanian_ci NOT NULL,
  `Pavarde` varchar(255) COLLATE utf32_lithuanian_ci NOT NULL,
  `Vartotojo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_lithuanian_ci;

--
-- Dumping data for table `vartotojai`
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
