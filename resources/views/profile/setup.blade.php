<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロフィール設定</title>
    <style>
        :root {
            --bg-start: #eef6ff;
            --bg-end: #fff6ec;
            --card-bg: #ffffff;
            --text-main: #1a2433;
            --text-muted: #5f6b82;
            --accent: #2563eb;
            --line: #dfe5f2;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Noto Sans JP", "Hiragino Kaku Gothic ProN", "Yu Gothic", sans-serif;
            color: var(--text-main);
            background: radial-gradient(circle at 80% 20%, #ffffff 0%, transparent 45%),
                linear-gradient(145deg, var(--bg-start), var(--bg-end));
            padding: 24px;
        }

        .page {
            width: min(100%, 760px);
            margin: 0 auto;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 18px;
            padding: 14px 16px;
            border-radius: 12px;
            background: #000000;
            color: #ffffff;
        }

        .brand {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .brand-link {
            color: inherit;
            text-decoration: none;
        }

        .brand-title {
            margin: 0;
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--text-muted);
        }

        .brand-user {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 700;
        }

        .logout-form {
            margin: 0;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #cbd6ee;
            border-radius: 999px;
            padding: 10px 16px;
            background: rgba(255, 255, 255, 0.72);
            color: var(--text-main);
            font-size: 0.95rem;
            font-weight: 700;
            text-decoration: none;
        }

        .logout-button {
            border: 1px solid #cbd6ee;
            border-radius: 999px;
            padding: 10px 16px;
            background: rgba(255, 255, 255, 0.72);
            color: var(--text-main);
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
        }

        .card {
            width: min(100%, 560px);
            background: var(--card-bg);
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 28px 24px;
            box-shadow: 0 20px 46px rgba(32, 50, 88, 0.12);
        }

        h1 {
            margin: 0;
            font-size: 1.7rem;
            line-height: 1.2;
        }

        .lead {
            margin: 12px 0 0;
            font-size: 0.98rem;
            color: var(--text-muted);
        }

        .status {
            margin-top: 16px;
            padding: 12px 14px;
            border: 1px solid #bfd4ff;
            border-radius: 10px;
            background: #eff5ff;
            color: var(--accent);
            font-size: 0.92rem;
            font-weight: 700;
        }

        .error-summary {
            margin-top: 16px;
            padding: 12px 14px;
            border: 1px solid #fecaca;
            border-radius: 10px;
            background: #fff1f2;
            color: #9f1239;
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .error-summary ul {
            margin: 8px 0 0;
            padding-left: 20px;
        }

        .verify-status {
            margin-top: 16px;
            padding: 12px 14px;
            border: 1px solid #f3d38a;
            border-radius: 10px;
            background: #fff7e4;
            color: #8a5a00;
            font-size: 0.92rem;
            line-height: 1.6;
        }

        .verify-status a {
            color: #7c4a00;
            font-weight: 700;
        }

        .steps {
            margin-top: 16px;
            padding-left: 20px;
            color: var(--text-main);
            line-height: 1.7;
        }

        .form {
            margin-top: 24px;
            display: grid;
            gap: 18px;
        }

        .field {
            display: grid;
            gap: 8px;
        }

        .profile-image-panel {
            display: grid;
            grid-template-columns: 104px 1fr;
            gap: 16px;
            align-items: center;
            padding: 18px;
            border-radius: 16px;
            background: linear-gradient(180deg, #fbfdff, #f5f8ff);
        }

        .profile-image-preview {
            width: 104px;
            height: 104px;
            border-radius: 28px;
            object-fit: cover;
            background: linear-gradient(135deg, #dbeafe, #ffedd5);
        }

        .profile-image-clickable {
            cursor: pointer;
        }

        .profile-image-fallback {
            display: grid;
            place-items: center;
            font-size: 2rem;
            font-weight: 700;
            color: #33518d;
        }

        .profile-image-copy {
            display: grid;
            gap: 10px;
        }

        .visually-hidden-file {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            border: 0;
            white-space: nowrap;
        }

        .file-trigger {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: fit-content;
            min-height: 42px;
            padding: 10px 16px;
            border: 1px solid #cfd8ea;
            border-radius: 999px;
            background: #fcfdff;
            color: var(--text-main);
            font-size: 0.92rem;
            font-weight: 700;
            cursor: pointer;
        }

        .file-trigger:hover {
            background: #f3f7ff;
        }

        .label {
            font-size: 0.94rem;
            font-weight: 700;
        }

        .input {
            width: 100%;
            border: 1px solid #cfd8ea;
            border-radius: 12px;
            padding: 12px 14px;
            font-size: 1rem;
            color: var(--text-main);
            background: #fcfdff;
        }

        .input:focus {
            outline: none;
            border-color: #8bb4ff;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        .hint {
            margin: 0;
            font-size: 0.84rem;
            color: var(--text-muted);
        }

        .error {
            margin: 0;
            font-size: 0.84rem;
            color: #c2410c;
        }

        .actions {
            display: flex;
            justify-content: center;
        }

        .submit-button {
            border: none;
            border-radius: 999px;
            min-width: 220px;
            padding: 14px 28px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #ffffff;
            font-size: 1.02rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 14px 24px rgba(37, 99, 235, 0.22);
        }

        @media (max-width: 640px) {
            .header {
                align-items: stretch;
                flex-direction: column;
            }

            .logout-button {
                width: 100%;
            }

            .header-actions {
                width: 100%;
                flex-direction: column;
            }

            .header-link,
            .logout-form,
            .logout-button {
                width: 100%;
            }

            .profile-image-panel {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="page">
        <header class="header">
            <div class="brand">
                <p class="brand-title"><a class="brand-link" href="{{ route('register.show') }}">COACHTECH</a></p>
                <p class="brand-user">{{ auth()->user()->name }} さん</p>
            </div>

            <div class="header-actions">
                <a class="header-link" href="{{ route('profile.show') }}">マイページ</a>
                <a class="header-link" href="{{ route('products.create') }}">出品</a>

                <form class="logout-form" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout-button" type="submit">ログアウト</button>
                </form>
            </div>
        </header>

        <main class="card">
            <h1>プロフィール設定</h1>
            <p class="lead">初回登録ありがとうございます。プロフィール情報を設定してください。</p>

            @if (session('status'))
            <p class="status">{{ session('status') }}</p>
            @endif

            @if ($errors->any())
            <div class="error-summary" role="alert" aria-live="assertive">
                入力内容に誤りがあります。以下を確認してください。
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form class="form" method="POST" action="{{ route('profile.setup.update') }}" enctype="multipart/form-data" novalidate>
                @csrf

                <div class="field">
                    <label class="label" for="profile_image">プロフィール画像</label>
                    <div class="profile-image-panel">
                        @if ($user->profile_image_path)
                        <img
                            class="profile-image-preview profile-image-clickable"
                            src="{{ asset('storage/' . $user->profile_image_path) }}"
                            id="profileImageTrigger"
                            alt="現在のプロフィール画像">
                        @else
                        <div class="profile-image-preview profile-image-fallback profile-image-clickable" id="profileImageTrigger" aria-hidden="true">
                        </div>
                        @endif

                        <div class="profile-image-copy">
                            <input
                                class="visually-hidden-file"
                                id="profile_image"
                                name="profile_image"
                                type="file"
                                accept="image/png,image/jpeg,image/webp">
                            @error('profile_image')
                            <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="name">ユーザー名</label>
                    <input
                        class="input"
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name', $user->name) }}"
                        maxlength="255"
                        pattern=".*\S.*"
                        title="ユーザー名を入力してください。"
                        required>
                    @error('name')
                    <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field">
                    <label class="label" for="email">メールアドレス</label>
                    <input
                        class="input"
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email', $user->email) }}"
                        maxlength="255"
                        placeholder="user@example.com"
                        required>
                    <p class="hint">コンビニ支払いの案内送信に利用します。</p>
                    @error('email')
                    <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field">
                    <label class="label" for="postal_code">郵便番号</label>
                    <input
                        class="input"
                        id="postal_code"
                        name="postal_code"
                        type="text"
                        value="{{ old('postal_code', $user->postal_code) }}"
                        inputmode="numeric"
                        maxlength="8"
                        placeholder="123-4567"
                        pattern="\d{3}-?\d{4}"
                        title="郵便番号は123-4567形式で入力してください。"
                        required>
                    <p class="hint">ハイフンあり、または数字7桁で入力してください。</p>
                    @error('postal_code')
                    <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field">
                    <label class="label" for="address">住所</label>
                    <input
                        class="input"
                        id="address"
                        name="address"
                        type="text"
                        value="{{ old('address', $user->address) }}"
                        maxlength="255"
                        pattern=".*\S.*"
                        title="住所を入力してください。"
                        required>
                    @error('address')
                    <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field">
                    <label class="label" for="building_name">建物名</label>
                    <input
                        class="input"
                        id="building_name"
                        name="building_name"
                        type="text"
                        value="{{ old('building_name', $user->building_name) }}"
                        maxlength="255"
                        pattern=".*\S.*"
                        title="建物名を入力してください。"
                        required>
                    @error('building_name')
                    <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="actions">
                    <button class="submit-button" type="submit">更新する</button>
                </div>
            </form>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const fileInput = document.getElementById('profile_image');
            const imageTrigger = document.getElementById('profileImageTrigger');

            if (!fileInput || !imageTrigger) {
                return;
            }

            let currentObjectUrl = null;

            const openFilePicker = () => {
                fileInput.click();
            };

            imageTrigger.setAttribute('role', 'button');
            imageTrigger.setAttribute('tabindex', '0');
            imageTrigger.setAttribute('aria-label', 'プロフィール画像を選択');

            imageTrigger.addEventListener('click', openFilePicker);
            imageTrigger.addEventListener('keydown', (event) => {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    openFilePicker();
                }
            });

            fileInput.addEventListener('change', () => {
                const selectedFile = fileInput.files && fileInput.files[0];

                if (!selectedFile) {
                    return;
                }

                if (currentObjectUrl) {
                    URL.revokeObjectURL(currentObjectUrl);
                }

                currentObjectUrl = URL.createObjectURL(selectedFile);

                if (imageTrigger.tagName.toLowerCase() === 'img') {
                    imageTrigger.src = currentObjectUrl;
                    return;
                }

                imageTrigger.style.backgroundImage = `url(${currentObjectUrl})`;
                imageTrigger.style.backgroundSize = 'cover';
                imageTrigger.style.backgroundPosition = 'center';
            });
        });
    </script>
</body>

</html>