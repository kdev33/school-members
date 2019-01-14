CREATE DATABASE IF NOT EXISTS `schoolmembers`;
USE `schoolmembers`;

CREATE TABLE `members` (
  `m_id` int NOT NULL AUTO_INCREMENT,
  `m_name` varchar(355),
  `m_email` varchar(20) UNIQUE,
  PRIMARY KEY (`m_id`)
);

CREATE TABLE `schools` (
  `s_id` int NOT NULL AUTO_INCREMENT,
  `s_name` varchar(355),
  PRIMARY KEY (`s_id`)
);

CREATE TABLE `schools_members` (
  `sm_school_id` int NOT NULL,
  `sm_member_id` int NOT NULL,
FOREIGN KEY (sm_school_id) REFERENCES schools(s_id),
FOREIGN KEY (sm_member_id) REFERENCES members(m_id)
);

INSERT INTO `schools` (`s_id`, `s_name`) VALUES
("1", "Oxford"),
("2", "MIT"),
("3", "Harvard");

INSERT INTO `members` (`m_name`, `m_email`) VALUES
("John", "john@mail.com"),
("Laura", "laura@mail.com"),
("Larry", "larry@mail.com"),
("James", "james@mail.com"),
("Aurea", "aurea@mail.com"),
("Priscila", "priscila@mail.com");
