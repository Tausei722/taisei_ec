# API作成タスク.md（アセットマスタ基盤 API）

## 目的
コマ編集画面のアセット選択UI（キャラ/小物/背景/演出/BGM/効果音）が、
ハードコードではなく **APIから taxonomy（分類）・assets（素材）を取得**できるようにする。

対象機能（MVP）:
- 分類（カテゴリ/タグ）の取得（タブ/チップ/ドロップダウン）
- assets一覧取得（分類で絞り込み / 検索）
- 履歴（最近使った / よく使った）
- 急上昇（trending）
- 利用通知（履歴更新 + イベント記録）
- プレミアム素材フラグ（is_premium）を返し、フロントでロック表示に利用できる

---

## 対象テーブル
- `assets`
- `taxonomies`
- `taxonomy_terms`
- `asset_term_map`
- `asset_user_history`
- `asset_events`
- `asset_trending_daily`

---

## 共通仕様

### asset_type（必須指定）
- `character | object | background | effect | bgm | sfx`

### 公開状態（MVP）
- 一覧/検索で返す assets は原則 `status='published'` のみ

### taxonomy の kind とUI表現
- `kind=category`: タブ/単一カテゴリ（例: シリーズ、カテゴリ1）
- `kind=tag`: チップ/複数選択タグ（例: 感情、動作、特徴）
- `ui_hint`: `tab | chip | dropdown` 等（フロント描画の補助情報）

### フィルタ指定（推奨：taxonomy別 filters）
**filters 方式で統一**する（曖昧さを無くすため）。
- `filters[<taxonomy_code>]=<term_code1>,<term_code2>,...`

検索ロジック（重要）:
- **同一taxonomy内は OR**
  - `filters[character_emotion]=cry,laugh` → cry **または** laugh
- **taxonomyが違えば AND**
  - `series=animal` **かつ** `(emotion=cry or laugh)` **かつ** `kind=panda`

> 画像UIの「複数選択」に一致させる。

### sort（任意）
- `default`（sort_order中心）
- `recent`（created_at desc）
- `popular`（履歴の use_count / 直近利用など）
- `trending`（急上昇スコア）

### ページング（任意）
- `page`（1起点）
- `per_page`

---

## キャラクター素材の最小ルール（MVP）
- asset_type=character の素材は、表情差分ごとに **別assets** として扱う。
- assets 検索では以下の taxonomy を前提にフィルタできること：
  - 必須: `filters[character_kind]`（例: panda / rabbit）
  - 必須: `filters[character_emotion]`（例: cry / laugh / angry / trouble）

例：
- パンダ×泣き：
  `GET /assets?asset_type=character&filters[character_kind]=panda&filters[character_emotion]=cry`
- パンダ×(泣き or 笑い)：
  `GET /assets?asset_type=character&filters[character_kind]=panda&filters[character_emotion]=cry,laugh`

---

## API一覧（MVP）

### 1) taxonomy取得（フィルタ定義）
**GET** `/asset/taxonomies`

#### Query
- `asset_type`（必須）

#### Response（例）
```json
{
  "asset_type": "character",
  "taxonomies": [
    {
      "code": "character_series",
      "kind": "category",
      "display_name": "シリーズ",
      "ui_hint": "tab",
      "terms": [
        { "code": "all", "label_ja": "すべて", "sort_order": 10 },
        { "code": "animal", "label_ja": "どうぶつ", "sort_order": 20 }
      ]
    },
    {
      "code": "character_emotion",
      "kind": "tag",
      "display_name": "感情",
      "ui_hint": "chip",
      "terms": [
        { "code": "cry", "label_ja": "泣き", "sort_order": 10 },
        { "code": "laugh", "label_ja": "笑い", "sort_order": 20 }
      ]
    }
  ]
}
```

#### 要件
- `is_active=true` の taxonomies / terms のみ返す
- taxonomyは `sort_order`、termsも `sort_order` でソート
- `asset_type` が不正なら 400

---

### 2) assets検索（一覧 + 絞り込み + 検索）
**GET** `/assets`

#### Query
- `asset_type`（必須）
- `q`（任意）：検索ワード
- `filters[<taxonomy_code>]`（任意）：term_codeをCSVで指定
- `sort`（任意）：default/recent/popular/trending
- `page`（任意）
- `per_page`（任意）
- `premium`（任意）：all/free/premium

