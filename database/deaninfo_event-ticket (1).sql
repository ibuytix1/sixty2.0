-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2019 at 09:08 AM
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
  `ticket_type` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cartitems`
--

INSERT INTO `cartitems` (`id`, `user_id`, `ticket_id`, `quantity`, `price`, `ticket_type`, `created_at`, `updated_at`) VALUES
(2, 6, 12, 80, '200', 2, '2019-05-22 18:27:41', '2019-05-22 18:27:41'),
(3, 7, 12, 80, '200', 2, '2019-05-22 18:34:36', '2019-05-22 18:34:36'),
(4, 7, 13, 80, '200', 2, '2019-05-22 18:36:38', '2019-05-22 18:36:38');

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
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `event_id` int(11) NOT NULL,
  `organizer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `first_name`, `last_name`, `email`, `create_at`, `updated_at`, `event_id`, `organizer_id`) VALUES
(1, 'Dean', 'test_last', 'atest@gmail.com', '2019-04-08 05:30:34', '2019-04-08 10:30:34', 7, 35),
(2, 'Dean Infotech', 'test_last', 'test@gmail.com', '2019-04-04 11:37:47', '2019-04-04 06:07:47', 17, 35),
(6, 'test', 'test_last', 'test@gmail.com', '2019-04-04 07:21:32', NULL, 17, 35),
(7, 'test', 'test_last', 'test@gmail.com', '2019-04-04 07:21:32', NULL, 17, 35),
(8, 'Dean Infotech', 'test_last', 'adean@gmail.com', '2019-04-05 04:37:20', '2019-04-05 09:37:20', 17, 35),
(9, 'test', 'test_last', 'test@gmail.com', '2019-04-05 09:40:28', NULL, 7, 35),
(11, 'test', 'test_last', 'test@gmail.com', '2019-04-05 09:40:28', NULL, 7, 35),
(12, 'Rishikesh', 'Singh', 'rishikeshdean@gmail.com', '2019-04-05 11:32:13', '2019-04-05 16:32:13', 7, 35),
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
(44, 'test', 'test_last', 'rishikeshdean@gmail.com', '2019-05-13 09:47:15', NULL, 20, 20);

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
(1, 7, 'Rishikesh', 'Rishikesh', '2019-05-06', '2019-05-14', '12:59:00', '11:59:00', 25, 35, 25.00, 'amt', 1, '2019-05-14 10:37:33'),
(2, 7, 'Rishikesh Singh', 'Test Description', '2019-05-06', '2019-05-14', '12:59:00', '13:59:00', 25, 6, 25.00, 'amt', 1, '2019-05-08 09:47:58');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `organizer_id` int(11) NOT NULL,
  `event_title` varchar(255) NOT NULL,
  `event_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `event_description` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `event_url` varchar(255) NOT NULL,
  `event_tags` varchar(255) DEFAULT NULL,
  `event_location` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `address_2` varchar(255) NOT NULL,
  `start_date` date DEFAULT NULL,
  `start_time` time NOT NULL,
  `end_date` date DEFAULT NULL,
  `end_time` time NOT NULL,
  `event_recurring` tinyint(1) DEFAULT NULL COMMENT '0=Free,1=Paid,2=Donation',
  `event_occurrence_type` varchar(255) DEFAULT NULL,
  `occurrence_start_time` time DEFAULT NULL,
  `occurrence_end_time` time DEFAULT NULL,
  `occurrence_off_the_day` text,
  `occurrence_from_date` timestamp NULL DEFAULT NULL,
  `occurence_to_date` timestamp NULL DEFAULT NULL,
  `show_no_of_available_tickets` tinyint(4) DEFAULT NULL,
  `refund_policy` int(11) DEFAULT NULL COMMENT '1=no refund 2=A day before 3=A week before',
  `parking` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=Yes 0=No',
  `wheelchair` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=Yes 0=No',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `is_private` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=active 0=inactive',
  `other_information` varchar(255) DEFAULT NULL,
  `aditional_information` varchar(40) DEFAULT NULL COMMENT '1=Alcohol , 2= ID card , 3=Children , 4=18+ , 5=Parking , 6=Wheelchair , 7=Casual , 8=Corporate Dressing , 9=Early Check-in',
  `cityLat` decimal(11,8) DEFAULT NULL,
  `cityLng` decimal(11,8) DEFAULT NULL,
  `event_status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `organizer_id`, `event_title`, `event_date`, `event_description`, `category_id`, `subcategory_id`, `event_url`, `event_tags`, `event_location`, `address`, `address_2`, `start_date`, `start_time`, `end_date`, `end_time`, `event_recurring`, `event_occurrence_type`, `occurrence_start_time`, `occurrence_end_time`, `occurrence_off_the_day`, `occurrence_from_date`, `occurence_to_date`, `show_no_of_available_tickets`, `refund_policy`, `parking`, `wheelchair`, `created_at`, `updated_at`, `is_delete`, `is_private`, `status`, `other_information`, `aditional_information`, `cityLat`, `cityLng`, `event_status`) VALUES
