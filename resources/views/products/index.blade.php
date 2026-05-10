<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品一覧</title>
    <style>
        :root {
            --bg-start: #f3f9f4;
            --bg-end: #fff5e8;
            --card-bg: #ffffff;
            --text-main: #1f2937;
            --text-muted: #5b6472;
            --line: #dbe4d7;
            --accent: #0f766e;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Noto Sans JP", "Hiragino Kaku Gothic ProN", "Yu Gothic", sans-serif;
            color: var(--text-main);
            background: radial-gradient(circle at 20% 10%, #ffffff 0%, transparent 34%),
                linear-gradient(140deg, var(--bg-start), var(--bg-end));
            padding: 24px;
        }

        .page {
            width: min(100%, 980px);
            margin: 0 auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            padding: 10px;
            border-radius: 12px;
            background: #000000;
            margin-bottom: 18px;
            flex-wrap: wrap;
        }

        .header-brand {
            font-size: 1.1rem;
            font-weight: 700;
            color: #ffffff;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            padding: 9px 14px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header-search-form {
            flex: 1;
            min-width: 220px;
            max-width: 440px;
            display: flex;
            align-items: center;
        }

        .header-search-input {
            width: 100%;
            border: 1px solid #b5c4b6;
            border-radius: 999px;
            padding: 9px 14px;
            font-size: 0.9rem;
        }

        .header-search-input:focus {
            outline: 2px solid rgba(15, 118, 110, 0.24);
            outline-offset: 1px;
            border-color: var(--accent);
        }

        .header-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--line);
            border-radius: 999px;
            padding: 9px 14px;
            text-decoration: none;
            background: #ffffff;
            color: var(--text-main);
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
        }

        .header-btn-primary {
            background: var(--accent);
            border-color: var(--accent);
            color: #ffffff;
        }

        .header-form {
            margin: 0;
        }

        .status {
            margin: 0 0 18px;
            padding: 12px 14px;
            border: 1px solid #98d7c8;
            border-radius: 10px;
            background: #ebfff8;
            color: #0b5f58;
            font-size: 0.92rem;
            font-weight: 700;
        }

        .image-link-form {
            position: absolute;
            inset: 0;
            z-index: 1;
            margin: 0;
            padding: 0;
        }

        .image-link-btn {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            border: none;
            background: none;
            cursor: pointer;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 18px;
        }

        .card {
            border: 1px solid var(--line);
            border-radius: 16px;
            background: var(--card-bg);
            box-shadow: 0 14px 30px rgba(43, 62, 43, 0.08);
            display: flex;
            flex-direction: column;
        }

        .card-clickable {
            cursor: pointer;
        }

        .card-clickable:focus-visible {
            outline: 3px solid var(--accent);
            outline-offset: 2px;
        }

        .image-wrap {
            aspect-ratio: 4 / 3;
            background: linear-gradient(135deg, #def7ec, #ffe9cc);
            display: grid;
            place-items: center;
            position: relative;
            border-radius: 16px 16px 0 0;
            overflow: hidden;
        }

        .image-buttons {
            position: absolute;
            top: 8px;
            right: 8px;
            display: flex;
            gap: 6px;
            z-index: 100;
            pointer-events: auto;
        }

        .sold-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 2;
            pointer-events: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 12px;
            border-radius: 999px;
            background: rgba(15, 23, 42, 0.88);
            color: #ffffff;
            font-size: 0.78rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .image-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: none;
            background: rgba(255, 255, 255, 0.9);
            color: #436a63;
            font-size: 0.8rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s;
            gap: 4px;
            min-width: 52px;
            padding: 0 8px;
        }

        .image-button:hover {
            background: #ffffff;
        }

        .image-button.liked {
            color: #c62828;
            background: rgba(255, 255, 255, 0.98);
        }

        .like-count {
            font-size: 0.78rem;
            font-weight: 800;
            line-height: 1;
        }

        .fallback {
            font-size: 1rem;
            font-weight: 700;
            color: #436a63;
            text-decoration: none;
        }

        .card-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            pointer-events: none;
        }

        .body {
            padding: 14px;
        }

        .name {
            margin: 0;
            font-size: 1rem;
            font-weight: 700;
            line-height: 1.5;
        }

        .empty {
            border: 1px dashed #aab9a9;
            border-radius: 16px;
            padding: 28px;
            text-align: center;
            color: var(--text-muted);
            background: rgba(255, 255, 255, 0.78);
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 18px;
            flex-wrap: wrap;
        }

        .filter-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--line);
            border-radius: 999px;
            padding: 8px 16px;
            background: #ffffff;
            color: var(--text-main);
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }

        .filter-btn:hover {
            background: var(--accent);
            color: #ffffff;
            border-color: var(--accent);
        }

        .filter-btn.active {
            background: var(--accent);
            color: #ffffff;
            border-color: var(--accent);
        }

        @media (max-width: 640px) {
            .header {
                justify-content: stretch;
            }

            .header-search-form {
                max-width: 100%;
                min-width: 100%;
            }

            .header-btn,
            .header-form {
                width: 100%;
            }

        }
    </style>
</head>

