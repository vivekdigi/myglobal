-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 03, 2023 at 04:48 AM
-- Server version: 10.5.20-MariaDB-cll-lve-log
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xtbhmcex_testinstall`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` bigint(20) NOT NULL,
  `user` int(11) DEFAULT NULL,
  `ip_address` varchar(191) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `device` varchar(191) DEFAULT NULL,
  `browser` varchar(191) DEFAULT NULL,
  `os` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstName` varchar(191) NOT NULL,
  `lastName` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `token_2fa_expiry` datetime DEFAULT current_timestamp(),
  `enable_2fa` varchar(191) NOT NULL DEFAULT 'disbaled',
  `token_2fa` varchar(191) DEFAULT NULL,
  `pass_2fa` varchar(191) DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `dashboard_style` varchar(191) NOT NULL DEFAULT 'dark',
  `remember_token` varchar(191) DEFAULT NULL,
  `password_token` varchar(100) DEFAULT NULL,
  `acnt_type_active` varchar(191) DEFAULT NULL,
  `status` varchar(191) DEFAULT NULL,
  `type` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `firstName`, `lastName`, `email`, `email_verified_at`, `password`, `token_2fa_expiry`, `enable_2fa`, `token_2fa`, `pass_2fa`, `phone`, `dashboard_style`, `remember_token`, `password_token`, `acnt_type_active`, `status`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'Test', 'super@happ.com', NULL, '$2y$10$ui/iqHxijsD2Nuikl95buOuwsBcbARMcCWs0Q50v5U2koemx.WYWW', '2023-07-07 17:34:45', 'disabled', '18479', 'true', '34444443', 'light', NULL, NULL, 'active', 'active', 'Super Admin', '2021-03-10 18:55:53', '2023-07-07 19:35:12'),
(3, 'New', 'Admin', 'admin@happ.com', NULL, '$2y$10$/mQxJ/gT5h27xSOJjZ6rxe4V0viGyfzWNLGlJ1Qp6KyW/vhLQWpIy', '2021-05-05 12:39:11', 'disbaled', NULL, NULL, '2344', 'light', NULL, NULL, 'active', 'active', 'Admin', '2021-04-06 13:23:58', '2023-02-20 18:30:49');

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `agent` varchar(191) DEFAULT NULL,
  `total_refered` varchar(191) NOT NULL DEFAULT '0',
  `total_activated` varchar(191) NOT NULL DEFAULT '0',
  `earnings` varchar(191) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `autologin_tokens`
--

CREATE TABLE `autologin_tokens` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `token` varchar(191) NOT NULL,
  `path` varchar(191) DEFAULT NULL,
  `count` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bnc_transactions`
--

CREATE TABLE `bnc_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `prepay_id` varchar(191) DEFAULT NULL,
  `deposit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` varchar(191) DEFAULT NULL,
  `status` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(191) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(191) NOT NULL,
  `owner` varchar(191) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contents`
--

