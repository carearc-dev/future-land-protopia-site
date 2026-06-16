# future-land-protopia-site

Future Land / Protopia サイト。

## 開発フロー（このリポジトリの運用ルール）

`main` は本番。**直接編集は禁止・すべての変更はPR経由**（1名以上の承認でマージ）。

1. 最新の `main` を取得（clone / pull）
2. 作業ブランチを切る（例 `feature/contact-form`）
3. Claude Code 等で編集 → commit → push
4. Pull Request を作成
5. 1名以上がレビュー承認 → `main` にマージ
6. マージで GitHub Actions が さくらサーバーへ自動デプロイ

> 各自が自分のGitHubアカウントで操作するため「誰が・いつ・何を」変更/デプロイしたかが履歴に残ります。

## デプロイに必要な GitHub Secrets

Settings → Secrets and variables → Actions に登録（**値はWeb UIから入力。チャットやドキュメントに平文を残さない**）:

| Secret | 用途 |
|---|---|
| `FTP_SERVER` | さくら FTPサーバー名 |
| `FTP_USERNAME` | さくら FTPユーザー名 |
| `FTP_PASSWORD` | さくら FTPパスワード |
| `FTP_SERVER_DIR` | デプロイ先ディレクトリ |
| `CONTACT_TO` | 問い合わせ通知の宛先 |
| `CONTACT_FROM` | 問い合わせ送信元アドレス |
| `CONTACT_FROM_NAME` | 送信元表示名 |

## セキュリティ運用

- 個人FTPでサーバーを直接触らない（誤操作・事故防止）。デプロイはActions経由のみ。
- 組織で2要素認証(2FA)を必須化。
- 端末紛失・退職時：当該アカウントの権限剥奪 ＋ 上記Secretsのローテーション。
