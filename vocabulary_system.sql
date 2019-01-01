-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th10 06, 2018 lúc 05:23 AM
-- Phiên bản máy phục vụ: 5.7.19
-- Phiên bản PHP: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `vocabulary_system`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `assignment`
--

DROP TABLE IF EXISTS `assignment`;
CREATE TABLE IF NOT EXISTS `assignment` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_user_id` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `update_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade` int(11) DEFAULT NULL,
  `instructions` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `assignment`
--

INSERT INTO `assignment` (`id`, `name`, `author_user_id`, `created_at`, `updated_at`, `date`, `status`, `update_status`, `grade`, `instructions`) VALUES
(1, 'Assign1', 1, '2018-05-21 20:09:12', '2018-05-21 20:09:12', '2018-05-22', 'Open', 'Open', NULL, 'Assign1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `essays`
--

DROP TABLE IF EXISTS `essays`;
CREATE TABLE IF NOT EXISTS `essays` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `count_letter` int(11) DEFAULT NULL,
  `session_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `title` longtext COLLATE utf8mb4_unicode_ci,
  `user_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `essays_session_id_foreign` (`session_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `essays`
--

INSERT INTO `essays` (`id`, `content`, `count_letter`, `session_id`, `created_at`, `updated_at`, `title`, `user_id`) VALUES
(1, 'dfadfad', 13, 1, '2018-05-21 20:32:13', '2018-05-21 20:32:14', 'dfadsf', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `author_user_id` int(11) NOT NULL DEFAULT '0',
  `enroll_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date DEFAULT NULL,
  `grade` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`, `created_at`, `updated_at`, `author_user_id`, `enroll_code`, `date`, `grade`) VALUES
