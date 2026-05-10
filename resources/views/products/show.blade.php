<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品詳細</title>
    <style>
        :root {
            --bg: #f6f9f4;
            --card: #ffffff;
            --line: #dce8d8;
            --text: #2b3e2b;
            --muted: #5f7460;
            --accent: #7e5bef;
            --sold: #0f172a;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Hiragino Kaku Gothic ProN", "Yu Gothic", sans-serif;
            background: radial-gradient(circle at 20% 0%, #eaf6df 0, var(--bg) 45%);
            color: var(--text);
        }

        .page {
            width: min(960px, 92vw);
            margin: 28px auto 40px;
        }

        .top-header {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
            padding: 10px 12px;
            border-radius: 12px;
            background: #111111;
            margin-bottom: 12px;
            flex-wrap: wrap;
        }

        .header-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 12px;
            border-radius: 999px;
            border: 1px solid var(--line);
            background: #ffffff;
            color: var(--text);
            text-decoration: none;
            font-size: 0.82rem;
            font-weight: 700;
            line-height: 1;
        }

        .header-btn:hover {
            opacity: 0.88;
        }

        .header-btn.primary {
            background: var(--accent);
            border-color: var(--accent);
            color: #ffffff;
        }

        .header-brand {
            margin-right: auto;
            color: #ffffff;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 800;
            letter-spacing: 0.04em;
        }

        .header-brand:hover {
            opacity: 0.85;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--muted);
            text-decoration: none;
            font-weight: 700;
            margin-bottom: 16px;
        }

        .back-link:hover {
            color: var(--text);
        }

        .card {
            border: 1px solid var(--line);
            border-radius: 18px;
            background: var(--card);
            box-shadow: 0 18px 40px rgba(43, 62, 43, 0.08);
            overflow: hidden;
            padding: 18px;
        }

        .card-main {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
        }

        .image-wrap {
            aspect-ratio: 4 / 3;
            background: linear-gradient(135deg, #def7ec, #ffe9cc);
            display: grid;
            place-items: center;
            position: relative;
            width: min(340px, 100%);
            margin: 0;
            border-radius: 14px;
            overflow: hidden;
            flex: 1 1 auto;
            box-shadow: 0 2px 0 var(--line);
        }

        .sold-badge {
            position: absolute;
            top: 14px;
            left: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 12px;
            border-radius: 999px;
            background: rgba(15, 23, 42, 0.9);
            color: #ffffff;
            font-size: 0.78rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .fallback {
            font-size: 1.2rem;
            font-weight: 700;
            color: #436a63;
        }

        .body {
            width: min(280px, 100%);
            margin-left: auto;
            padding: 0;
        }

        .title {
            margin: 0;
            font-size: clamp(1.2rem, 2vw, 1.6rem);
            font-weight: 800;
        }

        .brand-note {
            margin: 6px 0 0;
            font-size: 0.82rem;
            color: var(--muted);
            font-weight: 600;
        }

        .price-note {
            margin: 6px 0 0;
            font-size: 1.05rem;
            color: var(--text);
            font-weight: 800;
        }

        .social-row {
            margin: 8px 0 0;
            display: inline-flex;
            align-items: center;
            gap: 14px;
        }

        .social-btn {
            border: 1px solid var(--line);
            border-radius: 999px;
            background: #ffffff;
            color: var(--text);
            font-size: 0.92rem;
            line-height: 1;
            padding: 6px 12px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-weight: 700;
        }

        .social-icon {
            width: 14px;
            height: 14px;
            display: inline-block;
            color: var(--muted);
        }

        .social-icon svg {
            width: 100%;
            height: 100%;
            display: block;
        }

        .social-count {
            min-width: 1ch;
        }

        .meta {
            margin: 10px 0 0;
            color: var(--muted);
            font-size: 0.95rem;
        }

        .status {
            margin-top: 12px;
            display: inline-flex;
            align-items: center;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 0.82rem;
            font-weight: 700;
            background: #e8f4e7;
            color: #24523a;
        }

        .status.sold {
            background: #e2e8f0;
            color: var(--sold);
        }

        .actions {
            margin-top: 12px;
        }

        .purchase-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            border: 1px solid var(--accent);
            border-radius: 10px;
            background: var(--accent);
            color: #ffffff;
            text-decoration: none;
            font-size: 0.98rem;
            font-weight: 800;
            padding: 6px 14px;
            transition: opacity 0.2s;
        }

        .purchase-btn:hover {
            opacity: 0.9;
        }

        .purchase-btn.disabled {
            border-color: #94a3b8;
            background: #94a3b8;
            pointer-events: none;
            cursor: not-allowed;
        }

        .description {
            margin-top: 14px;
            padding-top: 12px;
            border-top: 1px solid var(--line);
        }

        .description-title {
            margin: 0;
            font-size: 1.05rem;
            color: var(--muted);
            font-weight: 700;
        }

        .description-text {
            margin: 6px 0 0;
            font-size: 0.82rem;
            line-height: 1.7;
            color: var(--muted);
            white-space: pre-line;
        }

        .product-info {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text);
        }

        .category-row {
            margin: 6px 0 0;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .category-chip {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 4px 14px;
            border: 1px solid #95a89a;
            border-radius: 999px;
            background: #ffffff;
            color: #3f5640;
            font-size: 0.8rem;
            line-height: 1;
            font-weight: 700;
        }

        .category-label {
            margin: 0;
        }

        .comment-count {
            margin-top: 14px;
            font-size: 1rem;
            font-weight: 700;
            color: var(--text);
        }

        .comment-user-row {
            margin: 6px 0 12px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .comment-user-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 999px;
            border: 1px solid #d1d5db;
            background: #f3f4f6;
            color: #9ca3af;
        }

        .comment-user-icon svg {
            width: 18px;
            height: 18px;
        }

        .comment-form {
            margin-top: 10px;
        }

        .comment-input {
            width: 100%;
            height: 32px;
            min-height: 32px;
            resize: none;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            background: #f3f4f6;
            color: var(--text);
            font-size: 0.9rem;
            line-height: 1.3;
            padding: 5px 10px;
            font-family: inherit;
        }

        .comment-input:focus {
            outline: none;
            border-color: #9bb59d;
            box-shadow: 0 0 0 3px rgba(155, 181, 157, 0.18);
        }

        .comment-input-large {
            height: 72px;
            min-height: 72px;
            padding: 10px 12px;
        }

        .comment-heading {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text);
        }

        .comment-submit {
            margin-top: 8px;
        }

        .comment-submit-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 280px;
            border: 1px solid #7e5bef;
            border-radius: 8px;
            background: #7e5bef;
            color: #ffffff;
            font-size: 0.84rem;
            font-weight: 700;
            padding: 6px 12px;
            cursor: pointer;
        }

        .comment-submit-btn:hover {
            opacity: 0.9;
        }

        @media (max-width: 760px) {
            .card-main {
                flex-direction: column;
            }

            .image-wrap {
                width: 100%;
            }

            .body {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="page">
        <header class="top-header" aria-label="ヘッダー操作">
            <a class="header-brand" href="{{ route('products.index') }}">COACHTECH</a>
            <a class="header-btn" href="#">ログアウト</a>
            <a class="header-btn" href="#">マイページ</a>
            <a class="header-btn primary" href="{{ route('products.create') }}">出品</a>
        </header>

        <article class="card" aria-label="商品詳細">
            <div class="card-main">
                <div class="image-wrap">
                    @if ($product->is_sold)
                    <span class="sold-badge">Sold</span>
                    @endif

                    @if ($product->image_path)
                    <img class="image" src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }} の画像">
                    @else
                    <div class="fallback" aria-hidden="true">商品画像</div>
                    @endif
                </div>

                <div class="body">
                    <h1 class="title">{{ $product->name }}</h1>
                    @if ($product->brand)
                    <p class="brand-note">{{ $product->brand }}</p>
                    @endif
                    @if ($product->price !== null)
                    <p class="price-note">¥{{ number_format($product->price) }}（税込）</p>
                    @endif
                    <div class="social-row" aria-label="お気に入りとコメント">
                        <button type="button" class="social-btn" aria-label="いいね数" data-like-button>
                            <span class="social-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 9V5a3 3 0 0 0-3-3L7 11v10h11.28a2 2 0 0 0 1.97-1.66l1.38-8A2 2 0 0 0 19.66 9H14z"></path>
                                    <path d="M7 11H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h3"></path>
                                </svg>
                            </span>
                            <span class="social-count" data-like-count>{{ $product->likes_count ?? 0 }}</span>
                        </button>
                        <button type="button" class="social-btn" aria-label="コメント数">
                            <span class="social-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                </svg>
                            </span>
                            <span class="social-count">{{ $product->comments_count ?? 0 }}</span>
                        </button>
                    </div>
                    <div class="actions">
                        @if (
                        $product->is_sold
                        || (auth()->check() && $product->seller_user_id !== null && (int) $product->seller_user_id === (int) auth()->id())
                        )
                        <span class="purchase-btn disabled" aria-disabled="true">購入手続きへ</span>
                        @else
                        <a class="purchase-btn" href="{{ route('products.purchase', $product) }}">購入手続きへ</a>
                        @endif
                    </div>
                    <section class="description" aria-label="商品説明">
                        <h2 class="description-title">商品説明</h2>
                        @if ($product->description)
                        <p class="description-text">{{ $product->description }}</p>
                        @endif
                        <p class="description-text product-info">商品の情報</p>
                        @if ($product->category)
                        <div class="category-row" aria-label="カテゴリー">
                            <span class="description-text category-label">カテゴリー</span>
                            <span class="category-chip">{{ $product->category }}</span>
                        </div>
                        @endif
                        @if ($product->condition)
                        @php
                        $conditionLabels = [
                        'good' => '良好',
                        'no_visible_damage' => '目立った傷や汚れなし',
                        'some_damage' => 'やや傷や汚れあり',
                        'poor' => '状態が悪い',
                        ];
                        @endphp
                        <div class="category-row" aria-label="商品の状態">
                            <span class="description-text category-label">商品の状態</span>
                            <span class="category-chip">{{ $conditionLabels[$product->condition] ?? $product->condition }}</span>
                        </div>
                        @endif
                        <p class="description-text comment-count">コメント({{ $product->comments_count ?? 0 }})</p>

                        @foreach ($product->comments ?? [] as $comment)
                        <div class="comment-user-row">
                            <span class="comment-user-icon" aria-label="コメントしたユーザー">
                                @if ($comment->user && $comment->user->profile_image_path)
                                <img src="{{ asset('storage/' . $comment->user->profile_image_path) }}" alt="" style="width:32px;height:32px;border-radius:999px;object-fit:cover;">
                                @else
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <circle cx="12" cy="8" r="4" />
                                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                                </svg>
                                @endif
                            </span>
                            <span class="description-text category-label">{{ $comment->user->name ?? '不明なユーザー' }}</span>
                        </div>
                        <textarea class="comment-input" readonly>{{ $comment->comment }}</textarea>
                        @endforeach

                        <p class="description-text comment-heading">商品へのコメント</p>
                        <div class="comment-form" aria-label="コメント欄">
                            <form method="POST" action="{{ route('products.comments.store', $product) }}" novalidate>
                                @csrf
                                <textarea class="comment-input comment-input-large" name="comment">{{ old('comment') }}</textarea>
                                @error('comment')
                                <p class="description-text" style="color: #d93025; margin-top: 8px;">{{ $message }}</p>
                                @enderror
                                @if (session('comment_status'))
                                <p class="description-text" style="color: #2e7d32; margin-top: 8px;">{{ session('comment_status') }}</p>
                                @endif
                                <div class="comment-submit">
                                    <button type="submit" class="comment-submit-btn">コメントを送信する</button>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </article>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var likeButton = document.querySelector('[data-like-button]');
            var likeCount = document.querySelector('[data-like-count]');
            var liked = false;

            if (!likeButton || !likeCount) {
                return;
            }

            likeButton.addEventListener('click', function() {
                var current = parseInt(likeCount.textContent, 10);
                var safeCurrent = Number.isNaN(current) ? 0 : current;

                if (liked) {
                    likeCount.textContent = String(Math.max(0, safeCurrent - 1));
                    liked = false;
                } else {
                    likeCount.textContent = String(safeCurrent + 1);
                    liked = true;
                }
            });
        });
    </script>
</body>

</html>