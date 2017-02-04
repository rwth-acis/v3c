
--
-- Database: `v3c`
--

-- TODO: Where/when to use ON UPDATE CASCADE and ON DELETE CASCADE?
USE v3c_database;

CREATE TABLE IF NOT EXISTS `subjects` (
  `id`         INT         NOT NULL     AUTO_INCREMENT,
  `name`       VARCHAR(64) NOT NULL UNIQUE,
  `img_url`    TEXT        NOT NULL,
  `created_at` TIMESTAMP   NOT NULL     DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP   NOT NULL     DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
)
  ENGINE = InnoDB COLLATE utf8_general_ci;



CREATE TABLE IF NOT EXISTS `roles` (
  `id`   INT          NOT NULL,
  `role` VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
)
  ENGINE = InnoDB COLLATE utf8_general_ci;



CREATE TABLE IF NOT EXISTS `organizations` (
  `id`        INT NOT NULL AUTO_INCREMENT,
  `name`      VARCHAR(255) NOT NULL,
  `email`     VARCHAR(255) NOT NULL UNIQUE,  -- TODO: may be replaced by users associated with organizations (then using the user's email)
  `logo_url`  TEXT NOT NULL ,
  `created_at` TIMESTAMP   NOT NULL     DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP   NOT NULL     DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
)
  ENGINE = InnoDB COLLATE utf8_general_ci;



CREATE TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email`            VARCHAR(255) NOT NULL UNIQUE,
  `given_name`       VARCHAR(255) NOT NULL,
  `family_name`      VARCHAR(255) NOT NULL,
  `role`             INT          NOT NULL,
  `affiliation`       INT   NOT NULL DEFAULT 0,
  `openIdConnectSub` VARCHAR(255)              DEFAULT NULL UNIQUE,
  `date_created`     TIMESTAMP    NOT NULL     DEFAULT CURRENT_TIMESTAMP,
  `date_updated`     TIMESTAMP    NOT NULL     DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  FOREIGN KEY (role) REFERENCES roles (id),
  FOREIGN KEY (affiliation) REFERENCES organizations(id)
)
  ENGINE = InnoDB COLLATE utf8_general_ci;



CREATE TABLE IF NOT EXISTS `courses` (
  `id`           INT          NOT NULL AUTO_INCREMENT,
  `lang`         CHAR(2)      NOT NULL,
  `name`         VARCHAR(64)  NOT NULL UNIQUE,
  `description`  TEXT         NOT NULL,
  `domain`       INT          NOT NULL,
  `profession`   VARCHAR(64)  NOT NULL,
  `creator`      VARCHAR(255) NOT NULL,
  `date_created` TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id, lang),
  FOREIGN KEY (creator) REFERENCES organizations (email),
  FOREIGN KEY (domain) REFERENCES subjects (id)
)
  ENGINE = InnoDB COLLATE utf8_general_ci;



CREATE TABLE IF NOT EXISTS `course_units` (
  `id`           INT          NOT NULL     AUTO_INCREMENT,
  `lang`         CHAR(2)      NOT NULL,
  `title`        VARCHAR(255) NOT NULL,
  `description`  TEXT         NOT NULL,
  `start_date`   DATE         NOT NULL,
  `points`       INT          NOT NULL,
  `date_created` TIMESTAMP    NOT NULL     DEFAULT CURRENT_TIMESTAMP,
  `date_updated` TIMESTAMP    NOT NULL     DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id, lang)
)
  ENGINE = InnoDB COLLATE utf8_general_ci;



CREATE TABLE IF NOT EXISTS `course_to_unit` (
  `course_id`   INT     NOT NULL,
  `course_lang` CHAR(2) NOT NULL,
  `unit_id`     INT     NOT NULL,
  `unit_lang`   CHAR(2) NOT NULL,
  PRIMARY KEY (course_id, course_lang, unit_id, unit_lang),
  FOREIGN KEY (course_id, course_lang) REFERENCES courses (id, lang) ON DELETE CASCADE,
  FOREIGN KEY (unit_id, unit_lang) REFERENCES course_units (id, lang) ON DELETE CASCADE
)
  ENGINE = InnoDB COLLATE utf8_general_ci;



CREATE TABLE IF NOT EXISTS `course_elements` (
  `id`           INT      NOT NULL     AUTO_INCREMENT,
  `lang`         CHAR(2)      NOT NULL,
  `title`        VARCHAR(255) NOT NULL,
  `description`  TEXT         NOT NULL,
  `points`       INT          NOT NULL,
  `date_created` TIMESTAMP    NOT NULL     DEFAULT CURRENT_TIMESTAMP,
  `date_updated` TIMESTAMP    NOT NULL     DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id, lang)
)
  ENGINE = InnoDB COLLATE utf8_general_ci;




CREATE TABLE IF NOT EXISTS `unit_to_element` (
  `course_id`   INT NOT NULL,
  `course_lang` CHAR(2) NOT NULL,
  `unit_id`     INT NOT NULL,
  `unit_lang`   CHAR(2) NOT NULL,
  PRIMARY KEY (course_id, course_lang, unit_id, unit_lang),
  FOREIGN KEY (course_id, course_lang) REFERENCES courses (id, lang),
  FOREIGN KEY (unit_id, unit_lang) REFERENCES course_units (id, lang)
)
  ENGINE = InnoDB COLLATE utf8_general_ci;



CREATE TABLE IF NOT EXISTS `widget` (
  `id`  INT NOT NULL AUTO_INCREMENT,
  `url`          VARCHAR(255) NOT NULL UNIQUE,
  `lang`         CHAR(2)        NOT NULL,
  `name`         VARCHAR(255)   NOT NULL,
  `description`  TEXT           NOT NULL,
  `date_created` TIMESTAMP      NOT NULL     DEFAULT CURRENT_TIMESTAMP,
  `date_updated` TIMESTAMP      NOT NULL     DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
)
  ENGINE = InnoDB COLLATE utf8_general_ci;



CREATE TABLE IF NOT EXISTS `element_to_widget` (
  `element_id`   INT NOT NULL,
  `element_lang` CHAR(2) NOT NULL,
  `widget_id`   INT NOT NULL,
  PRIMARY KEY (element_id, element_lang, widget_id),
  FOREIGN KEY (element_id, element_lang) REFERENCES course_elements (id, lang),
  FOREIGN KEY (widget_id) REFERENCES widget (id)
)
  ENGINE = InnoDB COLLATE utf8_general_ci;


#
# === NOT YET USED ===
#

# CREATE TABLE IF NOT EXISTS `slide_viewer_widget` (
#   `url`         VARCHAR(255) NOT NULL,
#   `lang`        CHAR(2)        NOT NULL,
#   `slide_url`   TEXT NOT NULL,
#   `slide_title` VARCHAR(255)   NOT NULL,
#   `slide_desc`  TEXT           NOT NULL,
#   PRIMARY KEY (url, lang),
#   FOREIGN KEY (url, lang) REFERENCES widget (url, lang)
# )
#   ENGINE = InnoDB COLLATE utf8_general_ci;
#
#
#
# CREATE TABLE IF NOT EXISTS `video_viewer_widget` (
#   `url`         VARCHAR(255) NOT NULL,
#   `lang`        CHAR(2)        NOT NULL,
#   `video_url`   TEXT NOT NULL,
#   `video_title` VARCHAR(255)   NOT NULL,
#   `video_desc`  TEXT           NOT NULL,
#   PRIMARY KEY (url, lang),
#   FOREIGN KEY (url, lang) REFERENCES widget (url, lang)
# )
#   ENGINE = InnoDB COLLATE utf8_general_ci;
#
#
#
# CREATE TABLE IF NOT EXISTS `quiz_widget` (
#   `url`      VARCHAR(255) NOT NULL,
#   `lang`     CHAR(2)        NOT NULL,
#   `quiz_id`  INT            NOT NULL UNIQUE,
#   `headline` VARCHAR(255)   NOT NULL,
#   PRIMARY KEY (url, lang, quiz_id),
#   FOREIGN KEY (url, lang) REFERENCES widget (url, lang)
# )
#   ENGINE = InnoDB COLLATE utf8_general_ci;
#
#
#
# CREATE TABLE IF NOT EXISTS `quiz_question` (
#   `url`           VARCHAR(255) NOT NULL,
#   `lang`          CHAR(2)        NOT NULL,
#   `quiz_id`       INT            NOT NULL,
#   `question_id`   INT            NOT NULL,
#   `question_text` VARCHAR(255)   NOT NULL,
#   `question_type` VARCHAR(255)   NOT NULL, -- maybe put this into another table
#   PRIMARY KEY (url, lang, quiz_id, question_id),
#   FOREIGN KEY (url, lang, quiz_id) REFERENCES quiz_widget (url, lang, quiz_id)
# )
#   ENGINE = InnoDB COLLATE utf8_general_ci;
#
#
#
#
# CREATE TABLE IF NOT EXISTS `quiz_answer` (
#   `url`         VARCHAR(255) NOT NULL,
#   `lang`        CHAR(2)        NOT NULL,
#   `quiz_id`     INT            NOT NULL,
#   `question_id` INT            NOT NULL,
#   `answer_id`   INT            NOT NULL,
#   `answer_text` VARCHAR(255)   NOT NULL,
#   PRIMARY KEY (url, lang, quiz_id, question_id, answer_id),
#   FOREIGN KEY (url, lang, quiz_id, question_id) REFERENCES quiz_question (url, lang, quiz_id, question_id)
# )
#   ENGINE = InnoDB COLLATE utf8_general_ci;
#