(4, 35, 'Abhishek', '2019-05-21 11:08:37', 'test', 1, 2, 'http://thanksgivingdayusa.com/d2/dev/DeCipher/Organizer/createEvent', NULL, 'dsfds', 'cxvxcvcx, Plac Kupiecki, Brzesko, Poland', 'Locarion', '2017-05-21', '00:00:00', '2019-05-21', '00:00:00', 0, 'Select', NULL, NULL, NULL, '2019-03-29 05:00:00', '2019-03-29 05:00:00', 0, 1, 0, 0, '2019-03-29 13:05:30', '2019-03-29 18:06:34', 0, 0, 1, 'TEst Information', '1,2,3', NULL, NULL, 1),
(6, 35, 'Test Event', '2019-05-21 09:42:05', 'Test Description', 1, 2, 'http://thanksgivingdayusa.com/d2/dev/DeCipher/Organizer/createEvent', NULL, 'USA', 'Testour, Tunisia', 'dfsdhfjdsfkjsdhf', '2019-05-21', '00:00:00', '2019-05-21', '00:00:00', 0, 'Select', NULL, NULL, NULL, '2019-04-03 05:00:00', '2019-04-03 05:00:00', 0, 1, 0, 0, '2019-04-03 11:30:25', '2019-04-03 18:05:36', 0, 0, 1, 'Test Information', '1,2,3,8', NULL, NULL, 1),
(7, 35, 'Dean Event', '2019-05-21 09:39:15', 'Test Description', 1, 3, 'http://thanksgivingdayusa.com/d2/dev/DeCipher/Organizer/createEvent', NULL, 'Barahani', 'Testour, Tunisia', 'Locarion', '2019-06-11', '00:00:00', '2019-06-25', '00:00:00', NULL, 'Select', NULL, NULL, NULL, '2019-04-05 04:39:25', '2019-04-05 04:39:25', NULL, 1, 0, 0, '2019-04-05 04:39:25', NULL, 0, 0, 1, 'TEst Information', '1,2', NULL, NULL, 1),
(8, 35, 'Test Event', '2019-05-21 09:39:28', 'Test Description', 1, 2, 'http://thanksgivingdayusa.com/d2/dev/DeCipher/Organizer/createEvent', NULL, 'Barahani', 'Testarossa Winery, College Avenue, Los Gatos, CA, USA', 'Delhi', '2019-06-12', '00:00:00', '2019-06-25', '00:00:00', 0, 'Select', NULL, NULL, NULL, '2019-04-08 05:00:00', '2019-04-08 05:00:00', 0, 1, 0, 0, '2019-04-08 05:45:48', '2019-04-08 15:25:42', 0, 0, 1, 'Test Information', '1,2,3', NULL, NULL, 2),
(9, 35, 'Second Event', '2019-05-21 09:39:28', 'Test Description', 2, 2, 'http://thanksgivingdayusa.com/d2/dev/DeCipher/Organizer/createEvent', NULL, 'Barahani', 'Testarossa Winery, College Avenue, Los Gatos, CA, USA', 'Delhi', '2019-06-13', '00:00:00', '2019-06-25', '00:00:00', 0, 'Select', NULL, NULL, NULL, '2019-04-08 05:00:00', '2019-04-08 05:00:00', 0, 1, 0, 0, '2019-04-08 12:13:24', '2019-04-08 17:16:00', 0, 0, 1, 'Test Information', '1,2,3', NULL, NULL, 1),
(10, 35, 'Test Event', '2019-05-21 09:39:28', 'Test Description', 1, 2, 'http://thanksgivingdayusa.com/d2/dev/DeCipher/Organizer/createEvent', '1,2,3,4,5', 'Barahani', 'Chennai, Tamil Nadu, India', 'Delhi', '2019-06-14', '12:07:00', '2019-06-25', '18:08:00', NULL, 'Select', NULL, NULL, NULL, '2019-04-09 05:05:55', '2019-04-09 05:05:55', 1, 1, 0, 0, '2019-04-09 05:05:55', NULL, 0, 0, 1, 'TEst Information', '1,2,3,4,5', NULL, NULL, 1),
(23, 35, 'Test Event', '2019-05-21 09:39:28', 'Test Description', 1, 2, 'http://thanksgivingdayusa.com/d2/dev/DeCipher/Organizer/createEvent', NULL, 'Barahani', 'Chennai, Tamil Nadu, India', 'Delhi', '2019-06-15', '12:07:00', '2019-06-25', '18:08:00', NULL, 'Select', NULL, NULL, NULL, '2019-04-09 05:05:55', '2019-04-09 05:05:55', 1, 1, 0, 0, '2019-04-09 05:05:55', NULL, 0, 0, 1, 'TEst Information', '1,2,3,4,5', NULL, NULL, 1),
(24, 35, 'Test Event', '2019-05-21 09:39:28', 'Test Description', 1, 2, 'http://thanksgivingdayusa.com/d2/dev/DeCipher/Organizer/createEvent', NULL, 'Barahani', 'Chennai, Tamil Nadu, India', 'Delhi', '2019-06-11', '12:07:00', '2019-06-25', '18:08:00', NULL, 'Select', NULL, NULL, NULL, '2019-04-09 05:05:55', '2019-04-09 05:05:55', 1, 1, 0, 0, '2019-04-09 05:05:55', NULL, 0, 0, 1, 'TEst Information', '1,2,3,4,5', NULL, NULL, 1),
(25, 35, 'Rishieksh  Rajput', '2019-05-21 09:39:28', 'Test', 25, 2, 'https://www.arazygroup.com/medtech-regulatory-awards/', '1,2,3,4,5', 'New Delhi', 'New Delhi', 'New Delhi', '2019-06-11', '12:00:00', '2019-06-25', '15:00:00', 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, '2019-05-15 10:03:38', '2019-05-15 10:28:46', 0, 1, 1, 'fgjhghg', '1,2,3,4,5', '40.71277600', '-74.00597400', 1);

