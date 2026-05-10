<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>住所の変更</title>
    <style>
        :root {
            --bg: #f7f9fc;
            --card: #ffffff;
            --line: #d4deeb;
            --text: #1f2937;
            --muted: #5b6472;
            --accent: #0f766e;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Hiragino Kaku Gothic ProN", "Yu Gothic", sans-serif;
            color: var(--text);
            background: radial-gradient(circle at 80% 0%, #e6f4ff 0, var(--bg) 45%);
        }

        .page {
            width: min(760px, 94vw);
            margin: 32px auto;
        }

        .card {
            border: 1px solid var(--line);
            border-radius: 16px;
            background: var(--card);
            box-shadow: 0 12px 28px rgba(31, 41, 55, 0.08);
            padding: 24px;
        }

        .top-header {
            background: #111111;
            border-radius: 12px;
            padding: 10px 14px;
            margin-bottom: 14px;
        }

        .top-header-title {
            margin: 0;
            color: #ffffff;
            font-size: 0.95rem;
            font-weight: 800;
            letter-spacing: 0.04em;
            text-decoration: none;
            display: inline-block;
        }

        h1 {
            margin: 0;
            font-size: 1.4rem;
            font-weight: 800;
            text-align: center;
        }

        .postal-wrap {
            margin-top: 56px;
        }

        .address-wrap {
            margin-top: 28px;
        }

        .building-wrap {
            margin-top: 28px;
        }

        .update-wrap {
            margin-top: 28px;
        }

        .postal-label {
            display: block;
            margin: 0 0 6px;
            text-align: left;
            color: var(--muted);
            font-size: 1rem;
            font-weight: 700;
        }

        .postal-input {
            display: block;
            width: 100%;
            margin: 0;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: #f9fafb;
            color: var(--text);
            padding: 12px 14px;
            font-size: 1.05rem;
            font-family: inherit;
        }

        .postal-input:focus {
            outline: none;
            border-color: var(--accent);
        }

        .lead {
            margin: 10px 0 0;
            color: var(--muted);
            font-size: 0.95rem;
        }

        .item {
            margin-top: 14px;
            padding: 12px;
            border: 1px solid var(--line);
            border-radius: 10px;
            background: #f8fbff;
            font-weight: 700;
        }

        .actions {
            margin-top: 18px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--line);
            border-radius: 10px;
            background: #ffffff;
            color: var(--text);
            text-decoration: none;
            font-size: 0.92rem;
            font-weight: 800;
            padding: 10px 14px;
        }

        .btn.primary {
            border-color: var(--accent);
            background: var(--accent);
            color: #ffffff;
        }

        .update-btn {
            width: 100%;
            cursor: pointer;
        }

        .error-text {
            margin: 8px 0 0;
            color: #d93025;
            font-size: 0.86rem;
            font-weight: 700;
        }
    </style>
</head>

<body>
    <div class="page">
        <header class="top-header" aria-label="ヘッダー">
            <a class="top-header-title" href="{{ route('products.index') }}">COACHTECH</a>
        </header>
        <form method="POST" action="{{ route('products.purchase.destination.update', $product) }}" class="card" aria-label="住所変更画面" novalidate>
            @csrf
            <h1>住所の変更</h1>
            <div class="postal-wrap">
                <label class="postal-label" for="postalCode">郵便番号</label>
                <input class="postal-input" id="postalCode" name="postal_code" type="text" placeholder="〒123-4567" value="{{ old('postal_code', $destination['postal_code']) }}">
                @error('postal_code')
                <p class="error-text">{{ $message }}</p>
                @enderror
            </div>
            <div class="address-wrap">
                <label class="postal-label" for="address">住所</label>
                <input class="postal-input" id="address" name="address" type="text" placeholder="東京都渋谷区..." value="{{ old('address', $destination['address']) }}">
                @error('address')
                <p class="error-text">{{ $message }}</p>
                @enderror
            </div>
            <div class="building-wrap">
                <label class="postal-label" for="building">建物名</label>
                <input class="postal-input" id="building" name="building_name" type="text" placeholder="〇〇マンション 101" value="{{ old('building_name', $destination['building_name']) }}">
                @error('building_name')
                <p class="error-text">{{ $message }}</p>
                @enderror
            </div>
            <div class="update-wrap">
                <button type="submit" class="btn primary update-btn">更新する</button>
            </div>
        </form>
    </div>
</body>

</html>