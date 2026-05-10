<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品出品</title>
    <style>
        body {
            margin: 0;
            font-family: "Hiragino Kaku Gothic ProN", "Yu Gothic", sans-serif;
            background: #f7f5ef;
            color: #2f2f2f;
        }

        .page {
            width: min(920px, 92%);
            margin: 28px auto;
        }

        .header {
            background: #000;
            border: 1px solid #000;
            border-radius: 14px;
            padding: 12px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
        }

        .brand {
            color: #fff;
            text-decoration: none;
            font-weight: 700;
        }

        .actions {
            display: flex;
            gap: 8px;
        }

        .btn {
            border: 1px solid #d9d3c8;
            border-radius: 10px;
            padding: 8px 12px;
            background: #fff;
            color: inherit;
            text-decoration: none;
            font-size: 14px;
        }

        .btn.primary {
            background: #0b7a6c;
            border-color: #0b7a6c;
            color: #fff;
        }

        .card {
            margin-top: 18px;
            background: #fff;
            border: 1px solid #d9d3c8;
            border-radius: 14px;
            padding: 24px;
            display: grid;
            place-items: start center;
        }

        .product-form {
            width: 100%;
        }

        h1 {
            margin: 0;
            font-size: 28px;
            text-align: center;
        }

        p {
            margin-top: 10px;
            color: #5f5b52;
        }

        .image-label {
            width: 100%;
            margin-top: 18px;
            color: #2f2f2f;
            text-align: left;
        }

        .image-picker-frame {
            width: 100%;
            margin-top: 10px;
            padding: 18px;
            border: 1px solid #d9d3c8;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 14px;
        }

        .image-input {
            display: none;
        }

        .category-options {
            width: 100%;
            margin-top: 12px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .category-option-input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .category-option-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 96px;
            padding: 10px 18px;
            border: 1px solid #d9d3c8;
            border-radius: 999px;
            background: #fff;
            color: #2f2f2f;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.2s ease, border-color 0.2s ease, color 0.2s ease;
        }

        .category-option-input:checked+.category-option-label {
            border-color: #0b7a6c;
            background: #0b7a6c;
            color: #fff;
        }

        .image-select-btn {
            align-self: start;
            border: 1px solid #d9d3c8;
            border-radius: 0;
            padding: 10px 14px;
            background: #fff;
            color: #2f2f2f;
            font-size: 14px;
            cursor: pointer;
        }

        .image-preview {
            display: none;
            width: min(320px, 100%);
            border-radius: 10px;
            object-fit: cover;
        }

        .image-preview.is-visible {
            display: block;
        }

        .image-file-name {
            margin: 0;
            color: #5f5b52;
            font-size: 13px;
        }

        .section-label {
            width: 100%;
            margin: 24px 0 0;
            padding-bottom: 12px;
            border-bottom: 1px solid #d9d3c8;
            color: #2f2f2f;
            font-size: 20px;
            font-weight: 700;
            text-align: left;
        }

        .select-box {
            width: 100%;
            margin-top: 4px;
            padding: 12px;
            border: 1px solid #d9d3c8;
            border-radius: 8px;
            background: #fff;
            color: #2f2f2f;
            font-size: 14px;
        }

        .text-input,
        .textarea-input {
            width: 100%;
            margin-top: 4px;
            padding: 12px;
            border: 1px solid #d9d3c8;
            border-radius: 8px;
            background: #fff;
            color: #2f2f2f;
            font-size: 14px;
            box-sizing: border-box;
        }

        .textarea-input {
            min-height: 120px;
            resize: vertical;
        }

        .submit-btn {
            width: 100%;
            margin-top: 24px;
            border: 1px solid #0b7a6c;
            border-radius: 8px;
            padding: 14px 16px;
            background: #0b7a6c;
            color: #fff;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
        }

        .form-message,
        .form-errors {
            width: 100%;
            margin-top: 18px;
            padding: 12px 14px;
            border-radius: 8px;
            box-sizing: border-box;
        }

        .form-message {
            border: 1px solid #b9ddc7;
            background: #edf8f1;
            color: #1f6b39;
        }

        .form-errors {
            border: 1px solid #f0b7b7;
            background: #fff1f1;
            color: #b3261e;
        }

        .form-errors ul {
            margin: 0;
            padding-left: 20px;
        }
    </style>
