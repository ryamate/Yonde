<?php

const MAX = 10;

session_start();

require_once __DIR__ . '/lib/escape.php';
require_once __DIR__ . '/lib/db_connect.php';

// エラーをnullにする（@$item["volumeInfo"]['authors']などに使用）
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $search_input = $_POST['search'];
    // バリデーションする
    $data = "https://www.googleapis.com/books/v1/volumes?q='$search_input'&maxResults=40";
    $json = file_get_contents($data);
    $searched_books_array = json_decode($json, true);
    $searched_books = $searched_books_array["items"];

    $user = [
        'user_name' => $_SESSION['user_name'],
    ];
    $dbc = new Dbc;
    $login_user = $dbc->getLoginUser($user);
    $stored_picture_books = $dbc->getStoredPictureBookGoogleBooksId($login_user);

    if (isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) {
        $page = $_REQUEST['page'];
    } else {
        $page = 1;
    }

    $start_no = ($page - 1) * MAX;
    $display_searched_books = array_slice($searched_books, $start_no, MAX, true);

    $searched_books_count = count($searched_books);
    $max_page = ceil($searched_books_count / MAX);
} else {
    $search_input = '';
}



$title = '絵本検索';
$content = __DIR__ . '/views/search_picture_book.php';
include __DIR__ . '/views/layout.php';
