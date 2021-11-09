-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 09 2021 г., 19:55
-- Версия сервера: 5.7.33
-- Версия PHP: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `school_site`
--
CREATE DATABASE IF NOT EXISTS `school_site` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `school_site`;

-- --------------------------------------------------------

--
-- Структура таблицы `content_about`
--

DROP TABLE IF EXISTS `content_about`;
CREATE TABLE `content_about` (
  `id` int(11) NOT NULL,
  `for_block` text NOT NULL,
  `type` text NOT NULL,
  `title` text,
  `check_abs_link` tinyint(1) NOT NULL DEFAULT '0',
  `link` text,
  `type_link` text,
  `content` text,
  `prioritiy` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `content_about`
--

INSERT INTO `content_about` (`id`, `for_block`, `type`, `title`, `check_abs_link`, `link`, `type_link`, `content`, `prioritiy`) VALUES
(1, 'commin', 'link', 'Сслыка 1', 0, 'https://www.php.net/manual/ru/language.oop5.decon.php', 'word', NULL, 0),
(2, 'common', 'link', 'Сслыка 2', 0, 'https://coderoad.ru/1034621/%D0%9F%D0%BE%D0%BB%D1%83%D1%87%D0%B8%D1%82%D1%8C-%D1%82%D0%B5%D0%BA%D1%83%D1%89%D0%B8%D0%B9-URL-%D1%81-JavaScript', 'pdf', NULL, 0),
(3, 'common', 'link', 'Сслыка 3', 0, 'https://www.php.net/manual/ru/language.oop5.decon.php', 'word', NULL, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `login` text NOT NULL,
  `password` text NOT NULL,
  `hash` text,
  `status` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `login`, `password`, `hash`, `status`) VALUES
(1, 'Владимир', 'q1zin', '1234', '123', 'admin');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `content_about`
--
ALTER TABLE `content_about`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `content_about`
--
ALTER TABLE `content_about`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
