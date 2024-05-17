-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2024 at 10:18 PM
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
-- Database: `remoteforce_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `department_name`) VALUES
(1, 'Bussiness Development'),
(2, 'Development'),
(3, 'Design'),
(4, 'Marketing'),
(5, 'Customer Support'),
(6, 'Cybersecurity');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `emp_id` int(11) NOT NULL,
  `empl_firstname` varchar(25) DEFAULT NULL,
  `empl_lastname` varchar(25) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `position` varchar(15) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`emp_id`, `empl_firstname`, `empl_lastname`, `email`, `password`, `position`, `department_id`) VALUES
(8, 'Administrator', '', 'ad.min', '$2y$10$Ls9j0p5ZdJzrMlaBSRtRJu21DEMVs5ymhumLQ9a5cwOc7RvP0QUwG', 'Administrator', 3),
(11, 'Famira', 'Catalan', 'famcat@email.com', '$2y$10$tV7ZvuaxF/wJ0/sunVi5Wei41jMLXPFaxTohCYC6IH/XZr8rIwf9y', 'Employee', 6),
(16, 'Princess', 'Caballeda', 'princess@gmail.com', '$2y$10$Fy7LBrlXWVn6SvodYPbeueRpWVlkUT/D3EAgNFUXNmWXWSmZrkjW.', 'Project Manager', 4),
(23, 'Lance', 'Alcordo', 'lance@email.com', '$2y$10$Vcxeyo7OXV3zVrrUereOGOLaNaUvKMepI2q15QDmcpIiJ11/zGL02', 'Project Manager', 3);

-- --------------------------------------------------------

--
-- Table structure for table `productivitytracking`
--

CREATE TABLE `productivitytracking` (
  `tracking_id` int(6) NOT NULL,
  `task_id` int(6) DEFAULT NULL,
  `emp_id` int(6) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `prod_description` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productivitytracking`
--

