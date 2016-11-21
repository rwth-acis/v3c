-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 21. Nov 2016 um 02:42
-- Server-Version: 10.1.19-MariaDB
-- PHP-Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `v3c_database`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `courses`
--

CREATE TABLE `courses` (
  `id`          INT(11)     NOT NULL
  COMMENT 'find corresponding models with this id',
  `name`        VARCHAR(64) NOT NULL,
  `domain`      varchar(64) NOT NULL,
  `profession`  varchar(64) NOT NULL,
  `description` TEXT,
  `creator`     INT(11)     NOT NULL
  COMMENT 'correlates with user table',
  `contact`     VARCHAR(1000)        DEFAULT NULL,
  `language`    INT(11)     NOT NULL,
  `links`       VARCHAR(1000)        DEFAULT NULL,
  `edit_date`   TIMESTAMP   NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `subject_id`  INT(11)     NOT NULL
)
  ENGINE = InnoDB
  DEFAULT CHARSET = latin1;

--
-- Daten für Tabelle `courses`
--

INSERT INTO `courses` (`id`, `name`, `domain`, `profession`, `description`, `creator`, `contact`, `language`, `links`, `edit_date`, `subject_id`)
VALUES
  (1, 'Social Entrepreneurship 101', '', '', 'This course introduces the basic principles of Social Entrepreneurship',
      132, 'Peter Sommerhoff', 1, 'http://petersommerhoff.com', '2016-11-20 18:04:43', 1),
  (2, 'Flight Booking Course', '', '', 'In this course you will learn to book flights for a customer.', 133,
      'Tilman Berres', 1, '', '2016-11-20 18:04:34', 66);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `course_units`
--

CREATE TABLE `course_units` (
  `id`        INT(11) NOT NULL,
  `course_id` INT(11) NOT NULL,
  `role_url`  TEXT    NOT NULL,
  `date`      DATE    NOT NULL
)
  ENGINE = InnoDB
  DEFAULT CHARSET = latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `languages`
--

CREATE TABLE `languages` (
  `id`       INT(11)     NOT NULL,
  `language` VARCHAR(63) NOT NULL
)
  ENGINE = InnoDB
  DEFAULT CHARSET = latin1;

--
-- Daten für Tabelle `languages`
--

INSERT INTO `languages` (`id`, `language`) VALUES
  (1, 'English'),
  (2, 'Greek'),
  (3, 'Italian'),
  (4, 'Spanish');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `roles`
--

CREATE TABLE `roles` (
  `id`   TINYINT(2)  NOT NULL,
  `role` VARCHAR(64) NOT NULL
)
  ENGINE = InnoDB
  DEFAULT CHARSET = latin1;

--
-- Daten für Tabelle `roles`
--

INSERT INTO `roles` (`id`, `role`) VALUES
  (1, 'Creator'),
  (2, 'Trainer'),
  (3, 'Developer'),
  (4, 'Learner');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `subjects`
--

CREATE TABLE `subjects` (
  `id`      INT(11)     NOT NULL
  COMMENT 'find corresponding models with this id',
  `name`    VARCHAR(64) NOT NULL,
  `img_url` TEXT        NOT NULL
)
  ENGINE = InnoDB
  DEFAULT CHARSET = latin1;

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

CREATE TABLE `users` (
  `id`               INT(11)      NOT NULL,
  `email`            VARCHAR(128) NOT NULL,
  `given_name`       VARCHAR(256)          DEFAULT NULL,
  `family_name`      VARCHAR(256)          DEFAULT NULL,
  `role`             TINYINT(2)   NOT NULL DEFAULT '4',
  `created_at`       TIMESTAMP    NULL     DEFAULT CURRENT_TIMESTAMP,
  `openIdConnectSub` VARCHAR(255)          DEFAULT NULL,
  `affiliation`      VARCHAR(100)          DEFAULT NULL,
  `city`             VARCHAR(100)          DEFAULT NULL,
  `street`           VARCHAR(100)          DEFAULT NULL,
  `phone`            VARCHAR(100)          DEFAULT NULL
)
  ENGINE = InnoDB
  DEFAULT CHARSET = latin1;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `email`, `given_name`, `family_name`, `role`, `created_at`, `openIdConnectSub`, `affiliation`, `city`, `street`, `phone`)
VALUES
  (132, 'petersommerhoff@gmail.com', 'Peter', 'Sommerhoff', 1, '2016-11-17 14:33:49',
        'bfc09ba5-b56d-4647-a83e-c1ce153d1230', 'RWTH', 'Aachen', 'Halifax', '1234'),
  (133, 'tilman.berres@rwth-aachen.de', 'Tilman', 'Berres', 1, '2016-11-19 12:42:35',
        '1cec8880-664d-4307-bf4f-7569161041ed', 'RWTH', 'Aachen', 'Halifax', '23456');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_creator` (`creator`),
  ADD KEY `FK_Subjects_Course` (`subject_id`),
  ADD KEY `language` (`language`);

--
-- Indizes für die Tabelle `course_units`
--
ALTER TABLE `course_units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indizes für die Tabelle `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `language` (`language`);

--
-- Indizes für die Tabelle `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_email_pass` (`email`),
  ADD KEY `role` (`role`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `courses`
--
ALTER TABLE `courses`
  MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT
  COMMENT 'find corresponding models with this id',
  AUTO_INCREMENT = 3;
--
-- AUTO_INCREMENT für Tabelle `languages`
--
ALTER TABLE `languages`
  MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 5;
--
-- AUTO_INCREMENT für Tabelle `roles`
--
ALTER TABLE `roles`
  MODIFY `id` TINYINT(2) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 5;
--
-- AUTO_INCREMENT für Tabelle `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT
  COMMENT 'find corresponding models with this id',
  AUTO_INCREMENT = 67;
--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 134;
--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `FK_Subjects_Course` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`),
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`language`) REFERENCES `languages` (`id`),
  ADD CONSTRAINT `fk_courses_users` FOREIGN KEY (`creator`) REFERENCES `users` (`id`)
  ON UPDATE CASCADE;

--
-- Constraints der Tabelle `course_units`
--
ALTER TABLE `course_units`
  ADD CONSTRAINT `course_units_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Constraints der Tabelle `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role`) REFERENCES `roles` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
