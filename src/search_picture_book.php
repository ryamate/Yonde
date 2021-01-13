<?php

session_start();

require_once __DIR__ . '/lib/escape.php';
require_once __DIR__ . '/lib/db_connect.php';

// エラーをnullにする（@$item["volumeInfo"]['authors']などに使用）
error_reporting(E_ALL);

$user = [
    'user_name' => $_SESSION['user_name'],
];
$dbc = new Dbc;
$login_user = $dbc->getLoginUser($user);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $search_input = $_POST['search'];
    // バリデーション（半角スペース入れると取得できない→スペース削除）
    $data = "https://www.googleapis.com/books/v1/volumes?q='$search_input'&maxResults=40";
    $json = file_get_contents($data);
    $searched_books_array = json_decode($json, true);
    $searched_books = $searched_books_array["items"];

    $stored_picture_books = $dbc->getStoredPictureBookGoogleBooksId($login_user);

    if (isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) {
        $page = $_REQUEST['page'];
    } else {
        $page = 1;
    }

    $start_no = ($page - 1) * $dbc::MAX_DISPLAY_BOOKS;
    $display_searched_books = array_slice($searched_books, $start_no, $dbc::MAX_DISPLAY_BOOKS, true);

    $searched_books_count = count($searched_books);
    $max_page = ceil($searched_books_count / $dbc::MAX_DISPLAY_BOOKS);
} else {
    $search_input = '';
}



$title = '絵本検索';
$content = __DIR__ . '/views/search_picture_book.php';
include __DIR__ . '/views/layout.php';
