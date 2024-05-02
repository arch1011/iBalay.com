-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 01, 2024 at 02:28 AM
-- Server version: 10.5.20-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id22081223_ibalay_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `bh_information`
--

CREATE TABLE `bh_information` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `complete_address` varchar(255) NOT NULL,
  `business_permit` enum('yes','no') NOT NULL,
  `monthly_payment_rate` varchar(50) NOT NULL,
  `number_of_kitchen` int(11) NOT NULL,
  `number_of_living_room` int(11) NOT NULL,
  `number_of_students_tenants` int(11) NOT NULL,
  `number_of_cr` int(11) NOT NULL,
  `number_of_beds` int(11) NOT NULL,
  `number_of_rooms` int(11) NOT NULL,
  `bh_max_capacity` int(11) NOT NULL,
  `gender_allowed` enum('male','female','all') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bh_information`
--

INSERT INTO `bh_information` (`id`, `owner_id`, `complete_address`, `business_permit`, `monthly_payment_rate`, `number_of_kitchen`, `number_of_living_room`, `number_of_students_tenants`, `number_of_cr`, `number_of_beds`, `number_of_rooms`, `bh_max_capacity`, `gender_allowed`) VALUES
(22, 49, 'Brgy.Tanauan', 'yes', '1200 - 1200', 2, 2, 2, 2, 2, 2, 2, 'male'),
(23, 50, 'dsgsd', 'yes', '23242343', 2, 2, 3, 3, 3, 5, 5, 'male');

-- --------------------------------------------------------

--
-- Table structure for table `bookmark`
--

CREATE TABLE `bookmark` (
  `BookmarkID` int(11) NOT NULL,
  `TenantID` int(11) DEFAULT NULL,
  `RoomID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `CommentID` int(11) NOT NULL,
  `RoomID` int(11) DEFAULT NULL,
  `TenantID` int(11) DEFAULT NULL,
  `CommentText` text DEFAULT NULL,
  `CrRating` int(11) DEFAULT NULL,
  `CoBoardersRating` int(11) DEFAULT NULL,
  `OwnerRating` int(11) DEFAULT NULL,
  `Rating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inquiry`
--

