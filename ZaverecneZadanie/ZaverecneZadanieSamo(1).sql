-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Hostiteľ: localhost:3306
-- Čas generovania: St 22.Máj 2019, 21:35
-- Verzia serveru: 5.7.25-0ubuntu0.18.04.2
-- Verzia PHP: 7.2.15-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáza: `ZaverecneZadanieSamo`
--

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `ADS`
--

CREATE TABLE `ADS` (
  `id` int(100) UNSIGNED NOT NULL,
  `meno` varchar(30) DEFAULT NULL,
  `cv1` varchar(30) DEFAULT NULL,
  `cv2` varchar(30) DEFAULT NULL,
  `cv3` varchar(30) DEFAULT NULL,
  `Spolu` varchar(30) DEFAULT NULL,
  `Znamka` varchar(30) DEFAULT NULL,
  `Skolskyrok` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Sťahujem dáta pre tabuľku `ADS`
--

INSERT INTO `ADS` (`id`, `meno`, `cv1`, `cv2`, `cv3`, `Spolu`, `Znamka`, `Skolskyrok`) VALUES
(11111, 'Jakub Jadvis', '8', '5', '52', '65', 'D', '2015/16'),
(12345, 'Fero Onderisin', '13', '47', '2', '62', 'E', '2015/16'),
(86139, 'Milan Pavlik', '10', '20', '50', '80', 'B', '2015/16');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `DBC`
--

CREATE TABLE `DBC` (
  `id` int(100) UNSIGNED NOT NULL,
  `meno` varchar(30) DEFAULT NULL,
  `cv1` varchar(30) DEFAULT NULL,
  `cv2` varchar(30) DEFAULT NULL,
  `cv3` varchar(30) DEFAULT NULL,
  `Spolu` varchar(30) DEFAULT NULL,
  `Znamka` varchar(30) DEFAULT NULL,
  `Skolskyrok` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Sťahujem dáta pre tabuľku `DBC`
--

INSERT INTO `DBC` (`id`, `meno`, `cv1`, `cv2`, `cv3`, `Spolu`, `Znamka`, `Skolskyrok`) VALUES
(11111, 'Jakub Jadvis', '8', '5', '52', '65', 'D', '2017/18'),
(12345, 'Fero Onderisin', '13', '47', '2', '62', 'E', '2017/18'),
(86139, 'Milan Pavlik', '10', '20', '50', '80', 'B', '2017/18');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `ECH`
--

CREATE TABLE `ECH` (
  `id` int(100) UNSIGNED NOT NULL,
  `meno` varchar(30) DEFAULT NULL,
  `cv1` varchar(30) DEFAULT NULL,
  `cv2` varchar(30) DEFAULT NULL,
  `cv3` varchar(30) DEFAULT NULL,
  `Spolu` varchar(30) DEFAULT NULL,
  `Znamka` varchar(30) DEFAULT NULL,
  `Skolskyrok` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Sťahujem dáta pre tabuľku `ECH`
--

INSERT INTO `ECH` (`id`, `meno`, `cv1`, `cv2`, `cv3`, `Spolu`, `Znamka`, `Skolskyrok`) VALUES
(11111, 'Jakub Jadvis', '8', '0', '54', '67', 'D', '2016/17'),
(12345, 'Fero Onderisin', '13', '41', '2', '54', 'FX', '2016/17'),
(86139, 'Milan Pavlik', '40', '20', '50', '120', 'B', '2016/17');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL COMMENT 'primary key',
  `employee_name` varchar(255) NOT NULL COMMENT 'employee name',
  `employee_salary` double NOT NULL COMMENT 'employee salary',
  `employee_age` int(11) NOT NULL COMMENT 'employee age'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='datatable demo table';

--
-- Sťahujem dáta pre tabuľku `employee`
--

INSERT INTO `employee` (`id`, `employee_name`, `employee_salary`, `employee_age`) VALUES
(1, 'Tiger Nixon', 320800, 61),
(2, 'Garrett Winters', 170750, 63),
(3, 'Ashton Cox', 86000, 66),
(4, 'Cedric Kelly', 433060, 22),
(5, 'Airi Satou', 162700, 33),
(6, 'Brielle Williamson', 372000, 61),
(7, 'Herrod Chandler', 137500, 59),
(8, 'Rhona Davidson', 327900, 55),
(9, 'Colleen Hurst', 205500, 39),
(10, 'Sonya Frost', 103600, 23),
(11, 'Jena Gaines', 90560, 30),
(12, 'Quinn Flynn', 342000, 22),
(13, 'Charde Marshall', 470600, 36),
(14, 'Haley Kennedy', 313500, 43),
(15, 'Tatyana Fitzpatrick', 385750, 19),
(16, 'Michael Silva', 198500, 66);

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `FGH`
--

CREATE TABLE `FGH` (
  `id` int(100) UNSIGNED NOT NULL,
  `meno` varchar(30) DEFAULT NULL,
  `Email` varchar(30) DEFAULT NULL,
  `login` varchar(30) DEFAULT NULL,
  `heslo` varchar(30) DEFAULT NULL,
  `Skolskyrok` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Sťahujem dáta pre tabuľku `FGH`
--

INSERT INTO `FGH` (`id`, `meno`, `Email`, `login`, `heslo`, `Skolskyrok`) VALUES
(1, 'Fero', 'onderisin123@gmail.com', 'Fero44', '8BJBFmo4Jp50c9r', '2015/16');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `GTY`
--

CREATE TABLE `GTY` (
  `id` int(100) UNSIGNED NOT NULL,
  `meno` varchar(30) DEFAULT NULL,
  `cv1` varchar(30) DEFAULT NULL,
  `cv2` varchar(30) DEFAULT NULL,
  `cv3` varchar(30) DEFAULT NULL,
  `Spolu` varchar(30) DEFAULT NULL,
  `Znamka` varchar(30) DEFAULT NULL,
  `Skolskyrok` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `HHG`
--

CREATE TABLE `HHG` (
  `id` int(100) UNSIGNED NOT NULL,
  `meno` varchar(30) DEFAULT NULL,
  `cv1` varchar(30) DEFAULT NULL,
  `cv2` varchar(30) DEFAULT NULL,
  `cv3` varchar(30) DEFAULT NULL,
  `Spolu` varchar(30) DEFAULT NULL,
  `Znamka` varchar(30) DEFAULT NULL,
  `Skolskyrok` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Sťahujem dáta pre tabuľku `HHG`
--

INSERT INTO `HHG` (`id`, `meno`, `cv1`, `cv2`, `cv3`, `Spolu`, `Znamka`, `Skolskyrok`) VALUES
(11111, 'Jakub Jadvis', '8', '0', '54', '67', 'D', '2014/15'),
(12345, 'Fero Onderisin', '13', '41', '2', '54', 'FX', '2014/15'),
(86139, 'Milan Pavlik', '40', '20', '50', '120', 'B', '2014/15');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `jjj`
--

CREATE TABLE `jjj` (
  `id` int(100) UNSIGNED NOT NULL,
  `meno` varchar(30) DEFAULT NULL,
  `cv1` varchar(30) DEFAULT NULL,
  `cv2` varchar(30) DEFAULT NULL,
  `cv3` varchar(30) DEFAULT NULL,
  `Spolu` varchar(30) DEFAULT NULL,
  `Znamka` varchar(30) DEFAULT NULL,
  `Skolskyrok` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `KKT`
--

CREATE TABLE `KKT` (
  `id` int(100) UNSIGNED NOT NULL,
  `meno` varchar(30) DEFAULT NULL,
  `cv1` varchar(30) DEFAULT NULL,
  `cv2` varchar(30) DEFAULT NULL,
  `cv3` varchar(30) DEFAULT NULL,
  `Spolu` varchar(30) DEFAULT NULL,
  `Znamka` varchar(30) DEFAULT NULL,
  `Skolskyrok` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Sťahujem dáta pre tabuľku `KKT`
--

INSERT INTO `KKT` (`id`, `meno`, `cv1`, `cv2`, `cv3`, `Spolu`, `Znamka`, `Skolskyrok`) VALUES
(11111, 'Jakub Jadvis', '8', '0', '54', '67', 'D', '2015/16'),
(12345, 'Fero Onderisin', '13', '41', '2', '54', 'FX', '2015/16'),
(86139, 'Milan Pavlik', '40', '20', '50', '120', 'B', '2015/16');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `KLK`
--

CREATE TABLE `KLK` (
  `id` int(100) UNSIGNED NOT NULL,
  `meno` varchar(30) DEFAULT NULL,
  `cv1` varchar(30) DEFAULT NULL,
  `cv2` varchar(30) DEFAULT NULL,
  `cv3` varchar(30) DEFAULT NULL,
  `Spolu` varchar(30) DEFAULT NULL,
  `Znamka` varchar(30) DEFAULT NULL,
  `Skolskyrok` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Kľúče pre exportované tabuľky
--

--
-- Indexy pre tabuľku `ADS`
--
ALTER TABLE `ADS`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `DBC`
--
ALTER TABLE `DBC`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `ECH`
--
ALTER TABLE `ECH`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `FGH`
--
ALTER TABLE `FGH`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `GTY`
--
ALTER TABLE `GTY`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `HHG`
--
ALTER TABLE `HHG`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `jjj`
--
ALTER TABLE `jjj`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `KKT`
--
ALTER TABLE `KKT`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `KLK`
--
ALTER TABLE `KLK`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pre exportované tabuľky
--

--
-- AUTO_INCREMENT pre tabuľku `ADS`
--
ALTER TABLE `ADS`
  MODIFY `id` int(100) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86140;
--
-- AUTO_INCREMENT pre tabuľku `DBC`
--
ALTER TABLE `DBC`
  MODIFY `id` int(100) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86140;
--
-- AUTO_INCREMENT pre tabuľku `ECH`
--
ALTER TABLE `ECH`
  MODIFY `id` int(100) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86140;
--
-- AUTO_INCREMENT pre tabuľku `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key', AUTO_INCREMENT=64;
--
-- AUTO_INCREMENT pre tabuľku `FGH`
--
ALTER TABLE `FGH`
  MODIFY `id` int(100) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pre tabuľku `GTY`
--
ALTER TABLE `GTY`
  MODIFY `id` int(100) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86140;
--
-- AUTO_INCREMENT pre tabuľku `HHG`
--
ALTER TABLE `HHG`
  MODIFY `id` int(100) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86140;
--
-- AUTO_INCREMENT pre tabuľku `jjj`
--
ALTER TABLE `jjj`
  MODIFY `id` int(100) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86140;
--
-- AUTO_INCREMENT pre tabuľku `KKT`
--
ALTER TABLE `KKT`
  MODIFY `id` int(100) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86140;
--
-- AUTO_INCREMENT pre tabuľku `KLK`
--
ALTER TABLE `KLK`
  MODIFY `id` int(100) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86140;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