#### Response（例）
```json
{
  "page": 1,
  "per_page": 30,
  "total": 1234,
  "items": [
    {
      "id": 101,
      "asset_type": "character",
      "asset_key": "char_panda_cry_01",
      "title": "泣きパンダ",
      "thumbnail_url": "https://...",
      "source_url": "https://...",
      "is_premium": false
    }
  ]
}
```

#### 要件（MVP）
- `assets.status='published'` のみ返す
- 検索 `q` はまず `title` と `keywords` に対する部分一致（ILIKE）で開始
  - 可能なら term.label_ja にも部分一致を含めてよい（任意）
- filters は前述の AND/OR ロジック
- `premium=free` は `is_premium=false` のみ
- `premium=premium` は `is_premium=true` のみ
- sort:
  - default: `sort_order asc, id asc`
  - recent: `created_at desc`
  - popular: `asset_user_history.use_count` 等を基準（MVPは後回しでも可）
  - trending: `asset_trending_daily` 集計を基準（MVPは後回しでも可）

---

### 3) 履歴取得（最近使った / よく使った）
**GET** `/assets/history`

#### Query
- `asset_type`（必須）
- `sort`（任意）：recent / frequent（デフォルト recent）
- `limit`（任意）：デフォルト 30

#### Response（例）
```json
{
  "asset_type": "character",
  "sort": "recent",
  "items": [
    {
      "id": 101,
      "asset_key": "char_panda_cry_01",
      "title": "泣きパンダ",
      "thumbnail_url": "https://...",
      "is_premium": false,
      "last_used_at": "2026-01-20T11:00:00+09:00",
      "use_count": 12
    }
  ]
}
```

#### 要件
- recent: `last_used_at desc`
- frequent: `use_count desc`
- 返すassetsは `published` のみ（MVP）

---

### 4) 利用通知（履歴更新 + イベント記録）
**POST** `/assets/{asset_id}/used`

#### Body（任意）
```json
{ "context": "frame_edit" }
```

#### 処理
- `asset_user_history` をUPSERT
  - `last_used_at = NOW()`
  - `use_count = use_count + 1`
- `asset_events` に insert
  - `event_type = 'use'`
  - `metadata = {context: ...}` 等

#### Response
- 204 No Content（推奨）
- asset_id が存在しない場合 404

---

### 5) 急上昇（ランキング）
**GET** `/assets/trending`

#### Query
- `asset_type`（必須）
- `window`（任意）：`7d | 14d | 30d`（デフォルト 7d）
- `limit`（任意）：デフォルト 30

#### Response（例）
```json
{
  "asset_type": "bgm",
  "window": "7d",
  "items": [
    {
      "id": 501,
      "asset_key": "bgm_chill_01",
      "title": "Chill Beat 01",
      "thumbnail_url": "https://...",
      "score": 123.45
    }
  ]
}
```

#### データソース
- `asset_trending_daily` を window で集計
  - 例：`bucket_date >= current_date - 6`（7日分）

---

## バッチ（運用タスク：急上昇集計）

### 目的
`asset_events`（生ログ）を集計し、`asset_trending_daily` を更新する。
急上昇タブ/ランキング取得を高速化する。

### 実行頻度（案）
- 1日1回（夜間）
- または 3時間おき（要件次第）

### 集計内容（例）
- `view_count`: event_type=view の件数
- `use_count`: event_type=use の件数
- `score`: `view_count * 1 + use_count * 3`（MVPの仮スコア）

---

## 実装優先順位（MVP）
1. `GET /asset/taxonomies`
2. `GET /assets`（filters + q + paging）
3. `POST /assets/{id}/used`
4. `GET /assets/history`
5. `GET /assets/trending`（trending_dailyが無い場合は暫定で events 直集計でも可）

---

## テスト観点（最低限）
- taxonomies が is_active / sort_order を守って返る
- assets検索が filters の AND/OR を満たす
- q検索が title/keywords に効く
- used が履歴をUPSERTできる（use_count増加）
- history が recent/frequent で並ぶ
- trending が window 指定で集計される

---

## 参考（DDL/seed）
- DDL: `yapclip-api/db/001_assets_schema.sql`
- seed（taxonomy/terms）: `yapclip-api/db/010_taxonomy_seed.sql`
- smoke seed（最小 assets）: `yapclip-api/db/020_assets_seed_smoke.sql`
