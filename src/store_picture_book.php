<?php

session_start();

require_once __DIR__ . '/lib/escape.php';
require_once __DIR__ . '/lib/db_connect.php';

if (!isset($_REQUEST['action'])) {
    $_REQUEST = ['action' => ''];
}
if ($_REQUEST['action'] === 'store' && $_SERVER['REQUEST_METHOD'] === 'POST') {

    $read_status = '';
    if (array_key_exists('read_status', $_POST)) {
        $read_status = $_POST['read_status'];
    }

    $stored_picture_book = [
        'google_books_id' => $_POST['google_books_id'],
        'five_star_rating' => (int)$_POST['five_star_rating'],
        'read_status' => $read_status,
        'summary' => $_POST['summary'],
    ];
    // バリデーションする
    $dbc = new Dbc;
    $picture_book_id = $dbc->getPictureBookId($stored_picture_book);
    $stored_picture_book = array_merge($picture_book_id, $stored_picture_book);

    $user_id = $_SESSION['id'];
    $dbc->storePictureBook($stored_picture_book, $user_id);
    header("Location: bookshelf.php");
    exit();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $picture_book = $_POST;
    // バリデーションする
    $dbc = new Dbc;
    $dbc->createPictureBook($picture_book);
    $stored_picture_book = [
        'google_books_id' => $picture_book['google_books_id'],
        'picture_book_id' => '',
        'five_star_rating' => '',
        'read_status' => 'よみたい',
        'summary' => ''
    ];
    $errors = [];
}

$title = 'よんで-Yonde-詳細登録';
$content = __DIR__ . '/views/store_picture_book.php';
include __DIR__ . '/views/layout.php';
