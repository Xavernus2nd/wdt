-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2023 at 02:39 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `ClassID` varchar(5) NOT NULL,
  `TeacherUsername` varchar(20) NOT NULL,
  `ClassName` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `QuestionID` varchar(6) NOT NULL,
  `QuestionNo` int(3) NOT NULL,
  `SetID` varchar(4) NOT NULL,
  `Question` text NOT NULL,
  `OptionA` varchar(50) NOT NULL,
  `OptionB` varchar(50) NOT NULL,
  `OptionC` varchar(50) NOT NULL,
  `OptionD` varchar(50) NOT NULL,
  `Answer` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`QuestionID`, `QuestionNo`, `SetID`, `Question`, `OptionA`, `OptionB`, `OptionC`, `OptionD`, `Answer`) VALUES
('Q00001', 1, 'S001', '1 + 1 = ?', '2', '4', '1', '10', '2'),
('Q00002', 2, 'S001', 'x + 2 = 5, find x', '2', '9', '3', '53', '3'),
('Q00003', 3, 'S001', 'how many e in meow meow?', '43', '1', '4', '2', '2');

-- --------------------------------------------------------

--
-- Table structure for table `question_set`
--

CREATE TABLE `question_set` (
  `SetID` varchar(4) NOT NULL,
  `SetName` varchar(50) NOT NULL,
  `TeacherUsername` varchar(20) NOT NULL,
  `TopicID` varchar(3) NOT NULL,
  `SetApprovalStatus` varchar(8) NOT NULL,
  `NoOfQuestions` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `question_set`
--

INSERT INTO `question_set` (`SetID`, `SetName`, `TeacherUsername`, `TopicID`, `SetApprovalStatus`, `NoOfQuestions`) VALUES
('S001', 'Set 1 Function', 'mastura', 'T01', 'ACCEPTED', 3),
('S002', 'Set 2 Function', 'haruto', 'T01', 'ACCEPTED', 4),
('S003', 'Set 1 Quadratic Function', 'mastura', 'T02', 'ACCEPTED', 5);

-- --------------------------------------------------------

--
-- Table structure for table `result`
--

CREATE TABLE `result` (
  `TrialID` varchar(6) NOT NULL,
  `StudentUsername` varchar(20) NOT NULL,
  `SetID` varchar(4) NOT NULL,
  `DateTime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Comment` text DEFAULT NULL,
  `TimeTaken` time NOT NULL,
  `QuizType` varchar(8) NOT NULL,
  `Score` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `StudentUsername` varchar(20) NOT NULL,
  `StudentFullName` varchar(50) NOT NULL,
  `StudentPassword` varchar(8) NOT NULL,
  `ClassID` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`StudentUsername`, `StudentFullName`, `StudentPassword`, `ClassID`) VALUES
('alya', 'mastura alya', 'aizen123', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_answer`
--

CREATE TABLE `student_answer` (
  `id` int(11) NOT NULL,
  `QuestionID` varchar(6) NOT NULL,
  `StudentUsername` varchar(20) NOT NULL,
  `StudentAnswer` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `TeacherUsername` varchar(20) NOT NULL,
  `TeacherFullName` varchar(50) NOT NULL,
  `TeacherPassword` varchar(8) NOT NULL,
  `ApprovalStatus` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`TeacherUsername`, `TeacherFullName`, `TeacherPassword`, `ApprovalStatus`) VALUES
('haruto', 'Watanabe Haruto', 'treasure', 'ACCEPTED'),
('mastura', 'Alya Mastura', 'aizen123', 'ACCEPTED');

-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

CREATE TABLE `topic` (
  `TopicID` varchar(3) NOT NULL,
  `TopicTitle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `topic`
--

INSERT INTO `topic` (`TopicID`, `TopicTitle`) VALUES
('T01', 'Functions'),
('T02', 'Quadratic Functions');

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
-- Indexes for table `result`
--
ALTER TABLE `result`
  ADD PRIMARY KEY (`TrialID`),
  ADD KEY `StudentUsername` (`StudentUsername`),
  ADD KEY `SetID` (`SetID`);

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
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `student_answer`
--
ALTER TABLE `student_answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
-- Constraints for table `result`
--
ALTER TABLE `result`
  ADD CONSTRAINT `result_ibfk_1` FOREIGN KEY (`StudentUsername`) REFERENCES `student` (`StudentUsername`),
  ADD CONSTRAINT `result_ibfk_2` FOREIGN KEY (`SetID`) REFERENCES `question_set` (`SetID`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`ClassID`) REFERENCES `class` (`ClassID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
