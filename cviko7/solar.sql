

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `Visitors`
--

CREATE TABLE `Visitors` (
  `ID` int(11) NOT NULL,
  `IP` varchar(30) CHARACTER SET utf8 NOT NULL,
  `Country` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Country_code` varchar(20) CHARACTER SET utf8 NOT NULL,
  `City` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Page_name` varchar(20) CHARACTER SET utf8 NOT NULL,
  `Hodina` datetime NOT NULL,
  `Den` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Sťahujem dáta pre tabuľku `Visitors`
--

INSERT INTO `Visitors` (`ID`, `IP`, `Country`, `Country_code`, `City`, `Page_name`, `Hodina`, `Den`) VALUES
(56, '37.59.35.205', 'France', 'FR', 'Strasbourg', 'forecast.php', '2017-05-08 20:51:50', '2017-05-08'),
(58, '67.225.189.54', 'United States', 'US', 'Tobyhanna', 'forecast.php', '2017-05-08 20:52:17', '2017-05-08'),
(59, '67.225.189.54', 'United States', 'US', 'Tobyhanna', 'index.php', '2017-05-08 20:52:47', '2017-05-08'),
(60, '37.59.35.205', 'France', 'FR', 'Strasbourg', 'index.php', '2017-05-08 20:52:58', '2017-05-08'),
(61, '147.175.181.41', 'Slovak Republic', 'SK', 'Bratislava', 'forecast.php', '2017-05-08 20:53:12', '2017-05-08'),
(62, '147.175.181.41', 'Slovak Republic', 'SK', 'Bratislava', 'visit.php', '2017-05-08 20:53:18', '2017-05-08'),
(65, '147.175.181.41', 'Slovak Republic', 'SK', 'Bratislava', 'index.php', '2017-05-08 21:05:04', '2017-05-08');

--
-- Kľúče pre exportované tabuľky
--

--
-- Indexy pre tabuľku `Visitors`
--
ALTER TABLE `Visitors`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `uniqueVisit` (`IP`,`Den`,`Page_name`) USING BTREE;

--
-- AUTO_INCREMENT pre exportované tabuľky
--

--
-- AUTO_INCREMENT pre tabuľku `Visitors`
--
ALTER TABLE `Visitors`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
