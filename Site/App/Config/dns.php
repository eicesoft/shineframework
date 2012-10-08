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

	'database_slave_map' => array(
		'master' => 'master'
	),

	'index_database' => array('index'),

	'index_redis' => array(
		'host' => '172.17.0.21',
		'port' => 6379
	),

	'redis_source' => array(
		'master' => array(
			'host' => '172.17.0.21',
			'port' => 6379
		),
	),

	'memcache_source' => array(
		'master' => array(
			'host' => '172.17.0.21',
			'port' => 11211
		),
	),

	'database_index_map' => array(
		0 => 'master',
	),

	'memcache_index_map' => array(
		0 => 'master',
	),

	'redis_index_map' => array(
		0 => 'master',
	),
);