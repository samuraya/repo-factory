<?php

return [
	'cache'=>'App\\Repositories\\Cache\\CacheShirtOrderRepository',
	'default'=>'App\\Repositories\\MysqlDefault\\MysqlDefaultMessageRepository',
	'mysql_two'=>'App\\Repositories\\MysqlTwo\\MysqlTwoMessageRepository',
	'filesystem'=>'App\\Repositories\\Filesystem\\FilesystemMessageRepository'
	
];
