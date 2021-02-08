<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/app.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <title><?= $title; ?></title>
</head>

<body>
    <nav class="navbar navbar-expand-md fixed-top shadow-sm bg-teal1" style="height: 60px; vertical-align: middle;">
        <div class="navbar-brand p-0">
            <a href="/"><img src="assets/images/package_design.png" alt="yonde" height="45"></a>
        </div>
        <div class="row collapse navbar-collapse mr-auto">
            <a class="text-white text-decoration-none mb-0 h3" href="/">よんで</a>
        </div>
        <div class="navbar-expand">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="btn btn-sm bg-warning text-decoration-none text-white font-weight-bold ml-2 mr-2" href="signup.php" role="button">新規登録</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-sm btn-outline-teal1 bg-white text-decoration-none text-teal1 font-weight-bold ml-2 mr-2" href="login.php" role="button" disabled>　ログイン　</a>
                </li>
            </ul>
        </div>
    </nav>
    <?php include $content; ?>
</body>
<footer>
    <div style="margin-top: 74px;">
        <div class="container text-center mt-5 mb-5" style="font-size:x-small;">
            <a class="btn btn-link">
                <h6>利用規約</h6>
            </a>
            <a class="btn btn-link">
                <h6>プライバシーポリシー</h6>
            </a>
            <a class="btn btn-link">
                <h6> 特定商取引に関する表記</h6>
            </a>
            <a class="btn btn-link">
                <h6> お問い合わせ</h6>
            </a>
        </div>
        <div class="container text-center mt-5 mb-5">
            <a class="" style="font-size:xx-small;">© 2021 Ryuzo Yamate
            </a>
        </div>
    </div>
</footer>

</html>
