-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2024 at 02:33 PM
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
  `teacher_id` int(255) DEFAULT NULL,
  `doubt_category` varchar(255) DEFAULT NULL,
  `doubt` varchar(255) DEFAULT NULL,
  `doubt_file` varchar(255) DEFAULT NULL,
  `doubt_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `answer` varchar(255) DEFAULT NULL,
  `answer_file` varchar(255) DEFAULT NULL,
  `answer_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `student_view` int(11) NOT NULL DEFAULT 0,
  `teacher_view` int(11) NOT NULL DEFAULT 0,
  `admin_view` int(11) NOT NULL DEFAULT 0,
  `accepted` int(11) NOT NULL DEFAULT 0,
  `doubt_submit` int(11) NOT NULL DEFAULT 0,
  `feedback` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doubt`
--

INSERT INTO `doubt` (`id`, `doubt_id`, `user_id`, `teacher_id`, `doubt_category`, `doubt`, `doubt_file`, `doubt_created_at`, `answer`, `answer_file`, `answer_created_at`, `student_view`, `teacher_view`, `admin_view`, `accepted`, `doubt_submit`, `feedback`) VALUES
(18, 872511, 873068, 586611, 'Economics', 'ones more question to check the file submission', '65f69d889edae_bohra.jpg', '2024-03-17 07:36:40', 'ones more question to check the file submission lets check again', '65f88d87e7c38_video.mp4', '2024-03-18 18:58:36', 2, 0, 0, 1, 1, 1),
(19, 506873, 873068, NULL, 'Physics', '\"Doubt submitted successfully.\" ,\"Great Doubt you ask \"', '65f6a5fb6aeb0_Burhanuddin Bohra resume.pdf', '2024-03-17 08:12:43', NULL, NULL, '2024-03-17 08:12:43', 1, 1, 0, 0, 0, 0),
(20, 491624, 873068, NULL, 'Physics', '\"Doubt submitted successfully.\" ,\"Great Doubt you ask \"', '65f6a69f1a251_Burhanuddin Bohra resume.pdf', '2024-03-17 08:15:27', NULL, NULL, '2024-03-17 08:15:27', 1, 1, 0, 0, 0, 0),
(21, 407523, 873068, 586611, 'Engg. Maths', 'I am trying to upload the video and now changing doubt', '65f973f8505ec_QR.jpg', '2024-03-19 11:16:08', 'So this a chat I want to end', '65f96ebd63a36_video.mp4', '2024-03-19 10:53:49', 2, 0, 0, 1, 1, 1),
(22, 169497, 504414, 586611, 'Maths', 'Checking new user ', '65f84e184540e_burhan.jpg', '2024-03-18 14:22:16', 'So u are a new user and trying for chat', '65f8942ee536d_QR.jpg', '2024-03-18 19:21:18', 2, 0, 0, 1, 1, 1),
(27, 882648, 504414, 586611, 'Economics', 'this is a trial doubt for final check and added video call link\r\n', '6601bf27e4886_Report_ A Session on ChatGPT.pdf(national technology day) (1).docx', '2024-03-26 21:45:44', 'So this a solution', '6603105c18b20_6601bf27e4886_Report_ A Session on ChatGPT.pdf(national technology day) (1) (2).docx', '2024-03-26 18:31:51', 1, 1, 0, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `doubt_submission`
--

CREATE TABLE `doubt_submission` (
  `id` int(11) NOT NULL,
  `doubt_id` int(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `verified` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `admin_view` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doubt_submission`
--

INSERT INTO `doubt_submission` (`id`, `doubt_id`, `description`, `verified`, `created_at`, `admin_view`) VALUES
(1, 1, 'Explanation of gravity', 1, '2024-03-08 18:46:39', 0),
(2, 2, 'Question about French capital', 0, '2024-03-08 18:46:39', 0),
(3, 3, 'Solving quadratic equations step by step', 1, '2024-03-08 18:46:39', 0);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `doubt_id` int(11) DEFAULT NULL,
  `teacher_id` int(255) NOT NULL,
  `satisfaction_level` int(11) DEFAULT NULL,
  `feedback_text` text DEFAULT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `doubt_id`, `teacher_id`, `satisfaction_level`, `feedback_text`, `submission_date`) VALUES
