<?php
/**
 * [BcLineNotify] CakeSchema
 *
 * @link			http://blog.kaburk.com/
 * @author			kaburk
 * @package			BcLineNotify
 * @license			MIT
 */
class BcLineNotifyConfigsSchema extends CakeSchema {

	public $name = 'BcLineNotifyConfigs';
	public $file = 'bc_line_notify_configs.php';
	public $connection = 'plugin';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {

	}

	public $bc_line_notify_configs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'value' => array('type' => 'text', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
	);

}