INSERT INTO `productivitytracking` (`tracking_id`, `task_id`, `emp_id`, `date`, `start_time`, `end_time`, `prod_description`) VALUES
(7, 10, 8, '2024-05-18', '02:04:00', '03:04:00', 'PHNwYW4gc3R5bGU9ImZvbnQtZmFtaWx5OiBzeXN0ZW0tdWksIC1hcHBsZS1zeXN0ZW0sICZxdW90O1NlZ29lIFVJJnF1b3Q7LCBSb2JvdG8sICZxdW90O0hlbHZldGljYSBOZXVlJnF1b3Q7LCBBcmlhbCwgJnF1b3Q7Tm90byBTYW5zJnF1b3Q7LCAmcXVvdDtMaWJlcmF0aW9uIFNhbnMmcXVvdDssIHNhbnMtc2VyaWYsICZxdW90O0FwcGxlIENvbG9yIEVtb2ppJnF1b3Q7LCAmcXVvdDtTZWdvZSBVSSBFbW9qaSZxdW90OywgJnF1b3Q7U2Vnb2UgVUkgU3ltYm9sJnF1b3Q7LCAmcXVvdDtOb3RvIENvbG9yIEVtb2ppJnF1b3Q7OyI+TG9yZW0gaXBzdW0gZG9sb3Igc2l0IGFtZXQuIFF1aSBub2JpcyBkb2xvcmVtIGF1dCBvZGl0IG1pbnVzIGlkIHF1YWVyYXQgdG90YW0gdXQgcXVhZSBxdW9kIHF1byBhZGlwaXNjaSBsaWJlcm8gdXQgbmVxdWUgc3VudC4gRWEgYmxhbmRpdGlpcyBtb2xlc3RpYWUgZXVtIHJlcnVtIHNhZXBlIGEgcXVhc2kgZXhjZXB0dXJpIGVzdCBlc3NlIGZhY2VyZS4gU2VkIHZvbHVwdGF0ZW0gZmFjZXJlIHZlbCBhbmltaSBlc3NlIGVvcyBleHBsaWNhYm8gbmVzY2l1bnQuIFF1aSBlaXVzIG1heGltZSBub24gb21uaXMgZnVnYSB1dCBhbGlhcyBibGFuZGl0aWlzIGV0Jm5ic3A7PC9zcGFuPjx1IHN0eWxlPSJmb250LWZhbWlseTogc3lzdGVtLXVpLCAtYXBwbGUtc3lzdGVtLCAmcXVvdDtTZWdvZSBVSSZxdW90OywgUm9ib3RvLCAmcXVvdDtIZWx2ZXRpY2EgTmV1ZSZxdW90OywgQXJpYWwsICZxdW90O05vdG8gU2FucyZxdW90OywgJnF1b3Q7TGliZXJhdGlvbiBTYW5zJnF1b3Q7LCBzYW5zLXNlcmlmLCAmcXVvdDtBcHBsZSBDb2xvciBFbW9qaSZxdW90OywgJnF1b3Q7U2Vnb2UgVUkgRW1vamkmcXVvdDssICZxdW90O1NlZ29lIFVJIFN5bWJvbCZxdW90OywgJnF1b3Q7Tm90byBDb2xvciBFbW9qaSZxdW90OzsiPjxpPnZvbHVwdGF0ZW0gcXVhZXJhdCBlb3MgcXVhbSBpbGxvIHNpdCBhcGVyaWFtIFF1aXMuPC9pPjwvdT4=');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` int(6) NOT NULL,
  `project_name` varchar(50) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `project_manager` int(6) DEFAULT NULL,
  `project_status` enum('Active','Completed','On Hold') NOT NULL,
  `proj_description` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`project_id`, `project_name`, `start_date`, `end_date`, `project_manager`, `project_status`, `proj_description`) VALUES
(13, 'Create Database', '2024-05-15', '2024-06-13', 16, 'Active', 'PHAgc3R5bGU9ImNvbG9yOiByZ2IoMzMsIDM3LCA0MSk7IGZvbnQtZmFtaWx5OiBzeXN0ZW0tdWksIC1hcHBsZS1zeXN0ZW0sICZxdW90O1NlZ29lIFVJJnF1b3Q7LCBSb2JvdG8sICZxdW90O0hlbHZldGljYSBOZXVlJnF1b3Q7LCBBcmlhbCwgJnF1b3Q7Tm90byBTYW5zJnF1b3Q7LCAmcXVvdDtMaWJlcmF0aW9uIFNhbnMmcXVvdDssIHNhbnMtc2VyaWYsICZxdW90O0FwcGxlIENvbG9yIEVtb2ppJnF1b3Q7LCAmcXVvdDtTZWdvZSBVSSBFbW9qaSZxdW90OywgJnF1b3Q7U2Vnb2UgVUkgU3ltYm9sJnF1b3Q7LCAmcXVvdDtOb3RvIENvbG9yIEVtb2ppJnF1b3Q7OyI+TG9yZW0gaXBzdW0gZG9sb3Igc2l0IGFtZXQuIFF1aSBub2JpcyBkb2xvcmVtIGF1dCBvZGl0IG1pbnVzIGlkIHF1YWVyYXQgdG90YW0gdXQgcXVhZSBxdW9kIHF1byBhZGlwaXNjaSBsaWJlcm8gdXQgbmVxdWUgc3VudC4gRWEgYmxhbmRpdGlpcyBtb2xlc3RpYWUgZXVtIHJlcnVtIHNhZXBlIGEgcXVhc2kgZXhjZXB0dXJpIGVzdCBlc3NlIGZhY2VyZS4gU2VkIHZvbHVwdGF0ZW0gZmFjZXJlIHZlbCBhbmltaSBlc3NlIGVvcyBleHBsaWNhYm8gbmVzY2l1bnQuIFF1aSBlaXVzIG1heGltZSBub24gb21uaXMgZnVnYSB1dCBhbGlhcyBibGFuZGl0aWlzIGV0IDx1PjxpPnZvbHVwdGF0ZW0gcXVhZXJhdCBlb3MgcXVhbSBpbGxvIHNpdCBhcGVyaWFtIFF1aXMuPC9pPjwvdT48L3A+PHAgc3R5bGU9ImNvbG9yOiByZ2IoMzMsIDM3LCA0MSk7IGZvbnQtZmFtaWx5OiBzeXN0ZW0tdWksIC1hcHBsZS1zeXN0ZW0sICZxdW90O1NlZ29lIFVJJnF1b3Q7LCBSb2JvdG8sICZxdW90O0hlbHZldGljYSBOZXVlJnF1b3Q7LCBBcmlhbCwgJnF1b3Q7Tm90byBTYW5zJnF1b3Q7LCAmcXVvdDtMaWJlcmF0aW9uIFNhbnMmcXVvdDssIHNhbnMtc2VyaWYsICZxdW90O0FwcGxlIENvbG9yIEVtb2ppJnF1b3Q7LCAmcXVvdDtTZWdvZSBVSSBFbW9qaSZxdW90OywgJnF1b3Q7U2Vnb2UgVUkgU3ltYm9sJnF1b3Q7LCAmcXVvdDtOb3RvIENvbG9yIEVtb2ppJnF1b3Q7OyI+PGI+MzMgZWFydW0gbWF4aW1lIG5vbiBzdW50IG1pbmltYSBlc3QgY3VtcXVlIHF1aWEgZXN0IGFuaW1pIG9tbmlzIEF0IGFyY2hpdGVjdG8gbmVzY2l1bnQgZXQgaXBzYW0gcmVwZWxsZW5kdXM/IFF1aSByZXBlbGxhdCBzaW50IHNpdCBpbmNpZHVudCB2b2x1cHRhdGVtIG5vbiBlbmltIHZvbHVwdGF0dW0uIEVzdCBldmVuaWV0IHF1YW0gZXVtIHN1c2NpcGl0IGRlbGVuaXRpIHNpdCBxdWlzIGNvbW1vZGkgcXVpIGJlYXRhZSBnYWxpc3VtIDMzIGVsaWdlbmRpIGZ1Z2l0IHV0IHZlbmlhbSBzZXF1aSBxdWkgZ2FsaXN1bSBhdHF1ZSE8L2I+PC9wPjxwIHN0eWxlPSJjb2xvcjogcmdiKDMzLCAzNywgNDEpOyBmb250LWZhbWlseTogc3lzdGVtLXVpLCAtYXBwbGUtc3lzdGVtLCAmcXVvdDtTZWdvZSBVSSZxdW90OywgUm9ib3RvLCAmcXVvdDtIZWx2ZXRpY2EgTmV1ZSZxdW90OywgQXJpYWwsICZxdW90O05vdG8gU2FucyZxdW90OywgJnF1b3Q7TGliZXJhdGlvbiBTYW5zJnF1b3Q7LCBzYW5zLXNlcmlmLCAmcXVvdDtBcHBsZSBDb2xvciBFbW9qaSZxdW90OywgJnF1b3Q7U2Vnb2UgVUkgRW1vamkmcXVvdDssICZxdW90O1NlZ29lIFVJIFN5bWJvbCZxdW90OywgJnF1b3Q7Tm90byBDb2xvciBFbW9qaSZxdW90OzsiPkV0IGxhYm9yaW9zYW0gZmFjaWxpcyBlYSBwb3NzaW11cyBkaXN0aW5jdGlvIGVvcyBvZGlvIGluY2lkdW50IGV0IGFzc3VtZW5kYSBoYXJ1bS4gRXQgaXVyZSBxdWFzaSBhZCBkb2xvciBhY2N1c2FtdXMgc2l0IGNvcnJ1cHRpIGZ1Z2l0IGV0IGF0cXVlIHBvcnJvIHZlbCBuZWNlc3NpdGF0aWJ1cyBpbnRlcm5vcyBzZWQgb2RpbyBhc3Blcm5hdHVyIHV0IGxhYm9yZSBvZGl0LiBTaXQgZG9sb3JlbXF1ZSBmYWNlcmUgc2VkIGRvbG9yaWJ1cyBjb3Jwb3JpcyBzZWQgcXVpYnVzZGFtIFF1aXMuPC9wPg=='),
(16, 'Hash Map Test', '2024-05-15', '2024-05-15', 23, 'Active', 'TG9yZW0gaXBzdW0gZG9sb3Igc2l0IGFtZXQsIGNvbnNlY3RldHVyIDxiPmFkaXBpc2NpbmcgZWxpdDwvYj4sIHNlZCBkbyA8dT5laXVzbW9kIHRlbXBvciBpbmNpZGlkdW50IHV0IGxhYm9yZSBldDwvdT4gPGk+ZG9sb3JlIG1hZ25hIGFsaXF1YTwvaT4uIFV0IGVuaW0gYWQgbWluaW0gdmVuaWFtLCBxdWlzIG5vc3RydWQgZXhlcmNpdGF0aW9uIHVsbGFtY28gbGFib3JpcyA=');

-- --------------------------------------------------------

--
-- Table structure for table `project_members`
--

CREATE TABLE `project_members` (
  `project_id` int(6) DEFAULT NULL,
  `emp_id` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_members`
