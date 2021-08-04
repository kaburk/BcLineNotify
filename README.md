# BcLineNotify（LINE通知プラグイン）

お問い合わせがあった時に LINE Notify を使って通知することができるbaserCMS4系のプラグインです。

## Installation

1. 圧縮ファイルを解凍後、BASERCMS/app/Plugin/BcLineNotify に配置します。
2. 管理システムのプラグイン管理に入って、表示されている BcLineNotify プラグイン を有効化して下さい。
3. 設定画面( /admin/bc_line_notify/bc_line_notifies/config ) にて アクセストークン、通知するメールフォームを設定してください。
4. お問合せフォームでお問い合わせがあると、LINEに通知が届くようになります。

## Caution

1時間にAPIをcallできる回数の上限が1000回（デフォルト）とのことです。
https://notify-bot.line.me/doc/ja/


## TODO

* フォーム毎にテンプレートを指定できるようにする。（現在はメール本文と同じテンプレートを利用）
* フォーム毎にアクセストークンを指定できるようにして、フォーム毎に通知先を変更できるようにする。

## Thanks

- [http://basercms.net/](http://basercms.net/)
- [http://wiki.basercms.net/](http://wiki.basercms.net/)
- [http://cakephp.jp](http://cakephp.jp)
- [Semantic Versioning 2.0.0](http://semver.org/lang/ja/)
