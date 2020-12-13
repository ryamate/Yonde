<?php

require_once __DIR__ . '/lib/mysqli.php';

function storePictureBook($link, $stored_picture_book)
{
    $sql = <<<EOT
INSERT INTO stored_picture_books (
    isbn_13,
    five_star_rating,
    read_status,
    review
)VALUES (
    "{$stored_picture_book['isbn_13']}",
    "{$stored_picture_book['five_star_rating']}",
    "{$stored_picture_book['read_status']}",
    "{$stored_picture_book['review']}"
)
EOT;
    $result = mysqli_query($link, $sql);
    if ($result) {
        // echo '登録が完了しました' . PHP_EOL;
        // var_dump($result);
    } else {
        echo 'Error: データの追加に失敗しました' . PHP_EOL;
        echo 'Debugging Error:' . mysqli_error($link) . PHP_EOL;
        // データが登録されている場合、変更に切り替える→それよりisbnが本棚登録ずみであることをバリデーションで弾く→弾くより入力変更に切り替える

    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $read_status = '';
    if (array_key_exists('read_status', $_POST)) {
        $read_status = $_POST['read_status'];
    }

    $stored_picture_book = [
        'isbn_13' => $_POST['isbn_13'],
        'five_star_rating' => (int)$_POST['five_star_rating'],
        'read_status' => $read_status,
        'review' => $_POST['review'],
    ];
    // バリデーションする
    $link = dbConnect();
    storePictureBook($link, $stored_picture_book);
    mysqli_close($link);
    include __DIR__ . '/index.php';
}
