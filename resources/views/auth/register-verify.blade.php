<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メールアドレス認証</title>
    <style>
        :root {
            --bg-start: #f4f7ff;
            --bg-end: #ffeede;
            --card-bg: #ffffff;
            --text-main: #1c2432;
            --text-muted: #5f6b82;
            --accent: #f05a28;
            --accent-strong: #cb3f1a;
            --line: #e4e7ef;
            --danger: #b42318;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Noto Sans JP", "Hiragino Kaku Gothic ProN", "Yu Gothic", sans-serif;
            color: var(--text-main);
            background: radial-gradient(circle at 15% 15%, #ffffff 0%, transparent 40%),
                linear-gradient(135deg, var(--bg-start), var(--bg-end));
            display: grid;
            place-items: center;
            padding: 24px;
        }

        .brand-link {
            position: fixed;
            top: 24px;
            left: 24px;
            color: var(--text-main);
            font-size: 1.1rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-decoration: none;
        }

        .card {
            width: min(100%, 460px);
            background: var(--card-bg);
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 30px 24px;
            box-shadow: 0 20px 45px rgba(20, 32, 62, 0.12);
            animation: slide-up 0.45s ease-out;
        }

        h1 {
            margin: 0;
            font-size: 1.7rem;
            line-height: 1.25;
        }

        p.lead {
            margin: 10px 0 24px;
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.7;
        }

        .field {
            margin-bottom: 16px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 700;
            font-size: 0.92rem;
        }

        input[type="text"] {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 12px 13px;
            font-size: 1.6rem;
            letter-spacing: 0.4em;
            text-align: center;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        input[type="text"]:focus {
            border-color: var(--accent);
            outline: none;
            box-shadow: 0 0 0 3px rgba(240, 90, 40, 0.18);
        }

        .error-list {
            margin: 0 0 16px;
            padding: 11px 14px;
            border: 1px solid #fbc8c1;
            border-radius: 10px;
            background: #fff3f1;
            color: var(--danger);
            font-size: 0.92rem;
        }

        .error-list ul {
            margin: 0;
            padding-left: 18px;
        }

        .field-error {
            margin-top: 6px;
            color: var(--danger);
            font-size: 0.85rem;
            font-weight: 600;
        }

        button {
            width: 100%;
            border: 0;
            border-radius: 999px;
            background: linear-gradient(120deg, var(--accent), var(--accent-strong));
            color: #fff;
            font-weight: 700;
            padding: 12px 16px;
            font-size: 1rem;
            cursor: pointer;
            transition: transform 0.15s ease, box-shadow 0.2s ease;
            box-shadow: 0 10px 22px rgba(240, 90, 40, 0.32);
        }

        button:hover {
            transform: translateY(-1px);
        }

        button:active {
            transform: translateY(0);
        }

        .note {
            margin-top: 14px;
            font-size: 0.84rem;
            text-align: center;
            color: var(--text-muted);
        }

        .note a {
            color: var(--accent-strong);
            font-weight: 700;
            text-decoration: none;
        }

        .note a:hover {
            text-decoration: underline;
        }

        @media (max-width: 540px) {
            .card {
                padding: 24px 18px;
                border-radius: 14px;
            }

            h1 {
                font-size: 1.45rem;
            }
        }

        @keyframes slide-up {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <a class="brand-link" href="{{ route('products.index') }}">COACHTECH</a>
    <main class="card">
        <h1>認証コードを入力</h1>
        <p class="lead">
            ご登録のメールアドレスに6桁の認証コードを送信しました。<br>
            コードを入力してアカウントを作成してください。（有効期限：10分）
        </p>

        @if ($errors->any())
        <div class="error-list" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('register.verify.store') }}" novalidate>
            @csrf
            <div class="field">
                <label for="code">認証コード（6桁）</label>
                <input id="code" type="text" name="code" inputmode="numeric" pattern="[0-9]*"
                    maxlength="6" autocomplete="one-time-code" autofocus
                    value="{{ old('code') }}">
                @error('code')
                <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit">認証して登録を完了する</button>
        </form>

        <p class="note"><a href="{{ route('register.show') }}">登録フォームに戻る</a></p>
    </main>
</body>

</html>