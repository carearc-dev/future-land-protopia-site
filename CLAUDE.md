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

## 画像・動画の軽量化ルール（2026-09 表示の重さ対策で整理）
- 表示に使うのは軽量版：静止画・アニメは **WebP**（表示サイズの約2倍の解像度）、FV動画は `img/fv-pc.mp4`（1280x900）/ `img/fv-sp.mp4`（720x1280）の音声なしH.264 ＋ポスター画像
- 元素材（`*-Anime.gif`, `character0*.png`, `PC-fv.mp4` など）はマスターとして残しているがページからは参照しない。差し替え時も数MBのGIF/動画をそのまま貼らない
- PC用の元動画 `PC-fv.mp4` は左右に黒帯（各192px）が焼き込まれているため、書き出し時にカットする
- FV動画は `<source media>` で画面幅に合う1本だけを読み込む（2本の video を CSS で出し分けると両方ダウンロードされる）

## 運用ルール
- 通常修正はPR経由（main保護・相互レビュー）。緊急修正のみadmin直push可
- コミットメッセージは日本語