</head>

<body>
    <div class="page">
        <header class="header">
            <a class="brand" href="{{ route('products.index') }}">COACHTECH</a>
            <div class="actions">
                <a class="btn" href="{{ route('profile.show') }}">マイページ</a>
                <a class="btn primary" href="{{ route('products.create') }}">出品</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn" type="submit">ログアウト</button>
                </form>
            </div>
        </header>

        <section class="card" aria-label="商品の出品">
            <h1>商品の出品</h1>
            <form class="product-form" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if (session('status'))
                <div class="form-message">{{ session('status') }}</div>
                @endif

                @if ($errors->any())
                <div class="form-errors">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <p class="image-label">商品画像</p>
                <input class="image-input" id="product-image" type="file" name="product_image" accept="image/*">
                <input id="temporary-image-path" type="hidden" name="temporary_image_path" value="{{ old('temporary_image_path', '') }}">
                <div class="image-picker-frame">
                    <button class="image-select-btn" id="product-image-trigger" type="button">画像を選択</button>
                    <img class="image-preview {{ old('temporary_image_path') ? 'is-visible' : '' }}" id="product-image-preview" alt="選択した商品画像のプレビュー" @if (old('temporary_image_path')) src="{{ asset('storage/' . old('temporary_image_path')) }}" @endif>
                    <p class="image-file-name" id="product-image-name">{{ old('temporary_image_path') ? basename((string) old('temporary_image_path')) : '選択されていません' }}</p>
                </div>
                <p class="section-label">商品の詳細</p>
                <p class="image-label">カテゴリー</p>
                <div class="category-options" role="radiogroup" aria-label="カテゴリー">
                    <input class="category-option-input" id="category-ladies" type="radio" name="category" value="ladies" {{ old('category') === 'ladies' ? 'checked' : '' }}>
                    <label class="category-option-label" for="category-ladies">レディース</label>

                    <input class="category-option-input" id="category-mens" type="radio" name="category" value="mens" {{ old('category') === 'mens' ? 'checked' : '' }}>
                    <label class="category-option-label" for="category-mens">メンズ</label>

                    <input class="category-option-input" id="category-cosmetics" type="radio" name="category" value="cosmetics" {{ old('category') === 'cosmetics' ? 'checked' : '' }}>
                    <label class="category-option-label" for="category-cosmetics">コスメ</label>

                    <input class="category-option-input" id="category-books" type="radio" name="category" value="books" {{ old('category') === 'books' ? 'checked' : '' }}>
                    <label class="category-option-label" for="category-books">本</label>

                    <input class="category-option-input" id="category-games" type="radio" name="category" value="games" {{ old('category') === 'games' ? 'checked' : '' }}>
                    <label class="category-option-label" for="category-games">ゲーム</label>

                    <input class="category-option-input" id="category-sports" type="radio" name="category" value="sports" {{ old('category') === 'sports' ? 'checked' : '' }}>
                    <label class="category-option-label" for="category-sports">スポーツ</label>

                    <input class="category-option-input" id="category-kitchen" type="radio" name="category" value="kitchen" {{ old('category') === 'kitchen' ? 'checked' : '' }}>
                    <label class="category-option-label" for="category-kitchen">キッチン</label>

                    <input class="category-option-input" id="category-handmade" type="radio" name="category" value="handmade" {{ old('category') === 'handmade' ? 'checked' : '' }}>
                    <label class="category-option-label" for="category-handmade">ハンドメイド</label>

                    <input class="category-option-input" id="category-accessories" type="radio" name="category" value="accessories" {{ old('category') === 'accessories' ? 'checked' : '' }}>
                    <label class="category-option-label" for="category-accessories">アクセサリー</label>

                    <input class="category-option-input" id="category-toys" type="radio" name="category" value="toys" {{ old('category') === 'toys' ? 'checked' : '' }}>
                    <label class="category-option-label" for="category-toys">おもちゃ</label>

                    <input class="category-option-input" id="category-baby-kids" type="radio" name="category" value="baby_kids" {{ old('category') === 'baby_kids' ? 'checked' : '' }}>
                    <label class="category-option-label" for="category-baby-kids">ベビー・キッズ</label>
                </div>

                <p class="image-label">商品の状態</p>
                <select class="select-box" name="condition" aria-label="商品の状態">
                    <option value="" selected disabled>選択してください</option>
                    <option value="good" {{ old('condition') === 'good' ? 'selected' : '' }}>良好</option>
                    <option value="no_visible_damage" {{ old('condition') === 'no_visible_damage' ? 'selected' : '' }}>目立った傷や汚れなし</option>
                    <option value="some_damage" {{ old('condition') === 'some_damage' ? 'selected' : '' }}>やや傷や汚れあり</option>
                    <option value="poor" {{ old('condition') === 'poor' ? 'selected' : '' }}>状態が悪い</option>
                </select>

                <p class="section-label">商品名と説明</p>

                <p class="image-label">商品名</p>
                <input class="text-input" type="text" name="name" value="{{ old('name') }}" placeholder="" aria-label="商品名">

                <p class="image-label">ブランド名</p>
                <input class="text-input" type="text" name="brand" value="{{ old('brand') }}" placeholder="" aria-label="ブランド名">

                <p class="image-label">説明</p>
                <textarea class="textarea-input" name="description" placeholder="" aria-label="説明">{{ old('description') }}</textarea>

                <p class="image-label">販売価格</p>
                <input class="text-input" type="text" name="price" value="{{ old('price') }}" placeholder="¥" aria-label="販売価格">

                <button class="submit-btn" type="submit">出品する</button>
            </form>
        </section>
    </div>