CREATE TABLE `contents` (
  `id` int(11) NOT NULL,
  `ref_key` varchar(191) NOT NULL,
  `title` varchar(191) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contents`
--

INSERT INTO `contents` (`id`, `ref_key`, `title`, `description`, `created_at`, `updated_at`) VALUES
(5, 'SMsJr1', 'What our Customer says!', 'Don\'t take our word for it, here\'s what some of our clients have to say about us', '2020-08-22 11:13:00', '2021-10-27 09:59:35'),
(11, 'anvs8c', 'About Us', 'About us header', '2020-08-22 11:32:29', '2021-10-27 10:21:22'),
(12, 'epJ4LI', 'Who we are', 'online trade \r\n                            is a solution for creating an investment management platform. It is suited for\r\n                            hedge or mutual fund managers and also Forex, stocks, bonds and cryptocurrency traders who\r\n                            are looking at runing pool trading system. Onlinetrader simplifies the investment,\r\n                            monitoring and management process. With a secure and compelling mobile-first design,\r\n                            together with a default front-end design, it takes few minutes to setup your own investment\r\n                            management or pool trading platform.', '2020-08-22 11:33:32', '2021-10-27 10:24:01'),
(13, '5hbB6X', 'Get Started', 'How to get started ?', '2020-08-22 11:33:55', '2021-10-27 10:25:09'),
(14, 'Zrhm3I', 'Create an Account', 'Create an account with us using your preffered email/username', '2020-08-22 11:34:11', '2021-10-27 10:25:29'),
(15, 'yTKhlt', 'Make a Deposit', 'Make A deposit with any of your preffered currency', '2020-08-22 11:34:26', '2021-10-27 10:25:52'),
(16, 'u0Ervr', 'Start Trading/Investing', 'Start trading with Indices commodities e.tc', '2020-08-22 11:34:56', '2021-10-27 10:26:12'),
(23, 'vr6Xw0', 'Our Investment Packages', 'Choose how you want to invest with us', '2020-08-22 11:37:43', '2021-10-27 09:58:51'),
(30, '52GPRA', 'Address', '13th Street. 47 W 13th St, New York, NY 10011, USA.', '2020-08-22 11:40:19', '2020-08-22 11:40:19'),
(31, '0EXbji', 'Phone Number', '+12 9xxxxxxxx', '2020-08-22 11:40:36', '2020-09-14 10:13:57'),
(32, 'HLgyaQ', 'Email', 'email@yourwebsiteurl.com', '2020-08-22 11:41:14', '2020-08-22 12:23:55'),
(35, 'Mnag31', 'The Better Way to Trade & Invest', 'Online Trade helps over 2 million customers achieve their financial goals by helping them trade and invest with ease', '2021-10-27 09:42:23', '2022-11-10 18:42:38'),
(36, 'rXJ7JQ', 'Trade Invest stock, and Bond', 'Home page text', '2021-10-27 09:45:17', '2021-10-27 09:45:17'),
(37, 'J23T0Y', 'Security Comes First', 'Security Comes first', '2021-10-27 09:53:15', '2021-10-27 09:54:52'),
(38, '9HOR1z', 'Security', 'Online Trade uses the highest levels of Internet Security, and it is secured by 256 bits SSL security encryption to ensure that your information is completely protected from fraud.', '2021-10-27 09:56:13', '2021-10-27 09:56:13'),
(39, '7DH2G9', 'Two Factor Auth', 'Two-factor authentication (2FA) by default on all Online Trade accounts, to securely protect you from unauthorised access and impersonation.', '2021-10-27 09:56:26', '2021-10-27 09:56:26'),
(40, '5Vg32I', 'Explore Our Services', 'It’s our mission to provide you with a delightful and a successful trading experience!', '2021-10-27 09:56:38', '2021-10-27 09:56:38'),
(41, 'Vg6Gy7', 'Powerful Trading Platforms', 'Online Trade offers multiple platform options to cover the needs of each type of trader and investors .', '2021-10-27 09:56:53', '2021-10-27 09:56:53'),
(42, '1Sx1dl', 'High leverage', 'Chance to magnify your investment and really win big with super-low spreads to further up your profits', '2021-10-27 09:57:06', '2021-10-27 09:57:06'),
(43, 'YYqKx3', 'Fast execution', 'Super-fast trading software, so you never suffer slippage.', '2021-10-27 09:57:20', '2021-10-27 09:57:20'),
(44, 'yGg8xI', 'Ultimate Security', 'With advanced security systems, we keep your account always protected.', '2021-10-27 09:57:35', '2021-10-27 09:57:35'),
(45, 'xEWMho', '24/7 live chat Support', 'Connect with our 24/7 support and Market Analyst on-demand.', '2021-10-27 09:57:48', '2021-10-27 09:57:48'),
(46, '9SOtK1', 'Always on the go? Mobile trading is easier than ever with Online Trade!', 'Get your hands on our customized Trading Platform with the comfort of freely trading on the move, to experience truly liberating trading sessions.', '2021-10-27 09:58:05', '2021-10-27 09:58:05'),
(47, 'wOS1ve', 'Cryptocurrency', 'Trade and invest Top Cryptocurrency', '2021-10-27 09:59:07', '2021-10-27 09:59:07'),
(48, 'wuZlis', 'Hello!, How can we help you?', 'Hello!, How can we help you?', '2021-10-27 10:32:12', '2021-10-27 10:32:12'),
(49, '1TYkw0', 'Find the help you need', 'Launch your campaign and benefit from our expertise on designing and managing conversion centered bootstrap4 html page.', '2021-10-27 10:32:33', '2021-10-27 10:32:33'),
(50, 'rK6Yhn', 'FAQs', 'Due to its widespread use as filler text for layouts, non-readability is of great importance.', '2021-10-27 10:32:49', '2021-10-27 10:32:49'),
(51, 'HBHBLo', 'Guides / Support', 'Due to its widespread use as filler text for layouts, non-readability is of great importance.', '2021-10-27 10:33:03', '2021-10-27 10:33:03'),
(52, 'rCTDQh', 'Support Request', 'Due to its widespread use as filler text for layouts, non-readability is of great importance.', '2021-10-27 10:33:14', '2021-10-27 10:33:14'),
(53, 'kMsswR', 'Get Started', 'Launch your campaign and benefit from our expertise on designing and managing conversion centered bootstrap4 html page.', '2021-10-27 10:33:28', '2021-10-27 10:33:28'),
(54, 'EOUU7R', 'Get in Touch !', 'This is required when, for text is not yet available.', '2021-10-27 10:33:56', '2021-10-27 10:33:56'),
(56, 'ROu4q6', 'Contact Us', 'Contact Us', '2021-10-27 10:47:41', '2021-10-27 10:47:41');

-- --------------------------------------------------------

--
-- Table structure for table `cp_transactions`
--

CREATE TABLE `cp_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `txn_id` varchar(191) DEFAULT NULL,
  `item_name` varchar(191) DEFAULT NULL,
  `Item_number` varchar(191) DEFAULT NULL,
  `amount_paid` varchar(191) DEFAULT NULL,
  `user_plan` varchar(191) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_tele_id` int(11) DEFAULT NULL,
  `amount1` varchar(191) DEFAULT NULL,
  `amount2` varchar(191) DEFAULT NULL,
  `currency1` varchar(191) DEFAULT NULL,
  `currency2` varchar(191) DEFAULT NULL,
  `status` varchar(191) DEFAULT NULL,
  `status_text` varchar(191) DEFAULT NULL,
  `type` varchar(191) DEFAULT NULL,
  `cp_p_key` varchar(191) DEFAULT NULL,
  `cp_pv_key` varchar(191) DEFAULT NULL,
  `cp_m_id` varchar(191) DEFAULT NULL,
  `cp_ipn_secret` varchar(191) DEFAULT NULL,
  `cp_debug_email` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cp_transactions`
--

INSERT INTO `cp_transactions` (`id`, `txn_id`, `item_name`, `Item_number`, `amount_paid`, `user_plan`, `user_id`, `user_tele_id`, `amount1`, `amount2`, `currency1`, `currency2`, `status`, `status_text`, `type`, `cp_p_key`, `cp_pv_key`, `cp_m_id`, `cp_ipn_secret`, `cp_debug_email`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', '1', 'sefef', 'Heloosjjsnnij2878u2i', 'tes@dd.gb', '2021-03-11 18:46:45', '2023-05-15 14:03:32');

-- --------------------------------------------------------

--
-- Table structure for table `crypto_accounts`
--

CREATE TABLE `crypto_accounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `btc` float DEFAULT NULL,
  `eth` float DEFAULT NULL,
  `ltc` float DEFAULT NULL,
  `xrp` float DEFAULT NULL,
  `link` float DEFAULT NULL,
  `bnb` float DEFAULT NULL,
  `aave` float DEFAULT NULL,
  `usdt` float DEFAULT NULL,
  `xlm` float DEFAULT NULL,
  `bch` float DEFAULT NULL,
  `ada` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `crypto_accounts`
--

INSERT INTO `crypto_accounts` (`id`, `user_id`, `btc`, `eth`, `ltc`, `xrp`, `link`, `bnb`, `aave`, `usdt`, `xlm`, `bch`, `ada`, `created_at`, `updated_at`) VALUES
(1, 93, 0.310042, 0.202379, 0.0223845, NULL, NULL, 0.499336, NULL, 182.225, NULL, NULL, 864.996, '2021-10-31 17:25:53', '2022-03-23 15:20:53'),
(2, 56, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-02-14 14:15:27', '2022-02-14 14:15:27'),
(3, 57, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-02-14 14:32:58', '2022-02-14 14:32:58'),
(4, 152, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-03-25 18:47:58', '2022-03-25 18:47:58'),
(5, 153, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-04-11 13:58:53', '2022-04-11 13:58:53'),
(6, 94, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-04-13 13:16:21', '2022-04-13 13:16:21'),
(7, 151, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-04-29 09:26:45', '2022-04-29 09:26:45'),
(8, 154, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-05-24 12:00:30', '2022-05-24 12:00:30'),
(9, 156, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-07-05 14:32:55', '2022-07-05 14:32:55'),
(10, 157, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-07-07 15:13:02', '2022-07-07 15:13:02'),
(11, 158, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-08-16 06:22:44', '2022-08-16 06:22:44'),
(12, 159, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-08-30 09:26:48', '2022-08-30 09:26:48'),
(13, 160, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-08-30 09:29:04', '2022-08-30 09:29:04'),
(14, 161, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-08-30 09:31:31', '2022-08-30 09:31:31'),
(15, 162, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-08-30 09:33:13', '2022-08-30 09:33:13'),
(16, 163, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-08-30 09:33:57', '2022-08-30 09:33:57'),
(17, 164, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-08-30 09:34:29', '2022-08-30 09:34:29'),
(18, 165, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-08-30 09:38:07', '2022-08-30 09:38:07'),
(19, 166, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-08-30 09:40:53', '2022-08-30 09:40:53'),
(20, 167, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-08-30 09:43:20', '2022-08-30 09:43:20'),
(21, 168, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-08-30 09:46:13', '2022-08-30 09:46:13'),
(22, 169, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-08-30 09:50:37', '2022-08-30 09:50:37'),
(23, 171, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-16 17:55:40', '2023-01-16 17:55:40'),
(24, 172, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-02-06 14:54:59', '2023-02-06 14:54:59'),
(25, 173, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-02-06 14:58:03', '2023-02-06 14:58:03'),
(26, 178, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-05-22 15:38:26', '2023-05-22 15:38:26'),
(27, 179, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-05-22 15:40:25', '2023-05-22 15:40:25'),
(28, 181, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-06-13 16:00:22', '2023-06-13 16:00:22'),
(29, 175, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-06-14 00:58:06', '2023-06-14 00:58:06'),
(30, 174, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-07-04 15:48:42', '2023-07-04 15:48:42'),
(31, 182, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-04 13:59:48', '2023-10-04 13:59:48');

-- --------------------------------------------------------

--
-- Table structure for table `crypto_records`
--

CREATE TABLE `crypto_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `source` varchar(191) DEFAULT NULL,
  `dest` varchar(191) DEFAULT NULL,
  `amount` double(8,2) DEFAULT NULL,
  `quantity` decimal(16,8) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `crypto_records`
--

INSERT INTO `crypto_records` (`id`, `source`, `dest`, `amount`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 'BTC', 'USD', 0.00, 107.58000000, '2022-05-24 10:21:07', '2022-05-24 10:21:07'),
(2, 'USD', 'BNB', 50.00, 0.15000000, '2022-05-24 11:26:55', '2022-05-24 11:26:55'),
(3, 'BTC', 'USD', 0.21, 6219.48000000, '2022-05-24 11:31:53', '2022-05-24 11:31:53'),
(4, 'USD', 'ETH', 100.00, 0.05000000, '2022-05-24 11:36:30', '2022-05-24 11:36:30'),
(5, 'USD', 'BTC', 60.00, 0.00000000, '2022-06-09 08:09:48', '2022-06-09 08:09:48'),
(6, 'BTC', 'USD', 0.10, 2841.35000000, '2022-06-12 06:36:40', '2022-06-12 06:36:40'),
(7, 'USD', 'BTC', 300.00, 0.01000000, '2022-07-16 15:18:29', '2022-07-16 15:18:29'),
(8, 'USD', 'ETH', 20.00, 0.00000000, '2023-05-29 15:23:25', '2023-05-29 15:23:25'),
(9, 'USD', 'BTC', 20.00, 0.00000000, '2023-05-29 15:24:21', '2023-05-29 15:24:21'),
(10, 'USD', 'BTC', 10.00, 0.00035138, '2023-05-29 15:34:34', '2023-05-29 15:34:34'),
(11, 'USD', 'BTC', 200.00, 0.00007550, '2023-06-12 15:16:52', '2023-06-12 15:16:52'),
(12, 'USD', 'ETH', 100.00, 0.05607370, '2023-06-12 15:21:09', '2023-06-12 15:21:09'),
(13, 'USD', 'BTC', 100.00, 0.03262426, '2023-07-18 13:06:05', '2023-07-18 13:06:05');

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `txn_id` varchar(191) DEFAULT NULL,
  `user` int(11) DEFAULT NULL,
  `amount` varchar(191) DEFAULT NULL,
  `payment_mode` varchar(191) DEFAULT NULL,
  `plan` int(11) DEFAULT NULL,
  `status` varchar(191) DEFAULT NULL,
  `proof` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ref_key` varchar(191) DEFAULT NULL,
  `question` varchar(191) DEFAULT NULL,
  `answer` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `ref_key`, `question`, `answer`, `created_at`, `updated_at`) VALUES
(4, 'JzySBF', 'How can i withdraw', 'Lorem ipsum dolor sit amet consectetur adipiscing elit nulla venenatis, pharetra viverra fusce ornare magna condimentum vulputate libero placerat sapien.', '2023-06-12 17:17:31', '2023-06-12 17:17:31'),
(5, 'yLY3R7', 'How can i deposit money via Paypal', 'Yes you can deposit via paypal, we also have other payment options that you can use for your convenience.', '2023-06-12 17:18:31', '2023-06-12 17:18:31'),
(6, 'm3VRCi', 'What is Online trade', 'Inceptos senectus platea arcu iaculis quis convallis hendrerit vestibulum nostra congue, quam torquent luctus litora netus volutpat cum faucibus', '2023-06-12 17:20:21', '2023-06-12 17:20:21');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `ref_key` varchar(191) NOT NULL,
  `title` varchar(191) NOT NULL,
  `description` text NOT NULL,
  `img_path` varchar(191) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `ref_key`, `title`, `description`, `img_path`, `created_at`, `updated_at`) VALUES
(8, 'DPd1Kn', 'Testimonial 1', 'Testimonial 1', 'SIu0JZ01.jpg1635329714', '2020-08-23 12:24:52', '2021-10-27 10:15:14'),
(9, 'ZqCgDz', 'Testimonial 2', 'Testimonial 2', 'photos/2O5A1PaPNEG6J92eybtWfyawbw8KYvCneD5VCZVM.jpg', '2020-08-23 12:25:07', '2022-02-17 10:01:28'),
(14, 'b9158B', 'Home Image', 'The image at the home page', 'photos/eQZW9KTA66MfDXmmsM7VzwfBuleCSRBpoyjaivei.jpg', '2021-10-27 09:48:42', '2022-02-16 15:32:47'),
(15, 'iAwfKe', 'About image', 'The image in the about page', 'photos/O424fd54I3OWdTvNZNDAFuVCMG1oVUMuCgbwxzeT.png', '2021-10-27 10:22:20', '2022-02-16 15:33:18');

-- --------------------------------------------------------

--
-- Table structure for table `ipaddresses`
--

CREATE TABLE `ipaddresses` (
  `id` int(10) UNSIGNED NOT NULL,
  `ipaddress` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kycs`
--

CREATE TABLE `kycs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(191) DEFAULT NULL,
  `last_name` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `phone_number` varchar(191) DEFAULT NULL,
  `dob` varchar(191) DEFAULT NULL,
  `social_media` varchar(191) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(191) DEFAULT NULL,
  `state` varchar(191) DEFAULT NULL,
  `country` varchar(191) DEFAULT NULL,
  `document_type` varchar(191) DEFAULT NULL,
  `frontimg` text DEFAULT NULL,
  `backimg` text DEFAULT NULL,
  `status` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2021_03_09_142220_create_sessions_table', 1),
(7, '2021_03_10_082445_create_admins_table', 2),
(8, '2021_03_10_082519_create_agents_table', 2),
(9, '2021_03_10_082715_create_assets_table', 2),
(10, '2021_03_10_082817_create_contents_table', 2),
(11, '2021_03_10_083110_create_cp_transactions_table', 2),
(12, '2021_03_10_083324_create_deposits_table', 2),
(13, '2021_03_10_083400_create_faqs_table', 2),
(14, '2021_03_10_083510_create_images_table', 2),
(15, '2021_03_10_083557_create_mt4_details_table', 2),
(17, '2021_03_10_083824_create_plans_table', 2),
(18, '2021_03_10_083850_create_settings_table', 2),
(19, '2021_03_10_083936_create_testimonies_table', 2),
(20, '2021_03_10_084009_create_tp__transactions_table', 2),
(21, '2021_03_10_084031_create_upgrades_table', 2),
(22, '2021_03_10_084120_create_userlogs_table', 2),
(23, '2021_03_10_084140_create_user_plans_table', 2),
(24, '2021_03_10_084235_create_wdmethods_table', 2),
(25, '2021_03_10_084300_create_withdrawals_table', 2),
(26, '2021_04_06_083043_create_tasks_table', 3),
(27, '2021_04_23_110006_create_exchanges_table', 4),
(28, '2021_04_23_114622_create_coin_transactions_table', 5),
(29, '2021_04_27_080945_create_currencies_table', 6),
(30, '2021_04_29_110349_create_c_withdrawals_table', 7),
(31, '2021_10_07_112653_create_ipaddresses_table', 8),
(32, '2021_10_27_114829_create_terms_privacies_table', 9),
(33, '2021_10_31_131124_create_crypto_accounts_table', 10),
(34, '2021_10_31_132849_create_settings_conts_table', 11),
(35, '2022_01_24_123921_create_copy_trade_accounts_table', 12),
(36, '2022_02_03_131113_create_tasks_table', 13),
(37, '2022_03_16_135903_create_adverts_table', 14),
(38, '2022_03_17_114728_create_orders_p2ps_table', 15),
(39, '2022_05_23_215802_create_crypto_records_table', 16),
(40, '2022_06_13_220336_create_kycs_table', 17),
(41, '2022_06_23_030303_create_bnc_transactions_table', 18),
(42, '2022_09_02_074542_create_courses_table', 19),
(43, '2022_09_02_074626_create_course_lessons_table', 20),
(44, '2022_09_02_074608_create_course_categories_table', 21),
(45, '2022_09_06_165000_create_user_courses_table', 22),
(46, '2014_01_28_232217_create_autologin_tokens_table', 23),
(47, '2014_02_07_004118_add_unique_index_to_autologin_tokens_table', 24),
(48, '2014_03_02_162640_add_count_to_autologin_tokens_table', 25),
(53, '2022_09_19_142955_create_master_accounts_table', 26),
(54, '2022_09_29_153351_create_signal_tbs_table', 27),
(55, '2022_09_29_175703_create_signal_subscribers_table', 28),
(56, '2023_01_30_102934_create_themes_table', 29),
(57, '2023_02_17_165829_create_cache_table', 30),
(58, '2021_03_10_083627_create_notifications_table', 31),
(59, '2023_06_13_164333_create_notifications_table', 32),
(60, '2023_08_04_135232_create_jobs_table', 33);

-- --------------------------------------------------------

--
-- Table structure for table `mt4_details`
--

CREATE TABLE `mt4_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `mt4_id` varchar(191) DEFAULT NULL,
  `mt4_password` text DEFAULT NULL,
  `mt_type` varchar(255) NOT NULL,
  `account_name` varchar(191) DEFAULT NULL,
  `account_type` varchar(191) DEFAULT NULL,
  `currency` varchar(191) DEFAULT NULL,
  `leverage` varchar(191) DEFAULT NULL,
  `server` varchar(191) DEFAULT NULL,
  `options` varchar(191) DEFAULT NULL,
  `duration` varchar(191) DEFAULT NULL,
  `status` varchar(191) DEFAULT NULL,
  `copying_trade` tinyint(1) DEFAULT 0,
  `provider` varchar(191) DEFAULT NULL,
  `strategy` text DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `reminded_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('104ef5e4-8ed1-474a-b838-756bf83e303a', 'App\\Notifications\\AccountNotification', 'App\\Models\\User', 93, '{\"message\":\"You just purchased a new investment plan: Standard, amount: $200.\",\"title\":\"New Investment Plan\"}', NULL, '2023-10-17 13:23:59', '2023-10-17 13:23:59'),
('112b45a8-4615-42bc-a2d2-056e1ffbdc76', 'App\\Notifications\\AccountNotification', 'App\\Models\\User', 93, '{\"message\":\"You just got a referral bonus. Amount: $10 from KayDemoExnx\",\"title\":\"Referral Bonus\"}', NULL, '2023-10-13 13:13:58', '2023-10-13 13:13:58'),
('14b91260-ff12-4245-b7c2-f5fc28c502b6', 'App\\Notifications\\AccountNotification', 'App\\Models\\User', 93, '{\"message\":\"You have succesfully cancelled your Standard plan and your investment capital have been credited to your account,  If this is a mistake, please contact us immediately to reactivate it for you.\",\"title\":\"Plan cancelled\"}', NULL, '2023-06-16 22:57:24', '2023-06-16 22:57:24'),
('1dc2b533-7a96-4857-abf2-600961ad852c', 'App\\Notifications\\AccountNotification', 'App\\Models\\User', 174, '{\"message\":\"You have a new balance transaction. Amount: {\\\"currency\\\":\\\"$\\\"}200.\",\"title\":\"System Topup\"}', NULL, '2023-07-04 15:49:11', '2023-07-04 15:49:11'),
('2457cedf-878c-4c0a-af72-d476e885d669', 'App\\Notifications\\AccountNotification', 'App\\Models\\User', 174, '{\"message\":\"You have a new profit. Plan: Standard, Amount: $4\",\"title\":\"New Profit record\"}', NULL, '2023-07-04 16:13:52', '2023-07-04 16:13:52'),
('254a98e0-7183-44d6-9751-29ee35f5b6ec', 'App\\Notifications\\AccountNotification', 'App\\Models\\User', 181, '{\"message\":\"You have a new balance transaction. Amount: {\\\"currency\\\":\\\"$\\\"}20.\",\"title\":\"System Topup\"}', NULL, '2023-07-25 15:25:45', '2023-07-25 15:25:45'),
('273d03a9-0106-401b-9e8a-684fb5e1e2c5', 'App\\Notifications\\AccountNotification', 'App\\Models\\User', 175, '{\"message\":\"You just purchased a new investment plan: Standard, amount: $200.\",\"title\":\"New Investment Plan\"}', '2023-06-14 01:24:01', '2023-06-14 01:21:02', '2023-06-14 01:24:01'),
('32d7638a-feb4-4248-b25f-6cfd008e7603', 'App\\Notifications\\AccountNotification', 'App\\Models\\User', 179, '{\"message\":\"You have a new balance transaction. Amount: {\\\"currency\\\":\\\"$\\\"}20.\",\"title\":\"System Topup\"}', NULL, '2023-07-25 15:25:43', '2023-07-25 15:25:43'),
('5824cceb-9dcc-470a-9901-e5d420577eea', 'App\\Notifications\\AccountNotification', 'App\\Models\\User', 175, '{\"message\":\"Your Deposit have been Confirmed and the amount is added to your account balance. Amount: $100\",\"title\":\"Deposit is Confirmed\"}', NULL, '2023-10-13 13:12:44', '2023-10-13 13:12:44'),
('6213577e-3de7-4eb8-ad52-b853f5b317b1', 'App\\Notifications\\AccountNotification', 'App\\Models\\User', 93, '{\"message\":\"Your Deposit have been Confirmed and the amount is added to your account balance. Amount: $4082\",\"title\":\"Deposit is Confirmed\"}', '2023-06-14 12:54:15', '2023-06-14 12:48:49', '2023-06-14 12:54:15'),
('78f661b4-8ab5-45a1-a803-10594f231d3c', 'App\\Notifications\\AccountNotification', 'App\\Models\\User', 93, '{\"message\":\"Tester Test, This is to inform you that your trading account management request has been reviewed and processed. Thank you for trusting Online Trade\",\"title\":\"Subscription Account Started!\"}', NULL, '2023-07-21 19:42:15', '2023-07-21 19:42:15'),
('9bded98e-a7c9-484b-9e85-316e734cefd5', 'App\\Notifications\\AccountNotification', 'App\\Models\\User', 93, '{\"message\":\"You just got a referral bonus. Amount: $0.4 from Victory Efekpogua\",\"title\":\"Referral Bonus\"}', NULL, '2023-07-04 16:22:25', '2023-07-04 16:22:25'),
('9f3fd953-e8b4-4224-b5fe-3c64d610f12a', 'App\\Notifications\\AccountNotification', 'App\\Models\\User', 93, '{\"message\":\"This is to inform you that following the documents you submited, your account have been verified. You can now enjoy all our services without restrictions. Cheers!!\",\"title\":\"Account was not verified\"}', NULL, '2023-10-09 13:59:28', '2023-10-09 13:59:28'),
('cf4fcbf2-8f01-4f33-b376-4a3fcb8a6024', 'App\\Notifications\\AccountNotification', 'App\\Models\\User', 174, '{\"message\":\"You just purchased a new investment plan: Standard, amount: $200.\",\"title\":\"New Investment Plan\"}', NULL, '2023-07-04 15:49:29', '2023-07-04 15:49:29'),
('d84963d3-4791-4343-a5c1-ad0f46ab5e22', 'App\\Notifications\\AccountNotification', 'App\\Models\\User', 175, '{\"message\":\"Your Deposit have been Confirmed and the amount is added to your account balance. Amount: $100\",\"title\":\"Deposit is Confirmed\"}', NULL, '2023-10-13 13:13:58', '2023-10-13 13:13:58'),
('e1f96c6c-14da-4dc1-93f7-254682b82187', 'App\\Notifications\\AccountNotification', 'App\\Models\\User', 93, '{\"message\":\"Tester Test, This is to inform you that your trading account management request has been reviewed and processed. Thank you for trusting Online Trade\",\"title\":\"Subscription Account Started!\"}', NULL, '2023-07-04 15:18:42', '2023-07-04 15:18:42'),
('ef719a36-6931-4255-a6d0-580de10c0ea4', 'App\\Notifications\\AccountNotification', 'App\\Models\\User', 93, '{\"message\":\"Your Deposit have been Confirmed and the amount is added to your account balance. Amount: $3882\",\"title\":\"Deposit is Confirmed\"}', '2023-06-14 12:42:04', '2023-06-14 12:40:18', '2023-06-14 12:42:04');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paystacks`
--

CREATE TABLE `paystacks` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `paystack_public_key` text DEFAULT NULL,
  `paystack_secret_key` text DEFAULT NULL,
  `paystack_url` varchar(191) DEFAULT NULL,
  `paystack_email` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `paystacks`
--

INSERT INTO `paystacks` (`id`, `created_at`, `updated_at`, `paystack_public_key`, `paystack_secret_key`, `paystack_url`, `paystack_email`) VALUES
(1, '2021-10-07 15:26:10', '2023-05-15 14:03:38', NULL, NULL, 'https://api.paystack.co', 'test@mail.com');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `price` varchar(191) DEFAULT NULL,
  `min_price` varchar(191) DEFAULT NULL,
  `max_price` varchar(191) DEFAULT NULL,
  `minr` varchar(191) DEFAULT NULL,
  `maxr` varchar(191) DEFAULT NULL,
  `gift` varchar(191) DEFAULT NULL,
  `expected_return` varchar(191) DEFAULT NULL,
  `type` varchar(191) DEFAULT NULL,
  `increment_interval` varchar(191) DEFAULT NULL,
  `increment_type` varchar(191) DEFAULT NULL,
  `increment_amount` varchar(191) DEFAULT NULL,
  `expiration` varchar(191) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `name`, `price`, `min_price`, `max_price`, `minr`, `maxr`, `gift`, `expected_return`, `type`, `increment_interval`, `increment_type`, `increment_amount`, `expiration`, `status`, `created_at`, `updated_at`) VALUES
(10, 'Standard', '200', '180', '200', '0.046', '0.046', '0', NULL, 'Main', 'Every 30 Minutes', 'Percentage', '2', '1 Hours', 'active', '2022-07-05 14:34:25', '2023-10-17 13:37:35'),
(12, 'Premium', '1000', '100', '1000', '2', '50', '0', NULL, 'Main', 'Monthly', 'Percentage', '2', '2 Months', 'active', '2023-05-15 12:40:23', '2023-10-09 14:11:14');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` text NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1lWe0pgKS1kwBuwXL3HgZQB5Dm9Q3V4IEEx0dtEu', NULL, '34.254.53.125', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.152 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoid2dLeUlPOHQ4QURHbGU2SnFqN1I1Y0VKUUtXdXByQ3VhVHpLTWVDeiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vdGVzdGluc3RhbGwubHZncm93Y2FwaXRhbC5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1698994923),
('4kc2vITNzTVobqVeWivXlShMTuJdm9DP2AO4ralP', NULL, '18.207.134.148', 'Slackbot-LinkExpanding 1.0 (+https://api.slack.com/robots)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY0I5QnlEMUZsRXljZWt0eVI0S3lJYXdkbXhST0pPWDMwcE5RV0gzViI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vdGVzdGluc3RhbGwubHZncm93Y2FwaXRhbC5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1698996122),
('5oC0FQTLHrYBrowLN4vpfXbthICwH5WZK7R9tsnA', NULL, '5.164.29.202', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36 (scanner.ducks.party)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ01GdExmT1hyWjZyN2k3OTNLcEZxVVVYM3dudm84eU9JUHVOSWNJcyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHBzOi8vd3d3LnRlc3RpbnN0YWxsLmx2Z3Jvd2NhcGl0YWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1698999414),
('9pJ8zN43aMf0XoTJON7ZVXioSRShrCp8BR2cwcfG', NULL, '51.75.141.254', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36 Edg/113.0.1774.42', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVEt3bXVKTWZ3ZzFiaHoybG41THN6YmpXRk9Jakt1YTk5Qk9wZTNpdiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHBzOi8vd3d3LnRlc3RpbnN0YWxsLmx2Z3Jvd2NhcGl0YWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1698999741),
('BlFp2TMJYPaMZ1cAjcNbIar1uCdKmoeyF5gu5vBJ', NULL, '198.147.22.233', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:109.0) Gecko/20100101 Firefox/113.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMGpUWElzdncwMlpoQWFDQk1BMkY4T0xHaFNaQVlsYlQ5aXIwdWZhdCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHBzOi8vd3d3LnRlc3RpbnN0YWxsLmx2Z3Jvd2NhcGl0YWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1698999741),
('Br3JkFCFEsREDNNkMP9OMqwI0HKCbsieL5Ig99lx', NULL, '105.113.82.238', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/118.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoia1lqS0Z3U1VpS3JPWWdUSmpibEFZZjVYVkc1aUZEQnlRR3oxdFhPcSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NzU6Imh0dHBzOi8vdGVzdGluc3RhbGwubHZncm93Y2FwaXRhbC5jb20vYWRtaW4vZGFzaGJvYXJkL3NldHRpbmdzL2FwcC1zZXR0aW5ncyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTI6ImxvZ2luX2FkbWluXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1698999565),
('DBMMW4oN48KoquunzCIlCJT4OOA2iDmAunsUKmoK', NULL, '34.254.53.125', 'Mozilla/5.0 (X11; Linux x86_64; rv:83.0) Gecko/20100101 Firefox/83.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWEZuN0JMMFd1ZGdQUEpmR3pkM3VodUVLY2x4Sk9PUm5nNHFHN0h1TiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHBzOi8vd3d3LnRlc3RpbnN0YWxsLmx2Z3Jvd2NhcGl0YWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1698994938),
('dhFkfnRPGLs4KHGOTzFAwn0jc6DV2squXxrKEAtY', NULL, '34.254.53.125', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.152 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUWJDSVFnSjNhN0dhMWtFalZ2UW5nUk01ZTg2NlZKWHNFVFowWGJvTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHBzOi8vd3d3LnRlc3RpbnN0YWxsLmx2Z3Jvd2NhcGl0YWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1698994943),
('edV4zuOVlQxXagmmrWbYjFygmHr8e6EpUuE7lktT', NULL, '205.185.222.19', 'Mozilla/5.0 (Linux; Android 12) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaWhqUG96UmxDdzhZaU1jQjBMd2ZqcVBpUUpXdEVqYmpQMXZlT0JQYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vdGVzdGluc3RhbGwubHZncm93Y2FwaXRhbC5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1698999744),
('IgtNqXpeXEEdzfdHIofKoHXF8foNcmY3EXjIZBn1', NULL, '31.171.153.86', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36 Edg/113.0.1774.50', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUGJsenhrWndXcUpFNnozVjdhN1RXSWZ2UXROUkNETlJpaVVFRFBRbiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vdGVzdGluc3RhbGwubHZncm93Y2FwaXRhbC5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1698999744),
('jQhhsZ1l9YtL4ClpO62pboKToiqVHnMqYm8qftZ5', NULL, '100.26.179.77', 'Slackbot-LinkExpanding 1.0 (+https://api.slack.com/robots)', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUFFsWTdlQkIxZGhsUkE3VTFqWVFhQ2ZWNDNKc3BtaFFleHNMaW01VyI7czo3OiJtZXNzYWdlIjtzOjExOiJOb3QgYWxsb3dlZCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjE6e2k6MDtzOjc6Im1lc3NhZ2UiO319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTg6Imh0dHBzOi8vdGVzdGluc3RhbGwubHZncm93Y2FwaXRhbC5jb20vYWRtaW5sb2dpbi9kYXNoYm9hcmQiO319', 1698996286),
('kmFdnvr5KCCfZdUnoadEnlaQHxPLSlCDCFonwwD9', NULL, '5.164.29.202', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36 (scanner.ducks.party)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNjNvRlExNnh4bHdTZ3FBYWhUQnZuY1BUT1hvRHNRWFl3dkJRTlBPNyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vdGVzdGluc3RhbGwubHZncm93Y2FwaXRhbC5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1698999139),
('Krl7hl0nQjeS64EJ2rmj6piq5Derbd8WeHzQxqcz', NULL, '216.131.114.7', 'Mozilla/5.0 (Linux; Android 11) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSWI3VFM1dWVSWUgxaXMzQUNSSklPcEFhSzJTY1ZrakRJWWlIZVRpcyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vdGVzdGluc3RhbGwubHZncm93Y2FwaXRhbC5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1698999748),
('L5dkTkXbRs44SsjHZkoSPI0WjsEjinVMpRBfkXFA', NULL, '100.26.179.77', 'Slackbot-LinkExpanding 1.0 (+https://api.slack.com/robots)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic1JnZk5MaXFpNjRZYVpzajkwaEZLOWQ2STF2dmRrOUFjYzZQSUQydSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NzA6Imh0dHBzOi8vdGVzdGluc3RhbGwubHZncm93Y2FwaXRhbC5jb20vYWRtaW4vZGFzaGJvYXJkL3RyYWRpbmctc2V0dGluZ3MiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1698996286),
('mLu4hbJvmPZUA4tEwFGBdTKged2RSHcKRtbAPml5', NULL, '100.26.179.77', 'Slackbot-LinkExpanding 1.0 (+https://api.slack.com/robots)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicWZQb1dyOWgwdWVqR2pVem80bFpMNW01Z1ZJa3pYMEFkV25uYUF0WSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTQ6Imh0dHBzOi8vdGVzdGluc3RhbGwubHZncm93Y2FwaXRhbC5jb20vYWRtaW5sb2dpbi9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1698996286),
('NgwAHRPYaS4jOqDbSjaXJ51aZU0mi1e5ytMUllut', 93, '102.88.62.104', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoid3dJY3hpZVladmpNVUFUS3dRaVNJSzVmZWNmRWhBOHBDeWNObXNVeCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vdGVzdGluc3RhbGwubHZncm93Y2FwaXRhbC5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUyOiJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6OTM7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjA6IiQyeSQxMCRMd09HL2oxbUxLLnQwLjJqa1NmdlVPZ1RSbFhWU0ZGaXV3ZHZjZUtQTXhkZGQ0dTYxcnNZLiI7czoyMToicGFzc3dvcmRfaGFzaF9zYW5jdHVtIjtzOjYwOiIkMnkkMTAkTHdPRy9qMW1MSy50MC4yamtTZnZVT2dUUmxYVlNGRml1d2R2Y2VLUE14ZGRkNHU2MXJzWS4iO30=', 1699001267),
('OuXXhleggnVLa6aS3y5X8h8BZR81qm2qB9iYxw7I', NULL, '34.254.53.125', 'Mozilla/5.0 (X11; Linux x86_64; rv:83.0) Gecko/20100101 Firefox/83.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoib25iY25jTXJmcFo1eHpSR0toNzhQVjVDRG9TUVVpdDE3dGwya0RCTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vdGVzdGluc3RhbGwubHZncm93Y2FwaXRhbC5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1698994917),
('PsSe3CBfl31CKG5LKj7aSP37aTs0HzuHASITmnxp', NULL, '31.94.15.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_4 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/113.0.5672.69 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVzRDVjVpSjRHVE5xZUp1dHVGbGVkS3lZOHpxdndxT2tLVEw5VmNZbyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vdGVzdGluc3RhbGwubHZncm93Y2FwaXRhbC5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1698999750),
('RURfMxkOdXyOyjB0ETV6S3iqob32lelQVh10TUoI', NULL, '193.239.84.86', 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_4 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/113.0.5672.69 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQXBMU3ROajBEa1I2T3JLOXgwYU9NT2lhRlpqc0hEWE55U3gwWnljNSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHBzOi8vd3d3LnRlc3RpbnN0YWxsLmx2Z3Jvd2NhcGl0YWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1698999741),
('tiDjrawPhgENNSaB4TgPFU75P40ywGOWX3VLJOL8', NULL, '161.35.246.138', 'Mozilla/5.0 (Android 10; Mobile; rv:109.0) Gecko/113.0 Firefox/113.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTVM5aXJvRWN2NVplS0VXeTBIRktlSHV6dmVHQk5aMmY5ZWUyaGJHSyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHBzOi8vd3d3LnRlc3RpbnN0YWxsLmx2Z3Jvd2NhcGl0YWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1698999741),
('vwlechjeWt7crsztYvkRivTcewo3ODVLsZAu1vfn', NULL, '45.79.221.160', 'Go-http-client/1.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSmlMRWpLdFF3RGxSM1VJa01GZ1BFd1pESFpXekxyQXF0VnpDZmJDZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vdGVzdGluc3RhbGwubHZncm93Y2FwaXRhbC5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1698998821),
('wByebgwPpVPXKsLAgfAtA94jq3nDdROW1kJNviQV', NULL, '34.254.53.125', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:109.0) Gecko/20100101 Firefox/118.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaVUxN21vcVY5Qm5sR1l2aWkwSGRlOUZRRjRvbFU5TFMwbzNvbDVXUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vdGVzdGluc3RhbGwubHZncm93Y2FwaXRhbC5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1698994918),
('YSR4QOLdIOZ8U0xfLXRrdxfw4sgo0Jqsya19MdW4', NULL, '34.254.53.125', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:109.0) Gecko/20100101 Firefox/118.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZGNXOWJzYWdlNDBJN1N5V3BhVkZVU2V6am1za3BUeU5JQzdxclNPUCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHBzOi8vd3d3LnRlc3RpbnN0YWxsLmx2Z3Jvd2NhcGl0YWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1698994939),
('z5wFQhh4vkcP29bdIXrHPuVU7V5lgLBibP9xZXP1', NULL, '216.131.88.4', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36 Edg/113.0.1774.42', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVm1pRTg5VGJpb2lMZktyV1BCU0h4OUNDNGNHd0IzQzMwazkySDZVaSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vdGVzdGluc3RhbGwubHZncm93Y2FwaXRhbC5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1698999744),
('ZlKh3hN5egL2uPeyfNJcbbJRJ3WXe19ah0gn6SzQ', NULL, '31.171.152.188', 'Mozilla/5.0 (Linux; Android 11) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZjFpSkkweWhNRm1RS3NyYUN2QjE2ZnFFZUliR3RyOHh5SG94Y3NLZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHBzOi8vd3d3LnRlc3RpbnN0YWxsLmx2Z3Jvd2NhcGl0YWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1698999741);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `site_name` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `currency` varchar(191) DEFAULT NULL,
  `s_currency` varchar(191) DEFAULT NULL,
  `capt_secret` varchar(191) DEFAULT NULL,
  `capt_sitekey` varchar(191) DEFAULT NULL,
  `payment_mode` varchar(191) DEFAULT NULL,
  `location` varchar(191) DEFAULT NULL,
  `s_s_k` varchar(191) DEFAULT NULL,
  `s_p_k` varchar(191) DEFAULT NULL,
  `pp_cs` varchar(191) DEFAULT NULL,
  `pp_ci` varchar(191) DEFAULT NULL,
  `keywords` varchar(191) DEFAULT NULL,
  `site_title` varchar(191) DEFAULT NULL,
  `site_address` varchar(191) DEFAULT NULL,
  `logo` varchar(191) DEFAULT NULL,
  `favicon` varchar(191) DEFAULT NULL,
  `trade_mode` varchar(191) DEFAULT NULL,
  `google_translate` varchar(191) DEFAULT NULL,
  `weekend_trade` varchar(191) DEFAULT NULL,
  `contact_email` varchar(191) DEFAULT NULL,
  `timezone` varchar(191) DEFAULT NULL,
  `mail_server` varchar(20) DEFAULT NULL,
  `emailfrom` varchar(191) DEFAULT NULL,
  `emailfromname` varchar(191) DEFAULT NULL,
  `smtp_host` varchar(191) DEFAULT NULL,
  `smtp_port` varchar(191) DEFAULT NULL,
  `smtp_encrypt` varchar(191) DEFAULT NULL,
  `smtp_user` varchar(191) DEFAULT NULL,
  `smtp_password` varchar(191) DEFAULT NULL,
  `google_secret` varchar(191) DEFAULT NULL,
  `google_id` varchar(191) DEFAULT NULL,
  `google_redirect` varchar(191) DEFAULT NULL,
  `referral_commission` varchar(191) DEFAULT NULL,
  `referral_commission1` varchar(191) DEFAULT NULL,
  `referral_commission2` varchar(191) DEFAULT NULL,
  `referral_commission3` varchar(191) DEFAULT NULL,
  `referral_commission4` varchar(191) DEFAULT NULL,
  `referral_commission5` varchar(191) DEFAULT NULL,
  `signup_bonus` varchar(191) DEFAULT NULL,
  `deposit_bonus` int(11) DEFAULT NULL,
  `tawk_to` longtext DEFAULT NULL,
  `enable_2fa` varchar(191) NOT NULL DEFAULT 'no',
  `enable_kyc` varchar(191) NOT NULL DEFAULT 'no',
  `enable_kyc_registration` varchar(191) DEFAULT NULL,
  `enable_with` varchar(191) DEFAULT NULL,
  `enable_verification` varchar(191) NOT NULL DEFAULT 'true',
  `enable_social_login` varchar(191) DEFAULT NULL,
  `withdrawal_option` varchar(191) NOT NULL DEFAULT 'auto',
  `deposit_option` varchar(191) DEFAULT NULL,
  `auto_merchant_option` varchar(191) DEFAULT 'Coinpayment',
  `dashboard_option` varchar(191) DEFAULT NULL,
  `enable_annoc` varchar(191) DEFAULT NULL,
  `subscription_service` text DEFAULT NULL,
  `captcha` varchar(191) DEFAULT NULL,
  `return_capital` tinyint(1) DEFAULT 1,
  `should_cancel_plan` tinyint(1) DEFAULT 1,
  `subscription_type` varchar(191) DEFAULT 'Fixed',
  `percentage_fee` decimal(8,2) DEFAULT 0.00,
  `use_copytrade` tinyint(1) DEFAULT 1,
  `commission_type` varchar(191) DEFAULT NULL,
  `billing_period` varchar(11) DEFAULT 'month',
  `commission_fee` varchar(191) DEFAULT NULL,
  `monthlyfee` varchar(191) DEFAULT NULL,
  `quarterlyfee` varchar(191) DEFAULT NULL,
  `yearlyfee` varchar(191) DEFAULT NULL,
  `newupdate` varchar(191) DEFAULT NULL,
  `modules` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`modules`)),
  `redirect_url` varchar(192) DEFAULT NULL,
  `website_theme` varchar(191) DEFAULT 'purpose.css',
  `referral_proffit_from` varchar(255) NOT NULL DEFAULT 'deposit',
  `theme` varchar(192) DEFAULT NULL,
  `ib_link` text DEFAULT NULL,
  `themes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`themes`)),
  `route_cached` tinyint(1) DEFAULT 0,
  `view_cached` tinyint(1) DEFAULT 0,
  `config_cached` tinyint(1) DEFAULT 0,
  `environment` varchar(11) DEFAULT 'local',
  `debug_mode` tinyint(1) DEFAULT 1,
  `credit_card_provider` varchar(191) DEFAULT 'Paystack',
  `deduction_option` varchar(191) DEFAULT 'userRequest',
  `welcome_message` text DEFAULT NULL,
  `install_type` varchar(20) DEFAULT NULL,
  `merchant_key` varchar(192) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `site_name`, `description`, `currency`, `s_currency`, `capt_secret`, `capt_sitekey`, `payment_mode`, `location`, `s_s_k`, `s_p_k`, `pp_cs`, `pp_ci`, `keywords`, `site_title`, `site_address`, `logo`, `favicon`, `trade_mode`, `google_translate`, `weekend_trade`, `contact_email`, `timezone`, `mail_server`, `emailfrom`, `emailfromname`, `smtp_host`, `smtp_port`, `smtp_encrypt`, `smtp_user`, `smtp_password`, `google_secret`, `google_id`, `google_redirect`, `referral_commission`, `referral_commission1`, `referral_commission2`, `referral_commission3`, `referral_commission4`, `referral_commission5`, `signup_bonus`, `deposit_bonus`, `tawk_to`, `enable_2fa`, `enable_kyc`, `enable_kyc_registration`, `enable_with`, `enable_verification`, `enable_social_login`, `withdrawal_option`, `deposit_option`, `auto_merchant_option`, `dashboard_option`, `enable_annoc`, `subscription_service`, `captcha`, `return_capital`, `should_cancel_plan`, `subscription_type`, `percentage_fee`, `use_copytrade`, `commission_type`, `billing_period`, `commission_fee`, `monthlyfee`, `quarterlyfee`, `yearlyfee`, `newupdate`, `modules`, `redirect_url`, `website_theme`, `referral_proffit_from`, `theme`, `ib_link`, `themes`, `route_cached`, `view_cached`, `config_cached`, `environment`, `debug_mode`, `credit_card_provider`, `deduction_option`, `welcome_message`, `install_type`, `merchant_key`, `created_at`, `updated_at`) VALUES
