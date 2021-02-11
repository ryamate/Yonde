<?php

declare(strict_types=1);

require_once __DIR__ . '/../../lib/escape.php';
require_once __DIR__ . '/../../lib/user.php';
require_once __DIR__ . '/../../lib/picture_book.php';

session_start();

// エラーをnullにする（@$item["volumeInfo"]['authors']などに使用）
error_reporting(E_ALL);

$user = [
    'user_name' => $_SESSION['user_name'],
];
$user_model = new User;
$login_user = $user_model->getLoginUser($user);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $search_input = $_POST['search'];
    // バリデーション（半角スペース入れると取得できない→スペース削除）
    $data = "https://www.googleapis.com/books/v1/volumes?q='$search_input'&maxResults=40";
    $json = file_get_contents($data);
    $searched_books_array = json_decode($json, true);
    $searched_books = $searched_books_array["items"];

    $picture_book_model = new PictureBook;
    $stored_picture_books = $picture_book_model->getStoredPictureBookGoogleBooksId($login_user);

    if (isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) {
        $page = $_REQUEST['page'];
    } else {
        $page = 1;
    }

    $start_no = ($page - 1) * $picture_book_model::MAX_DISPLAY_BOOKS;
    $display_searched_books = array_slice($searched_books, $start_no, $picture_book_model::MAX_DISPLAY_BOOKS, true);

    $searched_books_count = count($searched_books);
    $max_page = ceil($searched_books_count / $picture_book_model::MAX_DISPLAY_BOOKS);
} else {
    $search_input = '';
}



$title = 'よんで-Yonde-絵本検索';
$content = __DIR__ . '/../../views/picture_books/search_picture_book.php';
include __DIR__ . '/../../views/layout.php';
