<?php

declare(strict_types=1);

require_once __DIR__ . '/../../lib/escape.php';
require_once __DIR__ . '/../../lib/user.php';
require_once __DIR__ . '/../../lib/picture_book.php';

session_start();

/**
 * ログインユーザー情報をuserテーブルから取得する
 */
$user = [
    'user_name' => $_SESSION['user_name'],
];
$user_model = new User;
$login_user = $user_model->getLoginUser($user);

if (!isset($_REQUEST['action'])) {
    $_REQUEST = ['action' => ''];
}
/**
 *
 */
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
    // issue: バリデーション処理する
    $picture_book_model = new PictureBook;
    $picture_book_id = $picture_book_model->getPictureBookId($stored_picture_book);
    $stored_picture_book = array_merge($picture_book_id, $stored_picture_book);

    $user_id = $_SESSION['id'];
    $picture_book_model->storePictureBook($stored_picture_book, $login_user);
    header("Location: ../bookshelf.php");
    exit();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $picture_book = $_POST;
    $picture_book_model = new PictureBook;
    $registered_google_books_id = $picture_book_model->validateCreatePictureBook($picture_book);
    if (!isset($registered_google_books_id['google_books_id'])) {
        $picture_book_model->createPictureBook($picture_book);
    }
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
$content = __DIR__ . '/../../views/picture_books/store_picture_book.php';
include __DIR__ . '/../../views/layout.php';
