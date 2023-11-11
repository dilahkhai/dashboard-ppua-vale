-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2023 at 12:28 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `performancepp`
--

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `area` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`id`, `area`, `created_at`, `updated_at`) VALUES
(1, 'Furnace-Converter', NULL, NULL),
(2, 'Dryer-Kiln', NULL, NULL),
(3, 'Infrastructure', NULL, NULL),
(4, 'Utulities', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cruduser`
--

CREATE TABLE `cruduser` (
  `id_pegawai` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `area` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`) VALUES
(1, 'RND'),
(2, 'Automation project'),
(3, 'Tech. Support'),
(4, 'Management'),
(5, 'Maintenance');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id_employee` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `departement` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kaizen`
--

CREATE TABLE `kaizen` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `value` int(11) NOT NULL,
  `area_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kaizen`
--

INSERT INTO `kaizen` (`id`, `value`, `area_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2022-10-14 15:46:31', '2022-10-14 15:46:31');

-- --------------------------------------------------------

--
-- Table structure for table `knowledge`
--

CREATE TABLE `knowledge` (
  `id_knowledge` bigint(20) UNSIGNED NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `knowledge`
--

INSERT INTO `knowledge` (`id_knowledge`, `file`, `created_at`, `updated_at`) VALUES
(1, 'http://10.226.133.150/upload/1664442418.pdf', '2022-09-29 16:06:58', '2022-09-29 16:06:58'),
(2, 'http://10.226.133.150/upload/1664442435.pdf', '2022-09-29 16:07:15', '2022-09-29 16:07:15'),
(3, 'http://10.226.133.150/upload/1664442972.jpg', '2022-09-29 16:16:12', '2022-09-29 16:16:12'),
(4, 'http://10.226.133.150/upload/1664443239.jpg', '2022-09-29 16:20:39', '2022-09-29 16:20:39'),
(5, 'http://10.226.133.150/upload/1664519739.PNG', '2022-09-30 13:35:39', '2022-09-30 13:35:39'),
(6, 'http://10.226.133.150/upload/1664521855.png', '2022-09-30 14:10:55', '2022-09-30 14:10:55'),
(7, 'http://10.226.133.150/upload/1664521995.PNG', '2022-09-30 14:13:15', '2022-09-30 14:13:15');

-- --------------------------------------------------------

--
-- Table structure for table `landing_page_images`
--

CREATE TABLE `landing_page_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `landing_page_images`
--

INSERT INTO `landing_page_images` (`id`, `file`, `created_at`, `updated_at`) VALUES
(1, 'http://127.0.0.1:8000/upload/1663914292.jpg', '2022-09-23 13:24:52', '2022-09-23 13:24:52'),
(2, 'http://10.226.133.150/upload/1664436953.jpg', '2022-09-29 14:35:53', '2022-09-29 14:35:53');

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

CREATE TABLE `links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `source` int(11) NOT NULL,
  `target` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `man_hours`
--

CREATE TABLE `man_hours` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `update` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `man_hours`
--

INSERT INTO `man_hours` (`id`, `employee_id`, `update`, `created_at`, `updated_at`) VALUES
(1, 5, 184, '2022-09-23 13:37:35', '2022-09-23 13:37:35'),
(2, 3, 176, '2022-09-23 13:37:36', '2022-09-23 13:37:36'),
(3, 4, 163.433, '2022-09-23 13:37:36', '2022-09-23 13:37:36');

-- --------------------------------------------------------

--
-- Table structure for table `mcu`
--

CREATE TABLE `mcu` (
  `id_mcu` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `lastmcu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duedate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mcu`
--

INSERT INTO `mcu` (`id_mcu`, `employee_id`, `lastmcu`, `duedate`, `status`, `created_at`, `updated_at`) VALUES
(1, 10, '2023-08-08', '2024-07-16', 'DONE', '2023-10-16 01:40:11', '2023-10-16 01:40:23');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2009_08_28_030410_create_areas_table', 1),
(2, '2014_10_12_000000_create_users_table', 1),
(3, '2014_10_12_025636_department', 1),
(4, '2014_10_12_100000_create_password_resets_table', 1),
(5, '2019_08_19_000000_create_failed_jobs_table', 1),
(6, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(7, '2022_07_04_154345_create_statusperday_table', 1),
(8, '2022_07_05_021009_create_productivity_table', 1),
(9, '2022_07_05_050158_create_employee_table', 1),
(10, '2022_07_29_123020_create_oncall_table', 1),
(11, '2022_07_30_080218_create_knowledge_table', 1),
(12, '2022_07_30_103018_create_mcu_table', 1),
(13, '2022_07_30_150059_create_cruduser_table', 1),
(14, '2022_08_28_030111_create_safety_reports_table', 1),
(15, '2022_08_28_030228_create_working_time_per_weeks_table', 1),
(16, '2022_09_13_081153_create_manhours_table', 1),
(17, '2022_09_13_093455_create_organization_structures_table', 1),
(18, '2022_09_13_093516_create_kaizen_table', 1),
(19, '2022_09_17_021742_create_status_mcus_table', 1),
(20, '2022_09_17_024753_create_wfh_roosters_table', 1),
(21, '2022_09_17_024828_create_mods_table', 1),
(22, '2022_09_17_024914_create_landing_page_images_table', 1),
(23, '2022_09_17_133037_create_tasks_table', 1),
(24, '2022_09_17_133108_create_links_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mods`
--

CREATE TABLE `mods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mods`
--

INSERT INTO `mods` (`id`, `file`, `created_at`, `updated_at`) VALUES
(1, 'http://10.226.133.150/upload/1664520377.PNG', '2022-09-30 13:46:17', '2022-09-30 13:46:17'),
(2, 'http://10.226.133.150/upload/1664520429.PNG', '2022-09-30 13:47:09', '2022-09-30 13:47:09'),
(3, 'http://10.226.133.150/upload/1664875030.pdf', '2022-10-04 16:17:10', '2022-10-04 16:17:10'),
(4, 'http://10.226.133.150/upload/1664875154.jpg', '2022-10-04 16:19:14', '2022-10-04 16:19:14');

-- --------------------------------------------------------

--
-- Table structure for table `oncall`
--

CREATE TABLE `oncall` (
  `id_oncall` bigint(20) UNSIGNED NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oncall`
--

INSERT INTO `oncall` (`id_oncall`, `file`, `created_at`, `updated_at`) VALUES
(1, 'http://10.226.133.150/upload/1664521680.png', '2022-09-30 14:08:00', '2022-09-30 14:08:00'),
(2, 'http://10.226.133.150/upload/1669281336.JPG', '2022-11-24 17:15:36', '2022-11-24 17:15:36');

-- --------------------------------------------------------

--
-- Table structure for table `organization_structures`
--

CREATE TABLE `organization_structures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `value` int(11) NOT NULL,
  `area_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `productivity`
--

CREATE TABLE `productivity` (
  `id_productivity` bigint(20) UNSIGNED NOT NULL,
  `area_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `update` double DEFAULT NULL,
  `selisih` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `productivity`
--

INSERT INTO `productivity` (`id_productivity`, `area_id`, `department_id`, `update`, `selisih`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 3, 97, '2023-10-16 01:54:52', '2023-10-16 01:54:52'),
(2, 1, 2, 1, 99, '2023-10-16 01:54:52', '2023-10-16 01:54:52'),
(3, 1, 3, 9, 91, '2023-10-16 01:54:52', '2023-10-16 01:54:52'),
(4, 1, 4, 1, 99, '2023-10-16 01:54:52', '2023-10-16 01:54:52'),
(5, 1, 5, 1, 99, '2023-10-16 01:54:52', '2023-10-16 01:54:52');

-- --------------------------------------------------------

--
-- Table structure for table `safety_reports`
--

CREATE TABLE `safety_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `count` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `statusperday`
--

CREATE TABLE `statusperday` (
  `id_status` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `office` int(11) DEFAULT NULL,
  `ho` int(11) DEFAULT NULL,
  `training` int(11) DEFAULT NULL,
  `sick_leave` int(11) DEFAULT NULL,
  `annual_leave` int(11) DEFAULT NULL,
  `emergency_leave` int(11) DEFAULT NULL,
  `medical_leave` int(11) DEFAULT NULL,
  `maternity_leave` int(11) DEFAULT NULL,
  `wta` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statusperday`
--

INSERT INTO `statusperday` (`id_status`, `employee_id`, `office`, `ho`, `training`, `sick_leave`, `annual_leave`, `emergency_leave`, `medical_leave`, `maternity_leave`, `wta`, `created_at`, `updated_at`) VALUES
(1, 9, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-10-14 15:33:48', '2022-10-14 15:33:48'),
(2, 11, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '2022-10-14 15:33:48', '2022-10-14 15:33:48'),
(3, 12, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-10-14 15:33:48', '2022-10-14 15:33:48'),
(4, 14, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-10-14 15:33:48', '2022-10-14 15:33:48'),
(5, 9, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-24 17:51:16', '2022-11-24 17:51:16'),
(6, 11, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-24 17:51:16', '2022-11-24 17:51:16'),
(7, 12, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-24 17:51:16', '2022-11-24 17:51:16'),
(8, 14, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-24 17:51:16', '2022-11-24 17:51:16'),
(9, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-16 02:00:52', '2023-10-16 02:00:52'),
(10, 11, 8, NULL, 7, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-16 02:00:52', '2023-10-16 02:00:52'),
(11, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-16 02:00:52', '2023-10-16 02:00:52'),
(12, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-16 02:00:52', '2023-10-16 02:00:52'),
(13, 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-16 02:00:52', '2023-10-16 02:00:52');

-- --------------------------------------------------------

--
-- Table structure for table `status_mcus`
--

CREATE TABLE `status_mcus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `value` int(11) NOT NULL,
  `area_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `area_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `priority` enum('Low','Med','High') COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `status` enum('Not Started','In Progress','Complete','Overdue') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `area_id`, `name`, `user_id`, `priority`, `duration`, `start_date`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 'relocation', 1, 'Med', 12, '2023-07-11 00:00:00', 'In Progress', '2023-09-19 19:11:46', '2023-09-19 19:11:50'),
(2, NULL, 'Relocation', 10, 'Med', 150, '2023-08-08 00:00:00', 'In Progress', '2023-10-16 01:04:52', '2023-10-16 01:04:52');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `area_id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `confirmpassword` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `area_id`, `username`, `email_verified_at`, `password`, `confirmpassword`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Wasthy Novantri', 3, 'admin01', NULL, '$2y$10$9SxUjF3X20XGNp1CCNoSXO6LP3Ad4tRdG7OULeXBmauMvfv2rq/2C', 'pcn@2022', 'admin', NULL, NULL, '2022-09-30 13:54:53'),
(2, 'Syawal Ali', 2, 'syawal', NULL, '$2y$10$471hkuO/G22QlIxpk5AB..CArrh4mljOU8xJYbxDtw1OSUYAZQk4q', 'pcn@2022', '$2y$10$dDvApDlHNYgfpUKqrWfkwOJlwmosAjiYoLiIUsEA1me9W98RG/Su6', NULL, NULL, '2022-09-30 13:55:59'),
(3, 'Muh. Irfan', 3, 'mirfan', NULL, '$2y$10$pxxbT4JNkRMhoEE.j4qP/evVColuvyRlEHqfTSvUNb0mISscgn.Au', 'pcn@2022', 'user', NULL, '2022-09-23 13:20:04', '2022-09-23 13:20:04'),
(4, 'Reza Jalaluddin', 3, 'rjalaluddin', NULL, '$2y$10$IeR11kc5TvSpHg4qY3V/DO0tuXDYnpfbdlyXblLkBxV7m2jv/6wa.', 'pcn@2022', 'user', NULL, '2022-09-23 13:26:38', '2022-09-30 13:53:28'),
(5, 'Gatzy', 3, 'mgatzy', NULL, '$2y$10$ywsT1QVLI.bYdzv44eu0duZE2t5AJSsvNye6pIDyIdmSDUbEpfUzu', 'pcn@2022', 'user', NULL, '2022-09-23 13:27:04', '2022-09-23 13:27:04'),
(6, 'Muh. Akbar', 3, 'ridwana', NULL, '$2y$10$WtklqkKahZUpkJ9LvOfPr.64q3Q6Mi.mOZhcKGlQE4fTgNLO7LMmS', 'pcn@2022', 'user', NULL, '2022-09-30 13:54:20', '2022-09-30 13:54:20'),
(7, 'Ichwan Andrianto', 2, 'andrii', NULL, '$2y$10$W.vMtjVNlkuXza1ZSg8YxuTCR1LuK4DvkvPoGubKc59OypJ/0/MY6', 'pcn@2022', 'user', NULL, '2022-09-30 13:56:31', '2022-09-30 13:56:31'),
(8, 'Amelia Febrina', 2, 'afebrina', NULL, '$2y$10$dOWsQswYHThaAODwohziN.0Jn1wpyMNCMHcQiXWHiZiCGSYJUATCe', 'pcn@2022', 'user', NULL, '2022-09-30 13:57:01', '2022-09-30 13:57:01'),
(9, 'Suherman K', 1, 'suhermank', NULL, '$2y$10$QPVOMPjl.0nDd0WjcmEtOOHd27VSOOQHfwWOgwxyFglNqb1K2Tmpu', 'pcn@2022', 'user', NULL, '2022-09-30 13:58:25', '2022-09-30 13:58:25'),
(10, 'Hardiyanto', 2, 'hardiyanto', NULL, '$2y$10$eyCK/6BV9M2/deLxRqJTEutDkqndcpf82mbKFrDKRltWuHJA3estS', 'pcn@2022', 'user', NULL, '2022-09-30 13:58:52', '2022-09-30 13:58:52'),
(11, 'Nasrianto', 1, 'nasrianto', NULL, '$2y$10$F0RmpkqRflWD2qCFZCteMuGJWdefTgKz4/pucppotsaD2H2hKHFAO', 'pcn@2022', 'user', NULL, '2022-09-30 13:59:14', '2022-09-30 13:59:14'),
(12, 'Ray Hapri Sitepu', 1, 'raysitepu', NULL, '$2y$10$4rEL26MtKdk9Zs7far.2buwsEE/uVjXiaOV/AApBd0kdYnl5DrRhG', 'pcn@2022', 'user', NULL, '2022-09-30 13:59:54', '2022-09-30 13:59:54'),
(13, 'Busyairi', 4, 'busyairi', NULL, '$2y$10$sTrtKYy3UWPel/8j7T3Eh.zDuNG3cGSBbOFxWHh1ez8eXuF5jXM3i', 'pcn@2022', 'user', NULL, '2022-09-30 14:00:13', '2022-09-30 14:00:13'),
(14, 'Lina Tandioga', 1, 'linat', NULL, '$2y$10$Xde4z1R0mYOcCVN8c1sdI.6Zo8hMHTLVieRKpuhcP0tw6iRUfO8eS', 'pcn@2022', 'user', NULL, '2022-09-30 14:00:51', '2022-09-30 14:00:51'),
(15, 'Gunawan', 2, 'gunawan', NULL, '$2y$10$eSoxfk5V4qKw9i1VFeDTAevQB5.lwTb1YwBWW32hh/IU.oGiCPJB2', 'pcn@2022', 'user', NULL, '2022-09-30 14:01:23', '2022-09-30 14:01:23'),
(16, 'Wahyudi Sauri', 4, 'wahyudi', NULL, '$2y$10$pyhU8ApIlScZPb3YlcQ3NObfWY4w2Ab.r8ACkng9zlAmaLlNBMDYi', 'pcn@2022', 'user', NULL, '2022-09-30 14:01:51', '2022-09-30 14:01:51'),
(17, 'Aulya Sri Utami', 4, 'aulya', NULL, '$2y$10$AMZANP/HuAiqgYMCkaciAOUg3nOMM8vxdxQM6HVB2h933y/TRSZU6', 'pcn@2022', 'user', NULL, '2022-09-30 14:02:55', '2022-09-30 14:02:55'),
(18, 'Ezmeralda Cloudyana', 4, 'ezmeralda', NULL, '$2y$10$UajonqsE9atLxj9vph.ine6NYR6IlqgTQEx2pyPNErBO/moQ8/V0O', 'pcn@2022', 'user', NULL, '2022-09-30 14:03:32', '2022-09-30 14:03:32'),
(19, 'Muhammad Thaufiq Hidayat', 1, 'thaufiq', NULL, '$2y$10$w4UpVPxjdkFcawrphvcieOrtbbaviGB32uY8sAqPp8h8deEjfR/8y', 'pcn@2022', 'user', NULL, '2023-03-06 19:39:54', '2023-03-06 19:39:54');

-- --------------------------------------------------------

--
-- Table structure for table `wfh_roosters`
--

CREATE TABLE `wfh_roosters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wfh_roosters`
--

INSERT INTO `wfh_roosters` (`id`, `file`, `created_at`, `updated_at`) VALUES
(1, 'http://10.226.133.150/upload/1664522362.PNG', '2022-09-30 14:19:22', '2022-09-30 14:19:22'),
(2, 'http://10.226.133.150/upload/1664875539.jpg', '2022-10-04 16:25:39', '2022-10-04 16:25:39');

-- --------------------------------------------------------

--
-- Table structure for table `working_time_per_weeks`
--

CREATE TABLE `working_time_per_weeks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `update` double DEFAULT NULL,
  `selisih` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `working_time_per_weeks`
--

INSERT INTO `working_time_per_weeks` (`id`, `employee_id`, `update`, `selisih`, `created_at`, `updated_at`) VALUES
(1, 4, 0, 100, '2022-09-23 13:35:13', '2022-09-23 13:35:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cruduser`
--
ALTER TABLE `cruduser`
  ADD PRIMARY KEY (`id_pegawai`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id_employee`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `kaizen`
--
ALTER TABLE `kaizen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kaizen_area_id_foreign` (`area_id`);

--
-- Indexes for table `knowledge`
--
ALTER TABLE `knowledge`
  ADD PRIMARY KEY (`id_knowledge`);

--
-- Indexes for table `landing_page_images`
--
ALTER TABLE `landing_page_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `man_hours`
--
ALTER TABLE `man_hours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `man_hours_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `mcu`
--
ALTER TABLE `mcu`
  ADD PRIMARY KEY (`id_mcu`),
  ADD KEY `mcu_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mods`
--
ALTER TABLE `mods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oncall`
--
ALTER TABLE `oncall`
  ADD PRIMARY KEY (`id_oncall`);

--
-- Indexes for table `organization_structures`
--
ALTER TABLE `organization_structures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organization_structures_area_id_foreign` (`area_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `productivity`
--
ALTER TABLE `productivity`
  ADD PRIMARY KEY (`id_productivity`),
  ADD KEY `productivity_department_id_foreign` (`department_id`),
  ADD KEY `productivity_area_id_foreign` (`area_id`);

--
-- Indexes for table `safety_reports`
--
ALTER TABLE `safety_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `safety_reports_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `statusperday`
--
ALTER TABLE `statusperday`
  ADD PRIMARY KEY (`id_status`),
  ADD KEY `statusperday_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `status_mcus`
--
ALTER TABLE `status_mcus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status_mcus_area_id_foreign` (`area_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_area_id_foreign` (`area_id`),
  ADD KEY `tasks_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD KEY `users_area_id_foreign` (`area_id`);

--
-- Indexes for table `wfh_roosters`
--
ALTER TABLE `wfh_roosters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `working_time_per_weeks`
--
ALTER TABLE `working_time_per_weeks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `working_time_per_weeks_employee_id_foreign` (`employee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cruduser`
--
ALTER TABLE `cruduser`
  MODIFY `id_pegawai` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id_employee` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kaizen`
--
ALTER TABLE `kaizen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `knowledge`
--
ALTER TABLE `knowledge`
  MODIFY `id_knowledge` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `landing_page_images`
--
ALTER TABLE `landing_page_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `links`
--
ALTER TABLE `links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `man_hours`
--
ALTER TABLE `man_hours`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mcu`
--
ALTER TABLE `mcu`
  MODIFY `id_mcu` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `mods`
--
ALTER TABLE `mods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `oncall`
--
ALTER TABLE `oncall`
  MODIFY `id_oncall` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `organization_structures`
--
ALTER TABLE `organization_structures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `productivity`
--
ALTER TABLE `productivity`
  MODIFY `id_productivity` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `safety_reports`
--
ALTER TABLE `safety_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `statusperday`
--
ALTER TABLE `statusperday`
  MODIFY `id_status` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `status_mcus`
--
ALTER TABLE `status_mcus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `wfh_roosters`
--
ALTER TABLE `wfh_roosters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `working_time_per_weeks`
--
ALTER TABLE `working_time_per_weeks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kaizen`
--
ALTER TABLE `kaizen`
  ADD CONSTRAINT `kaizen_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `man_hours`
--
ALTER TABLE `man_hours`
  ADD CONSTRAINT `man_hours_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mcu`
--
ALTER TABLE `mcu`
  ADD CONSTRAINT `mcu_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `organization_structures`
--
ALTER TABLE `organization_structures`
  ADD CONSTRAINT `organization_structures_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `productivity`
--
ALTER TABLE `productivity`
  ADD CONSTRAINT `productivity_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productivity_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `safety_reports`
--
ALTER TABLE `safety_reports`
  ADD CONSTRAINT `safety_reports_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `statusperday`
--
ALTER TABLE `statusperday`
  ADD CONSTRAINT `statusperday_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `status_mcus`
--
ALTER TABLE `status_mcus`
  ADD CONSTRAINT `status_mcus_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tasks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `working_time_per_weeks`
--
ALTER TABLE `working_time_per_weeks`
  ADD CONSTRAINT `working_time_per_weeks_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
