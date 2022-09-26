-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2022 at 11:05 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clinica`
--

-- --------------------------------------------------------

--
-- Table structure for table `paciente`
--

CREATE TABLE `paciente` (
  `ID` int(11) NOT NULL,
  `CEDULA` varchar(20) NOT NULL,
  `INGRESO` datetime NOT NULL,
  `FECHA_SALIDA` date NOT NULL,
  `FK_URGENCIA` int(11) NOT NULL,
  `PESO` float NOT NULL,
  `EMAIL` varchar(30) NOT NULL,
  `NOMBRE` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `paciente`
--

INSERT INTO `paciente` (`ID`, `CEDULA`, `INGRESO`, `FECHA_SALIDA`, `FK_URGENCIA`, `PESO`, `EMAIL`, `NOMBRE`) VALUES
(2, '1003405445', '2022-09-21 21:05:27', '2022-09-06', 4, 65.5, 'jooge1998@gmail.com', 'jorge montes'),
(8, '13221323', '2022-09-22 21:05:27', '2022-09-23', 4, 50, 'juan19@gmail.com', 'juan perez');

-- --------------------------------------------------------

--
-- Table structure for table `urgencia`
--

CREATE TABLE `urgencia` (
  `ID` int(11) NOT NULL,
  `TRIAGE` varchar(50) NOT NULL,
  `SINTOMAS` varchar(500) NOT NULL,
  `MEDICO` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `urgencia`
--

INSERT INTO `urgencia` (`ID`, `TRIAGE`, `SINTOMAS`, `MEDICO`) VALUES
(4, 'verde', 'dolor cabeza', 'perez perez jaime');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_URGENCIA` (`FK_URGENCIA`);

--
-- Indexes for table `urgencia`
--
ALTER TABLE `urgencia`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `paciente`
--
ALTER TABLE `paciente`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `urgencia`
--
ALTER TABLE `urgencia`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `paciente`
--
ALTER TABLE `paciente`
  ADD CONSTRAINT `paciente_ibfk_1` FOREIGN KEY (`FK_URGENCIA`) REFERENCES `urgencia` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
