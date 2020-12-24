<?php

session_start();

require_once __DIR__ . '/lib/mysqli.php';

function getPictureBookId($link, $stored_picture_book)
{
    $sql = "SELECT id FROM picture_books where isbn_13 = '{$stored_picture_book['isbn_13']}'";
    $results = mysqli_query($link, $sql);
    $picture_book_id = mysqli_fetch_assoc($results);

    mysqli_free_result($results);

    return $picture_book_id;
}

function storePictureBook($link, $stored_picture_book, $user_id)
{
    $sql = <<<EOT
INSERT INTO stored_picture_books (
    picture_book_id,
    user_id,
    five_star_rating,
    read_status,
    summary,
    created_at
)VALUES (
    "{$stored_picture_book['id']}",
    "{$user_id}",
    "{$stored_picture_book['five_star_rating']}",
    "{$stored_picture_book['read_status']}",
    "{$stored_picture_book['summary']}",
    NOW()
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
        'summary' => $_POST['summary'],
    ];
    // バリデーションする
    $link = dbConnect();
    $picture_book_id = getPictureBookId($link, $stored_picture_book);
    $stored_picture_book = array_merge($picture_book_id, $stored_picture_book);

    $user_id = $_SESSION['id'];
    $link = dbConnect();
    storePictureBook($link, $stored_picture_book, $user_id);
    mysqli_close($link);
    include __DIR__ . '/bookshelf.php';
}
