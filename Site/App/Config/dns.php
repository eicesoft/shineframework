<?php
return array(
	/* 数据库配置 */
	'database_source' => array(
		'master' => array(
			'host' => '127.0.0.1',
			'database' => 'site',
			'user' => 'root',
			'password' => 'qwerasdf',
			'encode' => 'utf-8',
			'port' => 3306,
			'width' => 1,
		),

		'index' => array(
			'host' => '127.0.0.1',
			'database' => 'site',
			'user' => 'root',
			'password' => 'qwerasdf',
			'encode' => 'utf-8',
			'port' => 3306,
			'width' => 1,
		),
	),

	'database_index_map' => array(
		'master' => 0,
	),

	'database_slave_map' => array(
		'master' => 'master'
	),

	'index_database' => array('index'),
);