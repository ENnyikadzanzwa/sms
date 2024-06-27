-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2024 at 02:15 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sakiso`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `street_no` varchar(10) NOT NULL,
  `street_name` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `postal_code` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` int(11) NOT NULL,
  `school_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bank_accounts`
--

CREATE TABLE `bank_accounts` (
  `id` int(11) NOT NULL,
  `school_id` int(11) DEFAULT NULL,
  `bank_name` varchar(255) NOT NULL,
  `account_number` varchar(100) NOT NULL,
  `account_type` enum('Savings','Current') NOT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `balance` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `communications`
--

CREATE TABLE `communications` (
  `id` int(11) NOT NULL,
  `school_id` int(11) DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `message` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `exchange_rate` decimal(10,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `school_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `school_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `transaction_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

CREATE TABLE `fees` (
  `id` int(11) NOT NULL,
  `school_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `due_date` date NOT NULL,
  `status` enum('Paid','Pending','Overdue') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `school_id` int(11) DEFAULT NULL,
  `name` varchar(20) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `school_id`, `name`, `updated_at`, `created_at`) VALUES
(1, NULL, 'a', '2024-06-14 11:32:47', '2024-06-14 11:32:47'),
(2, NULL, 'a', '2024-06-14 11:32:53', '2024-06-14 11:32:53'),
(5, 12, 'ECDB', '2024-06-15 10:14:59', '2024-06-15 10:14:59'),
(6, 12, 'GRADE1', '2024-06-15 10:21:08', '2024-06-15 10:21:08'),
(7, 12, 'GRADE3', '2024-06-17 02:31:51', '2024-06-17 02:31:51'),
(8, 2, 'ECDA', '2024-06-17 05:59:22', '2024-06-17 05:59:22'),
(9, 2, 'ECDB', '2024-06-17 05:59:44', '2024-06-17 05:59:44'),
(10, 14, 'ECDA', '2024-06-17 06:45:12', '2024-06-17 06:45:12'),
(11, 14, 'ECDB', '2024-06-17 06:45:21', '2024-06-17 06:45:21');

-- --------------------------------------------------------

--
-- Table structure for table `grade_classes`
--

CREATE TABLE `grade_classes` (
  `id` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grade_classes`
--

INSERT INTO `grade_classes` (`id`, `grade_id`, `name`, `created_at`, `updated_at`) VALUES
(2, 5, 'bursar', '2024-06-15 16:16:02', '2024-06-15 16:16:02'),
(3, 6, 'emmanuel', '2024-06-17 02:32:17', '2024-06-17 02:32:17'),
(4, 8, 'Yellow', '2024-06-17 06:03:42', '2024-06-17 06:03:42'),
(5, 10, 'red', '2024-06-17 06:46:08', '2024-06-17 06:46:08');

-- --------------------------------------------------------

--
-- Table structure for table `grade_class_staff`
--

CREATE TABLE `grade_class_staff` (
  `id` int(11) NOT NULL,
  `grade_class_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grade_class_staff`
--

INSERT INTO `grade_class_staff` (`id`, `grade_class_id`, `staff_id`, `created_at`, `updated_at`) VALUES
(1, 2, 3, '2024-06-17 02:22:10', '2024-06-17 02:22:10'),
(2, 2, 2, '2024-06-17 02:31:15', '2024-06-17 02:31:15'),
(3, 4, 6, '2024-06-17 06:03:52', '2024-06-17 06:03:52'),
(4, 5, 7, '2024-06-17 06:54:39', '2024-06-17 06:54:39'),
(5, 5, 8, '2024-06-17 06:54:52', '2024-06-17 06:54:52');

-- --------------------------------------------------------

--
-- Table structure for table `grade_class_student`
--

CREATE TABLE `grade_class_student` (
  `id` int(11) NOT NULL,
  `grade_class_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grade_class_student`
--

INSERT INTO `grade_class_student` (`id`, `grade_class_id`, `student_id`) VALUES
(2, 3, 1),
(3, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `guardians`
--

CREATE TABLE `guardians` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `national_id` varchar(20) NOT NULL,
  `job` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guardians`
--

INSERT INTO `guardians` (`id`, `name`, `email`, `phone_number`, `address`, `date_of_birth`, `national_id`, `job`, `created_at`, `updated_at`) VALUES
(2, 'bursar', 'joel@gmail.com', '0775402600', '123katanga', '2000-05-12', '54637282', 'vendor', '2024-06-15 17:48:25', '2024-06-16 12:00:17'),
(3, 'grace', 'grace@gmail.com', '0775402600', '123katanga', '2000-03-02', '54637282', 'vendor', '2024-06-15 18:06:42', '2024-06-15 18:06:42'),
(4, 'grace', 'grace@gmail.com', '0775402600', '123katanga', '2000-03-02', '54637282', 'vendor', '2024-06-15 18:07:34', '2024-06-15 18:07:34'),
(5, 'grace', 'emmanuel3@gmail.com', '0775402600', '123katanga', '2000-03-02', '54637282', 'vendor', '2024-06-15 18:08:49', '2024-06-15 18:08:49'),
(6, 'a', 'az@gmail.com', '0775402600', '123katanga', '2000-02-02', '54637282', 'vendor', '2024-06-16 09:44:08', '2024-06-16 09:44:08'),
(7, 'guardian', 'guardians@gmail.com', '0775402600', '123katanga', '2000-02-02', '54637282', 'vendor', '2024-06-17 07:34:37', '2024-06-17 07:34:37');

-- --------------------------------------------------------

--
-- Table structure for table `incomes`
--

CREATE TABLE `incomes` (
  `id` int(11) NOT NULL,
  `school_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `transaction_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `school_id` int(11) DEFAULT NULL,
  `item_name` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `stock_level` int(11) DEFAULT NULL,
  `restock_level` int(11) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `district` varchar(255) NOT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `type` enum('Primary','High') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `name`, `province`, `district`, `contact`, `address`, `type`, `created_at`, `updated_at`) VALUES
(1, 'huny school', 'harare', 'harare', '0775402600', NULL, 'Primary', '2024-06-13 16:30:42', '2024-06-13 16:30:42'),
(2, 'joel', 'harare', 'harare', '0719929039', NULL, 'Primary', '2024-06-13 16:37:15', '2024-06-13 16:37:15'),
(3, 'chikono primary', 'harare', 'harare', '0775402600', NULL, 'Primary', '2024-06-13 16:41:43', '2024-06-13 16:41:43'),
(4, 'emma', 'mashwest', 'makonde', '0775402600', NULL, 'Primary', '2024-06-13 16:58:45', '2024-06-13 16:58:45'),
(5, 'Mukono', 'Manicaland', 'Chipinge', '0774804327', NULL, 'High', '2024-06-14 12:20:28', '2024-06-14 12:20:28'),
(6, 'Mukono', 'Manicaland', 'Chipinge', '000000', NULL, 'High', '2024-06-14 12:23:44', '2024-06-14 12:23:44'),
(7, 'emmanuel', 'mashwest', 'makonde', '0775402600', NULL, 'Primary', '2024-06-14 14:53:52', '2024-06-14 14:53:52'),
(8, 'emmanuel', 'makonde', 'mash', '0775402600', NULL, 'Primary', '2024-06-14 14:55:37', '2024-06-14 14:55:37'),
(9, 'joel2', 'west', 'maronde', '077402600', NULL, 'Primary', '2024-06-15 01:57:15', '2024-06-15 01:57:15'),
(10, 'first term', 'harare', 'harare', '0775402600', NULL, 'Primary', '2024-06-15 01:59:01', '2024-06-15 01:59:01'),
(11, 'bursar', 'hhy', 'hu', '0779833376', NULL, 'Primary', '2024-06-15 05:27:42', '2024-06-15 05:27:42'),
(12, 'red', 'red', 'red', '0775402600', NULL, 'Primary', '2024-06-15 05:29:24', '2024-06-15 05:29:24'),
(13, 'emmanuel', 'harare', 'harare', '0775402600', NULL, 'Primary', '2024-06-17 06:38:20', '2024-06-17 06:38:20'),
(14, 'emmanuel', 'harare', 'harare', '0775402600', NULL, 'Primary', '2024-06-17 06:40:27', '2024-06-17 06:40:27');

-- --------------------------------------------------------

--
-- Table structure for table `school_years`
--

CREATE TABLE `school_years` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `school_id` int(11) NOT NULL,
  `year` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `school_years`
--

INSERT INTO `school_years` (`id`, `name`, `start_date`, `end_date`, `school_id`, `year`, `created_at`, `updated_at`) VALUES
(1, 'bursar', '0000-00-00', '0000-00-00', 0, '', '2024-06-14 10:39:15', '2024-06-14 10:39:15'),
(2, 'bursar', '0000-00-00', '0000-00-00', 0, '', '2024-06-14 10:41:51', '2024-06-14 10:41:51'),
(3, 'bursar', '0000-00-00', '0000-00-00', 0, '', '2024-06-14 10:42:42', '2024-06-14 10:42:42'),
(4, 'bursar', '0000-00-00', '0000-00-00', 0, '', '2024-06-14 10:43:51', '2024-06-14 10:43:51'),
(5, 'sw', '0000-00-00', '0000-00-00', 0, '', '2024-06-14 15:09:40', '2024-06-14 15:09:40'),
(6, 'first term', '0000-00-00', '0000-00-00', 0, '', '2024-06-15 00:54:52', '2024-06-15 00:54:52'),
(7, 'first term', '0000-00-00', '0000-00-00', 0, '', '2024-06-15 00:55:24', '2024-06-15 00:55:24'),
(8, 'first term', '0000-00-00', '0000-00-00', 0, '', '2024-06-15 01:00:35', '2024-06-15 01:00:35'),
(9, 'bursar', '0000-00-00', '0000-00-00', 0, '', '2024-06-15 01:01:08', '2024-06-15 01:01:08'),
(10, 'emmanuel', '2024-01-01', '2024-11-05', 2, '2024', '2024-06-15 01:45:48', '2024-06-17 06:02:43'),
(12, 'emmanuel', '2024-01-11', '2024-11-15', 10, '2024', '2024-06-15 02:15:03', '2024-06-15 02:15:03'),
(15, 'Mukono', '2024-01-08', '2024-12-10', 12, '2024', '2024-06-15 06:50:29', '2024-06-15 09:42:31'),
(16, 'emmanuel', '2024-01-08', '2024-11-21', 14, '2024', '2024-06-17 06:43:41', '2024-06-17 06:43:41');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` text NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Hu96ilInxqCqWTBYgOSRoFbu1LIPCeNHmxloAWze', 17, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTE83eTJyOFgyOUlJR0x5bEVBMWthdTJWY2pkZWlyV3QzRnFHOFBhZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9oZWFkbWFzdGVyL2Rhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE3O30=', 1718626412);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `national_id` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `date_of_birth` date NOT NULL,
  `highest_education_level` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `name`, `surname`, `email`, `national_id`, `address`, `phone_number`, `date_of_birth`, `highest_education_level`, `created_at`, `updated_at`) VALUES
(2, 'mai', 'nyika', 'mai@gmail.com', '54637282', '123katanga', '0773710145', '2000-02-02', 'diploma', '2024-06-16 13:07:35', '2024-06-16 13:07:35'),
(3, 'mai', 'nyika', 'reeed@gmail.com', '54637282', '123katanga', '0775402600', '2000-02-02', 'diploma', '2024-06-16 13:10:26', '2024-06-16 13:10:26'),
(6, 'brian', 'mukono', 'muko@gmail.com', '54637282', '123katanga', '0775402600', '2000-06-06', 'diploma', '2024-06-17 05:55:13', '2024-06-17 05:55:13'),
(8, 'Brian Mukono', 'nyika', 'seed@gmail.com', '54637282', '123katanga', '0775402600', '2000-02-15', 'diploma', '2024-06-17 06:53:25', '2024-06-17 06:53:25');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `school_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL,
  `guardian_id` int(11) DEFAULT NULL,
  `class` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `school_id`, `name`, `contact`, `address_id`, `guardian_id`, `class`, `created_at`, `updated_at`) VALUES
(1, NULL, 'bursar', '0775402600', NULL, NULL, NULL, '2024-06-14 07:46:26', '2024-06-14 07:46:26'),
(2, NULL, 'bursar', '0775402600', NULL, NULL, NULL, '2024-06-14 08:24:15', '2024-06-14 08:24:15'),
(3, NULL, 'bursar', '0775402600', NULL, NULL, NULL, '2024-06-14 08:27:48', '2024-06-14 08:27:48'),
(4, NULL, 'bursar', '0775402600', NULL, NULL, NULL, '2024-06-14 11:05:52', '2024-06-14 11:05:52');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(11) NOT NULL,
  `school_id` int(11) DEFAULT NULL,
  `plan` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE `terms` (
  `id` int(11) NOT NULL,
  `school_year_id` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `name` varchar(20) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `terms`
--

INSERT INTO `terms` (`id`, `school_year_id`, `updated_at`, `created_at`, `name`, `start_date`, `end_date`) VALUES
(1, 1, '2024-06-14 11:24:12', '2024-06-14 11:24:12', 'sw', '2024-01-31', '2024-06-29'),
(2, 1, '2024-06-14 11:24:49', '2024-06-14 11:24:49', 'first term', '2024-02-28', '2024-06-12'),
(11, 15, '2024-06-15 07:31:55', '2024-06-15 06:53:07', 'Term 2', '2024-06-13', '2024-09-18'),
(13, 15, '2024-06-15 09:45:25', '2024-06-15 09:45:25', 'emmanuel', '2024-09-27', '2024-12-17'),
(14, 10, '2024-06-17 06:03:14', '2024-06-17 06:03:14', 'Term 1', '2024-01-01', '2024-06-17'),
(15, 16, '2024-06-17 06:44:31', '2024-06-17 06:44:31', 'first term', '2024-01-08', '2024-04-02');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `school_id` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `type` enum('Credit','Debit') NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `school_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Administrator','Headmaster','Bursar','Staff','Guardian','Student') NOT NULL,
  `address_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `school_id`, `name`, `contact`, `email`, `username`, `password`, `role`, `address_id`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Brian Tonderai Mukono', NULL, 'marondebriant@gmail.com', NULL, '$2y$12$on5Jr4wOmBYmB0s9xrdR3.Q0XLBcEhWe5wPh3lCI4nD9yodTHZITu', 'Administrator', NULL, '2024-06-13 12:01:02', '2024-06-13 12:01:02'),
(2, NULL, 'Brian Tonderai Mukono', NULL, 'word@gmail.com', NULL, '$2y$12$S5KqJRhGct6le8C.Ueis2O75zJF.URrKURGeNdwFUYO3WYFBg5lPK', 'Headmaster', NULL, '2024-06-13 15:44:52', '2024-06-13 15:44:52'),
(3, 1, 'emma', '0775402600', 'jun@gmail.com', 'emmanuel', '$2y$12$ylubExYLhpuaGH6VrCgf/.8KsPZwsSpsMqsocMVVhzLe8SrJPj8kC', 'Headmaster', NULL, '2024-06-13 16:31:38', '2024-06-13 16:31:38'),
(4, 2, 'joel', '0775402600', 'joel@gmail.com', 'Joel', '$2y$12$Q.6h71HdNDjvEFCfIc.I.evP5r5l7wG/1UrPwwxt9Zy97fmqU3mQO', 'Headmaster', NULL, '2024-06-13 16:38:00', '2024-06-13 16:38:00'),
(5, 4, 'makonde', 'makonde', 'makonde@gmail.com', 'makonde1', '$2y$12$G8z6e1mbxVnxfQKOc1IeaOC1snw9F5xCKj2ldpf7uNAFSixzN6V5S', 'Headmaster', NULL, '2024-06-13 16:59:37', '2024-06-13 16:59:37'),
(6, NULL, 'nyasha', NULL, 'nyasha@gmail.com', NULL, '$2y$12$7nDmfWbDj60OlRqU7kq/luhmUUAtgmmhELIKwwsJEzziixrrEZuVm', 'Administrator', NULL, '2024-06-13 17:40:03', '2024-06-13 17:40:03'),
(7, NULL, 'bursar', NULL, 'bursar@gmail.com', NULL, '$2y$12$yopKYpPvewldpYsjzuvGe.veRxs5u4j7S1z8uBoKsYvHrNXpMO.ca', 'Bursar', NULL, '2024-06-13 17:42:59', '2024-06-13 17:42:59'),
(8, NULL, 'admin', NULL, 'ad@gmail.com', NULL, '$2y$12$PsKLHXMuMlClqplA8Pgwsur4s6./K12O2g0AT9Urqj81MQ8YJFyJW', 'Administrator', NULL, '2024-06-14 03:42:06', '2024-06-14 03:42:06'),
(9, 6, 'Mukono', '0987654321', 'abc@gmail.com', 'Brian', '$2y$12$7et.Lo4MTYMM.px5ObMt4uJiYf/NpvrFLlIeO231E5LE3S1AdKmzK', 'Headmaster', NULL, '2024-06-14 12:24:09', '2024-06-14 12:24:09'),
(10, 8, 'emmanuel', '0775402600', 'emmanuel@gmail.com', 'emmanuel2', '$2y$12$VDPTSffw781bpC21ZHeeFu6UlLB0E5TSCunykG9ztDPAdK9HdWagW', 'Headmaster', NULL, '2024-06-14 14:56:20', '2024-06-14 14:56:20'),
(11, NULL, 'admin1', NULL, 'admin1@gmail.com', NULL, '$2y$12$.c7jK.cQ.W9xBX8I522GCO7RPaXvQI4LYiehlYQJrJIrHRca1xB6e', 'Administrator', NULL, '2024-06-14 16:03:47', '2024-06-14 16:03:47'),
(12, NULL, 'parent', NULL, 'parent@gmail.com', NULL, '$2y$12$KQ.P5lrIXWb/b..XHMbh3ecJf6.U3xgffc8QrEsAzCh.IdlXtfNv6', 'Guardian', NULL, '2024-06-14 16:25:05', '2024-06-14 16:25:05'),
(13, NULL, 'student', NULL, 'student@gmail.com', NULL, '$2y$12$ql6Zpthf.20qv16nl2ZGcuNSR//umRcOXHA/o/gF5YMM8z/BRdM22', 'Guardian', NULL, '2024-06-14 16:35:32', '2024-06-14 16:35:32'),
(14, NULL, 'student', NULL, 'student1@gmail.com', NULL, '$2y$12$WUqqpYe8rDgZUnHHst8.RehZj92JSD2gaV0tCjaP6IU7kCfHKnGrK', 'Student', NULL, '2024-06-14 16:41:22', '2024-06-14 16:41:22'),
(15, NULL, 'student2', NULL, 'student2@gmail.com', NULL, '$2y$12$Jxj26wcrkwtrWDU2Kgwzpepi9xIhSWB65Q0Cr7soWlpwSvX.TOLbq', 'Student', NULL, '2024-06-14 16:47:10', '2024-06-14 16:47:10'),
(16, 10, 'harare', '0775402600', 'harare@gmail.com', 'harare', '$2y$12$fFVcEKV0qhShk9jCpFY68ey4iYyYIE4ZNOZl6gxwremhzak7uwTHG', 'Headmaster', NULL, '2024-06-15 01:59:48', '2024-06-15 01:59:48'),
(17, 12, 'red', '0775402600', 'red@gmail.com', 'red', '$2y$12$Z295fg.5w3MVo7E0Pc4HB.xn9ArQ9WhxyMq3FHSHNfo138Ca7eyC.', 'Headmaster', NULL, '2024-06-15 05:29:58', '2024-06-15 05:29:58'),
(18, 12, 'grace', NULL, 'grace@gmail.com', NULL, '$2y$12$6pgLKU.Giip8tz8B6DnjX.mQ5dZ.IEhTq1uoYQlh1cvjV7xKlNiJy', 'Guardian', NULL, '2024-06-15 18:07:35', '2024-06-15 18:07:35'),
(19, 12, 'grace', NULL, 'emmanuel3@gmail.com', NULL, '$2y$12$qfM8Y77kvK/wScJFHRFpoO9iZYxqmmWhr9fZbwnCbxmAC0pKkei5a', 'Guardian', NULL, '2024-06-15 18:08:49', '2024-06-15 18:08:49'),
(20, 12, 'a', NULL, 'az@gmail.com', NULL, '$2y$12$lNAjJZXWxrz5VRRFnEZWS../NghLPBui5pGo.I/zgSYHY2fSMWT.i', 'Guardian', NULL, '2024-06-16 09:44:08', '2024-06-16 09:44:08'),
(21, 12, 'mai', NULL, 'reeed@gmail.com', NULL, '$2y$12$XyaTxrUqETAKXZJrny0HFuVyeVIy7QuHTiKBiwVeaMZo3yLWbJdKe', 'Staff', NULL, '2024-06-16 13:10:27', '2024-06-16 13:10:27'),
(22, 12, 'a', NULL, 'adwin@gmail.com', NULL, '$2y$12$nZVltUMdNSozgOCtjnzBIufuwd3eRCBhatLVikFbn43jOnKr8ljPe', 'Staff', NULL, '2024-06-16 13:31:23', '2024-06-16 13:31:23'),
(23, 12, 'mai nyika', NULL, 'ticha@gmail.com', NULL, '$2y$12$k0W/EGRK/9WdODO7/adsf.nqzi7fGwDcQByyejsXC0EYyw4FgNcKu', 'Staff', NULL, '2024-06-16 13:32:38', '2024-06-16 13:32:38'),
(24, 12, 'brian', NULL, 'muko@gmail.com', NULL, '$2y$12$symSOULaXrR5DeKnkjn9v.1r63aVvWMbrNwD3cbSaqlHa70Ox5SVi', 'Staff', NULL, '2024-06-17 05:55:13', '2024-06-17 05:55:13'),
(25, 14, 'emmanuel', '0775402600', 'yellow@gmail.com', 'yellow', '$2y$12$a.K5CrFwzppchoUo.56nIerdslnKoUOaq5YlTrNf76qpsAQBAEIdi', 'Headmaster', NULL, '2024-06-17 06:41:40', '2024-06-17 06:41:40'),
(26, 14, 'Brian Mukono', NULL, 'sed@gmail.com', NULL, '$2y$12$Ri3SC0STP7OsNIlzABBBtOvAz5Z3SWyTR2ok.Ye64DUrVXSCPUWl2', 'Staff', NULL, '2024-06-17 06:50:55', '2024-06-17 06:50:55'),
(27, 14, 'Brian Mukono', NULL, 'seed@gmail.com', NULL, '$2y$12$fwoPuW/SF2gsKz1eq8ThTOT.3q8mS8y8BVjBws47dJfUOUL9HqBte', 'Staff', NULL, '2024-06-17 06:53:26', '2024-06-17 06:53:26'),
(28, 2, 'guardian', NULL, 'guardians@gmail.com', NULL, '$2y$12$qDLwhByt9CUhtA9s0Ig9Ve5cXKmvk8CeNr74X4H9kW/tzKc/kGs7W', 'Guardian', NULL, '2024-06-17 07:34:38', '2024-06-17 07:34:38'),
(29, NULL, 'emmanuel', NULL, 'guardian@gmail.com', NULL, '$2y$12$eL6VFoXBi9bNhcQMQo6p9.KwNNe4ZgZsqdZGQWoWsH.4sJydaCBOO', 'Guardian', NULL, '2024-06-17 07:36:20', '2024-06-17 07:36:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_id` (`school_id`),
  ADD KEY `assigned_to` (`assigned_to`);

--
-- Indexes for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_id` (`school_id`),
  ADD KEY `currency_id` (`currency_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `communications`
--
ALTER TABLE `communications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_id` (`school_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_id` (`school_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_id` (`school_id`),
  ADD KEY `transaction_id` (`transaction_id`);

--
-- Indexes for table `fees`
--
ALTER TABLE `fees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_id` (`school_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `grades_fk_school_id` (`school_id`);

--
-- Indexes for table `grade_classes`
--
ALTER TABLE `grade_classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `classes_fk_grade_id` (`grade_id`);

--
-- Indexes for table `grade_class_staff`
--
ALTER TABLE `grade_class_staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_assignment` (`grade_class_id`,`staff_id`);

--
-- Indexes for table `grade_class_student`
--
ALTER TABLE `grade_class_student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_grade_class_id_student` (`grade_class_id`),
  ADD KEY `fk_student_id` (`student_id`);

--
-- Indexes for table `guardians`
--
ALTER TABLE `guardians`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `incomes`
--
ALTER TABLE `incomes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_id` (`school_id`),
  ADD KEY `transaction_id` (`transaction_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_id` (`school_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `school_years`
--
ALTER TABLE `school_years`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_years_fk_school_id` (`school_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_id` (`school_id`),
  ADD KEY `guardian_id` (`guardian_id`),
  ADD KEY `address_id` (`address_id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_id` (`school_id`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `terms_fk_school_year_id` (`school_year_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_id` (`school_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `school_id` (`school_id`),
  ADD KEY `address_id` (`address_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `communications`
--
ALTER TABLE `communications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fees`
--
ALTER TABLE `fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `grade_classes`
--
ALTER TABLE `grade_classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `grade_class_staff`
--
ALTER TABLE `grade_class_staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `grade_class_student`
--
ALTER TABLE `grade_class_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `guardians`
--
ALTER TABLE `guardians`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `incomes`
--
ALTER TABLE `incomes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `school_years`
--
ALTER TABLE `school_years`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assets`
--
ALTER TABLE `assets`
  ADD CONSTRAINT `assets_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`),
  ADD CONSTRAINT `assets_ibfk_2` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`);

--
-- Constraints for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD CONSTRAINT `bank_accounts_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`),
  ADD CONSTRAINT `bank_accounts_ibfk_2` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`);

--
-- Constraints for table `communications`
--
ALTER TABLE `communications`
  ADD CONSTRAINT `communications_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`),
  ADD CONSTRAINT `communications_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `communications_ibfk_3` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`);

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`),
  ADD CONSTRAINT `expenses_ibfk_2` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`);

--
-- Constraints for table `fees`
--
ALTER TABLE `fees`
  ADD CONSTRAINT `fees_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`),
  ADD CONSTRAINT `fees_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_fk_school_id` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`);

--
-- Constraints for table `grade_classes`
--
ALTER TABLE `grade_classes`
  ADD CONSTRAINT `classes_fk_grade_id` FOREIGN KEY (`grade_id`) REFERENCES `grades` (`id`);

--
-- Constraints for table `grade_class_staff`
--
ALTER TABLE `grade_class_staff`
  ADD CONSTRAINT `fk_grade_class_id` FOREIGN KEY (`grade_class_id`) REFERENCES `grade_classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_grade_class_id_staff` FOREIGN KEY (`grade_class_id`) REFERENCES `grade_classes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `grade_class_student`
--
ALTER TABLE `grade_class_student`
  ADD CONSTRAINT `fk_grade_class_id_student` FOREIGN KEY (`grade_class_id`) REFERENCES `grade_classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_student_id` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `incomes`
--
ALTER TABLE `incomes`
  ADD CONSTRAINT `incomes_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`),
  ADD CONSTRAINT `incomes_ibfk_2` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`);

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`);

--
-- Constraints for table `school_years`
--
ALTER TABLE `school_years`
  ADD CONSTRAINT `school_years_fk_school_id` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`),
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`guardian_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `students_ibfk_3` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`);

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`);

--
-- Constraints for table `terms`
--
ALTER TABLE `terms`
  ADD CONSTRAINT `terms_fk_school_year_id` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`),
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `bank_accounts` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
