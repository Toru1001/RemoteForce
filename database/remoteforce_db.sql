-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2024 at 08:43 AM
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
(8, 'Administrator', '', 'admin', '$2y$10$Ls9j0p5ZdJzrMlaBSRtRJu21DEMVs5ymhumLQ9a5cwOc7RvP0QUwG', 'Administrator', 3),
(11, 'Famira', 'Catalan', 'famcat@email.com', '$2y$10$Gd4US3XTXHm2krg0wRzxvOMHl2KGlJlAJQlh11hj12a.O0zWJ1Ghy', 'Employee', 6),
(16, 'Princess', 'Caballeda', 'princess@gmail.com', '$2y$10$Fy7LBrlXWVn6SvodYPbeueRpWVlkUT/D3EAgNFUXNmWXWSmZrkjW.', 'Project Manager', 4),
(23, 'Lance', 'Alcordo', 'lance@email.com', '$2y$10$Vcxeyo7OXV3zVrrUereOGOLaNaUvKMepI2q15QDmcpIiJ11/zGL02', 'Project Manager', 3),
(26, 'Jonniel', 'Mirafuentes', 'jmirafuentes@email.com', '$2y$10$7XnpUa/DbCNhEMxtU1GmdOGAjnGJz.ovtFhtJARXZ0PV04XqULrou', 'Administrator', 6),
(27, 'Rachelle', 'Cuizon', 'rachelle@email.com', '$2y$10$OjCD4ztRtVtoLPqv.ydycuPgmYL2Vet.0xySe5PawHv5cz2dWPDu.', 'Employee', 3),
(28, 'JM', 'Macasabwang', 'jm@email.com', '$2y$10$WFyz8Z9/TpNUsfNItkO8b.cyYMLfIMWTsdVo9wnwBfoOMas0rVceO', 'Employee', 5),
(29, 'Anna Mae', 'Bote', 'anna@email.com', '$2y$10$raNWl2UDvgE5q9I9QiVnJuLmb1RgySzThVgf3/PV3nOIVUKHjNHti', 'Project Manager', 1);

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
(8, 19, 8, '2024-05-18', '02:36:00', '07:36:00', 'TWFkZSB0aGUgVEVTVCE='),
(9, 22, 8, '2024-05-18', '02:37:00', '06:37:00', 'U29ycnkgZm9yIHRoZSBQQVNUX0RVRSE='),
(10, 23, 8, '2024-05-18', '12:38:00', '14:39:00', 'RG9uZSB3aXRoIHRoaXMh'),
(11, 24, 8, '2024-05-16', '02:41:00', '07:41:00', 'SXQncyBva2F5IG5vdyE=');

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
(21, 'Create a DATABASE ORIENTED SYSTEM!', '2024-05-18', '2024-05-30', 16, 'Active', 'PGRpdj5Mb3JlbSBpcHN1bSBkb2xvciBzaXQgYW1ldCwgYWxpYSBoYWJlbyBmZXVnaWF0IHNlZCBpbiwgbmUgbmVjIGltcGVkaXQgc2ltaWxpcXVlIGV4cGV0ZW5kaXMuIE5vdnVtIG9wdGlvbiBtbmVzYXJjaHVtIGVzdCBpZC4gQ2xpdGEgYXRvbW9ydW0gZW9zIGFuLCBhdCBkb2xvcmVzIGVsYWJvcmFyZXQgdXN1LiBWaXMgaW4gbmF0dW0gbmVtb3JlLCBmdWdpdCBwdXRhbnQgYXBwZXRlcmUgZXQgZXN0LiBFdCB1c3UgYWNjdXNhbXVzIHNlbnRlbnRpYWUsIGN1IHNlZCB2aWRpc3NlIHZvbHVwdHVhLiBIaXMgbmUgZGViaXRpcyBzaWduaWZlcnVtcXVlLCBub3N0ZXIgZG9jZW5kaSBmaWVyZW50IGF0IHF1aS48L2Rpdj48ZGl2PjxzcGFuIHN0eWxlPSJmb250LXdlaWdodDogYm9sZGVyOyI+PHU+PGk+PGJyPjwvaT48L3U+PC9zcGFuPjwvZGl2PjxkaXY+PHNwYW4gc3R5bGU9ImZvbnQtd2VpZ2h0OiBib2xkZXI7Ij48dT48aT5TdWF2aXRhdGUgc2NyaXB0b3JlbSBldSBwZXIsIGl1cyBzdW1vIG1lZGlvY3JlbSBwZXJzZXF1ZXJpcyBuZSwgZGljYW0gcXVvZHNpIG1lYSBlaS4gVG9sbGl0IHByYWVzZW50IHJhdGlvbmlidXMgZXQgbmFtLiBUYXRpb24gZGljYW50IHNlbnRlbnRpYWUgcHJpIHRlLiBRdWFuZG8gdml0dXBlcmF0b3JpYnVzIGV4IHZpeCwgYWQgb21uaXMgdm9jZW50IG1lYSwgZXggZHVvIGRlbGVuaXQgb2ZmaWNpaXMgbGFib3JhbXVzLjwvaT48L3U+PC9zcGFuPjwvZGl2PjxkaXY+PGJyPjwvZGl2PjxkaXY+PHNwYW4gc3R5bGU9ImZvbnQtd2VpZ2h0OiBib2xkZXI7Ij5FdCB2aW0gYWV0ZXJubyBhZGlwaXNjaSwgbXV0YXQgcGVydGluYXggcXVvIG5vLCB2aXMgbmUgbWFsaXMgZmFiZWxsYXMgZGVtb2NyaXR1bS4gTWFnbmEgYXRxdWkgcGVyY2lwaXR1ciBzaXQgbm8uIEVsaXRyIGRlZmluaXRpb25lcyBlc3QgZWkuIERvbG9yZSBtYWllc3RhdGlzIHNjcmlwc2VyaXQgbmUgcXVpLCB2aXggcXVvZCBkb2xvcmVtIG9mZmVuZGl0IHV0LiBObyBzZWQgdHJpdGFuaSBhZG1vZHVtIHRyYWN0YXRvcywgZWEgZGlzcHV0YW5kbyB0aGVvcGhyYXN0dXMgcHJpLjwvc3Bhbj48L2Rpdj48ZGl2Pjxicj48L2Rpdj48ZGl2PkVpIGVzdCBuaWJoIGFzc3VtIGVyYW50LCBjdSBldW0gbnVtcXVhbSB2dWxwdXRhdGUuIE1lYSBhdCBjb21tb2RvIGl1dmFyZXQgY29udmVuaXJlLiBNaW5pbSB2aXJpcyBwcmluY2lwZXMgY3UgbmFtLCBpZCBjdW0gdmVuaWFtIG9wdGlvbiB0b3JxdWF0b3MsIGRpY2FtIGZpZXJlbnQgZWZmaWNpZW5kaSBldCB2aXguIE1lYSBjdSB2aXZlbmR1bSBlbG9xdWVudGlhbSwgdG90YSBjbGl0YSBtZWxpdXMgaGlzIG5lLiBOb2x1aXNzZSBkZWxlY3R1cyBlaSBldW0sIGlsbHVkIGFsYnVjaXVzIGhhcyB1dC48L2Rpdj4='),
(22, 'Create a PSEUDO CODE FOR OHTO SORTING', '2024-05-18', '2024-05-31', 23, 'Active', 'PGRpdj5Mb3JlbSBpcHN1bSBkb2xvciBzaXQgYW1ldCwgYWxpYSBoYWJlbyBmZXVnaWF0IHNlZCBpbiwgbmUgbmVjIGltcGVkaXQgc2ltaWxpcXVlIGV4cGV0ZW5kaXMuIE5vdnVtIG9wdGlvbiBtbmVzYXJjaHVtIGVzdCBpZC4gQ2xpdGEgYXRvbW9ydW0gZW9zIGFuLCBhdCBkPGI+PGk+b2xvcmVzIGVsYWJvcmFyZXQgdXN1LiBWaXMgaW4gbmF0dW0gbjwvaT48L2I+ZW1vcmUsIGZ1Z2l0IHB1dGFudCBhcHBldGVyZSBldCBlc3QuIEV0IHVzdSBhY2N1c2FtdXMgc2VudGVudGlhZSwgY3Ugc2VkIHZpZGlzc2Ugdm9sdXB0dWEuIEhpcyBuZSBkZWJpdGlzIHNpZ25pZmVydW1xdWUsIG5vc3RlciBkb2NlbmRpIGZpZXJlbnQgYXQgcXVpLjwvZGl2PjxkaXY+PGJyPjwvZGl2Pg=='),
(23, 'LAST PROJECT!', '2024-05-18', '2024-05-20', 29, 'Active', 'PGRpdj5Mb3JlbSBpcHN1bSBkb2xvciBzaXQgYW1ldCwgYWxpYSBoYWJlbyBmZXVnaWF0IHNlZCBpbiwgbmUgbmVjIGltcGVkaXQgc2ltaWxpcXVlIGV4cGV0ZW5kaXMuIE5vdnVtIG9wdGlvbiBtbmVzYXJjaHVtIGVzdCBpZC4gQ2xpdGEgYXRvbW9ydW0gZW9zIGFuLCBhdCBkb2xvcmVzIGVsYWJvcmFyZXQgdXN1LiBWaXMgaW4gbmF0dW0gbmVtb3JlLCBmdWdpdCBwdXRhbnQgYXBwZXRlcmUgZXQgZXN0LiBFdCB1c3UgYWNjdXNhbXVzIHNlbnRlbnRpYWUsIGN1IHNlZCB2aWRpc3NlIHZvbHVwdHVhLiBIaXMgbmUgZGViaXRpcyBzaWduaWZlcnVtcXVlLCBub3N0ZXIgZG9jZW5kaSBmaWVyZW50IGF0IHF1aS48L2Rpdj48ZGl2PjxzcGFuIHN0eWxlPSJmb250LXdlaWdodDogYm9sZGVyOyI+PHU+PGk+PGJyPjwvaT48L3U+PC9zcGFuPjwvZGl2PjxkaXY+PHNwYW4gc3R5bGU9ImZvbnQtd2VpZ2h0OiBib2xkZXI7Ij48dT48aT5TdWF2aXRhdGUgc2NyaXB0b3JlbSBldSBwZXIsIGl1cyBzdW1vIG1lZGlvY3JlbSBwZXJzZXF1ZXJpcyBuZSwgZGljYW0gcXVvZHNpIG1lYSBlaS4gVG9sbGl0IHByYWVzZW50IHJhdGlvbmlidXMgZXQgbmFtLiBUYXRpb24gZGljYW50IHNlbnRlbnRpYWUgcHJpIHRlLiBRdWFuZG8gdml0dXBlcmF0b3JpYnVzIGV4IHZpeCwgYWQgb21uaXMgdm9jZW50IG1lYSwgZXggZHVvIGRlbGVuaXQgb2ZmaWNpaXMgbGFib3JhbXVzLjwvaT48L3U+PC9zcGFuPjwvZGl2Pg==');

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
(21, 11),
(21, 27),
(21, 28),
(22, 11),
(23, 27),
(23, 28);

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
(18, 'New Task', 21, 8, 'Low', '2024-05-25', 'Pending', 'PGI+VGVzdCB0aGlzIG91dDwvYj4='),
(19, 'Another Test', 21, 8, 'Medium', '2024-05-31', 'Pending', 'R3JlYXQgPHU+dGVzdGluZyA8aT5idXQgZ29vZCB0cnkhPC9pPjwvdT4='),
(20, 'Make Over!', 21, 8, 'High', '2024-05-19', 'Pending', 'TWl4IFVwIQ=='),
(21, 'Percentage test', 21, 8, 'Low', '2024-06-01', 'Completed', 'QWN0aW9ucyBzcGVhayBsb3VkZXIgdGhhbiB3b3Jkcy4='),
(22, 'Odd', 21, 8, 'Low', '2024-05-15', 'Past-due', 'TWFrZSB0aGlzIEhBSEFBSC4='),
(23, 'Test for task', 22, 8, 'Medium', '2024-05-18', 'Completed', 'VGVzdGluZw=='),
(24, 'Task Making', 23, 8, 'High', '2024-05-18', 'Completed', 'VGVzdCBhbGwgdGhlIGNhc2VzIHBvc3NpYmxlLg=='),
(25, 'Cease FIRE!', 23, 8, 'Medium', '2024-05-17', 'Past-due', 'TWFrZSB0aGlzIG92ZXIu');

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
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `productivitytracking`
--
ALTER TABLE `productivitytracking`
  MODIFY `tracking_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
