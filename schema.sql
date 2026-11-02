-- ============================================================================
-- ApexCorp Solutions Database Schema
-- Database: company_db
-- Compatible with MySQL / MariaDB / phpMyAdmin
-- ============================================================================

CREATE DATABASE IF NOT EXISTS `company_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `company_db`;

-- ----------------------------------------------------------------------------
-- Table structure for table `users`
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `fullname` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('admin', 'employee') NOT NULL,
    `department` VARCHAR(100) NOT NULL,
    `designation` VARCHAR(100) NOT NULL,
    `phone` VARCHAR(30) NOT NULL,
    `location` VARCHAR(100) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- Seed Data for Admins (Default Password: Admin@123)
-- ----------------------------------------------------------------------------
INSERT INTO `users` (`fullname`, `email`, `password`, `role`, `department`, `designation`, `phone`, `location`) VALUES
('Michael Sterling', 'admin@apexcorp.com', '$2y$10$n59br04CblVK8t2CNkHkkuPVAWvC6wR4Q6wvTq879eJlPJjVKxfvm', 'admin', 'Executive', 'Chief Executive Officer (CEO)', '+1 (555) 019-2831', 'New York HQ - Floor 14'),
('Sarah Jenkins', 'sarah.director@apexcorp.com', '$2y$10$n59br04CblVK8t2CNkHkkuPVAWvC6wR4Q6wvTq879eJlPJjVKxfvm', 'admin', 'Human Resources', 'VP of People & Culture', '+1 (555) 019-2832', 'New York HQ - Floor 12'),
('David Chen', 'david.cto@apexcorp.com', '$2y$10$n59br04CblVK8t2CNkHkkuPVAWvC6wR4Q6wvTq879eJlPJjVKxfvm', 'admin', 'Engineering & Tech', 'Chief Technology Officer (CTO)', '+1 (555) 019-2833', 'San Francisco Tech Hub'),
('Elena Rostova', 'elena.ops@apexcorp.com', '$2y$10$n59br04CblVK8t2CNkHkkuPVAWvC6wR4Q6wvTq879eJlPJjVKxfvm', 'admin', 'Operations', 'Chief Operations Officer (COO)', '+1 (555) 019-2834', 'Chicago Operations Center')
ON DUPLICATE KEY UPDATE `email` = `email`;

-- ----------------------------------------------------------------------------
-- Seed Data for Employees (Default Password: Emp@123)
-- ----------------------------------------------------------------------------
INSERT INTO `users` (`fullname`, `email`, `password`, `role`, `department`, `designation`, `phone`, `location`) VALUES
('John Doe', 'john.dev@apexcorp.com', '$2y$10$fLIsNyeKV.kdb1UncBofJeb11OcuydLxLW7DQXpAj0UH4MMnoQ9.K', 'employee', 'Engineering', 'Senior Full Stack Engineer', '+1 (555) 441-1001', 'Remote - Austin, TX'),
('Emma Watson', 'emma.design@apexcorp.com', '$2y$10$fLIsNyeKV.kdb1UncBofJeb11OcuydLxLW7DQXpAj0UH4MMnoQ9.K', 'employee', 'Product Design', 'Lead UX/UI Designer', '+1 (555) 441-1002', 'San Francisco Tech Hub'),
('Alex Rivera', 'alex.marketing@apexcorp.com', '$2y$10$fLIsNyeKV.kdb1UncBofJeb11OcuydLxLW7DQXpAj0UH4MMnoQ9.K', 'employee', 'Marketing', 'Digital Growth Strategist', '+1 (555) 441-1003', 'New York HQ - Floor 9'),
('Sophia Martinez', 'sophia.data@apexcorp.com', '$2y$10$fLIsNyeKV.kdb1UncBofJeb11OcuydLxLW7DQXpAj0UH4MMnoQ9.K', 'employee', 'Data Science', 'Machine Learning Engineer', '+1 (555) 441-1004', 'Seattle Research Lab'),
('Liam Gallagher', 'liam.qa@apexcorp.com', '$2y$10$fLIsNyeKV.kdb1UncBofJeb11OcuydLxLW7DQXpAj0UH4MMnoQ9.K', 'employee', 'Quality Assurance', 'Lead QA Automation Engineer', '+1 (555) 441-1005', 'Chicago Operations Center')
ON DUPLICATE KEY UPDATE `email` = `email`;
