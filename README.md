# Laravel + React ECサイト

Docker環境でLaravelバックエンドとReactフロントエンドを使用したECサイトです。

## 必要な環境

- Docker
- Docker Compose

## プロジェクト構成

```
.
├── backend/          # Laravel API
├── frontend/         # React アプリケーション
├── docker-compose.yml
└── README.md
```

## セットアップ

1. リポジトリをクローン
```bash
git clone <repository-url>
cd taisei
```

2. Dockerコンテナを起動
```bash
docker-compose up -d --build
```

3. Laravelのマイグレーションを実行
```bash
docker-compose exec backend php artisan migrate
```

4. アプリケーションにアクセス
- フロントエンド: http://localhost:3000
- バックエンドAPI: http://localhost:8000
- phpMyAdmin: http://localhost:8080

## 機能

### バックエンド (Laravel)
- 商品管理 (Categories, Products)
- ユーザー認証 (Laravel Sanctum)
- ショッピングカート (Cart Items)
- 注文管理 (Orders, Order Items)
- RESTful API

### フロントエンド (React)
- 商品一覧・詳細表示
- ショッピングカート機能
- ユーザー登録・ログイン
- 注文処理
- レスポンシブデザイン

## データベース構成

### Categories
- id, name, description, image, is_active, timestamps

### Products
- id, name, description, price, stock_quantity, sku, images, category_id, is_active, weight, dimensions, timestamps

### Cart Items
- id, user_id, product_id, quantity, price, timestamps

### Orders
- id, user_id, order_number, total_amount, tax_amount, shipping_amount, status, payment_status, shipping_address, billing_address, notes, timestamps

### Order Items
- id, order_id, product_id, product_name, product_price, quantity, total_price, timestamps

## 開発

### バックエンド開発
```bash
# コンテナに接続
docker-compose exec backend bash

# マイグレーション
php artisan migrate

# シーダー実行
php artisan db:seed

# キャッシュクリア
php artisan cache:clear
```

### フロントエンド開発
```bash
# コンテナに接続
docker-compose exec frontend bash

# 依存関係インストール
npm install

# 開発サーバー起動
npm start
```

## API エンドポイント

- `GET /api/products` - 商品一覧
- `GET /api/products/{id}` - 商品詳細
- `POST /api/cart` - カートに追加
- `GET /api/cart` - カート内容取得
- `POST /api/orders` - 注文作成
- `POST /api/login` - ログイン
- `POST /api/register` - ユーザー登録

## トラブルシューティング

### コンテナが起動しない場合
```bash
docker-compose down
docker-compose up --build
```

### データベース接続エラー
```bash
# MySQLコンテナを確認
docker-compose logs mysql

# 設定ファイルを確認
cat backend/.env
```

## ライセンス

MIT License