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
    <nav class="navbar navbar-expand-md fixed-top shadow-sm bg-teal1" style="height: 60px; vertical-align: middle;">
        <div class="navbar-brand p-0">
            <a href="/"><img src="/images/package_design.png" alt="yonde" height="45"></a>
        </div>
        <div class="row collapse navbar-collapse mr-auto">
            <a class="text-white text-decoration-none mb-0 h3" href="/">よんで</a>
        </div>
        <!-- </div> -->
        <div class="navbar-expand">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="btn btn-sm bg-warning text-decoration-none text-white font-weight-bold ml-2 mr2" href="signup.php" role="button">新規登録</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-sm btn-outline-teal1 bg-white text-decoration-none text-teal1 font-weight-bold ml-2 mr2" href="input_login.php" role="button" disabled>ログイン</a>
                    <!-- <button type="submit" class="btn btn-teal1 shadow">新規登録</button> -->
                </li>
            </ul>
        </div>
    </nav>
    <?php include $content; ?>
</body>

</html>