(1, 407523, 0, 4, 'great solution', '2024-03-19 11:36:00'),
(2, 169497, 586611, 5, 'No I understand the solution', '2024-03-19 14:12:56'),
(3, 872511, 586611, 3, 'Nice work', '2024-03-19 14:18:58');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_plan`
--

CREATE TABLE `subscription_plan` (
  `id` int(11) NOT NULL,
  `subscription_id` int(11) NOT NULL,
  `plan_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `duration` int(255) NOT NULL,
  `price` int(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscription_plan`
--

INSERT INTO `subscription_plan` (`id`, `subscription_id`, `plan_name`, `description`, `duration`, `price`, `created_at`) VALUES
(0, 0, 'Free Plan', 'No Access', 0, 0, '2024-04-05 13:26:47'),
(1, 1, 'Basic', 'Access to basic features', 1, 10, '2024-03-14 12:40:54'),
(2, 2, 'Premium', 'Access to premium features', 3, 25, '2024-03-14 12:41:04'),
(3, 3, 'Pro', 'Access to all features', 6, 50, '2024-03-14 12:41:10');

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
  `transaction_id` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `end_date` date NOT NULL,
  `verified` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscription_user`
--

INSERT INTO `subscription_user` (`id`, `user_id`, `name`, `email`, `contact`, `photo`, `mother_name`, `mother_email`, `mother_contact`, `father_name`, `father_email`, `father_contact`, `address`, `city`, `state`, `pin`, `subscription_id`, `transaction_id`, `created_at`, `end_date`, `verified`) VALUES
(7, 873068, 'Burhanuddin Bohra', 'burhanuddinb542@gmail.com', '8890919295', '65f69f4727751_bohra.jpg', 'Sakina Bohra', 'burhanuddinb542@gmail.com', '8890919295', 'Mustafa Bohra', 'burhanuddinb542@gmail.com', '8890919295', 'Burhani mohalla', 'Chhoti Sadri', 'Rajasthan', '312604', 3, '112378945678', '2024-03-17 13:14:07', '2024-09-17', 1),
(8, 504414, 'Bohra', 'murtazabohra786110@gmail.com', '9057543501', '65f84d68d83e8_burhan.jpg', 'Sakina Bohra', 'burhanuddinb542@gmail.com', '1234567890', 'Mustafa Bohra', 'burhanuddinb542@gmail.com', '9876543210', 'Bohra Colony Scheme no.36B', 'Neemuch', 'Madhya Pradesh', '312604', 1, '1234567890', '2024-03-18 19:49:20', '2024-04-18', 1);

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `id` int(11) NOT NULL,
  `teacher_id` int(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `age` varchar(20) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `tech_stack` varchar(255) NOT NULL,
  `experience` varchar(255) NOT NULL,
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

INSERT INTO `teacher` (`id`, `teacher_id`, `photo`, `name`, `email`, `contact`, `age`, `gender`, `tech_stack`, `experience`, `resume`, `address`, `city`, `state`, `pin`, `created_at`, `active`, `verified`) VALUES
(1, 201, 'teacher1_photo.jpg', 'Alice Teacher', 'alice@example.com', '9876543210', '30', 'Female', 'Mathematics', '5 years', 'alice_resume.pdf', '456 Oak St', 'Cityville', 'CA', '12345', '2024-03-08 18:46:39', 0, 1),
(2, 202, 'teacher2_photo.jpg', 'Bob Educator', 'bob@example.com', '8765432109', '35', 'Male', 'Physics', '8 years', 'bob_resume.pdf', '789 Pine St', 'Townsville', 'NY', '54321', '2024-03-08 18:46:39', 0, 1),
(3, 203, 'teacher3_photo.jpg', 'Charlie Instructor', 'charlie@example.com', '7654321098', '28', 'Male', 'Chemistry', '3 years', 'charlie_resume.pdf', '123 Main St', 'Villageville', 'TX', '67890', '2024-03-08 18:46:39', 0, 1),
(4, 586611, '65f6a7bbe9ff5_bohra.jpg', 'Burhanuddin Bohra', 'paawan0304@proton.me', '8890919295', '19', 'Male', 'HTML, CSS, Java', '2 year experience in coding', '65f6a7bbea017_Burhanuddin Bohra resume.pdf', 'Burhani mohalla', 'Chhoti Sadri', 'Rajasthan', '312604', '2024-03-16 15:14:18', 1, 1),
(5, 826177, '65f6a7bbe9ff5_bohra.jpg', 'Burhanuddin Bohra', '2022pietadburhanuddin013@poornima.org', '8890919295', '19', 'Male', 'HTML, CSS, Java', '3 years experience in coding', '65f6a7bbea017_Burhanuddin Bohra resume.pdf', 'ISI - 2, Poornima Marg, Sitapura, Jaipur, Rajasthan 302022', 'Jaipur', 'Rajasthan', '312604', '2024-03-17 13:50:11', 1, 0);

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
  `role` int(11) NOT NULL DEFAULT 0 COMMENT '1-student, 2-teacher, 3-admin, 4-parent\r\n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_id`, `email`, `password`, `created_at`, `role`) VALUES
(4, 873068, 'burhanuddinb542@gmail.com', '$2y$10$aLOpar8GdOEfwrh1Nl2Mye173uMAU/UW6ENwzpDP9VjjshjT.wKM2', '2024-03-09 22:34:02', 1),
(5, 826177, '2022pietadburhanuddin013@poornima.org', '$2y$10$29uKfVNer/vd5EDDZ4qzxuiu36nWQAZ/QprFxGzH0WV39g97rjO7e', '2024-03-14 11:14:53', 2),
(6, 586611, 'paawan0304@proton.me', '$2y$10$cx.k60hqssIBsIQAd37CSuoy3VajJvlwnMWUX2vjAwYjczO5jsRm6', '2024-03-16 15:06:19', 2),
(7, 504414, 'murtazabohra786110@gmail.com', '$2y$10$G9VH3ZPk9duqwY/gx0o/DeStTGLUKJv8y7PIAy3kd6y2ATIw4Epqm', '2024-03-18 19:46:33', 1),
(8, 880147, 'admin@admin.org', '$2y$10$VLvfsmHqfkKh3FqAXSNvMuQGboBw/gAHIfuBB314PTDiDFbPaeytS', '2024-04-03 21:14:48', 3),
(9, 287549, 'gunjan@gmail.com', '$2y$10$gVHBLLrAroVwOFfGpKM15ef6fWMxB3AnNFXAcwUH8jfxJfWi.8sbO', '2024-04-05 17:34:32', 0);

-- --------------------------------------------------------

--
-- Table structure for table `videocall_link`
--

CREATE TABLE `videocall_link` (
  `id` int(11) NOT NULL,
  `teacher_id` int(255) NOT NULL,
  `videocall_link` varchar(255) NOT NULL,
  `join_code` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_call`
--

CREATE TABLE `video_call` (
  `id` int(11) NOT NULL,
  `doubt_id` int(255) NOT NULL,
  `videocall_link` varchar(255) NOT NULL,
  `join_code` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `attend` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `video_call`
--

INSERT INTO `video_call` (`id`, `doubt_id`, `videocall_link`, `join_code`, `created_at`, `attend`) VALUES
(1, 1, 'https://example.com/videocall1', '12345', '2024-03-08 18:46:39', 0),
(2, 2, 'https://example.com/videocall2', '67890', '2024-03-08 18:46:39', 0),
(3, 3, 'https://example.com/videocall3', '23456', '2024-03-08 18:46:39', 0),
(4, 872511, 'https://example.com/videocall1', '7894561230', '2024-03-18 23:29:04', 0),
(5, 872511, 'https://example.com/videocall1', '7894561230', '2024-03-18 23:37:27', 0),
(6, 872511, 'https://example.com/videocall1', '7894561230', '2024-03-18 23:44:17', 0),
(7, 169497, '', '', '2024-03-19 00:51:18', 0),
(8, 407523, '', '', '2024-03-19 16:23:49', 0),
(9, 882648, 'https://app.zoom.us/wc/89329153590/start?fromPWA=1&pwd=iLp3hh4HXLtwEyCiNrars52YYkvG1g.RKyFPUC7J4mxkHAw', 'NA', '2024-03-26 23:43:48', 0);

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
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
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
-- Indexes for table `videocall_link`
--
ALTER TABLE `videocall_link`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `doubt_submission`
--
ALTER TABLE `doubt_submission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subscription_plan`
--
ALTER TABLE `subscription_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `subscription_user`
--
ALTER TABLE `subscription_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `videocall_link`
--
ALTER TABLE `videocall_link`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_call`
--
ALTER TABLE `video_call`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
