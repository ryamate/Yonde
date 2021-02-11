<?php

declare(strict_types=1);

require_once __DIR__ . '/../../lib/escape.php';
require_once __DIR__ . '/../../lib/user.php';
require_once __DIR__ . '/../../lib/picture_book.php';

//〜〜のため
session_start();

//〜〜のため
$errors = [];
$user = [
    'user_name' => $_SESSION['user_name'],
];
$user_model = new User;
$login_user = $user_model->getLoginUser($user);

if (!isset($_REQUEST['action'])) {
    $_REQUEST = ['action' => ''];
}
if ($_REQUEST['action'] === 'modify' && $_SERVER['REQUEST_METHOD'] === 'POST') {

    $read_status = '';
    if (array_key_exists('read_status', $_POST)) {
        $read_status = $_POST['read_status'];
    }

    $stored_picture_book = [
        'id' => $_POST['stored_picture_book_id'],
        'five_star_rating' => (int)$_POST['five_star_rating'],
        'read_status' => $read_status,
        'summary' => $_POST['summary'],
    ];
    // バリデーションする
    $picture_book_model = new PictureBook;
    $picture_book_model->modifyStorePictureBook($stored_picture_book);
    header("Location: ../bookshelf.php");
    exit();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stored_picture_book = $_POST;
}

$title = 'よんで-Yonde-詳細編集';
$content = __DIR__ . '/../../views/picture_books/modify_stored_picture_book.php';
include __DIR__ . '/../../views/layout.php';
