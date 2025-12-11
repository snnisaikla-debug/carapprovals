-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2025 at 11:34 AM
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
-- Database: `car-approval`
--

-- --------------------------------------------------------

--
-- Table structure for table `approvals`
--

CREATE TABLE `approvals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `status` enum('WAIT_ADMIN','WAIT_HEAD','APPROVED','REJECTED_ADMIN','REJECTED_HEAD') NOT NULL DEFAULT 'WAIT_ADMIN',
  `car_model` varchar(255) NOT NULL,
  `car_price` decimal(10,2) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `customer_district` varchar(255) DEFAULT NULL,
  `customer_province` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(255) DEFAULT NULL,
  `car_color` varchar(255) DEFAULT NULL,
  `car_options` varchar(255) DEFAULT NULL,
  `plus_head` decimal(10,2) DEFAULT NULL,
  `fn` varchar(255) DEFAULT NULL,
  `down_percent` decimal(5,2) DEFAULT NULL,
  `down_amount` decimal(10,2) DEFAULT NULL,
  `finance_amount` decimal(10,2) DEFAULT NULL,
  `installment_per_month` decimal(10,2) DEFAULT NULL,
  `installment_months` int(11) DEFAULT NULL,
  `interest_rate` decimal(5,2) DEFAULT NULL,
  `campaign_code` varchar(255) DEFAULT NULL,
  `sale_type` varchar(255) DEFAULT NULL,
  `sale_type_amount` decimal(10,2) DEFAULT NULL,
  `fleet_amount` decimal(10,2) DEFAULT NULL,
  `insurance_deduct` decimal(10,2) DEFAULT NULL,
  `insurance_used` decimal(10,2) DEFAULT NULL,
  `kickback_amount` decimal(10,2) DEFAULT NULL,
  `com_fn_option` varchar(255) DEFAULT NULL,
  `com_fn_amount` decimal(10,2) DEFAULT NULL,
  `free_items` text DEFAULT NULL,
  `free_items_over` text DEFAULT NULL,
  `extra_purchase_items` text DEFAULT NULL,
  `campaigns_available` text DEFAULT NULL,
  `campaigns_used` text DEFAULT NULL,
  `is_commercial_30000` tinyint(1) NOT NULL DEFAULT 0,
  `decoration_amount` decimal(10,2) DEFAULT NULL,
  `over_campaign_amount` decimal(10,2) DEFAULT NULL,
  `over_campaign_status` varchar(255) DEFAULT NULL,
  `over_decoration_amount` decimal(10,2) DEFAULT NULL,
  `over_decoration_status` varchar(255) DEFAULT NULL,
  `over_reason` text DEFAULT NULL,
  `sc_signature` varchar(255) DEFAULT NULL,
  `sale_com_signature` varchar(255) DEFAULT NULL,
  `sales_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `approvals`
--

