<?php
/**
 * [BcLineNotify] View
 *
 * @link			http://blog.kaburk.com/
 * @author			kaburk
 * @package			BcLineNotify
 * @license			MIT
 */
?>
<section class="bca-section" data-bca-section-type='form-group'>

<?php echo $this->BcForm->create('BcLineNotifyConfig', ['type' => 'file']) ?>

	<?php echo $this->BcFormTable->dispatchBefore() ?>

	<table id="FormTable" class="form-table bca-form-table">
		<tr>
			<th class="col-head bca-form-table__label">
				<?php echo $this->BcForm->label('BcLineNotifyConfig.acces_token', __d('baser', 'アクセストークン')) ?>
				&nbsp;<span class="required bca-label" data-bca-label-type="required"><?php echo __d('baser', '必須') ?></span>
			</th>
			<td class="col-input bca-form-table__input">
				<?php
					echo $this->BcForm->input(
						'BcLineNotifyConfig.acces_token',
						[
							'type' => 'text',
							'size' => 100,
							'maxlength' => 255,
							'autofocus' => true,
							'class' => 'bca-textbox__input',
						]
					);
				?>
				<?php echo $this->BcForm->error('BcLineNotifyConfig.acces_token') ?>
				<p class="info">
					<ol>
						<li><a href="https://notify-bot.line.me/ja/" target="_blank">LINE Nofity</a> にアクセスして、LINEアカウントでログインしてください。</li>
						<li>ログイン後、画面右上のアカウント名のメニューから「マイページ」を選択します。</li>
						<li>「アクセストークンの発行(開発者向け)」画面にて「トークンを発行する」ボタンをクリックします。</li>
						<li>「トークン名」は、通知時に表示されますのでなにか文字を入力してください。（例：通知 など）</li>
						<li>「1:1でLINE Notifyから通知を受け取る」を選択するか、通知させたい「トークグループ」を選択してください。</li>
						<li>発行されたトークンをコピーして上記の設定欄に貼り付けてください。</li>
					</ol>
					<ul>
						<li>複数人で通知を受信したい場合はトークグループを準備して「LINE Notify」を「友だちの招待」で検索して追加してください。</li>
					</ul>
				</p>
			</td>
<?php
	foreach ($sites as $siteId => $siteName):
		if (isset($mailContents[$siteId])) {
			$mailContentsCount = count($mailContents[$siteId]);
		} else {
			$mailContentsCount = 0;
		}
?>
		<tr>
			<th class="col-head bca-form-table__label">
				<?php echo $this->BcForm->label('BcLineNotifyConfig.mail', __d('baser', '通知対象：')) ?>
				<?php echo $siteName ?>
			</th>
			<td class="col-input bca-form-table__input">
				<?php
					if (isset($mailContents[$siteId])):
						$mailContentIds = [];
						foreach ($mailContents[$siteId] as $mailContentId => $mailName):
							$mailContentIds[$mailContentId] = $mailName;
						endforeach;
						echo $this->BcForm->input(
							'BcLineNotifyConfig.site_mail_' . $siteId,
							[
								'type' => 'select',
								'multiple' => 'checkbox',
								'options' => $mailContentIds,
								'class' => 'bca-checkbox__input',
							]
						);
					endif;
				?>
			</td>
		</tr>
<?php endforeach; ?>

		<?php echo $this->BcForm->dispatchAfterForm('option') ?>
	</table>

	<?php echo $this->BcFormTable->dispatchAfter() ?>

	<section class="bca-actions">
		<div class="bca-actions__main">
			<?php echo $this->BcForm->submit(
				__d('baser', '保存'),
				[
					'id' => 'BtnSave',
					'div' => false,
					'class' => 'button bca-btn bca-actions__item',
					'data-bca-btn-type' => 'save',
					'data-bca-btn-size' => 'lg',
					'data-bca-btn-width' => 'lg',
				]
			) ?>
		</div>
	</section>

<?php echo $this->BcForm->end() ?>

</section>

<script>
$(function(){
});
</script>

<style>
</style>