-- --------------------------------------------------------

--
-- Table structure for table `event_attendee`
--

CREATE TABLE `event_attendee` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `amount` varchar(250) NOT NULL,
  `ticket_type` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `payment_type` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_attendee`
--

INSERT INTO `event_attendee` (`id`, `first_name`, `last_name`, `amount`, `ticket_type`, `quantity`, `email`, `payment_type`, `event_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Rishikesh', 'singh', '100', 1, 5, 'singhrishikesh@gmail.com', 2, 25, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Rishikesh', 'singh', '100', 1, 5, 'singhrishikesh@gmail.com', 2, 25, 7, '2019-05-16 18:58:54', NULL),
(3, 'Rishikesh', 'singh', '100', 1, 5, 'singhrishikesh@gmail.com', 2, 25, 7, '2019-05-16 18:58:54', NULL),
(4, 'Rishikesh', 'singh', '100', 1, 5, 'singhrishikesh@gmail.com', 2, 25, 7, '2019-05-16 18:58:54', NULL),
(5, 'Rishikesh', 'singh', '100', 1, 5, 'singhrishikesh@gmail.com', 2, 25, 7, '2019-05-16 18:58:54', NULL);

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
(1, 19, 'event_image01557380873.jpg'),
(2, 20, 'event_image11557380873.jpg'),
(3, 20, 'event_image21557380873.jpg'),
(4, 20, 'event_image31557380873.jpg'),
(5, 21, 'event_image01557381779.jpg'),
(6, 21, 'event_image11557381779.jpg'),
(7, 21, 'event_image21557381779.jpg'),
(8, 21, 'event_image31557381779.jpg'),
(9, 22, 'event_image01557401919.jpg'),
(10, 22, 'event_image11557401919.jpg'),
(11, 22, 'event_image21557401919.jpg'),
(12, 22, 'event_image31557401919.jpg'),
(26, 25, 'event_image11557914618.jpg'),
(27, 25, 'event_image21557914618.jpg'),
(28, 25, 'event_image31557914618.jpg'),
(29, 25, 'event_image01557915770.jpg');

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
  `event_type` tinyint(4) NOT NULL,
  `price` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_ticket`
--

INSERT INTO `event_ticket` (`id`, `event_id`, `ticket_type`, `quantity`, `event_type`, `price`) VALUES
(5, 10, 'Paid', 25, 2, '100'),
(6, 10, 'VIP', 25, 1, '200'),
(7, 10, 'Early Bird', 25, 2, '300'),
(8, 20, 'Free', 25, 1, '300'),
(9, 21, 'Ticket_type', 25, 2, '300'),
(10, 21, 'Ticket_type', 25, 1, '300'),
(17, 22, 'Ticket_type', 25, 2, '300'),
(18, 22, 'Ticket_type', 25, 1, '300'),
(29, 25, 'Ticket_type', 25, 2, '300'),
(30, 25, 'Ticket_type', 25, 1, '300');

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
('04f6bde168010742c875309077e0c1723612f9f7484a25e4ea2f7d069c7536d92509a5a66e3f0f19', 7, 1, 'userToken', '[]', 0, '2019-05-21 06:52:54', '2019-05-21 06:52:54', '2020-05-21 12:22:54'),
('1705771534a53798ace96d7326e0db80b2368f619828c095fee70dde344e8507008b8542c123400f', 6, 1, 'userToken', '[]', 0, '2019-05-05 23:50:50', '2019-05-05 23:50:50', '2020-05-06 05:20:50'),
('3d105188ae6a9704e9de81fd9f8050172104167a105bee045f12a0b7a6e4c2ad265a706069d55a8f', 2, 1, 'userToken', '[]', 0, '2019-05-03 04:20:14', '2019-05-03 04:20:14', '2020-05-03 09:50:14'),
('40439e20548c917dd610b7a1d23280bf6198c331c2a4c60de639035b0002ad81f94ed84e1d8c67f9', 7, 1, 'userToken', '[]', 0, '2019-05-16 13:08:56', '2019-05-16 13:08:56', '2020-05-16 18:38:56'),
('484c6bbbec0c3f2ffb0abc83c58f46eea0d62b5053ce77ca83eef414d7de694b188f5f505a636f61', 2, 1, 'userToken', '[]', 0, '2019-05-03 04:19:07', '2019-05-03 04:19:07', '2020-05-03 09:49:07'),
('59436e5e862e3afeaacc6d0d908565595b2ff12d142ff2af87dfcab4d2b09a85bb88791884fb4232', 6, 1, 'userToken', '[]', 0, '2019-05-03 05:00:28', '2019-05-03 05:00:28', '2020-05-03 10:30:28'),
('637499e2a1907c8ad0aacc709159991aa0568577e9add0b10b02dad2321a400e96a5020a117a6ad8', 6, 1, 'userToken', '[]', 0, '2019-05-03 05:49:38', '2019-05-03 05:49:38', '2020-05-03 11:19:38'),
('6aca702f769cef44d7152e8a20ed479b3601c57fea43d414c1da02686fcb43db9520d86e11583630', 2, 1, 'userToken', '[]', 0, '2019-05-03 04:23:12', '2019-05-03 04:23:12', '2020-05-03 09:53:12'),
('83a854be378dea8774613d638b3ecccd72d2b049be3b740997bf4830a07a3bdd9ea4b492e2f3699f', 2, 1, 'userToken', '[]', 0, '2019-05-03 04:23:44', '2019-05-03 04:23:44', '2020-05-03 09:53:44'),
('9fc41700b7d35fd1e802ca44514bc097049744300224f4eb381fd54c6bc2b5a3a68d57d9e4689b57', 6, 1, 'userToken', '[]', 0, '2019-05-03 04:29:02', '2019-05-03 04:29:02', '2020-05-03 09:59:02'),
('bd0428803f0e5639e6f8fbd4ef99c96f7fc38a4f70dd846a60fc77971783f17a5e56e1c8e7c4693d', 7, 1, 'userToken', '[]', 0, '2019-05-06 06:25:36', '2019-05-06 06:25:36', '2020-05-06 11:55:36'),
('d136670962fed3a138e87fc43443e793aaaabca89dc78b6f132c75ece309123246e4121eaff23f79', 7, 1, 'userToken', '[]', 0, '2019-05-06 00:44:10', '2019-05-06 00:44:10', '2020-05-06 06:14:10'),
('eef614ffd6899f6007ad48894f5426ef99bf70abab3d9de4dca20259e40a7c403b0acd7a1acede31', 6, 1, 'userToken', '[]', 0, '2019-05-03 05:00:06', '2019-05-03 05:00:06', '2020-05-03 10:30:06'),
('f1ed3958984eb87860b1685801f891222d62b9158cacba4365c683591e0245edec099350751894f2', 2, 1, 'userToken', '[]', 0, '2019-05-03 04:27:47', '2019-05-03 04:27:47', '2020-05-03 09:57:47'),
('f592efe41a836c861b573ca334ae1e949748ff43756272c18eab39da2ba4bdb2782aed6c6c35b062', 2, 1, 'userToken', '[]', 0, '2019-05-03 04:28:14', '2019-05-03 04:28:14', '2020-05-03 09:58:14');

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
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_id`, `customer_id`, `created_at`) VALUES
(1, 1, 1, 1552654901),
(2, 2, 2, 1552654901);

