<?php

session_start();

require_once __DIR__ . '/lib/escape.php';
require_once __DIR__ . '/lib/db_connect.php';

$errors = [];

$user = [
    'user_name' => $_SESSION['user_name'],
];
$dbc = new Dbc;
$login_user = $dbc->getLoginUser($user);

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
    $dbc->modifyStorePictureBook($stored_picture_book);
    header("Location: bookshelf.php");
    exit();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stored_picture_book = $_POST;
}

$title = 'よんで-Yonde-詳細編集';
$content = __DIR__ . '/views/modify_stored_picture_book.php';
include __DIR__ . '/views/layout.php';
