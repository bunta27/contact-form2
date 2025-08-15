# お問い合わせフォーム

## 環境構築
1. リポジトリ取得
git clone [<REPOSITORY_URL>](https://github.com/bunta27/contact-form2.git)
cd ~/coachtech/laravel/contact-form2

2. .env 作成
cp .env.example .env

3. .env を docker-compose のサービス名に合わせて調整
#   DB_CONNECTION=mysql
#   DB_HOST=mysql         # 例: docker-compose.yml の MySQL サービス名が mysql の場合
#   DB_PORT=3306
#   DB_DATABASE=laravel_db       # 環境に合わせて
#   DB_USERNAME=laravel_user      # 環境に合わせて
#   DB_PASSWORD=laravel_pass    # 環境に合わせて

4. コンテナ起動（ビルド）
docker-compose up -d --build

5. PHP コンテナに入って依存関係をインストール
docker-compose exec php bash
composer install

6. アプリケーションキーを生成
php artisan key:generate

7. マイグレーション & シーディング
php artisan migrate --seed

MySQL が起動しない場合は OS によって設定が必要になることがあります。各自の PC に合わせて `docker-compose.yml` の設定を調整してください。

## 使用技術（実行環境）
- PHP 8.1.33
- Laravel 8.83.8
- MySQL 8.0.26
- Nginx 1.21.1
- Docker 28.3.0/ Docker Compose v2.38.1

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
