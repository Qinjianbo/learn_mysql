<?php
$host = '127.0.0.1';
$user = 'root';
$pwd = '123456';
$db = 'java';

$connection = mysqli_connect($host, $user, $pwd, $db);
if ($connection->connect_error) {
    die('Connect error('. $connection->connect_error. ') '. $connection->connect_errno);
}

// create table test( id int not null auto_increment, name varchar(10) not null default '', age tinyint default 0 not null, primary key (id) ) ENGINE=innodb default charset=utf8mb4 collate=utf8mb4_bin;
$insert = 'insert into test(name, age) values';
$insertData = [];
for ($i = 0; $i < 5000000; $i++) {
    $insertData[] = sprintf('(%s, %d)', $i+1, 'name'.($i+1));
    if ($i % 10000 == 0) {
        $insert .= implode(',', $insertData);
        $connection->query($insert);
        $insert = 'insert into test(name, age) values';
        $insertData = [];
    }
}
$connection->close();
//mysql> select count(*) from test;
//+----------+
//| count(*) |
//+----------+
//|  4990501 |
//+----------+

//mysql> show create table test\G;
//*************************** 1. row ***************************
//       Table: test
//Create Table: CREATE TABLE `test` (
//  `id` int(11) NOT NULL AUTO_INCREMENT,
//  `name` varchar(10) COLLATE utf8mb4_bin NOT NULL DEFAULT '',
//  `age` tinyint(4) NOT NULL DEFAULT '0',
//  PRIMARY KEY (`id`)
//) ENGINE=InnoDB AUTO_INCREMENT=4990502 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin
//1 row in set (0.00 sec)

//mysql> select * from test where name = 'name10000';
//Empty set (0.57 sec)
//
//mysql> select * from test where name = 'name100000';
//Empty set (0.57 sec)
//
//mysql> select * from test where name = 'name100000';
//Empty set (0.56 sec)
//
//mysql> select * from test where name = 'name100000';
//Empty set (0.56 sec)

//mysql> alter table test add index idx_name using btree(name);
//Query OK, 0 rows affected (10.59 sec)
//mysql> select * from test where name = 'name100000';
//Empty set (0.67 sec)
//
//mysql> select * from test where name = 'name100000';
//Empty set (0.66 sec)
//
//mysql> select * from test where name = 'name100000';
//Empty set (0.59 sec)
//
//mysql> select * from test where name = 'name100000';
//Empty set (0.63 sec)
//
//mysql> select * from test where name = 'name100000';
//Empty set (0.00 sec)
//
//mysql> select * from test where name = 'name100000';
//Empty set (0.00 sec)
