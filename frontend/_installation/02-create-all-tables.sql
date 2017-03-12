CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index',
  `user_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s name, unique',
  `user_password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s password in salted and hashed format',
  `user_email` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s email, unique',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data';


CREATE TABLE IF NOT EXISTS `Transportation`(
 `trDID` int(11) NOT NULL AUTO_INCREMENT,
 `TYPE` varchar(20),
 PRIMARY KEY (`trDID`)
);

CREATE TABLE IF NOT EXISTS `Plan` (
 `planID` int(11) NOT NULL AUTO_INCREMENT,
 `title` varchar(50),
 `commentsID` int(11),
 `ArrayOfLocations` varchar(1024),
 `ownedByUserID` int(11),
 `createdByUserID` int(11),
 PRIMARY KEY (`planID`)
);

CREATE TABLE IF NOT EXISTS `Friend`(
 `userID1` int(11),
 `userID2` int(11)
);

CREATE TABLE IF NOT EXISTS `Comments` (
 `commentID` int(11) NOT NULL AUTO_INCREMENT,
 `userID` int(11),
 `content` varchar(4096),
 PRIMARY KEY(`commentID`)
);
