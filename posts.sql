--
-- Database: `blogger`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `postID` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(170) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `authorID` int(11) NOT NULL,
  `blogID` int(11) NOT NULL,
  `createdDate` datetime NOT NULL,
  `updateDate` datetime DEFAULT current_timestamp(),
  `content` longtext DEFAULT NULL,
  `postStatus` enum('draft','published') NOT NULL,
  `postType` enum('Post','Page') NOT NULL,
  `isComments` enum('allowed','blocked') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`postID`, `title`, `description`, `slug`, `authorID`, `blogID`, `createdDate`, `updateDate`, `content`, `postStatus`, `postType`, `isComments`) VALUES
(1, 'test post', 'test', 'test-post.html', 1, 1, '2023-01-20 22:23:54', '2023-01-21 22:23:54', 'test', 'published', 'Post', 'allowed');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`postID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `postID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
