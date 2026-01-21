-- Samarth App - MySQL Initialization
-- Optimized for 1000+ users

-- Create database with proper charset
CREATE DATABASE IF NOT EXISTS samarth CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create user and grant privileges
CREATE USER IF NOT EXISTS 'samarth'@'%' IDENTIFIED BY 'samarth_pass';
GRANT ALL PRIVILEGES ON samarth.* TO 'samarth'@'%';
FLUSH PRIVILEGES;

-- Set default charset for all future tables
SET default_storage_engine = INNODB;
SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

