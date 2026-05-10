<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: "Helvetica Neue", Arial, sans-serif;
            color: #1c2432;
            background: #f4f7ff;
            margin: 0;
            padding: 40px 16px;
        }

        .container {
            max-width: 480px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            padding: 36px 32px;
            box-shadow: 0 8px 24px rgba(20, 32, 62, 0.10);
        }

        .brand {
            font-size: 1.1rem;
            font-weight: 800;
            letter-spacing: 0.1em;
            color: #1c2432;
            margin-bottom: 24px;
        }

        h1 {
            font-size: 1.4rem;
            margin: 0 0 12px;
        }

        p {
            font-size: 0.95rem;
            color: #5f6b82;
            line-height: 1.7;
            margin: 0 0 20px;
        }

        .code-box {
            display: block;
            width: fit-content;
            margin: 0 auto 24px;
            padding: 16px 40px;
            background: #f4f7ff;
            border-radius: 12px;
            font-size: 2.2rem;
            font-weight: 800;
            letter-spacing: 0.35em;
            color: #f05a28;
            border: 2px dashed #f05a28;
        }

        .note {
            font-size: 0.82rem;
            color: #9aa3b0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="brand">COACHTECH</div>
        <h1>メールアドレス認証</h1>
        <p>会員登録のご確認のため、以下の認証コードを入力してください。<br>このコードの有効期限は <strong>10分</strong> です。</p>
        <span class="code-box">{{ $code }}</span>
        <p class="note">このメールに心当たりがない場合は、無視していただいて構いません。</p>
    </div>
</body>

</html>