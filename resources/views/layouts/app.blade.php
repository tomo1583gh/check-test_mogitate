<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mogitate</title>

    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">


    <!-- 共通CSSの読み込み -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <!-- ✅ ヘッダー -->
    <header class="main-header">
        <div class="logo">mogitate</div>
    </header>

    <!-- ✅ メインコンテンツ -->
    <main class="main-content">
        @yield('content')
    </main>
</body>

</html>