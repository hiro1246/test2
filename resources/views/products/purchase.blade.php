<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>購入手続き</title>
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
            width: min(980px, 94vw);
            margin: 28px auto 40px;
        }

        .top-header {
            display: flex;
            align-items: center;
            min-height: 48px;
            padding: 10px 14px;
            border-radius: 12px;
            background: #111111;
            margin-bottom: 14px;
        }

        .top-header-title {
            margin: 0;
            color: #ffffff;
            font-size: 0.95rem;
            font-weight: 800;
            letter-spacing: 0.04em;
            text-decoration: none;
        }

        .top-header-title:hover {
            opacity: 0.88;
        }

        .header-actions {
            margin-left: auto;
            display: inline-flex;
            align-items: center;
            gap: 8px;
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

        .layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 280px;
            gap: 20px;
            align-items: start;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            color: var(--muted);
            text-decoration: none;
            font-weight: 700;
            margin-bottom: 16px;
        }

        .card {
            border: 1px solid var(--line);
            border-radius: 16px;
            background: var(--card);
            box-shadow: 0 12px 28px rgba(31, 41, 55, 0.08);
            padding: 22px;
        }

        .summary-card {
            border: 1px solid var(--line);
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 12px 28px rgba(31, 41, 55, 0.08);
            padding: 16px;
        }

        .summary-title {
            margin: 0 0 10px;
            font-size: 0.96rem;
            font-weight: 800;
            color: var(--text);
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        .summary-table th,
        .summary-table td {
            border: 1px solid var(--line);
            padding: 10px;
            text-align: left;
            vertical-align: middle;
        }

        .summary-table th {
            width: 42%;
            background: #f8fbff;
            color: var(--muted);
            font-weight: 700;
        }

        .summary-table td {
            color: var(--text);
            font-weight: 700;
        }

        .summary-buy-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            margin-top: 12px;
            border: 1px solid var(--accent);
            border-radius: 10px;
            background: var(--accent);
            color: #ffffff;
            text-decoration: none;
            font-size: 0.92rem;
            font-weight: 800;
            padding: 10px 12px;
            cursor: pointer;
        }

        .summary-buy-btn:hover {
            opacity: 0.92;
        }

        .top-row {
            display: flex;
            justify-content: flex-start;
            align-items: flex-start;
            gap: 20px;
        }

        .thumb {
            width: 260px;
            aspect-ratio: 4 / 3;
            border: 1px solid var(--line);
            border-bottom: 2px solid var(--line);
            border-radius: 10px;
            background: linear-gradient(135deg, #def7ec, #ffe9cc);
            display: grid;
            place-items: center;
            flex-shrink: 0;
        }

        .thumb-wrap {
            width: 260px;
            flex-shrink: 0;
        }

        .thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            border-radius: 10px;
            overflow: hidden;
        }

        .thumb-fallback {
            color: #436a63;
            font-size: 0.82rem;
            font-weight: 700;
        }

        .product-name {
            margin: 0;
            font-size: 2rem;
            font-weight: 800;
            color: var(--text);
        }

        .product-price {
            margin: 10px 0 0;
            padding-left: 8px;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text);
        }



        .purchase-top-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--accent);
            border-radius: 10px;
            background: var(--accent);
            color: #ffffff;
            text-decoration: none;
            font-size: 0.92rem;
            font-weight: 800;
            padding: 10px 14px;
            white-space: nowrap;
        }

        .title {
            margin: 0;
            font-size: clamp(1.2rem, 2vw, 1.5rem);
            font-weight: 800;
        }

        .meta {
            margin: 10px 0 0;
            color: var(--muted);
            font-size: 0.95rem;
        }

        .notice {
            margin-top: 16px;
            border: 1px solid #b8e0d9;
            border-radius: 10px;
            background: #ecfffb;
            color: #13564f;
            padding: 12px;
            font-size: 0.92rem;
            font-weight: 700;
        }

        .divider {
            border: none;
            border-top: 1px solid var(--line);
            margin: 20px -22px;
        }

        .section-title {
            margin: 20px 0 10px;
            font-size: 1rem;
            font-weight: 800;
            color: var(--text);
        }

        .section-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .delivery-change-btn {
            border: none;
            background: transparent;
            color: var(--accent);
            font-size: 0.88rem;
            font-weight: 700;
            cursor: pointer;
            padding: 0;
        }

        .payment-select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: #f9fafb;
            color: var(--text);
            font-size: 0.92rem;
            font-family: inherit;
            appearance: none;
            cursor: pointer;
        }

        .delivery-row {
            display: flex;
            justify-content: flex-start;
            margin-top: 9px;
        }

        .delivery-row.address-line {
            padding-bottom: 10px;
            border-bottom: 1px solid var(--line);
        }

        .delivery-postal {
            font-size: 0.92rem;
            color: var(--muted);
            font-weight: 600;
        }

        .delivery-edit {
            display: none;
            margin-top: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--line);
        }

        .delivery-edit.is-active {
            display: block;
        }

        .delivery-input-label {
            display: block;
            margin: 0 0 6px;
            font-size: 0.82rem;
            color: var(--muted);
            font-weight: 700;
        }

        .delivery-input {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: #f9fafb;
            color: var(--text);
            padding: 8px 10px;
            font-size: 0.9rem;
            font-family: inherit;
            margin-bottom: 10px;
        }

        .delivery-input:focus {
            outline: none;
            border-color: var(--accent);
        }

        .delivery-edit-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .delivery-save-btn,
        .delivery-cancel-btn {
            border-radius: 8px;
            font-size: 0.84rem;
            font-weight: 700;
            padding: 7px 12px;
            cursor: pointer;
        }

        .delivery-save-btn {
            border: 1px solid var(--accent);
            background: var(--accent);
            color: #ffffff;
        }

        .delivery-cancel-btn {
            border: 1px solid var(--line);
            background: #ffffff;
            color: var(--text);
        }

        .payment-select:focus {
            outline: none;
            border-color: var(--accent);
        }

        .payment-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid var(--line);
        }

        .payment-label {
            font-size: 0.92rem;
            color: var(--muted);
        }

        .payment-value {
            font-size: 0.92rem;
            font-weight: 700;
            color: var(--text);
        }

        .payment-change {
            font-size: 0.82rem;
            color: var(--accent);
            text-decoration: none;
            font-weight: 700;
        }

        .action {
            margin-top: 16px;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            border: 1px solid var(--accent);
            border-radius: 10px;
            background: var(--accent);
            color: #ffffff;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 800;
            padding: 11px 14px;
        }

        @media (max-width: 460px) {
            .page {
                margin: 20px auto 28px;
            }

            .top-row {
                gap: 8px;
            }

            .thumb {
                width: 130px;
            }

            .purchase-top-btn {
                font-size: 0.86rem;
                padding: 9px 12px;
            }
        }

        @media (max-width: 860px) {
            .layout {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="page">
        <header class="top-header" aria-label="ヘッダー">
            <a class="top-header-title" href="{{ route('products.index') }}">COACHTECH</a>
            <div class="header-actions">
                <a class="header-btn" href="#">ログアウト</a>
                <a class="header-btn" href="#">マイページ</a>
                <a class="header-btn primary" href="{{ route('products.create') }}">出品</a>
            </div>
        </header>
        <div class="layout">
            <article class="card" aria-label="購入手続き">
                <div class="top-row">
                    <div class="thumb-wrap">
                        <div class="thumb" aria-label="商品画像">
                            @php
                            $purchaseImageSrc = null;
                            if ($product->image_path) {
                            $purchaseImageSrc = \Illuminate\Support\Str::startsWith($product->image_path, ['http://', 'https://', '/'])
                            ? $product->image_path
                            : asset('storage/' . $product->image_path);
                            }
                            @endphp
                            @if ($purchaseImageSrc)
                            <img src="{{ $purchaseImageSrc }}" alt="{{ $product->name }} の画像">
                            @else
                            <span class="thumb-fallback">商品画像</span>
                            @endif
                        </div>
                    </div>
                </div>
                <hr class="divider">
                <h2 class="section-title">支払い方法</h2>
                <div class="payment-row">
                    <select class="payment-select" id="paymentMethodSelect" name="payment_method">
                        <option value="card" selected>カード支払い</option>
                        <option value="convenience">コンビニ支払い</option>
                    </select>
                </div>
                <hr class="divider">
                <div class="section-head">
                    <h2 class="section-title">配送先</h2>
                    <a href="{{ route('products.purchase.destination', $product) }}" class="delivery-change-btn" id="deliveryToggleBtn">住所の変更</a>
                </div>
                <div id="deliveryDisplay">
                    <div class="delivery-row">
                        <span class="delivery-postal" id="deliveryPostalText">{{ $deliveryPostalCode }}</span>
                    </div>
                    <div class="delivery-row address-line">
                        <span class="delivery-postal" id="deliveryAddressText">{{ $deliveryAddressLine }}</span>
                    </div>
                </div>
                <form class="delivery-edit" id="deliveryEditForm">
                    <label class="delivery-input-label" for="deliveryPostalInput">郵便番号</label>
                    <input class="delivery-input" id="deliveryPostalInput" type="text" value="{{ $deliveryPostalCode }}">
                    <label class="delivery-input-label" for="deliveryAddressInput">住所・建物名</label>
                    <input class="delivery-input" id="deliveryAddressInput" type="text" value="{{ $deliveryAddressLine }}">
                    <div class="delivery-edit-actions">
                        <button type="submit" class="delivery-save-btn">更新</button>
                        <button type="button" class="delivery-cancel-btn" id="deliveryCancelBtn">キャンセル</button>
                    </div>
                </form>
                @if (session('status'))
                <p class="notice">{{ session('status') }}</p>
                @endif
            </article>

            <aside class="summary-card" aria-label="購入内容サマリー">
                <table class="summary-table">
                    <tbody>
                        <tr>
                            <th>支払い方法</th>
                            <td id="summaryPaymentMethod">カード支払い</td>
                        </tr>
                    </tbody>
                </table>
                <form method="POST" action="{{ route('products.purchase.complete', $product) }}">
                    @csrf
                    <input type="hidden" name="payment_method" id="paymentMethodInput" value="card">
                    <button type="submit" class="summary-buy-btn" id="summaryBuyBtn">購入する</button>
                </form>
            </aside>
        </div>
    </div>

    <script>
        const deliveryToggleBtn = document.getElementById('deliveryToggleBtn');
        const deliveryCancelBtn = document.getElementById('deliveryCancelBtn');
        const paymentMethodSelect = document.getElementById('paymentMethodSelect');
        const paymentMethodInput = document.getElementById('paymentMethodInput');
        const summaryPaymentMethod = document.getElementById('summaryPaymentMethod');
        const summaryBuyBtn = document.getElementById('summaryBuyBtn');
        const deliveryDisplay = document.getElementById('deliveryDisplay');
        const deliveryEditForm = document.getElementById('deliveryEditForm');
        const deliveryPostalText = document.getElementById('deliveryPostalText');
        const deliveryAddressText = document.getElementById('deliveryAddressText');
        const deliveryPostalInput = document.getElementById('deliveryPostalInput');
        const deliveryAddressInput = document.getElementById('deliveryAddressInput');

        const updatePaymentSummary = () => {
            const selectedText = paymentMethodSelect.options[paymentMethodSelect.selectedIndex].text;
            summaryPaymentMethod.textContent = selectedText;
            paymentMethodInput.value = paymentMethodSelect.value;
        };

        const setEditMode = (isEdit) => {
            deliveryDisplay.style.display = isEdit ? 'none' : 'block';
            deliveryEditForm.classList.toggle('is-active', isEdit);
            if (isEdit) {
                deliveryPostalInput.focus();
            }
        };

        deliveryToggleBtn.addEventListener('click', (event) => {
            event.preventDefault();
            window.location.assign(deliveryToggleBtn.href);
        });

        deliveryCancelBtn.addEventListener('click', () => {
            setEditMode(false);
        });

        deliveryEditForm.addEventListener('submit', (event) => {
            event.preventDefault();
            const newPostal = deliveryPostalInput.value.trim();
            const newAddress = deliveryAddressInput.value.trim();

            if (newPostal !== '') {
                deliveryPostalText.textContent = newPostal;
            }

            if (newAddress !== '') {
                deliveryAddressText.textContent = newAddress;
            }

            setEditMode(false);
        });

        paymentMethodSelect.addEventListener('change', updatePaymentSummary);
        updatePaymentSummary();
    </script>
</body>

</html>