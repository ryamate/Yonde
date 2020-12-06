<?php

require_once __DIR__ . '/lib/mysqli.php';

function createPictureBook($link, $picture_book)
{
    $sql = <<<EOT
INSERT INTO picture_books (
    picture_book_id,
    title,
    authors,
    published_date,
    thumbnail_uri
)VALUES (
    "{$picture_book['picture_book_id']}",
    "{$picture_book['title']}",
    "{$picture_book['authors']}",
    "{$picture_book['published_date']}",
    "{$picture_book['thumbnail_uri']}"
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
    // $picture_book = $_POST;
    $picture_book = [
        'picture_book_id' => (int)$_POST['picture_book_id'],
        'title' => $_POST['title'],
        'authors' => $_POST['authors'],
        'published_date' => $_POST['published_date'],
        'thumbnail_uri' => $_POST['thumbnail_uri']
    ];
    var_dump($picture_book);
    // バリデーションする
    $link = dbConnect();
    createPictureBook($link, $picture_book);
    mysqli_close($link);
    // header("Location: register_details.php");
}
