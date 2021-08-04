<?php
/**
 * [BcLineNotifyConfig] BcLineNotify model
 *
 * @link			http://blog.kaburk.com/
 * @author			kaburk
 * @package			BcLineNotify
 * @license			MIT
 */
class BcLineNotifyConfig extends AppModel {

	public $name = 'BcLineNotifyConfig';

	public $actsAs = [
	];

	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->validate = [
			'acces_token' => [
				[
					'rule' => [
						'notBlank',
					],
					'message' => __d('baser', 'アクセストークンを入力してください。'),
					'required' => true,
				],
			],
		];
	}

}
