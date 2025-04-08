-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 08 2025 г., 23:59
-- Версия сервера: 8.0.30
-- Версия PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `belik_project_05`
--

-- --------------------------------------------------------

--
-- Структура таблицы `belik_231`
--

CREATE TABLE `belik_231` (
  `id` int NOT NULL,
  `username` varchar(32) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `belik_231`
--

INSERT INTO `belik_231` (`id`, `username`, `phone`, `password`, `created_at`) VALUES
(1, 'Igor', '+79312398592', '$2y$10$Au6kcuWOvbx.kjBRPooINe8zrX6zChQCrYv1MxPuvPQKdenN132Da', '2025-04-08 20:48:56'),
(2, 'Belik', '+72293122222', '$2y$10$YHbB5r4zaTvssidQDnvEm.lTxLT9hPpxvpJabbHFxzMYYqPrYsN6W', '2025-04-08 20:55:05'),
(3, 'kgjhklerter', '+79312385692', '$2y$10$NeTIhX6RL20Uc6wWpt4ga.WEIcteotVHX2sUnmfREPvco9RhkPYaa', '2025-04-08 20:56:40'),
(5, 'fghrtygfhrty', '+79312386745', '$2y$10$Ig61f6lyfj3GUZrhORxqA.t8SjUKwqHIWSWrBUsfR3XZb19xgGgXO', '2025-04-08 20:58:35'),
(6, 'ghfrtygfh', '89312386745', '$2y$10$mg/yfp4ek.ygp5JGyM9BIOMSFeD.t0/80QDqKc1AUx1t17rhk8DNu', '2025-04-08 20:58:53');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `belik_231`
--
ALTER TABLE `belik_231`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `belik_231`
--
ALTER TABLE `belik_231`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