</body>

<script>
    const productImageInput = document.getElementById('product-image');
    const productImageTrigger = document.getElementById('product-image-trigger');
    const productImagePreview = document.getElementById('product-image-preview');
    const productImageName = document.getElementById('product-image-name');
    const temporaryImagePathInput = document.getElementById('temporary-image-path');
    const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
    const uploadTemporaryImageUrl = "{{ route('products.image.temp.upload') }}";
    const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '{{ csrf_token() }}';

    if (productImageInput && productImageTrigger && productImagePreview && productImageName && temporaryImagePathInput) {
        productImageTrigger.addEventListener('click', () => {
            productImageInput.click();
        });

        productImageInput.addEventListener('change', async (event) => {
            const [file] = event.target.files || [];

            if (!file) {
                productImagePreview.classList.remove('is-visible');
                productImagePreview.removeAttribute('src');
                productImageName.textContent = '選択されていません';
                temporaryImagePathInput.value = '';
                return;
            }

            const formData = new FormData();
            formData.append('product_image', file);

            try {
                const response = await fetch(uploadTemporaryImageUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                const payload = await response.json();

                if (!response.ok) {
                    throw new Error(payload.message || '画像アップロードに失敗しました。');
                }

                temporaryImagePathInput.value = payload.path || '';
                productImagePreview.src = payload.url || URL.createObjectURL(file);
                productImagePreview.classList.add('is-visible');
                productImageName.textContent = payload.name || file.name;
            } catch (error) {
                productImagePreview.classList.remove('is-visible');
                productImagePreview.removeAttribute('src');
                productImageName.textContent = '選択されていません';
                temporaryImagePathInput.value = '';
                alert(error instanceof Error ? error.message : '画像アップロードに失敗しました。');
            }
        });
    }
</script>

</html>