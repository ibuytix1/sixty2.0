-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 18, 2019 at 08:04 AM
-- Server version: 5.6.41-84.1
-- PHP Version: 5.6.30

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
(32, 'test', 'test_last', 'test@gmail.com', '2019-04-08 17:16:54', NULL, 8, 2);

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE `coupon` (
  `id` int(10) UNSIGNED NOT NULL,
  `orgnisar_id` int(11) NOT NULL,
  `coupon` varchar(250) NOT NULL,
  `description` text,
  `start_date` int(11) NOT NULL,
  `end_date` int(11) NOT NULL,
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

INSERT INTO `coupon` (`id`, `orgnisar_id`, `coupon`, `description`, `start_date`, `end_date`, `total_available`, `redeem_on`, `amount`, `type`, `status`, `updated_at`) VALUES
(7, 35, 'TEST20', 'Test Description', 1554296340, 1554296340, 200, 6, 200.00, '%', 1, '2019-04-03 16:32:40'),
(8, 35, 'TEST Coupon', 'Test Description', 1554469140, 1554469140, 200, 6, 200.00, 'amt', 1, '2019-04-04 09:31:46');

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
  `start_date` int(11) DEFAULT NULL,
  `end_date` int(11) DEFAULT NULL,
  `event_recurring` tinyint(1) DEFAULT NULL COMMENT '0=Free,1=Paid,2=Donation',
  `event_occurrence_type` varchar(255) DEFAULT NULL,
  `occurrence_start_time` time DEFAULT NULL,
  `occurrence_end_time` time DEFAULT NULL,
  `occurrence_off_the_day` text,
  `occurrence_from_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `occurence_to_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
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

INSERT INTO `events` (`id`, `organizer_id`, `event_title`, `event_date`, `event_description`, `category_id`, `subcategory_id`, `event_url`, `event_tags`, `event_location`, `address`, `address_2`, `start_date`, `end_date`, `event_recurring`, `event_occurrence_type`, `occurrence_start_time`, `occurrence_end_time`, `occurrence_off_the_day`, `occurrence_from_date`, `occurence_to_date`, `show_no_of_available_tickets`, `refund_policy`, `parking`, `wheelchair`, `created_at`, `updated_at`, `is_delete`, `is_private`, `status`, `other_information`, `aditional_information`, `cityLat`, `cityLng`, `event_status`) VALUES
(4, 2, 'Test Event', '2019-03-29 13:06:34', 'test', 1, 2, 'http://thanksgivingdayusa.com/d2/dev/DeCipher/Organizer/createEvent', NULL, 'dsfds', 'cxvxcvcx, Plac Kupiecki, Brzesko, Poland', 'Locarion', 1553864340, 1553950740, 0, 'Select', NULL, NULL, NULL, '2019-03-29 05:00:00', '2019-03-29 05:00:00', 0, 1, 0, 0, '2019-03-29 13:05:30', '2019-03-29 18:06:34', 0, 0, 1, 'TEst Information', '1,2,3', NULL, NULL, NULL),
(6, 35, 'Test Event', '2019-04-03 13:05:36', 'Test Description', 1, 2, 'http://thanksgivingdayusa.com/d2/dev/DeCipher/Organizer/createEvent', NULL, 'USA', 'Testour, Tunisia', 'dfsdhfjdsfkjsdhf', 1554296340, 1554382740, 0, 'Select', NULL, NULL, NULL, '2019-04-03 05:00:00', '2019-04-03 05:00:00', 0, 1, 0, 0, '2019-04-03 11:30:25', '2019-04-03 18:05:36', 0, 0, 1, 'Test Information', '1,2,3,8', NULL, NULL, 1),
(7, 35, 'Dean Event', '2019-04-05 04:39:25', 'Test Description', 1, 3, 'http://thanksgivingdayusa.com/d2/dev/DeCipher/Organizer/createEvent', NULL, 'Barahani', 'Testour, Tunisia', 'Locarion', 1554555540, 1554814740, NULL, 'Select', NULL, NULL, NULL, '2019-04-05 04:39:25', '2019-04-05 04:39:25', NULL, 1, 0, 0, '2019-04-05 04:39:25', NULL, 0, 0, 1, 'TEst Information', '1,2', NULL, NULL, 1),
(8, 2, 'Test Event', '2019-04-08 10:25:42', 'Test Description', 1, 2, 'http://thanksgivingdayusa.com/d2/dev/DeCipher/Organizer/createEvent', NULL, 'Barahani', 'Testarossa Winery, College Avenue, Los Gatos, CA, USA', 'Delhi', 1554728340, 1554814740, 0, 'Select', NULL, NULL, NULL, '2019-04-08 05:00:00', '2019-04-08 05:00:00', 0, 1, 0, 0, '2019-04-08 05:45:48', '2019-04-08 15:25:42', 0, 0, 1, 'Test Information', '1,2,3', NULL, NULL, 2),
(9, 2, 'Second Event', '2019-04-08 12:16:00', 'Test Description', 1, 2, 'http://thanksgivingdayusa.com/d2/dev/DeCipher/Organizer/createEvent', NULL, 'Barahani', 'Testarossa Winery, College Avenue, Los Gatos, CA, USA', 'Delhi', 1554728340, 1554814740, 0, 'Select', NULL, NULL, NULL, '2019-04-08 05:00:00', '2019-04-08 05:00:00', 0, 1, 0, 0, '2019-04-08 12:13:24', '2019-04-08 17:16:00', 0, 0, 1, 'Test Information', '1,2,3', NULL, NULL, 1),
(10, 6, 'Test Event', '2019-04-09 05:05:55', 'Test Description', 1, 2, 'http://thanksgivingdayusa.com/d2/dev/DeCipher/Organizer/createEvent', NULL, 'Barahani', 'Chennai, Tamil Nadu, India', 'Delhi', 1554814740, 1554901140, NULL, 'Select', NULL, NULL, NULL, '2019-04-09 05:05:55', '2019-04-09 05:05:55', 1, 1, 0, 0, '2019-04-09 05:05:55', NULL, 0, 0, 1, 'TEst Information', '1,2,3,4,5', NULL, NULL, 1);

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
(16, 4, 'event_image01553864730.jpg'),
(17, 4, 'event_image11553864730.jpg'),
(18, 4, 'event_image21553864730.jpg'),
(19, 4, 'event_image31553864730.png'),
(24, 6, 'event_image01554291025.jpg'),
(25, 6, 'event_image11554291025.jpg'),
(26, 6, 'event_image21554291025.jpg'),
(27, 6, 'event_image31554291025.png'),
(28, 7, 'event_image01554439165.jpg'),
(29, 7, 'event_image11554439165.jpg'),
(30, 7, 'event_image21554439165.jpg'),
(31, 7, 'event_image31554439165.png'),
(32, 8, 'event_image01554702348.jpg'),
(33, 8, 'event_image11554702348.jpg'),
(34, 8, 'event_image21554702348.jpg'),
(35, 8, 'event_image31554702348.png'),
(36, 9, 'event_image01554725697.jpg'),
(37, 9, 'event_image11554725697.jpg'),
(38, 9, 'event_image21554725697.jpg'),
(39, 9, 'event_image31554725697.png'),
(40, 10, 'event_image01554786355.jpg'),
(41, 10, 'event_image11554786355.jpg'),
(42, 10, 'event_image21554786355.jpg'),
(43, 10, 'event_image31554786355.png');

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
(10, 4, 'Paid Type', 20, 1, '400'),
(17, 6, 'TEst Type', 300, 1, '300'),
(18, 7, 'VIP', 300, 1, '400'),
(21, 8, 'VIP', 300, 1, '200'),
(22, 8, 'Test Type', 300, 2, '350'),
(29, 9, 'VIP', 300, 1, '200'),
(30, 9, 'Test Type', 300, 2, '350'),
(31, 10, 'VIP', 300, 2, '200');

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
  `price` decimal(10,3) NOT NULL
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
(2, 'Ace Entertainments', 'John', 'Doe', 'admin@gmail.com', '7068508545', 'google Api', NULL, NULL, '12345', 'Test.com', 'Singh.com', '2019-04-05 09:01:18', NULL, 0, '0000-00-00 00:00:00', 'http://Facebook.com/face', 'skype.yfguysdgf746237468', 'http://Instagram.com/instagram', 'Text Field here', 1, 'http://twitter.com/twitter', 'https://Snapchat.com/snapmelly', ''),
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
(1, 'Rishikesh singh', 'Rishikesh', 'Singh', 'admin@gmail.com', '8465625449', NULL, NULL, NULL, '12345', 'www.uniqueurl.com', '1,2,3,4,5', 'www.webpage.com', '2019-03-28 12:11:49', NULL, 1, '0000-00-00 00:00:00', NULL, NULL, NULL, 0, NULL, NULL),
(2, 'Rishikesh Singh', 'Rahul', 'Singh', 'rahul@gmail.com', '8423319130', NULL, NULL, NULL, '12345', NULL, '2', NULL, '2019-03-28 09:21:49', NULL, 1, '0000-00-00 00:00:00', NULL, NULL, NULL, 1, NULL, NULL),
(3, 'Vikash Pandey', 'Vikash', 'pandey', 'rishikesh@apptology.in', '8423319130', NULL, NULL, NULL, '12345', NULL, '2,3,4', NULL, '2019-03-28 09:15:17', NULL, 1, '0000-00-00 00:00:00', NULL, NULL, NULL, 1, NULL, NULL),
(4, 'Rishikesh Singh', 'Rahul', 'Singh', 'neeraj@gmail.com', '8423319133', NULL, NULL, NULL, '121345', NULL, '2,3,4,5', NULL, '2019-03-28 09:21:40', NULL, 1, '0000-00-00 00:00:00', NULL, NULL, NULL, 1, NULL, NULL),
(5, 'Rishikesh Singh', 'Rahul', 'Singh', 'admin@gmail.com1', '8423319133', NULL, NULL, NULL, '12345', NULL, NULL, NULL, '2019-03-28 11:19:25', NULL, 1, '0000-00-00 00:00:00', NULL, NULL, NULL, 1, NULL, NULL),
(6, 'Rishikesh Singh', 'Rishikesh', 'Singh', 'neeraj@gmail.com1', '8423319130', NULL, NULL, NULL, '12345', NULL, NULL, NULL, '2019-03-28 11:20:37', NULL, 1, '0000-00-00 00:00:00', NULL, NULL, NULL, 1, NULL, NULL),
(7, 'Rishikesh Singh', 'Prince', 'dsadasd', 'srishikesh@deaninfotech.com', '8423319130', NULL, NULL, NULL, '12345', NULL, '2,3,4,5', NULL, '2019-03-28 11:20:50', NULL, 0, '2019-03-27 10:58:31', NULL, NULL, NULL, 0, NULL, NULL),
(8, 'march user', 'march', 'user', 'marchuser@gmail.com', '1234567899', NULL, NULL, NULL, '123456', NULL, '1,2', NULL, '2019-03-28 11:20:11', NULL, 1, '2019-03-28 09:19:06', NULL, NULL, NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `created_at`, `updated_at`, `is_delete`, `status`, `remember_token`) VALUES
(1, 'Dean Infotech', 'dean@gmail.com', '8423319130', '12345', '2019-03-01 11:48:06', '2019-03-14 11:23:13', 0, 0, NULL),
(2, 'Rishikesh singh', 'singhrishikesh67@gmail.com', NULL, '$2y$10$vA4F8n1SGDyDpNLAs3Abd.yZ9LBK9G8d3Y8dQYEVYz9VCzgrLRUQS', '2019-03-05 07:27:21', '2019-03-05 07:27:21', NULL, 1, NULL),
(3, 'rishikesh singh', 'singhrishikesh67@gmail1.com', NULL, '$2y$10$uraZCS2HRV/AInN9aOExtOdpJfjMq54GN1urKM2.xQfkPsutz/hpW', '2019-03-06 10:07:47', '2019-03-06 10:07:47', NULL, 1, 'zVxzIkvkAYH4FPQ5jnbWDYqEXnaEMSc5gNOQYWK2uU6L8EL7svigFvvfJHLY'),
(4, 'Rishikesh Singh', 'singhrishikesh@gmail.com', NULL, '$2y$10$kok4cAA5Hlxbq8YAmmna4.hVTBx3536XUn8ihK5PL3kabmk2s7uVi', '2019-03-07 06:26:37', '2019-03-07 06:26:37', NULL, 1, 'gBZ8NKODZFqRmyCTqtKRMxowkQboJV6HvG1p3SAHEcNEXflQ8MLpyaoGUdpP');

-- --------------------------------------------------------

--
-- Table structure for table `user_bank_account`
--

CREATE TABLE `user_bank_account` (
  `id` int(11) NOT NULL,
  `organizer_id` int(11) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `bank_currency` varchar(255) NOT NULL,
  `bank_phone_no` varchar(255) NOT NULL,
  `routing_number` varchar(255) NOT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_bank_account`
--

INSERT INTO `user_bank_account` (`id`, `organizer_id`, `bank_name`, `account_name`, `account_number`, `bank_currency`, `bank_phone_no`, `routing_number`, `updated_at`, `created_at`) VALUES
(1, 6, 'ICICI', 'Rishikeshn singh', '3802020107665595', 'NGN', 'ICICI', '4546549874654654', 1553253566, NULL),
(2, 2, 'ICICI', 'Rishikeshn singh', '3802020104564674', 'CAD', '8423876545', '4546549874654656', NULL, NULL),
(3, 2, 'ICICI', 'Rishikeshn singh', '3802020104564675', 'Select One', '8423876545', '4546549874654655', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_paypal_account`
--

CREATE TABLE `user_paypal_account` (
  `id` int(11) NOT NULL,
  `organizer_id` int(11) NOT NULL,
  `paypal_email` varchar(255) NOT NULL,
  `name_organizer` varchar(255) NOT NULL,
  `pay_pal_phone_no` varchar(255) NOT NULL,
  `pay_pal_currency` varchar(255) NOT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_paypal_account`
--

INSERT INTO `user_paypal_account` (`id`, `organizer_id`, `paypal_email`, `name_organizer`, `pay_pal_phone_no`, `pay_pal_currency`, `updated_at`, `created_at`) VALUES
(1, 13, 'paypal@gmail.com', 'Test Paypal', '9178256466', 'USD', NULL, NULL),
(2, 2, 'singhrisgh@gmail.com', 'Rishikesh singh', '8845456454', 'CAD', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
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
-- Indexes for table `promoters`
--
ALTER TABLE `promoters`
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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_bank_account`
--
ALTER TABLE `user_bank_account`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organizer_id` (`organizer_id`);

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
-- AUTO_INCREMENT for table `cms_pages`
--
ALTER TABLE `cms_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `coupon`
--
ALTER TABLE `coupon`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `event_category`
--
ALTER TABLE `event_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `event_mages`
--
ALTER TABLE `event_mages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

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
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_bank_account`
--
ALTER TABLE `user_bank_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_paypal_account`
--
ALTER TABLE `user_paypal_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event_subcategory`
--
ALTER TABLE `event_subcategory`
  ADD CONSTRAINT `event_subcategory_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `event_category` (`id`);

--
-- Constraints for table `user_bank_account`
--
ALTER TABLE `user_bank_account`
  ADD CONSTRAINT `user_bank_account_ibfk_1` FOREIGN KEY (`organizer_id`) REFERENCES `orgnisars` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
