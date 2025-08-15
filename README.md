# お問い合わせフォーム

## 環境構築

### 前提
- Docker / Docker Compose がインストールされていること

### 手順（Docker のビルド → マイグレーション → シーディングまで）
```bash
# 1. リポジトリ取得
git clone <REPOSITORY_URL>
cd <YOUR_PROJECT_DIR>

# 2. .env 作成
cp .env.example .env

# 3. .env を docker-compose のサービス名に合わせて調整
#   DB_CONNECTION=mysql
#   DB_HOST=mysql         # 例: docker-compose.yml の MySQL サービス名が mysql の場合
#   DB_PORT=3306
#   DB_DATABASE=app       # 環境に合わせて
#   DB_USERNAME=root      # 環境に合わせて
#   DB_PASSWORD=secret    # 環境に合わせて

# 4. コンテナ起動（ビルド）
docker-compose up -d --build

# 5. PHP コンテナに入って依存関係をインストール
docker-compose exec php bash
composer install

# 6. アプリケーションキーを生成
php artisan key:generate

# 7. マイグレーション & シーディング
php artisan migrate --seed

# 8. （必要であれば）開発終了時にコンテナ停止
exit
docker-compose down
```

> **メモ**: MySQL が起動しない場合は OS によって設定が必要になることがあります。各自の PC に合わせて `docker-compose.yml` の設定を調整してください。

## 使用技術（実行環境）
- PHP 8.x
- Laravel 10.x
- MySQL 8.x
- Nginx
- Docker / Docker Compose

## ER 図
> GitHub でレンダリング可能な Mermaid 記法を利用しています。

```mermaid
erDiagram
    CATEGORIES ||--o{ CONTACTS : "1 to many"

    CATEGORIES {
        BIGINT id PK
        VARCHAR name
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    CONTACTS {
        BIGINT id PK
        BIGINT category_id FK
        VARCHAR name
        ENUM gender        // male / female / other
        VARCHAR email
        VARCHAR tel
        VARCHAR address
        VARCHAR building   // nullable
        TEXT detail
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }
```

## URL
- 開発環境: http://localhost/
- phpMyAdmin: http://localhost:8080/

## 命名規約（ER 図評価項目）
- テーブル名: **スネークケース・複数形**（例: `contacts`, `categories`）
- カラム名: **スネークケース**（例: `category_id`, `created_at` など）
- 外部キー: `*_id`（例: `category_id`）
- タイムスタンプ: `created_at`, `updated_at`

> ※ 課題の評価基準に「カラム名も複数形」とある場合は、そちらに合わせてください。ただし、Laravel の一般的な慣習は **カラムは単数形** です（`name`, `email` など）。
