CREATE TABLE `17cs05_friendrequest` (
  `Sno` int(11) NOT NULL,
  `RequestID` varchar(50) DEFAULT NULL,
  `RequestFrom` varchar(50) DEFAULT NULL,
  `RequestTo` varchar(50) DEFAULT NULL,
  `RequestStatus` varchar(50) DEFAULT NULL,
  `RequestDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `Creator` varchar(200) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `Updator` varchar(200) DEFAULT NULL,
  `UpdatedDate` datetime DEFAULT NULL,
  `CurrentlyActive` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `17cs05_friendrequest`
  ADD PRIMARY KEY (`RequestID`),
  ADD UNIQUE KEY `Sno` (`Sno`)

  ALTER TABLE `17cs05_friendrequest`
  MODIFY `Sno` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `17cs05_user_settings` (
  `Sno` int(11) NOT NULL,
  `UserID` varchar(50) DEFAULT NULL,
  `NewsFeed` int(11) DEFAULT '0',
  `FeedLanguage` varchar(50) DEFAULT NULL,
  `ShowOthers`int(11) DEFAULT '1',
  `Creator` varchar(200) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `Updator` varchar(200) DEFAULT NULL,
  `UpdatedDate` datetime DEFAULT NULL,
  `CurrentlyActive` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `17cs05_user_settings` 
  ADD UNIQUE KEY `Sno` (`Sno`)

  ALTER TABLE `17cs05_user_settings` 
  MODIFY `Sno` int(11) NOT NULL AUTO_INCREMENT;