(1, 'OnlineTrader', 'We are online', '$', 'USD', NULL, NULL, '123567', NULL, 'sk_test_your_stripe_secret_key_here', 'pk_test_51JP8qpSBWKZBQRLPUIfQVYfUGly65fb1LiPUwAUajKy1nVM9Rvly3v3hQLvXnRqrWCrnUNz1qPQHNSxE689tSAoL00B1iOTNfd', 'jijdjkdkdk', 'iidjdjdj', 'online trade, forex, cfd,', 'Welcome to Online Trade', 'https://onlinetrade.test', 'photos/EaiBxGHxL2zHEz0jBXItz3unQ9HwBvtXdgQOgpLd.png', 'photos/i6KEyIIzscFVLkNd20fCnXsUesrnIemV3XQN3dt8.png', 'on', 'on', 'off', 'support@onlintrade.com', 'Africa/Lagos', 'sendmail', 'onlintrade@happ.com', 'Online Trade', 'smtp.mailtrap.io', '2525', 'tls', NULL, NULL, NULL, NULL, 'http://yoursite.com/auth/google/callback', '10', '30', '20', '10', '5', '1', NULL, 0, NULL, 'no', 'yes', 'no', 'true', 'true', 'yes', 'manual', 'manual', 'Binance', 'dark', 'on', NULL, 'false', 1, 1, 'Fixed', 1.00, 1, 'amount-traded', 'Weekly', NULL, '30', '40', '80', 'Welcome to Online trader version 5 with a lot of Security Features,', '{\"signal\":false,\"cryptoswap\":true,\"investment\":true,\"membership\":false,\"subscription\":false}', NULL, 'green.css', 'Deposit', 'purpose', 'kdldkdkd', '[\"purpose\", \"millage\"]', 0, 0, 0, 'local', 1, 'Stripe', 'AdminApprove', 'Welcome to Online trader, Please buy a plan', 'Main-Domain', NULL, NULL, '2023-11-03 12:47:13');

