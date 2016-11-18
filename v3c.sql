-- Erstellungszeit: 18. Nov 2016 um 12:36
-- Server Version: 5.6.21
-- PHP-Version: 5.5.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `v3c`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(11) NOT NULL COMMENT 'find corresponding models with this id',
  `name` varchar(64) NOT NULL,
  `description` text,
  `creator` int(11) NOT NULL COMMENT 'correlates with user table',
  `role_url` text NOT NULL,
  `contact` varchar(1000) DEFAULT NULL,
  `dates` varchar(1000) DEFAULT NULL,
  `links` varchar(1000) DEFAULT NULL,
  `edit_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `courses`
--

INSERT INTO `courses` (`id`, `name`, `description`, `creator`, `role_url`, `contact`, `dates`, `links`, `edit_date`, `subject_id`) VALUES
  (1, 'Social Entrepreneurship 101', 'This course introduces the basic principles of Social Entrepreneurship', 132, 'se101', 'Peter Sommerhoff', 'Nov 23, 2016\r\nNov 30, 2016\r\nDez 13, 2016', 'http://petersommerhoff.com', '2016-11-18 10:04:51', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `course_models`
--
-- in Benutzung(#1146 - Table 'v3c.course_models' doesn't exist)
-- Fehler beim Lesen der Daten: (#1146 - Table 'v3c.course_models' doesn't exist)

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `models`
--
-- in Benutzung(#1146 - Table 'v3c.models' doesn't exist)
-- Fehler beim Lesen der Daten: (#1146 - Table 'v3c.models' doesn't exist)

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `subjects`
--

CREATE TABLE IF NOT EXISTS `subjects` (
  `id` int(11) NOT NULL COMMENT 'find corresponding models with this id',
  `name` varchar(64) NOT NULL,
  `img_url` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `img_url`) VALUES
  (1, 'Social Entrepreneurship', '../images/se.jpg'),
  (66, 'Tourism & Hospitality', '../images/tourism.jpg');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `given_name` varchar(256) DEFAULT NULL,
  `family_name` varchar(256) DEFAULT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `openIdConnectSub` varchar(255) DEFAULT NULL,
  `affiliation` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `street` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=133 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `email`, `given_name`, `family_name`, `confirmed`, `created_at`, `openIdConnectSub`, `affiliation`, `city`, `street`, `phone`) VALUES
  (132, 'petersommerhoff@gmail.com', 'Peter', 'Sommerhoff', 1, '2016-11-17 14:33:49', 'bfc09ba5-b56d-4647-a83e-c1ce153d1230', 'RWTH', 'Aachen', 'Halifax', '1234');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`), ADD KEY `index_creator` (`creator`), ADD KEY `FK_Subjects_Course` (`subject_id`);

--
-- Indizes für die Tabelle `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `uq_email_pass` (`email`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'find corresponding models with this id',AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'find corresponding models with this id',AUTO_INCREMENT=67;
--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=133;
--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `FK_Subjects_Course` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`),
  ADD CONSTRAINT `fk_courses_users` FOREIGN KEY (`creator`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
