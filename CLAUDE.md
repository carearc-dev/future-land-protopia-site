# future-land-protopia-site — FUTURE LAND PROTOPIA 公式サイト

## 目的
キャラクターブランド「FUTURE LAND PROTOPIA」（エリオット・フラッティ・キャメロン）の公式サイト。
LINEスタンプ・Instagram（@future_land_protopia）への導線を持つ。

- 本番: https://futurelandprotopia.jp/ （さくらインターネット、docroot: ~/www/futurelandprotopia.jp/）
- リポジトリ: carearc-dev/future-land-protopia-site（**public**）

## デプロイ（自動化済み）
- mainへのpushで GitHub Actions がさくらへ **SFTP自動デプロイ**（.github/workflows/deploy.yml、SSH鍵方式）
- 編集は必ずこのリポジトリのクローンで行う（過去に古い静的コピーで編集しかけた事故あり。作業前に git pull）

## 問い合わせフォーム
- index.php 冒頭のPHPが送信処理。宛先はサーバー側の `config.php` を読む（雛形: config.php.example）
- **config.phpはリポジトリに含めない**（publicリポのため個人アドレスを晒さない）。config.php未設置時は mail@daikanyama-hb.com にフォールバック
- サーバーへのconfig.php設置は手動（SFTP）。設置状況 2026-07-07時点: 未設置（フォールバック動作）

## 一時非表示中の要素（再開時にdisplay:noneを外す）
- LINEスタンプDLボタン（配布開始時にhrefも設定）
- Goods（EC）セクション・ナビItem

## 未対応メモ
- フッターの Threads / TikTok アイコンは表示復旧済みだが **リンク先が href="#" のまま**（実アカウントURLが決まったら設定）

## 運用ルール
- 通常修正はPR経由（main保護・相互レビュー）。緊急修正のみadmin直push可
- コミットメッセージは日本語
