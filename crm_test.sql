-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Дек 19 2017 г., 00:46
-- Версия сервера: 5.7.20-0ubuntu0.16.04.1
-- Версия PHP: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `crm_test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `fos_user`
--

CREATE TABLE `fos_user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `fos_user`
--

INSERT INTO `fos_user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`) VALUES
(1, 'Vdf', 'vdf', 'vms@mail.ru', 'vms@mail.ru', 1, NULL, '$2y$13$g8u7g.RaECfuQHpx6f5Gs.yZb5H2OTTySAKWt28Nz1ySXTV/aH3Fm', '2017-12-11 14:28:59', NULL, NULL, 'a:0:{}'),
(2, 'dd', 'dd', 'dd@mail.ru', 'dd@mail.ru', 1, NULL, '$2y$13$YymtY5Sn1GOm1PvQicwyHehVU63JYC4ebqfdb1FyZi6UQDzVSwOiK', '2017-12-15 13:45:26', NULL, NULL, 'a:0:{}'),
(3, 'msyniuk', 'msyniuk', 'msyniuk@gmail.com', 'msyniuk@gmail.com', 1, NULL, '$2y$13$kJqsf3XC2/dSHlW4R1.6.eRdHvL8euMOKVK05hd9CeW8BxgdtvzNm', NULL, NULL, NULL, 'a:0:{}'),
(4, 'corben1979', 'corben1979', 'corben1979@mail.ru', 'corben1979@mail.ru', 1, NULL, '$2y$13$C5wN6i.gm/NsVeqpHf9ahuz69wRK3sbFJpmvJBr5lIo7f396Lxzhu', NULL, NULL, NULL, 'a:0:{}'),
(5, 'vasco', 'vasco', 'vasco1984@mail.ru', 'vasco1984@mail.ru', 1, NULL, '$2y$13$iJp4UByn/CxOjo50Y3.pHei7ok.ZMV9c2THn2NUrgcd1Z7UNr5ANK', NULL, NULL, NULL, 'a:0:{}'),
(6, 'admin', 'admin', 'admin@mail.ru', 'admin@mail.ru', 1, NULL, '$2y$13$.XVhmCVNNO1Kl9kOteDak.AFvTFcOE8TtuqJY6ZjY46N7lI8/mnIu', '2017-12-15 13:46:47', NULL, NULL, 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}'),
(7, 'administrator', 'administrator', 'support@bad.ru', 'support@bad.ru', 1, NULL, '$2y$13$E9bspWEZjNhUoltaKqMrs.9vD8to73g3AAXJZVHqHzCkGbtBNs2pO', NULL, NULL, NULL, 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}');

-- --------------------------------------------------------

--
-- Структура таблицы `report`
--

CREATE TABLE `report` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `hours` int(11) NOT NULL,
  `comment` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `report`
--

INSERT INTO `report` (`id`, `user_id`, `date`, `hours`, `comment`) VALUES
(2, 1, '2017-12-06', 99, 'Kuku'),
(3, 2, '2017-12-06', 85, 'интернет'),
(4, 3, '2017-12-04', 12, 'супер'),
(6, 4, '2017-12-05', 10, 'зашибись'),
(7, 5, '2017-12-06', 11, 'приветливый'),
(8, 1, '2017-11-17', 13, 'молодчина'),
(9, 2, '2017-11-10', 14, 'мегакрутой'),
(10, 3, '2017-11-01', 18, 'от улыбки хмурый день светлей'),
(11, 4, '2017-11-17', 19, 'Пусть бегут неуклюже'),
(12, 5, '2017-10-21', 20, 'Супер-пупер'),
(13, 2, '2017-12-28', 55, 'Лиза'),
(14, 2, '2017-12-24', 100, 'fgfgfffg'),
(15, 2, '2017-12-13', 700, 'fgfgfffg yrdhggd'),
(16, 2, '2017-12-22', 16, 'hello'),
(17, 2, '2017-12-13', 666, 'hjvkjhvjg'),
(18, 2, '2017-12-13', 666, 'hjvkjhvjg'),
(19, 2, '2017-12-11', 8754, 'hjvkjhvjg khjg h'),
(20, 2, '2017-12-11', 8754, 'hjvkjhvjg khjg h'),
(21, 2, '2017-12-11', 222, 'sdf'),
(22, 2, '2017-12-10', 3242, 'sdfgsdfh'),
(23, 2, '2017-12-13', 56, 'вася'),
(24, 6, '2017-12-03', 9, 'goodby'),
(25, 6, '2017-12-14', 23, 'ggg'),
(26, 6, '2017-12-14', 3, 'sss'),
(27, 6, '2017-12-14', 3, 'd'),
(28, 6, '2017-12-14', 5, 'admin'),
(29, 6, '2017-12-14', 1, 'xcx'),
(30, 2, '2017-12-14', 1, 'мало'),
(31, NULL, '2017-12-14', 33, 'ddd'),
(32, 6, '2017-12-14', 122, '222'),
(33, 6, '2017-12-14', 11, '1111'),
(34, 6, '2017-12-14', 11, '1111'),
(35, 2, '2017-12-15', 12, 'Лиля');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `fos_user`
--
ALTER TABLE `fos_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_957A647992FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_957A6479A0D96FBF` (`email_canonical`),
  ADD UNIQUE KEY `UNIQ_957A6479C05FB297` (`confirmation_token`);

--
-- Индексы таблицы `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C42F7784A76ED395` (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `fos_user`
--
ALTER TABLE `fos_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `report`
--
ALTER TABLE `report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `report`
--
ALTER TABLE `report`
  ADD CONSTRAINT `FK_C42F7784A76ED395` FOREIGN KEY (`user_id`) REFERENCES `fos_user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
