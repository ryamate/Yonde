<?php

// エラーをnullにする（@$item["volumeInfo"]['authors']に使用）
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $search_input = $_POST['search'];
    // バリデーションする
    $data = "https://www.googleapis.com/books/v1/volumes?q='$search_input'&maxResults=40";
    $json = file_get_contents($data);
    // trueを第二引数にすると配列型、falseだとオブジェクト型
    $searched_books_array = json_decode($json, true);

    $searched_books = $searched_books_array["items"];
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheets/css/app.css">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <title>絵本検索</title>
</head>

<body>
    <div class="container">
        <h1>絵本の検索</h1>
        <p>まずは絵本のタイトル、作家名、出版社名などを入力して検索してください。</p>
        <p>例えば… パンやのろくちゃん や はらぺこあおむし や おしりたんてい など。</p>
        <form action="search_api.php" method="POST">
            <div>
                <label for="search">検索</label>
                <input type="text" id="search" name="search" placeholder="絵本のタイトルなど">
                <button type="submit" class="btn btn-teal1 shadow mt-2 mb-2"><i class="fas fa-search"></i></button>
            </div>
        </form>
    </div>
    <main>
        <div class="container">
            <h2>検索結果</h2>
            <?php if (count($searched_books) > 0) : ?>
                <?php foreach ($searched_books as $item_number => $item) : ?>
                    <section class="card-deck shadow-sm mb-4">
                        <div class="card border-0 d-flex align-items-center justify-content-center">
                            <div class="card-body">
                                <!-- <h5 class="card-title">No.<?= $item_number + 1; ?></h5> -->

                                <?php $imageLink = @$item["volumeInfo"]["imageLinks"]["thumbnail"]; ?>
                                <?php if ($imageLink !== null) : ?>
                                    <img src="<?= $imageLink; ?>" alt="表紙イメージ">
                                <?php else : ?>
                                    <?= 'no image'; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="card border-0 d-flex align-items-center justify-content-center">
                            <?php $book_title = @$item["volumeInfo"]['title']; ?>
                            <h3 class="card-title"><?= $book_title; ?></h3>
                            <div class="card-text">
                                <?php $authors = @$item["volumeInfo"]['authors']; ?>
                                <?php if ($authors !== null) : ?>
                                    <?php foreach ($authors as $author) : ?>
                                        <p><?= $author; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                    <?php $published_date = @$item["volumeInfo"]["publishedDate"]; ?>
                                    <?php if ($published_date !== null) : ?>
                                        /<?= $published_date; ?></p>
                                    <?php endif; ?>
                            </div>
                        </div>
                        <div class="card border-0 d-flex align-items-center justify-content-center">
                            <form action="" method="POST">

                                <button type="submit" class="btn btn-teal1 shadow mt-2 mb-2"><i class="fas fa-plus-square"></i> 絵本棚に登録</button>
                            </form>
                        </div>
                    </section>
                <?php endforeach; ?>
            <?php else : ?>
                <p>検索結果は0件です。</p>
            <?php endif; ?>
        </div>
    </main>
</body>

</html>
