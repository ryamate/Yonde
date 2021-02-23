<?php

declare(strict_types=1); // 厳密な型付けを宣言

require_once __DIR__ . '/../../lib/escape.php';
require_once __DIR__ . '/../../lib/display_format.php';
require_once __DIR__ . '/../../lib/user.php';
require_once __DIR__ . '/../../lib/picture_book.php';

session_start(); // 新しいセッションを開始、あるいは既存のセッションを再開する

error_reporting(E_ALL); // エラーをnullにする（@$item["volumeInfo"]['authors']などに使用）

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login_user = [
        'id' => $_SESSION['id'],
    ];

    $search_input = $_POST['search'];
    // バリデーション（半角スペース入れると取得できない→スペース削除）
    $data = "https://www.googleapis.com/books/v1/volumes?q='$search_input'&maxResults=40";
    $json = file_get_contents($data);
    $searched_books_array = json_decode($json, true);
    $searched_books = $searched_books_array["items"];

    // 登録状況の表示（登録済みか未登録か）のために、DBより登録状況を取得
    $picture_book_model = new PictureBook;
    $stored_picture_books = $picture_book_model->getStoredPictureBookGoogleBooksId($login_user);

    // ページング
    if (isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) {
        $page = $_REQUEST['page'];
    } else {
        $page = 1;
    }

    $start_no = ($page - 1) * $picture_book_model::MAX_DISPLAY_BOOKS;

    // $display_searched_books = array_slice($searched_books, $start_no, $picture_book_model::MAX_DISPLAY_BOOKS, true);
    $transformation_searched_books = array_slice($searched_books, $start_no, $picture_book_model::MAX_DISPLAY_BOOKS, true);


    foreach ($transformation_searched_books as $item_number => $item) {
        $authors_array = @$item["volumeInfo"]["authors"];
        if ($authors_array !== null) {
            $authors = implode(",", $authors_array);
        } else {
            $authors = null;
        }

        $display_searched_books[] = [
            'google_books_id' => @$item["id"],
            'isbn_13' => @$item["volumeInfo"]["industryIdentifiers"][1]["identifier"],
            'title' =>  @$item["volumeInfo"]["title"],
            'authors' =>  $authors,
            'published_date' => @$item["volumeInfo"]["publishedDate"],
            'thumbnail_uri' => @$item["volumeInfo"]["imageLinks"]["thumbnail"],
            'description' => @$item["volumeInfo"]["description"],
        ];
    }

    $searched_books_count = count($searched_books);
    $max_page = ceil($searched_books_count / $picture_book_model::MAX_DISPLAY_BOOKS);
} else {
    $search_input = '';
}

$login_user = [
    'user_icon' => $_SESSION['user_icon'],
];


$title = 'よんで-Yonde-絵本検索';
$content = __DIR__ . '/../../views/picture_books/search_picture_book.php';
include __DIR__ . '/../../views/layout.php';
