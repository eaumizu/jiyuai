# JiyuAI

WordPress を土台にブログと Web アプリを育てるための開発環境です。
WordPress、MariaDB、WP-CLI と、Web アプリを追加するための小さなプラグインを含みます。

## 必要なもの

Docker Engine、Docker Compose v2、Python 3、Bash。
クラウド環境では既存の `/workspace/jiyuai` を使用します。

## セットアップと起動

```sh
bash scripts/setup.sh
bash scripts/start.sh
```

初回は `.env` にランダムな開発用パスワードを生成します。このファイルは Git 管理しません。
既存の `.env` とデータは保持します。イメージはダイジェストで固定しています。
起動スクリプトは WordPress を初期化し、ホーム・ブログ・Web アプリのページを用意します。
初期化は一度だけ行い、以後の投稿やページ編集を保持します。

開発用ポートは 8080、管理画面のパスは `/wp-admin/` です。
管理者名は `jiyuai_admin`、パスワードはローカル `.env` の `WP_ADMIN_PASSWORD` を参照してください。
`admin@example.test` は開発用アドレスです。外部メールの送信設定は含みません。
このクラウド環境のチャットから閲覧するためのプレビュー機能はありません。
本番のホスティング、ドメイン、HTTPS、実際の管理者メールは別途設定します。

## 開発と検証

`wp-content/plugins/jiyuai-app/jiyuai-app.php` が Web アプリの拡張場所です。
`[jiyuai_app]` ショートコードを固定ページに置いて表示します。
現在は案内を表示する土台のみで、具体的なアプリ機能や AI API は未実装です。
ブログ記事と固定ページは WordPress 管理画面から編集できます。

```sh
python3 scripts/smoke.py
# WordPress、PHP、プラグインの確認
 docker compose run --rm -T cli wp core version
 docker compose run --rm -T cli php -l wp-content/plugins/jiyuai-app/jiyuai-app.php
# 停止（データ保持）
 docker compose stop
```

データベース・WordPress 本体・アップロードは Docker の名前付きボリュームに保存します。
GitHub のコードには投稿・アップロード・パスワードを含めません。
ボリュームを削除するとサイトのデータが失われます。運用時はデータベースとアップロードをバックアップしてください。
外部への HTTP 通信が必要なプラグインを追加する場合は、クラウド環境の許可ドメインとプロキシ・CA 設定も確認してください。
