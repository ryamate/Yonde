<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheets/css/app.css">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <title><?= $title; ?></title>
</head>

<body>
    <nav class="navbar navbar-expand-md fixed-top shadow-sm" style="height: 60px; vertical-align: middle;background: rgba(255,255,255,0.9);">
        <div class="navbar-brand p-0">
            <a href="bookshelf.php"><img src="/images/package_design.png" alt="yonde" height="45"></a>
        </div>
        <div class="row collapse navbar-collapse mr-auto">
            <a class="text-teal1 text-decoration-none mb-0 h3" href="bookshelf.php">よんで</a>
        </div>
        <div class="navbar-expand">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <form action="search_result.php" method="POST" class="form-inline">
                        <input type="text" id="search" name="search" class="form-control" placeholder="絵本を検索">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-teal1"><i class="fas fa-search"></i></button>
                    </form>
                </li>
                <li class="nav-item">
                </li>
            </ul>
        </div>
    </nav>
    <?php include $content; ?>
</body>
<footer>
    <div class=" bg-teal1 text-white" style="margin-top: 74px;">
        <div class="container text-center pt-4 mb-4" style="font-size:x-small;">
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
        <div class="container text-center mt-4 pb-5">
            <a class="" style="font-size:xx-small;">© 2020 Ryuzo Yamate
            </a>
        </div>
    </div>
</footer>


</html>
