<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/app.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link rel="shortcut icon" href="../favicon.ico" />
    <title><?= $title; ?></title>
</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-light bg-teal1 shadow-sm bd-navbar" style="vertical-align: middle; position: sticky; top: 0; z-index: 1071;">

        <!-- navbar の左側: ロゴ -->
        <a class="navbar-brand mt-1 mr-2" href="../bookshelf.php">
            <img src="../assets/images/logo.png" height="35" class="d-inline-block align-top text-white text-decoration-none" alt=" yonde">
        </a>

        <!-- toggle button -->
        <button class="navbar-toggler p-1" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <!-- navbar の左側: アプリ名 -->
            <ul class="navbar-nav mr-auto d-none d-sm-block">
                <li class="nav-item">
                    <a class="nav-link text-white text-decoration-none mb-0 h4" href="../bookshelf.php">よんで</a>
                </li>
            </ul>

            <!-- navbar の右側: 検索バー・絵本棚・タイムライン・プロフィール設定・プロフィール画像（ホーム・ログアウト） -->
            <ul class="navbar-nav">

                <!-- 検索バー -->
                <div class="d-none d-sm-block pt-2">
                    <form action="../picture_books/search_picture_book.php" method="POST" class="form-inline">
                        <div class="input-group input-group-sm">
                            <input type="search" id="search" name="search" class="form-control" placeholder="絵本をさがす">
                            <div class="input-group-append">
                                <button class="btn btn-outline-teal1 bg-white text-teal1" type="submit" id="search"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- 検索バー toggle -->
                <div class="d-block d-sm-none pt-2">
                    <form action="../picture_books/search_picture_book.php" method="POST" class="form-inline">
                        <div class="input-group input-group-sm">
                            <input type="search" id="search" name="search" class="form-control" placeholder="絵本をさがす">
                            <div class="input-group-append">
                                <button class="btn btn-outline-teal1 bg-white text-teal1" type="submit" id="search"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- 絵本棚 button -->
                <li class="nav-item">
                    <div class="d-none d-sm-block">
                        <a href="../bookshelf.php" title="絵本棚" class="nav-link btn-teal1 text-white rounded-circle d-flex align-items-center justify-content-center ml-3" style="width: 45px; height:45px;"><i class="fas fa-book fa-lg"></i></a>
                    </div>
                    <!-- 絵本棚 toggle -->
                    <div class="d-block d-sm-none">
                        <a href="../bookshelf.php" title="絵本棚" class="nav-link">絵本棚</a>
                    </div>
                </li>

                <!-- タイムライン button -->
                <li class="nav-item">
                    <div class="d-none d-sm-block">
                        <a href="" title="タイムライン" class="nav-link btn-teal1 text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height:45px;"><i class="far fa-clock fa-lg"></i></a>
                    </div>
                    <!-- タイムライン toggle -->
                    <div class="d-block d-sm-none">
                        <a href="" title="タイムライン" class="nav-link">タイムライン</a>
                    </div>
                </li>

                <!-- プロフィール設定 button -->
                <li class="nav-item">
                    <div class="d-none d-sm-block">
                        <a href="../users/profile_setting.php" title="プロフィール設定" class="nav-link btn-teal1 text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height:45px;"><i class="fas fa-cog fa-lg"></i></a>
                    </div>
                    <!-- プロフィール設定 toggle -->
                    <div class="d-block d-sm-none">
                        <a href="../users/profile_setting.php" title="プロフィール設定" class="nav-link">プロフィール設定</a>
                    </div>
                </li>

                <!-- プロフィール画像（ホーム・ログアウト） button -->
                <li class="nav-item">
                    <div class="d-none d-sm-block">
                        <div class="mt-1 ml-1 mr-2">
                            <div class="dropdown drop-hover">
                                <a href="" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php if ($login_user['user_icon'] !== '') : ?>
                                        <img src="../assets/images/user_icon/<?= escape($login_user['user_icon']); ?>" alt="プロフィール画像" class="rounded-circle bg-white border" width="35" height="35" style="background-position: center center; object-fit:cover;">
                                    <?php else : ?>
                                        <i class="far fa-user-circle fa-2x text-white rounded-circle"></i>
                                    <?php endif; ?>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item small" href="../bookshelf.php">ホーム</a>
                                    <a class="dropdown-item small" href="../auth/logout.php">ログアウト</a>
                                </div>

                                <style>
                                    .drop-hover:hover>.dropdown-menu {
                                        display: block;
                                    }
                                </style>
                            </div>
                        </div>
                    </div>
                    <!-- ホーム toggle -->
                    <div class="d-block d-sm-none">
                        <a href="../bookshelf.php" title="ホーム" class="nav-link">ホーム</a>
                    </div>
                </li>
                <li class="nav-item">
                    <!-- ログアウト toggle -->
                    <div class="d-block d-sm-none">
                        <a href="../auth/logout.php" title="ログアウト" class="nav-link">ログアウト</a>
                    </div>
                </li>

            </ul>
        </div>
    </nav>

    <?php include $content; ?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!-- <script src="../vendor/twbs/bootstrap/site/docs/4.5/assets/js/vendor/jquery.slim.min.js"></script>
    <script src="../vendor/twbs/bootstrap/dist/js/bootstrap.js"></script> -->
</body>
<footer>
    <div class="bg-teal1 text-white" style="margin-top: 74px;">
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
            <a class="" style="font-size:xx-small;">© 2021 Ryuzo Yamate
            </a>
        </div>
    </div>
</footer>


</html>