-- --------------------------------------------------------

--
-- Table structure for table `settings_conts`
--

CREATE TABLE `settings_conts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `use_crypto_feature` varchar(20) NOT NULL DEFAULT 'true',
  `fee` float DEFAULT 0,
  `btc` varchar(20) NOT NULL DEFAULT 'enabled',
  `eth` varchar(20) NOT NULL DEFAULT 'enabled',
  `ltc` varchar(20) NOT NULL DEFAULT 'enabled',
  `link` varchar(20) NOT NULL DEFAULT 'enabled',
  `bnb` varchar(191) NOT NULL DEFAULT 'enabled',
  `aave` varchar(250) DEFAULT 'enabled',
  `usdt` varchar(250) NOT NULL DEFAULT 'enabled',
  `bch` varchar(191) NOT NULL DEFAULT 'enabled',
  `xlm` varchar(191) NOT NULL DEFAULT 'enabled',
  `xrp` varchar(191) NOT NULL DEFAULT 'enabled',
  `ada` varchar(191) NOT NULL DEFAULT 'enabled',
  `currency_rate` int(11) DEFAULT NULL,
  `minamt` int(11) DEFAULT NULL,
  `use_transfer` tinyint(1) DEFAULT 1,
  `min_transfer` int(11) DEFAULT 0,
  `purchase_code` varchar(191) DEFAULT 'xxxxxx',
  `old_version` varchar(191) NOT NULL DEFAULT '6',
  `transfer_charges` int(11) DEFAULT 0,
  `bnc_secret_key` varchar(191) DEFAULT NULL,
  `bnc_api_key` varchar(191) DEFAULT NULL,
  `flw_secret_hash` varchar(191) DEFAULT NULL,
  `flw_secret_key` varchar(191) DEFAULT NULL,
  `flw_public_key` varchar(191) DEFAULT NULL,
  `local_currency` varchar(20) DEFAULT NULL,
  `commission_p2p` float DEFAULT NULL,
  `enable_p2p` varchar(20) DEFAULT NULL,
  `base_currency` varchar(20) DEFAULT NULL,
  `telegram_bot_api` varchar(192) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings_conts`
