-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 05 2025 г., 21:19
-- Версия сервера: 10.3.22-MariaDB
-- Версия PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `bussydog`
--
CREATE DATABASE IF NOT EXISTS `bussydog` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `bussydog`;

-- --------------------------------------------------------

--
-- Структура таблицы `sys_authsessions`
--

CREATE TABLE IF NOT EXISTS `sys_authsessions` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` bigint(20) NOT NULL,
  `authtoken` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiresAt` datetime NOT NULL,
  `useragent` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ipAddr` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isTerminated` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `sys_dialogue`
--

CREATE TABLE IF NOT EXISTS `sys_dialogue` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `isPrivate` bit(1) NOT NULL DEFAULT b'1',
  `Name` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sys_dialogue`
--

INSERT INTO `sys_dialogue` (`id`, `isPrivate`, `Name`) VALUES
(1, b'1', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `sys_dialoguemessage`
--

CREATE TABLE IF NOT EXISTS `sys_dialoguemessage` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `dialogue` bigint(20) NOT NULL,
  `user` bigint(20) NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sentAt` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sys_dialoguemessage`
--

INSERT INTO `sys_dialoguemessage` (`id`, `dialogue`, `user`, `message`, `sentAt`) VALUES
(1, 1, 3, 'Привет!', '2024-03-30 23:53:14'),
(2, 1, 2, 'Привет!', '2024-03-30 23:55:14');

-- --------------------------------------------------------

--
-- Структура таблицы `sys_dialogueparticipant`
--

CREATE TABLE IF NOT EXISTS `sys_dialogueparticipant` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `dialogue` bigint(20) NOT NULL,
  `user` bigint(20) NOT NULL,
  `isOwner` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sys_dialogueparticipant`
--

INSERT INTO `sys_dialogueparticipant` (`id`, `dialogue`, `user`, `isOwner`) VALUES
(1, 1, 2, b'0'),
(2, 1, 3, b'0');

-- --------------------------------------------------------

--
-- Структура таблицы `sys_indexwidgets`
--

CREATE TABLE IF NOT EXISTS `sys_indexwidgets` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userId` bigint(20) NOT NULL,
  `widgetId` bigint(20) DEFAULT NULL,
  `num` bigint(20) NOT NULL,
  `widgetSizeClass` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sys_indexwidgets`
--

INSERT INTO `sys_indexwidgets` (`id`, `userId`, `widgetId`, `num`, `widgetSizeClass`) VALUES
(1, 2, 1, 1, 'widget100'),
(2, 2, NULL, 0, 'widget50'),
(3, 2, NULL, 0, 'widget50'),
(4, 2, NULL, 0, 'widget50'),
(5, 2, NULL, 0, 'widget50'),
(6, 2, NULL, 0, 'widget100'),
(7, 2, NULL, 0, 'widget50'),
(8, 2, NULL, 0, 'widget50'),
(9, 2, NULL, 0, 'widget100'),
(10, 2, NULL, 0, 'widget50'),
(11, 2, NULL, 0, 'widget50'),
(12, 2, NULL, 0, 'widget100'),
(13, 2, NULL, 0, 'widget50'),
(14, 2, NULL, 0, 'widget100'),
(15, 2, NULL, 0, 'widget50'),
(16, 2, NULL, 0, 'widget50'),
(17, 2, NULL, 0, 'widget50'),
(18, 2, NULL, 0, 'widget50'),
(19, 2, NULL, 0, 'widget100'),
(20, 2, NULL, 0, 'widget100'),
(21, 2, NULL, 0, 'widget100');

-- --------------------------------------------------------

--
-- Структура таблицы `sys_indexwidgetsassembly`
--

