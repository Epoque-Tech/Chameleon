<?php
use Epoque\Chameleon\MySQLDB;

$sql = 'create table test(id int auto_increment primary key, test_key varchar(32), test_value varchar(64))';
//print_r(MySQLDB::insert($sql));

print_r( MySQLDB::headers('test'));

?>

<h2>MySQLDB Tests</h2>