(1, 'Group1', NULL, '2018-05-21 20:06:51', '2018-05-21 20:06:51', 1, 'EA2B', '2018-05-22', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `group_assignment`
--

DROP TABLE IF EXISTS `group_assignment`;
CREATE TABLE IF NOT EXISTS `group_assignment` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `assignment_id` int(10) UNSIGNED NOT NULL,
  `group_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_assignment_assignment_id_foreign` (`assignment_id`),
  KEY `group_assignment_group_id_foreign` (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `group_assignment`
--

INSERT INTO `group_assignment` (`id`, `assignment_id`, `group_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2018-05-21 20:09:18', '2018-05-21 20:09:18');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1246 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1239, '2018_05_08_115256_alter_groups_table_to_add_date_grade', 8),
(1240, '2018_05_08_115510_alter_words_to_add_user_id', 8),
(1241, '2018_05_08_122525_alter_assignment_table_to_add_instructions', 8),
(1242, '2018_05_09_044816_alter_essays_table_to_add_user_id', 8),
(1243, '2018_05_09_045001_alter_sentences_table_to_add_user_id', 8),
(1244, '2018_05_09_050300_alter_paragraphs_table_to_add_user_id', 8),
(629, '2018_05_08_115510_alter_words_sentences_paragraphs_essays_to_add_user_id', 7),
(544, '2018_05_08_114744_alter_assignments_table_to_add_some_fields', 6),
(545, '2018_05_08_115256_alter_groups_table_to_add_some_fields', 6),
(1245, '2018_05_16_092332_alter_sessions_table_to_add_student_id', 8),
(1214, '2014_10_12_000000_create_users_table', 8),
(1215, '2014_10_12_100000_create_password_resets_table', 8),
(1216, '2018_01_29_033759_create_groups_table', 8),
(1217, '2018_01_29_033936_create_user_group_table', 8),
(1218, '2018_01_29_034233_create_sessions_table', 8),
(1219, '2018_01_29_034543_create_words_table', 8),
(1220, '2018_01_29_034734_create_sentences_table', 8),
(1221, '2018_01_29_034830_create_essays_table', 8),
(1222, '2018_01_29_034908_create_paragraphs_table', 8),
(126, '2018_04_21_041326_alter_users_table_to_add_student_author_id', 1),
(1223, '2018_01_29_034959_create_timers_table', 8),
(1224, '2018_02_06_162120_after_timers', 8),
(1225, '2018_02_08_072310_after_essyas_table', 8),
(1226, '2018_02_21_025852_alter_users_table_to_add_role', 8),
(1227, '2018_03_04_150046_alter_users_table_to_add_parent_id', 8),
(1228, '2018_03_06_045741_alter_sessions_table_to_add_student_can_edit', 8),
(1229, '2018_03_08_154654_alter_user_group_to_add_is_confirmed', 8),
(1230, '2018_03_10_110558_alter_groups_to_add_author_user_id', 8),
(1231, '2018_04_06_053726_alter_users_table_to_add_verify_field', 8),
(1232, '2018_04_09_102749_create_assignment_table', 8),
(1233, '2018_04_10_095545_alter_group_table_add_enroll_code_field', 8),
(1234, '2018_04_21_004235_create_group_assignment_table', 8),
(1235, '2018_04_21_041326_alter_users_table_to_add_author_id', 8),
(1236, '2018_05_04_113938_add_session_assignment_id_field', 8),
(1237, '2018_05_08_114224_alter_users_table_to_add_grade', 8),
(1238, '2018_05_08_114744_alter_assignments_table_to_add_date_status_grade', 8);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `paragraphs`
--

DROP TABLE IF EXISTS `paragraphs`;
CREATE TABLE IF NOT EXISTS `paragraphs` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` longtext COLLATE utf8mb4_unicode_ci,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `count_letter` int(11) DEFAULT NULL,
  `session_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `paragraphs_session_id_foreign` (`session_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `paragraphs`
--

INSERT INTO `paragraphs` (`id`, `title`, `content`, `count_letter`, `session_id`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 'dfadsfasdf', 'dsfasdfsdf', 20, 1, '2018-05-21 20:32:09', '2018-05-21 20:32:10', 1),
(2, 'dfadsfdsa', 'adsfasdfasdfasdf', 25, 1, '2018-05-21 20:32:11', '2018-05-21 20:32:13', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sentences`
--

DROP TABLE IF EXISTS `sentences`;
CREATE TABLE IF NOT EXISTS `sentences` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `count_letter` int(11) DEFAULT NULL,
  `session_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sentences_session_id_foreign` (`session_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sentences`
--

INSERT INTO `sentences` (`id`, `content`, `count_letter`, `session_id`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 'dfadfasdfasd', 12, 1, '2018-05-21 20:32:08', '2018-05-21 20:32:08', 1),
(2, 'fadfdasfasdf', 12, 1, '2018-05-21 20:32:33', '2018-05-21 20:32:33', 1),
(3, 'dfadsfadsfdfa', 13, 1, '2018-05-21 20:32:34', '2018-05-21 20:32:34', 1),
(4, 'fadfadfadsf', 11, 1, '2018-05-21 20:32:37', '2018-05-21 20:32:37', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `is_new` tinyint(1) NOT NULL,
  `count_letter` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `student_can_edit` int(11) NOT NULL DEFAULT '0',
  `assignment_id` int(10) UNSIGNED DEFAULT NULL,
  `student_id` int(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sessions`
--

INSERT INTO `sessions` (`id`, `name`, `user_id`, `is_new`, `count_letter`, `created_at`, `updated_at`, `student_can_edit`, `assignment_id`, `student_id`) VALUES
(1, 'Session 1', 1, 0, 126, '2018-05-21 20:09:18', '2018-05-21 20:32:37', 0, 1, 2),
(2, 'Session 2', 1, 1, 0, '2018-05-21 20:18:54', '2018-05-21 20:18:54', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `timers`
--

DROP TABLE IF EXISTS `timers`;
CREATE TABLE IF NOT EXISTS `timers` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `duration` time DEFAULT NULL,
  `session_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `timers_user_id_foreign` (`user_id`),
  KEY `timers_session_id_foreign` (`session_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `timers`
--

INSERT INTO `timers` (`id`, `user_id`, `type`, `start`, `end`, `duration`, `session_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'online', '2018-05-22 03:03:31', '2018-05-22 03:03:36', '00:00:05', NULL, '2018-05-21 20:03:31', '2018-05-21 20:03:36'),
(2, 1, 'online', '2018-05-22 03:05:27', '2018-05-22 03:06:53', '00:01:26', NULL, '2018-05-21 20:05:27', '2018-05-21 20:06:53'),
(3, 1, 'online', '2018-05-22 03:09:05', '2018-05-22 03:23:23', '00:14:18', NULL, '2018-05-21 20:09:05', '2018-05-21 20:23:23'),
(4, 1, 'create_session', '2018-05-22 03:18:54', '2018-05-22 03:18:54', '00:00:00', 2, '2018-05-21 20:18:54', '2018-05-21 20:18:54'),
(5, 4, 'online', '2018-05-22 03:23:29', '2018-05-22 03:25:09', '00:01:40', NULL, '2018-05-21 20:23:29', '2018-05-21 20:25:09'),
(6, 1, 'online', '2018-05-22 03:25:37', '2018-05-22 03:25:37', '00:00:00', NULL, '2018-05-21 20:25:37', '2018-05-21 20:25:37'),
(7, 1, 'online', '2018-05-22 03:27:20', '2018-05-22 03:32:46', '00:05:26', NULL, '2018-05-21 20:27:20', '2018-05-21 20:32:46'),
(8, 4, 'online', '2018-05-22 03:32:51', '2018-05-22 03:32:58', '00:00:07', NULL, '2018-05-21 20:32:51', '2018-05-21 20:32:58'),
(9, 4, 'online', '2018-05-22 03:34:35', '2018-05-22 03:34:35', '00:00:00', NULL, '2018-05-21 20:34:35', '2018-05-21 20:34:35'),
(10, 1, 'online', '2018-05-22 03:34:43', '2018-05-22 03:34:49', '00:00:06', NULL, '2018-05-21 20:34:43', '2018-05-21 20:34:49'),
(11, 1, 'online', '2018-06-04 07:03:00', '2018-06-04 07:03:00', '00:00:00', NULL, '2018-06-04 00:03:00', '2018-06-04 00:03:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` int(11) NOT NULL DEFAULT '0',
  `parent_id` int(11) DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'not_verified',
  `confirmation_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_id` int(11) NOT NULL DEFAULT '0',
  `grade` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `parent_id`, `status`, `confirmation_code`, `author_id`, `grade`) VALUES
(1, 'admin', 'admin', 'admin@admin.com', '$2y$10$OyIFSyZO7NIhScLLZowkM.7KE8boc2UTtxV3zW.Zm/6Ev5ciSvZBe', '7gyIdR7Sbh6iQJuMki9fKrpm1q6ZERQ31Y1fiXlGGyuydEbT6mh8mA7W9WBx', NULL, NULL, 0, NULL, 'verified', NULL, 0, NULL),
(2, 'stu1', 'stu1', 'stu1@gm.com', '$2y$10$Xv4RmdW7f1ZuiR8p0F.uRuhjRobcul4I2eFbKknGmRBPPRANNQ3bu', NULL, '2018-05-21 20:05:40', '2018-05-21 20:06:02', 2, NULL, 'verified', 'hdO1o3lQ5vIxmXMAf24ZCNjOEfxKvU', 1, NULL),
(3, 'stu2', 'stu2', 'stu2@gm.com', '$2y$10$VATeiObhsAiRXPpwhntlH.cpyoreyIutReVz.umIvub9RPThOQvIm', NULL, '2018-05-21 20:05:57', '2018-05-21 20:06:03', 2, NULL, 'verified', 'WyfqBcxrY16773Uunvh0uCT2OBjoey', 1, NULL),
(4, 'tea1', 'tea1', 'tea1@gm.com', '$2y$10$iIlpQ3oAWtXWWZewDKqpoO7lyv2JgsVHbzHNPE8f1OQ9aDxAKHdpa', 'uOUrEq7WO3KkVuSrJEnzp6NM57ox7vBt9kdMOge8PFW0Xe8pSRZnmJtbb4ZQ', '2018-05-21 20:23:17', '2018-05-21 20:23:22', 1, NULL, 'verified', 'sPrClhVW6qQSVUMw5Nv0oKl6DnXsur', 1, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_group`
--

DROP TABLE IF EXISTS `user_group`;
CREATE TABLE IF NOT EXISTS `user_group` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `group_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_confirmed` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_group_user_id_foreign` (`user_id`),
  KEY `user_group_group_id_foreign` (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user_group`
--

INSERT INTO `user_group` (`id`, `user_id`, `group_id`, `created_at`, `updated_at`, `is_confirmed`) VALUES
(1, 2, 1, '2018-05-21 20:09:17', '2018-05-21 20:09:17', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `words`
--

DROP TABLE IF EXISTS `words`;
CREATE TABLE IF NOT EXISTS `words` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `count_letter` int(11) DEFAULT NULL,
  `synonym` longtext COLLATE utf8mb4_unicode_ci,
  `count_synonym` int(11) DEFAULT NULL,
  `antonym` longtext COLLATE utf8mb4_unicode_ci,
  `count_antonym` int(11) DEFAULT NULL,
  `suffix` longtext COLLATE utf8mb4_unicode_ci,
  `count_suffix` int(11) DEFAULT NULL,
  `prefix` longtext COLLATE utf8mb4_unicode_ci,
  `count_prefix` int(11) DEFAULT NULL,
  `word_type` longtext COLLATE utf8mb4_unicode_ci,
  `count_word_type` int(11) DEFAULT NULL,
  `definition` longtext COLLATE utf8mb4_unicode_ci,
  `count_definition` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `session_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `words_session_id_foreign` (`session_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `words`
--

INSERT INTO `words` (`id`, `content`, `count_letter`, `synonym`, `count_synonym`, `antonym`, `count_antonym`, `suffix`, `count_suffix`, `prefix`, `count_prefix`, `word_type`, `count_word_type`, `definition`, `count_definition`, `total`, `session_id`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 'dfasdf', 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, 1, '2018-05-21 20:32:07', '2018-05-21 20:32:07', 1),
(2, 'fadfadsf', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, 1, '2018-05-21 20:32:33', '2018-05-21 20:32:33', 1),
(3, 'dfadfa', 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, 1, '2018-05-21 20:32:35', '2018-05-21 20:32:35', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
