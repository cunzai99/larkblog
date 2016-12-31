<?php
/**
 * memcache配置
 * 
 */

$server['host']        = '127.0.0.1';
$server['port']        = '11211';
$server['weight']      = '100';
$server['lasting']     = '1';
$server['connectTime'] = '1';

$servers[] = $server;

return array(
			// 'keyLists' => ,
			'servers'  => $servers
		);