<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>問い合わせフォーム</title>
    <!-- BootstrapのCSSを読み込む -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">問い合わせフォーム</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('inquiry.submit') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">名前</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">メールアドレス</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
            @error('email')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="affiliation" class="form-label">所属(会社名や学校名)</label>
            <input type="text" class="form-control" id="affiliation" name="affiliation" value="{{ old('affiliation') }}">
            @error('affiliation')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="inquiry_type" class="form-label">問い合わせの種別</label>
            <select class="form-select" id="inquiry_type" name="inq_type" required>
                <option value="" disabled selected>選択してください</option>
                <option value="1">種別1</option>
                <option value="2">種別2</option>
                <option value="3">種別3</option>
            </select>
            @error('inquiry_type')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="subject" class="form-label">件名</label>
            <input type="text" class="form-control" id="subject" name="subject" value="{{ old('subject') }}" required>
            @error('subject')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="message" class="form-label">問い合わせ内容</label>
            <textarea class="form-control" id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
            @error('message')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">送信</button>
    </form>
</div>

<!-- BootstrapのJSを読み込む（必要な場合） -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
