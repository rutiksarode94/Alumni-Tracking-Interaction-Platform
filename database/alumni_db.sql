-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2020 at 05:17 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `alumni_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `alumnus_bio`
--

-- Create the alumnus_bio table
CREATE TABLE `alumnus_bio` (
  `id` int(30) NOT NULL,
  `gr_no` varchar(12) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `middlename` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `batch` year(4) NOT NULL,
  `course_id` int(30) NOT NULL,
  `email` varchar(250) NOT NULL,
  `connected_to` text NOT NULL,
  `avatar` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0= Unverified, 1= Verified',
  `date_created` date NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert data into the alumnus_bio table
INSERT INTO `alumnus_bio` (`id`, `gr_no`, `firstname`, `middlename`, `lastname`, `gender`, `batch`, `course_id`, `email`, `connected_to`, `avatar`, `status`, `date_created`) 
VALUES (2, 'A1032000023', 'Rutik', 'S', 'Sarode', 'Male', 2009, 1, 'rutik13@gmail.com', 'My Company', '1602730260_avatar.jpg', 1, '2020-10-15');


CREATE TABLE `careers` (
  `id` int(30) NOT NULL,
  `company` varchar(250) NOT NULL,
  `location` text NOT NULL,
  `job_title` text NOT NULL,
  `description` text NOT NULL,
  `user_id` int(30) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `careers`
--

INSERT INTO `careers` (`id`, `company`, `location`, `job_title`, `description`, `user_id`, `date_created`) VALUES
(1, 'IT Company', 'Home-Based', 'Web Developer', '&lt;p style=&quot;-webkit-tap-highlight-color: rgba(0, 0, 0, 0); margin-top: 1.5em; margin-bottom: 1.5em; line-height: 1.5; animation: 1000ms linear 0s 1 normal none running fadeInLorem;&quot;&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sagittis eu volutpat odio facilisis mauris sit amet massa vitae. In tellus integer feugiat scelerisque varius morbi enim. Orci eu lobortis elementum nibh tellus molestie nunc. Vulputate ut pharetra sit amet aliquam id diam maecenas ultricies. Lacus sed viverra tellus in hac habitasse platea dictumst vestibulum. Eleifend donec pretium vulputate sapien nec. Enim praesent elementum facilisis leo vel fringilla est ullamcorper. Quam adipiscing vitae proin sagittis nisl rhoncus. Sed viverra ipsum nunc aliquet bibendum. Enim ut sem viverra aliquet eget sit amet tellus. Integer feugiat scelerisque varius morbi enim nunc faucibus.&lt;/p&gt;&lt;p style=&quot;-webkit-tap-highlight-color: rgba(0, 0, 0, 0); margin-top: 1.5em; margin-bottom: 1.5em; line-height: 1.5; animation: 1000ms linear 0s 1 normal none running fadeInLorem;&quot;&gt;Viverra justo nec ultrices dui. Leo vel orci porta non pulvinar neque laoreet. Id semper risus in hendrerit gravida rutrum quisque non tellus. Sit amet consectetur adipiscing elit ut. Id neque aliquam vestibulum morbi blandit cursus risus. Tristique senectus et netus et malesuada. Amet aliquam id diam maecenas ultricies mi eget mauris. Morbi tristique senectus et netus et malesuada. Diam phasellus vestibulum lorem sed risus. Tempor orci dapibus ultrices in. Mi sit amet mauris commodo quis imperdiet. Quisque sagittis purus sit amet volutpat. Vehicula ipsum a arcu cursus. Ornare quam viverra orci sagittis eu volutpat odio facilisis. Id volutpat lacus laoreet non curabitur. Cursus euismod quis viverra nibh cras pulvinar mattis nunc. Id aliquet lectus proin nibh nisl condimentum id venenatis. Eget nulla facilisi etiam dignissim diam quis enim lobortis. Lacus suspendisse faucibus interdum posuere lorem ipsum dolor sit amet.&lt;/p&gt;', 3, '2020-10-15 14:14:27'),
(2, 'Sample Company', 'Sample location', 'IT Specialist', '&lt;p style=&quot;margin-top: 1.5em; margin-bottom: 1.5em; margin-right: unset; margin-left: unset; color: rgb(68, 68, 68); font-family: &amp;quot;Open Sans&amp;quot;, sans-serif; font-size: 16px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); line-height: 1.5; animation: 1000ms linear 0s 1 normal none running fadeInLorem;&quot;&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sagittis eu volutpat odio facilisis mauris sit amet massa vitae. In tellus integer feugiat scelerisque varius morbi enim. Orci eu lobortis elementum nibh tellus molestie nunc. Vulputate ut pharetra sit amet aliquam id diam maecenas ultricies. Lacus sed viverra tellus in hac habitasse platea dictumst vestibulum. Eleifend donec pretium vulputate sapien nec. Enim praesent elementum facilisis leo vel fringilla est ullamcorper. Quam adipiscing vitae proin sagittis nisl rhoncus. Sed viverra ipsum nunc aliquet bibendum. Enim ut sem viverra aliquet eget sit amet tellus. Integer feugiat scelerisque varius morbi enim nunc faucibus.&lt;/p&gt;&lt;p style=&quot;margin-top: 1.5em; margin-bottom: 1.5em; margin-right: unset; margin-left: unset; color: rgb(68, 68, 68); font-family: &amp;quot;Open Sans&amp;quot;, sans-serif; font-size: 16px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); line-height: 1.5; animation: 1000ms linear 0s 1 normal none running fadeInLorem;&quot;&gt;Viverra justo nec ultrices dui. Leo vel orci porta non pulvinar neque laoreet. Id semper risus in hendrerit gravida rutrum quisque non tellus. Sit amet consectetur adipiscing elit ut. Id neque aliquam vestibulum morbi blandit cursus risus. Tristique senectus et netus et malesuada. Amet aliquam id diam maecenas ultricies mi eget mauris. Morbi tristique senectus et netus et malesuada. Diam phasellus vestibulum lorem sed risus. Tempor orci dapibus ultrices in. Mi sit amet mauris commodo quis imperdiet. Quisque sagittis purus sit amet volutpat. Vehicula ipsum a arcu cursus. Ornare quam viverra orci sagittis eu volutpat odio facilisis. Id volutpat lacus laoreet non curabitur. Cursus euismod quis viverra nibh cras pulvinar mattis nunc. Id aliquet lectus proin nibh nisl condimentum id venenatis. Eget nulla facilisi etiam dignissim diam quis enim lobortis. Lacus suspendisse faucibus interdum posuere lorem ipsum dolor sit amet.&lt;/p&gt;', 1, '2020-10-15 15:05:37');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(30) NOT NULL,
  `course` text NOT NULL,
  `about` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course`, `about`) VALUES
