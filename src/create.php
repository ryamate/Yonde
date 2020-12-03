<?php

// 検索結果→絵本登録に利用

require_once __DIR__ . '/lib/mysqli.php';

function createPictureBook($link, $picture_book)
{
    $sql = <<<EOT
INSERT INTO companies (
    title,
    author,
    publisher
)VALUES (
    "{$picture_book['title']}",
    "{$picture_book['author']}",
    "{$picture_book['publisher']}"
)
EOT;
    $result = mysqli_query($link, $sql);
    if ($result) {
        echo '登録が完了しました' . PHP_EOL;
    } else {
        echo 'Error: データの追加に失敗しました' . PHP_EOL;
        echo 'Debugging Error:' . mysqli_error($link) . PHP_EOL;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $picture_book = [
        'title' => $_POST['title'],
        'author' => $_POST['author'],
        'publisher' => $_POST['publisher']
    ];
    // バリデーションする
    $link = dbConnect();
    createPictureBook($link, $picture_book);
    mysqli_close($link);
}
