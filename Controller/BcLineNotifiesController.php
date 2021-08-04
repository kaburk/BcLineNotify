<?php
/**
 * [BcLineNotify] Controller
 *
 * @link			http://blog.kaburk.com/
 * @author			kaburk
 * @package			BcLineNotify
 * @license			MIT
 */
class BcLineNotifiesController extends AppController {

	public $uses = [
		'Content',
		'Site',
		'BcLineNotify.BcLineNotifyConfig',
	];

	public $components = [
		'BcAuth',
		'Cookie',
		'BcAuthConfigure',
		'BcMessage',
	];

		public function beforeFilter() {
		parent::beforeFilter();
	}

	/**
	 * [ADMIN] config
	 */
	public function admin_config() {


		$this->pageTitle = '各種設定';

		if (!$this->request->data) {

			$this->request->data['BcLineNotifyConfig'] = $this->BcLineNotifyConfig->findExpanded();
			foreach ($this->request->data['BcLineNotifyConfig'] as $key => $value) {
				if (preg_match('/^site_mail_(.*)$/', $key)) {
					$this->request->data['BcLineNotifyConfig'][$key] = unserialize($value);
				}
			}

		} else {

			foreach ($this->request->data['BcLineNotifyConfig'] as $key => $value) {
				if (preg_match('/^site_mail_(.*)$/', $key)) {
					$this->request->data['BcLineNotifyConfig'][$key] = serialize($value);
				}
			}
			$this->BcLineNotifyConfig->set($this->request->data);
			if (!$this->BcLineNotifyConfig->validates()) {
				$this->BcMessage->setError(__d('baser', '入力エラーです。内容を修正してください。'));
			} else {
				$this->BcLineNotifyConfig->saveKeyValue($this->request->data);
				clearCache();
				$this->BcMessage->setSuccess(__d('baser', 'オプション設定を保存しました。'));
				$this->redirect('config');
			}

		}

		$sites = $this->Site->find('list', [
			'fields' => [
				'id',
				'display_name',
			],
			'order' => [
				'id' => 'ASC',
			],
		]);
		$sites = array_merge(
			[0 => $this->siteConfigs['main_site_display_name']],
			$sites
		);
		$this->set('sites', $sites);

		$mailContents = $this->Content->find('list', [
			'fields' => [
				'entity_id',
				'title',
				'site_id',
			],
			'conditions' => [
				'plugin' => 'Mail',
				'type' => 'MailContent',
			],
			'order' => [
				'site_id' => 'ASC',
				'entity_id' => 'ASC',
			],
		]);
		$this->set('mailContents', $mailContents);

	}
}