--

INSERT INTO `settings_conts` (`id`, `use_crypto_feature`, `fee`, `btc`, `eth`, `ltc`, `link`, `bnb`, `aave`, `usdt`, `bch`, `xlm`, `xrp`, `ada`, `currency_rate`, `minamt`, `use_transfer`, `min_transfer`, `purchase_code`, `old_version`, `transfer_charges`, `bnc_secret_key`, `bnc_api_key`, `flw_secret_hash`, `flw_secret_key`, `flw_public_key`, `local_currency`, `commission_p2p`, `enable_p2p`, `base_currency`, `telegram_bot_api`, `created_at`, `updated_at`) VALUES
(1, 'false', 2, 'enabled', 'enabled', 'enabled', 'disabled', 'enabled', 'disabled', 'enabled', 'enabled', 'enabled', 'enabled', 'enabled', NULL, 5, 1, 50, NULL, '', 0, NULL, NULL, NULL, NULL, NULL, 'USD', 0, 'false', NULL, NULL, '2021-10-31 18:32:30', '2023-06-06 12:35:50');

-- --------------------------------------------------------

--
-- Table structure for table `symbol_maps`
--

CREATE TABLE `symbol_maps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from_symbol` varchar(255) NOT NULL,
  `to_symbol` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `symbol_maps`
