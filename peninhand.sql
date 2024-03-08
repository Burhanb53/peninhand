-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2024 at 02:17 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `peninhand`
--

-- --------------------------------------------------------

--
-- Table structure for table `doubt`
--

CREATE TABLE `doubt` (
  `id` int(11) NOT NULL,
  `doubt_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `teacher_id` int(255) NOT NULL,
  `doubt` varchar(255) DEFAULT NULL,
  `doubt_image` varchar(255) DEFAULT NULL,
  `doubt_created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `answer` varchar(255) DEFAULT NULL,
  `answer_image` varchar(255) DEFAULT NULL,
  `answer_created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doubt`
--

INSERT INTO `doubt` (`id`, `doubt_id`, `user_id`, `teacher_id`, `doubt`, `doubt_image`, `doubt_created_at`, `answer`, `answer_image`, `answer_created_at`) VALUES
(1, 1, 101, 201, 'How does gravity work?', 'gravity_image.jpg', '2024-03-08 13:16:39', 'Gravity is the force...', 'answer_image.jpg', '2024-03-08 13:16:39'),
(2, 2, 102, 202, 'What is the capital of France?', NULL, '2024-03-08 13:16:39', 'The capital of France is Paris.', NULL, '2024-03-08 13:16:39'),
(3, 3, 103, 203, 'How to solve quadratic equations?', 'equation_image.jpg', '2024-03-08 13:16:39', 'Quadratic equations can be solved using...', 'solution_image.jpg', '2024-03-08 13:16:39');

-- --------------------------------------------------------

--
-- Table structure for table `doubt_submission`
--

CREATE TABLE `doubt_submission` (
  `id` int(11) NOT NULL,
  `doubt_id` int(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `verified` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doubt_submission`
--

INSERT INTO `doubt_submission` (`id`, `doubt_id`, `description`, `verified`, `created_at`) VALUES
(1, 1, 'Explanation of gravity', 1, '2024-03-08 18:46:39'),
(2, 2, 'Question about French capital', 0, '2024-03-08 18:46:39'),
(3, 3, 'Solving quadratic equations step by step', 1, '2024-03-08 18:46:39');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_plan`
--

CREATE TABLE `subscription_plan` (
  `id` int(11) NOT NULL,
  `subscription_id` int(11) NOT NULL,
  `plan_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `duration` varchar(255) NOT NULL,
  `price` int(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscription_plan`
--

INSERT INTO `subscription_plan` (`id`, `subscription_id`, `plan_name`, `description`, `duration`, `price`, `created_at`) VALUES
(1, 1, 'Basic', 'Access to basic features', '1 month', 10, '2024-03-08 18:46:39'),
(2, 2, 'Premium', 'Access to premium features', '3 months', 25, '2024-03-08 18:46:39'),
(3, 3, 'Pro', 'Access to all features', '6 months', 50, '2024-03-08 18:46:39');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_user`
--

CREATE TABLE `subscription_user` (
  `id` int(11) NOT NULL,
  `user_id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `mother_name` varchar(255) DEFAULT NULL,
  `mother_email` varchar(255) DEFAULT NULL,
  `mother_contact` varchar(20) DEFAULT NULL,
  `father_name` varchar(255) DEFAULT NULL,
  `father_email` varchar(255) DEFAULT NULL,
  `father_contact` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(100) NOT NULL,
  `pin` varchar(10) NOT NULL,
  `subscription_id` int(10) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `end_date` date NOT NULL,
  `verified` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscription_user`
--

INSERT INTO `subscription_user` (`id`, `user_id`, `name`, `email`, `contact`, `photo`, `mother_name`, `mother_email`, `mother_contact`, `father_name`, `father_email`, `father_contact`, `address`, `city`, `state`, `pin`, `subscription_id`, `created_at`, `end_date`, `verified`) VALUES
(1, 101, 'John Doe', 'john@example.com', '1234567890', 'john_photo.jpg', 'Jane Doe', 'jane@example.com', '9876543210', 'John Doe Sr.', 'johnsr@example.com', '8765432109', '123 Main St', 'Cityville', 'CA', '12345', 1, '2024-03-08 18:46:39', '2024-04-01', 1),
(2, 102, 'Jane Smith', 'jane@example.com', '9876543210', 'jane_photo.jpg', 'Mary Smith', 'mary@example.com', '8765432109', 'James Smith', 'james@example.com', '7654321098', '456 Oak St', 'Townsville', 'NY', '54321', 2, '2024-03-08 18:46:39', '2024-06-01', 1),
(3, 103, 'Bob Johnson', 'bob@example.com', '8765432109', 'bob_photo.jpg', 'Sue Johnson', 'sue@example.com', '7654321098', 'Tom Johnson', 'tom@example.com', '6543210987', '789 Pine St', 'Villageville', 'TX', '67890', 3, '2024-03-08 18:46:39', '2024-09-01', 0);

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `id` int(11) NOT NULL,
  `teacher_id` int(255) NOT NULL,
  `profile_photo` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `age` varchar(20) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `tech_stake` varchar(255) NOT NULL,
  `Experience` varchar(255) NOT NULL,
  `resume` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(50) NOT NULL,
  `pin` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `active` int(11) NOT NULL DEFAULT 0,
  `verified` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`id`, `teacher_id`, `profile_photo`, `name`, `email`, `contact`, `age`, `gender`, `tech_stake`, `Experience`, `resume`, `address`, `city`, `state`, `pin`, `created_at`, `active`, `verified`) VALUES
(1, 201, 'teacher1_photo.jpg', 'Alice Teacher', 'alice@example.com', '9876543210', '30', 'Female', 'Mathematics', '5 years', 'alice_resume.pdf', '456 Oak St', 'Cityville', 'CA', '12345', '2024-03-08 18:46:39', 1, 1),
(2, 202, 'teacher2_photo.jpg', 'Bob Educator', 'bob@example.com', '8765432109', '35', 'Male', 'Physics', '8 years', 'bob_resume.pdf', '789 Pine St', 'Townsville', 'NY', '54321', '2024-03-08 18:46:39', 1, 1),
(3, 203, 'teacher3_photo.jpg', 'Charlie Instructor', 'charlie@example.com', '7654321098', '28', 'Male', 'Chemistry', '3 years', 'charlie_resume.pdf', '123 Main St', 'Villageville', 'TX', '67890', '2024-03-08 18:46:39', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `user_id` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `role` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_id`, `email`, `password`, `created_at`, `role`) VALUES
(1, 101, 'john@example.com', 'hashed_password', '2024-03-08 18:46:39', 1),
(2, 102, 'jane@example.com', 'hashed_password', '2024-03-08 18:46:39', 1),
(3, 103, 'bob@example.com', 'hashed_password', '2024-03-08 18:46:39', 1);

-- --------------------------------------------------------

--
-- Table structure for table `video_call`
--

CREATE TABLE `video_call` (
  `id` int(11) NOT NULL,
  `doubt_id` int(255) NOT NULL,
  `videocall_link` varchar(255) NOT NULL,
  `join_code` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `video_call`
--

INSERT INTO `video_call` (`id`, `doubt_id`, `videocall_link`, `join_code`, `created_at`) VALUES
(1, 1, 'https://example.com/videocall1', '12345', '2024-03-08 18:46:39'),
(2, 2, 'https://example.com/videocall2', '67890', '2024-03-08 18:46:39'),
(3, 3, 'https://example.com/videocall3', '23456', '2024-03-08 18:46:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `doubt`
--
ALTER TABLE `doubt`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doubt_submission`
--
ALTER TABLE `doubt_submission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription_plan`
--
ALTER TABLE `subscription_plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription_user`
--
ALTER TABLE `subscription_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_call`
--
ALTER TABLE `video_call`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `doubt`
--
ALTER TABLE `doubt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `doubt_submission`
--
ALTER TABLE `doubt_submission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subscription_plan`
--
ALTER TABLE `subscription_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subscription_user`
--
ALTER TABLE `subscription_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `video_call`
--
ALTER TABLE `video_call`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
