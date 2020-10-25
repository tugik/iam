
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
  `group` varchar(64) DEFAULT '',
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

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `protocol` varchar(10) NOT NULL,
  `dst_ip` varchar(20) NOT NULL,
  `dst_port` varchar(10) NOT NULL,
  `action` varchar(16) NOT NULL DEFAULT 'accept',
  `description` varchar(255) NOT NULL,
  `state` varchar(16) NOT NULL DEFAULT 'enable',
  `add_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `change_by` varchar(64) NOT NULL,
   PRIMARY KEY (`id`),
   FOREIGN KEY (account_id)  REFERENCES accounts (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=11;




###############################


#cat ./test.zone | awk {'print " insert into records (name, zone_id, ttl, class, type, data, descr, change_by) values ( `" $1"`, `11`, `7200`, `IN`,  `"$2 "`,  `"$3 "`, `test.zone`, `testing`);"'} > test.wnb
#INSERT INTO zones (zone, type_zone, file, masters, forwarders, name, ttl, class, type, primary_ns, resp_person, serial, refresh, retry, expire, minimum, change_by) VALUES ('test.zone', 'master', '/etc/bind/test.zone', 'NO ', 'NO', 'test.zone', '7200', 'IN', 'SOA', 'ns1.test.zone', 'test@zone.test', '2020021900', '3600', '600', '604800', '1800', 'testing' );

###############################

#INSERT INTO users (username, fullname, password, permission, state, change_by ) VALUES ('test','full test', MD5('test'), 'administrator', 'enable', 'test' );

#[mysqld]
#default_authentication_plugin= mysql_native_password

#FLUSH PRIVILEGES;

###############################

CREATE USER 'iamuser'@'localhost' IDENTIFIED WITH mysql_native_password BY 'iampass';
GRANT ALL PRIVILEGES ON iam.* TO 'iamuser'@'localhost';
FLUSH PRIVILEGES;

#ALTER USER 'test'@'localhost' IDENTIFIED WITH mysql_native_password BY 'test';
#ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'password';

################################
