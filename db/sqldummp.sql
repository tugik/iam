
#################################

CREATE DATABASE iam;

USE iam;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL UNIQUE,
  `fullname` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `permission` varchar(16) NOT NULL,
  `state` varchar(16) NOT NULL DEFAULT 'enable',
  `add_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `change_by` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(64) NOT NULL UNIQUE,
  `fullname` varchar(64) DEFAULT '',
  `department` varchar(64) DEFAULT '',
  `ip` varchar(64) NOT NULL,
  `vlan` varchar(20) NOT NULL,
  `server` varchar(64) NOT NULL,
  `device` varchar(64) NOT NULL,
  `dns` varchar(64) NOT NULL,
  `net` varchar(64) NOT NULL,
  `subnet` varchar(64) NOT NULL,
  `descr` varchar(255) DEFAULT '',
  `state` varchar(16) NOT NULL DEFAULT 'enable',
  `add_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `change_by` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `routes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `default` ENUM('yes','no') NOT NULL DEFAULT 'yes',
  `dst_ip` varchar(20) NOT NULL,
  `dst_mask` varchar(20) NOT NULL,
  `descr` varchar(255) DEFAULT '',
  `state` varchar(16) NOT NULL DEFAULT 'enable',
  `add_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `change_by` varchar(64) NOT NULL,
   PRIMARY KEY (`id`),
   FOREIGN KEY (account_id)  REFERENCES accounts (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `accesslist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `proto` varchar(10) NOT NULL,
  `dst_ip` varchar(20) NOT NULL,
  `dst_port` varchar(10) NOT NULL,
  `action` varchar(16) NOT NULL DEFAULT 'accept',
  `descr` varchar(255) NOT NULL,
  `state` varchar(16) NOT NULL DEFAULT 'enable',
  `add_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `change_by` varchar(64) NOT NULL,
   PRIMARY KEY (`id`),
   FOREIGN KEY (account_id)  REFERENCES accounts (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=11;



###############################

CREATE USER 'iamuser'@'localhost' IDENTIFIED WITH mysql_native_password BY 'iampass';
GRANT ALL PRIVILEGES ON iam.* TO 'iamuser'@'localhost';
FLUSH PRIVILEGES;

#ALTER USER 'test'@'localhost' IDENTIFIED WITH mysql_native_password BY 'test';

###############################

INSERT INTO users (username, fullname, password, permission, state, change_by ) VALUES ('test','full test', MD5('test'), 'administrator', 'enable', 'test' );

#[mysqld]
#default_authentication_plugin= mysql_native_password

#FLUSH PRIVILEGES;

################################
