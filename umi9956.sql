-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Авг 23 2021 г., 17:32
-- Версия сервера: 10.3.29-MariaDB-100+deb10u1-log
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `umi9956`
--

-- --------------------------------------------------------

--
-- Структура таблицы `oneway_person_card`
--

CREATE TABLE `oneway_person_card` (
  `ID` int(10) UNSIGNED NOT NULL,
  `person_name` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `person_date` date NOT NULL,
  `person_role` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `person_city` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `person_img` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `person_descr` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

--
-- Дамп данных таблицы `oneway_person_card`
--

INSERT INTO `oneway_person_card` (`ID`, `person_name`, `person_date`, `person_role`, `person_city`, `person_img`, `person_descr`) VALUES
(1, 'Emilia Clarke', '1986-10-26', 'актриса', 'Лондон, Великобритания', 'img/img_person-1.jpg', 'Британская актриса. Наиболее известна по роли Дайнерис Таргарие в телесериале \"Игра престолов\" и Сары Коннор в фильме \"Терминатор: Генезис\".'),
(2, 'Киану Ривз', '1964-09-02', 'актёр, кинорежиссёр', 'Оттава, Канада', 'img/img_person-2.jpg', 'Канадский актёр, кинорежиссёр, кинопродюсер и музыкант (бас-гитарист). Наиболее известен своими ролями в киносериях «Матрица», «Билл и Тед»');

-- --------------------------------------------------------

--
-- Структура таблицы `oneway_person_slider`
--

CREATE TABLE `oneway_person_slider` (
  `ID` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `slide_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

--
-- Дамп данных таблицы `oneway_person_slider`
--

INSERT INTO `oneway_person_slider` (`ID`, `person_id`, `slide_url`) VALUES
(1, 1, 'img/img_slider-1-1.jpg'),
(2, 1, 'img/img_slider-1-2.jpg'),
(3, 1, 'img/img_slider-1-3.jpg'),
(4, 2, 'img/img_slider-2-1.jpg'),
(5, 2, 'img/img_slider-2-2.jpg'),
(6, 2, 'img/img_slider-2-3.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `oneway_person_slider_like`
--

CREATE TABLE `oneway_person_slider_like` (
  `ID` int(10) UNSIGNED NOT NULL,
  `slider_id` int(11) NOT NULL,
  `ip_adress` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slider_like` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

--
-- Дамп данных таблицы `oneway_person_slider_like`
--

INSERT INTO `oneway_person_slider_like` (`ID`, `slider_id`, `ip_adress`, `slider_like`) VALUES
(1, 1, '10.10.10.1', 1),
(2, 3, '10.10.10.1', 1),
(3, 3, '109.200.120.54', 0),
(4, 2, '109.200.120.54', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `oneway_person_card`
--
ALTER TABLE `oneway_person_card`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `oneway_person_slider`
--
ALTER TABLE `oneway_person_slider`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `person_id` (`person_id`);

--
-- Индексы таблицы `oneway_person_slider_like`
--
ALTER TABLE `oneway_person_slider_like`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `slider_ip` (`ip_adress`,`slider_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `oneway_person_card`
--
ALTER TABLE `oneway_person_card`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `oneway_person_slider`
--
ALTER TABLE `oneway_person_slider`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `oneway_person_slider_like`
--
ALTER TABLE `oneway_person_slider_like`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
