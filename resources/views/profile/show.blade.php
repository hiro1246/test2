<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->name }}</title>
    <style>
        :root {
            --bg-start: #eef6ff;
            --bg-end: #fff6ec;
            --card-bg: #ffffff;
            --text-main: #1a2433;
            --text-muted: #5f6b82;
            --accent: #2563eb;
            --line: #dfe5f2;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Noto Sans JP", "Hiragino Kaku Gothic ProN", "Yu Gothic", sans-serif;
            color: var(--text-main);
            background: radial-gradient(circle at 80% 20%, #ffffff 0%, transparent 45%), linear-gradient(145deg, var(--bg-start), var(--bg-end));
            padding: 0;
            display: flex;
            flex-direction: column;
        }

        header {
            background: #000000;
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .header-logo {
            color: #ffffff;
            font-size: 1.4rem;
            font-weight: 700;
            text-decoration: none;
            letter-spacing: 1px;
        }

        .header-nav {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-nav a,
        .header-nav form {
            display: inline-block;
        }

        .header-nav button {
            background: none;
            border: none;
            color: #ffffff;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            padding: 8px 12px;
            text-decoration: none;
            font-family: inherit;
        }

        .header-nav a {
            color: #ffffff;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            padding: 8px 12px;
        }

        .header-nav a:hover,
        .header-nav button:hover {
            opacity: 0.8;
        }

        .header-nav .btn-post {
            background: #2563eb;
            border-radius: 999px;
            padding: 8px 20px;
            color: #ffffff;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .header-nav .btn-post:hover {
            background: #1d4ed8;
            opacity: 1;
        }

        .page {
            width: 100%;
            margin: 0 auto;
            padding: 24px;
            flex: 1;
        }

        .card {
            width: 100%;
            background: var(--card-bg);
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 28px 24px;
            box-shadow: 0 20px 46px rgba(32, 50, 88, 0.12);
        }

        .profile-heading {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 0 0 16px;
            justify-content: space-between;
        }

        .heading-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--accent);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            font-weight: 700;
            flex-shrink: 0;
            overflow: hidden;
        }

        .avatar-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        h1 {
            margin: 0;
            font-size: 1.7rem;
        }

        .status {
            margin: 0 0 16px;
            padding: 12px 14px;
            border: 1px solid #bfd4ff;
            border-radius: 10px;
            background: #eff5ff;
            color: var(--accent);
            font-size: 0.92rem;
            font-weight: 700;
        }

        dl {
            margin: 0;
            display: grid;
            gap: 10px;
        }

        dt {
            font-weight: 700;
            color: var(--text-muted);
        }

        dd {
            margin: 0;
            padding: 8px 10px;
            border-radius: 10px;
            background: #f8fbff;
        }

        .section {
            margin-top: 22px;
        }

        .section-title {
            margin: 0 0 10px;
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-muted);
        }

        .product-list {
            display: grid;
            gap: 10px;
        }

        .product-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            border: 1px solid var(--line);
            border-radius: 10px;
            text-decoration: none;
            color: inherit;
            background: #ffffff;
        }

        .product-item:hover {
            background: #f8fbff;
        }

        .product-thumb {
            width: 52px;
            height: 52px;
            border-radius: 8px;
            overflow: hidden;
            flex-shrink: 0;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.78rem;
            color: var(--text-muted);
            border: 1px solid var(--line);
        }

        .product-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-meta {
            min-width: 0;
            display: grid;
            gap: 4px;
        }

        .product-name {
            font-size: 0.95rem;
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .product-price {
            font-size: 0.86rem;
            color: var(--text-muted);
        }

        .empty-note {
            margin: 0;
            padding: 12px;
            border-radius: 10px;
            background: #f8fbff;
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .listed-gallery {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .listed-card {
            display: block;
            border: 1px solid var(--line);
            border-radius: 12px;
            background: #ffffff;
            overflow: hidden;
            text-decoration: none;
            color: inherit;
        }

        .listed-card:hover {
            box-shadow: 0 10px 24px rgba(32, 50, 88, 0.14);
        }

        .listed-image-wrap {
            width: 100%;
            aspect-ratio: 1 / 1;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .listed-image-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .listed-caption {
            padding: 8px 10px 10px;
            font-size: 0.82rem;
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .actions {
            margin-top: 20px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            border: 1px solid #cbd6ee;
            border-radius: 999px;
            padding: 10px 16px;
            background: #ffffff;
            color: var(--text-main);
            font-size: 0.95rem;
            font-weight: 700;
            text-decoration: none;
        }

        .product-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 16px;
            border-bottom: 2px solid var(--line);
        }

        .product-tab {
            padding: 10px 16px;
            border: none;
            background: transparent;
            color: var(--text-muted);
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
        }

        .product-tab:hover {
            color: var(--text-main);
        }

        .product-tab.active {
            color: var(--accent);
            border-bottom-color: var(--accent);
        }

        .product-gallery-section {
            display: none;
        }

        .product-gallery-section.active {
            display: block;
        }
    </style>
</head>

<body>
    <header>
        <a href="{{ route('products.index') }}" class="header-logo">COACHTECH</a>
        <nav class="header-nav">
            <a href="{{ route('profile.show') }}">マイページ</a>
            <a href="{{ route('products.create') }}" class="btn-post">出品</a>
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit">ログアウト</button>
            </form>
        </nav>
    </header>
    <div class="page">
        <main class="card">
            <div class="profile-heading">
                <div class="heading-left">
                    <div class="avatar-icon">
                        @if ($user->profile_image_path)
                        <img src="{{ asset('storage/' . $user->profile_image_path) }}" alt="{{ $user->name }}">
                        @else
                        {{ mb_substr($user->name, 0, 1) }}
                        @endif
                    </div>
                    <h1>{{ $user->name }}</h1>
                </div>
                <a class="btn" href="{{ route('profile.setup') }}">プロフィールを編集</a>
            </div>

            @if (session('status'))
            <p class="status">{{ session('status') }}</p>
            @endif

            @php
            $hasListedProducts = $listedProducts->isNotEmpty();
            $hasPurchasedProducts = $purchasedProducts->isNotEmpty();
            @endphp

            <div class="product-tabs">
                <button class="product-tab active" data-tab="listed">出品した商品</button>
                <button class="product-tab" data-tab="purchased">購入した商品</button>
            </div>

            <section class="product-gallery-section active" id="listed-section" aria-label="出品した商品">

                <div class="listed-gallery">
                    @forelse ($listedProducts as $product)
                    <a class="listed-card" href="{{ route('products.show', $product) }}" aria-label="{{ $product->name }}">
                        <div class="listed-image-wrap">
                            @php
                            $listedImageSrc = null;
                            if ($product->image_path) {
                            $listedImageSrc = \Illuminate\Support\Str::startsWith($product->image_path, ['http://', 'https://', '/'])
                            ? $product->image_path
                            : (\Illuminate\Support\Str::startsWith($product->image_path, 'storage/')
                            ? asset($product->image_path)
                            : asset('storage/' . $product->image_path));
                            }
                            @endphp
                            @if ($listedImageSrc)
                            <img src="{{ $listedImageSrc }}" alt="{{ $product->name }}">
                            @endif
                        </div>
                        <div class="listed-caption">{{ $product->name }}</div>
                    </a>
                    @empty
                    <p class="empty-note">出品した商品はありません</p>
                    @endforelse
                </div>
            </section>

            <section class="product-gallery-section" id="purchased-section" aria-label="購入した商品">
                <div class="product-list">
                    @forelse ($purchasedProducts as $product)
                    <a class="product-item" href="{{ route('products.show', $product) }}">
                        <div class="product-thumb">
                            @php
                            $purchasedImageSrc = null;
                            if ($product->image_path) {
                            $purchasedImageSrc = \Illuminate\Support\Str::startsWith($product->image_path, ['http://', 'https://', '/'])
                            ? $product->image_path
                            : (\Illuminate\Support\Str::startsWith($product->image_path, 'storage/')
                            ? asset($product->image_path)
                            : asset('storage/' . $product->image_path));
                            }
                            @endphp
                            @if ($purchasedImageSrc)
                            <img src="{{ $purchasedImageSrc }}" alt="{{ $product->name }}">
                            @else
                            画像なし
                            @endif
                        </div>
                        <div class="product-meta">
                            <div class="product-name">{{ $product->name }}</div>
                            <div class="product-price">¥{{ number_format((int) ($product->price ?? 0)) }}</div>
                        </div>
                    </a>
                    @empty
                    <p class="empty-note">購入した商品はありません</p>
                    @endforelse
                </div>
            </section>


        </main>
    </div>

    <script>
        document.querySelectorAll('.product-tab').forEach((tab) => {
            tab.addEventListener('click', () => {
                const tabName = tab.dataset.tab;

                document.querySelectorAll('.product-tab').forEach((t) => {
                    t.classList.remove('active');
                });

                document.querySelectorAll('.product-gallery-section').forEach((section) => {
                    section.classList.remove('active');
                });

                tab.classList.add('active');
                document.getElementById(tabName + '-section').classList.add('active');
            });
        });
    </script>
</body>

</html>