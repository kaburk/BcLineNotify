<?php
/**
 * [BcLineNotify] setting
 *
 * @link			http://blog.kaburk.com/
 * @author			kaburk
 * @package			BcLineNotify
 * @license			MIT
 */

 /**
 * システムナビ
 */
$config['BcApp.adminNavigation'] = [
	'Plugins' => [
		'menus' => [
			'BcLineNotifyConfig' => [
				'title' => 'LINE通知設定',
				'url' => [
					'admin' => true,
					'plugin' => 'bc_line_notify',
					'controller' => 'bc_line_notifies',
					'action' => 'config',
				],
			],
		],
	],
];

define('LINE_API_URL'  ,"https://notify-api.line.me/api/notify");