CREATE TABLE IF NOT EXISTS `sys_indexwidgetsassembly` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `widgetId` bigint(20) NOT NULL,
  `versionNumb` bigint(20) NOT NULL,
  `isCurrent` bit(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sys_indexwidgetsassembly`
--

INSERT INTO `sys_indexwidgetsassembly` (`id`, `widgetId`, `versionNumb`, `isCurrent`) VALUES
(1, 1, 1, b'1');

-- --------------------------------------------------------

--
-- Структура таблицы `sys_interfaces`
--

CREATE TABLE IF NOT EXISTS `sys_interfaces` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `csssheetname` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sys_interfaces`
--

INSERT INTO `sys_interfaces` (`id`, `name`, `csssheetname`) VALUES
(1, 'По умолчанию', 'base-blue');

-- --------------------------------------------------------

--
-- Структура таблицы `sys_interface_buttons`
--

CREATE TABLE IF NOT EXISTS `sys_interface_buttons` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `interfaceid` bigint(20) NOT NULL,
  `buttonText` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `buttonIcon` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `num` bigint(20) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sys_interface_buttons`
--

INSERT INTO `sys_interface_buttons` (`id`, `interfaceid`, `buttonText`, `buttonIcon`, `path`, `num`) VALUES
(1, 1, 'Главная', 'house', 'index', 1),
(2, 1, 'Задачи', 'list-check', 'index', 0),
(3, 1, 'Мессенджер', 'message', 'index', 0),
(4, 1, 'Организация', 'address-card', 'OrganizationPage', 2),
(5, 1, 'База знаний', 'globe', 'wiki', 5);

-- --------------------------------------------------------

--
-- Структура таблицы `sys_positions`
--

CREATE TABLE IF NOT EXISTS `sys_positions` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user` bigint(20) DEFAULT NULL,
  `parent` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sys_positions`
--

INSERT INTO `sys_positions` (`id`, `name`, `user`, `parent`) VALUES
(1, 'Директор', 2, NULL),
(2, 'Заместитель директора технический директор', NULL, 1),
(3, 'Заместитель директора коммерческий директор', NULL, 1),
(4, 'Ядоплюй-1', 2, 2),
(5, 'Ядоплюй-2', NULL, 2),
(6, 'Ядоплюй-3', NULL, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `sys_privilege`
--

CREATE TABLE IF NOT EXISTS `sys_privilege` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `keyname` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sys_privilege`
--

INSERT INTO `sys_privilege` (`id`, `keyname`, `name`, `description`) VALUES
(1, 'all', 'Полный доступ [Debug]', 'Полный доступ без проверки прав. '),
(2, 'widget-index-edit', 'Настройка главной страницы', 'Позволяет пользователю настраивать виджеты на главной странице'),
(3, 'wiki-access', 'Просмотр базы знаний', ''),
(4, 'wiki-editor', 'Администрирование базы знаний', 'Позволяет пользователю создавать/удалять/редактировать структуры и статьи в базе знаний');

-- --------------------------------------------------------

--
-- Структура таблицы `sys_uiwidget`
--

CREATE TABLE IF NOT EXISTS `sys_uiwidget` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `visiblename` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `assembly` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sys_uiwidget`
--

INSERT INTO `sys_uiwidget` (`id`, `visiblename`, `assembly`) VALUES
(1, 'Тестовый виджет', 'Test');

-- --------------------------------------------------------

--
-- Структура таблицы `sys_usergroup`
--

CREATE TABLE IF NOT EXISTS `sys_usergroup` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sys_usergroup`
--

INSERT INTO `sys_usergroup` (`id`, `name`, `description`) VALUES
(1, 'Тест', 'Тестовая группа');

-- --------------------------------------------------------

--
-- Структура таблицы `sys_usergroup_positions`
--

CREATE TABLE IF NOT EXISTS `sys_usergroup_positions` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `usergroup` bigint(20) NOT NULL,
  `position` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sys_usergroup_positions`
--

INSERT INTO `sys_usergroup_positions` (`id`, `usergroup`, `position`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `sys_usergroup_privelege`
--

CREATE TABLE IF NOT EXISTS `sys_usergroup_privelege` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `usergroup` bigint(20) NOT NULL,
  `privilege` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sys_usergroup_privelege`
--

INSERT INTO `sys_usergroup_privelege` (`id`, `usergroup`, `privilege`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `sys_usergroup_user`
--

CREATE TABLE IF NOT EXISTS `sys_usergroup_user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `usergroup` bigint(20) NOT NULL,
  `user` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sys_usergroup_user`
--

INSERT INTO `sys_usergroup_user` (`id`, `usergroup`, `user`) VALUES
(1, 1, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `sys_wikiarticle`
--

CREATE TABLE IF NOT EXISTS `sys_wikiarticle` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` bigint(20) DEFAULT NULL,
  `isArchived` bit(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sys_wikiarticle`
--

INSERT INTO `sys_wikiarticle` (`id`, `name`, `content`, `parent`, `isArchived`) VALUES
(1, 'Тестовая статья-1', '<h1>тестовый тест</h1>', 12, b'1'),
(2, 'Тестовая статья-2', '<p>Test</p>', 12, b'0'),
(3, 'Тестовая статья-3', '<p>test1221323123</p>', 12, b'0'),
(4, 'Тестовая статья-4', '<p>1</p>', 12, b'0');

-- --------------------------------------------------------

--
-- Структура таблицы `sys_wikistructure`
--

CREATE TABLE IF NOT EXISTS `sys_wikistructure` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sys_wikistructure`
--

INSERT INTO `sys_wikistructure` (`id`, `name`, `parent`) VALUES
(12, 'Тестовая структура', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `login` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middlename` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passwordhash` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isBlocked` bit(1) NOT NULL DEFAULT b'1',
  `interface` bigint(20) NOT NULL DEFAULT 1,
  `verified` bit(1) NOT NULL DEFAULT b'1',
  `verificationToken` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photoBase64` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `inCompanyFrom` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `login`, `firstname`, `middlename`, `lastname`, `passwordhash`, `email`, `description`, `isBlocked`, `interface`, `verified`, `verificationToken`, `photoBase64`, `birthday`, `inCompanyFrom`) VALUES
(1, '1', '1', '1', '1', '1', '1', '1', b'1', 1, b'1', NULL, NULL, NULL, NULL),
(2, 'test', 'test', 'test', 'test', '1', 'test@test.ru', '1', b'0', 1, b'1', NULL, NULL, NULL, NULL),
(3, 'test3', 'test', 'test', 'test', '1', 'test3@test.ru', NULL, b'0', 1, b'1', NULL, NULL, NULL, NULL),
(5, 'test2', 'test', 'test', 'test', '1', 'test2@test.ru', NULL, b'0', 1, b'0', NULL, NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
