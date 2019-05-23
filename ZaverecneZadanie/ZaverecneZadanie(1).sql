-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Hostiteľ: localhost:3306
-- Čas generovania: St 22.Máj 2019, 21:34
-- Verzia serveru: 5.7.25-0ubuntu0.18.04.2
-- Verzia PHP: 7.2.15-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáza: `ZaverecneZadanie`
--

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `Admin`
--

CREATE TABLE `Admin` (
  `login` varchar(30) NOT NULL,
  `password` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Sťahujem dáta pre tabuľku `Admin`
--

INSERT INTO `Admin` (`login`, `password`) VALUES
('admin', '$2y$12$5VjpOwP4I/wqQc2zXjHxSejJRD51WW2incbjCZpFiSaAbe4KbvKRe');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `logMail`
--

CREATE TABLE `logMail` (
  `datumOdoslania` date NOT NULL,
  `menoStudenta` varchar(50) CHARACTER SET utf8 NOT NULL,
  `predmetSpravy` varchar(50) CHARACTER SET utf8 NOT NULL,
  `IDSablony` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `sablony`
--

CREATE TABLE `sablony` (
  `id` int(11) NOT NULL,
  `sablona` text COLLATE utf8_slovak_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

--
-- Sťahujem dáta pre tabuľku `sablony`
--

INSERT INTO `sablony` (`id`, `sablona`) VALUES
(1, 'Dobrý deň,\nna predmete Webové technológie 2 budete mať k dispozícii vlastný virtuálny linux server, ktorý budete\npoužívať počas semestra, a na ktorom budete vypracovávať zadania. Prihlasovacie údaje k Vašemu serveru\nsu uvedené nižšie.\nip adresa: {{verejnaIP}}\nprihlasovacie meno: {{login}}\nheslo: {{heslo}}\nVaše web stránky budú dostupné na: http:// {{verejnaIP}}:{{http}}\nS pozdravom,\n{{sender}}');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `ULOHA1`
--

CREATE TABLE `ULOHA1` (
  `id` varchar(50) DEFAULT NULL,
  `meno` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `heslo` varchar(300) DEFAULT NULL,
  `tim` varchar(50) DEFAULT NULL,
  `predmet` varchar(50) DEFAULT NULL,
  `body` varchar(50) NOT NULL,
  `suhlas` varchar(100) NOT NULL,
  `rok_predmetu` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Sťahujem dáta pre tabuľku `ULOHA1`
--

INSERT INTO `ULOHA1` (`id`, `meno`, `email`, `heslo`, `tim`, `predmet`, `body`, `suhlas`, `rok_predmetu`) VALUES
('86139', 'Milan Pavlik', 'xpavlikm3@stuba.sk', '$2y$12$iG4FOOcLzbNrjvcVh5IuiuwNA/5gOr4lHet01Nxog2uLy9Ujxod2e', '1', 'WEB2', '37', '', '2018/2019'),
('86139', 'Milan Pavlik', 'xpavlikm3@stuba.sk', '$2y$12$x6jf6bw2OQm1/0BDwaTASOkK9WowUHOHgaqUa8ZiauNZj425DWRvy', '1', 'WEB1', '50', '', '2018/2019'),
('86153', 'Samuel Solar', 'xsolar@stuba.sk', '$2y$12$6mrCDTLXPXRls9JnvcGFv.ypwVKrUf27XkwY2hU1qkjMeRXNN6Xnm', '1', 'WEB2', '39', '', '2018/2019'),
('86153', 'Samuel Solar', 'xsolar@stuba.sk', '$2y$12$23yiRgvwYoA6oClucNvrqerBn2ZThkUxaBSZpRAzL7vXbfD8kMK46', '1', 'WEB1', '50', '', '2018/2019'),
('86186', 'Matus Chalko', 'xchalko@stuba.sk', '', '1', 'WEB2', '37', 'suhlasim', '2018/2019'),
('86190', 'Jakub Jadvis', 'xjadvis@stuba.sk', '', '1', 'WEB2', '37', 'nesuhlasim', '2018/2019'),
('86190', 'Jakub Jadvis', 'xjadvis@stuba.sk', '', '1', 'WEB1', '50', 'suhlasim', '2018/2019');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `ULOHA2`
--

CREATE TABLE `ULOHA2` (
  `id` varchar(50) DEFAULT NULL,
  `meno` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `heslo` varchar(300) DEFAULT NULL,
  `tim` varchar(50) DEFAULT NULL,
  `predmet` varchar(50) DEFAULT NULL,
  `body` varchar(50) NOT NULL,
  `suhlas` varchar(100) NOT NULL,
  `rok_predmetu` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Sťahujem dáta pre tabuľku `ULOHA2`
--

INSERT INTO `ULOHA2` (`id`, `meno`, `email`, `heslo`, `tim`, `predmet`, `body`, `suhlas`, `rok_predmetu`) VALUES
('86153', 'Samuel Solar', 'xsolar@stuba.sk', '$2y$12$6mrCDTLXPXRls9JnvcGFv.ypwVKrUf27XkwY2hU1qkjMeRXNN6Xnm', '1', 'WEB2', '39', '', '2018/2019'),
('86190', 'Jakub Jadvis', 'xjadvis@stuba.sk', '', '1', 'WEB2', '37', 'nesuhlasim', '2018/2019'),
('86139', 'Milan Pavlik', 'xpavlikm3@stuba.sk', '$2y$12$iG4FOOcLzbNrjvcVh5IuiuwNA/5gOr4lHet01Nxog2uLy9Ujxod2e', '1', 'WEB2', '37', '', '2018/2019'),
('86186', 'Matus Chalko', 'xchalko@stuba.sk', '', '1', 'WEB2', '37', 'suhlasim', '2018/2019'),
('86153', 'Samuel Solar', 'xsolar@stuba.sk', '$2y$12$23yiRgvwYoA6oClucNvrqerBn2ZThkUxaBSZpRAzL7vXbfD8kMK46', '1', 'WEB1', '50', '', '2018/2019'),
('86190', 'Jakub Jadvis', 'xjadvis@stuba.sk', '', '1', 'WEB1', '50', 'suhlasim', '2018/2019'),
('86139', 'Milan Pavlik', 'xpavlikm3@stuba.sk', '$2y$12$x6jf6bw2OQm1/0BDwaTASOkK9WowUHOHgaqUa8ZiauNZj425DWRvy', '1', 'WEB1', '50', '', '2018/2019');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `ULOHA2BODY`
--

CREATE TABLE `ULOHA2BODY` (
  `predmet` varchar(50) DEFAULT NULL,
  `tim` varchar(50) DEFAULT NULL,
  `body` varchar(50) DEFAULT NULL,
  `suhlas_admin` varchar(100) NOT NULL,
  `rok_predmetu` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Sťahujem dáta pre tabuľku `ULOHA2BODY`
--

INSERT INTO `ULOHA2BODY` (`predmet`, `tim`, `body`, `suhlas_admin`, `rok_predmetu`) VALUES
('DBS', '15', '60', '', '2012/2013'),
('VSA', '15', '50', 'suhlasim', '2012/2013'),
('VSA', '', '', '', '2012/2013'),
('VSA', '13', '50', '', '2012/2013'),
('WEB2', '1', '150', '', '2018/2019');

--
-- Kľúče pre exportované tabuľky
--

--
-- Indexy pre tabuľku `sablony`
--
ALTER TABLE `sablony`
  ADD PRIMARY KEY (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