--

INSERT INTO `symbol_maps` (`id`, `from_symbol`, `to_symbol`, `created_at`, `updated_at`) VALUES
(1, 'EURUSD.m', 'EURUSD', '2023-08-23 14:11:10', '2023-08-23 14:11:10'),
(2, '#AA', '1INCHUSDm', '2023-08-23 14:12:38', '2023-08-23 14:12:38');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `status` varchar(191) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `designation` varchar(191) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `priority` varchar(191) DEFAULT NULL,
  `attch` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `terms_privacies`
--

CREATE TABLE `terms_privacies` (
  `id` int(10) UNSIGNED NOT NULL,
  `description` text NOT NULL,
  `useterms` varchar(191) NOT NULL DEFAULT 'yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `terms_privacies`
--

INSERT INTO `terms_privacies` (`id`, `description`, `useterms`, `created_at`, `updated_at`) VALUES
(1, '<p><strong>Our Commitment to You:</strong></p>\r\n\r\n<p>Thank you for showing interest in our service. In order for us to provide you with our service, we are required to collect and process certain personal data about you and your activity.</p>\r\n\r\n<p>By entrusting us with your personal data, we would like to assure you of our commitment to keep such information private and to operate in accordance with all regulatory laws and all EU data protection laws, including General Data Protection Regulation (GDPR) 679/2016 (EU).</p>\r\n\r\n<p>We have taken measurable steps to protect the confidentiality, security and integrity of this data. We encourage you to review the following information carefully.</p>\r\n\r\n<p><strong>Grounds for data collection:</strong></p>\r\n\r\n<p>Processing of your personal information (meaning, any data which may potentially allow your identification with reasonable means; hereinafter &ldquo;Personal Data&rdquo;) is necessary for the performance of our contractual obligations towards you and providing you with our services, to protect our legitimate interests and for compliance with legal and financial regulatory obligations to which we are subject.</p>\r\n\r\n<p>When you use our services, you consent to the collection, storage, use, disclosure and other uses of your Personal Data as described in this Privacy Policy.</p>\r\n\r\n<p><strong>How do we receive data about you?</strong></p>\r\n\r\n<p>We receive your Personal Data from various sources:</p>\r\n\r\n<ol>\r\n	<li>When you voluntarily provide us with your personal details in order to create an account (for example, your name and email address)</li>\r\n	<li>When you use or access our site and services, in connection with your use of our services (for example, your financial transactions)</li>\r\n	<li>&nbsp;</li>\r\n</ol>\r\n\r\n<p><strong>What type of data we collect?</strong></p>\r\n\r\n<p>In order to open an account, and in order to provide you with our services we will need you to collect the following data:</p>\r\n\r\n<p><strong>Personal Data<br />\r\nWe collect the following Personal Data about you:</strong></p>\r\n\r\n<ul>\r\n	<li><em>Registration data</em>&nbsp;&ndash; your name, email address, phone number, occupation, country of residence, and your age (in order to verify you are over 18 years of age and eligible to participate in our service).</li>\r\n	<li><em>Voluntary data</em>&nbsp;&ndash; when you communicate with us (for example when you send us an email or use a &ldquo;contact us&rdquo; form on our site) we collect the personal data you provided us with.</li>\r\n	<li><em>Financial data</em>&nbsp;&ndash; by its nature, your use of our services includes financial transactions, thus requiring us to obtain your financial details, which includes, but not limited to your payment details (such as bank account details and financial transactions performed through our services).</li>\r\n	<li><em>Technical data</em>&nbsp;&ndash; we collect certain technical data that is automatically recorded when you use our services, such as your IP address, MAC address, device approximate location</li>\r\n	<li>Non Personal Data</li>\r\n</ul>\r\n\r\n<p>We record and collect data from or about your device (for example your computer or your mobile device) when you access our services and visit our site. This includes, but not limited to: your login credentials, UDID, Google advertising ID, IDFA, cookie identifiers, and may include other identifiers such your operating system version, browser type, language preferences, time zone, referring domains and the duration of your visits. This will facilitate our ability to improve our service and personalize your experience with us.<br />\r\nIf we combine Personal Data with non-Personal Data about you, the combined data will be treated as Personal Data for as long as it remains combined.</p>\r\n\r\n<p><strong>Tracking Technologies</strong></p>\r\n\r\n<p>When you visit or access our services we use (and authorize 3rd parties to use) pixels, cookies, events and other technologies (&ldquo;Tracking Technologies&ldquo;). Those allow us to automatically collect data about you, your device and your online behavior, in order to enhance your navigation in our services, improve our site&rsquo;s performance, perform analytics and customize your experience on it. In addition, we may merge data we have with data collected through said tracking technologies with data we may obtain from other sources and, as a result, such data may become Personal Data.<br />\r\nCookie Policy page.</p>\r\n\r\n<p><strong>How do we use the data We collect?</strong></p>\r\n\r\n<ul>\r\n	<li>Provision of service &ndash; we will use your Personal Data you provide us for the provision and improvement of our services to you.</li>\r\n	<li>Marketing purposes &ndash; we will use your Personal Data (such as your email address or phone number). For example, by subscribing to our newsletter you will receive tips and announcements straight to your email account. We may also send you promotional material concerning our services or our partners&rsquo; services (which we believe may interest you), including but not limited to, by building an automated profile based on your Personal Data, for marketing purposes. You may choose not to receive our promotional or marketing emails (all or any part thereof) by clicking on the &ldquo;unsubscribe&rdquo; link in the emails that you receive from us. Please note that even if you unsubscribe from our newsletter, we may continue to send you service-related updates and notifications or reply to your queries and feedback you provide us.</li>\r\n	<li>Opt-out of receiving marketing materials &ndash; If you do not want us to use or share your personal data for marketing purposes, you may opt-out in accordance with this &ldquo;Opt-out&rdquo; section. Please note that even if you opt-out, we may still use and share your personal information with third parties for non-marketing purposes (for example to fulfill your requests, communicate with you and respond to your inquiries, etc.). In such cases, the companies with whom we share your personal data are authorized to use your Personal Data only as necessary to provide these non-marketing services.</li>\r\n	<li>Analytics, surveys and research &ndash; we are always trying to improve our services and think of new and exciting features for our users. From time to time, we may conduct surveys or test features, and analyze the information we have to develop, evaluate and improve these features.</li>\r\n	<li>Protecting our interests &ndash; we use your Personal Data when we believe it&rsquo;s necessary in order to take precautions against liabilities, investigate and defend ourselves against any third-party claims or allegations, investigate and protect ourselves from fraud, protect the security or integrity of our services and protect the rights and property of the company, its users and/or partners.</li>\r\n	<li>Enforcing of policies &ndash; we use your Personal Data in order to enforce our policies, including but limited to our Terms &amp; Conditions.</li>\r\n	<li>Compliance with legal and regulatory requirements &ndash; we also use your Personal Data to investigate violations and prevent money laundering and perform due-diligence checks, and as required by law, regulation or other governmental authority, or to comply with a subpoena or similar legal process.</li>\r\n</ul>\r\n\r\n<p><strong>With whom do we share your Personal Data</strong></p>\r\n\r\n<ul>\r\n	<li>Internal concerned parties &ndash; we share your data with companies in our group, as well as our employees limited to those employees or partners who need to know the information in order to provide you with our services.</li>\r\n	<li>Financial providers and payment processors &ndash; we share your financial data about you for purposes of accepting deposits or performing risk analysis.</li>\r\n	<li>Business partners &ndash; we share your data with business partners, such as storage providers and analytics providers who help us provide you with our service.</li>\r\n	<li>Legal and regulatory entities &ndash; we may disclose any data in case we believe, in good faith, that such disclosure is necessary in order to enforce our Terms &amp; Conditions take precautions against liabilities, investigate and defend ourselves against any third party claims or allegations, protect the security or integrity of the site and our servers and protect the rights and property, our users and/or partners. We may also disclose your personal data where requested any other regulatory authority having control or jurisdiction over us, you or our associates or in the territories we have clients or providers, as a broker.</li>\r\n	<li>Merger and acquisitions &ndash; we may share your data if we enter into a business transaction such as a merger, acquisition, reorganization, bankruptcy, or sale of some or all of our assets. Any party that acquires our assets as part of such a transaction may continue to use your data in accordance with the terms of this Privacy Policy.</li>\r\n</ul>\r\n\r\n<p><strong>Transfer of data outside the EEA</strong></p>\r\n\r\n<p>Please note that some data recipients may be located outside the EEA. In such cases, we will transfer your data only to such countries as approved by the European Commission as providing an adequate level of data protection or enter into legal agreements ensuring an adequate level of data protection.</p>\r\n\r\n<p><strong>How we protect your data</strong></p>\r\n\r\n<p>We have implemented administrative, technical, and physical safeguards to help prevent unauthorized access, use, or disclosure of your personal data. Your data is stored on secure servers and isn&rsquo;t publicly available. We limit access of your data only to those employees or partners that need to know the information in order to enable the carrying out of the agreement between us.</p>\r\n\r\n<p>You need to help us prevent unauthorized access to your account by protecting your password appropriately and limiting access to your account (for example, by signing off after you have finished accessing your account). You will be solely responsible for keeping your password confidential and for all use of your password and your account, including any unauthorized use.</p>\r\n\r\n<p>While we seek to protect your data to ensure that it is kept confidential, we cannot absolutely guarantee its security. You should be aware that there is always some risk involved in transmitting data over the internet. While we strive to protect your Personal Data, we cannot ensure or warrant the security and privacy of your personal Data or other content you transmit using the service, and you do so at your own risk.</p>\r\n\r\n<p><strong>Retention</strong></p>\r\n\r\n<p>We will retain your personal data for as long as necessary to provide our services, and as necessary to comply with our legal obligations, resolve disputes, and enforce our policies. Retention periods will be determined taking into account the type of data that is collected and the purpose for which it is collected, bearing in mind the requirements applicable to the situation and the need to destroy outdated, unused data at the earliest reasonable time. Under applicable regulations, we will keep records containing client personal data, trading information, account opening documents, communications and anything else as required by applicable laws and regulations.</p>\r\n\r\n<p><strong>User Rights</strong></p>\r\n\r\n<ol>\r\n	<li>Receive confirmation as to whether or not personal data concerning you is being processed, and access your stored personal data, together with supplementary data.</li>\r\n	<li>Receive a copy of personal data you directly volunteer to us in a structured, commonly used and machine-readable format.</li>\r\n	<li>Request rectification of your personal data that is in our control.</li>\r\n	<li>Request erasure of your personal data.</li>\r\n	<li>Object to the processing of personal data by us.</li>\r\n	<li>Request to restrict processing of your personal data by us.</li>\r\n</ol>\r\n\r\n<p>However, please note that these rights are not absolute, and may be subject to our own legitimate interests and regulatory requirements.</p>\r\n\r\n<p><strong>How to Contact us?</strong></p>\r\n\r\n<p>If you wish to exercise any of the aforementioned rights, or receive more information, please contact our General Data Protection Officer (&ldquo;GDPO&rdquo;) using the details provided below:</p>\r\n\r\n<p>Email: support@onlintrade.com</p>\r\n\r\n<p>Attn. GDPO Compliance Officer</p>\r\n\r\n<p>If you decide to terminate your account, you may do so by emailing us at support@onlintrade.com. If you terminate your account, please be aware that personal information that you have provided us may still be maintained for legal and regulatory reasons (as described above), but it will no longer be accessible via your account.</p>\r\n\r\n<p><strong>Updates to this Policy</strong></p>\r\n\r\n<p>This Privacy Policy is subject to changes from time to time, at our sole discretion. The most current version will always be posted on our website (as reflected in the &ldquo;Last Updated&rdquo; heading). You are advised to check for updates regularly. In the event of material changes, we will provide you with a notice. By continuing to access or use our services after any revisions become effective, you agree to be bound by the updated Privacy Policy.</p>', 'yes', '2020-12-14 15:39:57', '2023-06-13 15:32:09');

-- --------------------------------------------------------

--
-- Table structure for table `testimonies`
--

CREATE TABLE `testimonies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ref_key` varchar(191) DEFAULT NULL,
  `position` varchar(191) DEFAULT NULL,
  `name` varchar(191) DEFAULT NULL,
  `what_is_said` varchar(191) DEFAULT NULL,
  `picture` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `themes`
--

CREATE TABLE `themes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `path` varchar(191) DEFAULT NULL,
  `description` varchar(191) DEFAULT NULL,
  `active` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `themes`
--

INSERT INTO `themes` (`id`, `name`, `path`, `description`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Archive', '/Users/macbookair/Documents/Brynamics/OnlineTraderSoftware/onlinetrader/storage/app/livewire-tmp/DLwSLZtJEzlOagm35LBsmE2EOIYmlL-metaQXJjaGl2ZS56aXA=-.zip', NULL, 0, '2023-01-31 14:42:54', '2023-02-13 16:00:55'),
(2, 'Qudash', '/Users/macbookair/Documents/Brynamics/OnlineTraderSoftware/onlinetrader/storage/app/livewire-tmp/pUsIsoprhLVTC8ubgINjtrPWmNugZV-metaUXVkYXNoLnppcA==-.zip', NULL, 0, '2023-01-31 15:23:14', '2023-02-15 20:08:15'),
(3, 'Front', '/Users/macbookair/Documents/Brynamics/OnlineTraderSoftware/onlinetrader/storage/app/livewire-tmp/pUsIsoprhLVTC8ubgINjtrPWmNugZV-metaUXVkYXNoLnppcA==-.zip', NULL, 1, '2023-02-13 17:03:05', '2023-02-15 20:08:15');

-- --------------------------------------------------------

--
-- Table structure for table `tp__transactions`
--

CREATE TABLE `tp__transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `plan` varchar(250) DEFAULT NULL,
  `user_plan_id` int(11) DEFAULT NULL,
  `user` int(11) DEFAULT NULL,
  `amount` varchar(191) DEFAULT NULL,
  `type` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tp__transactions`
--

INSERT INTO `tp__transactions` (`id`, `plan`, `user_plan_id`, `user`, `amount`, `type`, `created_at`, `updated_at`) VALUES
(27, 'Standard', 27, 174, '4', 'ROI', '2023-07-04 16:13:52', '2023-07-04 16:13:52'),
(28, 'Credit', NULL, 93, '0.4', 'Ref_bonus', '2023-07-04 16:22:25', '2023-07-04 16:22:25'),
(29, 'Standard', NULL, 174, '200', 'Investment capital', '2023-07-04 18:35:56', '2023-07-04 18:35:56'),
(30, 'Subscribed MT4 Trading', NULL, 93, '30', 'MT4 Trading', '2023-07-21 19:30:18', '2023-07-21 19:30:18'),
(31, 'Credit', NULL, 93, '20', 'balance', '2023-07-25 15:24:05', '2023-07-25 15:24:05'),
(32, 'Credit', NULL, 179, '20', 'balance', '2023-07-25 15:25:43', '2023-07-25 15:25:43'),
(33, 'Credit', NULL, 181, '20', 'balance', '2023-07-25 15:25:45', '2023-07-25 15:25:45'),
(34, 'Subscribed MT4 Trading', NULL, 93, '30', 'MT4 Trading', '2023-10-09 14:25:37', '2023-10-09 14:25:37'),
(35, 'Subscribed MT4 Trading', NULL, 93, '40', 'MT4 Trading', '2023-10-09 14:26:27', '2023-10-09 14:26:27'),
(36, 'Subscribed MT4 Trading', NULL, 93, '80', 'MT4 Trading', '2023-10-09 14:26:51', '2023-10-09 14:26:51'),
(37, 'Credit', NULL, 93, '10', 'Ref_bonus', '2023-10-13 13:13:58', '2023-10-13 13:13:58'),
(38, 'Credit', NULL, 93, '400', 'balance', '2023-10-17 13:23:42', '2023-10-17 13:23:42'),
(39, 'Standard', NULL, 93, '200', 'Plan purchase', '2023-10-17 13:23:59', '2023-10-17 13:23:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kyc_id` int(11) DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `username` varchar(191) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `cstatus` varchar(191) DEFAULT NULL,
  `userupdate` text DEFAULT NULL,
  `assign_to` varchar(191) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `country` varchar(191) DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `dashboard_style` varchar(191) NOT NULL DEFAULT 'light',
  `bank_name` varchar(191) DEFAULT NULL,
  `account_name` varchar(191) DEFAULT NULL,
  `account_number` varchar(191) DEFAULT NULL,
  `swift_code` varchar(191) DEFAULT NULL,
  `acnt_type_active` varchar(191) DEFAULT NULL,
  `btc_address` varchar(191) DEFAULT NULL,
  `eth_address` varchar(191) DEFAULT NULL,
  `ltc_address` varchar(191) DEFAULT NULL,
  `usdt_address` varchar(191) DEFAULT NULL,
  `plan` varchar(191) DEFAULT NULL,
  `user_plan` varchar(191) DEFAULT NULL,
  `account_bal` float DEFAULT NULL,
  `roi` float DEFAULT NULL,
  `bonus` float DEFAULT NULL,
  `ref_bonus` float DEFAULT NULL,
  `signup_bonus` varchar(191) DEFAULT NULL,
  `auto_trade` varchar(191) DEFAULT NULL,
  `bonus_released` int(11) NOT NULL DEFAULT 0,
  `ref_by` varchar(191) DEFAULT NULL,
  `ref_link` varchar(191) DEFAULT NULL,
  `account_verify` varchar(191) DEFAULT NULL,
  `entered_at` datetime DEFAULT NULL,
  `activated_at` datetime DEFAULT NULL,
  `last_growth` datetime DEFAULT NULL,
  `status` varchar(25) DEFAULT 'active',
  `trade_mode` varchar(191) DEFAULT 'on',
  `act_session` varchar(191) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` text DEFAULT NULL,
  `withdrawotp` varchar(191) DEFAULT NULL,
  `sendotpemail` varchar(191) NOT NULL DEFAULT 'Yes',
  `sendroiemail` varchar(191) NOT NULL DEFAULT 'Yes',
  `sendpromoemail` varchar(191) NOT NULL DEFAULT 'Yes',
  `sendinvplanemail` varchar(191) NOT NULL DEFAULT 'Yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `kyc_id`, `name`, `email`, `username`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `dob`, `cstatus`, `userupdate`, `assign_to`, `address`, `country`, `phone`, `dashboard_style`, `bank_name`, `account_name`, `account_number`, `swift_code`, `acnt_type_active`, `btc_address`, `eth_address`, `ltc_address`, `usdt_address`, `plan`, `user_plan`, `account_bal`, `roi`, `bonus`, `ref_bonus`, `signup_bonus`, `auto_trade`, `bonus_released`, `ref_by`, `ref_link`, `account_verify`, `entered_at`, `activated_at`, `last_growth`, `status`, `trade_mode`, `act_session`, `remember_token`, `current_team_id`, `profile_photo_path`, `withdrawotp`, `sendotpemail`, `sendroiemail`, `sendpromoemail`, `sendinvplanemail`, `created_at`, `updated_at`) VALUES
(93, 10, 'Tester Test', 'test1234@happ.com', 'testtim1', '2022-03-09 19:24:34', '$2y$10$LwOG/j1mLK.t0.2jkSfvUOgTRlXVSFFiuwdvceKPMxddd4u61rsY.', NULL, NULL, NULL, 'Customer', NULL, NULL, 'My adddress', 'Nigeria', '9897009200202', 'light', 'Firstbanks', 'Rolly Bakers', '50211377871', '46641', NULL, 'bc1qxsu48d0g3wjlrf2qz03qruggxdsnt9fpxrmhrws', '0x542b5f0F013A20e90D5Ae187E426D48B9852Ed9ds', '2hshhsiDSKJSKS882i2s', 'bc1qxsu48d0g3wjl0x542b5f0F013A20e9s', '10', '28', 210, 0, 0, 10, 'received', NULL, 0, '151', 'http://127.0.0.1:8000/ref/testtim1', 'Rejected', '2023-10-17 09:23:59', NULL, NULL, 'active', 'on', NULL, 'SgfdivFN5vqMTUnXvOgr0r5LqOD3r9xwFu8fmoqExEAqx7gtnkrYtOdgG6JR', NULL, '', 'Sxzmp', 'No', 'No', 'Yes', 'Yes', '2023-05-09 16:48:46', '2023-10-17 13:23:59');

-- --------------------------------------------------------

--
-- Table structure for table `user_plans`
--

CREATE TABLE `user_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `plan` int(11) DEFAULT NULL,
  `user` int(11) DEFAULT NULL,
  `amount` varchar(191) DEFAULT NULL,
  `active` varchar(191) DEFAULT NULL,
  `inv_duration` varchar(191) DEFAULT NULL,
  `expire_date` datetime DEFAULT NULL,
  `activated_at` datetime DEFAULT NULL,
  `last_growth` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `profit_earned` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_plans`
--

INSERT INTO `user_plans` (`id`, `plan`, `user`, `amount`, `active`, `inv_duration`, `expire_date`, `activated_at`, `last_growth`, `created_at`, `updated_at`, `profit_earned`) VALUES
(22, 10, 93, '200', 'cancelled', '1 Hours', '2023-06-07 15:25:36', '2023-06-07 14:25:36', '2023-06-07 14:49:36', '2023-06-07 18:25:36', '2023-06-07 19:20:02', NULL),
(24, 10, 93, '200', 'cancelled', '1 Hours', '2023-06-13 20:07:03', '2023-06-13 19:07:03', '2023-06-13 19:31:03', '2023-06-13 23:07:03', '2023-06-13 23:46:19', NULL),
(25, 10, 93, '200', 'cancelled', '1 Hours', '2023-06-13 21:10:45', '2023-06-13 20:10:45', '2023-06-13 20:34:45', '2023-06-14 00:10:45', '2023-06-16 22:57:24', NULL),
(26, 10, 175, '200', 'expired', '1 Hours', '2023-06-13 22:21:02', '2023-06-13 21:21:02', '2023-06-13 21:45:02', '2023-06-14 01:21:02', '2023-07-04 15:55:18', NULL),
(28, 10, 93, '200', 'yes', '1 Hours', '2023-10-17 10:23:59', '2023-10-17 09:23:59', '2023-10-17 09:47:59', '2023-10-17 13:23:59', '2023-10-17 13:23:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wdmethods`
--

CREATE TABLE `wdmethods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `minimum` varchar(191) DEFAULT NULL,
  `maximum` varchar(191) DEFAULT NULL,
  `charges_amount` varchar(191) DEFAULT NULL,
  `charges_type` varchar(191) DEFAULT NULL,
  `duration` varchar(191) DEFAULT NULL,
  `img_url` text DEFAULT NULL,
  `bankname` varchar(191) DEFAULT NULL,
  `account_name` varchar(191) DEFAULT NULL,
  `account_number` varchar(191) DEFAULT NULL,
  `swift_code` varchar(191) DEFAULT NULL,
  `wallet_address` text DEFAULT NULL,
  `barcode` text DEFAULT NULL,
  `network` varchar(191) DEFAULT NULL,
  `methodtype` varchar(191) DEFAULT NULL,
  `type` varchar(191) DEFAULT NULL,
  `status` varchar(191) DEFAULT NULL,
  `defaultpay` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wdmethods`
--

INSERT INTO `wdmethods` (`id`, `name`, `minimum`, `maximum`, `charges_amount`, `charges_type`, `duration`, `img_url`, `bankname`, `account_name`, `account_number`, `swift_code`, `wallet_address`, `barcode`, `network`, `methodtype`, `type`, `status`, `defaultpay`, `created_at`, `updated_at`) VALUES
(1, 'Bitcoin', '10', '10000', '0', 'percentage', 'Instant', 'data:image/png;base64,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', NULL, NULL, NULL, NULL, 'e390303ifjjkjkkks993kdod90031', '938893993', 'Erc', 'crypto', 'both', 'enabled', 'yes', '2021-03-11 17:53:32', '2023-10-16 13:11:35'),
(2, 'Ethereum', '10', '2100', '0', 'percentage', 'Instant', 'https://lulo.com', NULL, NULL, NULL, NULL, 'dddddddddddddddddddddddd', '938893993', 'Erc', 'crypto', 'both', 'enabled', 'yes', '2021-03-22 15:36:03', '2023-10-16 13:11:31'),
(3, 'Litecoin', '100', '10000', '0', '0', 'Instant', 'https://lulo.com', NULL, NULL, NULL, NULL, 'hhhhhhhhhhhhhhhhhhhhhhh', 'hhhhhhhhhhh', 'Erc', 'crypto', 'both', 'enabled', 'yes', '2021-03-22 15:36:33', '2023-10-16 13:11:26'),
(10, 'Paypal', '10', '10000', '0', 'percentage', 'Instant Payment', 'https://lulo.com', 'Automatic', 'Automatic', '99388383', NULL, NULL, NULL, NULL, 'currency', 'deposit', 'enabled', 'yes', '2021-10-07 13:56:14', '2021-10-11 13:57:12'),
(12, 'Bank Transfer', '10', '10000', '0', 'percentage', 'Instant Payment', NULL, 'Mining Bank', 'Miller lauren', '99388383', '3222ASD', NULL, NULL, NULL, 'currency', 'both', 'enabled', 'yes', '2021-10-11 16:35:35', '2023-10-16 13:11:43'),
(21, 'USDT', '0', '100', '0', 'percentage', 'Instant Payment', NULL, NULL, NULL, NULL, NULL, 'enter your correct wallet address here', NULL, 'TRC20', 'crypto', 'both', 'enabled', 'yes', '2021-04-14 14:45:06', '2023-10-16 13:11:48'),
(23, 'BUSD', '0', '1000', '0', 'percentage', NULL, NULL, NULL, NULL, NULL, NULL, 'Enter your correct wallet address here', NULL, 'ERC20', 'crypto', 'both', 'enabled', 'yes', '2022-06-28 04:25:41', '2022-06-28 04:25:41'),
(24, 'Credit Card', '0', '0', '0', 'percentage', 'Instant Payment', NULL, '-', '-', '0', NULL, NULL, NULL, NULL, 'currency', 'deposit', 'enabled', 'yes', '2022-07-20 17:02:29', '2023-10-16 13:09:50');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `txn_id` varchar(191) DEFAULT NULL,
  `user` int(11) DEFAULT NULL,
  `amount` varchar(191) DEFAULT NULL,
  `columns` varchar(191) DEFAULT NULL,
  `to_deduct` varchar(191) DEFAULT NULL,
  `status` varchar(191) DEFAULT NULL,
  `payment_mode` varchar(191) DEFAULT NULL,
  `paydetails` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `autologin_tokens`
--
ALTER TABLE `autologin_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `autologin_tokens_token_unique` (`token`);

--
-- Indexes for table `bnc_transactions`
--
ALTER TABLE `bnc_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `contents`
--
ALTER TABLE `contents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cp_transactions`
--
ALTER TABLE `cp_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crypto_accounts`
--
ALTER TABLE `crypto_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crypto_records`
--
ALTER TABLE `crypto_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ipaddresses`
--
ALTER TABLE `ipaddresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `kycs`
--
ALTER TABLE `kycs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kycs_email_unique` (`email`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mt4_details`
--
ALTER TABLE `mt4_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `paystacks`
--
ALTER TABLE `paystacks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings_conts`
--
ALTER TABLE `settings_conts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `symbol_maps`
--
ALTER TABLE `symbol_maps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terms_privacies`
--
ALTER TABLE `terms_privacies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonies`
--
ALTER TABLE `testimonies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tp__transactions`
--
ALTER TABLE `tp__transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_plans`
--
ALTER TABLE `user_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wdmethods`
--
ALTER TABLE `wdmethods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `autologin_tokens`
--
ALTER TABLE `autologin_tokens`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bnc_transactions`
--
ALTER TABLE `bnc_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `contents`
--
ALTER TABLE `contents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `cp_transactions`
--
ALTER TABLE `cp_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `crypto_accounts`
--
ALTER TABLE `crypto_accounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `crypto_records`
--
ALTER TABLE `crypto_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `ipaddresses`
--
ALTER TABLE `ipaddresses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kycs`
--
ALTER TABLE `kycs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `mt4_details`
--
ALTER TABLE `mt4_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `paystacks`
--
ALTER TABLE `paystacks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings_conts`
--
ALTER TABLE `settings_conts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `symbol_maps`
--
ALTER TABLE `symbol_maps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `terms_privacies`
--
ALTER TABLE `terms_privacies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `testimonies`
--
ALTER TABLE `testimonies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `themes`
--
ALTER TABLE `themes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tp__transactions`
--
ALTER TABLE `tp__transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT for table `user_plans`
--
ALTER TABLE `user_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `wdmethods`
--
ALTER TABLE `wdmethods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
