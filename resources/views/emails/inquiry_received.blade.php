<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>問い合わせ受領確認</title>
</head>
<body>
<p>{{ $name }}様</p>

<p>お問い合わせありがとうございます。</p>

<p>以下の内容でお問い合わせを受け付けました：</p>

<ul>
    <li>件名: {{ $subject }}</li>
    <li>問い合わせ内容: {{ $messageContent }}</li>
</ul>

<p>後ほど、担当者よりご連絡いたします。</p>

<p>どうぞよろしくお願いいたします。</p>
</body>
</html>
