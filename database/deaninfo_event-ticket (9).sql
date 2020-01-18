-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 12, 2019 at 02:38 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `deaninfo_event-ticket`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `username`, `password`, `status`) VALUES
(1, 'Super Admin', 'admin@gmail.com', '1234', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cartitems`
--

CREATE TABLE `cartitems` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `ticket_type` varchar(191) NOT NULL,
  `coupon_id` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cartitems`
--

INSERT INTO `cartitems` (`id`, `user_id`, `ticket_id`, `quantity`, `price`, `ticket_type`, `coupon_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(7, 9, 38, 1, '300', 'vip', NULL, '2019-06-10 17:51:02', '2019-06-10 18:27:47', '0000-00-00 00:00:00'),
(10, 9, 36, 1, '300', 'paid', NULL, '2019-06-10 18:27:35', '2019-06-10 18:27:35', NULL),
(11, 15, 37, 1, '300', 'vip', NULL, '2019-06-11 14:06:05', '2019-06-11 14:06:44', NULL),
(12, 15, 38, 1, '300', 'vip', NULL, '2019-06-11 14:06:24', '2019-06-11 14:06:24', NULL),
(13, 15, 5, 4, '400', 'paid', NULL, '2019-06-11 14:06:34', '2019-06-11 14:06:34', NULL),
(14, 15, 36, 3, '675', 'paid', '4', '2019-06-11 14:07:41', '2019-06-11 16:28:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cms_pages`
--

CREATE TABLE `cms_pages` (
  `id` int(11) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_description` text NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `delete_at` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `page_keyword` varchar(255) NOT NULL,
  `seo_description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_pages`
--

INSERT INTO `cms_pages` (`id`, `page_title`, `page_description`, `created_at`, `updated_at`, `delete_at`, `title`, `page_keyword`, `seo_description`) VALUES
(1, 'About Us', '<p>Test Description of page</p>', 1552568798, 1554109694, NULL, 'About Us', 'About Us page keyword', 'Test Description'),
(2, 'FAQ\'s', '<p>Test Description</p>', 1554108341, NULL, NULL, 'FAQ\'s', 'FAQ\'s', ''),
(3, 'Privacy & Policy', '<p>Test Description of privacy and policy</p>', 1554108451, NULL, NULL, 'Privacy & Policy', 'Privacy And Policy', ''),
(4, 'Terms  & Conditions`', '<p>Test terms and Description page<strong>s</strong></p>', 1554108554, NULL, NULL, 'Terms & Conditions', 'Terms And Condition', ''),
(5, 'How It Works', '<p>Test How it works</p>', 1554108650, NULL, NULL, 'How It Works', 'How It works', '');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `event_id` int(11) NOT NULL,
  `organizer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `first_name`, `last_name`, `email`, `created_at`, `updated_at`, `event_id`, `organizer_id`) VALUES
(6, 'John', 'Doe', 'loveneet@gmail.com1', '2019-07-12 09:00:07', '2019-07-12 09:01:23', 62, 7),
(7, 'Vikas', 'G', 'vikas@gmail.com', '2019-07-12 08:39:35', '2019-07-11 13:20:24', 62, 7),
(9, 'Akki', 'Ninja', 'akki@gmail.com', '2019-07-12 08:39:57', '2019-07-11 13:20:40', 61, 7),
(11, 'Jordan', 'J', 'jordan@gmail.com', '2019-07-12 08:40:00', '2019-07-11 13:21:00', 61, 7),
(12, 'Rishikesh', 'Singh', 'rishikeshdean@gmail.com', '2019-07-12 08:40:03', '2019-04-05 16:32:13', 61, 7),
(25, 'test', 'test_last', 'test@gmail.com', '2019-04-08 17:16:41', NULL, 9, 2),
(26, 'test', 'test_last', 'test@gmail.com', '2019-04-08 17:16:41', NULL, 9, 2),
(27, 'test', 'test_last', 'test@gmail.com', '2019-04-08 17:16:41', NULL, 9, 2),
(28, 'test', 'test_last', 'test@gmail.com', '2019-04-08 17:16:41', NULL, 9, 2),
(29, 'test', 'test_last', 'test@gmail.com', '2019-04-08 17:16:54', NULL, 8, 2),
(30, 'test', 'test_last', 'test@gmail.com', '2019-04-08 17:16:54', NULL, 8, 2),
(31, 'test', 'test_last', 'test@gmail.com', '2019-04-08 17:16:54', NULL, 8, 2),
(32, 'test', 'test_last', 'test@gmail.com', '2019-04-08 17:16:54', NULL, 8, 2),
(33, 'test', 'test_last', 'test@gmail.com', '2019-05-10 07:32:11', NULL, 20, 20),
(34, 'test', 'test_last', 'test@gmail.com', '2019-05-10 07:32:11', NULL, 20, 20),
(35, 'test', 'test_last', 'test@gmail.com', '2019-05-10 07:32:11', NULL, 20, 20),
(36, 'test', 'test_last', 'test@gmail.com', '2019-05-10 07:32:11', NULL, 20, 20),
(37, 'test', 'test_last', 'test@gmail.com', '2019-05-10 07:33:26', NULL, 20, 20),
(38, 'test', 'test_last', 'test@gmail.com', '2019-05-10 07:33:26', NULL, 20, 20),
(39, 'dean', 'test_last', 'test@gmail.com', '2019-05-10 13:33:08', NULL, 20, 20),
(40, 'Rishikesh', 'test_last', 'test@gmail.com', '2019-05-13 06:29:36', NULL, 20, 20),
(42, 'test', 'test_last', 'test@gmail.com', '2019-05-10 09:13:14', NULL, 20, 20),
(43, 'test', 'test_last', 'test@gmail.com', '2019-05-10 09:13:14', NULL, 20, 20),
(44, 'test', 'test_last', 'rishikeshdean@gmail.com', '2019-05-13 09:47:15', NULL, 20, 20),
(45, 'Dean', 'test_last', 'atest@gmail.com', '2019-06-26 10:23:58', NULL, 6, 35),
(46, 'Dean Infotech', 'test_last', 'test@gmail.com', '2019-06-26 10:23:58', NULL, 6, 35),
(47, 'test', 'test_last', 'test@gmail.com', '2019-06-26 10:23:58', NULL, 6, 35),
(48, 'test', 'test_last', 'test@gmail.com', '2019-06-26 10:23:58', NULL, 6, 35),
(51, 'Akki', 'Ninja', 'akki@gmail.com1', '2019-07-24 10:35:29', '2019-07-24 12:59:19', 60, 9),
(52, 'Jordan', 'J', 'jordan@gmail.com1', '2019-07-24 10:35:29', NULL, 60, 9),
(53, 'Rishikesh', 'Singh', 'rishikeshdean@gmail.com1', '2019-07-24 10:35:29', NULL, 60, 9),
(54, 'John', 'Doe', 'loveneet@gmail.com1', '2019-07-24 11:20:09', NULL, 60, 9),
(55, 'Vikas', 'G', 'vikas@gmail.com1', '2019-07-24 11:20:09', NULL, 60, 9),
(56, 'Akki', 'Ninja', 'akki@gmail.com1', '2019-07-24 11:20:09', NULL, 60, 9),
(57, 'Jordan', 'J', 'jordan@gmail.com1', '2019-07-24 11:20:09', NULL, 60, 9),
(58, 'Rishikesh', 'Singh', 'rishikeshdean@gmail.com1', '2019-07-24 11:20:09', NULL, 60, 9),
(59, 'John', 'Doe', 'loveneet@gmail.com1', '2019-07-24 11:21:24', NULL, 60, 9),
(60, 'Vikas', 'G', 'vikas@gmail.com1', '2019-07-24 11:21:24', NULL, 60, 9),
(61, 'Akki', 'Ninja', 'akki@gmail.com321', '2019-07-24 11:21:24', '2019-07-24 12:59:51', 60, 9),
(62, 'Jordan', 'J', 'jordan@gmail.com1', '2019-07-24 11:21:24', NULL, 60, 9),
(63, 'Rishikesh', 'Singh', 'rishikeshdean@gmail.com1', '2019-07-24 11:21:24', NULL, 60, 9);

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE `coupon` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `coupon` varchar(250) NOT NULL,
  `description` text,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `total_available` int(11) DEFAULT NULL,
  `redeem_on` int(11) DEFAULT NULL,
  `amount` float(10,2) NOT NULL,
  `type` enum('%','amt') NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coupon`
--

INSERT INTO `coupon` (`id`, `user_id`, `coupon`, `description`, `start_date`, `end_date`, `start_time`, `end_time`, `total_available`, `redeem_on`, `amount`, `type`, `status`, `updated_at`) VALUES
(5, 7, 'BUY20', '20 percent discount', '2019-01-01', '2020-01-01', '01:00:00', '01:00:00', NULL, 61, 20.00, '%', 1, '2019-07-17 09:44:23'),
(6, 7, 'OFF20', '20 bucks off', '2019-01-01', '2020-01-01', '01:00:00', '13:00:00', 20, 49, 20.00, 'amt', 1, '2019-07-03 12:27:17'),
(7, 7, 'BUYY20', '20 percent off', '2019-01-01', '2020-01-01', '01:00:00', '01:00:00', NULL, 49, 20.00, '%', 1, '2019-07-03 12:49:08'),
(8, 7, 'Testing Coupon', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', '2019-07-21', '2019-07-25', '00:30:00', '00:30:00', NULL, 53, 1200.00, 'amt', 1, '2019-07-19 12:17:36'),
(9, 7, 'Testing Coupon 2', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', '2019-08-21', '2019-08-24', '00:45:00', '00:45:00', NULL, 53, 1324.00, 'amt', 1, '2019-07-19 12:20:33'),
(10, 7, 'Testing Coupon 3', 'slfjlsjflksjf', '2019-07-24', '2019-07-26', '00:00:00', '00:15:00', NULL, 53, 3213.00, 'amt', 1, '2019-07-19 12:49:18'),
(11, 7, 'asdfasfd', 'fasdfasf', '2019-07-23', '2019-07-24', '00:30:00', '00:15:00', NULL, 53, 234.00, 'amt', 1, '2019-07-19 12:53:44'),
(12, 7, 'asdfasfasdfasf', 'asdfasf', '2019-07-29', '2019-07-31', '00:15:00', '00:45:00', NULL, 53, 234.00, 'amt', 1, '2019-07-19 12:54:21'),
(13, 7, 'afsdasfasf', 'asdfasf', '2019-07-22', '2019-07-27', '00:30:00', '00:30:00', 2, 54, 234.00, 'amt', 1, '2019-07-19 12:57:23'),
(14, 7, 'ufhgjhfjhfj', 'mnvmnvv', '2019-07-21', '2019-07-31', '00:30:00', '00:15:00', NULL, 49, 31.00, 'amt', 1, '2019-07-19 12:59:57'),
(15, 7, 'jhjggjhvj', 'jkhgjhvjhv', '2019-07-22', '2019-07-24', '00:30:00', '00:15:00', NULL, 49, 6876.00, 'amt', 1, '2019-07-19 13:01:46'),
(16, 7, 'jhgjygjhgjhg', 'khkjglhbjhm', '2019-07-24', '2019-07-27', '00:30:00', '01:00:00', NULL, 49, 21654652.00, 'amt', 1, '2019-07-19 13:02:29'),
(17, 7, 'jgjgjgj', 'iggkufgvk', '2019-07-22', '2019-07-31', '00:30:00', '00:30:00', NULL, 49, 32134.00, 'amt', 1, '2019-07-19 13:04:06'),
(18, 7, 'dfasf', 'asdfasf', '2019-07-24', '2019-07-27', '00:45:00', '00:30:00', NULL, 49, 234.00, 'amt', 1, '2019-07-19 13:09:43'),
(19, 9, 'FOOD50', NULL, '2019-07-25', '2019-08-17', '00:45:00', '00:30:00', NULL, 60, 100.00, '%', 1, '2019-07-24 09:14:35'),
(21, 9, 'DELHI60', '60 percent off on selected events.', '2019-07-24', '2019-08-15', '00:30:00', '01:00:00', 10, 60, 60.00, '%', 0, '2019-07-24 09:16:56');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `organizer_id` int(11) NOT NULL,
  `event_title` varchar(255) NOT NULL,
  `event_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `event_description` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `event_url` varchar(255) NOT NULL,
  `event_tags` varchar(255) DEFAULT NULL,
  `event_location` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `address_2` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `start_time` time NOT NULL,
  `end_date` date DEFAULT NULL,
  `end_time` time NOT NULL,
  `event_recurring` tinyint(1) DEFAULT NULL COMMENT '0=Free,1=Paid,2=Donation',
  `is_recurring` tinyint(1) DEFAULT NULL,
  `event_occurrence_type` varchar(255) DEFAULT NULL,
  `occurrence_start_time` time DEFAULT NULL,
  `occurrence_end_time` time DEFAULT NULL,
  `occurrence_off_the_day` text,
  `occurrence_from_date` date DEFAULT NULL,
  `occurence_to_date` date DEFAULT NULL,
  `show_no_of_available_tickets` tinyint(4) DEFAULT NULL,
  `refund_policy` int(11) DEFAULT NULL COMMENT '1=no refund 2=A day before 3=A week before',
  `ticket_fees` int(1) DEFAULT NULL COMMENT '1:charge attendee 2:charge organizer',
  `parking` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=Yes 0=No',
  `wheelchair` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=Yes 0=No',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `is_private` tinyint(4) NOT NULL DEFAULT '0',
  `other_information` varchar(255) DEFAULT NULL,
  `aditional_information` varchar(40) DEFAULT NULL COMMENT '1=Alcohol , 2= ID card , 3=Children , 4=18+ , 5=Parking , 6=Wheelchair , 7=Casual , 8=Corporate Dressing , 9=Early Check-in',
  `cityLat` decimal(11,8) DEFAULT NULL,
  `cityLng` decimal(11,8) DEFAULT NULL,
  `event_status` tinyint(1) DEFAULT NULL COMMENT '1=active 0=inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `organizer_id`, `event_title`, `event_date`, `event_description`, `category_id`, `subcategory_id`, `event_url`, `event_tags`, `event_location`, `address`, `address_2`, `start_date`, `start_time`, `end_date`, `end_time`, `event_recurring`, `is_recurring`, `event_occurrence_type`, `occurrence_start_time`, `occurrence_end_time`, `occurrence_off_the_day`, `occurrence_from_date`, `occurence_to_date`, `show_no_of_available_tickets`, `refund_policy`, `ticket_fees`, `parking`, `wheelchair`, `created_at`, `updated_at`, `deleted_at`, `is_delete`, `is_private`, `other_information`, `aditional_information`, `cityLat`, `cityLng`, `event_status`) VALUES
(49, 7, 'Testing Event', '2019-08-12 10:51:42', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.', 1, 2, 'medtech-regulatory-awards', NULL, 'United States', 'United States', 'New Delhi India', '2019-08-24', '22:20:00', '2020-01-01', '01:01:00', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0, '2019-07-02 08:22:12', '2019-07-11 09:26:59', NULL, 0, 1, 'Testing other information for events', '1,4,5', NULL, NULL, 1),
(52, 7, 'testing', '2019-08-12 11:12:00', 'testing event', 2, NULL, 'testevent', NULL, 'United States', 'test', 'test', '2019-08-26', '01:00:00', '2019-01-01', '01:00:00', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, 1, 0, 0, '2019-07-02 08:45:04', '2019-07-16 05:19:03', NULL, 0, 0, 'test', '3', NULL, NULL, 1),
(53, 7, 'This is event Name', '2019-08-12 11:12:42', 'test description', 1, 2, 'website', NULL, 'United States', 'testing', 'testing', '2019-08-15', '01:00:00', '2020-01-01', '13:00:00', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 1, 0, 0, '2019-07-04 09:36:50', '2019-07-17 13:00:25', NULL, 0, 1, 'other info', '3', NULL, NULL, 1),
(54, 7, 'testing event1234', '2019-08-12 11:11:54', 'description', 1, 2, 'eventtesting', NULL, 'United States', 'delhi', 'delhi', '2019-08-12', '01:00:00', '2020-01-01', '13:00:00', 0, 1, 'Daily', '03:00:00', '01:00:00', '0', '2019-01-01', '2020-01-01', 1, 1, 1, 0, 0, '2019-07-05 06:38:34', '2019-07-11 06:31:57', NULL, 0, 1, 'other', '4,2,1', NULL, NULL, 1),
(55, 7, 'testing event234', '2019-08-12 11:12:46', 'asdfasf', 1, 2, 'testing', NULL, 'United States', 'test', 'test', '2019-08-22', '02:00:00', '2020-01-01', '01:00:00', 0, 1, 'Once In A Week', '01:00:00', '02:00:00', '0', '2019-01-01', '2020-01-01', 1, 2, 1, 0, 0, '2019-07-05 06:53:05', '2019-07-11 09:21:19', '2019-07-11 09:21:19', 0, 1, 'asdf', '1,2', NULL, NULL, 0),
(56, 7, 'jgjg', '2019-08-12 11:12:50', 'sdfasf', 1, 2, 'jhgj', NULL, 'United States', 'kjbmnbmg', 'bmjhjkh', '2019-08-23', '01:00:00', '2019-01-01', '01:00:00', NULL, 1, 'Daily', '01:00:00', '01:00:00', '0', '2019-01-02', '2019-01-01', 1, 3, 1, 0, 0, '2019-07-05 11:37:17', '2019-07-11 09:25:37', '2019-07-11 09:25:37', 0, 0, '234sdf', '2,4,5,8', NULL, NULL, 0),
(57, 7, 'asdfasf', '2019-08-12 11:12:54', 'fasfd', 3, NULL, 'asfasf', NULL, 'United States', 'asdfasf', 'asdfasf', '2019-08-14', '01:00:00', '2019-01-01', '01:00:00', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0, '2019-07-05 11:51:15', NULL, NULL, 0, 0, 'w23fasdf', '2,3', NULL, NULL, 1),
(58, 7, 'asdfasfasdfasf', '2019-08-12 11:12:57', 'asdfasf', 1, 2, 'wflkj', NULL, 'Canada', 'asdf', 'asdf', '2019-08-31', '01:00:00', '2019-01-01', '01:00:00', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, 1, 0, 0, '2019-07-05 11:53:53', '2019-07-17 13:01:57', NULL, 0, 1, 'asdfasf', '3,2', NULL, NULL, 1),
(59, 7, 'afdasf', '2019-08-12 11:13:00', 'sfdasf', 1, 2, 'www-sdlfkj-slkdfj', NULL, 'Canada', 'asdfsfa', 'asfdadf', '2019-08-28', '01:00:00', '2019-01-01', '01:01:00', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, 1, 0, 0, '2019-07-05 11:59:51', NULL, NULL, 0, 0, 'asdf', '2,3', NULL, NULL, 1),
(60, 9, 'Eminem in Delhi', '2019-08-12 11:11:24', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.', 1, 2, 'www-dfldf-df', NULL, 'Canada', 'asdf', 'asdf', '2019-09-20', '13:55:00', '2019-09-23', '07:56:00', 0, 1, 'Once In A Week', '07:56:00', '07:56:00', '1', '2019-07-16', '2019-07-31', 1, 1, 1, 1, 0, '2019-07-05 13:26:35', '2019-07-25 13:16:25', NULL, 0, 1, 'jhkjh', '1,2,4', NULL, NULL, 1),
(61, 7, 'all selected', '2019-08-12 11:13:09', 'Thanos is coming', 1, 2, 'website-dssd', NULL, 'Canada', 'nowhere', 'nowhere', '2019-08-15', '13:00:00', '2020-01-01', '01:00:00', 0, 1, 'Daily', '01:00:00', '01:00:00', '0', '2019-01-01', '2020-01-01', 1, 2, 1, 0, 0, '2019-07-10 06:50:51', '2019-07-17 13:07:44', NULL, 0, 1, 'Stranger Things', '1,2,3,9,5,6', NULL, NULL, 0),
(62, 7, 'asdfasffasdfasdf', '2019-08-12 11:11:18', 'asdfasdf', 1, 2, 'sdfsdf3afdf', NULL, 'Canada', 'sf', 'asdf', '2019-01-01', '01:00:00', '2020-01-01', '01:00:00', 0, 1, 'Daily', '01:00:00', '01:00:00', '0', '2019-01-02', '2019-01-01', 1, 2, 1, 0, 0, '2019-07-10 08:30:15', '2019-07-17 13:07:32', NULL, 0, 1, 'sadfasdfas', '3,2,5,8', NULL, NULL, 0),
(63, 9, 'title of this event', '2019-08-09 11:51:25', 'asdfasdf', 5, NULL, 'title-of-this-event', NULL, 'United States', 'asdfasdf', 'asdf', '2019-08-14', '00:45:00', '2019-08-30', '00:30:00', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 0, 0, '2019-08-09 11:51:25', NULL, NULL, 0, 0, 'fsdfsdf', '1,2,3', NULL, NULL, 1),
(64, 9, 'asdfwerwe', '2019-08-09 11:53:43', 'asdfasdf', 2, NULL, 'asdfwerwe', NULL, 'United States', 'asdf', 'asdf', '2019-08-13', '00:15:00', '2019-08-20', '01:00:00', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 0, 0, '2019-08-09 11:53:43', NULL, NULL, 0, 0, 'fasdf', '2', NULL, NULL, 1),
(65, 9, 'asdf asfda', '2019-08-09 11:55:25', 'asdfasdf', 2, NULL, 'asdf-asfda', NULL, 'Canada', 'adf', 'asdf', '2019-08-12', '00:45:00', '2019-08-29', '00:45:00', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 0, 0, '2019-08-09 11:55:25', NULL, NULL, 0, 0, 'sdf3sadf', '2', NULL, NULL, 1),
(66, 9, 'fasdfasf fa df', '2019-08-09 11:56:41', 'asdf', 3, NULL, 'fasdfasf-fa-df', NULL, 'United States', 'asdfasdf', 'asdffasd', '2019-08-13', '00:30:00', '2019-08-31', '00:45:00', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 0, 0, '2019-08-09 11:56:41', NULL, NULL, 0, 0, 'fasdf', '1,2', NULL, NULL, 0),
(67, 9, 'lksfjiel fjlkwj i', '2019-08-09 11:58:23', 'asdf', 3, NULL, 'lksfjiel-fjlkwj-i', NULL, 'United States', '2342af', 'afd', '2019-08-13', '00:15:00', '2019-08-19', '00:45:00', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 0, 0, '2019-08-09 11:58:23', NULL, NULL, 0, 0, 'fsdf', '2,3', NULL, NULL, 1),
(68, 9, 'fasdf', '2019-08-09 12:01:09', 'fasdf', 2, NULL, 'fasdf', NULL, 'Nigeria', 'asdf', 'asdf', '2019-08-20', '00:30:00', '2019-08-24', '00:15:00', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 0, 0, '2019-08-09 12:01:09', NULL, NULL, 0, 0, 'asdf', '2', NULL, NULL, 1),
(69, 9, 'fasf', '2019-08-09 12:04:58', 'fasdf', 1, 3, 'fasf', NULL, 'Canada', 'asdf', 'asdf', '2019-08-12', '00:30:00', '2019-08-30', '01:00:00', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 0, 0, '2019-08-09 12:04:58', NULL, NULL, 0, 0, 'asdf', '2', NULL, NULL, 1),
(70, 9, 'sljfljksf', '2019-08-09 12:05:58', 'asdfasf', 1, 2, 'sfjlklj', NULL, 'United States', '234', '234', '2019-08-20', '00:30:00', '2019-08-23', '00:15:00', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 0, 0, '2019-08-09 12:05:58', NULL, NULL, 0, 0, 'asdf', '2', NULL, NULL, 1),
(71, 9, 'fafasdf', '2019-08-09 12:07:00', 'asdf', 3, NULL, 'fafasdf', NULL, 'Canada', 'fasdf', 'asdf', '2019-08-14', '00:45:00', '2019-08-21', '00:45:00', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 0, 0, '2019-08-09 12:07:00', NULL, NULL, 0, 0, 'fasdf', NULL, NULL, NULL, 0),
(72, 9, 'sfasdf', '2019-08-09 12:08:41', 'asdfasdf', 1, 3, 'sfasdf', NULL, 'Canada', 'fasdf', 'asdf', '2019-08-14', '00:30:00', '2019-08-22', '00:15:00', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 0, 0, '2019-08-09 12:08:41', NULL, NULL, 0, 0, 'asdf', '3', NULL, NULL, 0),
(73, 9, 'fadf', '2019-08-09 12:11:31', 'fasdf', 2, NULL, 'fadf', NULL, 'United States', 'sdfs, sfa', 'sfa', '2019-08-14', '00:30:00', '2019-08-23', '00:15:00', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 0, 0, '2019-08-09 12:11:31', NULL, NULL, 0, 0, '324', NULL, NULL, NULL, 0),
(74, 9, 'asdfafd fasd fa sdf as f', '2019-08-09 12:14:57', 'asdfadf', 2, NULL, 'asdfafd-fasd-fa-sdf-as-f', NULL, 'United States', 'sdfs, sfa', 'sfa', '2019-08-13', '00:45:00', '2019-08-21', '00:45:00', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 0, 0, '2019-08-09 12:14:57', NULL, NULL, 0, 0, 'adf', NULL, NULL, NULL, 0),
(75, 9, 'asdfasdf', '2019-08-09 12:18:03', 'asdf', 3, NULL, 'asdfasdf', NULL, 'Canada', 'sdfs, sfa', 'sfa', '2019-08-15', '00:00:00', '2019-08-28', '00:45:00', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 0, 0, '2019-08-09 12:18:03', NULL, NULL, 0, 0, 'asdf', NULL, NULL, NULL, 0),
(76, 9, 'asdfwewrq', '2019-08-09 12:33:22', 'aasdf', 2, NULL, 'asdfasdfsdf', NULL, 'United Kingdom', 'sdfs, sfa', 'sfa', '2019-08-20', '00:15:00', '2019-08-24', '00:30:00', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 0, 0, '2019-08-09 12:33:22', NULL, NULL, 0, 0, 'asdf', NULL, NULL, NULL, 0),
(77, 9, 'Enrique in New York', '2019-08-12 11:17:57', '<p>Suspendisse maximus semper lacinia. Pellentesque pulvinar ligula turpis, eget cursus ex malesuada a. Sed vitae nibh vel ante ultricies viverra et sit amet metus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Cras blandit vestibulum quam, ac tincidunt ligula congue vitae. Maecenas nec metus sed nisl tincidunt vestibulum. Maecenas id feugiat ex. Nam pulvinar est sit amet maximus viverra. Nullam accumsan, lacus et efficitur mollis, metus erat finibus eros, eu vulputate massa arcu sagittis orci. Nunc bibendum malesuada ornare. <s><em><strong>Praesent consequat, lacus et gravida ultrices, libero metus tincidunt velit, et elementum enim justo a justo</strong></em></s>. Integer imperdiet lectus sit amet congue semper. Proin at urna laoreet velit feugiat congue. Curabitur tempus fringilla quam, in aliquet nibh finibus egestas. Proin convallis sem sit amet turpis suscipit, at pharetra metus egestas.&nbsp;</p>\n\n<ol>\n	<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>\n	<li>Mauris ac aliquam urna, sed sollicitudin massa.</li>\n</ol>\n\n<p>Suspendisse rutrum luctus tellus, sed varius purus rhoncus a. Nullam consectetur enim non finibus interdum. Vestibulum ut lorem metus. Sed tincidunt maximus egestas. Integer lectus risus, imperdiet id aliquam dignissim, ultricies quis tortor. Integer congue ante a volutpat ornare. Donec eget nisi libero. Donec fermentum non purus non hendrerit. Cras euismod nec elit a lobortis. Morbi imperdiet non lacus sit amet congue. Aenean ac condimentum felis, vel venenatis leo.</p>\n\n<blockquote>\n<p>Phasellus consequat facilisis odio.</p>\n</blockquote>\n\n<p>Vestibulum ac nisl vel enim dapibus pretium. Cras vitae libero ac augue molestie rhoncus. Fusce efficitur euismod nulla quis iaculis. Donec congue purus sed mattis imperdiet. Fusce ornare felis quam, sed molestie purus dignissim at. Nunc gravida dictum aliquet. Cras malesuada quam ante. Integer fringilla id nibh ut sagittis. Praesent et sem lacus. Nullam mattis dui ac urna fringilla ultricies.</p>\n\n<p>Nullam at dui metus. Aenean vulputate dui sit amet ante vestibulum, eget tincidunt nisl gravida. Aenean ex risus, semper vestibulum velit ut, porttitor ornare eros. Nam ultrices dignissim sapien ac rutrum. Etiam quis tortor lectus. In in diam eget diam elementum commodo. Nam dictum egestas magna quis dignissim. Duis congue vestibulum convallis. Suspendisse potenti. Aliquam erat volutpat. In auctor in dolor vel ultrices.</p>\n\n<p><strong>Vivamus vestibulum urna sed vulputate aliquet. Praesent fermentum mattis mi, non scelerisque nulla tempor et. Curabitur augue dolor, efficitur at sagittis id, semper at lectus. Cras accumsan vulputate magna, ut aliquam nulla condimentum dignissim. Cras nec justo efficitur orci venenatis hendrerit. Morbi porttitor nec lectus ac sollicitudin. Nam commodo sodales magna, at eleifend tortor luctus in. Proin mauris dui, laoreet et volutpat quis, aliquet porta tellus.</strong></p>', 2, NULL, 'enrique-in-new-york', NULL, 'United States', 'New York', 'Near somewhere', '2019-08-15', '22:00:00', '2019-08-15', '01:15:00', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0, '2019-08-12 06:37:40', '2019-08-12 07:27:33', NULL, 0, 0, 'Please come 30 minutes before the event starts', '2', NULL, NULL, 1),
(78, 9, 'Rihana Coming to New York', '2019-08-12 11:18:01', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam augue nisi, rhoncus in mauris a, aliquam tincidunt elit. Aenean ut maximus ligula. Mauris vel mauris suscipit, pulvinar diam a, tempor augue. Quisque eget diam ipsum. Pellentesque ornare ipsum at mauris rhoncus, a hendrerit massa pharetra. Cras urna ipsum, hendrerit eu sapien quis, mollis viverra neque. Ut ornare pretium dui. In viverra felis in pharetra blandit. Nam facilisis est sit amet egestas elementum. Nunc sit amet magna tempus, viverra turpis non, accumsan eros. Fusce ut ullamcorper massa. Suspendisse tristique velit quis turpis semper tempor. Nulla non interdum nulla.</p>\n\n<p>Integer quis libero mi. Aliquam semper sem ac tellus elementum, vel euismod massa placerat. Sed felis risus, vulputate eget ligula et, vestibulum imperdiet enim. Sed et velit imperdiet, ullamcorper velit id, tempor diam. Suspendisse eget orci vel diam rutrum blandit in id felis. Donec condimentum ut nulla nec congue. Cras nec justo bibendum, ornare metus vitae, eleifend nibh. Donec tempor lorem eget mattis blandit. Aenean pulvinar, mi in elementum fermentum, sem eros efficitur purus, quis bibendum dui tortor vitae augue. Phasellus dictum, arcu ut porttitor scelerisque, libero nibh vulputate est, nec vulputate nunc tortor dapibus diam. Quisque ac nunc sit amet libero tempor mattis eu posuere ligula.</p>', 1, 2, 'rihana-coming-to-new-york', NULL, 'United States', 'New York', '123', '2019-08-13', '00:45:00', '2019-08-15', '01:00:00', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0, '2019-08-12 06:48:36', '2019-08-12 08:32:43', NULL, 0, 0, 'Do not bring bags.', '2,3,4', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `event_attendee`
--

CREATE TABLE `event_attendee` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `amount` varchar(250) NOT NULL,
  `ticket_type` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_attendee`
--

INSERT INTO `event_attendee` (`id`, `first_name`, `last_name`, `amount`, `ticket_type`, `quantity`, `email`, `payment_type`, `event_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'fasdf', 'asf', '123', 'VIP', 3, 'asdf@sdf.sdf', 'Bank Deposit', 53, 7, '2019-07-17 18:30:00', NULL),
(2, 'fasdf', 'asf', '123', 'VIP', 3, 'asdf@sdf.sdf', 'Bank Deposit', 53, 7, '2019-07-07 20:41:18', NULL),
(3, 'fasdf', 'asf', '123', 'VIP', 3, 'asdf@sdf.sdf', 'Bank Deposit', 53, 7, '2019-07-02 08:12:29', NULL),
(4, 'asdfasf', 'asdfasf', '200', 'General Admission', 2, 'fasf@asldfj.sdlf', 'Credit/Debit Card', 53, 7, '2019-07-18 12:53:10', '2019-07-18 12:53:10'),
(5, 'asdf', 'asdf', '234', 'V.VIP', 2, 'asdf@asdf.sdf', 'Cash Payment', 53, 7, '2019-07-18 12:54:21', '2019-07-18 12:54:21'),
(6, 'dsfa', 'asdf', '234', 'V.VIP', 2, 'asd@sf.df', 'Credit/Debit Card', 54, 7, '2019-07-18 13:49:56', '2019-07-18 13:49:56'),
(7, 'testing', 'testing', '20', 'General Admission', 2, 'testing@email.com', 'Cash Payment', 60, 9, '2019-07-24 09:51:05', '2019-07-24 09:51:05');

-- --------------------------------------------------------

--
-- Table structure for table `event_category`
--

CREATE TABLE `event_category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_category`
--

INSERT INTO `event_category` (`id`, `category_name`, `category_description`, `created_at`, `updated_at`, `is_delete`, `deleted_at`) VALUES
(1, 'Test category4', 'About category', '2019-02-27 11:06:32', '2019-04-01 10:43:20', 0, NULL),
(2, 'This is test category', 'Category Description', '2019-02-28 07:29:41', '2019-04-01 10:43:34', 0, NULL),
(3, 'test category', 'Description', '2019-03-06 07:40:41', '2019-04-01 10:43:47', 0, NULL),
(5, 'Party', '', '2019-03-07 01:33:52', NULL, 0, NULL),
(8, 'test category march', '', '2019-03-28 09:10:09', '2019-03-28 09:10:48', 0, NULL),
(9, 'test category', 'asdasd', '2019-04-01 10:34:50', NULL, 0, NULL),
(10, 'Church', NULL, '2019-04-07 09:33:04', NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `event_mages`
--

CREATE TABLE `event_mages` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `image_name` varchar(233) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_mages`
--

INSERT INTO `event_mages` (`id`, `event_id`, `image_name`) VALUES
(69, 50, 'event_image01562055958.jpg'),
(71, 52, 'event_image01562057104.png'),
(72, 53, 'event_image01562233010.png'),
(75, 55, 'event_image01562309585.png'),
(76, 55, 'event_image11562309585.jpg'),
(77, 56, 'event_image01562326637.png'),
(78, 57, 'event_image01562327475.png'),
(79, 58, 'event_image01562327633.jpg'),
(80, 59, 'event_image01562327991.png'),
(89, 54, 'event_image01562822809.jpg'),
(94, 61, 'event_image01562827655.jpg'),
(95, 61, 'event_image11562827655.jpg'),
(108, 62, 'event_image01562833175.jpg'),
(109, 49, 'event_image01562837219.jpg'),
(110, 60, 'event_image01564985158.png'),
(111, 60, 'event_image11564985158.jpg'),
(112, 60, 'event_image21564985158.jpg'),
(113, 63, 'event_image01565351485.jpg'),
(114, 63, 'event_image11565351485.jpeg'),
(115, 63, 'event_image21565351485.jpg'),
(116, 64, 'event_image01565351623.jpg'),
(117, 64, 'event_image11565351623.jpeg'),
(118, 64, 'event_image21565351623.jpg'),
(119, 65, 'event_image01565351725.jpg'),
(120, 65, 'event_image11565351725.jpeg'),
(121, 65, 'event_image21565351725.jpg'),
(122, 66, 'event_image01565351801.png'),
(123, 66, 'event_image11565351801.jpg'),
(124, 66, 'event_image21565351801.jpeg'),
(125, 67, 'event_image01565351903.jpg'),
(126, 68, 'event_image01565352069.jpg'),
(127, 69, 'event_image01565352298.jpg'),
(128, 70, 'event_image01565352358.jpg'),
(129, 71, 'event_image01565352420.jpg'),
(130, 72, 'event_image01565352521.jpg'),
(131, 73, 'event_image01565352691.jpg'),
(132, 74, 'event_image01565352897.jpeg'),
(133, 75, 'event_image01565353083.jpeg'),
(134, 76, 'event_image01565354002.jpg'),
(135, 77, 'event_image01565591860.jpg'),
(136, 78, 'event_image01565592516.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `event_plans`
--

CREATE TABLE `event_plans` (
  `id` int(11) NOT NULL,
  `plan_title` varchar(255) NOT NULL,
  `plan_price` varchar(255) NOT NULL,
  `plan_expiry_date` int(11) NOT NULL,
  `plan_description` varchar(255) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_plans`
--

INSERT INTO `event_plans` (`id`, `plan_title`, `plan_price`, `plan_expiry_date`, `plan_description`, `created_at`, `updated_at`) VALUES
(4, 'page 123', '500', 1602374400, 'description of plan....123', 1553595777, 1553595873),
(7, 'sneha', '11', 1492281344, 'testting', 1553769282, NULL),
(8, 'iBuytix Extra', '2% + $0.79', 1576108800, 'Sub1', 1554177931, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `event_subcategory`
--

CREATE TABLE `event_subcategory` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_name` varchar(22) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_subcategory`
--

INSERT INTO `event_subcategory` (`id`, `category_id`, `subcategory_name`, `created_at`, `updated_at`, `deleted_at`, `is_delete`) VALUES
(2, 1, 'sucategory1', '2019-03-11 12:51:30', '2019-03-27 01:09:22', NULL, 0),
(3, 1, 'Test 3', '2019-03-27 01:01:32', '2019-03-27 01:03:00', NULL, 0),
(5, 1, 'Partyyyy', '2019-03-28 11:50:44', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `event_ticket`
--

CREATE TABLE `event_ticket` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `ticket_type` varchar(255) DEFAULT NULL,
  `quantity` int(225) DEFAULT NULL,
  `event_type` tinyint(4) NOT NULL COMMENT '1.Free 2. Paid 3. Donate',
  `price` varchar(255) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_ticket`
--

INSERT INTO `event_ticket` (`id`, `event_id`, `ticket_type`, `quantity`, `event_type`, `price`, `description`, `created_at`, `updated_at`) VALUES
(51, 50, 'PAID', 200, 2, '200', NULL, NULL, NULL),
(53, 52, 'RSVP', 32, 1, '0', NULL, NULL, NULL),
(54, 52, 'PAID', 200, 2, '323', NULL, NULL, NULL),
(58, 56, 'PAID', 234, 1, '234', NULL, NULL, NULL),
(59, 56, 'PAID', 234, 2, '234', NULL, NULL, NULL),
(60, 56, 'PAID', 234, 3, '234', NULL, NULL, NULL),
(61, 57, 'RSVP', 23, 2, '100', NULL, NULL, NULL),
(63, 59, 'RSVP', 234, 2, '100', NULL, NULL, NULL),
(93, 54, 'RSVP', 2000, 1, '0', NULL, NULL, NULL),
(149, 55, 'RSVP', 2000, 1, '0', NULL, NULL, NULL),
(150, 49, 'RSVP', 0, 1, '0', NULL, NULL, NULL),
(168, 58, 'PAID', 23, 2, '234', NULL, NULL, NULL),
(171, 62, 'PAID', 20, 2, '20', NULL, NULL, NULL),
(172, 62, 'PAID', 34, 2, '234', NULL, NULL, NULL),
(173, 61, 'PAID', 20, 2, '2000', NULL, NULL, NULL),
(174, 61, 'RSVP', 100, 1, '0', NULL, NULL, NULL),
(175, 61, 'DONATE', 20000, 3, '100', NULL, NULL, NULL),
(176, 53, 'RSVP', 200, 1, '0', NULL, NULL, NULL),
(177, 53, 'PAID', 1000, 2, '1000', NULL, NULL, NULL),
(183, 60, 'FREE', 200, 1, '0', NULL, NULL, NULL),
(184, 60, 'VIP', 198, 2, '200', NULL, NULL, NULL),
(185, 60, 'V.VIP', 198, 2, '300', NULL, NULL, NULL),
(186, 63, 'VVIP', 23, 1, '0', NULL, NULL, NULL),
(187, 64, 'VIP', 23, 2, '3', NULL, NULL, NULL),
(188, 65, 'VVIP', 324, 2, '333', NULL, NULL, NULL),
(189, 66, 'VIP', 23, 2, '23', NULL, NULL, NULL),
(190, 67, 'EARLY BIRD', 324, 2, '33', NULL, NULL, NULL),
(191, 68, 'VIP', 23, 2, '344', NULL, NULL, NULL),
(192, 69, 'VIP', 234, 1, '0', NULL, NULL, NULL),
(193, 70, 'EARLY BIRD', 3444, 1, '0', NULL, NULL, NULL),
(194, 71, 'VIP', 3, 1, '0', NULL, NULL, NULL),
(195, 72, 'EARLY BIRD', 3, 2, '0', NULL, NULL, NULL),
(196, 73, 'VIP', 34, 2, '34', NULL, NULL, NULL),
(197, 74, 'VIP', 234, 1, '234', NULL, NULL, NULL),
(198, 75, 'VVIP', 234, 2, '34', NULL, NULL, NULL),
(199, 76, 'VIP', 2, 1, '42', NULL, NULL, NULL),
(203, 77, 'VVIP', 111, 1, '0', NULL, NULL, NULL),
(207, 78, 'EARLY BIRD', 22, 2, '0', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `follow`
--

CREATE TABLE `follow` (
  `id` int(10) UNSIGNED NOT NULL,
  `followed_user_id` int(10) UNSIGNED NOT NULL,
  `follower_user_id` int(10) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `follow`
--

INSERT INTO `follow` (`id`, `followed_user_id`, `follower_user_id`, `created_at`, `updated_at`) VALUES
(3, 3, 5, '2019-05-22 12:56:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `helpdesk`
--

CREATE TABLE `helpdesk` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `organizer_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `organizer_message` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `helpdesk`
--

INSERT INTO `helpdesk` (`id`, `user_id`, `organizer_id`, `category_id`, `subject`, `message`, `organizer_message`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(11, 15, 9, 2, 'test subject', 'test message', 'test message for user who sent me his problem sdf', 'closed', '2019-06-17 15:36:17', '2019-06-17 18:15:48', NULL),
(12, 15, 9, 1, 'test subject', 'test message', NULL, 'pending', '2019-06-17 15:36:35', '2019-06-17 15:36:35', NULL),
(13, 15, 13, 1, 'test subject', 'test message', NULL, 'pending', '2019-06-17 17:09:25', '2019-06-17 17:09:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `helpdesk_category`
--

CREATE TABLE `helpdesk_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `helpdesk_category`
--

INSERT INTO `helpdesk_category` (`id`, `name`, `updated_at`, `created_at`) VALUES
(1, 'Ticket', NULL, NULL),
(2, 'Order', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `helpdesk_images`
--

CREATE TABLE `helpdesk_images` (
  `id` int(11) NOT NULL,
  `helpdesk_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `helpdesk_images`
--

INSERT INTO `helpdesk_images` (`id`, `helpdesk_id`, `image`, `created_at`, `updated_at`) VALUES
(13, 11, '1560765977-godzilla_king_of_the_monsters_2019_4k_8k-2560x1440.jpg', '2019-06-17 15:36:17', '2019-06-17 15:36:17'),
(14, 11, '1560765977-joker_2-2560x1440.jpg', '2019-06-17 15:36:17', '2019-06-17 15:36:17'),
(15, 11, '1560765977-pokemon_detective_pikachu_2019_5k-2560x1440.jpg', '2019-06-17 15:36:17', '2019-06-17 15:36:17'),
(16, 11, '1560765977-purge_led_mask_5k-2560x1440.jpg', '2019-06-17 15:36:17', '2019-06-17 15:36:17'),
(17, 12, '1560765995-Koala.jpg', '2019-06-17 15:36:35', '2019-06-17 15:36:35'),
(18, 12, '1560765995-Lighthouse.jpg', '2019-06-17 15:36:35', '2019-06-17 15:36:35'),
(19, 12, '1560765995-Penguins.jpg', '2019-06-17 15:36:35', '2019-06-17 15:36:35'),
(20, 12, '1560765995-Tulips.jpg', '2019-06-17 15:36:35', '2019-06-17 15:36:35'),
(21, 13, '1560771566-Koala.jpg', '2019-06-17 17:09:26', '2019-06-17 17:09:26'),
(22, 13, '1560771566-Lighthouse.jpg', '2019-06-17 17:09:26', '2019-06-17 17:09:26'),
(23, 13, '1560771566-Penguins.jpg', '2019-06-17 17:09:26', '2019-06-17 17:09:26'),
(24, 13, '1560771566-Tulips.jpg', '2019-06-17 17:09:26', '2019-06-17 17:09:26');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2019_05_22_153303_create_jobs_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('010990015eeee94a9fbf8eed4c7ada294b9be21f8ca2562556ae1c0bda54395c0ac08d59e0284857', 15, 1, 'userToken', '[]', 0, '2019-08-09 06:06:48', '2019-08-09 06:06:48', '2020-08-09 11:36:48'),
('04447012872753d5949830e05af799c6c3664183f75a4c9a99c26b1db0d6e7444996763d3980da4f', 9, 1, 'userToken', '[]', 0, '2019-07-01 06:03:58', '2019-07-01 06:03:58', '2020-07-01 11:33:58'),
('04f0be596c6d9a067ccc86fb97b1b99c5c4e3569997592e7bb08252a1b73af1c17c629a28e3f3204', 26, 1, 'userToken', '[]', 0, '2019-06-25 05:59:00', '2019-06-25 05:59:00', '2020-06-25 11:29:00'),
('0ef47b8eec6266ea19f999e75db397c2f240bf4c4dd3958d6f6bf8612decec16c692d60cffd246b1', 15, 1, 'userToken', '[]', 0, '2019-06-21 11:54:36', '2019-06-21 11:54:36', '2020-06-21 17:24:36'),
('139e1c4bcebb1628f7cda26f10769ed1307f75fa832e0bef42e58e610409531d16a6a000d73c370c', 7, 1, 'userToken', '[]', 0, '2019-07-11 05:05:40', '2019-07-11 05:05:40', '2020-07-11 10:35:40'),
('15e16b0c769bd4e0d801e2dc01ad500d3fcc7369dc432f68f446c44c8dca84f28eb23747c43ef045', 15, 1, 'userToken', '[]', 0, '2019-08-02 05:07:44', '2019-08-02 05:07:44', '2020-08-02 10:37:44'),
('18cdd41e1c258d6f542f8c7f148ffa1af96c7034d2572f8d40256bf9caa9ce15fa03146f34a786b5', 9, 1, 'userToken', '[]', 0, '2019-08-05 06:00:29', '2019-08-05 06:00:29', '2020-08-05 11:30:29'),
('195f4e75e24746c9184ffd117d8ea03c7b6a9aafe0cb1dfd57c009315cc5b90b0665577efb2d77bd', 9, 1, 'userToken', '[]', 0, '2019-06-26 05:00:17', '2019-06-26 05:00:17', '2020-06-26 10:30:17'),
('19da57d0aa6c86bae9af457301c79bfee077372a3ba5978fd1e91255e64d9e1828606d6e1d3e1462', 7, 1, 'userToken', '[]', 0, '2019-07-23 09:19:48', '2019-07-23 09:19:48', '2020-07-23 14:49:48'),
('1a765a309906a08811081e16a567457974d0eb3893aa5bf8027e82fe1f023bc3feef9f9a944899a4', 23, 1, 'userToken', '[]', 0, '2019-06-24 10:20:29', '2019-06-24 10:20:29', '2020-06-24 15:50:29'),
('1b2517ccc2bccf317d0f50949fdc06491f73ea4f513b4386c0f28a6f8bca5fab4ccd5f9753c42522', 9, 1, 'userToken', '[]', 0, '2019-07-03 06:28:10', '2019-07-03 06:28:10', '2020-07-03 11:58:10'),
('1b745dc2f1c5d4cb4dd3862cfb0b6ad7d470cce632f75c81fdde6e3d409132d25de545a73ace0e61', 7, 1, 'userToken', '[]', 0, '2019-07-23 13:22:50', '2019-07-23 13:22:50', '2020-07-23 18:52:50'),
('219e1fc9b9ee0e50cb7ae40e7c55818682c3a13518e8d81b21e95c3a1ef3ab566bf4bab95d197090', 9, 1, 'userToken', '[]', 0, '2019-06-24 12:17:50', '2019-06-24 12:17:50', '2020-06-24 17:47:50'),
('23ed5bd40d572a796cbf979261164110407b7b89a91cbd07fae2f5dddb2568ef92c6e5709cd8527e', 7, 1, 'userToken', '[]', 0, '2019-07-05 04:42:53', '2019-07-05 04:42:53', '2020-07-05 10:12:53'),
('23f9358991bba11a9af4ea10cb20e7c9a4256af19c9ebd3af52070d491180a3ff5c71ad4fa3083a1', 9, 1, 'userToken', '[]', 0, '2019-06-21 12:17:58', '2019-06-21 12:17:58', '2020-06-21 17:47:58'),
('258bfc09ff56daeae5ebef49df506e2db439acd29748a3fe2ddee8fcc2e9ccbc27e6938daf30f2db', 15, 1, 'userToken', '[]', 0, '2019-08-02 10:47:14', '2019-08-02 10:47:14', '2020-08-02 16:17:14'),
('272f98b1c8e9ac58806e63a4f8a35b5fa57a48695bf7697acd859ad32b9c53654a930e9810878b3d', 9, 1, 'userToken', '[]', 0, '2019-06-25 12:30:40', '2019-06-25 12:30:40', '2020-06-25 18:00:40'),
('27b476acfe8133284d967d08a6db462dc60837f132c86eecc590f423c1dd52d9cb21b6d374188f04', 9, 1, 'userToken', '[]', 0, '2019-07-02 10:46:00', '2019-07-02 10:46:00', '2020-07-02 16:16:00'),
('29dc94b86ceaed1ce1bfea3e95fa6a84ad58ad5517b8b1f7d140a88de0e4d7a9f5e2033be78bc6a6', 15, 1, 'userToken', '[]', 0, '2019-08-01 05:00:40', '2019-08-01 05:00:40', '2020-08-01 10:30:40'),
('2b315e856e383007020f529acc3365c320a724c936286824e71aaf357096bd7b55e561bf25550ed0', 9, 1, 'userToken', '[]', 0, '2019-06-27 05:41:39', '2019-06-27 05:41:39', '2020-06-27 11:11:39'),
('2c712f7ba1f4bd18ceb27bc5091f466b504914ee88ab72616a8ff4c2b5b2df56f0798ab9eb01cbc8', 15, 1, 'userToken', '[]', 0, '2019-08-05 08:19:34', '2019-08-05 08:19:34', '2020-08-05 13:49:34'),
('322ab1a62a0191f8752b9c439b6fd2d943cf72646706a2cb28ddd219dff4cfbe8209db722e179f2b', 15, 1, 'userToken', '[]', 0, '2019-07-30 12:14:47', '2019-07-30 12:14:47', '2020-07-30 17:44:47'),
('32c0cfed4e4c36d4b03a86b9a8c315dc09317030577aae57415f601d5ae203c65a10c95c94776d09', 23, 1, 'userToken', '[]', 0, '2019-06-24 11:20:08', '2019-06-24 11:20:08', '2020-06-24 16:50:08'),
('3358c2a1d976d6343abcf843a7dc5716efc7e1bf02cc35b752809c9da0325ea309b8f831ebf5425a', 15, 1, 'userToken', '[]', 0, '2019-06-24 12:50:32', '2019-06-24 12:50:32', '2020-06-24 18:20:32'),
('33b640e1f7490779f34bd7cba476f12481c63ec23cc77eed0609c5688e6c7845d5a83ad78da5f930', 9, 1, 'userToken', '[]', 0, '2019-07-03 10:45:47', '2019-07-03 10:45:47', '2020-07-03 16:15:47'),
('349491d27b26ebec32b5548ba844f08c9d62bd37043f166e522e29b8bfadd74b05b5ac1c3605794d', 7, 1, 'userToken', '[]', 0, '2019-07-26 07:08:32', '2019-07-26 07:08:32', '2020-07-26 12:38:32'),
('359ecb685bb6829e11ce1281e99096abf57991858fd0a9a556da1a41af150664a6bd08d435ac6e52', 24, 1, 'userToken', '[]', 0, '2019-06-24 13:08:09', '2019-06-24 13:08:09', '2020-06-24 18:38:09'),
('37e59d0d66689ba4d10f7d37b9b0fda91aeda92acfb7a3674ee6418d7aad729067653d47a2db1b98', 15, 1, 'userToken', '[]', 0, '2019-07-30 12:15:06', '2019-07-30 12:15:06', '2020-07-30 17:45:06'),
('3a36c4ef064a4a64ff419c50941b1b71faef7a5fdba6325f8e80cca60d8172fe09fae25df62ecebe', 9, 1, 'userToken', '[]', 0, '2019-07-03 05:00:13', '2019-07-03 05:00:13', '2020-07-03 10:30:13'),
('3bf4956c2cb4f609b5e64f5ecaecdcdac0951856bb7f0125c1b2df27edfbb77412736bd1ddf162d9', 9, 1, 'userToken', '[]', 0, '2019-06-21 10:54:51', '2019-06-21 10:54:51', '2020-06-21 16:24:51'),
('3c4359c2ca02db064c25530664f0b9df1fecb6e73649a904a24443ce3ef3c55645a1e29629b953c1', 9, 1, 'userToken', '[]', 0, '2019-08-09 08:37:08', '2019-08-09 08:37:08', '2020-08-09 14:07:08'),
('3effab35fa16ec1028ea5f9fe17cc701afa271a284198eeaa19f22a50c70c19fa54366bffe6aa3be', 9, 1, 'userToken', '[]', 0, '2019-06-24 13:01:51', '2019-06-24 13:01:51', '2020-06-24 18:31:51'),
('42e2dd6bbe2acebd21a85c8a62af87f583950564cd541962f30e6b03e6abd64183d90aa7a142525a', 15, 1, 'userToken', '[]', 0, '2019-07-30 12:08:47', '2019-07-30 12:08:47', '2020-07-30 17:38:47'),
('468a692b234d72d1764e62b660bc404c08b8d2801b704a4004050e8b7435bc582773587dc96ba886', 7, 1, 'userToken', '[]', 0, '2019-07-01 12:26:09', '2019-07-01 12:26:09', '2020-07-01 17:56:09'),
('4d006c85f61d7d9ecedcb38c0ed9ebaade9a69b0449f554cdf8e6cdfe006dd4d53ab549077c9f760', 15, 1, 'userToken', '[]', 0, '2019-07-30 12:19:55', '2019-07-30 12:19:55', '2020-07-30 17:49:55'),
('4d87c19c0a99ee9d0375a8fe25a2a771da9a3efe6c62958e64ba6c1d2b2d795cb1f511d6a8dbb710', 15, 1, 'userToken', '[]', 0, '2019-07-30 12:14:11', '2019-07-30 12:14:11', '2020-07-30 17:44:11'),
('50f60efdb5e108a8601f3b4506b2763c5506cc1900172d1a70d93c418ceb7da351c387d0aec32624', 9, 1, 'userToken', '[]', 0, '2019-07-03 05:20:34', '2019-07-03 05:20:34', '2020-07-03 10:50:34'),
('51ee6aa9d8ee4ce3ec3703f9c845fc4c5bb13e3652309b66f6394e309bc41f8cc942b46ec07e829f', 24, 1, 'userToken', '[]', 0, '2019-06-24 12:13:03', '2019-06-24 12:13:03', '2020-06-24 17:43:03'),
('5339de7f5d97c961393511a31858ce8ba6326b7e5f22c8cf166e53dc2008ff923da9aff593a9c16b', 9, 1, 'userToken', '[]', 0, '2019-06-21 11:49:36', '2019-06-21 11:49:36', '2020-06-21 17:19:36'),
('542cea79e63bb047313300338c5016765c2d64e1dcb8785087d6f8f31328406fce784b244b2342aa', 9, 1, 'userToken', '[]', 0, '2019-06-24 05:13:44', '2019-06-24 05:13:44', '2020-06-24 10:43:44'),
('55e802f4c77b779bbbb885a3fcc09ce2709500ab7c045da2269903e9bb58d913aebffe7fead51d46', 9, 1, 'userToken', '[]', 0, '2019-06-24 11:26:56', '2019-06-24 11:26:56', '2020-06-24 16:56:56'),
('575d72ea37fd573856b63a13b9fdf909c6e15b7c0f21822b0555df1b1d714a21e0b1daf6a540edc8', 9, 1, 'userToken', '[]', 0, '2019-07-04 13:08:04', '2019-07-04 13:08:04', '2020-07-04 18:38:04'),
('57a3ec1dfa392bae10b0bbd6c77a93e7965984bfd7bc83e906f9b56b6f0dae8f57a22e4c289884f3', 22, 1, 'userToken', '[]', 0, '2019-06-24 10:12:04', '2019-06-24 10:12:04', '2020-06-24 15:42:04'),
('5a01bd935f76477a4787f543f0f29ed465ea2a26555e3d52405e8a147ec088b3f1845dd1cba82396', 15, 1, 'userToken', '[]', 0, '2019-06-21 12:18:21', '2019-06-21 12:18:21', '2020-06-21 17:48:21'),
('5a52e2a079e5e297b6c22093a7833c4f5ddb7c707090a939484f082ebd42896f7d804830675c49d1', 7, 1, 'userToken', '[]', 0, '2019-07-17 05:14:31', '2019-07-17 05:14:31', '2020-07-17 10:44:31'),
('5aa62765c2bc13166e81e6b4c2844a68985efdf2621bf36d32d4a19a1a0427f003c6f607e12e1328', 7, 1, 'userToken', '[]', 0, '2019-07-04 05:19:48', '2019-07-04 05:19:48', '2020-07-04 10:49:48'),
('5c9a74f1b0b2b237ace100173c7227b427b781260d5fcdda4947ae3a7cd7994d4b1eca0ef160e6f2', 9, 1, 'userToken', '[]', 0, '2019-07-25 13:13:17', '2019-07-25 13:13:17', '2020-07-25 18:43:17'),
('604a624ff6035dc5c000117116d569bfbf8b8b52977f3919f769098cdfba383735d9061646c01d45', 7, 1, 'userToken', '[]', 0, '2019-07-10 05:24:15', '2019-07-10 05:24:15', '2020-07-10 10:54:15'),
('611ecf02ed30a6d1fc4a429da9bfe82432ad73aa871745c35f042c63e9db938d79d86f2554317269', 7, 1, 'userToken', '[]', 0, '2019-07-04 13:09:37', '2019-07-04 13:09:37', '2020-07-04 18:39:37'),
('61cd36d983d0f053b076cf81dfde8839abde18d50da61547c29498a0330d9e118894bdf7447bc04a', 26, 1, 'userToken', '[]', 0, '2019-06-25 10:15:39', '2019-06-25 10:15:39', '2020-06-25 15:45:39'),
('63db4381c74075ec6639b3027b82034377b9d0e738c7021840d7ebf227b304bf6147b33cca35821b', 9, 1, 'userToken', '[]', 0, '2019-08-02 06:19:41', '2019-08-02 06:19:41', '2020-08-02 11:49:41'),
('65b2983bf4760df5d6b6d6d3915bdbd87bff07a2aad65c0a9addfd7b18433997eee9687dd0df93e0', 7, 1, 'userToken', '[]', 0, '2019-07-11 05:17:56', '2019-07-11 05:17:56', '2020-07-11 10:47:56'),
('66a0878ad3dd44c48b7d5eaad21db88ff0d4699391f7d229a9ac4991cffb8b5acefb062b3b562686', 7, 1, 'userToken', '[]', 0, '2019-07-15 05:38:48', '2019-07-15 05:38:48', '2020-07-15 11:08:48'),
('6bffdd0e136b5eff968e81c2976df148bafcb719a64eaf826384dc350d6b85fee7cb582a8808f11c', 9, 1, 'userToken', '[]', 0, '2019-06-21 10:53:23', '2019-06-21 10:53:23', '2020-06-21 16:23:23'),
('6e8ad99e587aad848e3ec5608c755a7e8ac213859d366b0d2423e4aa273b2707160a9f1b30e097c4', 7, 1, 'userToken', '[]', 0, '2019-06-24 12:18:11', '2019-06-24 12:18:11', '2020-06-24 17:48:11'),
('70c8cb2b9f9135c3765cc124f3272bab307cc2cb62fda0a0967f0e49ff402290644e233ec54ecd50', 9, 1, 'userToken', '[]', 0, '2019-07-24 05:26:55', '2019-07-24 05:26:55', '2020-07-24 10:56:55'),
('72f78f63a90df812ea433119d221e74648dae6b9bbc6e0a815cff0a4dbc5aa117f6924b44fc1aa45', 9, 1, 'userToken', '[]', 0, '2019-06-27 05:11:48', '2019-06-27 05:11:48', '2020-06-27 10:41:48'),
('740bbdc71002761663ce2a6bc093a13ab6430d7ac6473af577289ad61646b44d376a9ca5aace125f', 9, 1, 'userToken', '[]', 0, '2019-06-21 11:50:01', '2019-06-21 11:50:01', '2020-06-21 17:20:01'),
('74d3a4def01606cb9821cf8ce55b25c55e2251360687f2cbd83d0d62c2bf96ecf00813c23bbc7634', 15, 1, 'userToken', '[]', 0, '2019-08-09 07:31:19', '2019-08-09 07:31:19', '2020-08-09 13:01:19'),
('78cfdc535c755b428e4a9c595cc1c51cd81a86b7db259a3c73d07f3742e8967c21562d65a39ee6ff', 23, 1, 'userToken', '[]', 0, '2019-06-24 12:02:57', '2019-06-24 12:02:57', '2020-06-24 17:32:57'),
('7d5ec4e92b0ee24d28fd9c182dbca5093b6d25d989569dd9fea8900ea32ba46bf5448485f1f57053', 7, 1, 'userToken', '[]', 0, '2019-07-19 04:58:08', '2019-07-19 04:58:08', '2020-07-19 10:28:08'),
('7de13a5373221dc430afb8f802e27a957d7d3b73f2bb5477819b41789d6a9b652c45e1705ccbc7f2', 24, 1, 'userToken', '[]', 0, '2019-06-24 12:52:47', '2019-06-24 12:52:47', '2020-06-24 18:22:47'),
('7e06d330ebf09d1b1dfd41f79b0b4de68ff71c8f3d0e796f9d3ab3ea3ef15e90d4eae065f17d80c2', 15, 1, 'userToken', '[]', 0, '2019-07-30 11:30:02', '2019-07-30 11:30:02', '2020-07-30 17:00:02'),
('7e520a10c9d0919bdd336434ba0585970b68e76240004c946d5b6d715700ddeec2f44d39ef81902a', 9, 1, 'userToken', '[]', 0, '2019-06-27 04:55:00', '2019-06-27 04:55:00', '2020-06-27 10:25:00'),
('7fc76f539d5ad749e2582d22909121b19d2e8f6a3b4fbab8cb9eda46ec43b1d1617c7770bbf99081', 22, 1, 'userToken', '[]', 0, '2019-06-24 10:36:52', '2019-06-24 10:36:52', '2020-06-24 16:06:52'),
('81c10c1ebc4724421194690ea7f4849c9defd9fb90bbd858718eadb278d4cbb58455d3bc25f36097', 7, 1, 'userToken', '[]', 0, '2019-07-03 05:03:35', '2019-07-03 05:03:35', '2020-07-03 10:33:35'),
('8293c54c27b22457240ff70735b3bb55be59efbc180f47f98f2f6d5e88a84f16fc989ff3059ea4f9', 9, 1, 'userToken', '[]', 0, '2019-08-09 04:51:30', '2019-08-09 04:51:30', '2020-08-09 10:21:30'),
('8422c97bd047152ebb6176369584a6f3bd22cc5d649708d0169ae1eb14a9330e3ebd88847fdd2834', 15, 1, 'userToken', '[]', 0, '2019-06-21 11:51:08', '2019-06-21 11:51:08', '2020-06-21 17:21:08'),
('85a7c62cfc47a9e5abfd7012db99605bd2e550a327654a1a80d73437f2d2be907bed43fa8c40f5fb', 7, 1, 'userToken', '[]', 0, '2019-07-03 05:57:13', '2019-07-03 05:57:13', '2020-07-03 11:27:13'),
('8c8618444dfb044249ed55cbecd4049ecd3fd10e00920a3f34375b4aa348493675ab5b6c37f42671', 9, 1, 'userToken', '[]', 0, '2019-07-02 05:19:46', '2019-07-02 05:19:46', '2020-07-02 10:49:46'),
('908b73cefbc9dce62b42225d9f893ab4e15c147e1a6ab12d2dfca12d5e57d2b1d22f47908d53522d', 9, 1, 'userToken', '[]', 0, '2019-06-21 12:15:11', '2019-06-21 12:15:11', '2020-06-21 17:45:11'),
('9170f885be37426e02a13da13eae924dde11841cd4ee62f5a627ac81c2539aff909f427808ecfb6d', 15, 1, 'userToken', '[]', 0, '2019-07-31 04:51:28', '2019-07-31 04:51:28', '2020-07-31 10:21:28'),
('96df952110fb56474fc49b9de2c6bd599d5f05aa5789be002327cd31ae3fd349f0a42a0d44d779f0', 9, 1, 'userToken', '[]', 0, '2019-06-24 12:00:23', '2019-06-24 12:00:23', '2020-06-24 17:30:23'),
('9d069b294b9983ceecf597301513b1bddf7b5d41ad8ffb75cb5958df6e820b002c92f88a7a835c2b', 15, 1, 'userToken', '[]', 0, '2019-08-08 11:22:32', '2019-08-08 11:22:32', '2020-08-08 16:52:32'),
('9d3c3a2992e5e356be1ef135423b8894990308babef5380a5ff5a7dfea2e83f2c905f3a860daa1ff', 9, 1, 'userToken', '[]', 0, '2019-06-27 05:17:35', '2019-06-27 05:17:35', '2020-06-27 10:47:35'),
('9f8f6676d21b685e8981fe81c14331a4f0a61644e6b668db87582db39188471e95aafcee0356f9a6', 7, 1, 'userToken', '[]', 0, '2019-07-16 05:07:19', '2019-07-16 05:07:19', '2020-07-16 10:37:19'),
('a2a04e4823904ff08cb5f52eec170dcadd33cb4269375aeab07eec8b8874865675d868c97a752f8c', 9, 1, 'userToken', '[]', 0, '2019-06-24 12:02:25', '2019-06-24 12:02:25', '2020-06-24 17:32:25'),
('a2baaa2c76035b60b1dcb55a2348dd67bdf5a6c7bedaf160452285f3e30caf41263e89ecee396e62', 7, 1, 'userToken', '[]', 0, '2019-06-24 12:22:00', '2019-06-24 12:22:00', '2020-06-24 17:52:00'),
('a638d4f212918a475cb8c81ec6c077a867bbbe4a31f3721c489c6f813199e2a5dc1dba919747c637', 15, 1, 'userToken', '[]', 0, '2019-08-09 07:30:59', '2019-08-09 07:30:59', '2020-08-09 13:00:59'),
('a9da862e7566eb25ff638e1d7c894b0581c9a8a6b0c5379e82c05cf1ed7c6987f920e2f34a59684a', 24, 1, 'userToken', '[]', 0, '2019-06-24 13:04:27', '2019-06-24 13:04:27', '2020-06-24 18:34:27'),
('aa6e8e0e266579ddba7015a5c62601dc8886b45f03bb0a70c1e3c779dc17e2b8562db084f68d57f8', 9, 1, 'userToken', '[]', 0, '2019-06-25 11:46:16', '2019-06-25 11:46:16', '2020-06-25 17:16:16'),
('accd1c7f759221c2a766f4b709144d06fe356ba0f39bbe62a06bdad8cce007f6f968820330506d29', 15, 1, 'userToken', '[]', 0, '2019-08-09 08:31:32', '2019-08-09 08:31:32', '2020-08-09 14:01:32'),
('b551178e42f19d14867b78901a7bd2a5e9d4329ae42b4ab454e9a2afddc4ea72c7ec7488aec77280', 9, 1, 'userToken', '[]', 0, '2019-06-27 05:22:40', '2019-06-27 05:22:40', '2020-06-27 10:52:40'),
('b91d3c8aabb9a47fe3bd50f677d902b2cc141e08ca31ea3fdd23f44b7aeee9c6a69754b61559749c', 15, 1, 'userToken', '[]', 0, '2019-06-21 12:16:54', '2019-06-21 12:16:54', '2020-06-21 17:46:54'),
('bba260a498eee1fd03c031ec3ce1c9f30b5a362885bde1363a27fc86f29763442ae8318f7e43bca8', 9, 1, 'userToken', '[]', 0, '2019-07-22 06:39:13', '2019-07-22 06:39:13', '2020-07-22 12:09:13'),
('bbd29ac9dc8b58f6d4cb32bc3b27a7235201e70bab1bc2f26c14fde2c313a349fb609de10b8cfc8b', 7, 1, 'userToken', '[]', 0, '2019-07-12 04:55:37', '2019-07-12 04:55:37', '2020-07-12 10:25:37'),
('c0775e78e9c710b5facfdeb23aed72528d0a63e5b1da56c071d8a47876ae46291249ca35fa299a4b', 9, 1, 'userToken', '[]', 0, '2019-06-27 06:38:16', '2019-06-27 06:38:16', '2020-06-27 12:08:16'),
('c380334a002f0b3b77ca1021ca9ab6562be99fc25ec3915d102687782689679a5050068e20f0532a', 9, 1, 'userToken', '[]', 0, '2019-07-03 12:18:33', '2019-07-03 12:18:33', '2020-07-03 17:48:33'),
('cc7c117df6e203e550f1a4c711a5a9fca4e51c60ddb276e6b862b13374dd391012743eabba988ce7', 15, 1, 'userToken', '[]', 0, '2019-08-07 06:20:10', '2019-08-07 06:20:10', '2020-08-07 11:50:10'),
('cf73d7889f79f3a787fbfcc15e3174cf2d046a283e8a8ca626f0348942cce0bd7d27f6e47848de87', 9, 1, 'userToken', '[]', 0, '2019-06-21 10:55:16', '2019-06-21 10:55:16', '2020-06-21 16:25:16'),
('d3189ec5da174f40176cc1acfccc58637691b334b1a379a1e4589fba9575be5ae29541a460e739e2', 9, 1, 'userToken', '[]', 0, '2019-06-27 05:46:29', '2019-06-27 05:46:29', '2020-06-27 11:16:29'),
('d82570e6fbcef535f99f00d8a75927a6362e2180472400d0f4966315399a75b165174659f0ad12d9', 7, 1, 'userToken', '[]', 0, '2019-07-19 13:27:03', '2019-07-19 13:27:03', '2020-07-19 18:57:03'),
('d86e3fcae55b4784a380a0a850a90ded23dcbd4d4ad78a2926e21b067bfb5f3453bacc3a77098c2e', 7, 1, 'userToken', '[]', 0, '2019-07-18 05:42:10', '2019-07-18 05:42:10', '2020-07-18 11:12:10'),
('d931616ae5821d758a34136004e8c1b90f8ad565a3396f6b228594cae677f52deefcba061757468b', 9, 1, 'userToken', '[]', 0, '2019-06-21 10:49:01', '2019-06-21 10:49:01', '2020-06-21 16:19:01'),
('da87ce480f43c9c497366a37e038337237aef990a42df8908771fa780c36a3b52dccd3fc6f624200', 9, 1, 'userToken', '[]', 0, '2019-06-26 04:59:12', '2019-06-26 04:59:12', '2020-06-26 10:29:12'),
('dd38d98a70175e78d3ea57d2d308082d19d6bb0c993484f9cc443b72142ee816366f8b5a3ba43b45', 23, 1, 'userToken', '[]', 0, '2019-06-24 11:25:58', '2019-06-24 11:25:58', '2020-06-24 16:55:58'),
('e0046017a2bf99fada162ff8b2b65e5c1c1c48b077eee1d2fe634e1d548cd524aee86f71537caa37', 25, 1, 'userToken', '[]', 0, '2019-06-25 05:55:41', '2019-06-25 05:55:41', '2020-06-25 11:25:41'),
('e145a517017995e9c1357807dc24dcfbee36550f89acd372cf8780597314e273aa2631db4d3a6733', 9, 1, 'userToken', '[]', 0, '2019-07-01 12:26:24', '2019-07-01 12:26:24', '2020-07-01 17:56:24'),
('e2491561bc69d5d40023f66545ef1929784c25c20c144c50ad7302ed09d1192cdd8aaaf612108947', 23, 1, 'userToken', '[]', 0, '2019-06-24 10:20:29', '2019-06-24 10:20:29', '2020-06-24 15:50:29'),
('e54dc5397bf4ef4bba27c106cefdac6101bf35aa02e9876c1ccfce3a71b28b6a79e96c1281b521de', 9, 1, 'userToken', '[]', 0, '2019-06-28 05:08:51', '2019-06-28 05:08:51', '2020-06-28 10:38:51'),
('e58995b32cb2ad12a6b544125d56cf0c55bcbfe25d427b55ebc1717a41a4d2d8b44d6dc9eb8964f0', 15, 1, 'userToken', '[]', 0, '2019-07-30 12:18:53', '2019-07-30 12:18:53', '2020-07-30 17:48:53'),
('e9975610772c5a8bc9acae7c8b2c3b76290ff2f9ad8ae3451f359e88751bd6a1e7f17c5d2f7d206d', 7, 1, 'userToken', '[]', 0, '2019-07-12 12:11:28', '2019-07-12 12:11:28', '2020-07-12 17:41:28'),
('ea71ad8213ea05ecaf1750bc3ad1729c4fbd4489b2bd310a5818fc481974671c1bfd1be004551b68', 7, 1, 'userToken', '[]', 0, '2019-07-22 07:05:04', '2019-07-22 07:05:04', '2020-07-22 12:35:04'),
('ec1d9a24810062ec759a08980011b61c0fddcea9a755bf0e745210dc04b59531b091fa2018d4e9ab', 15, 1, 'userToken', '[]', 0, '2019-07-30 12:11:39', '2019-07-30 12:11:39', '2020-07-30 17:41:39'),
('ecb2d6bef7d7e5c80ec0d26df4e6b74894b08fe58249eb07700976be6db26e592bdd2a802008fc66', 7, 1, 'userToken', '[]', 0, '2019-06-24 12:17:23', '2019-06-24 12:17:23', '2020-06-24 17:47:23'),
('ef03019f320f8bfc6f85ec7329392de10395c489acd61f3120e4f44095b3e504ce3e8027c0fa91f9', 7, 1, 'userToken', '[]', 0, '2019-07-22 05:11:24', '2019-07-22 05:11:24', '2020-07-22 10:41:24'),
('f154613c475b4fc8eb0a2527d67ea9364202905d9c97675a1d67167e402716488844d5069465b331', 9, 1, 'userToken', '[]', 0, '2019-08-12 06:04:45', '2019-08-12 06:04:45', '2020-08-12 11:34:45'),
('f55b5491ece7466336df21fa6f285010d7b53e7f0858ff8874b22cc9e85290845d2eaab159f5a64e', 7, 1, 'userToken', '[]', 0, '2019-07-02 08:18:04', '2019-07-02 08:18:04', '2020-07-02 13:48:04'),
('f614cc0d2b11f1dcbe23032d23480ac983a8ebbdf31dfd71b013a4d4ba17fe81971ceec686a97373', 15, 1, 'userToken', '[]', 0, '2019-07-30 12:06:31', '2019-07-30 12:06:31', '2020-07-30 17:36:31'),
('f767fd1b1343a6603bc0b0a4001d14ab93a38754dda03c9513742e8556a3d82177fd52a922f6d4f4', 26, 1, 'userToken', '[]', 0, '2019-06-25 05:59:26', '2019-06-25 05:59:26', '2020-06-25 11:29:26'),
('f9a057babcfd66981d36a5ad801895ab88ffcec9cdba49b3e3cff8ea8611c3db1de66895fa1b81c3', 15, 1, 'userToken', '[]', 0, '2019-07-22 06:38:53', '2019-07-22 06:38:53', '2020-07-22 12:08:53'),
('fac00f1fa2c4d8f38336c1a807b0668a93e6f475cbabde733cd2e8d415a38cb6b2b26b8b6cecaff0', 7, 1, 'userToken', '[]', 0, '2019-07-19 13:28:39', '2019-07-19 13:28:39', '2020-07-19 18:58:39'),
('fb90b6c9319005036ee326040a28b116e6096f11bbc09486bd5ab441b4bb598973e2ea4cf3c87377', 9, 1, 'userToken', '[]', 0, '2019-07-05 13:23:15', '2019-07-05 13:23:15', '2020-07-05 18:53:15'),
('fe7888adba0f56ef3eff6ff71932458d78b195656cb10d8fd2d060cc84ea07d09640d1d3737f7f97', 9, 1, 'userToken', '[]', 0, '2019-06-21 10:55:49', '2019-06-21 10:55:49', '2020-06-21 16:25:49');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', '2cduBpDmYmjl6n1bSG5ESTw4v7WcrJBTCy8nUVqz', 'http://localhost', 1, 0, 0, '2019-05-01 23:47:07', '2019-05-01 23:47:07'),
(2, NULL, 'Laravel Password Grant Client', 'B6gX0hUBLRTvcR13duetcTB5LNRUi4UjDRNJ0svx', 'http://localhost', 0, 1, 0, '2019-05-01 23:47:07', '2019-05-01 23:47:07');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2019-05-01 23:47:07', '2019-05-01 23:47:07');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `barcode` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `purchaser_first_name` varchar(255) NOT NULL,
  `purchaser_last_name` varchar(255) NOT NULL,
  `purchaser_email` varchar(255) NOT NULL,
  `purchaser_phone` varchar(255) DEFAULT NULL,
  `billing_address` varchar(255) NOT NULL,
  `billing_address_2` varchar(255) DEFAULT NULL,
  `billing_country` varchar(255) DEFAULT NULL,
  `billing_state` varchar(255) DEFAULT NULL,
  `billing_city` varchar(255) DEFAULT NULL,
  `billing_zip` varchar(255) DEFAULT NULL,
  `billing_landmark` varchar(255) DEFAULT NULL,
  `ticket_details` text,
  `status` varchar(255) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `payer_first_name` varchar(255) DEFAULT NULL,
  `payer_last_name` varchar(255) DEFAULT NULL,
  `payer_email` varchar(255) DEFAULT NULL,
  `payer_id` varchar(255) DEFAULT NULL,
  `checkin_status` tinyint(1) NOT NULL,
  `payed_with` varchar(255) DEFAULT NULL,
  `refund_id` varchar(255) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `barcode`, `customer_id`, `event_id`, `purchaser_first_name`, `purchaser_last_name`, `purchaser_email`, `purchaser_phone`, `billing_address`, `billing_address_2`, `billing_country`, `billing_state`, `billing_city`, `billing_zip`, `billing_landmark`, `ticket_details`, `status`, `total_amount`, `coupon_id`, `payer_first_name`, `payer_last_name`, `payer_email`, `payer_id`, `checkin_status`, `payed_with`, `refund_id`, `transaction_id`, `created_at`, `updated_at`) VALUES
(1044, 1404058590, 1, 60, 'fsdfs', 'dfadsfa', 'sdfasf@sf.sf', 'asdfasdf', 'asfadf', NULL, 'asdfasd', 'fasdfasf', 'fasdfasd', '23424', 'asdfaf', '[{\"price\":\"0\",\"id\":180,\"event_id\":60,\"quantity\":200,\"ticket_type\":\"FREE\",\"description\":null,\"event_type\":\"Free\",\"selected\":3,\"attendees\":[{\"first_name\":\"sdfs\",\"last_name\":\"fsd\",\"email\":\"fsdfsd\"},{\"first_name\":\"fsdf\",\"last_name\":\"sfsd\",\"email\":\"fsdfs\"},{\"first_name\":\"fsdf\",\"last_name\":\"sdfsdf\",\"email\":\"sdfsfd\"}]},{\"price\":\"200\",\"id\":181,\"event_id\":60,\"quantity\":198,\"ticket_type\":\"VIP\",\"description\":null,\"event_type\":\"Paid\",\"selected\":4,\"attendees\":[{\"first_name\":\"sdf\",\"last_name\":\"sdf\",\"email\":\"sdfs\"},{\"first_name\":\"sdf\",\"last_name\":\"sdf\",\"email\":\"sdf\"},{\"first_name\":\"sdfsfd\",\"last_name\":\"sdfsdf\",\"email\":\"sdfsdf\"},{\"first_name\":\"sdfsdf\",\"last_name\":\"sfsdf\",\"email\":\"fsdf\"}]},{\"price\":\"300\",\"id\":182,\"event_id\":60,\"quantity\":198,\"ticket_type\":\"V.VIP\",\"description\":null,\"event_type\":\"Paid\",\"selected\":2,\"attendees\":[{\"first_name\":\"sdfsd\",\"last_name\":\"fsfsdf\",\"email\":\"sdfsdf\"},{\"first_name\":\"sdfsdfsd\",\"last_name\":\"fsdfsdf\",\"email\":\"sdfsdf\"}]}]', 'pending', '1400.00', NULL, NULL, NULL, NULL, NULL, 0, '', NULL, NULL, '2019-08-02 12:27:07', '2019-08-02 12:27:07'),
(1045, 1011650723, 1, 60, 'vikas', 'vikas', 'vikas@vikas.com', 'vikas', 'vikas', NULL, 'vikas', 'vikas', 'vikas', '84527', 'vikas', '[{\"price\":\"0\",\"id\":183,\"event_id\":60,\"quantity\":200,\"ticket_type\":\"FREE\",\"description\":null,\"event_type\":\"Free\",\"selected\":2,\"attendees\":[{\"first_name\":\"vikas1\",\"last_name\":\"vikas1.1\",\"email\":\"vikas@vikas\"},{\"first_name\":\"vikas2\",\"last_name\":\"vikas2.1\",\"email\":\"vikas2@vikas\"}]},{\"price\":\"200\",\"id\":184,\"event_id\":60,\"quantity\":198,\"ticket_type\":\"VIP\",\"description\":null,\"event_type\":\"Paid\",\"selected\":3,\"attendees\":[{\"first_name\":\"vikas3\",\"last_name\":\"vikas3.1\",\"email\":\"vikas3@vikas\"},{\"first_name\":\"vikas4\",\"last_name\":\"vikas4.1\",\"email\":\"vikas4@vikas\"},{\"first_name\":\"vikas5\",\"last_name\":\"vikas5.1\",\"email\":\"vikas5@vikas\"}]},{\"price\":\"300\",\"id\":185,\"event_id\":60,\"quantity\":198,\"ticket_type\":\"V.VIP\",\"description\":null,\"event_type\":\"Paid\",\"selected\":3,\"attendees\":[{\"first_name\":\"vikas6\",\"last_name\":\"vikas6.1\",\"email\":\"vikas6@vikas\"},{\"first_name\":\"vikas7\",\"last_name\":\"vikas7.1\",\"email\":\"vikas7@vikas\"},{\"first_name\":\"vikas8\",\"last_name\":\"vikas8.1\",\"email\":\"vikas8@vikas\"}]}]', 'COMPLETED', '1500.00', NULL, 'vikas', 'vikas', 'vikas@vikas.com', 'NLBDXUUH2EAWL', 0, 'paypal', NULL, NULL, '2019-08-05 06:24:20', '2019-08-05 07:25:26'),
(1046, 1237557117, 1, 60, 'sdfsdf', 'asdfasdf', 'asdf@sdf.df', 'sdf', 'asdfas', NULL, 'dfasdf', 'asdfasdf', 'asdf', '23424', 'asdf', '[{\"price\":\"200\",\"id\":184,\"event_id\":60,\"quantity\":198,\"ticket_type\":\"VIP\",\"description\":null,\"event_type\":\"Paid\",\"selected\":5,\"attendees\":[{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null}]},{\"price\":\"300\",\"id\":185,\"event_id\":60,\"quantity\":198,\"ticket_type\":\"V.VIP\",\"description\":null,\"event_type\":\"Paid\",\"selected\":2,\"attendees\":[{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null}]}]', 'COMPLETED', '1600.00', NULL, 'asdfasf', 'fasdfa', 'sfs@sdf.sdf', 'MJF9YGHG4DWT8', 0, 'paypal', NULL, NULL, '2019-08-05 08:21:49', '2019-08-05 08:22:58'),
(1047, 1254488834, 1, 60, 'sfsd', 'fsadf', 'asdf@sdf.sdf', 'asfd', 'asdf', NULL, 'asdf', 'asdfas', 'asdf', '23424', 'sdfsf', '[{\"price\":\"200\",\"id\":184,\"event_id\":60,\"quantity\":198,\"ticket_type\":\"VIP\",\"description\":null,\"event_type\":\"Paid\",\"selected\":5,\"attendees\":[{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null}]},{\"price\":\"300\",\"id\":185,\"event_id\":60,\"quantity\":198,\"ticket_type\":\"V.VIP\",\"description\":null,\"event_type\":\"Paid\",\"selected\":2,\"attendees\":[{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null}]}]', 'COMPLETED', '1600.00', NULL, 'Loveneet', 'Kumar', 'deanloveneet-buy-us@gmail.com', '9Y7QFCV9TC3TU', 0, 'paypal', NULL, NULL, '2019-08-05 08:25:27', '2019-08-05 08:27:06'),
(1048, 1117983907, 1, 60, 'fasdfa', 'sdfasdf', 'sfs@sdf.sdf', '23sf', 'asdfads', NULL, 'fasdf', 'asdfasf', 'asfd', '23424', 'asdfasf', '[{\"price\":\"200\",\"id\":184,\"event_id\":60,\"quantity\":198,\"ticket_type\":\"VIP\",\"description\":null,\"event_type\":\"Paid\",\"selected\":5,\"attendees\":[{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null}]},{\"price\":\"300\",\"id\":185,\"event_id\":60,\"quantity\":198,\"ticket_type\":\"V.VIP\",\"description\":null,\"event_type\":\"Paid\",\"selected\":2,\"attendees\":[{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null}]}]', 'COMPLETED', '1600.00', NULL, 'Loveneet', 'Kumar', 'deanloveneet-buy-us@gmail.com', '9Y7QFCV9TC3TU', 0, 'paypal', NULL, NULL, '2019-08-05 08:51:41', '2019-08-05 08:53:07'),
(1049, 1321164509, 1, 60, 'asdfasf', 'sdsf', 'sfs@sdf.sdf', 'sdfsdf', 'sdfsdf', NULL, 'sdfsf', 'sdfsd', 'sdfs', '23424', 'sdfasf', '[{\"price\":\"200\",\"id\":184,\"event_id\":60,\"quantity\":198,\"ticket_type\":\"VIP\",\"description\":null,\"event_type\":\"Paid\",\"selected\":5,\"attendees\":[{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null}]},{\"price\":\"300\",\"id\":185,\"event_id\":60,\"quantity\":198,\"ticket_type\":\"V.VIP\",\"description\":null,\"event_type\":\"Paid\",\"selected\":2,\"attendees\":[{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null}]}]', 'COMPLETED', '1600.00', NULL, 'sdfsf', 'sfsfslj', 'sfs@sdf.sdf', 'QR4QKQGSP92KS', 0, 'paypal', NULL, NULL, '2019-08-05 10:00:21', '2019-08-05 10:01:43'),
(1050, 1345529662, 1, 60, 'sdfsdf', 'asdfa', 'fasdfa@sdf.df', 'asfd', 'sdfsdf', NULL, 'sdf', 'sdf', 'sdf', '234', 'asdf', '[{\"price\":\"0\",\"id\":183,\"event_id\":60,\"quantity\":200,\"ticket_type\":\"FREE\",\"description\":null,\"event_type\":\"Free\",\"selected\":1,\"attendees\":[{\"first_name\":null,\"last_name\":null,\"email\":null}]},{\"price\":\"200\",\"id\":184,\"event_id\":60,\"quantity\":198,\"ticket_type\":\"VIP\",\"description\":null,\"event_type\":\"Paid\",\"selected\":1,\"attendees\":[{\"first_name\":null,\"last_name\":null,\"email\":null}]},{\"price\":\"300\",\"id\":185,\"event_id\":60,\"quantity\":198,\"ticket_type\":\"V.VIP\",\"description\":null,\"event_type\":\"Paid\",\"selected\":2,\"attendees\":[{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null}]}]', 'pending', '800.00', NULL, NULL, NULL, NULL, NULL, 0, '', NULL, NULL, '2019-08-05 10:23:53', '2019-08-05 10:23:53'),
(1051, 1070054509, 1, 60, 'fsdfasdf', 'asdfa', 'sfs@sdf.sdf', 'sdfadsf', 'asdf', NULL, 'asdf', 'asdf', 'asdf', '2342', 'sdfsf', '[{\"price\":\"0\",\"id\":183,\"event_id\":60,\"quantity\":200,\"ticket_type\":\"FREE\",\"description\":null,\"event_type\":\"Free\",\"selected\":1,\"attendees\":[{\"first_name\":null,\"last_name\":null,\"email\":null}]},{\"price\":\"200\",\"id\":184,\"event_id\":60,\"quantity\":198,\"ticket_type\":\"VIP\",\"description\":null,\"event_type\":\"Paid\",\"selected\":1,\"attendees\":[{\"first_name\":null,\"last_name\":null,\"email\":null}]},{\"price\":\"300\",\"id\":185,\"event_id\":60,\"quantity\":198,\"ticket_type\":\"V.VIP\",\"description\":null,\"event_type\":\"Paid\",\"selected\":2,\"attendees\":[{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null}]}]', 'COMPLETED', '800.00', NULL, 'asdf', 'asdf', 'sfs@sdf.sdf', '7ALCVXMPF2LFA', 0, 'paypal', NULL, NULL, '2019-08-05 10:27:10', '2019-08-05 10:28:24'),
(1052, 1318386355, 1, 60, 'sdf', 'sfa', 'sfs@sdf.sdf', 'sdf', 'sdfs', NULL, 'United States', 'District of Columbia', 'adfasdf', '23424', 'asdf', '[{\"price\":\"200\",\"id\":184,\"event_id\":60,\"quantity\":198,\"ticket_type\":\"VIP\",\"description\":null,\"event_type\":\"Paid\",\"selected\":5,\"attendees\":[{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null}]}]', 'pending', '1000.00', NULL, NULL, NULL, NULL, NULL, 0, '', NULL, NULL, '2019-08-05 10:56:03', '2019-08-05 10:56:03'),
(1053, 1297775463, 1, 60, 'fsadf', 'adsf', 'sfs@sdf.sdf', 'sdfsf', 'sdfs', NULL, 'United States', 'District of Columbia', 'adfasdf', '23424', 'sdf', '[{\"price\":\"200\",\"id\":184,\"event_id\":60,\"quantity\":198,\"ticket_type\":\"VIP\",\"description\":null,\"event_type\":\"Paid\",\"selected\":5,\"attendees\":[{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null}]}]', 'COMPLETED', '1000.00', NULL, 'Loveneet', 'Kumar', 'deanloveneet-buy-us@gmail.com', '9Y7QFCV9TC3TU', 0, 'paypal', NULL, NULL, '2019-08-05 10:59:08', '2019-08-05 11:00:15'),
(1054, 1339510330, 1, 57, 'safsdf', 'asdfadf', 'asdf@sdf.sdf', NULL, 'asdf', NULL, 'asdf', 'asdf', 'asdf', '23424', 'fasdf', '[{\"price\":\"100\",\"id\":61,\"event_id\":57,\"quantity\":23,\"ticket_type\":\"RSVP\",\"description\":null,\"event_type\":\"Paid\",\"selected\":2,\"attendees\":[{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null}]}]', 'COMPLETED', '200.00', NULL, 'sfsf', 'sdfsf', 'sfs@sdf.sdf', 'E3UV7XRQWVK8W', 0, 'paypal', NULL, NULL, '2019-08-07 07:03:46', '2019-08-07 07:06:20');

-- --------------------------------------------------------

--
-- Table structure for table `order_tickets`
--

CREATE TABLE `order_tickets` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `ticket_type` varchar(255) NOT NULL,
  `attendees` text,
  `event_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_tickets`
--

INSERT INTO `order_tickets` (`id`, `order_id`, `event_id`, `ticket_id`, `quantity`, `price`, `total_price`, `ticket_type`, `attendees`, `event_type`, `created_at`, `updated_at`) VALUES
(86, 1044, 60, 180, 3, '0.00', '0.00', 'FREE', '[{\"first_name\":\"sdfs\",\"last_name\":\"fsd\",\"email\":\"fsdfsd\"},{\"first_name\":\"fsdf\",\"last_name\":\"sfsd\",\"email\":\"fsdfs\"},{\"first_name\":\"fsdf\",\"last_name\":\"sdfsdf\",\"email\":\"sdfsfd\"}]', 'Free', '2019-08-02 12:27:07', '2019-08-02 12:27:07'),
(87, 1044, 60, 181, 4, '200.00', '800.00', 'VIP', '[{\"first_name\":\"sdf\",\"last_name\":\"sdf\",\"email\":\"sdfs\"},{\"first_name\":\"sdf\",\"last_name\":\"sdf\",\"email\":\"sdf\"},{\"first_name\":\"sdfsfd\",\"last_name\":\"sdfsdf\",\"email\":\"sdfsdf\"},{\"first_name\":\"sdfsdf\",\"last_name\":\"sfsdf\",\"email\":\"fsdf\"}]', 'Paid', '2019-08-02 12:27:07', '2019-08-02 12:27:07'),
(88, 1044, 60, 182, 2, '300.00', '600.00', 'V.VIP', '[{\"first_name\":\"sdfsd\",\"last_name\":\"fsfsdf\",\"email\":\"sdfsdf\"},{\"first_name\":\"sdfsdfsd\",\"last_name\":\"fsdfsdf\",\"email\":\"sdfsdf\"}]', 'Paid', '2019-08-02 12:27:07', '2019-08-02 12:27:07'),
(89, 1045, 60, 183, 2, '0.00', '0.00', 'FREE', '[{\"first_name\":\"vikas1\",\"last_name\":\"vikas1.1\",\"email\":\"vikas@vikas\"},{\"first_name\":\"vikas2\",\"last_name\":\"vikas2.1\",\"email\":\"vikas2@vikas\"}]', 'Free', '2019-08-05 06:24:20', '2019-08-05 06:24:20'),
(90, 1045, 60, 184, 3, '200.00', '600.00', 'VIP', '[{\"first_name\":\"vikas3\",\"last_name\":\"vikas3.1\",\"email\":\"vikas3@vikas\"},{\"first_name\":\"vikas4\",\"last_name\":\"vikas4.1\",\"email\":\"vikas4@vikas\"},{\"first_name\":\"vikas5\",\"last_name\":\"vikas5.1\",\"email\":\"vikas5@vikas\"}]', 'Paid', '2019-08-05 06:24:20', '2019-08-05 06:24:20'),
(91, 1045, 60, 185, 3, '300.00', '900.00', 'V.VIP', '[{\"first_name\":\"vikas6\",\"last_name\":\"vikas6.1\",\"email\":\"vikas6@vikas\"},{\"first_name\":\"vikas7\",\"last_name\":\"vikas7.1\",\"email\":\"vikas7@vikas\"},{\"first_name\":\"vikas8\",\"last_name\":\"vikas8.1\",\"email\":\"vikas8@vikas\"}]', 'Paid', '2019-08-05 06:24:20', '2019-08-05 06:24:20'),
(92, 1046, 60, 184, 5, '200.00', '1000.00', 'VIP', '[{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null}]', 'Paid', '2019-08-05 08:21:49', '2019-08-05 08:21:49'),
(93, 1046, 60, 185, 2, '300.00', '600.00', 'V.VIP', '[{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null}]', 'Paid', '2019-08-05 08:21:49', '2019-08-05 08:21:49'),
(94, 1047, 60, 184, 5, '200.00', '1000.00', 'VIP', '[{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null}]', 'Paid', '2019-08-05 08:25:27', '2019-08-05 08:25:27'),
(95, 1047, 60, 185, 2, '300.00', '600.00', 'V.VIP', '[{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null}]', 'Paid', '2019-08-05 08:25:27', '2019-08-05 08:25:27'),
(96, 1048, 60, 184, 5, '200.00', '1000.00', 'VIP', '[{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null}]', 'Paid', '2019-08-05 08:51:41', '2019-08-05 08:51:41'),
(97, 1048, 60, 185, 2, '300.00', '600.00', 'V.VIP', '[{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null}]', 'Paid', '2019-08-05 08:51:41', '2019-08-05 08:51:41'),
(98, 1049, 60, 184, 5, '200.00', '1000.00', 'VIP', '[{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null}]', 'Paid', '2019-08-05 10:00:21', '2019-08-05 10:00:21'),
(99, 1049, 60, 185, 2, '300.00', '600.00', 'V.VIP', '[{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null}]', 'Paid', '2019-08-05 10:00:21', '2019-08-05 10:00:21'),
(100, 1050, 60, 183, 1, '0.00', '0.00', 'FREE', '[{\"first_name\":null,\"last_name\":null,\"email\":null}]', 'Free', '2019-08-05 10:23:53', '2019-08-05 10:23:53'),
(101, 1050, 60, 184, 1, '200.00', '200.00', 'VIP', '[{\"first_name\":null,\"last_name\":null,\"email\":null}]', 'Paid', '2019-08-05 10:23:53', '2019-08-05 10:23:53'),
(102, 1050, 60, 185, 2, '300.00', '600.00', 'V.VIP', '[{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null}]', 'Paid', '2019-08-05 10:23:53', '2019-08-05 10:23:53'),
(103, 1051, 60, 183, 1, '0.00', '0.00', 'FREE', '[{\"first_name\":null,\"last_name\":null,\"email\":null}]', 'Free', '2019-08-05 10:27:11', '2019-08-05 10:27:11'),
(104, 1051, 60, 184, 1, '200.00', '200.00', 'VIP', '[{\"first_name\":null,\"last_name\":null,\"email\":null}]', 'Paid', '2019-08-05 10:27:11', '2019-08-05 10:27:11'),
(105, 1051, 60, 185, 2, '300.00', '600.00', 'V.VIP', '[{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null}]', 'Paid', '2019-08-05 10:27:11', '2019-08-05 10:27:11'),
(106, 1052, 60, 184, 5, '200.00', '1000.00', 'VIP', '[{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null}]', 'Paid', '2019-08-05 10:56:03', '2019-08-05 10:56:03'),
(107, 1053, 60, 184, 5, '200.00', '1000.00', 'VIP', '[{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null}]', 'Paid', '2019-08-05 10:59:08', '2019-08-05 10:59:08'),
(108, 1054, 57, 61, 2, '100.00', '200.00', 'RSVP', '[{\"first_name\":null,\"last_name\":null,\"email\":null},{\"first_name\":null,\"last_name\":null,\"email\":null}]', 'Paid', '2019-08-07 07:03:46', '2019-08-07 07:03:46');

-- --------------------------------------------------------

--
-- Table structure for table `orgnisars`
--

CREATE TABLE `orgnisars` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(200) NOT NULL,
  `mobile_number` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `cityLat` decimal(11,8) DEFAULT NULL,
  `cityLng` decimal(11,8) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `unique_url` varchar(255) DEFAULT NULL,
  `website` varchar(355) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fb_url` varchar(250) DEFAULT NULL,
  `skype_url` varchar(250) DEFAULT NULL,
  `insta_url` varchar(250) DEFAULT NULL,
  `about_organizer` varchar(250) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `twitter` varchar(255) DEFAULT NULL,
  `snapchat` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orgnisars`
--

INSERT INTO `orgnisars` (`id`, `full_name`, `first_name`, `last_name`, `email`, `mobile_number`, `location`, `cityLat`, `cityLng`, `password`, `unique_url`, `website`, `updated_at`, `deleted_at`, `is_delete`, `created_at`, `fb_url`, `skype_url`, `insta_url`, `about_organizer`, `status`, `twitter`, `snapchat`, `token`) VALUES
(2, 'fgfdg', 'fsdf', 'fdsfsd', 'rmousami@deaninfotech.com', NULL, NULL, NULL, NULL, '123456', NULL, NULL, '2019-05-03 07:21:13', NULL, 0, '0000-00-00 00:00:00', 'http://', 'skype.yfguysdgf746237468', 'http://Instagram.com/instagram', 'gfdgdfg', 1, 'http://twitter.com/twitter', 'https://Snapchat.com/snapmelly', ''),
(6, 'Test Organizer', 'Test', 'Organizer', 'test@gmail.com', '8707817505', 'gtrhr', NULL, NULL, '12345', 'www.decipher.com', 'tert', '2019-06-18 07:25:01', NULL, 0, '0000-00-00 00:00:00', 'www.facebook.com', NULL, 'www.instagram.com', 'Test Organizer11233', 0, 'www.twitter.com', 'www.snapchat.com', 'yGNHk5Zh0VgqeWuM8SGjufeHUo88prIH'),
(7, 'Rishikesh Singh', 'Rishikesh', 'Singh', 'rishikeshdean@gmail.com', '8423319130', 'New Delhi', NULL, NULL, '123456', 'www.decipher.com', 'www.mywebsite.com', '2019-07-18 12:42:45', NULL, 0, '2019-03-27 18:03:37', 'http://facebbok.com', NULL, 'http://www.instagram.com', 'I am developer, I\'ve no life', 0, 'http://www.twitter.com1', 'http://www.snapchat.com', 'mxmH78IuaedKc4Zoiaq1dOLAYbf1uRGv'),
(16, 'Rishikesh Singh', 'Prince', 'Singh', 'neeraj@gmail.com', '8423319133', 'sdfsdf', NULL, NULL, '12345', 'Test.com', NULL, NULL, NULL, 0, '2019-03-25 16:46:36', 'www.facebook.com', NULL, 'www.instagram.com', 'dsadsad', 1, NULL, 'www.snapchat.com', NULL),
(21, 'Rishikesh Singh', 'Rahul', 'Singh', 'asdjas@gmail.com', '8423319130', 'ffsdf', NULL, NULL, '12345', 'dsfsdf', NULL, NULL, NULL, 0, '2019-03-25 17:05:09', 'dsfsdf', NULL, 'dsfdsfsdf', 'dsfsdf', 1, NULL, 'sdfsdfdsf', NULL),
(28, 'test', 'testfirst', 'testlast', 'testfirst@gmail.com', '1233545677', 'location', NULL, NULL, '123456', 'unq.com', 'www.firsttest.com', '2019-03-26 14:47:45', NULL, 0, '2019-03-26 14:31:54', 'facebook.com', NULL, 'insta.com', 'test orgwqw', 0, NULL, 'snap.com', NULL),
(29, 'organiser name (Cipher Entertainments', 'Babajide', 'Cipher', 'testfirstgred@gmail.com', '12345678', 'ewrfew', NULL, NULL, '123456', 'fds', 'ferfrr', '2019-03-28 16:25:32', NULL, 0, '2019-03-26 14:37:48', 'fds', NULL, 'fsd', 'fds', 0, NULL, 'fds', NULL),
(31, 'rfwerw', 'rwer', 'rewrewr', 'testfirsyuuyt55t@gmail.com', '1234567', 'df', NULL, NULL, '123456gsdf', 'dgfd', 'bfdgd', '2019-03-26 14:39:32', NULL, 0, '2019-03-26 14:39:23', 'efsde', NULL, 'gfd', 'fdgd', 1, NULL, 'fd', NULL),
(32, 'Rishikesh Singh', 'Rahul', 'Singh', 'rishikeshdean@gmail.com1', '8423319130', 'jdhkjdfhskf', NULL, NULL, '12345', 'www.decipher.com', 'www.myoffice.com', '2019-03-26 17:46:48', NULL, 0, '2019-03-26 15:56:52', 'facebbok.hfsdfsdf8787fdsf4ds', NULL, 'www.instagram.com', 'fsdfsdfsdf', 0, 'www.twitter.com', 'www.snapchat.com', NULL),
(33, 'new organizerdfgd', 'newfdsf', 'organizerfds', 'neworganizer@gmail.comfsd', '123456789781223', 'locationff', NULL, NULL, '123456', 'uq.comfds', 'new.comfdsf', '2019-03-28 16:26:57', NULL, 0, '2019-03-26 17:48:58', 'fb.comfe', NULL, 'int.comfds', 'new orgfds', 0, 'twit.comdfs', 'snp.comfds', NULL),
(34, 'test123`', 'tuybj', 'hujhguhj', 'fjkdsj@gmail.com', '123467789', 'kjfkjhdsk', NULL, NULL, '123456', 'jiji', 'hiuhi.com', '2019-03-27 09:55:15', NULL, 0, '2019-03-27 09:52:46', 'oijioj', NULL, 'kkjk', 'kjkkj', 0, 'jkhj', 'kjk', NULL),
(36, 'Test With google api Location', 'Rishikesh', 'Singh', 'Rk@gmail.com', '8423319130', 'Test Yantra Software Solutions India Pvt Ltd, Gandhi Bazaar, Basavanagudi, Bengaluru, Karnataka, India', NULL, NULL, '12345', 'fgjsgdfjgf', 'www.myoffice.com', NULL, NULL, 0, '2019-03-29 11:45:17', 'www.facebook.com', NULL, 'insta.hgfhdgsfjg874', 'fffsfsdf', 1, 'www.twitter.com', 'www.snapchat.com', NULL),
(37, 'test april df', 'april', 'test', 'testapril@gmail.com', '1234567898', 'test april', NULL, NULL, '123456', 'url.com', 'ww.testapril.com', '2019-06-19 07:18:50', NULL, 0, '2019-04-11 11:20:47', 'http://fb.com', NULL, 'http://insta.com', 'april organizer', 1, 'http://twt.com', 'http://snp.com', 'hnByT9KtskDuodsPiXtMh4K2vJV9C0nO');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promoters`
--

CREATE TABLE `promoters` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(200) NOT NULL,
  `mobile_number` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `cityLat` decimal(11,8) DEFAULT NULL,
  `cityLng` decimal(11,8) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `unique_url` varchar(255) DEFAULT NULL,
  `website` varchar(355) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `fb_url` varchar(250) DEFAULT NULL,
  `skype_url` varchar(250) DEFAULT NULL,
  `insta_url` varchar(250) DEFAULT NULL,
  `about_promoter` varchar(250) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `twitter` varchar(255) DEFAULT NULL,
  `snapchat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `promoters`
--

INSERT INTO `promoters` (`id`, `full_name`, `first_name`, `last_name`, `email`, `mobile_number`, `location`, `cityLat`, `cityLng`, `password`, `unique_url`, `website`, `updated_at`, `deleted_at`, `is_delete`, `created_at`, `fb_url`, `skype_url`, `insta_url`, `about_promoter`, `status`, `twitter`, `snapchat`) VALUES
(1, 'Rishikesh Singh', 'Rahul', 'Singh', 'admin@gmail.com', '8423319133', 'sdfsdf', NULL, NULL, '12345', 'Test.com', 'https://rishikesh.info', '2019-03-27 11:25:01', NULL, 0, '0000-00-00 00:00:00', 'guwygfywgefu', NULL, 'Instaa.com', 'test Promoter', 1, 'dsfdsaf', '.comeygyeg'),
(2, 'test promoter', 'test', 'promoter', 'test@promoter.com', '12345678978', 'test location', NULL, NULL, '12345678', 'www.test.com', 'Test Website', '2019-03-26 15:10:20', NULL, 1, '0000-00-00 00:00:00', 'test.facebook', NULL, 'insta.com', NULL, 1, 'twitter.com', 'snap.com'),
(3, 'promoter Friday', 'promoter', 'friday', 'fpromoter@gmail.com', '12354567879', 'friday location', NULL, NULL, '123456', 'unique url', NULL, '2019-03-25 09:59:39', NULL, 1, '0000-00-00 00:00:00', 'facebook.com', NULL, 'instagram.com', 'friday promoter', 1, NULL, 'snapchat.com'),
(4, 'Rishikesh Singh', 'Rahul', 'Singh', 'neeraj@gmail.com', '8423319130', 'New Delhi', NULL, NULL, '12345', 'www.decipher.com', NULL, '2019-03-27 11:21:05', NULL, 1, '2019-03-23 15:34:09', 'www.facebook.com', NULL, 'www.instagram.com', 'sdfdsf', 0, NULL, 'www.snapchat.com'),
(5, 'jhgjhg', 'hg', 'hgjh', 'gh@qrg.com', 'gjh', 'jhg', NULL, NULL, 'jhg', 'jhg', NULL, '2019-03-25 15:22:08', NULL, 1, '2019-03-25 15:21:02', 'jhg', NULL, 'jhg', 'gjh', 1, NULL, 'jhgjh'),
(6, 'kjhjklkljklj', 'kljkl', 'jklj', 'kljkl@gmail.com', 'jkl', 'klj', NULL, NULL, 'jklj', 'klj', NULL, '2019-03-25 15:22:12', NULL, 1, '2019-03-25 15:21:26', 'klj', NULL, 'klj', 'klj', 1, NULL, 'klj'),
(7, 'Rishikesh Singh', 'Rahul', 'gfhfghfg', 'admin@gmail1.com', '8423319130', NULL, NULL, NULL, '12345', NULL, 'www.myoffice.com', '2019-03-27 11:19:00', NULL, 0, '2019-03-26 09:47:04', NULL, NULL, NULL, NULL, 0, NULL, NULL),
(8, 'ggy', 'uyg', 'yguy', 'veer@gmail.com1', 'gyg', 'yg', NULL, NULL, 'yg', 'yg', 'yg', '2019-03-26 10:02:28', NULL, 1, '2019-03-26 10:01:51', 'yg', NULL, 'yg', NULL, 1, NULL, 'yg'),
(9, 'promoter', 'first promoter', 'last promiter', 'firstpromoter@gmail.com', '1234567878', 'location', NULL, NULL, '123456', 'unq.com', 'www.promoter.com', '2019-03-26 15:09:50', NULL, 0, '2019-03-26 15:06:17', 'facebook.com', NULL, 'insta.com', 'ede', 1, NULL, 'snap.com'),
(10, 'efsdf', 'fds', 'fds', 'testfirfsdst@gmail.com', '23456788', 'fcdsvd', NULL, NULL, '123456', 'vcx', 'cdvds', '2019-03-29 11:07:32', NULL, 1, '2019-03-26 15:11:24', 'vdc', NULL, 'vcx', 'vvcx', 1, NULL, 'vxc'),
(11, 'fsdfs', 'fsdfd', 'fdsfs', 'testffsdfsirst@gmail.com', '2134567', 'dsadsa', NULL, NULL, '123456', 'dasda', 'dsada', '2019-03-26 15:14:57', NULL, 0, '2019-03-26 15:11:54', 'dasd', NULL, 'dasda', 'dsadsa', 0, NULL, 'dasd'),
(12, 'dss', 'fdsf', 'fdsfs', 'testfirfdsst@gmail.com', '123456789', 'fdsfsf', NULL, NULL, '123456', 'fdsf', 'axdxsaf', '2019-03-29 11:15:11', NULL, 1, '2019-03-26 15:15:51', 'fdsf', NULL, 'fds', 'fsdf', 0, NULL, 'fddfs'),
(13, 'derewrw', 'fewf', 'fewf', 'testdcscsfirst@gmail.com', '123453555', 'fdsfdf', NULL, NULL, '123456', 'gdfgfd', 'fdsfs', NULL, NULL, 0, '2019-03-26 15:16:17', 'gfdgdfg', NULL, 'gfdgd', 'gfdgdfgfd', 1, NULL, 'ggfdgd'),
(14, 'vdfgfd', 'gdfgdf', 'gdfg', 'testfircvsdast@gmail.com', '12345678', 'fdsfds', NULL, NULL, '123456', 'fsdf', 'dasda', NULL, NULL, 0, '2019-03-26 15:16:42', 'fds', NULL, 'fsdf', 'dfssfd', 1, NULL, 'fdsf'),
(15, 'ewewe', 'dsfds', 'fdfd', 'fdsdtestfirst@gmail.com', '12345678', 'sdsdsd', NULL, NULL, '123456', 'ds', 'dsads', '2019-03-26 15:19:28', NULL, 1, '2019-03-26 15:17:07', 'dsd', NULL, 'dfs', 'hjghjk', 1, NULL, 'dsds'),
(16, 'oiojj', 'lkjjkjk', 'lkjljj', 'nkntestfirst@gmail.com', '123456732', NULL, NULL, NULL, '123456', 'gfd', 'dfredf', '2019-03-26 15:19:16', NULL, 1, '2019-03-26 15:17:28', 'gdfg', NULL, 'gfd', 'gdfgffgf', 0, NULL, 'gdf'),
(17, 'grdg', 'gfg', 'gfdgf', 'testfirst@gmail.comdsadsa', '123456789', 'fdgf', NULL, NULL, '123456', 'gfdgd', 'cdsfsf', '2019-03-28 11:33:42', NULL, 1, '2019-03-26 15:18:15', 'gfdgd', NULL, 'gfdg', 'fdfd', 1, 'dsfdsaf1', 'fgd'),
(18, 'jk', 'j', 'jhg', 'hj@gmail.com', '8423319130', 'New Delhi', NULL, NULL, '12345', 'www.decipher.com', 'www.myoffice.com', '2019-03-27 18:07:48', NULL, 1, '2019-03-27 18:07:36', 'www.facebook.com', NULL, 'www.instagram.com', 'fdsfsdffds', 1, 'www.twitter.com1', 'www.snapchat.com'),
(19, 'promoter', 'promoter', 'promoter', 'promoter@gmail.com', '12365677671', 'location.com', NULL, NULL, '123456', 'unq.com', 'www.testpromoter.com', '2019-03-28 11:34:24', NULL, 0, '2019-03-28 11:28:57', 'faceook.com', NULL, 'inst.com', 'test promoter...', 0, 'twt.com', 'snp.com');

-- --------------------------------------------------------

--
-- Table structure for table `promotion_request`
--

CREATE TABLE `promotion_request` (
  `id` int(11) NOT NULL,
  `organizer_id` int(11) NOT NULL,
  `promoter_id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `request_type` varchar(191) NOT NULL,
  `request_status` varchar(191) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `promotion_request`
--

INSERT INTO `promotion_request` (`id`, `organizer_id`, `promoter_id`, `event_id`, `request_type`, `request_status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 9, 13, 27, 'promotion', 'accepted', '2019-06-07 15:58:51', '2019-06-07 17:45:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shoping_cart`
--

CREATE TABLE `shoping_cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `craeted_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `tag` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `tag`, `created_at`, `updated_at`) VALUES
(1, 'Tag', '2019-07-25 12:25:26', '2019-07-25 12:25:26'),
(2, 'Tag2', '2019-07-25 12:25:34', '2019-07-25 12:25:34'),
(3, 'Tag3', '2019-07-25 12:25:42', '2019-07-25 12:25:42');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(200) NOT NULL,
  `mobile_number` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `cityLat` decimal(11,8) DEFAULT NULL,
  `cityLng` decimal(11,8) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `unique_url` varchar(255) DEFAULT NULL,
  `roles` varchar(30) DEFAULT NULL,
  `website` varchar(355) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `fb_url` varchar(250) DEFAULT NULL,
  `skype_url` varchar(250) DEFAULT NULL,
  `insta_url` varchar(250) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `twitter` varchar(255) DEFAULT NULL,
  `snapchat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `full_name`, `first_name`, `last_name`, `email`, `mobile_number`, `location`, `cityLat`, `cityLng`, `password`, `unique_url`, `roles`, `website`, `updated_at`, `deleted_at`, `is_delete`, `created_at`, `fb_url`, `skype_url`, `insta_url`, `status`, `twitter`, `snapchat`) VALUES
(1, 'Rahul', 'Rishikesh', 'Singh', 'admin@gmail.com', '8465625449', NULL, NULL, NULL, '12345', 'www.uniqueurl.com', '1,2,3,4,5', 'www.webpage.com', '2019-03-28 12:11:49', NULL, 1, '0000-00-00 00:00:00', NULL, NULL, NULL, 0, NULL, NULL),
(2, 'Rishikesh Singh', 'Rahul', 'Singh', 'rahul@gmail.com', '8423319130', NULL, NULL, NULL, '12345', NULL, '2', NULL, '2019-03-28 09:21:49', NULL, 1, '0000-00-00 00:00:00', NULL, NULL, NULL, 1, NULL, NULL),
(3, 'Vikash Pandey', 'Vikash', 'pandey', 'rishikesh@apptology.in', '8423319130', NULL, NULL, NULL, '12345', NULL, '2,3,4', NULL, '2019-03-28 09:15:17', NULL, 1, '0000-00-00 00:00:00', NULL, NULL, NULL, 1, NULL, NULL),
(4, 'Rishikesh Singh', 'Rahul', 'Singh', 'neeraj@gmail.com', '8423319133', NULL, NULL, NULL, '121345', NULL, '2,3,4,5', NULL, '2019-03-28 09:21:40', NULL, 1, '0000-00-00 00:00:00', NULL, NULL, NULL, 1, NULL, NULL),
(5, 'Rishikesh Singh', 'Rahul', 'Singh', 'admin@gmail.com1', '8423319133', NULL, NULL, NULL, '12345', NULL, NULL, NULL, '2019-03-28 11:19:25', NULL, 1, '0000-00-00 00:00:00', NULL, NULL, NULL, 1, NULL, NULL),
(6, 'Rishikesh Singh', 'Rishikesh', 'Singh', 'neeraj@gmail.com1', '8423319130', NULL, NULL, NULL, '12345', NULL, NULL, NULL, '2019-03-28 11:20:37', NULL, 1, '0000-00-00 00:00:00', NULL, NULL, NULL, 1, NULL, NULL),
(8, 'march user', 'march', 'user', 'marchuser@gmail.com', '1234567899', NULL, NULL, NULL, '123456', NULL, '1,2', NULL, '2019-03-28 11:20:11', NULL, 1, '2019-03-28 09:19:06', NULL, NULL, NULL, 1, NULL, NULL),
(35, 'Rishikesh Singh', 'Prince', 'dsadasd', 'srishikesh@deaninfotech.com', '8423319130', NULL, NULL, NULL, '12345', NULL, '2,3,4,5', NULL, '2019-06-18 12:56:00', NULL, 0, '2019-03-27 10:58:31', NULL, NULL, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` int(10) DEFAULT NULL COMMENT '1:user 2:organizer 3:promoters',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_confirm` int(1) NOT NULL,
  `email_confirm_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `about_organizer` text COLLATE utf8mb4_unicode_ci,
  `mobile_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` text COLLATE utf8mb4_unicode_ci,
  `cityLat` decimal(10,8) DEFAULT NULL,
  `cityLng` decimal(10,8) DEFAULT NULL,
  `unique_url` text COLLATE utf8mb4_unicode_ci,
  `roles` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fb_url` text COLLATE utf8mb4_unicode_ci,
  `insta_url` text COLLATE utf8mb4_unicode_ci,
  `snapchat` text COLLATE utf8mb4_unicode_ci,
  `twitter` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`, `remember_token`, `created_at`, `updated_at`, `first_name`, `last_name`, `email_confirm`, `email_confirm_code`, `about_organizer`, `mobile_number`, `location`, `cityLat`, `cityLng`, `unique_url`, `roles`, `website`, `fb_url`, `insta_url`, `snapchat`, `twitter`) VALUES
(7, NULL, 'rishikeshdean@gmail.com', '$2y$10$diGZTdGGPYGxM90SSic6w.5qptrSe1aR5GKDc7vzeD0WUsXPJvv3u', 2, 'Uqmthyu1NsTCefLUU7COYiA9SVaorbJYxiQGonwO6ey8H5F1Vz1v5bNkCOYO', '2019-05-06 00:44:10', '2019-05-06 01:23:54', 'Rishikesh', 'singh', 1, '', NULL, NULL, 'New Delhi', NULL, NULL, 'www.facebook.com', NULL, NULL, 'http://www.facebook.com', 'http://www.instagram.com', 'http://www.snapchat.com', 'http://www.twitter.com'),
(8, NULL, 'rishikeshdean@gmail1.com', '$2y$10$diGZTdGGPYGxM90SSic6w.5qptrSe1aR5GKDc7vzeD0WUsXPJvv3u', 1, NULL, '2019-05-06 00:44:10', '2019-05-06 01:23:54', 'Rishikesh', 'singh', 1, '', NULL, NULL, 'New Delhi', NULL, NULL, 'www.facebook.com', NULL, NULL, 'http://www.facebook.com', 'http://www.instagram.com', 'http://www.snapchat.com', 'http://www.twitter.com'),
(9, NULL, 'deanloveneet@gmail.com', '$2y$10$Xb6g2m.Cn3msKw0PI2YZN.HPUHb/iCYtvcLjDiqr.i4sQzSShmjym', 2, 'uTLkrmakt7cVp0hDbAhPsza9hxPwxKDtB5HNXPUIGM8rrGGYpIj32edTDjvv', '2019-05-30 04:51:41', '2019-07-04 13:08:52', 'loveneet', 'kumar', 1, '', 'I am Programmer, I\'m super lazy', '1234567891', 'New Delhi', NULL, NULL, 'www.facebook.com', NULL, 'www.mybloggingwebsite.com', 'http://www.facebook.com', 'http://www.instagram.com', 'http://www.snapchat.com', 'http://www.twitter.com'),
(12, NULL, 'vikas@gmail.com', '$2y$10$AHx1jbT9khFlQTlxak9ILuSC7QOwF4ADh1bV2VRsmMHwmNfFwk8zu', 2, NULL, '2019-05-31 11:23:19', '2019-05-31 11:30:00', 'Vikas', 'Kumar', 1, '', NULL, NULL, 'New Delhi', '28.70406000', '28.70406000', 'www.facebook.com', NULL, NULL, NULL, NULL, NULL, NULL),
(13, NULL, 'rocketsingh@gmail.com', '$2y$10$VrFwR0jMTJL.SOc5tNopU.gtv5piMtSMTm3ollVUo4Hnsql5sjj/u', 2, NULL, '2019-06-07 09:00:37', '2019-06-10 09:06:02', 'Rocket', 'Singh', 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, NULL, 'bestpromoter@gmail.com', '$2y$10$TPZROANdLNY4apbpINIwmeWOi/UxWAVFUv2p46SpAlSDaCM2G/Cta', 3, NULL, '2019-06-10 09:02:54', '2019-06-10 09:02:54', 'promoter', 'best', 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, NULL, 'loveneet@gmail.com', '$2y$10$kXNwDvCog9RBsP6cwTtzMead9pPTUdSII9eDvzPdLmAa9ateUhmhu', 1, 'fPrTaAvy6dr0DvjxzHj3jbITzooDxvHFzuZOlRVacx22jGKVysDnEN0Mt1Pk', '2019-06-11 08:34:04', '2019-06-24 12:50:32', 'loveneet', 'kumar', 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, NULL, 'test@gmail.com', '$2y$10$ueen1XBpO8NM9sxm15atROXr//tSbAJlxevLaX5VIExdfNbPVWKhC', 1, NULL, '2019-06-24 12:11:33', '2019-06-25 09:25:49', 'test', 'testing', 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, NULL, 'egob@o.spamtrap.ro', '$2y$10$V1EKQvi/kQ/aga95134cPuhaZfMabNr4jpdlpDBpDU84c76ydjkYO', 1, NULL, '2019-06-25 05:54:58', '2019-06-25 05:55:41', 'firstname', 'lastname', 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, NULL, 'rurc@laoho.com', '$2y$10$9YkwP9hzFKfTClcsg48zve.TFBQQ2QncUqtJp/QfaaPEPLnCm0xoq', 1, 'ttbM2RqcSOrQWbKjiGB5TRjfBgg4RmqxY34hTwBX6Yekj3zNXvu2eZxQyNma', '2019-06-25 05:58:13', '2019-06-25 11:09:54', 'addf', 'asdf', 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_bank_account`
--

CREATE TABLE `user_bank_account` (
  `id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `bank_currency` varchar(255) NOT NULL,
  `bank_phone_no` varchar(255) NOT NULL,
  `routing_number` varchar(255) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_bank_account`
--

INSERT INTO `user_bank_account` (`id`, `user_id`, `bank_name`, `account_name`, `account_number`, `bank_currency`, `bank_phone_no`, `routing_number`, `updated_at`, `created_at`, `deleted_at`) VALUES
(2, 7, 'ICICI', 'Rishikeshn singh1234567', '3802020104564674', 'CAD', '8423876545', '4546549874654656', '2019-07-17 07:01:37', NULL, NULL),
(3, 7, 'asdfasf', 'Rishikesh Singh Rajput', '233184651564', 'USD', '95989095665', 'TDSD', '2019-07-16 13:19:51', NULL, NULL),
(4, 7, 'HDFC', 'Rishikesh singh44', '7465654987469', 'EUR', '9598088162', '65564564', '2019-07-17 06:47:17', NULL, NULL),
(7, 9, 'asdf', 'asdf', 'asdf', 'USD', 'asdf', 'asdf', NULL, '2019-07-24 10:19:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_paypal_account`
--

CREATE TABLE `user_paypal_account` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `paypal_email` varchar(255) NOT NULL,
  `name_paypal` varchar(255) NOT NULL,
  `pay_pal_phone_no` varchar(255) NOT NULL,
  `pay_pal_currency` varchar(255) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_paypal_account`
--

INSERT INTO `user_paypal_account` (`id`, `user_id`, `paypal_email`, `name_paypal`, `pay_pal_phone_no`, `pay_pal_currency`, `updated_at`, `created_at`) VALUES
(1, 13, 'paypal@gmail.com', 'Test Paypal', '9178256466', 'USD', NULL, NULL),
(2, 2, 'singhrisgh@gmail.com', 'Rishikesh singh', '8845456454', 'CAD', NULL, NULL),
(3, 7, 'singhrishikesh67@gmail.com', 'Rishikesh singh', '8421361191', 'USD', '2019-07-16 13:26:21', '2019-05-06 03:38:58'),
(6, 7, 'test@testemail.com', 'SBI', '123456987', 'USD', '2019-07-17 07:24:08', '2019-07-16 12:52:29'),
(7, 7, 'asdfasf@sf.sdfasf', 'asdfasdf', 'asdfasf', 'GBP', NULL, '2019-07-16 12:52:39'),
(8, 9, 'asdfasf@sdflj.sldf', 'asdfasf', 'asdf', 'CAD', NULL, '2019-07-24 10:13:47'),
(10, 9, 'asdfasf@sdf.df', 'asdfasf', 'asdfsf', 'CAD', NULL, '2019-07-24 10:23:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cartitems`
--
ALTER TABLE `cartitems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_pages`
--
ALTER TABLE `cms_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupon` (`coupon`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `event_url` (`event_url`),
  ADD KEY `event_category` (`category_id`),
  ADD KEY `organizer_id` (`organizer_id`),
  ADD KEY `cityLat` (`cityLat`,`cityLng`);

--
-- Indexes for table `event_attendee`
--
ALTER TABLE `event_attendee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_category`
--
ALTER TABLE `event_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_mages`
--
ALTER TABLE `event_mages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_plans`
--
ALTER TABLE `event_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_subcategory`
--
ALTER TABLE `event_subcategory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `event_ticket`
--
ALTER TABLE `event_ticket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `follow`
--
ALTER TABLE `follow`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `helpdesk`
--
ALTER TABLE `helpdesk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `helpdesk_category`
--
ALTER TABLE `helpdesk_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `helpdesk_images`
--
ALTER TABLE `helpdesk_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_reserved_at_index` (`queue`,`reserved_at`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `barcode` (`barcode`);

--
-- Indexes for table `order_tickets`
--
ALTER TABLE `order_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orgnisars`
--
ALTER TABLE `orgnisars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `promoters`
--
ALTER TABLE `promoters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promotion_request`
--
ALTER TABLE `promotion_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shoping_cart`
--
ALTER TABLE `shoping_cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_bank_account`
--
ALTER TABLE `user_bank_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_paypal_account`
--
ALTER TABLE `user_paypal_account`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cartitems`
--
ALTER TABLE `cartitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `cms_pages`
--
ALTER TABLE `cms_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `coupon`
--
ALTER TABLE `coupon`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `event_attendee`
--
ALTER TABLE `event_attendee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `event_category`
--
ALTER TABLE `event_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `event_mages`
--
ALTER TABLE `event_mages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT for table `event_plans`
--
ALTER TABLE `event_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `event_subcategory`
--
ALTER TABLE `event_subcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `event_ticket`
--
ALTER TABLE `event_ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=208;

--
-- AUTO_INCREMENT for table `follow`
--
ALTER TABLE `follow`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `helpdesk`
--
ALTER TABLE `helpdesk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `helpdesk_category`
--
ALTER TABLE `helpdesk_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `helpdesk_images`
--
ALTER TABLE `helpdesk_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1055;

--
-- AUTO_INCREMENT for table `order_tickets`
--
ALTER TABLE `order_tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `orgnisars`
--
ALTER TABLE `orgnisars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `promoters`
--
ALTER TABLE `promoters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `promotion_request`
--
ALTER TABLE `promotion_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shoping_cart`
--
ALTER TABLE `shoping_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `user_bank_account`
--
ALTER TABLE `user_bank_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_paypal_account`
--
ALTER TABLE `user_paypal_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event_subcategory`
--
ALTER TABLE `event_subcategory`
  ADD CONSTRAINT `event_subcategory_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `event_category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