<body>
    <div class="page">
        <header class="header">
            <a class="header-brand" href="{{ route('products.index') }}">COACHTECH</a>
            <form class="header-search-form" action="{{ route('products.index') }}" method="GET">
                @if ($currentFilter === 'mylist')
                <input type="hidden" name="list" value="mylist">
                @endif
                <input
                    class="header-search-input"
                    type="text"
                    name="keyword"
                    value="{{ $searchKeyword }}"
                    placeholder="商品名・ブランド名で検索"
                    aria-label="商品検索">
            </form>
            <div class="header-actions">
                <a class="header-btn" href="{{ route('profile.show') }}">マイページ</a>
                <a class="header-btn header-btn-primary" href="{{ route('products.create') }}">出品</a>
                <form class="header-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="header-btn" type="submit">ログアウト</button>
                </form>
            </div>
        </header>

        @php
        $allFilterQuery = $searchKeyword !== '' ? ['keyword' => $searchKeyword] : [];
        $myListFilterQuery = array_merge(['list' => 'mylist'], $allFilterQuery);
        @endphp
        <div class="filter-buttons">
            <a class="filter-btn {{ $currentFilter === 'all' ? 'active' : '' }}" href="{{ route('products.index', $allFilterQuery) }}">おすすめ</a>
            <a class="filter-btn {{ $currentFilter === 'mylist' ? 'active' : '' }}" href="{{ route('products.index', $myListFilterQuery) }}">マイリスト</a>
        </div>

        @if (session('status'))
        <p class="status">{{ session('status') }}</p>
        @endif

        <section class="grid">
            @if ($products->isEmpty())
            <div class="empty">表示できる商品がまだありません。</div>
            @endif

            @foreach ($products as $product)
            <article
                class="card card-clickable"
                data-href="{{ route('products.show', $product) }}"
                role="link"
                tabindex="0"
                aria-label="{{ $product->name }} の詳細を見る">
                <div class="image-wrap">
                    @if ($product->is_sold)
                    <span class="sold-badge">Sold</span>
                    @endif

                    <div class="image-buttons">
                        @php
                        $isLiked = in_array($product->id, $likedProductIds, true);
                        @endphp
                        <button
                            class="image-button like-button {{ $isLiked ? 'liked' : '' }}"
                            title="いいね"
                            type="button"
                            data-url="{{ route('products.favorites.toggle', $product) }}"
                            data-liked="{{ $isLiked ? '1' : '0' }}">
                            <span class="like-icon">{{ $isLiked ? '♥' : '♡' }}</span>
                            <span class="like-count">{{ $product->favorited_by_users_count ?? 0 }}</span>
                        </button>
                    </div>
                    <form class="image-link-form" action="{{ route('products.show', $product) }}" method="GET">
                        <button class="image-link-btn" type="submit" aria-label="{{ $product->name }} の詳細を見る">
                            @if ($product->image_path)
                            <img class="card-image" src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }} の画像">
                            @else
                            <span class="fallback" aria-hidden="true"></span>
                            @endif
                        </button>
                    </form>
                </div>
                <div class="body">
                    <p class="name">{{ $product->name }}</p>
                </div>
            </article>
            @endforeach
        </section>
    </div>

    <script>
        const searchForm = document.querySelector('.header-search-form');
        const searchInput = document.querySelector('.header-search-input');

        if (searchForm && searchInput) {
            let searchTimer = null;

            searchInput.addEventListener('input', () => {
                if (searchTimer !== null) {
                    clearTimeout(searchTimer);
                }

                searchTimer = window.setTimeout(() => {
                    searchForm.submit();
                }, 400);
            });
        }

        document.querySelectorAll('.card-clickable[data-href]').forEach((card) => {
            const href = card.getAttribute('data-href');
            if (!href) return;

            card.addEventListener('click', (event) => {
                if (event.target.closest('.image-button')) return;
                if (event.target.closest('a')) return;
                window.location.href = href;
            });

            card.addEventListener('keydown', (event) => {
                if (event.key !== 'Enter' && event.key !== ' ') return;
                if (event.target.closest('.image-button')) return;
                event.preventDefault();
                window.location.href = href;
            });
        });

        const csrfToken = '{{ csrf_token() }}';

        document.querySelectorAll('.like-button').forEach((button) => {
            button.addEventListener('click', async (event) => {
                event.preventDefault();
                event.stopPropagation();

                const url = button.dataset.url;
                if (!url || button.disabled) return;

                button.disabled = true;

                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                    });

                    if (!response.ok) {
                        throw new Error('failed');
                    }

                    const data = await response.json();
                    const liked = !!data.liked;
                    const likesCount = Number(data.likes_count ?? 0);

                    button.dataset.liked = liked ? '1' : '0';
                    button.classList.toggle('liked', liked);

                    const icon = button.querySelector('.like-icon');
                    const count = button.querySelector('.like-count');

                    if (icon) {
                        icon.textContent = liked ? '♥' : '♡';
                    }

                    if (count) {
                        count.textContent = String(Number.isNaN(likesCount) ? 0 : likesCount);
                    }
                } catch (error) {
                    alert('いいねの更新に失敗しました。時間をおいて再度お試しください。');
                } finally {
                    button.disabled = false;
                }
            });
        });
    </script>
</body>

</html>