(1, ' Information Technology', 'Sample'),
(2, ' Computer Science ', 'Sample');;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(30) NOT NULL,
  `title` varchar(250) NOT NULL,
  `content` text NOT NULL,
  `schedule` datetime NOT NULL,
  `banner` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `content`, `schedule`, `banner`, `date_created`) VALUES
(1, 'Sample Event', '&lt;p style=&quot;margin-bottom: 15px; color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; padding: 0px; text-align: justify;&quot;&gt;Cras a est hendrerit, egestas urna quis, ullamcorper elit. Nullam a felis eget dolor vulputate vehicula. In hac habitasse platea dictumst. Nunc est urna, gravida sit amet ligula ut, aliquam fermentum lorem. Vestibulum non suscipit velit, in rhoncus orci. Vivamus pulvinar quam nec leo semper facilisis quis eu magna. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vestibulum lectus lorem, iaculis sed nunc nec, lacinia auctor risus.&lt;/p&gt;&lt;p style=&quot;margin-bottom: 15px; color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; padding: 0px; text-align: justify;&quot;&gt;Aenean elementum, risus eget rutrum dapibus, tellus leo eleifend leo, et mattis turpis quam eu turpis. Suspendisse commodo placerat tellus, quis faucibus metus euismod sed. Cras vitae risus in felis dignissim fermentum. Morbi aliquam nisi ipsum, id aliquam tortor congue eu. Sed fringilla convallis augue, et vulputate ante convallis vitae. Integer lacinia lacus at vehicula finibus. Nullam ultrices turpis dui, volutpat pulvinar augue placerat in. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis quam metus, sollicitudin a lectus non, tincidunt sagittis odio.&lt;/p&gt;', '2020-10-16 10:00:00', '1602813060_no-image-available.png', '2020-10-16 09:51:55');

