-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2024 at 07:13 PM
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
  `position` varchar(25) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`emp_id`, `empl_firstname`, `empl_lastname`, `email`, `password`, `position`, `department_id`) VALUES
(8, 'Jonniel', 'Mirafuentes', 'jmirafuentes47@gmail.com', '$2y$10$djp2zn14Do9p6P5roAuotOFIl/cQiS6osWnie2EUHyPEr4UJ8pLf6', 'Administrator', 3),
(11, 'Famira', 'Catalan', 'famcat@email.com', '$2y$10$tV7ZvuaxF/wJ0/sunVi5Wei41jMLXPFaxTohCYC6IH/XZr8rIwf9y', 'Employee', 6),
(12, 'Anna', 'Bote', 'anna@anna', '$2y$10$xLNshkTIgCIaJ0XsOsa7bufnUyA.YrhaMdooKk.6bmB9Q.1jsz39m', 'Project Manager', 6),
(13, 'Lance', 'Alcordo', 'lalance@email.com', '$2y$10$scoMZte0RFdJA5EoCn6Pi.Ch4ZEyB8kEpQo5z7uLJueBQ8G0m8YMG', 'Project Manager', 3),
(16, 'Princess', 'Caballeda', 'princess@gmail.com', '$2y$10$Fy7LBrlXWVn6SvodYPbeueRpWVlkUT/D3EAgNFUXNmWXWSmZrkjW.', 'Project Manager', 4);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` int(6) NOT NULL,
  `project_name` varchar(100) NOT NULL,
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
(13, 'test', '2024-05-15', '2024-06-13', 11, 'Active', 'PHAgc3R5bGU9ImNvbG9yOiByZ2IoMzMsIDM3LCA0MSk7IGZvbnQtZmFtaWx5OiBzeXN0ZW0tdWksIC1hcHBsZS1zeXN0ZW0sICZxdW90O1NlZ29lIFVJJnF1b3Q7LCBSb2JvdG8sICZxdW90O0hlbHZldGljYSBOZXVlJnF1b3Q7LCBBcmlhbCwgJnF1b3Q7Tm90byBTYW5zJnF1b3Q7LCAmcXVvdDtMaWJlcmF0aW9uIFNhbnMmcXVvdDssIHNhbnMtc2VyaWYsICZxdW90O0FwcGxlIENvbG9yIEVtb2ppJnF1b3Q7LCAmcXVvdDtTZWdvZSBVSSBFbW9qaSZxdW90OywgJnF1b3Q7U2Vnb2UgVUkgU3ltYm9sJnF1b3Q7LCAmcXVvdDtOb3RvIENvbG9yIEVtb2ppJnF1b3Q7OyI+TG9yZW0gaXBzdW0gZG9sb3Igc2l0IGFtZXQuIFF1aSBub2JpcyBkb2xvcmVtIGF1dCBvZGl0IG1pbnVzIGlkIHF1YWVyYXQgdG90YW0gdXQgcXVhZSBxdW9kIHF1byBhZGlwaXNjaSBsaWJlcm8gdXQgbmVxdWUgc3VudC4gRWEgYmxhbmRpdGlpcyBtb2xlc3RpYWUgZXVtIHJlcnVtIHNhZXBlIGEgcXVhc2kgZXhjZXB0dXJpIGVzdCBlc3NlIGZhY2VyZS4gU2VkIHZvbHVwdGF0ZW0gZmFjZXJlIHZlbCBhbmltaSBlc3NlIGVvcyBleHBsaWNhYm8gbmVzY2l1bnQuIFF1aSBlaXVzIG1heGltZSBub24gb21uaXMgZnVnYSB1dCBhbGlhcyBibGFuZGl0aWlzIGV0IHZvbHVwdGF0ZW0gcXVhZXJhdCBlb3MgcXVhbSBpbGxvIHNpdCBhcGVyaWFtIFF1aXMuPC9wPjxwIHN0eWxlPSJjb2xvcjogcmdiKDMzLCAzNywgNDEpOyBmb250LWZhbWlseTogc3lzdGVtLXVpLCAtYXBwbGUtc3lzdGVtLCAmcXVvdDtTZWdvZSBVSSZxdW90OywgUm9ib3RvLCAmcXVvdDtIZWx2ZXRpY2EgTmV1ZSZxdW90OywgQXJpYWwsICZxdW90O05vdG8gU2FucyZxdW90OywgJnF1b3Q7TGliZXJhdGlvbiBTYW5zJnF1b3Q7LCBzYW5zLXNlcmlmLCAmcXVvdDtBcHBsZSBDb2xvciBFbW9qaSZxdW90OywgJnF1b3Q7U2Vnb2UgVUkgRW1vamkmcXVvdDssICZxdW90O1NlZ29lIFVJIFN5bWJvbCZxdW90OywgJnF1b3Q7Tm90byBDb2xvciBFbW9qaSZxdW90OzsiPjMzIGVhcnVtIG1heGltZSBub24gc3VudCBtaW5pbWEgZXN0IGN1bXF1ZSBxdWlhIGVzdCBhbmltaSBvbW5pcyBBdCBhcmNoaXRlY3RvIG5lc2NpdW50IGV0IGlwc2FtIHJlcGVsbGVuZHVzPyBRdWkgcmVwZWxsYXQgc2ludCBzaXQgaW5jaWR1bnQgdm9sdXB0YXRlbSBub24gZW5pbSB2b2x1cHRhdHVtLiBFc3QgZXZlbmlldCBxdWFtIGV1bSBzdXNjaXBpdCBkZWxlbml0aSBzaXQgcXVpcyBjb21tb2RpIHF1aSBiZWF0YWUgZ2FsaXN1bSAzMyBlbGlnZW5kaSBmdWdpdCB1dCB2ZW5pYW0gc2VxdWkgcXVpIGdhbGlzdW0gYXRxdWUhPC9wPjxwIHN0eWxlPSJjb2xvcjogcmdiKDMzLCAzNywgNDEpOyBmb250LWZhbWlseTogc3lzdGVtLXVpLCAtYXBwbGUtc3lzdGVtLCAmcXVvdDtTZWdvZSBVSSZxdW90OywgUm9ib3RvLCAmcXVvdDtIZWx2ZXRpY2EgTmV1ZSZxdW90OywgQXJpYWwsICZxdW90O05vdG8gU2FucyZxdW90OywgJnF1b3Q7TGliZXJhdGlvbiBTYW5zJnF1b3Q7LCBzYW5zLXNlcmlmLCAmcXVvdDtBcHBsZSBDb2xvciBFbW9qaSZxdW90OywgJnF1b3Q7U2Vnb2UgVUkgRW1vamkmcXVvdDssICZxdW90O1NlZ29lIFVJIFN5bWJvbCZxdW90OywgJnF1b3Q7Tm90byBDb2xvciBFbW9qaSZxdW90OzsiPkV0IGxhYm9yaW9zYW0gZmFjaWxpcyBlYSBwb3NzaW11cyBkaXN0aW5jdGlvIGVvcyBvZGlvIGluY2lkdW50IGV0IGFzc3VtZW5kYSBoYXJ1bS4gRXQgaXVyZSBxdWFzaSBhZCBkb2xvciBhY2N1c2FtdXMgc2l0IGNvcnJ1cHRpIGZ1Z2l0IGV0IGF0cXVlIHBvcnJvIHZlbCBuZWNlc3NpdGF0aWJ1cyBpbnRlcm5vcyBzZWQgb2RpbyBhc3Blcm5hdHVyIHV0IGxhYm9yZSBvZGl0LiBTaXQgZG9sb3JlbXF1ZSBmYWNlcmUgc2VkIGRvbG9yaWJ1cyBjb3Jwb3JpcyBzZWQgcXVpYnVzZGFtIFF1aXMuPC9wPg=='),
(14, 'Creation of tasks', '2024-05-15', '2024-05-30', 16, 'Completed', 'Y3JlYXRlZCBsaXN0IGlzIGhlcmU6IDxiPmFzd2EgaGFubXc8L2I+PGRpdj48Yj4xLiA8L2I+YXNkandhZDwvZGl2PjxkaXY+Mi4gPGI+c2Rhc2RqaHcgPHU+ZGFzZHc8aT5hd2Rhd2Q8L2k+PC91PjwvYj48L2Rpdj4='),
(15, 'Text this Project Out', '2024-05-14', '2024-05-30', 12, 'Active', 'UHV0IHRleHQgaGVoZTxkaXY+PG9sPjxsaT5IZXJlIGlzIHRoZSB0ZXh0Li4uLi4uLjwvbGk+PC9vbD48L2Rpdj4='),
(16, 'Hash Map Test', '2024-05-15', '2024-05-15', 13, 'Active', 'TG9yZW0gaXBzdW0gZG9sb3Igc2l0IGFtZXQsIGNvbnNlY3RldHVyIGFkaXBpc2NpbmcgZWxpdCwgc2VkIGRvIGVpdXNtb2QgdGVtcG9yIGluY2lkaWR1bnQgdXQgbGFib3JlIGV0IGRvbG9yZSBtYWduYSBhbGlxdWEuIFV0IGVuaW0gYWQgbWluaW0gdmVuaWFtLCBxdWlzIG5vc3RydWQgZXhlcmNpdGF0aW9uIHVsbGFtY28gbGFib3JpcyB'),
(17, 'Create This', '2024-05-15', '2024-05-30', 12, 'Active', 'PGI+Q3JlYXRlIFRhc2tzPC9iPjxkaXY+PGJyPjwvZGl2PjxkaXY+d2FmYXNmYXNkPGJyPmFzd2FhJm5ic3A7PC9kaXY+'),
(18, 'Meat', '2024-05-17', '2024-06-07', 16, 'Active', 'TG9yZW0gaXBzdW0gZG9sb3Igc2l0IGFtZXQuIE5vbiBjb25zZXF1YXR1ciB2ZW5pYW0gZW9zIHJlcnVtIHF1aWEgZXN0IHZvbHVwdGF0ZW0gZXNzZSBzaXQgY29uc2VxdXVudHVyIGVzc2UuIFF1aSBtb2RpIHRlbXBvcmlidXMgZW9zIHN1bnQgcGVyZmVyZW5kaXMgcmVtIGV2ZW5pZXQgcXVpYSByZW0gbGFib3J1bSBkb2xvcmVtPyBFdCB');

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
(13, 12),
(13, 16),
(14, 8),
(14, 11),
(14, 12),
(14, 13),
(15, 8),
(16, 8),
(16, 11),
(16, 12),
(17, 8),
(17, 11),
(17, 12),
(18, 12);

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
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`);

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
