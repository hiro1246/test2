<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>コンビニ支払い案内</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Hiragino Kaku Gothic ProN", "Yu Gothic", sans-serif;
            background: #f7f9fc;
            color: #1f2937;
        }

        .page {
            width: min(620px, 94vw);
            margin: 48px auto 60px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #5b6472;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9rem;
            margin-bottom: 24px;
        }

        .back-btn:hover {
            opacity: 0.75;
        }

        .card {
            background: #ffffff;
            border: 1px solid #d4deeb;
            border-radius: 16px;
            box-shadow: 0 12px 28px rgba(31, 41, 55, 0.08);
            padding: 32px 28px;
            text-align: center;
        }

        .icon {
            font-size: 2.8rem;
            margin-bottom: 12px;
        }

        h1 {
            font-size: 1.25rem;
            font-weight: 800;
            margin: 0 0 10px;
        }

        .sub {
            color: #5b6472;
            font-size: 0.92rem;
            line-height: 1.7;
            margin: 0 0 28px;
        }

        .voucher-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            background: #0f766e;
            color: #ffffff;
            text-decoration: none;
            font-weight: 800;
            font-size: 0.95rem;
            padding: 13px 28px;
            border-radius: 10px;
            margin-bottom: 16px;
        }

        .voucher-btn:hover {
            opacity: 0.88;
        }

        .note {
            font-size: 0.82rem;
            color: #5b6472;
            margin-top: 20px;
        }

        .product-name {
            font-weight: 700;
            color: #1f2937;
        }
    </style>
</head>

<body>
    <div class="page">
        <a class="back-btn" href="{{ route('products.show', $product) }}">&#8592; 商品ページに戻る</a>

        <div class="card">
            <div class="icon">🏪</div>
            <h1>コンビニ支払いの手続きが完了しました</h1>
            <p class="sub">
                <span class="product-name">{{ $product->name }}</span> のお支払いをお受け付けしました。<br>
                下記のボタンから支払い番号・バーコードを確認し、<br>
                3日以内にコンビニでお支払いください。
            </p>

            @if ($hostedVoucherUrl)
            <a class="voucher-btn" href="{{ $hostedVoucherUrl }}" target="_blank" rel="noopener noreferrer">
                支払い番号・バーコードを確認する ↗
            </a>
            @else
            <p style="color:#b91c1c;font-size:0.9rem;">
                支払い情報の取得に失敗しました。Stripeダッシュボードまたはメールをご確認ください。
            </p>
            @endif

            <p class="note">
                入金確認後に購入が確定されます。<br>
                支払い期限は3日間です。
            </p>
        </div>
    </div>
</body>

</html>