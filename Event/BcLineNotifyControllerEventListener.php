<?php
/**
 * [BcLineNotify] ControllerEventListener
 *
 * @link			http://blog.kaburk.com/
 * @author			kaburk
 * @package			BcLineNotify
 * @license			MIT
 */
class BcLineNotifyControllerEventListener extends BcControllerEventListener {

	public $events = [
		'Mail.Mail.afterSendEmail',
	];

	public function __construct(){

	}

	/**
	 * mailMailAfterSendEmail
	 *
	 * @param CakeEvent $event
	 * @return boolean
	 */
	public function mailMailAfterSendEmail(CakeEvent $event) {

		$this->setupModel();

		$Controller = $event->subject();
		$config = $this->BcLineNotifyConfighModel->findExpanded();

		$siteId = $Controller->request->params['Content']['site_id'];
		$entityId = $Controller->request->params['Content']['entity_id'];

		$setting = [];
		if ($config['site_mail_' . $siteId]) {
			$setting = unserialize($config['site_mail_' . $siteId]);
		}

		if (!in_array($entityId, $setting)) {
			return true;
		}

		// データを整形
		$this->MailMessageModel->setup($entityId);
		$data = $this->MailMessageModel->convertToDb($Controller->request->data);
		$data['message'] = $data['MailMessage'];
		unset($data['MailMessage']);
		$data['content'] = $Controller->request->params['Content'];
		$data['mailFields'] = $this->MailMessageModel->mailFields;
		$data['mailContents'] = $this->MailMessageModel->mailContent;
		$data['mailConfig'] = $this->MailConfigModel->find();
		$data['other']['date'] = date('Y/m/d H:i');
		$data['other']['mode'] = 'admin'; // 管理者宛メールを通知
		$data = $this->MailMessageModel->convertDatasToMail($data);

		// メール本文用変数準備
		App::uses('BcBaserHelper', 'View/Helper');
		App::uses('BcAppView', 'View');
		$bcBaserhelper = new BcBaserHelper(new BcAppView($Controller));
		$bcBaserhelper->_View->set('message', $data['message']);
		$bcBaserhelper->_View->set('content', $data['content']);
		$bcBaserhelper->_View->set('mailFields', $data['mailFields']);
		$bcBaserhelper->_View->set('mailContents', $data['mailContents']['MailContent']);
		$bcBaserhelper->_View->set('mailConfig', $data['mailConfig']['MailConfig']);
		$bcBaserhelper->_View->set('other', $data['other']);

		// メール本文の組み立て
		$template = '..' . DS . 'Emails' . DS . 'text'. DS . $data['mailContents']['MailContent']['mail_template'];
		$body = $bcBaserhelper->getElement($template);

		// LINEに通知
		$this->sendLineMessage($config['acces_token'], $body);

		$this->log([$siteId, $entityId, $body], LOG_DEBUG);

		return true;
	}

	/**
	 * モデルを準備する
	 */
	private function setupModel() {

		if (ClassRegistry::isKeySet('BcLineNotify.BcLineNotifyConfig')) {
			$this->BcLineNotifyConfighModel = ClassRegistry::getObject('BcLineNotify.BcLineNotifyConfig');
		} else {
			$this->BcLineNotifyConfighModel = ClassRegistry::init('BcLineNotify.BcLineNotifyConfig');
		}

		if (ClassRegistry::isKeySet('Mail.MailMessage')) {
			$this->MailMessageModel = ClassRegistry::getObject('BcLineNotify.MailMessage');
		} else {
			$this->MailMessageModel = ClassRegistry::init('Mail.MailMessage');
		}

		if (ClassRegistry::isKeySet('Mail.MailConfig')) {
			$this->MailConfigModel = ClassRegistry::getObject('Mail.MailConfig');
		} else {
			$this->MailConfigModel = ClassRegistry::init('Mail.MailConfig');
		}
	}

	/**
	 * Line Nofity へ メッセージを送信する
	 */
	private function sendLineMessage($token, $message) {

		$data = [
			"message" => $message
		];

		$data = http_build_query($data, "", "&");
		$options = [
			'http' => [
				'method'=>'POST',
				'header'=>"Authorization: Bearer " . $token . "\r\n"
						. "Content-Type: application/x-www-form-urlencoded\r\n"
						. "Content-Length: " . strlen($data) . "\r\n" ,
				'content' => $data
			],
		];
		$context = stream_context_create($options);
		$resultJson = file_get_contents(LINE_API_URL, false, $context);
		$resutlArray = json_decode($resultJson, true);

		if($resutlArray['status'] != 200)  {
			return false;
		}
		return true;

	}
}
