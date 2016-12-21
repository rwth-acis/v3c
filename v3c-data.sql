
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
-- Data for table `organizations`
--

INSERT INTO `organizations` (`id`, `name`, `email`, `logo_url`) VALUES
  (1, 'EUROTraining', 'kpapavramidis@mastgroup.gr', 'http://virtus-project.eu/wp-content/uploads/2016/03/eurotraining-logo-e1459274552478.jpg'),
  (2, 'EuropeanProgress', 'giampoulaki@europeanprogress.gr', 'http://virtus-project.eu/wp-content/uploads/2016/03/EUROPEAN-PROGRESS-LOGO-e1459274456103.jpg'),
  (3, 'BEST', 'office@best.at', 'http://virtus-project.eu/wp-content/uploads/2016/03/BEST-Logo-gro%C3%9F-e1459273908202.jpg'),
  (4, 'FFeuskadi', 'lorena.corral@ffeuskadi.net', 'http://virtus-project.eu/wp-content/uploads/2016/03/Logo-FFE-e1459273835655.jpg'),
  (5, 'cesie', 'irene.pizzo@cesie.org', 'http://virtus-project.eu/wp-content/uploads/2016/03/CESIE_Logo_jpg-e1459273896421.jpg');



--
-- Data for table `users`
--

INSERT INTO `users` (`email`, `given_name`, `family_name`, `role`, `openIdConnectSub`, `date_created`, `date_updated`)
VALUES
  ('petersommerhoff@gmail.com', 'Peter', 'Sommerhoff', 1, 'bfc09ba5-b56d-4647-a83e-c1ce153d1230', '2016-11-17 14:33:49',
   '2016-11-17 14:33:49'),
  ('tilman.berres@rwth-aachen.de', 'Tilman', 'Berres', 1, '1cec8880-664d-4307-bf4f-7569161041ed', '2016-11-19 12:42:35',
   '2016-11-19 12:42:35'),
  ('lauri.euren@rwth-aachen.de', 'Lauri', 'Euren', 1, 'b7221a72-2c14-4525-a840-2d0703cc494d', '2016-11-20 14:33:49',
   '2016-11-20 14:33:49');


--
-- Data for table `courses`
--

INSERT INTO `courses` (`id`, `lang`, `name`, `description`, `domain`, `profession`, `creator`, `date_created`, `date_updated`)
VALUES
  (1, 'en', 'Social Entrepreneurship 101', 'This course introduces the basic principles of Social Entrepreneurship', 1,
   'Social Entrepreneur', 'kpapavramidis@mastgroup.gr', '2016-11-20 18:04:43', '2016-11-20 18:04:43'),
  (1, 'de', 'Social Entrepreneurship Einführung', 'Dieser Kurs behandelt die Grundlagen des Social Entrepreneurship', 1,
   'Social Entrepreneur', 'kpapavramidis@mastgroup.gr', '2016-11-20 18:04:43', '2016-11-20 18:04:43'),
  (1, 'es', 'Curso de Social Entrepreneurship', 'Este curso es sobre los fundamentos del Social Entrepreneurship', 1,
   'Social Entrepreneur', 'kpapavramidis@mastgroup.gr', '2016-11-20 18:04:43', '2016-11-20 18:04:43'),
  (2, 'en', 'Case Study: Endeavor Greece', 'This case study discusses the Endeavor Greece project and highlights learning takeaways for Social Enterprises', 1,
   'Social Entrepreneur', 'kpapavramidis@mastgroup.gr', '2016-11-20 18:04:43', '2016-11-20 18:04:43'),
  (3, 'en', 'Ernesto Sirolli\'s approach to Social Entrepreneurship', 'This course covers the key learning points Ernesto Sirolli during his career as a coach for Social Enterprises', 1,
   'Social Entrepreneur', 'kpapavramidis@mastgroup.gr', '2016-11-20 18:04:43', '2016-11-20 18:04:43'),
  (4, 'en', 'Scaling the Social Enterprise', 'Learn how to increase your reach with your Social Enterprise', 1,
   'Social Entrepreneur', 'kpapavramidis@mastgroup.gr', '2016-11-20 18:04:43', '2016-11-20 18:04:43'),
  (5, 'en', 'Flight Booking Course', 'In this course you will learn to book flights for a customer.', 2,
   'Hotel Booker', 'giampoulaki@europeanprogress.gr', '2016-11-20 18:04:34', '2016-11-20 18:04:34');
   

