-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2023 at 06:07 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mathsquiz`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminUsername` varchar(20) NOT NULL,
  `AdminFullName` varchar(50) NOT NULL,
  `AdminPassword` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `ClassID` int(11) NOT NULL,
  `TeacherUsername` varchar(20) NOT NULL,
  `ClassName` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `QuestionID` int(11) NOT NULL,
  `SetID` int(11) NOT NULL,
  `QuestionNumber` int(2) NOT NULL,
  `Question` text NOT NULL,
  `OptionA` varchar(50) NOT NULL,
  `OptionB` varchar(50) NOT NULL,
  `OptionC` varchar(50) NOT NULL,
  `OptionD` varchar(50) NOT NULL,
  `Answer` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`QuestionID`, `SetID`, `QuestionNumber`, `Question`, `OptionA`, `OptionB`, `OptionC`, `OptionD`, `Answer`) VALUES
(1, 1, 1, '1 + 1 = ?', '2', '199', '32', '1', '2'),
(2, 1, 2, 'X + 5 = 2, find x', '3432', '1', '3', '90', '3'),
(3, 1, 3, '21 - 22 = ?', '2', '-1', '3', '1', '-1');

-- --------------------------------------------------------

--
-- Table structure for table `question_set`
--

CREATE TABLE `question_set` (
  `SetID` int(11) NOT NULL,
  `SetName` varchar(50) NOT NULL,
  `TeacherUsername` varchar(20) NOT NULL,
  `TopicID` int(11) NOT NULL,
  `SetApprovalStatus` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `question_set`
--

INSERT INTO `question_set` (`SetID`, `SetName`, `TeacherUsername`, `TopicID`, `SetApprovalStatus`) VALUES
(1, 'Set 1 Function', 'maow', 1, 'ACCEPTED'),
(2, 'Set 2 Function', 'maow', 1, ''),
(7, 'Set 1 Quadratic Function', 'maow', 2, 'ACCEPTED');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `StudentUsername` varchar(20) NOT NULL,
  `StudentFullName` varchar(50) NOT NULL,
  `StudentPassword` varchar(8) NOT NULL,
  `ClassID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_answer`
--

CREATE TABLE `student_answer` (
  `AnswerID` int(11) NOT NULL,
  `TrialID` int(11) NOT NULL,
  `QuestionID` int(11) NOT NULL,
  `StudentAnswer` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `TeacherUsername` varchar(20) NOT NULL,
  `TeacherFullName` varchar(50) NOT NULL,
  `TeacherPassword` varchar(8) NOT NULL,
  `ApprovalStatus` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`TeacherUsername`, `TeacherFullName`, `TeacherPassword`, `ApprovalStatus`) VALUES
('maow', 'Cat Doorbell', 'meow1234', 'ACCEPTED');

-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

CREATE TABLE `topic` (
  `TopicID` int(11) NOT NULL,
  `TopicTitle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `topic`
--

INSERT INTO `topic` (`TopicID`, `TopicTitle`) VALUES
(1, 'Functions'),
(2, 'More Functions');

-- --------------------------------------------------------

--
-- Table structure for table `trial`
--

CREATE TABLE `trial` (
  `TrialID` int(11) NOT NULL,
  `StudentUsername` varchar(20) NOT NULL,
  `SetID` int(11) NOT NULL,
  `DateTime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Comment` text DEFAULT NULL,
  `TimeTaken` time DEFAULT NULL,
  `QuizType` varchar(8) NOT NULL,
  `Score` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminUsername`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`ClassID`),
  ADD KEY `TeacherUsername` (`TeacherUsername`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`QuestionID`),
  ADD KEY `SetID` (`SetID`);

--
-- Indexes for table `question_set`
--
ALTER TABLE `question_set`
  ADD PRIMARY KEY (`SetID`),
  ADD KEY `TeacherUsername` (`TeacherUsername`),
  ADD KEY `TopicID` (`TopicID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`StudentUsername`),
  ADD KEY `ClassID` (`ClassID`);

--
-- Indexes for table `student_answer`
--
ALTER TABLE `student_answer`
  ADD PRIMARY KEY (`AnswerID`),
  ADD KEY `TrialID` (`TrialID`),
  ADD KEY `QuestionID` (`QuestionID`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`TeacherUsername`);

--
-- Indexes for table `topic`
--
ALTER TABLE `topic`
  ADD PRIMARY KEY (`TopicID`);

--
-- Indexes for table `trial`
--
ALTER TABLE `trial`
  ADD PRIMARY KEY (`TrialID`),
  ADD KEY `StudentUsername` (`StudentUsername`),
  ADD KEY `SetID` (`SetID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `ClassID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `QuestionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `question_set`
--
ALTER TABLE `question_set`
  MODIFY `SetID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `student_answer`
--
ALTER TABLE `student_answer`
  MODIFY `AnswerID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `topic`
--
ALTER TABLE `topic`
  MODIFY `TopicID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `trial`
--
ALTER TABLE `trial`
  MODIFY `TrialID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `class_ibfk_1` FOREIGN KEY (`TeacherUsername`) REFERENCES `teacher` (`TeacherUsername`);

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`SetID`) REFERENCES `question_set` (`SetID`);

--
-- Constraints for table `question_set`
--
ALTER TABLE `question_set`
  ADD CONSTRAINT `question_set_ibfk_1` FOREIGN KEY (`TeacherUsername`) REFERENCES `teacher` (`TeacherUsername`),
  ADD CONSTRAINT `question_set_ibfk_2` FOREIGN KEY (`TopicID`) REFERENCES `topic` (`TopicID`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`ClassID`) REFERENCES `class` (`ClassID`);

--
-- Constraints for table `student_answer`
--
ALTER TABLE `student_answer`
  ADD CONSTRAINT `student_answer_ibfk_1` FOREIGN KEY (`TrialID`) REFERENCES `trial` (`TrialID`),
  ADD CONSTRAINT `student_answer_ibfk_2` FOREIGN KEY (`QuestionID`) REFERENCES `question` (`QuestionID`);

--
-- Constraints for table `trial`
--
ALTER TABLE `trial`
  ADD CONSTRAINT `trial_ibfk_1` FOREIGN KEY (`StudentUsername`) REFERENCES `student` (`StudentUsername`),
  ADD CONSTRAINT `trial_ibfk_2` FOREIGN KEY (`SetID`) REFERENCES `question_set` (`SetID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
