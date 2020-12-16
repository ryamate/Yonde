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
    <nav class="fixed-top navbar navbar-expand-md shadow-sm" style="background: rgba(255,255,255,0.9);">
        <h1 class="h2">
            <a class="text-teal1 text-decoration-none" href="bookshelf.php"><img src="/image/package_design.png" alt="yonde" height="45">よんで</a>
        </h1>
    </nav>
    <header>

    </header>
    <main>
        <div class="container" style="margin-top: 90px;">
            <?php include $content; ?>
        </div>
    </main>
    <footer>

    </footer>
</body>

</html>
