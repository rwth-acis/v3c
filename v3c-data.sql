
--
-- Data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `img_url`) VALUES
  (1, 'Social Entrepreneurship', '../images/se.jpg'),
  (2, 'Tourism & Hospitality', '../images/tourism.jpg');


--
-- Data for table `roles`
--

INSERT INTO `roles` (`id`, `role`) VALUES
  (1, 'Admin'),
  (2, 'Teacher'),
  (3, 'Learner'),
  (4, 'Operator');

--
-- Data for table `users`
--

INSERT INTO `users` (`email`, `given_name`, `family_name`, `role`, `openIdConnectSub`, `date_created`, `date_updated`)
VALUES
  ('petersommerhoff@gmail.com', 'Peter', 'Sommerhoff', 1, 'bfc09ba5-b56d-4647-a83e-c1ce153d1230', '2016-11-17 14:33:49',
   '2016-11-17 14:33:49'),
  ('tilman.berres@rwth-aachen.de', 'Tilman', 'Berres', 1, '1cec8880-664d-4307-bf4f-7569161041ed', '2016-11-19 12:42:35',
   '2016-11-19 12:42:35');


--
-- Data for table `courses`
--

INSERT INTO `courses` (`id`, `lang`, `name`, `description`, `domain`, `profession`, `creator`, `date_created`, `date_updated`)
VALUES
  (1, 'en', 'Social Entrepreneurship 101', 'This course introduces the basic principles of Social Entrepreneurship', 1,
   'Social Entrepreneur', 'petersommerhoff@gmail.com', '2016-11-20 18:04:43', '2016-11-20 18:04:43'),
  (2, 'en', 'Flight Booking Course', 'In this course you will learn to book flights for a customer.', 2,
   'Hotel Booker', 'tilman.berres@rwth-aachen.de', '2016-11-20 18:04:34', '2016-11-20 18:04:34');

--
-- Data for table `course_units`
--

INSERT INTO `course_units` (`id`, `lang`, `title`, `description`, `start_date`, `points`, `date_created`, `date_updated`)
VALUES
  (NULL, 'en', 'Introduction to Social Entrepreneurship', 'The basics of Social Entrepreneurship explained. What is social value and why we must have an impact on it?',
   '2016-12-01 09:00:00', 12, '2016-11-20 18:05:43', '2016-11-20 18:05:43'),
  (NULL, 'en', 'Assessing Your Inner Potential', 'What factors make people successful? How to further develop these factors in yourself?',
  '2016-12-07 09:00:00', 12, '2016-11-20 18:06:43', '2016-11-20 18:06:43'),
  (NULL, 'en', 'From Ideas To Action', 'Once being able to assess capabilities, we look, how do these capabilities turn into beneficial action.',
   '2016-14-12 09:00:00', 12, '2016-11-20 18:07:43', '2016-11-20 18:07:43'),
  (NULL, 'en', 'Role Of Technology', 'What is the role of technology in social entrepreneurship nowadays?',
   '2016-12-21 09:00:00', 12, '2016-11-20 18:08:43', '2016-11-20 18:08:43'),
  (NULL, 'en', 'History of Social Entrepreneurship and Summary', 'We take a look at some of the biggest social entrepreneurs and see what they have in common. We also wrap up the course with a brief summary.',
   '2016-04-01 09:00:00', 12, '2016-11-20 18:09:43', '2016-11-20 18:10:43');
   
--
-- Data for table `course_to_unit`
--

INSERT INTO `course_to_unit` (`course_id`, `course_lang`, `unit_id`, `unit_lang`)
VALUES
  (1, 'en', 1, 'en'),
  (1, 'en', 2, 'en'),
  (1, 'en', 3, 'en'),
  (1, 'en', 4, 'en'),
  (1, 'en', 5, 'en');