CREATE TABLE `inquiry` (
  `InquiryID` int(11) NOT NULL,
  `RoomID` int(11) DEFAULT NULL,
  `TenantID` int(11) DEFAULT NULL,
  `OwnerID` int(11) DEFAULT NULL,
  `Message` text DEFAULT NULL,
  `InquiryDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `owners`
--

CREATE TABLE `owners` (
  `owner_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `warnings` tinyint(1) DEFAULT 0,
  `documents` varchar(255) DEFAULT NULL,
  `approval_status` tinyint(1) DEFAULT 0,
  `close_account` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `owners`
--

INSERT INTO `owners` (`owner_id`, `username`, `password`, `name`, `contact_number`, `email`, `photo`, `location`, `warnings`, `documents`, `approval_status`, `close_account`) VALUES
(49, 'cord', '$2y$10$OpkX/3wj0ZeGPd79nawCP.c3X0ZE3X5Hnz8P3TQIWOasnAY/NlPny', 'cord ian moraleta', '09124768399', 'cordmorale101@gmail.com', '662f350d25260_Screenshot_2024-04-29-09-21-33-38_ccc4ff946bf847a7c199bff6d87da37a.jpg', 'Brgy.imelda tolosa leyte', 3, 'LETTER OF INTENT.pdf|RESUME_DADULLA.pdf', 1, 1),
(50, 'jerome', '$2y$10$Mf3F2qsR9bohbgw0iqBykut5RqIkiHxuort7VTKFutVZcnPuLBuB2', 'Jerorme', '93049049', 'jerome@gmail.com', 'Picture1.png', 'bfjsdifji', 0, 'Legal Med Act.pdf|Personal Identification.docx', 1, 0),
(51, 'mj', '$2y$10$eBsGr//zk3luE2yY7m7.5.sjDIQ.Yc1kMg9blv.0xYciBEmd.ro.S', 'mj', '213213', 'mj@gmail.com', 'logo.png', 'gfdgdfg', 0, 'April 8 jubille.docx|codes_dashboards.docx', 2, 0),
(52, 'hannie', '$2y$10$a1Yb8u4a9Mc/W0aZrukp..VsMdYWl9nwGSuWPfMOV7H4bLqBzrt.W', 'hanni', '934293', 'hannie@gmail.com', 'evsu_favicon.png', 'sdfsdkfj', 0, 'Memorial stone 1 (midway).docx|April 8 jubille.docx', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `PaymentID` int(11) NOT NULL,
  `RoomID` int(11) DEFAULT NULL,
  `TenantID` int(11) DEFAULT NULL,
  `OwnerID` int(11) DEFAULT NULL,
  `Amount` decimal(10,2) DEFAULT NULL,
  `DueDate` date DEFAULT NULL,
  `PaymentDate` date DEFAULT NULL,
  `IsFirstPayment` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`PaymentID`, `RoomID`, `TenantID`, `OwnerID`, `Amount`, `DueDate`, `PaymentDate`, `IsFirstPayment`) VALUES
(84, 134, 35, 49, 32423.00, '2024-05-30', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment_history`
--

CREATE TABLE `payment_history` (
  `PaymentHistoryID` int(11) NOT NULL,
  `PaymentID` int(11) DEFAULT NULL,
  `RoomID` int(11) DEFAULT NULL,
  `TenantID` int(11) DEFAULT NULL,
  `OwnerID` int(11) DEFAULT NULL,
  `Amount` decimal(10,2) DEFAULT NULL,
  `DueDate` date DEFAULT NULL,
  `PaymentDate` date DEFAULT NULL,
  `IsFirstPayment` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payment_history`
--

INSERT INTO `payment_history` (`PaymentHistoryID`, `PaymentID`, `RoomID`, `TenantID`, `OwnerID`, `Amount`, `DueDate`, `PaymentDate`, `IsFirstPayment`) VALUES
(14, 84, 134, 35, 49, 32423.00, '2024-05-30', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `reply`
--

CREATE TABLE `reply` (
  `ReplyID` int(11) NOT NULL,
  `InquiryID` int(11) DEFAULT NULL,
  `TenantID` int(11) DEFAULT NULL,
  `RoomID` int(11) DEFAULT NULL,
  `OwnerID` int(11) DEFAULT NULL,
  `ReplyMessage` text DEFAULT NULL,
  `ReplyDate` date DEFAULT NULL,
  `Notified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `ReportID` int(11) NOT NULL,
  `RoomID` int(11) DEFAULT NULL,
  `TenantID` int(11) DEFAULT NULL,
  `ReportDate` date DEFAULT NULL,
  `ReportText` text DEFAULT NULL,
  `Acknowledge` tinyint(1) DEFAULT 0,
  `Notified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `ReservationID` int(11) NOT NULL,
  `RoomID` int(11) DEFAULT NULL,
  `TenantID` int(11) DEFAULT NULL,
  `ReservationDate` date DEFAULT NULL,
  `ReservedDate` date DEFAULT NULL,
  `OwnerID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `RoomID` int(11) NOT NULL,
  `OwnerID` int(11) DEFAULT NULL,
  `BoardingHouseName` varchar(255) DEFAULT NULL,
  `RoomNumber` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Category` enum('Male','Female','All Gender') DEFAULT NULL,
  `Capacity` tinyint(4) DEFAULT NULL,
  `Barangay` enum('Ada','Amanluran','Arado','Atipolo','Balud','Bangon','Bantagan','Baras','Binolo','Binongto-an','Bislig','Buntay (Poblacion)','Cabalagnan','Cabarasan Guti','Cabonga-an','Cabuynan','Cahumayhumayan','Calogcog','Calsadahay','Camire','Canbalisara','Canramos (Poblacion)','Catigbian','Catmon','Cogon','Guindag-an','Guingauan','Hilagpad','Lapay','Licod (Poblacion)','Limbuhan Daku','Limbuhan Guti','Linao','Kiling','Magay','Maghulod','Malaguicay','Maribi','Mohon','Pago','Pasil','Picas','Sacme','San Miguel (Poblacion)','Salvador','San Isidro','San Roque (Poblacion)','San Victor','Santa Cruz','Santa Elena','Santo Niño (Haclagan) (Poblacion)','Solano','Talolora','Tugop') DEFAULT NULL,
  `Availability` tinyint(1) DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `Photos` text DEFAULT NULL,
  `Municipality` varchar(255) DEFAULT NULL,
  `Latitude` decimal(10,8) DEFAULT NULL,
  `Longitude` decimal(11,8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`RoomID`, `OwnerID`, `BoardingHouseName`, `RoomNumber`, `Description`, `Category`, `Capacity`, `Barangay`, `Availability`, `Price`, `Photos`, `Municipality`, `Latitude`, `Longitude`) VALUES
(134, 49, 'cord\'s BH', '1', 'this is room 1', 'Male', 1, 'San Roque (Poblacion)', 1, 2000.00, '/iBalay.com/uploads/room-photos-49/24296851_1624555150920621_2432502825900117817_n.jpg,/iBalay.com/uploads/room-photos-49/24852240_1624553420920794_2370120490159944774_n.jpg', 'Tanauan', 11.10929337, 125.02062130),
(135, 49, 'cord\'s BH', '2', 'sdasdsa', 'Male', 2, 'Ada', 1, 2000.00, '/iBalay.com/uploads/room-photos-49/Home of Chaos.png,/iBalay.com/uploads/room-photos-49/fearfully and wonderfully made; (1).png', 'Tanauan', 11.11257803, 125.01688562),
(136, 49, 'cord\'s BH', '3', 'wewq', 'Male', 2, 'Ada', 1, 22222.00, '/iBalay.com/uploads/room-photos-49/2.png,/iBalay.com/uploads/room-photos-49/sunday.png', 'Tanauan', 11.10967237, 125.02032073),
(150, 50, 'xvxcv', '1', 'sdfsd', 'Male', 1, 'Ada', 1, 334.00, '/iBalay.com/uploads/room-photos-50/24296851_1624555150920621_2432502825900117817_n.jpg,/iBalay.com/uploads/room-photos-50/24852240_1624553420920794_2370120490159944774_n.jpg', 'Tanauan', 11.10943234, 125.02091381);

-- --------------------------------------------------------

--
-- Table structure for table `saso`
--

CREATE TABLE `saso` (
  `saso_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `saso`
--

INSERT INTO `saso` (`saso_id`, `username`, `password`, `photo`) VALUES
(3, 'saso', '$2y$10$gxhZAUk0BumQb0BZz08v/uw57SlAEM8SOsNfElwcw5IWN5o0kYNMm', '663058c2b18da_evsu_favicon.png');

-- --------------------------------------------------------

--
-- Table structure for table `tenant`
--

CREATE TABLE `tenant` (
  `TenantID` int(11) NOT NULL,
  `FirstName` varchar(255) DEFAULT NULL,
  `LastName` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `PhoneNumber` varchar(15) DEFAULT NULL,
  `Photos` text DEFAULT NULL,
  `OwnerID` int(11) DEFAULT NULL,
  `owner_history` text DEFAULT NULL,
  `RoomID` int(11) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `checked_out` tinyint(1) DEFAULT 0,
  `Evsu_student` enum('yes','no') DEFAULT 'no',
  `student_id` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tenant`
--

INSERT INTO `tenant` (`TenantID`, `FirstName`, `LastName`, `Email`, `PhoneNumber`, `Photos`, `OwnerID`, `owner_history`, `RoomID`, `Password`, `gender`, `checked_out`, `Evsu_student`, `student_id`, `address`) VALUES
(35, 'tester', 'testing', 'tester@gmail.com', '3432432', NULL, 49, NULL, 134, '$2y$10$mvNCS42W2oecGNIjZTmlnuVOAtm5gJd.QNONYoi/daAxEQ1NqxkyG', 'Male', 0, 'yes', '343243-23432', 'brgy.imidlda, Imelda Lane, Tolosa, LEyte'),
(36, 'Mary Jay', 'Cinco', 'mj@gmail.com', '0945752454', NULL, NULL, NULL, NULL, '$2y$10$UoASDmCJyt19SVVlYHjXRekZX6y9pfkkvWIZfcHDw50REwhrRSqje', 'Female', 1, 'yes', '2020-03489', 'brgy, Sto, Niño Tanaun Leyet');

-- --------------------------------------------------------

--
-- Table structure for table `tenant_history`
--

CREATE TABLE `tenant_history` (
  `TenantHistoryID` int(11) NOT NULL,
  `TenantID` int(11) DEFAULT NULL,
  `OwnerID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tenant_history`
--

INSERT INTO `tenant_history` (`TenantHistoryID`, `TenantID`, `OwnerID`) VALUES
(9, 35, 49);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bh_information`
--
ALTER TABLE `bh_information`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `bookmark`
--
ALTER TABLE `bookmark`
  ADD PRIMARY KEY (`BookmarkID`),
  ADD KEY `TenantID` (`TenantID`),
  ADD KEY `RoomID` (`RoomID`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`CommentID`),
  ADD KEY `RoomID` (`RoomID`),
  ADD KEY `TenantID` (`TenantID`);

--
-- Indexes for table `inquiry`
--
ALTER TABLE `inquiry`
  ADD PRIMARY KEY (`InquiryID`),
  ADD KEY `RoomID` (`RoomID`),
  ADD KEY `TenantID` (`TenantID`),
  ADD KEY `OwnerID` (`OwnerID`);

--
-- Indexes for table `owners`
--
ALTER TABLE `owners`
  ADD PRIMARY KEY (`owner_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`PaymentID`),
  ADD KEY `RoomID` (`RoomID`),
  ADD KEY `TenantID` (`TenantID`),
  ADD KEY `OwnerID` (`OwnerID`);

--
-- Indexes for table `payment_history`
--
ALTER TABLE `payment_history`
  ADD PRIMARY KEY (`PaymentHistoryID`),
  ADD KEY `RoomID` (`RoomID`),
  ADD KEY `TenantID` (`TenantID`),
  ADD KEY `OwnerID` (`OwnerID`),
  ADD KEY `payment_history_ibfk_1` (`PaymentID`);

--
-- Indexes for table `reply`
--
ALTER TABLE `reply`
  ADD PRIMARY KEY (`ReplyID`),
  ADD KEY `InquiryID` (`InquiryID`),
  ADD KEY `TenantID` (`TenantID`),
  ADD KEY `RoomID` (`RoomID`),
  ADD KEY `OwnerID` (`OwnerID`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`ReportID`),
  ADD KEY `RoomID` (`RoomID`),
  ADD KEY `TenantID` (`TenantID`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`ReservationID`),
  ADD KEY `RoomID` (`RoomID`),
  ADD KEY `TenantID` (`TenantID`),
  ADD KEY `OwnerID` (`OwnerID`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`RoomID`),
  ADD KEY `fk_room_owner` (`OwnerID`);

--
-- Indexes for table `saso`
--
ALTER TABLE `saso`
  ADD PRIMARY KEY (`saso_id`);

--
-- Indexes for table `tenant`
--
ALTER TABLE `tenant`
  ADD PRIMARY KEY (`TenantID`),
  ADD KEY `FK_Tenant_Owner` (`OwnerID`),
  ADD KEY `FK_Tenant_Room` (`RoomID`);

--
-- Indexes for table `tenant_history`
--
ALTER TABLE `tenant_history`
  ADD PRIMARY KEY (`TenantHistoryID`),
  ADD KEY `TenantID` (`TenantID`),
  ADD KEY `OwnerID` (`OwnerID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bh_information`
--
ALTER TABLE `bh_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `bookmark`
--
ALTER TABLE `bookmark`
  MODIFY `BookmarkID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `CommentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `inquiry`
--
ALTER TABLE `inquiry`
  MODIFY `InquiryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `owners`
--
ALTER TABLE `owners`
  MODIFY `owner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `payment_history`
--
ALTER TABLE `payment_history`
  MODIFY `PaymentHistoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `reply`
--
ALTER TABLE `reply`
  MODIFY `ReplyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `ReportID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `ReservationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `RoomID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `saso`
--
ALTER TABLE `saso`
  MODIFY `saso_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tenant`
--
ALTER TABLE `tenant`
  MODIFY `TenantID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tenant_history`
--
ALTER TABLE `tenant_history`
  MODIFY `TenantHistoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bh_information`
--
ALTER TABLE `bh_information`
  ADD CONSTRAINT `bh_information_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `owners` (`owner_id`);

--
-- Constraints for table `bookmark`
--
ALTER TABLE `bookmark`
  ADD CONSTRAINT `bookmark_ibfk_1` FOREIGN KEY (`TenantID`) REFERENCES `tenant` (`TenantID`),
  ADD CONSTRAINT `bookmark_ibfk_2` FOREIGN KEY (`RoomID`) REFERENCES `room` (`RoomID`);

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`RoomID`) REFERENCES `room` (`RoomID`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`TenantID`) REFERENCES `tenant` (`TenantID`);

--
-- Constraints for table `inquiry`
--
ALTER TABLE `inquiry`
  ADD CONSTRAINT `inquiry_ibfk_1` FOREIGN KEY (`RoomID`) REFERENCES `room` (`RoomID`),
  ADD CONSTRAINT `inquiry_ibfk_2` FOREIGN KEY (`TenantID`) REFERENCES `tenant` (`TenantID`),
  ADD CONSTRAINT `inquiry_ibfk_3` FOREIGN KEY (`OwnerID`) REFERENCES `owners` (`owner_id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`RoomID`) REFERENCES `room` (`RoomID`),
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`TenantID`) REFERENCES `tenant` (`TenantID`),
  ADD CONSTRAINT `payment_ibfk_3` FOREIGN KEY (`OwnerID`) REFERENCES `owners` (`owner_id`);

--
-- Constraints for table `payment_history`
--
ALTER TABLE `payment_history`
  ADD CONSTRAINT `payment_history_ibfk_2` FOREIGN KEY (`RoomID`) REFERENCES `room` (`RoomID`),
  ADD CONSTRAINT `payment_history_ibfk_3` FOREIGN KEY (`TenantID`) REFERENCES `tenant` (`TenantID`),
  ADD CONSTRAINT `payment_history_ibfk_4` FOREIGN KEY (`OwnerID`) REFERENCES `owners` (`owner_id`);

--
-- Constraints for table `reply`
--
ALTER TABLE `reply`
  ADD CONSTRAINT `reply_ibfk_1` FOREIGN KEY (`InquiryID`) REFERENCES `inquiry` (`InquiryID`),
  ADD CONSTRAINT `reply_ibfk_2` FOREIGN KEY (`TenantID`) REFERENCES `tenant` (`TenantID`),
  ADD CONSTRAINT `reply_ibfk_3` FOREIGN KEY (`RoomID`) REFERENCES `room` (`RoomID`),
  ADD CONSTRAINT `reply_ibfk_4` FOREIGN KEY (`OwnerID`) REFERENCES `owners` (`owner_id`);

--
-- Constraints for table `report`
--
ALTER TABLE `report`
  ADD CONSTRAINT `report_ibfk_1` FOREIGN KEY (`RoomID`) REFERENCES `room` (`RoomID`),
  ADD CONSTRAINT `report_ibfk_2` FOREIGN KEY (`TenantID`) REFERENCES `tenant` (`TenantID`);

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`RoomID`) REFERENCES `room` (`RoomID`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`TenantID`) REFERENCES `tenant` (`TenantID`),
  ADD CONSTRAINT `reservation_ibfk_3` FOREIGN KEY (`OwnerID`) REFERENCES `owners` (`owner_id`);

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `fk_room_owner` FOREIGN KEY (`OwnerID`) REFERENCES `owners` (`owner_id`);

--
-- Constraints for table `tenant`
--
ALTER TABLE `tenant`
  ADD CONSTRAINT `FK_Tenant_Owner` FOREIGN KEY (`OwnerID`) REFERENCES `owners` (`owner_id`),
  ADD CONSTRAINT `FK_Tenant_Room` FOREIGN KEY (`RoomID`) REFERENCES `room` (`RoomID`);

--
-- Constraints for table `tenant_history`
--
ALTER TABLE `tenant_history`
  ADD CONSTRAINT `tenant_history_ibfk_1` FOREIGN KEY (`TenantID`) REFERENCES `tenant` (`TenantID`),
  ADD CONSTRAINT `tenant_history_ibfk_2` FOREIGN KEY (`OwnerID`) REFERENCES `owners` (`owner_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
