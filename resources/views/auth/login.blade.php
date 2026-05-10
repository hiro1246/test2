<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    <style>
        :root {
            --bg-start: #edf8f6;
            --bg-end: #fef6e9;
            --card-bg: #ffffff;
            --text-main: #1d2a2a;
            --text-muted: #5f6d6d;
            --accent: #0d9488;
            --accent-strong: #0f766e;
            --line: #d9e4e4;
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
            background: radial-gradient(circle at 82% 18%, #ffffff 0%, transparent 42%),
                linear-gradient(140deg, var(--bg-start), var(--bg-end));
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
            width: min(100%, 440px);
            background: var(--card-bg);
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 30px 24px;
            box-shadow: 0 20px 45px rgba(12, 67, 65, 0.14);
            animation: rise 0.4s ease-out;
        }

        h1 {
            margin: 0;
            font-size: 1.7rem;
            line-height: 1.2;
        }

        .lead {
            margin: 10px 0 22px;
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .field {
            margin-bottom: 14px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 700;
            font-size: 0.92rem;
        }

        input {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 12px 13px;
            font-size: 0.98rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        input:focus {
            border-color: var(--accent);
            outline: none;
            box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.2);
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
            box-shadow: 0 10px 24px rgba(13, 148, 136, 0.25);
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

        @keyframes rise {
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
        <h1>ログイン</h1>
        <p class="lead">登録済みのアカウントでサインインしてください。</p>

        @if ($errors->any())
        <div class="error-list" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}" novalidate>
            @csrf

            <div class="field">
                <label for="email">メールアドレス</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label for="password">パスワード</label>
                <input id="password" type="password" name="password" required>
                @error('password')
                <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit">ログインする</button>
        </form>

        <p class="note"><a href="{{ route('register.show') }}">会員登録はこちら</a></p>
    </main>
</body>

</html>
