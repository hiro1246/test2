## 環境構築

### 前提条件

- Docker
- Docker Compose

### 初期設定手順

1. **コンテナのビルドと起動**

```sh
docker-compose up -d --build
```

2. **PHPコンテナに入る**

```sh
docker-compose exec php bash
```

3. **Composerの依存関係をインストール**

```sh
composer install
```

4. **.envファイルの設定**

プロジェクトルートにある `.env.example` をコピーして `.env` を作成します：

```sh
cp .env.example .env
```

以下の環境変数を設定してください：

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```

5. **アプリケーションキーの生成**

```sh
php artisan key:generate
```

6. **データベースのマイグレーション**

```sh
php artisan migrate
```

7. **データベースのシーディング**

```sh
php artisan db:seed
```

### 動作確認

- **アプリケーション**: http://localhost
- **phpMyAdmin**: http://localhost:8080
    - ユーザー: `laravel_user`
    - パスワード: `laravel_pass`
- **MailHog**: http://localhost:8025

## meilhog（MailHog）について

この開発環境では、メール送信の確認に MailHog を使用しています。

### できること

- アプリから送信されたメールをブラウザで確認できる
- 実際のメールアドレスへは配信されない（ローカル開発用）

### 確認方法

1. アプリでメール送信処理を実行する（例: 会員登録、確認メール再送など）
2. http://localhost:8025 を開く
3. 受信一覧から対象メールを選択し、件名・本文・ヘッダーを確認する

### Laravel側の設定例

`.env` に以下を設定してください。

```
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

## Stripe決済について

このアプリでは、商品購入時に Stripe Checkout を使った決済を行います。

### 利用できる支払い方法

- カード決済
- コンビニ支払い

### 必要な環境変数

`.env` に以下を設定してください。

```
STRIPE_KEY=
STRIPE_SECRET=
STRIPE_WEBHOOK_SECRET=
```

### 補足

- コンビニ支払いは 120円 から 300,000円 の範囲で利用できます。
- Stripe の Webhook は `/stripe/webhook` で受けています。
- 決済完了後は、支払い方法に応じて購入結果の画面へ遷移します。

### テーブル説明

- **users**: ユーザー情報（出品者・購入者）
- **products**: 商品情報（seller_user_id：出品者、buyer_user_id：購入者）
- **comments**: 商品に対するコメント
- **favorites**: ユーザーのお気に入り商品管理（user_id, product_idの組み合わせはユニーク）


## 商品削除方法

特定の商品を削除したい場合は、以下のエンドポイントにPOSTリクエストを送信してください（要ログイン）。

- エンドポイント: `/products/{id}/delete`
- メソッド: POST

例：curlコマンド
```sh
curl -X POST http://localhost/products/31/delete --cookie "your_session_cookie"
```

BladeやJSからフォームで：
```html
<form method="POST" action="/products/31/delete">
	@csrf
	<button type="submit">削除</button>
</form>
```

これで商品ID 31が削除されます。
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