--

INSERT INTO `project_members` (`project_id`, `emp_id`) VALUES
(13, 16),
(16, 8),
(16, 11);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(11) NOT NULL,
  `task_name` varchar(50) DEFAULT NULL,
  `project_id` int(6) DEFAULT NULL,
  `emp_id` int(6) DEFAULT NULL,
  `priority` enum('Low','Medium','High') DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `task_status` enum('Pending','Completed','Past-due') DEFAULT NULL,
  `task_description` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`task_id`, `task_name`, `project_id`, `emp_id`, `priority`, `deadline`, `task_status`, `task_description`) VALUES
(10, 'Make your own Coffee', 13, 8, 'Low', '2024-05-27', 'Completed', 'PHAgc3R5bGU9ImZvbnQtZmFtaWx5OiBzeXN0ZW0tdWksIC1hcHBsZS1zeXN0ZW0sICZxdW90O1NlZ29lIFVJJnF1b3Q7LCBSb2JvdG8sICZxdW90O0hlbHZldGljYSBOZXVlJnF1b3Q7LCBBcmlhbCwgJnF1b3Q7Tm90byBTYW5zJnF1b3Q7LCAmcXVvdDtMaWJlcmF0aW9uIFNhbnMmcXVvdDssIHNhbnMtc2VyaWYsICZxdW90O0FwcGxlIENvbG9yIEVtb2ppJnF1b3Q7LCAmcXVvdDtTZWdvZSBVSSBFbW9qaSZxdW90OywgJnF1b3Q7U2Vnb2UgVUkgU3ltYm9sJnF1b3Q7LCAmcXVvdDtOb3RvIENvbG9yIEVtb2ppJnF1b3Q7OyI+PHNwYW4gc3R5bGU9ImZvbnQtd2VpZ2h0OiBib2xkZXI7Ij4zMyBlYXJ1bSBtYXhpbWUgbm9uIHN1bnQgbWluaW1hIGVzdCBjdW1xdWUgcXVpYSBlc3QgYW5pbWkgb21uaXMgQXQgYXJjaGl0ZWN0byBuZXNjaXVudCBldCBpcHNhbSByZXBlbGxlbmR1cz8gUXVpIHJlcGVsbGF0IHNpbnQgc2l0IGluY2lkdW50IHZvbHVwdGF0ZW0gbm9uIGVuaW0gdm9sdXB0YXR1bS4gRXN0IGV2ZW5pZXQgcXVhbSBldW0gc3VzY2lwaXQgZGVsZW5pdGkgc2l0IHF1aXMgY29tbW9kaSBxdWkgYmVhdGFlIGdhbGlzdW0gMzMgZWxpZ2VuZGkgZnVnaXQgdXQgdmVuaWFtIHNlcXVpIHF1aSBnYWxpc3VtIGF0cXVlITwvc3Bhbj48L3A+PHAgc3R5bGU9ImZvbnQtZmFtaWx5OiBzeXN0ZW0tdWksIC1hcHBsZS1zeXN0ZW0sICZxdW90O1NlZ29lIFVJJnF1b3Q7LCBSb2JvdG8sICZxdW90O0hlbHZldGljYSBOZXVlJnF1b3Q7LCBBcmlhbCwgJnF1b3Q7Tm90byBTYW5zJnF1b3Q7LCAmcXVvdDtMaWJlcmF0aW9uIFNhbnMmcXVvdDssIHNhbnMtc2VyaWYsICZxdW90O0FwcGxlIENvbG9yIEVtb2ppJnF1b3Q7LCAmcXVvdDtTZWdvZSBVSSBFbW9qaSZxdW90OywgJnF1b3Q7U2Vnb2UgVUkgU3ltYm9sJnF1b3Q7LCAmcXVvdDtOb3RvIENvbG9yIEVtb2ppJnF1b3Q7OyI+RXQgbGFib3Jpb3NhbSBmYWNpbGlzIGVhIHBvc3NpbXVzIGRpc3RpbmN0aW8gZW9zIG9kaW8gaW5jaWR1bnQgZXQgYXNzdW1lbmRhIGhhcnVtLiBFdCBpdXJlIHF1YXNpIGFkIGRvbG9yIGFjY3VzYW11cyBzaXQgY29ycnVwdGkgZnVnaXQgZXQgYXRxdWUgcG9ycm8gdmVsIG5lY2Vzc2l0YXRpYnVzIGludGVybm9zIHNlZCBvZGlvIGFzcGVybmF0dXIgdXQgbGFib3JlIG9kaXQuIFNpdCBkb2xvcmVtcXVlIGZhY2VyZSBzZWQgZG9sb3JpYnVzIGNvcnBvcmlzIHNlZCBxdWlidXNkYW0gUXVpcy48L3A+'),
(11, 'Another Task!', 13, 8, 'Medium', '2024-05-21', 'Pending', 'VGVzdCA8Yj5BR0FJTiE8L2I+'),
(12, 'Another One', 13, 8, 'Low', '2024-05-22', 'Pending', 'PGI+VEVTVCBUSElTIEFMTCBUSEUgV0FZPC9iPg=='),
(13, 'This task', 16, 8, 'Low', '2024-05-24', 'Pending', 'VGFzayBpcyBub3doZXJlIGNvbXBsZXRlZCBlbWU='),
(14, 'Thanks', 16, 8, 'Medium', '2024-05-21', 'Completed', 'SGFpc3Q=');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`emp_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `productivitytracking`
--
ALTER TABLE `productivitytracking`
  ADD PRIMARY KEY (`tracking_id`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `emp_id` (`emp_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`),
  ADD KEY `project_manager` (`project_manager`);

--
-- Indexes for table `project_members`
--
ALTER TABLE `project_members`
  ADD KEY `project_id` (`project_id`),
  ADD KEY `emp_id` (`emp_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `emp_id` (`emp_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `productivitytracking`
--
ALTER TABLE `productivitytracking`
  MODIFY `tracking_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`);

--
-- Constraints for table `productivitytracking`
--
ALTER TABLE `productivitytracking`
  ADD CONSTRAINT `productivitytracking_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`task_id`),
  ADD CONSTRAINT `productivitytracking_ibfk_2` FOREIGN KEY (`emp_id`) REFERENCES `employees` (`emp_id`);

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`project_manager`) REFERENCES `employees` (`emp_id`);

--
-- Constraints for table `project_members`
--
ALTER TABLE `project_members`
  ADD CONSTRAINT `project_members_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`),
  ADD CONSTRAINT `project_members_ibfk_2` FOREIGN KEY (`emp_id`) REFERENCES `employees` (`emp_id`);

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`),
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`emp_id`) REFERENCES `employees` (`emp_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
