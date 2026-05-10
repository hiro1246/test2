<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    <style>
        :root {
            --bg-start: #eff5ff;
            --bg-end: #fff1e6;
            --card-bg: rgba(255, 255, 255, 0.92);
            --text-main: #182235;
            --text-muted: #667085;
            --accent: #f05a28;
            --accent-strong: #c2410c;
            --line: #d9e2f2;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Noto Sans JP", "Hiragino Kaku Gothic ProN", "Yu Gothic", sans-serif;
            color: var(--text-main);
            background: radial-gradient(circle at 18% 18%, #ffffff 0%, transparent 32%),
                linear-gradient(145deg, var(--bg-start), var(--bg-end));
            padding: 24px;
        }

        .brand-link {
            color: var(--text-main);
            font-size: 1.15rem;
            font-weight: 800;
            letter-spacing: 0.14em;
            text-decoration: none;
        }

        .page {
            min-height: calc(100vh - 48px);
            display: grid;
            place-items: center;
        }

        .hero {
            width: min(100%, 720px);
            padding: 32px;
            border: 1px solid var(--line);
            border-radius: 24px;
            background: var(--card-bg);
            box-shadow: 0 24px 60px rgba(24, 34, 53, 0.12);
        }

        .eyebrow {
            margin: 0 0 18px;
        }

        h1 {
            margin: 0;
            font-size: clamp(2rem, 5vw, 3.6rem);
            line-height: 1.08;
        }

        .lead {
            margin: 16px 0 0;
            color: var(--text-muted);
            font-size: 1rem;
            line-height: 1.8;
        }

        .actions {
            margin-top: 28px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .primary-link,
        .secondary-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 170px;
            border-radius: 999px;
            padding: 13px 20px;
            font-weight: 700;
            text-decoration: none;
        }

        .primary-link {
            background: linear-gradient(120deg, var(--accent), var(--accent-strong));
            color: #ffffff;
            box-shadow: 0 16px 28px rgba(240, 90, 40, 0.24);
        }

        .secondary-link {
            border: 1px solid var(--line);
            color: var(--text-main);
            background: #ffffff;
        }

        @media (max-width: 540px) {
            .hero {
                padding: 24px 20px;
            }

            .actions {
                flex-direction: column;
            }

            .primary-link,
            .secondary-link {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <a class="brand-link" href="{{ route('products.index') }}">COACHTECH</a>

    <main class="page">
        <section class="hero">
            <p class="eyebrow">キャリアと学習を前に進めるためのコミュニティ</p>
            <h1>COACHTECHで、次の挑戦を始める。</h1>
            <p class="lead">初めての方は会員登録から開始できます。すでにアカウントをお持ちの場合はログイン画面からサインインしてください。</p>

            <div class="actions">
                <a class="primary-link" href="{{ route('register.show') }}">会員登録へ進む</a>
                <a class="secondary-link" href="{{ route('login.show') }}">ログインする</a>
            </div>
        </section>
    </main>
</body>

</html>