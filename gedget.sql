--
-- Database: `blogger`
--

-- --------------------------------------------------------

--
-- Table structure for table `gedget`
--

CREATE TABLE `gedget` (
  `gadgetID` int(11) NOT NULL,
  `blogID` int(11) NOT NULL,
  `type` enum('profile','search','html','labels','topPosts','list','header','nav') NOT NULL,
  `content` text NOT NULL,
  `position` int(11) NOT NULL,
  `displayOn` enum('header','nav','sideBar','footer') NOT NULL,
  `html` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gedget`
--
ALTER TABLE `gedget`
  ADD PRIMARY KEY (`gadgetID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gedget`
--
ALTER TABLE `gedget`
  MODIFY `gadgetID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
