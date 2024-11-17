-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS stuBook;

-- Use the created database
USE stuBook;

-- Table structure for `comments`
CREATE TABLE IF NOT EXISTS `comments` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'Article ID',
  `owner` INT NOT NULL COMMENT 'Publisher',
  `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Publication Date',
  `text` TEXT COMMENT 'Content',
  PRIMARY KEY (`id`)
);

-- Data for table `comments`
INSERT INTO `comments` (`id`, `owner`, `date`, `text`) VALUES
(1, 1, '2023-10-01 10:00:00', 'This is the first comment.'),
(2, 2, '2023-10-02 12:00:00', 'Welcome to the stuBook database!'),
(3, 3, '2023-10-03 15:00:00', 'Hello world!');

-- Table structure for `user`
CREATE TABLE IF NOT EXISTS `user` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'User ID',
  `username` CHAR(32) NOT NULL COMMENT 'Username',
  `password` CHAR(32) NOT NULL COMMENT 'Password',
  `level` INT NOT NULL DEFAULT 0 COMMENT 'Level',
  `avatar` CHAR(64) DEFAULT NULL COMMENT 'Avatar',
  PRIMARY KEY (`id`)
);

-- Data for table `user`
INSERT INTO `user` (`id`, `username`, `password`, `level`, `avatar`) VALUES
(1, 'john_doe', 'hello123', 0, 'john.jpg'),
(2, 'jane_smith', 'pass123', 1, 'jane.jpg'),
(3, 'admin_user', 'adminpass', 1, 'admin.jpg');

-- Commit changes
COMMIT;