-- --------------------------------------------------------

--
-- Table structure for table `order_tickets`
--

CREATE TABLE `order_tickets` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(10,3) NOT NULL,
  `ticket_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(6, 'Test Organizer', 'Test', 'Organizer', 'test@gmail.com', '8707817505', 'gtrhr', NULL, NULL, '12345', 'www.decipher.com', 'tert', '2019-03-27 09:53:38', NULL, 0, '0000-00-00 00:00:00', 'www.facebook.com', NULL, 'www.instagram.com', 'Test Organizer11233', 0, 'www.twitter.com', 'www.snapchat.com', 'yGNHk5Zh0VgqeWuM8SGjufeHUo88prIH'),
(16, 'Rishikesh Singh', 'Prince', 'Singh', 'neeraj@gmail.com', '8423319133', 'sdfsdf', NULL, NULL, '12345', 'Test.com', NULL, NULL, NULL, 0, '2019-03-25 16:46:36', 'www.facebook.com', NULL, 'www.instagram.com', 'dsadsad', 1, NULL, 'www.snapchat.com', NULL),
(21, 'Rishikesh Singh', 'Rahul', 'Singh', 'asdjas@gmail.com', '8423319130', 'ffsdf', NULL, NULL, '12345', 'dsfsdf', NULL, NULL, NULL, 0, '2019-03-25 17:05:09', 'dsfsdf', NULL, 'dsfdsfsdf', 'dsfsdf', 1, NULL, 'sdfsdfdsf', NULL),
(28, 'test', 'testfirst', 'testlast', 'testfirst@gmail.com', '1233545677', 'location', NULL, NULL, '123456', 'unq.com', 'www.firsttest.com', '2019-03-26 14:47:45', NULL, 0, '2019-03-26 14:31:54', 'facebook.com', NULL, 'insta.com', 'test orgwqw', 0, NULL, 'snap.com', NULL),
(29, 'organiser name (Cipher Entertainments', 'Babajide', 'Cipher', 'testfirstgred@gmail.com', '12345678', 'ewrfew', NULL, NULL, '123456', 'fds', 'ferfrr', '2019-03-28 16:25:32', NULL, 0, '2019-03-26 14:37:48', 'fds', NULL, 'fsd', 'fds', 0, NULL, 'fds', NULL),
(31, 'rfwerw', 'rwer', 'rewrewr', 'testfirsyuuyt55t@gmail.com', '1234567', 'df', NULL, NULL, '123456gsdf', 'dgfd', 'bfdgd', '2019-03-26 14:39:32', NULL, 0, '2019-03-26 14:39:23', 'efsde', NULL, 'gfd', 'fdgd', 1, NULL, 'fd', NULL),
(32, 'Rishikesh Singh', 'Rahul', 'Singh', 'rishikeshdean@gmail.com1', '8423319130', 'jdhkjdfhskf', NULL, NULL, '12345', 'www.decipher.com', 'www.myoffice.com', '2019-03-26 17:46:48', NULL, 0, '2019-03-26 15:56:52', 'facebbok.hfsdfsdf8787fdsf4ds', NULL, 'www.instagram.com', 'fsdfsdfsdf', 0, 'www.twitter.com', 'www.snapchat.com', NULL),
(33, 'new organizerdfgd', 'newfdsf', 'organizerfds', 'neworganizer@gmail.comfsd', '123456789781223', 'locationff', NULL, NULL, '123456', 'uq.comfds', 'new.comfdsf', '2019-03-28 16:26:57', NULL, 0, '2019-03-26 17:48:58', 'fb.comfe', NULL, 'int.comfds', 'new orgfds', 0, 'twit.comdfs', 'snp.comfds', NULL),
(34, 'test123`', 'tuybj', 'hujhguhj', 'fjkdsj@gmail.com', '123467789', 'kjfkjhdsk', NULL, NULL, '123456', 'jiji', 'hiuhi.com', '2019-03-27 09:55:15', NULL, 0, '2019-03-27 09:52:46', 'oijioj', NULL, 'kkjk', 'kjkkj', 0, 'jkhj', 'kjk', NULL),
(35, 'Rishikesh Singh', 'Rahul', 'Singh', 'rishikeshdean@gmail.com', '8423319130', '12345', NULL, NULL, '12345', 'www.decipher.com', 'www.myoffice.com', '2019-03-07 17:06:10', NULL, 0, '2019-03-27 18:03:37', 'facebbok.hfsdfsdf8787fdsf4ds', NULL, 'www.instagram.com', 'sfsdfsdf', 0, 'www.twitter.com1', 'www.snapchat.com', 'mxmH78IuaedKc4Zoiaq1dOLAYbf1uRGv'),
(36, 'Test With google api Location', 'Rishikesh', 'Singh', 'Rk@gmail.com', '8423319130', 'Test Yantra Software Solutions India Pvt Ltd, Gandhi Bazaar, Basavanagudi, Bengaluru, Karnataka, India', NULL, NULL, '12345', 'fgjsgdfjgf', 'www.myoffice.com', NULL, NULL, 0, '2019-03-29 11:45:17', 'www.facebook.com', NULL, 'insta.hgfhdgsfjg874', 'fffsfsdf', 1, 'www.twitter.com', 'www.snapchat.com', NULL),
(37, 'test april', 'april', 'test', 'testapril@gmail.com', '1234567898', 'test april', NULL, NULL, '123456', 'url.com', 'ww.testapril.com', NULL, NULL, 0, '2019-04-11 11:20:47', 'http://fb.com', NULL, 'http://insta.com', 'april organizer', 1, 'http://twt.com', 'http://snp.com', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('rishikeshdean@gmail.com', 'Zl6OzImCmCEvDWfliskbRd5TIjr1F7nW', '2019-05-07 05:14:27'),
('rishikeshdean@gmail.com', 'FwE7DxejXJpxDDyhQudrg3ogNTeaDwYf', '2019-05-07 05:20:47');

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
(1, 'Test Tag', '2019-05-14 22:37:11', NULL),
(2, 'Test Tag 2', '2019-05-14 22:37:18', NULL),
(3, 'Test Tag 3', '2019-05-14 22:37:23', NULL);

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
(35, 'Rishikesh Singh', 'Prince', 'dsadasd', 'srishikesh@deaninfotech.com', '8423319130', NULL, NULL, NULL, '12345', NULL, '2,3,4,5', NULL, '2019-03-28 11:20:50', NULL, 0, '2019-03-27 10:58:31', NULL, NULL, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` int(10) DEFAULT NULL COMMENT '2 for organizer and 1 for User',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`, `remember_token`, `created_at`, `updated_at`, `first_name`, `last_name`, `about_organizer`, `mobile_number`, `location`, `cityLat`, `cityLng`, `unique_url`, `roles`, `website`, `fb_url`, `insta_url`, `snapchat`, `twitter`) VALUES
(7, NULL, 'rishikeshdean@gmail.com', '$2y$10$diGZTdGGPYGxM90SSic6w.5qptrSe1aR5GKDc7vzeD0WUsXPJvv3u', 0, NULL, '2019-05-06 00:44:10', '2019-05-06 01:23:54', 'Rishikesh', 'singh', NULL, NULL, 'New Delhi', NULL, NULL, 'www.facebook.com', NULL, NULL, 'http://www.facebook.com', 'http://www.instagram.com', 'http://www.snapchat.com', 'http://www.twitter.com'),
(8, NULL, 'rishikeshdean@gmail1.com', '$2y$10$diGZTdGGPYGxM90SSic6w.5qptrSe1aR5GKDc7vzeD0WUsXPJvv3u', 0, NULL, '2019-05-06 00:44:10', '2019-05-06 01:23:54', 'Rishikesh', 'singh', NULL, NULL, 'New Delhi', NULL, NULL, 'www.facebook.com', NULL, NULL, 'http://www.facebook.com', 'http://www.instagram.com', 'http://www.snapchat.com', 'http://www.twitter.com');

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
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_bank_account`
--

INSERT INTO `user_bank_account` (`id`, `user_id`, `bank_name`, `account_name`, `account_number`, `bank_currency`, `bank_phone_no`, `routing_number`, `updated_at`, `created_at`) VALUES
(1, 7, 'ICICI', 'Rishikeshn singh', '3802020107665595', 'NGN', 'ICICI', '4546549874654654', '0000-00-00 00:00:00', NULL),
(2, 7, 'ICICI', 'Rishikeshn singh', '3802020104564674', 'CAD', '8423876545', '4546549874654656', NULL, NULL),
(3, 7, 'ICICI', 'Rishikeshn singh', '3802020104564675', 'Select One', '8423876545', '4546549874654655', NULL, NULL),
(4, 7, 'HDFC', 'Rishikesh singh', '7465654987469', 'EUR', '9598088162', '65564564', NULL, NULL);

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
(3, 7, 'rishikeshdean@gmail.com', 'Rishikesh singh', '8421361191', 'CAD', '2019-05-06 04:49:18', '2019-05-06 03:38:58');

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
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
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cms_pages`
--
ALTER TABLE `cms_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `coupon`
--
ALTER TABLE `coupon`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `event_attendee`
--
ALTER TABLE `event_attendee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `event_category`
--
ALTER TABLE `event_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `event_mages`
--
ALTER TABLE `event_mages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `follow`
--
ALTER TABLE `follow`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_bank_account`
--
ALTER TABLE `user_bank_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_paypal_account`
--
ALTER TABLE `user_paypal_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
