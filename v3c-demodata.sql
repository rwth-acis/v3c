USE v3c_database;

--demo course
INSERT INTO `courses` (`id`, `lang`, `name`, `description`, `domain`, `profession`, `creator`, `date_created`, `date_updated`) VALUES
(6, 'en', 'Social Entrepreneurship', 'A course teaching you all you need to know about social entrepreneurship.', 1, 'Entrepreneur', 'kpapavramidis@mastgroup.gr', '2017-02-05 17:01:20', '2017-02-05 17:01:20');

--demo course units
INSERT INTO `course_units` (`id`, `lang`, `title`, `description`, `start_date`, `points`, `date_created`, `date_updated`) VALUES
(9, 'en', 'Introduction to Social Entrepreneurship', 'Introduces adult learners to the core concepts of social entrepreneurship.\r\nAnswers primary question such as "what is included in the notion of Social Economy and what are the latter&#39;s aims?" or "what is social capital and how is it measured?"', '2017-02-17', 12, '2017-02-05 17:06:15', '2017-02-05 17:06:15'),
(10, 'en', 'Producing Social Value: Identifying a Social Business Opportunity', 'Equips learners with the methodologies and tools required in order to recognize the potential for development of a successful, socially-oriented entrepreneurial activity.', '2017-02-24', 12, '2017-02-05 17:08:33', '2017-02-05 17:08:33'),
(11, 'en', 'Client Complains/Feedback Management', 'Highlights the connection between social entrepreneurship and innovation through reference to relevant case studiesand best practices recorded in EU-member states.', '2017-03-03', 12, '2017-02-05 17:09:53', '2017-02-05 17:09:53'),
(12, 'en', 'Basic principles of Quality in Client/Hospitality Services', 'Informs learners of the ways of developing funds for a social enterprise.', '2017-03-10', 12, '2017-02-05 17:10:42', '2017-02-05 17:10:42'),
(13, 'en', 'Digital Marketing in Social Entrepreneurship', 'Promotes the use of the social networks among participants for marketing issues, creating and maintaining stable relationships with potential buyers, customers, partners, collaborators, followers...', '2017-03-17', 12, '2017-02-05 17:11:57', '2017-02-05 17:11:57');

--course2unit relation table
INSERT INTO `course_to_unit` (`course_id`, `course_lang`, `unit_id`, `unit_lang`) VALUES
(6, 'en', 9, 'en'),
(6, 'en', 10, 'en'),
(6, 'en', 11, 'en'),
(6, 'en', 12, 'en'),
(6, 'en', 13, 'en');