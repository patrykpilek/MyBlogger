--
-- Database: `blogger`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogsauth`
--

CREATE TABLE `blogsauth` (
  `authID` int(11) NOT NULL,
  `blogID` int(11) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  `role` enum('Author','Admin') NOT NULL DEFAULT 'Author'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogsauth`
--

INSERT INTO `blogsauth` (`authID`, `blogID`, `userID`, `role`) VALUES
(1, 1, 1, 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogsauth`
--
ALTER TABLE `blogsauth`
  ADD PRIMARY KEY (`authID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogsauth`
--
ALTER TABLE `blogsauth`
  MODIFY `authID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
