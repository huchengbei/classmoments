/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50621
Source Host           : localhost:3306
Source Database       : classmoments2

Target Server Type    : MYSQL
Target Server Version : 50621
File Encoding         : 65001

Date: 2017-12-25 20:50:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for class_activity
-- ----------------------------
DROP TABLE IF EXISTS `class_activity`;
CREATE TABLE `class_activity` (
  `activityId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `authorId` int(11) DEFAULT NULL,
  `classId` int(11) DEFAULT NULL,
  `startTime` datetime DEFAULT NULL,
  `endTime` datetime DEFAULT NULL,
  `createTime` datetime DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  PRIMARY KEY (`activityId`),
  KEY `authorId_activity_user` (`authorId`) USING BTREE,
  KEY `classId_activity_class` (`classId`) USING BTREE,
  CONSTRAINT `class_activity_ibfk_1` FOREIGN KEY (`authorId`) REFERENCES `class_user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `class_activity_ibfk_2` FOREIGN KEY (`classId`) REFERENCES `class_class` (`classId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for class_activity_content
-- ----------------------------
DROP TABLE IF EXISTS `class_activity_content`;
CREATE TABLE `class_activity_content` (
  `contentId` int(11) NOT NULL AUTO_INCREMENT,
  `questionId` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`contentId`),
  KEY `userId_record_activity` (`userId`) USING BTREE,
  KEY `questionId_record_info` (`questionId`) USING BTREE,
  CONSTRAINT `class_activity_content_ibfk_1` FOREIGN KEY (`questionId`) REFERENCES `class_activity_question` (`questionId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `class_activity_content_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `class_user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for class_activity_question
-- ----------------------------
DROP TABLE IF EXISTS `class_activity_question`;
CREATE TABLE `class_activity_question` (
  `questionId` int(11) NOT NULL AUTO_INCREMENT,
  `activityId` int(11) DEFAULT NULL,
  `question` varchar(255) DEFAULT NULL,
  `mode` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`questionId`),
  KEY `activityId_info_activity` (`activityId`) USING BTREE,
  CONSTRAINT `class_activity_question_ibfk_1` FOREIGN KEY (`activityId`) REFERENCES `class_activity` (`activityId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for class_chatroom
-- ----------------------------
DROP TABLE IF EXISTS `class_chatroom`;
CREATE TABLE `class_chatroom` (
  `msgId` int(11) NOT NULL AUTO_INCREMENT,
  `classId` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `createTime` datetime DEFAULT NULL,
  PRIMARY KEY (`msgId`),
  KEY `userId_chatroom_user` (`userId`) USING BTREE,
  KEY `classId_chatroom_classId` (`classId`) USING BTREE,
  CONSTRAINT `class_chatroom_ibfk_1` FOREIGN KEY (`classId`) REFERENCES `class_class` (`classId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `class_chatroom_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `class_user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for class_class
-- ----------------------------
DROP TABLE IF EXISTS `class_class`;
CREATE TABLE `class_class` (
  `classId` int(10) NOT NULL AUTO_INCREMENT,
  `className` varchar(255) DEFAULT NULL,
  `grade` varchar(255) DEFAULT NULL,
  `school` varchar(255) DEFAULT NULL,
  `college` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `uniqueCode` varchar(255) DEFAULT NULL,
  `monitorId` int(10) DEFAULT NULL,
  `majorId` int(11) DEFAULT NULL,
  PRIMARY KEY (`classId`),
  KEY `monitorId_class_user` (`monitorId`) USING BTREE,
  KEY `majorId` (`majorId`) USING BTREE,
  CONSTRAINT `class_class_ibfk_1` FOREIGN KEY (`majorId`) REFERENCES `class_major` (`majorId`),
  CONSTRAINT `class_class_ibfk_2` FOREIGN KEY (`monitorId`) REFERENCES `class_user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for class_class_subject
-- ----------------------------
DROP TABLE IF EXISTS `class_class_subject`;
CREATE TABLE `class_class_subject` (
  `courseId` int(11) NOT NULL AUTO_INCREMENT,
  `classId` int(11) NOT NULL,
  `subjectId` int(11) NOT NULL,
  `term` int(11) DEFAULT NULL,
  PRIMARY KEY (`courseId`),
  KEY `classId_classsubject_class` (`classId`) USING BTREE,
  KEY `subjectId_classsubject_subject` (`subjectId`) USING BTREE,
  CONSTRAINT `class_class_subject_ibfk_1` FOREIGN KEY (`classId`) REFERENCES `class_class` (`classId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `class_class_subject_ibfk_2` FOREIGN KEY (`subjectId`) REFERENCES `class_subject` (`subjectId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for class_college
-- ----------------------------
DROP TABLE IF EXISTS `class_college`;
CREATE TABLE `class_college` (
  `collegeId` int(11) NOT NULL AUTO_INCREMENT,
  `collegename` varchar(255) DEFAULT NULL,
  `universityId` int(11) DEFAULT NULL,
  PRIMARY KEY (`collegeId`),
  KEY `universityId_college_university` (`universityId`) USING BTREE,
  CONSTRAINT `class_college_ibfk_1` FOREIGN KEY (`universityId`) REFERENCES `class_university` (`universityId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for class_dorm
-- ----------------------------
DROP TABLE IF EXISTS `class_dorm`;
CREATE TABLE `class_dorm` (
  `dormId` int(11) NOT NULL AUTO_INCREMENT,
  `dormName` varchar(255) DEFAULT NULL,
  `dormBuildId` int(11) DEFAULT NULL,
  PRIMARY KEY (`dormId`),
  KEY `dormBuildId_dorm_dormBuild` (`dormBuildId`) USING BTREE,
  CONSTRAINT `class_dorm_ibfk_1` FOREIGN KEY (`dormBuildId`) REFERENCES `class_dorm_build` (`dormBuildId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for class_dorm_build
-- ----------------------------
DROP TABLE IF EXISTS `class_dorm_build`;
CREATE TABLE `class_dorm_build` (
  `dormBuildId` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(255) DEFAULT NULL,
  `dormBuildName` varchar(255) DEFAULT NULL,
  `universityId` int(11) DEFAULT NULL,
  PRIMARY KEY (`dormBuildId`),
  KEY `universityId_dormBuild_university` (`universityId`) USING BTREE,
  CONSTRAINT `class_dorm_build_ibfk_1` FOREIGN KEY (`universityId`) REFERENCES `class_university` (`universityId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for class_file
-- ----------------------------
DROP TABLE IF EXISTS `class_file`;
CREATE TABLE `class_file` (
  `fileId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `savename` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `size` double DEFAULT NULL,
  `md5` varchar(255) DEFAULT NULL,
  `sha1` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`fileId`)
) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for class_investigation_option
-- ----------------------------
DROP TABLE IF EXISTS `class_investigation_option`;
CREATE TABLE `class_investigation_option` (
  `optionId` int(11) NOT NULL AUTO_INCREMENT,
  `questionId` int(11) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`optionId`),
  KEY `quesionId_option_investionQuestion` (`questionId`) USING BTREE,
  CONSTRAINT `class_investigation_option_ibfk_1` FOREIGN KEY (`questionId`) REFERENCES `class_investigation_question` (`questionId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for class_investigation_question
-- ----------------------------
DROP TABLE IF EXISTS `class_investigation_question`;
CREATE TABLE `class_investigation_question` (
  `questionId` int(11) NOT NULL AUTO_INCREMENT,
  `investigationId` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `mode` int(11) DEFAULT NULL COMMENT '0单选1多选',
  PRIMARY KEY (`questionId`),
  KEY `investigationId_question_titile` (`investigationId`) USING BTREE,
  CONSTRAINT `class_investigation_question_ibfk_1` FOREIGN KEY (`investigationId`) REFERENCES `class_investigation_title` (`investigationId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for class_investigation_record
-- ----------------------------
DROP TABLE IF EXISTS `class_investigation_record`;
CREATE TABLE `class_investigation_record` (
  `recordId` int(11) NOT NULL AUTO_INCREMENT,
  `optionId` int(11) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `investigationTime` datetime DEFAULT NULL,
  PRIMARY KEY (`recordId`),
  KEY `optionId_record_investigation_option` (`optionId`) USING BTREE,
  KEY `userId_investigationrecord_user` (`userId`) USING BTREE,
  CONSTRAINT `class_investigation_record_ibfk_1` FOREIGN KEY (`optionId`) REFERENCES `class_investigation_option` (`optionId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `class_investigation_record_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `class_user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for class_investigation_title
-- ----------------------------
DROP TABLE IF EXISTS `class_investigation_title`;
CREATE TABLE `class_investigation_title` (
  `investigationId` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `classId` int(11) DEFAULT NULL,
  `authorId` int(11) DEFAULT NULL,
  `startTime` datetime DEFAULT NULL,
  `endTime` datetime DEFAULT NULL,
  `createTime` datetime DEFAULT NULL,
  `status` int(2) DEFAULT '0',
  PRIMARY KEY (`investigationId`),
  KEY `authorId_investigation_user` (`authorId`) USING BTREE,
  KEY `classId_investigation_class` (`classId`) USING BTREE,
  CONSTRAINT `class_investigation_title_ibfk_1` FOREIGN KEY (`authorId`) REFERENCES `class_user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `class_investigation_title_ibfk_2` FOREIGN KEY (`classId`) REFERENCES `class_class` (`classId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for class_major
-- ----------------------------
DROP TABLE IF EXISTS `class_major`;
CREATE TABLE `class_major` (
  `majorId` int(11) NOT NULL AUTO_INCREMENT,
  `majorname` varchar(255) DEFAULT NULL,
  `collegeId` int(11) DEFAULT NULL,
  PRIMARY KEY (`majorId`),
  KEY `collegeId_major_college` (`collegeId`) USING BTREE,
  CONSTRAINT `class_major_ibfk_1` FOREIGN KEY (`collegeId`) REFERENCES `class_college` (`collegeId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for class_manager
-- ----------------------------
DROP TABLE IF EXISTS `class_manager`;
CREATE TABLE `class_manager` (
  `classId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `position` varchar(255) DEFAULT NULL,
  `power` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`classId`,`userId`),
  KEY `userId_admin_user` (`userId`) USING BTREE,
  CONSTRAINT `class_manager_ibfk_1` FOREIGN KEY (`classId`) REFERENCES `class_class` (`classId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `class_manager_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `class_user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for class_message
-- ----------------------------
DROP TABLE IF EXISTS `class_message`;
CREATE TABLE `class_message` (
  `messageId` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `classId` int(11) DEFAULT NULL,
  `content` longtext,
  `authorId` int(11) DEFAULT NULL,
  `createTime` datetime DEFAULT NULL,
  PRIMARY KEY (`messageId`),
  KEY `classId_message_class` (`classId`) USING BTREE,
  KEY `authorId_message_user` (`authorId`) USING BTREE,
  CONSTRAINT `class_message_ibfk_1` FOREIGN KEY (`authorId`) REFERENCES `class_user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `class_message_ibfk_2` FOREIGN KEY (`classId`) REFERENCES `class_class` (`classId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for class_notice
-- ----------------------------
DROP TABLE IF EXISTS `class_notice`;
CREATE TABLE `class_notice` (
  `noticeId` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `classId` int(11) DEFAULT NULL,
  `content` longtext,
  `authorId` int(11) DEFAULT NULL,
  `createTime` datetime DEFAULT NULL,
  PRIMARY KEY (`noticeId`),
  KEY `classId_notice_class` (`classId`) USING BTREE,
  KEY `authorId_notice_user` (`authorId`) USING BTREE,
  CONSTRAINT `class_notice_ibfk_1` FOREIGN KEY (`authorId`) REFERENCES `class_user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `class_notice_ibfk_2` FOREIGN KEY (`classId`) REFERENCES `class_class` (`classId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for class_score
-- ----------------------------
DROP TABLE IF EXISTS `class_score`;
CREATE TABLE `class_score` (
  `userId` int(11) NOT NULL,
  `courseId` int(11) NOT NULL,
  `score` int(3) DEFAULT NULL,
  PRIMARY KEY (`userId`,`courseId`),
  KEY `courseId_score_classsubject` (`courseId`) USING BTREE,
  CONSTRAINT `class_score_ibfk_1` FOREIGN KEY (`courseId`) REFERENCES `class_class_subject` (`courseId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `class_score_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `class_user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for class_share
-- ----------------------------
DROP TABLE IF EXISTS `class_share`;
CREATE TABLE `class_share` (
  `shareId` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) DEFAULT NULL,
  `fileId` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `classId` int(11) DEFAULT NULL,
  `shareTime` datetime DEFAULT NULL,
  PRIMARY KEY (`shareId`),
  KEY `fileId_share_file` (`fileId`) USING BTREE,
  KEY `classId_share_class` (`classId`) USING BTREE,
  KEY `userId_share_user` (`userId`) USING BTREE,
  CONSTRAINT `class_share_ibfk_1` FOREIGN KEY (`classId`) REFERENCES `class_class` (`classId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `class_share_ibfk_2` FOREIGN KEY (`fileId`) REFERENCES `class_file` (`fileId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `class_share_ibfk_3` FOREIGN KEY (`userId`) REFERENCES `class_user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for class_subject
-- ----------------------------
DROP TABLE IF EXISTS `class_subject`;
CREATE TABLE `class_subject` (
  `subjectId` int(11) NOT NULL AUTO_INCREMENT,
  `subjectname` varchar(255) DEFAULT NULL,
  `subjectCode` varchar(255) DEFAULT NULL,
  `collegeId` int(11) DEFAULT NULL,
  PRIMARY KEY (`subjectId`),
  KEY `collegeId_subject_college` (`collegeId`) USING BTREE,
  CONSTRAINT `class_subject_ibfk_1` FOREIGN KEY (`collegeId`) REFERENCES `class_college` (`collegeId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for class_task_record
-- ----------------------------
DROP TABLE IF EXISTS `class_task_record`;
CREATE TABLE `class_task_record` (
  `recordId` int(11) NOT NULL AUTO_INCREMENT,
  `taskId` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `fileId` int(11) DEFAULT NULL,
  `uploadTime` datetime DEFAULT NULL,
  PRIMARY KEY (`recordId`),
  KEY `fileId_record_file` (`fileId`) USING BTREE,
  KEY `taskId_record_title` (`taskId`) USING BTREE,
  KEY `userId_record_user` (`userId`) USING BTREE,
  CONSTRAINT `class_task_record_ibfk_1` FOREIGN KEY (`fileId`) REFERENCES `class_file` (`fileId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `class_task_record_ibfk_2` FOREIGN KEY (`taskId`) REFERENCES `class_task_title` (`taskId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `class_task_record_ibfk_3` FOREIGN KEY (`userId`) REFERENCES `class_user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for class_task_title
-- ----------------------------
DROP TABLE IF EXISTS `class_task_title`;
CREATE TABLE `class_task_title` (
  `taskId` int(11) NOT NULL AUTO_INCREMENT,
  `classId` int(11) DEFAULT NULL,
  `authorId` int(11) DEFAULT NULL,
  `subjectId` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `startTime` datetime DEFAULT NULL,
  `endTime` datetime DEFAULT NULL,
  `createTime` datetime DEFAULT NULL,
  `tip` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`taskId`),
  KEY `author_task_user` (`authorId`) USING BTREE,
  KEY `classId_task_class` (`classId`) USING BTREE,
  KEY `subjectId_task_subject` (`subjectId`) USING BTREE,
  CONSTRAINT `class_task_title_ibfk_1` FOREIGN KEY (`authorId`) REFERENCES `class_user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `class_task_title_ibfk_2` FOREIGN KEY (`classId`) REFERENCES `class_class` (`classId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `class_task_title_ibfk_3` FOREIGN KEY (`subjectId`) REFERENCES `class_subject` (`subjectId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for class_university
-- ----------------------------
DROP TABLE IF EXISTS `class_university`;
CREATE TABLE `class_university` (
  `universityId` int(11) NOT NULL AUTO_INCREMENT,
  `universityname` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`universityId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for class_user
-- ----------------------------
DROP TABLE IF EXISTS `class_user`;
CREATE TABLE `class_user` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `usernumber` varchar(255) DEFAULT NULL,
  `nikename` varchar(255) DEFAULT NULL,
  `sex` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `classId` int(11) DEFAULT NULL,
  `dormBuildId` int(11) DEFAULT NULL,
  `dormName` varchar(255) DEFAULT NULL COMMENT '临时用的',
  `dormId` int(11) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `zzmm` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`userId`),
  KEY `classId_user_class` (`classId`) USING BTREE,
  KEY `dormBuildId_user_dormBuild` (`dormBuildId`) USING BTREE,
  KEY `dormId_user_dorm` (`dormId`) USING BTREE,
  CONSTRAINT `class_user_ibfk_1` FOREIGN KEY (`classId`) REFERENCES `class_class` (`classId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `class_user_ibfk_2` FOREIGN KEY (`dormBuildId`) REFERENCES `class_dorm_build` (`dormBuildId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `class_user_ibfk_3` FOREIGN KEY (`dormId`) REFERENCES `class_dorm` (`dormId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for class_vote_option
-- ----------------------------
DROP TABLE IF EXISTS `class_vote_option`;
CREATE TABLE `class_vote_option` (
  `optionId` int(11) NOT NULL AUTO_INCREMENT,
  `questionId` int(11) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`optionId`),
  KEY `questionId_option_question` (`questionId`) USING BTREE,
  CONSTRAINT `class_vote_option_ibfk_1` FOREIGN KEY (`questionId`) REFERENCES `class_vote_question` (`questionId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for class_vote_question
-- ----------------------------
DROP TABLE IF EXISTS `class_vote_question`;
CREATE TABLE `class_vote_question` (
  `questionId` int(11) NOT NULL AUTO_INCREMENT,
  `voteId` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `mode` int(11) DEFAULT NULL COMMENT '0单选1多选',
  PRIMARY KEY (`questionId`),
  KEY `voteId_question_titile` (`voteId`) USING BTREE,
  CONSTRAINT `class_vote_question_ibfk_1` FOREIGN KEY (`voteId`) REFERENCES `class_vote_title` (`voteId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for class_vote_record
-- ----------------------------
DROP TABLE IF EXISTS `class_vote_record`;
CREATE TABLE `class_vote_record` (
  `recordId` int(11) NOT NULL AUTO_INCREMENT,
  `optionId` int(11) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `voteTime` datetime DEFAULT NULL,
  PRIMARY KEY (`recordId`),
  KEY `optionId_record_option` (`optionId`) USING BTREE,
  KEY `userIdId` (`userId`) USING BTREE,
  CONSTRAINT `class_vote_record_ibfk_1` FOREIGN KEY (`optionId`) REFERENCES `class_vote_option` (`optionId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `class_vote_record_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `class_user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for class_vote_title
-- ----------------------------
DROP TABLE IF EXISTS `class_vote_title`;
CREATE TABLE `class_vote_title` (
  `voteId` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `classId` int(11) DEFAULT NULL,
  `authorId` int(11) DEFAULT NULL,
  `startTime` datetime DEFAULT NULL,
  `endTime` datetime DEFAULT NULL,
  `createTime` datetime DEFAULT NULL,
  `status` int(2) DEFAULT '0',
  PRIMARY KEY (`voteId`),
  KEY `authorId_vote_user` (`authorId`) USING BTREE,
  KEY `classId_vote_class` (`classId`) USING BTREE,
  CONSTRAINT `class_vote_title_ibfk_1` FOREIGN KEY (`authorId`) REFERENCES `class_user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `class_vote_title_ibfk_2` FOREIGN KEY (`classId`) REFERENCES `class_class` (`classId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- View structure for class_view_activity
-- ----------------------------
DROP VIEW IF EXISTS `class_view_activity`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `class_view_activity` AS select `class_activity`.`activityId` AS `activityId`,`class_activity`.`name` AS `name`,`class_activity`.`authorId` AS `authorId`,`class_activity`.`classId` AS `classId`,`class_activity`.`endTime` AS `endTime`,`class_activity`.`createTime` AS `createTime`,`class_activity`.`description` AS `description`,count(distinct `class_activity_content`.`userId`) AS `num`,`class_activity`.`status` AS `status`,`class_class`.`className` AS `className`,`class_user`.`username` AS `username`,`class_user`.`usernumber` AS `usernumber`,`class_user`.`nikename` AS `nikename`,`class_activity`.`startTime` AS `startTime` from ((((`class_activity` left join `class_activity_question` on((`class_activity_question`.`activityId` = `class_activity`.`activityId`))) left join `class_activity_content` on((`class_activity_content`.`questionId` = `class_activity_question`.`questionId`))) join `class_class` on((`class_activity`.`classId` = `class_class`.`classId`))) join `class_user` on((`class_activity`.`authorId` = `class_user`.`userId`))) group by `class_activity`.`activityId` ;

-- ----------------------------
-- View structure for class_view_activity_question
-- ----------------------------
DROP VIEW IF EXISTS `class_view_activity_question`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `class_view_activity_question` AS select `class_activity`.`activityId` AS `activityId`,`class_activity`.`name` AS `name`,`class_activity`.`authorId` AS `authorId`,`class_activity`.`classId` AS `classId`,`class_activity`.`startTime` AS `startTime`,`class_activity`.`endTime` AS `endTime`,`class_activity`.`createTime` AS `createTime`,`class_activity`.`description` AS `description`,`class_user`.`username` AS `username`,`class_user`.`usernumber` AS `usernumber`,`class_user`.`nikename` AS `nikename`,`class_activity_question`.`question` AS `question`,`class_activity_question`.`questionId` AS `questionId` from ((`class_activity` join `class_activity_question` on((`class_activity_question`.`activityId` = `class_activity`.`activityId`))) join `class_user` on((`class_activity`.`authorId` = `class_user`.`userId`))) ;

-- ----------------------------
-- View structure for class_view_activity_question_content
-- ----------------------------
DROP VIEW IF EXISTS `class_view_activity_question_content`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `class_view_activity_question_content` AS select `class_activity_question`.`activityId` AS `activityId`,`class_activity_question`.`questionId` AS `questionId`,`class_activity_question`.`question` AS `question`,`class_activity_content`.`contentId` AS `contentId`,`class_user`.`username` AS `username`,`class_user`.`usernumber` AS `usernumber`,`class_user`.`nikename` AS `nikename`,`class_activity_content`.`userId` AS `userId`,`class_activity_content`.`content` AS `content`,`class_activity_question`.`mode` AS `mode` from ((`class_activity_question` join `class_activity_content` on((`class_activity_content`.`questionId` = `class_activity_question`.`questionId`))) join `class_user` on((`class_activity_content`.`userId` = `class_user`.`userId`))) ;

-- ----------------------------
-- View structure for class_view_activity_user
-- ----------------------------
DROP VIEW IF EXISTS `class_view_activity_user`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `class_view_activity_user` AS select distinct `class_activity`.`activityId` AS `activityId`,`class_activity`.`name` AS `name`,`class_activity`.`authorId` AS `authorId`,`class_activity`.`classId` AS `classId`,`class_activity`.`startTime` AS `startTime`,`class_activity`.`endTime` AS `endTime`,`class_activity`.`createTime` AS `createTime`,`class_activity`.`description` AS `description`,`class_user`.`userId` AS `userId`,`class_user`.`username` AS `username`,`class_user`.`usernumber` AS `usernumber`,`class_user`.`nikename` AS `nikename` from (((`class_activity` left join `class_activity_question` on((`class_activity_question`.`activityId` = `class_activity`.`activityId`))) left join `class_activity_content` on((`class_activity_content`.`questionId` = `class_activity_question`.`questionId`))) left join `class_user` on((`class_activity_content`.`userId` = `class_user`.`userId`))) ;

-- ----------------------------
-- View structure for class_view_chatroom
-- ----------------------------
DROP VIEW IF EXISTS `class_view_chatroom`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `class_view_chatroom` AS select `class_chatroom`.`msgId` AS `msgId`,`class_chatroom`.`classId` AS `classId`,`class_chatroom`.`userId` AS `userId`,`class_chatroom`.`content` AS `content`,`class_chatroom`.`createTime` AS `createTime`,`class_class`.`className` AS `className`,`class_user`.`username` AS `username`,`class_user`.`usernumber` AS `usernumber`,`class_user`.`nikename` AS `nikename` from ((`class_chatroom` join `class_class` on((`class_chatroom`.`classId` = `class_class`.`classId`))) join `class_user` on((`class_chatroom`.`userId` = `class_user`.`userId`))) ;

-- ----------------------------
-- View structure for class_view_investigation
-- ----------------------------
DROP VIEW IF EXISTS `class_view_investigation`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `class_view_investigation` AS select `class_investigation_title`.`investigationId` AS `investigationId`,`class_investigation_title`.`title` AS `title`,`class_investigation_title`.`classId` AS `classId`,`class_investigation_title`.`authorId` AS `authorId`,`class_investigation_title`.`endTime` AS `endTime`,`class_investigation_title`.`createTime` AS `createTime`,`class_user`.`username` AS `username`,`class_user`.`usernumber` AS `usernumber`,`class_user`.`nikename` AS `nikename`,`class_class`.`className` AS `className`,count(distinct `class_investigation_record`.`userId`) AS `num`,`class_investigation_title`.`startTime` AS `startTime`,`class_investigation_title`.`status` AS `status` from (((((`class_investigation_title` join `class_user` on((`class_investigation_title`.`authorId` = `class_user`.`userId`))) join `class_class` on((`class_investigation_title`.`classId` = `class_class`.`classId`))) join `class_investigation_question` on((`class_investigation_question`.`investigationId` = `class_investigation_title`.`investigationId`))) join `class_investigation_option` on((`class_investigation_option`.`questionId` = `class_investigation_question`.`questionId`))) left join `class_investigation_record` on((`class_investigation_record`.`optionId` = `class_investigation_option`.`optionId`))) group by `class_investigation_title`.`investigationId` ;

-- ----------------------------
-- View structure for class_view_investigation_option_record
-- ----------------------------
DROP VIEW IF EXISTS `class_view_investigation_option_record`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `class_view_investigation_option_record` AS select `class_investigation_option`.`optionId` AS `optionId`,`class_investigation_option`.`questionId` AS `questionId`,`class_investigation_option`.`content` AS `content`,`class_investigation_option`.`image` AS `image`,count(distinct `class_investigation_record`.`userId`) AS `num` from (`class_investigation_option` left join `class_investigation_record` on((`class_investigation_record`.`optionId` = `class_investigation_option`.`optionId`))) group by `class_investigation_option`.`optionId` ;

-- ----------------------------
-- View structure for class_view_investigation_quesion_record
-- ----------------------------
DROP VIEW IF EXISTS `class_view_investigation_quesion_record`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `class_view_investigation_quesion_record` AS select `class_investigation_question`.`investigationId` AS `investigationId`,`class_investigation_question`.`title` AS `title`,`class_investigation_question`.`mode` AS `mode`,`class_view_investigation_option_record`.`optionId` AS `optionId`,`class_view_investigation_option_record`.`content` AS `content`,`class_view_investigation_option_record`.`image` AS `image`,`class_view_investigation_option_record`.`num` AS `num` from (`class_view_investigation_option_record` join `class_investigation_question` on((`class_view_investigation_option_record`.`questionId` = `class_investigation_question`.`questionId`))) ;

-- ----------------------------
-- View structure for class_view_investigation_user
-- ----------------------------
DROP VIEW IF EXISTS `class_view_investigation_user`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `class_view_investigation_user` AS select distinct `class_investigation_title`.`investigationId` AS `investigationId`,`class_investigation_title`.`title` AS `title`,`class_investigation_title`.`classId` AS `classId`,`class_investigation_title`.`authorId` AS `authorId`,`class_user`.`userId` AS `userId`,`class_user`.`username` AS `username`,`class_user`.`usernumber` AS `usernumber`,`class_user`.`nikename` AS `nikename`,`class_investigation_title`.`startTime` AS `startTime`,`class_investigation_title`.`endTime` AS `endTime`,`class_investigation_title`.`createTime` AS `createTime`,`class_investigation_title`.`status` AS `status` from ((((`class_investigation_title` join `class_investigation_question` on((`class_investigation_question`.`investigationId` = `class_investigation_title`.`investigationId`))) join `class_investigation_option` on((`class_investigation_option`.`questionId` = `class_investigation_question`.`questionId`))) join `class_investigation_record` on((`class_investigation_record`.`optionId` = `class_investigation_option`.`optionId`))) join `class_user` on((`class_investigation_record`.`userId` = `class_user`.`userId`))) ;

-- ----------------------------
-- View structure for class_view_manager
-- ----------------------------
DROP VIEW IF EXISTS `class_view_manager`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `class_view_manager` AS select `class_user`.`userId` AS `userId`,`class_user`.`username` AS `username`,`class_user`.`usernumber` AS `usernumber`,`class_user`.`nikename` AS `nikename`,`class_user`.`sex` AS `sex`,`class_class`.`classId` AS `classId`,`class_class`.`className` AS `className`,`class_manager`.`position` AS `position`,`class_manager`.`power` AS `power`,`class_user`.`tel` AS `tel`,`class_manager`.`description` AS `description` from ((`class_manager` join `class_class` on((`class_manager`.`classId` = `class_class`.`classId`))) join `class_user` on((`class_manager`.`userId` = `class_user`.`userId`))) ;

-- ----------------------------
-- View structure for class_view_message
-- ----------------------------
DROP VIEW IF EXISTS `class_view_message`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `class_view_message` AS select `class_message`.`messageId` AS `messageId`,`class_message`.`title` AS `title`,`class_message`.`classId` AS `classId`,`class_class`.`className` AS `className`,`class_message`.`content` AS `content`,`class_message`.`authorId` AS `authorId`,`class_user`.`username` AS `username`,`class_user`.`usernumber` AS `usernumber`,`class_user`.`nikename` AS `nikename`,`class_message`.`createTime` AS `createTime` from ((`class_message` join `class_class` on((`class_message`.`classId` = `class_class`.`classId`))) join `class_user` on((`class_message`.`authorId` = `class_user`.`userId`))) ;

-- ----------------------------
-- View structure for class_view_notice
-- ----------------------------
DROP VIEW IF EXISTS `class_view_notice`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `class_view_notice` AS select `class_notice`.`noticeId` AS `noticeId`,`class_notice`.`title` AS `title`,`class_notice`.`classId` AS `classId`,`class_class`.`className` AS `className`,`class_notice`.`content` AS `content`,`class_notice`.`authorId` AS `authorId`,`class_user`.`username` AS `username`,`class_user`.`usernumber` AS `usernumber`,`class_user`.`nikename` AS `nikename`,`class_notice`.`createTime` AS `createTime` from ((`class_notice` join `class_class` on((`class_notice`.`classId` = `class_class`.`classId`))) join `class_user` on((`class_notice`.`authorId` = `class_user`.`userId`))) ;

-- ----------------------------
-- View structure for class_view_score
-- ----------------------------
DROP VIEW IF EXISTS `class_view_score`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `class_view_score` AS select `class_user`.`userId` AS `userId`,`class_user`.`username` AS `username`,`class_user`.`usernumber` AS `usernumber`,`class_user`.`nikename` AS `nikename`,`class_user`.`sex` AS `sex`,`class_score`.`score` AS `score`,`class_score`.`courseId` AS `courseId`,`class_class_subject`.`subjectId` AS `subjectId`,`class_class_subject`.`term` AS `term`,`class_subject`.`subjectname` AS `subjectname`,`class_subject`.`subjectCode` AS `subjectCode` from (((`class_score` join `class_user` on((`class_score`.`userId` = `class_user`.`userId`))) join `class_class_subject` on((`class_score`.`courseId` = `class_class_subject`.`courseId`))) join `class_subject` on((`class_class_subject`.`subjectId` = `class_subject`.`subjectId`))) ;

-- ----------------------------
-- View structure for class_view_score_avg
-- ----------------------------
DROP VIEW IF EXISTS `class_view_score_avg`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `class_view_score_avg` AS select `class_user`.`userId` AS `userId`,`class_user`.`username` AS `username`,`class_user`.`usernumber` AS `usernumber`,`class_user`.`nikename` AS `nikename`,`class_user`.`sex` AS `sex`,`class_user`.`tel` AS `tel`,avg(`class_view_score`.`score`) AS `avg`,`class_view_score`.`term` AS `term`,`class_user`.`classId` AS `classId`,`class_class`.`className` AS `className` from ((`class_user` join `class_view_score` on((`class_user`.`userId` = `class_view_score`.`userId`))) join `class_class` on((`class_user`.`classId` = `class_class`.`classId`))) group by `class_user`.`userId`,`class_user`.`username`,`class_user`.`usernumber`,`class_user`.`nikename`,`class_user`.`sex`,`class_user`.`tel`,`class_view_score`.`term`,`class_user`.`classId` ;

-- ----------------------------
-- View structure for class_view_score_avg_rank
-- ----------------------------
DROP VIEW IF EXISTS `class_view_score_avg_rank`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `class_view_score_avg_rank` AS select `T`.`userId` AS `userId`,`T`.`username` AS `username`,`T`.`usernumber` AS `usernumber`,`T`.`nikename` AS `nikename`,`T`.`sex` AS `sex`,`T`.`tel` AS `tel`,`T`.`avg` AS `avg`,`T`.`term` AS `term`,`T`.`classId` AS `classId`,`T`.`className` AS `className`,((select count(0) from `class_view_score_avg` where ((`class_view_score_avg`.`term` = `T`.`term`) and (`class_view_score_avg`.`avg` > `T`.`avg`))) + 1) AS `rank` from `class_view_score_avg` `T` ;

-- ----------------------------
-- View structure for class_view_share_file
-- ----------------------------
DROP VIEW IF EXISTS `class_view_share_file`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `class_view_share_file` AS select `class_share`.`shareId` AS `shareId`,`class_share`.`fileId` AS `fileId`,`class_share`.`userId` AS `userId`,`class_share`.`classId` AS `classId`,`class_file`.`name` AS `name`,`class_file`.`savename` AS `savename`,`class_file`.`location` AS `location`,`class_file`.`type` AS `type`,`class_file`.`size` AS `size`,`class_file`.`md5` AS `md5`,`class_file`.`sha1` AS `sha1`,`class_class`.`className` AS `className`,`class_user`.`username` AS `username`,`class_user`.`usernumber` AS `usernumber`,`class_user`.`nikename` AS `nikename`,`class_user`.`sex` AS `sex`,`class_share`.`shareTime` AS `shareTime`,`class_share`.`description` AS `description` from (((`class_share` join `class_file` on((`class_share`.`fileId` = `class_file`.`fileId`))) join `class_class` on((`class_share`.`classId` = `class_class`.`classId`))) join `class_user` on((`class_share`.`userId` = `class_user`.`userId`))) ;

-- ----------------------------
-- View structure for class_view_student
-- ----------------------------
DROP VIEW IF EXISTS `class_view_student`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `class_view_student` AS select `class_user`.`userId` AS `userId`,`class_user`.`username` AS `username`,`class_user`.`usernumber` AS `usernumber`,`class_user`.`nikename` AS `nikename`,`class_user`.`sex` AS `sex`,`class_user`.`classId` AS `classId`,`class_class`.`className` AS `className`,`class_user`.`dormName` AS `dormName`,`class_user`.`tel` AS `tel`,`class_dorm_build`.`dormBuildId` AS `dormBuildId`,`class_dorm_build`.`location` AS `location`,`class_dorm_build`.`dormBuildName` AS `dormBuildName`,`class_user`.`password` AS `password` from ((`class_user` join `class_class` on(((`class_user`.`classId` = `class_class`.`classId`) and (`class_user`.`classId` = `class_class`.`classId`)))) left join `class_dorm_build` on((`class_user`.`dormBuildId` = `class_dorm_build`.`dormBuildId`))) ;

-- ----------------------------
-- View structure for class_view_student_info
-- ----------------------------
DROP VIEW IF EXISTS `class_view_student_info`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `class_view_student_info` AS select `class_user`.`userId` AS `userId`,`class_user`.`username` AS `username`,`class_user`.`usernumber` AS `usernumber`,`class_user`.`nikename` AS `nikename`,`class_user`.`sex` AS `sex`,`class_class`.`className` AS `className`,`class_major`.`majorname` AS `majorname`,`class_college`.`collegename` AS `collegename`,`class_university`.`universityname` AS `universityname`,`class_user`.`classId` AS `classId`,`class_class`.`majorId` AS `majorId`,`class_major`.`collegeId` AS `collegeId`,`class_college`.`universityId` AS `universityId`,`class_user`.`dormName` AS `dormName`,`class_user`.`dormId` AS `dormId`,`class_user`.`dormBuildId` AS `dormBuildId`,`class_user`.`tel` AS `tel`,`class_user`.`zzmm` AS `zzmm`,`class_user`.`password` AS `password`,`class_dorm_build`.`dormBuildName` AS `dormBuildName` from (((((`class_user` left join `class_class` on((`class_user`.`classId` = `class_class`.`classId`))) left join `class_major` on((`class_class`.`majorId` = `class_major`.`majorId`))) left join `class_college` on((`class_major`.`collegeId` = `class_college`.`collegeId`))) left join `class_university` on((`class_college`.`universityId` = `class_university`.`universityId`))) left join `class_dorm_build` on((`class_user`.`dormBuildId` = `class_dorm_build`.`dormBuildId`))) ;

-- ----------------------------
-- View structure for class_view_subject
-- ----------------------------
DROP VIEW IF EXISTS `class_view_subject`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `class_view_subject` AS select `class_class_subject`.`courseId` AS `courseId`,`class_class`.`classId` AS `classId`,`class_class`.`className` AS `className`,`class_class_subject`.`subjectId` AS `subjectId`,`class_subject`.`subjectname` AS `subjectname`,`class_class_subject`.`term` AS `term`,`class_subject`.`subjectCode` AS `subjectCode`,`class_subject`.`collegeId` AS `collegeId`,`class_college`.`collegename` AS `collegename` from (((`class_class` left join `class_class_subject` on((`class_class_subject`.`classId` = `class_class`.`classId`))) left join `class_subject` on((`class_class_subject`.`subjectId` = `class_subject`.`subjectId`))) left join `class_college` on((`class_subject`.`collegeId` = `class_college`.`collegeId`))) ;

-- ----------------------------
-- View structure for class_view_subject_info
-- ----------------------------
DROP VIEW IF EXISTS `class_view_subject_info`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `class_view_subject_info` AS select `class_subject`.`subjectId` AS `subjectId`,`class_subject`.`subjectname` AS `subjectname`,`class_subject`.`subjectCode` AS `subjectCode`,`class_subject`.`collegeId` AS `collegeId`,`class_college`.`collegename` AS `collegename`,`class_college`.`universityId` AS `universityId`,`class_university`.`universityname` AS `universityname` from ((`class_subject` left join `class_college` on((`class_subject`.`collegeId` = `class_college`.`collegeId`))) left join `class_university` on((`class_college`.`universityId` = `class_university`.`universityId`))) ;

-- ----------------------------
-- View structure for class_view_task
-- ----------------------------
DROP VIEW IF EXISTS `class_view_task`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `class_view_task` AS select `class_task_title`.`taskId` AS `taskId`,`class_task_title`.`classId` AS `classId`,`class_user`.`usernumber` AS `usernumber`,`class_user`.`nikename` AS `nikename`,`class_user`.`username` AS `username`,`class_task_title`.`title` AS `title`,`class_task_title`.`authorId` AS `authorId`,`class_task_title`.`startTime` AS `startTime`,`class_task_title`.`endTime` AS `endTime`,`class_task_title`.`createTime` AS `createTime`,`class_task_title`.`tip` AS `tip`,`class_task_title`.`description` AS `description`,`class_task_title`.`status` AS `status`,`class_subject`.`subjectname` AS `subjectname`,`class_subject`.`subjectId` AS `subjectId`,count(distinct `class_task_record`.`userId`) AS `Count(distinct class_task_record.userId)` from (((`class_task_title` left join `class_user` on((`class_task_title`.`authorId` = `class_user`.`userId`))) left join `class_subject` on((`class_task_title`.`subjectId` = `class_subject`.`subjectId`))) left join `class_task_record` on((`class_task_record`.`taskId` = `class_task_title`.`taskId`))) group by `class_task_title`.`taskId`,`class_task_title`.`classId`,`class_user`.`usernumber`,`class_user`.`nikename`,`class_user`.`username`,`class_task_title`.`title`,`class_task_title`.`authorId`,`class_task_title`.`startTime`,`class_task_title`.`endTime`,`class_task_title`.`createTime`,`class_task_title`.`tip`,`class_task_title`.`description`,`class_task_title`.`status`,`class_subject`.`subjectname`,`class_subject`.`subjectId` ;

-- ----------------------------
-- View structure for class_view_taskfiles
-- ----------------------------
DROP VIEW IF EXISTS `class_view_taskfiles`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `class_view_taskfiles` AS select `class_file`.`fileId` AS `fileId`,`class_file`.`name` AS `name`,`class_file`.`savename` AS `savename`,`class_file`.`location` AS `location`,`class_user`.`nikename` AS `nikename`,`class_user`.`usernumber` AS `usernumber`,`class_file`.`type` AS `type`,`class_file`.`size` AS `size`,`class_file`.`md5` AS `md5`,`class_file`.`sha1` AS `sha1`,`class_task_record`.`recordId` AS `recordId`,`class_task_record`.`taskId` AS `taskId`,`class_task_record`.`userId` AS `userId`,`class_task_record`.`uploadTime` AS `uploadTime`,`class_task_title`.`classId` AS `classId`,`class_task_title`.`authorId` AS `authorId`,`class_task_title`.`title` AS `title`,`class_task_title`.`startTime` AS `startTime`,`class_task_title`.`endTime` AS `endTime`,`class_task_title`.`createTime` AS `createTime`,`class_task_title`.`tip` AS `tip`,`class_task_title`.`description` AS `description` from (((`class_file` join `class_task_record` on((`class_task_record`.`fileId` = `class_file`.`fileId`))) join `class_task_title` on((`class_task_record`.`taskId` = `class_task_title`.`taskId`))) join `class_user` on((`class_task_record`.`userId` = `class_user`.`userId`))) ;

-- ----------------------------
-- View structure for class_view_vote
-- ----------------------------
DROP VIEW IF EXISTS `class_view_vote`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `class_view_vote` AS select `class_vote_title`.`voteId` AS `voteId`,`class_vote_title`.`title` AS `title`,`class_vote_title`.`classId` AS `classId`,`class_vote_title`.`authorId` AS `authorId`,`class_vote_title`.`endTime` AS `endTime`,`class_vote_title`.`createTime` AS `createTime`,`class_user`.`username` AS `username`,`class_user`.`usernumber` AS `usernumber`,`class_user`.`nikename` AS `nikename`,`class_class`.`className` AS `className`,count(distinct `class_vote_record`.`userId`) AS `num`,`class_vote_title`.`startTime` AS `startTime`,`class_vote_title`.`status` AS `status` from (((((`class_vote_title` join `class_user` on((`class_vote_title`.`authorId` = `class_user`.`userId`))) join `class_class` on((`class_vote_title`.`classId` = `class_class`.`classId`))) join `class_vote_question` on((`class_vote_question`.`voteId` = `class_vote_title`.`voteId`))) join `class_vote_option` on((`class_vote_option`.`questionId` = `class_vote_question`.`questionId`))) left join `class_vote_record` on((`class_vote_record`.`optionId` = `class_vote_option`.`optionId`))) group by `class_vote_title`.`voteId` ;

-- ----------------------------
-- View structure for class_view_vote_option_record
-- ----------------------------
DROP VIEW IF EXISTS `class_view_vote_option_record`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `class_view_vote_option_record` AS select `class_vote_option`.`optionId` AS `optionId`,`class_vote_option`.`questionId` AS `questionId`,`class_vote_option`.`content` AS `content`,`class_vote_option`.`image` AS `image`,count(distinct `class_vote_record`.`userId`) AS `num` from (`class_vote_option` left join `class_vote_record` on((`class_vote_record`.`optionId` = `class_vote_option`.`optionId`))) group by `class_vote_option`.`optionId` ;

-- ----------------------------
-- View structure for class_view_vote_question_record
-- ----------------------------
DROP VIEW IF EXISTS `class_view_vote_question_record`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `class_view_vote_question_record` AS select `class_vote_question`.`voteId` AS `voteId`,`class_vote_question`.`title` AS `title`,`class_vote_question`.`mode` AS `mode`,`class_view_vote_option_record`.`optionId` AS `optionId`,`class_view_vote_option_record`.`content` AS `content`,`class_view_vote_option_record`.`image` AS `image`,`class_view_vote_option_record`.`num` AS `num` from (`class_view_vote_option_record` join `class_vote_question` on((`class_view_vote_option_record`.`questionId` = `class_vote_question`.`questionId`))) ;

-- ----------------------------
-- View structure for class_view_vote_user
-- ----------------------------
DROP VIEW IF EXISTS `class_view_vote_user`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `class_view_vote_user` AS select distinct `class_vote_title`.`voteId` AS `voteId`,`class_vote_title`.`title` AS `title`,`class_vote_title`.`classId` AS `classId`,`class_vote_title`.`authorId` AS `authorId`,`class_user`.`userId` AS `userId`,`class_user`.`username` AS `username`,`class_user`.`usernumber` AS `usernumber`,`class_user`.`nikename` AS `nikename`,`class_vote_title`.`startTime` AS `startTime`,`class_vote_title`.`endTime` AS `endTime`,`class_vote_title`.`createTime` AS `createTime`,`class_vote_title`.`status` AS `status` from ((((`class_vote_title` join `class_vote_question` on((`class_vote_question`.`voteId` = `class_vote_title`.`voteId`))) join `class_vote_option` on((`class_vote_option`.`questionId` = `class_vote_question`.`questionId`))) join `class_vote_record` on((`class_vote_record`.`optionId` = `class_vote_option`.`optionId`))) join `class_user` on((`class_vote_record`.`userId` = `class_user`.`userId`))) ;
