-- Elite RP Website Database Setup
-- Create the database if you haven't already:
-- CREATE DATABASE IF NOT EXISTS eliterp;
-- USE eliterp;

-- --------------------------------------------------------
-- Table structure for table `users`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `steam_id` varchar(50) DEFAULT NULL,
  `discord_id` varchar(50) DEFAULT NULL,
  `discord_name` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `avatar_url` text DEFAULT NULL,
  `is_whitelisted` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `steam_id` (`steam_id`),
  UNIQUE KEY `discord_id` (`discord_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table structure for table `applications`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `discord_name` varchar(100) NOT NULL,
  `discord_id` varchar(50) NOT NULL,
  `steam_name` varchar(100) NOT NULL,
  `age` int(11) NOT NULL,
  `character_name` varchar(100) NOT NULL,
  `char_ethnicity` varchar(50) NOT NULL,
  `char_backstory` text NOT NULL,
  `char_objectives` text NOT NULL,
  `source` varchar(100) NOT NULL,
  `reason` text NOT NULL,
  `experience` text NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `reviewed_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table structure for table `rate_limit` (Optional but good for rate_limiter.php)
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `rate_limit` (
  `ip_address` varchar(45) NOT NULL,
  `action_type` varchar(50) NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`ip_address`,`action_type`,`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