--
-- Data for table `course_units`
--

INSERT INTO `course_units` (`id`, `lang`, `title`, `description`, `start_date`, `points`, `date_created`, `date_updated`)
VALUES
  (1, 'en', 'Introduction to Social Entrepreneurship', 'The basics of Social Entrepreneurship explained. What is social value and why we must have an impact on it?',
   '2016-12-01 09:00:00', 12, '2016-11-20 18:05:43', '2016-11-20 18:05:43'),
  (2, 'en', 'Assessing Your Inner Potential', 'What factors make people successful? How to further develop these factors in yourself?',
  '2016-12-07 09:00:00', 12, '2016-11-20 18:06:43', '2016-11-20 18:06:43'),
  (3, 'en', 'From Ideas To Action', 'Once being able to assess capabilities, we look, how do these capabilities turn into beneficial action.',
   '2016-12-14 09:00:00', 12, '2016-11-20 18:07:43', '2016-11-20 18:07:43'),
  (4, 'en', 'Role Of Technology', 'What is the role of technology in social entrepreneurship nowadays?',
   '2016-12-21 09:00:00', 12, '2016-11-20 18:08:43', '2016-11-20 18:08:43'),
  (5, 'en', 'Putting It All Together', 'We recap the main takeaways from this course.',
   '2016-12-21 09:00:00', 12, '2016-11-20 18:08:43', '2016-11-20 18:08:43'),

  (1, 'es', 'Historia del Social Entrepreneurship', 'Echamos un vistazo a algunos de los mayores empresarios sociales y ver lo que tienen en común. También concluimos el curso con un breve resumen.',
   '2016-04-01 09:00:00', 12, '2016-11-20 18:09:43', '2016-11-20 18:10:43'),
  (2, 'es', 'Introducción al Social Entrepreneurship', 'Los fundamentos del Social Entrepreneurship explicado. ¿Qué es el valor social y por qué debemos tener un impacto en él?',
   '2016-12-01 09:00:00', 12, '2016-11-20 18:05:43', '2016-11-20 18:05:43'),
  (3, 'es', 'Evaluación de su potencial interno', '¿Qué factores hacen que la gente tenga éxito? ¿Cómo desarrollar más estos factores en sí mismo?',
   '2016-12-07 09:00:00', 12, '2016-11-20 18:06:43', '2016-11-20 18:06:43'),
  (4, 'es', 'De las Ideas a la Acción', 'Una vez que seamos capaces de evaluar las capacidades, miramos cómo estas capacidades se convierten en acciones beneficiosas.',
   '2016-12-14 09:00:00', 12, '2016-11-20 18:07:43', '2016-11-20 18:07:43'),
  (5, 'es', 'Poniendolo todo junto', '¿Qué factores hacen que la gente tenga éxito? ¿Cómo desarrollar más estos factores en sí mismo?',
   '2016-12-07 09:00:00', 12, '2016-11-20 18:06:43', '2016-11-20 18:06:43');

   
--
-- Data for table `course_to_unit`
--

INSERT INTO `course_to_unit` (`course_id`, `course_lang`, `unit_id`, `unit_lang`)
VALUES
  (1, 'en', 1, 'en'),
  (1, 'en', 2, 'en'),
  (1, 'en', 3, 'en'),
  (1, 'en', 4, 'en'),
  (1, 'en', 5, 'en'),
  (1, 'es', 1, 'es'),
  (1, 'es', 2, 'es'),
  (1, 'es', 3, 'es'),
  (1, 'es', 4, 'es'),
  (1, 'es', 5, 'es');