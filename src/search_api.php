<?php

// エラーをnullにする（@$item["volumeInfo"]['authors']に使用）
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $search_input = $_POST['search'];
    // バリデーションする
    $data = "https://www.googleapis.com/books/v1/volumes?q='$search_input'";
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
    <title>絵本検索</title>
</head>

<body>
    <h1>絵本の検索</h1>
    <p>まずは絵本のタイトル、作家名、出版社名などを入力して検索してください。</p>
    <p>例えば… パンやのろくちゃん や はらぺこあおむし や えんとつ町のプペル など。</p>
    <form action="search_api.php" method="POST">
        <div>
            <label for="search">検索</label>
            <input type="text" id="search" name="search">
            <button type="submit">検索する</button>
        </div>
    </form>
    <h2>検索結果</h2>
    <main>
        <?php if (count($searched_books) > 0) : ?>
            <?php foreach ($searched_books as $item_number => $item) : ?>
                <section class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title text-teal1">No.<?= $item_number + 1; ?></h5>
                        <?php $imageLink = @$item["volumeInfo"]["imageLinks"]["smallThumbnail"]; ?>
                        <?php if ($imageLink !== null) : ?>
                            <img src="<?= $imageLink; ?>" alt="表紙イメージ">
                        <?php else : ?>
                            <?= 'no image'; ?>
                        <?php endif; ?>

                        <h3><?= $item["volumeInfo"]['title']; ?></h3>

                        <?php $authors = @$item["volumeInfo"]['authors']; ?>
                        <?php if ($authors !== null) : ?>
                            <?php foreach ($authors as $author) : ?>
                                <h5><?= $author; ?></h5>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php $published_date = @$item["volumeInfo"]["publishedDate"]; ?>
                        <?php if ($published_date !== null) : ?>
                            <h5><?= $published_date; ?></h5>
                        <?php endif; ?>
                    </div>
                </section>
            <?php endforeach; ?>
        <?php else : ?>
            <p>検索結果は0件です。</p>
        <?php endif; ?>
    </main>
</body>

</html>