-- --------------------------------------------------------

--
-- Table structure for table `event_commits`
--

CREATE TABLE `event_commits` (
  `id` int(30) NOT NULL,
  `event_id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `event_commits`
--

INSERT INTO `event_commits` (`id`, `event_id`, `user_id`) VALUES
(1, 1, 3);



CREATE TABLE `gallery` (
  `id` int(30) NOT NULL,
  `about` text NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `about`, `created`) VALUES
(1, 'Samplee', '2020-10-15 13:08:27'),
(2, 'asdasd', '2020-10-15 13:15:37'),
(3, 'asdasdrtgfdg', '2020-10-15 13:15:45'),
(4, 'dfgdfgdfg', '2020-10-15 13:15:53'),
(5, 'dfgdfgdfg', '2020-10-15 13:16:07');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `cover_img` text NOT NULL,
  `about_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `cover_img`, `about_content`) VALUES
(1, 'Alumni Tracking & Interaction Platform', 'info@sample.comm', '+6948 8542 623', '1602738120_pngtree-purple-hd-business-banner-image_5493.jpg', '&lt;p style=&quot;text-align: center; background: transparent; position: relative;&quot;&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-weight: 400; text-align: justify;&quot;&gt;&amp;nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&rsquo;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p style=&quot;text-align: center; background: transparent; position: relative;&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p style=&quot;text-align: center; background: transparent; position: relative;&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;/p&gt;');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `gr_no` VARCHAR(12),
  `name` TEXT NOT NULL,
  `username` VARCHAR(200) NOT NULL,
  `password` TEXT NOT NULL,
  `type` TINYINT(1) NOT NULL DEFAULT 3 COMMENT '1=Admin,2=Staff, 3=Users',
  `auto_generated_pass` TEXT NOT NULL,
  `alumnus_id` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



-- Insert data into the users table
INSERT INTO `users` (`gr_no`, `name`, `username`, `password`, `type`, `auto_generated_pass`, `alumnus_id`) VALUES
('N01032000001', 'Admin', 'admin', '0192023a7bbd73250516f069df18b500', 1, '', 0);


CREATE TABLE `contact_messages` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `message` TEXT NOT NULL,
    `date_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `admin_reply` TEXT
);

INSERT INTO `contact_messages` (`name`, `email`, `message`, `date_created`, `admin_reply`) VALUES 
('Rutik Sarode', 'rutik123@gmail.com', 'Hello', '2020-10-15 13:08:27', 'hello');

-- Indexes for dumped tables
--
-- Indexes for dumped tables
--
-- Indexes for dumped tables

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('unread','read') DEFAULT 'unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `timestamp`, `status`) VALUES
(3, 1, 'New alumnus profile added: Harry Kithoriya', '2024-03-28 04:08:09', 'unread'),
(4, 1, 'New alumnus profile added: harry Kithoriya', '2024-03-28 04:08:09', 'unread'),
(5, 1, 'New alumnus profile added: harry Kithoriya', '2024-03-28 04:08:09', 'unread'),
(6, 1, 'New job posted: Sr. PHP Developer at EInfoChips', '2024-03-28 04:08:09', 'unread'),
(7, 1, 'New job posted: dfgfdgdf at fdgfdg', '2024-03-28 04:08:09', 'unread'),
(8, 2, 'New alumnus profile added: Harry Kithoriya', '2024-03-28 04:08:09', 'unread'),
(9, 2, 'New alumnus profile added: harry Kithoriya', '2024-03-28 04:08:09', 'unread'),
(10, 2, 'New alumnus profile added: harry Kithoriya', '2024-03-28 04:08:09', 'unread'),
(11, 2, 'New job posted: Sr. PHP Developer at EInfoChips', '2024-03-28 04:08:09', 'unread'),
(12, 2, 'New job posted: dfgfdgdf at fdgfdg', '2024-03-28 04:08:09', 'unread'),
(13, 4555, 'New alumnus profile added: Harry Kithoriya', '2024-03-28 04:08:09', 'unread'),
(14, 4555, 'New alumnus profile added: harry Kithoriya', '2024-03-28 04:08:09', 'unread'),
(15, 4555, 'New alumnus profile added: harry Kithoriya', '2024-03-28 04:08:09', 'unread'),
(16, 4555, 'New job posted: Sr. PHP Developer at EInfoChips', '2024-03-28 04:08:10', 'unread'),
(17, 4555, 'New job posted: dfgfdgdf at fdgfdg', '2024-03-28 04:08:10', 'unread'),
(18, 67676, 'New alumnus profile added: Harry Kithoriya', '2024-03-28 04:08:10', 'unread'),
(19, 67676, 'New alumnus profile added: harry Kithoriya', '2024-03-28 04:08:10', 'unread'),
(20, 67676, 'New alumnus profile added: harry Kithoriya', '2024-03-28 04:08:10', 'unread'),
(21, 67676, 'New job posted: Sr. PHP Developer at EInfoChips', '2024-03-28 04:08:10', 'unread'),
(22, 67676, 'New job posted: dfgfdgdf at fdgfdg', '2024-03-28 04:08:10', 'unread');
-- Indexes for table `alumnus_bio`
--


--
-- Indexes for table `careers`
--
ALTER TABLE `careers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_commits`

ALTER TABLE `event_commits`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--


--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alumnus_bio`