INSERT INTO `approvals` (`id`, `group_id`, `version`, `status`, `car_model`, `car_price`, `customer_name`, `remark`, `created_by`, `created_at`, `updated_at`, `customer_district`, `customer_province`, `customer_phone`, `car_color`, `car_options`, `plus_head`, `fn`, `down_percent`, `down_amount`, `finance_amount`, `installment_per_month`, `installment_months`, `interest_rate`, `campaign_code`, `sale_type`, `sale_type_amount`, `fleet_amount`, `insurance_deduct`, `insurance_used`, `kickback_amount`, `com_fn_option`, `com_fn_amount`, `free_items`, `free_items_over`, `extra_purchase_items`, `campaigns_available`, `campaigns_used`, `is_commercial_30000`, `decoration_amount`, `over_campaign_amount`, `over_campaign_status`, `over_decoration_amount`, `over_decoration_status`, `over_reason`, `sc_signature`, `sale_com_signature`, `sales_name`) VALUES
(1, 1, 1, 'WAIT_ADMIN', 'ABC', 180000.00, 'นาย เอบี เกิดไกล', NULL, 'SALE', '2025-12-04 02:58:45', '2025-12-04 02:58:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 1, 2, 'WAIT_HEAD', 'ABC', 180000.00, 'นาย เอบี เกิดไกล', NULL, 'ADMIN', '2025-12-04 02:58:55', '2025-12-04 02:58:55', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 1, 3, 'REJECTED_HEAD', 'ABC', 180000.00, 'นาย เอบี เกิดไกล', NULL, 'HEAD', '2025-12-04 02:58:59', '2025-12-04 02:58:59', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 4, 1, 'WAIT_ADMIN', 'DDF', 500000.00, 'AAA', NULL, 'SALE', '2025-12-04 02:59:20', '2025-12-04 02:59:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 4, 2, 'WAIT_HEAD', 'DDF', 500000.00, 'AAA', NULL, 'ADMIN', '2025-12-04 02:59:24', '2025-12-04 02:59:24', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 4, 3, 'APPROVED', 'DDF', 500000.00, 'AAA', NULL, 'HEAD', '2025-12-04 02:59:26', '2025-12-04 02:59:26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 7, 1, 'WAIT_ADMIN', 'GE2WXD4PRY0', 1059000.00, 'สุมิตร กิ่งคำ', NULL, 'SALE', '2025-12-10 01:41:54', '2025-12-10 01:41:54', 'สีชมพู', 'ขอนแก่น', '0112223333', 'X8W', NULL, NULL, 'NLTH', 25.00, 264750.00, 794250.00, NULL, 25000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '8', NULL, 'ป.1\r\nกรอบป้าย\r\nผ้ายาง\r\nคูปองน้ำมัน 5,000 บาท', NULL, 'ทะเบียน + พรบ 7500 บาท\r\nฟิล์มเซลามิก 60%/60% 4000 บาท\r\nน้ำมัน 500 บาท\r\n\r\nรวม 12000 บาท', 'แคมเปญ 7500\r\nGE 15000\r\nRE 10000\r\n\r\nรวม 100000', 'ซื้อเพิ่ม 12000\r\nหัก L 25000', 0, NULL, NULL, 'ไม่เกิน', NULL, 'ไม่เกิน', NULL, NULL, NULL, 'Pao');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
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
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_04_092952_create_approvals_table', 1),
(5, '2025_12_09_040719_add_role_to_users_table', 2),
(6, '2025_12_09_042828_add_detail_fields_to_approvals_table', 3),
(7, '2025_12_09_092156_add_avatar_to_users_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('HSg4tCHBDI4komuYrRkEOagGDHYx59zRrx4kT442', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTWFPMmdFV3AydGplRUF2T01mR0o5MkpBWVk2SW4wc2hNWXNBQVZEYSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hcHByb3ZhbHM/c29ydD1zYWxlcyI7czo1OiJyb3V0ZSI7czoxNToiYXBwcm92YWxzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1765362380),
('sf9Oa5Wps8dXdTC9P0vmU5GzJ6eZdlxO29lzyKPt', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNnF5Nm9nS29meHduM1R4OHN4b0x3MXBuclA1ZXJiSk1NeFB0Z2Z6UyI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czozMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FwcHJvdmFscyI7czo1OiJyb3V0ZSI7czoxNToiYXBwcm92YWxzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765435631),
('V9TFWdAJYMUZid5FchjA5SFp6Iu1AyTJmuCWZYiq', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibDhNWjlwYXZadmd1ZlVzSm9DTFlGR29VRWFFZ0puQXpUOGYyUXpBciI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hcHByb3ZhbHMiO3M6NToicm91dGUiO3M6MTU6ImFwcHJvdmFscy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1765416784);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'SALE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'Pao', 'sales@ypb.co.th', 'avatars/f2KgnWDxhs6nCXtWWqf7zkMGVb0lyqLO7wv7WeFO.jpg', NULL, '$2y$12$LkpWJ/TpHGT4zakwtBq8m.HkW1qzbatjD1cJ9qArLXOCQ1HsJt00q', '7m3pc1mOE4SyLLKyPywbPE8SV2kKiN3TKOqupOxULovdEckMX7uTk14iOXak', '2025-12-08 21:55:48', '2025-12-09 02:41:45', 'SALE'),
(2, 'Tung', 'head@ypb.co.th', NULL, NULL, '$2y$12$FKAmUGcoN36xEbSweil4b.tYKqynIoCUZTxtMJ4GiYVoNN5VcBt3C', NULL, '2025-12-09 01:56:19', '2025-12-09 01:56:19', 'HEAD'),
(3, 'Admin', 'admin@ypb.co.th', NULL, NULL, '$2y$12$sWJ3oFIgkr6wvJpQVz0AMOY/aa0PN/nWmrtveE.txzs9laaaxcuAG', NULL, '2025-12-09 01:56:47', '2025-12-09 01:56:47', 'ADMIN');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `approvals`
--
ALTER TABLE `approvals`
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
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `approvals`
--
ALTER TABLE `approvals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
