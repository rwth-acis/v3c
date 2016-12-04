
--
-- Daten für Tabelle `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `img_url`) VALUES
  (1, 'Social Entrepreneurship', '../images/se.jpg'),
  (2, 'Tourism & Hospitality', '../images/tourism.jpg');


--
-- Daten für Tabelle `roles`
--

INSERT INTO `roles` (`id`, `role`) VALUES
  (1, 'Admin'),
  (2, 'Teacher'),
  (3, 'Learner'),
  (4, 'Operator');

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`email`, `given_name`, `family_name`, `role`, `openIdConnectSub`, `date_created`, `date_updated`)
VALUES
  ('petersommerhoff@gmail.com', 'Peter', 'Sommerhoff', 1, 'bfc09ba5-b56d-4647-a83e-c1ce153d1230', '2016-11-17 14:33:49',
   '2016-11-17 14:33:49'),
  ('tilman.berres@rwth-aachen.de', 'Tilman', 'Berres', 1, '1cec8880-664d-4307-bf4f-7569161041ed', '2016-11-19 12:42:35',
   '2016-11-19 12:42:35');


--
-- Daten für Tabelle `courses`
--

INSERT INTO `courses` (`id`, `lang`, `name`, `description`, `domain`, `profession`, `creator`, `date_created`, `date_updated`)
VALUES
  (1, 'en', 'Social Entrepreneurship 101', 'This course introduces the basic principles of Social Entrepreneurship', 1,
   'Social Entrepreneur', 'petersommerhoff@gmail.com', '2016-11-20 18:04:43', '2016-11-20 18:04:43'),
  (2, 'en', 'Flight Booking Course', 'In this course you will learn to book flights for a customer.', 2,
   'Hotel Booker', 'tilman.berres@rwth-aachen.de', '2016-11-20 18:04:34', '2016-11-20 18:04:34');