--
ALTER TABLE `alumnus_bio`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `careers`
--
ALTER TABLE `careers`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `event_commits`
--
ALTER TABLE `event_commits`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;



ALTER TABLE `gallery`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    message TEXT NOT NULL,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(id),
    FOREIGN KEY (receiver_id) REFERENCES users(id)
);

ALTER TABLE users
ADD COLUMN location VARCHAR(255),
ADD COLUMN current_year VARCHAR(50),
ADD COLUMN contact VARCHAR(15),
ADD COLUMN job_title VARCHAR(255);

ALTER TABLE `users` ADD `batch` YEAR NOT NULL AFTER `username`;
ALTER TABLE users ADD COLUMN course_id INT;
ALTER TABLE `users` ADD `user_type` VARCHAR(20) NOT NULL AFTER `course_id`;
ALTER TABLE alumnus_bio ADD COLUMN job_title VARCHAR(255), ADD COLUMN location VARCHAR(255), ADD COLUMN contact VARCHAR(20), ADD COLUMN current_year VARCHAR(20);
ALTER TABLE users ADD COLUMN connected_to VARCHAR(10);
ALTER TABLE users ADD COLUMN gender VARCHAR(10);
ALTER TABLE alumnus_bio ADD COLUMN user_type VARCHAR(25);

CREATE TABLE `chat` (
  `id` int AUTO_INCREMENT NOT NULL,
  `sender_gr_no` VARCHAR(12) NOT NULL,
  `receiver_gr_no` VARCHAR(12) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `sender_gr_no`, `receiver_gr_no`, `message`, `created_at`) VALUES
(1, 8, 2, 'GM', '2024-03-19 04:44:08'),
(2, 2, 8, 'VGM', '2024-03-19 04:44:14'),
(3, 2, 8, 'Kese ho?', '2024-03-19 05:05:04'),
(4, 2, 8, 'hhh', '2024-03-19 05:10:23');


CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_id INT,
    comment TEXT,
    likes INT DEFAULT 0, -- New column for storing the number of likes
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (image_id) REFERENCES gallery(id) ON DELETE CASCADE
);
ALTER TABLE users
ADD COLUMN avatar TEXT NOT NULL;

ALTER TABLE `gallery` ADD `gr_no` VARCHAR(12) NOT NULL AFTER `id`, ADD `name` TEXT NOT NULL AFTER `gr_no`;
ALTER TABLE gallery ADD COLUMN likes INT DEFAULT 0;
ALTER TABLE `comments` ADD `gr_no` VARCHAR(12) NOT NULL AFTER `id`, ADD `name` TEXT NOT NULL AFTER `gr_no`;
ALTER TABLE users ADD COLUMN otp VARCHAR(10) DEFAULT NULL;