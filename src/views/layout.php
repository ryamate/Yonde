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
    <nav class="navbar navbar-expand-md fixed-top shadow-sm bg-teal1" style="height: 60px; vertical-align: middle;">
        <div class="navbar-brand p-0">
            <a href="../bookshelf.php"><img src="../assets/images/logo.png" alt="yonde" height="45"></a>
        </div>
        <div class="row collapse navbar-collapse mr-auto">
            <a class="text-white text-decoration-none mb-0 ml-1 h2" href="../bookshelf.php">よんで</a>
        </div>

        <div class="navbar-expand">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <form action="../picture_books/search_picture_book.php" method="POST" class="form-inline">
                        <div class="input-group input-group-sm mt-2">
                            <input type="text" id="search" name="search" class="form-control" placeholder="絵本をさがす">
                            <div class="input-group-append">
                                <button class="btn btn-outline-teal1 bg-white text-teal1" type="submit" id="search"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </li>
                <li class="nav-item ml-1">
                    <a href="" title="本棚" class="btn btn-teal1 text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height:45px;"><i class="fas fa-book fa-lg"></i></a>
                </li>
                <li class="nav-item">
                    <a href="" title="タイムライン" class="btn btn-teal1 text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height:45px;"><i class="far fa-clock fa-lg"></i></a>
                </li>
                <li class="nav-item">
                    <a href="../users/profile_setting.php" title="プロフィール設定" class="btn btn-teal1 text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height:45px;"><i class="fas fa-cog fa-lg"></i></a>
                </li>
                <li class=" nav-item ml-1 d-flex align-items-center justify-content-center">
                    <div class="dropdown drop-hover">
                        <a href="" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="">

                            <!-- <img src="../assets/images/user_icon/<?= $login_user['user_icon'] !== '' ? escape($login_user['user_icon']) : 'no_image_user_man.png'; ?>" alt="プロフィール画像" class="rounded-circle" style="width: 45px; height:45px;background-position: center center; object-fit:cover;"> -->


                            <?php if ($login_user['user_icon'] !== '') : ?>
                                <img src="../assets/images/user_icon/<?= escape($login_user['user_icon']); ?>" alt="プロフィール画像" class="rounded-circle" style="width: 45px; height:45px;background-position: center center; object-fit:cover;">
                            <?php else : ?>
                                <i class="far fa-user-circle fa-2x text-white rounded-circle"></i>
                                <!-- <img src="assets/images/user_icon/no_image_user_man.png" alt="プロフィール画像" style="width: 100px; height:100px;background-position: center center;border-radius: 50%;object-fit:cover;"> -->
                            <?php endif; ?>


                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item small" href="../bookshelf.php">ホーム</a>
                            <a class="dropdown-item small" href="../auth/logout.php">ログアウト</a>
                        </div>
                    </div>
                    <style>
                        .drop-hover:hover>.dropdown-menu {
                            display: block;
                        }
                    </style>
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
