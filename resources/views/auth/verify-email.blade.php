<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メール認証</title>
    <style>
        :root {
            --bg-start: #f2f7ff;
            --bg-end: #fff4ec;
            --card-bg: #ffffff;
            --text-main: #1f2a3a;
            --text-muted: #5f6b82;
            --accent: #1d4ed8;
            --accent-strong: #1e40af;
            --line: #dde5f2;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Noto Sans JP", "Hiragino Kaku Gothic ProN", "Yu Gothic", sans-serif;
            color: var(--text-main);
            background: radial-gradient(circle at 85% 18%, #ffffff 0%, transparent 44%),
                linear-gradient(145deg, var(--bg-start), var(--bg-end));
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
            width: min(100%, 520px);
            background: var(--card-bg);
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 30px 24px;
            box-shadow: 0 20px 45px rgba(31, 53, 97, 0.14);
        }

        h1 {
            margin: 0;
            font-size: 1.6rem;
            line-height: 1.25;
        }

        p {
            margin: 12px 0 0;
            color: var(--text-muted);
            line-height: 1.7;
        }

        .status {
            margin-top: 16px;
            padding: 10px 12px;
            border: 1px solid #bfd0ff;
            border-radius: 10px;
            background: #eff4ff;
            color: var(--accent-strong);
            font-weight: 700;
            font-size: 0.9rem;
        }

        form {
            margin-top: 18px;
        }

        .actions {
            margin-top: 18px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        button {
            border: 0;
            border-radius: 999px;
            background: linear-gradient(120deg, var(--accent), var(--accent-strong));
            color: #fff;
            font-weight: 700;
            padding: 11px 18px;
            font-size: 0.95rem;
            cursor: pointer;
        }

        .verify-link {
            display: inline-block;
            border-radius: 999px;
            background: #eef3ff;
            border: 1px solid #bfd0ff;
            color: var(--accent-strong);
            font-weight: 700;
            padding: 10px 18px;
            font-size: 0.95rem;
            text-decoration: none;
        }

        .verify-link:hover {
            background: #e3ecff;
        }
    </style>
</head>

<body>
    <a class="brand-link" href="{{ route('products.index') }}">COACHTECH</a>
    <main class="card">
        <h1>メール認証</h1>
        <p>登録したメールアドレスに確認メールを送信しました。メール内のリンクをクリックして認証を完了してください。</p>

        @if (session('status'))
        <p class="status">{{ session('status') }}</p>
        @endif

        <div class="actions">
            <a class="verify-link" href="http://localhost:8025" target="_blank" rel="noopener noreferrer" aria-label="MailHogを開いて認証メールを確認">認証はこちら</a>

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit">確認メールを再送する</button>
            </form>
        </div>
    </main>
</body>

</html>