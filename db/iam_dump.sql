
#################################

CREATE DATABASE iam;

USE iam;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL UNIQUE,
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
  `account` varchar(32) NOT NULL UNIQUE,
  `password` varchar(64) NOT NULL DEFAULT '',
  `fullname` varchar(64) DEFAULT '',
  `department` varchar(64) DEFAULT '',
  `ip` varchar(20) NOT NULL UNIQUE,
  `vlan` varchar(20) NOT NULL,
  `server` varchar(64) NOT NULL,
  `device` varchar(16) NOT NULL,
  `dns1` varchar(16) NOT NULL,
  `dns2` varchar(16) NOT NULL,
  `network` varchar(20) NOT NULL,
  `netmask` varchar(20) NOT NULL,
  `descr` varchar(255) DEFAULT '',
  `state` varchar(16) NOT NULL DEFAULT 'enable',
  `add_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `change_by` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
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

CREATE TABLE IF NOT EXISTS `routes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
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

###############################

CREATE USER 'iamuser'@'localhost' IDENTIFIED WITH mysql_native_password BY 'iampass';
GRANT ALL PRIVILEGES ON iam.* TO 'iamuser'@'localhost';
FLUSH PRIVILEGES;

#ALTER USER 'admin'@'localhost' IDENTIFIED WITH mysql_native_password BY 'admin';

###############################

INSERT INTO users (username, fullname, password, permission, state, change_by ) VALUES ('admin','full Name', MD5('admin'), 'administrator', 'enable', 'test' );

################################
#[mysqld]
#default_authentication_plugin= mysql_native_password

#FLUSH PRIVILEGES;

################################
