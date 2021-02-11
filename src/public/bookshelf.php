<?php

declare(strict_types=1);

require_once __DIR__ . '/../lib/escape.php';
require_once __DIR__ . '/../lib/user.php';
require_once __DIR__ . '/../lib/picture_book.php';

//
if (!isset($_SESSION)) {
    session_start();
}

/**
 * ログインしているユーザーであるか判定し、ユーザー情報取得し、
 * 前回のsessionから１時間以上経過しているユーザーをログインページへ送る
 */
if (isset($_SESSION['user_name']) && $_SESSION['time'] + 60 * 60 > time()) {
    $user = [
        'user_name' => $_SESSION['user_name'],
    ];
    $user_model = new User;
    $login_user = $user_model->getLoginUser($user);
    $_SESSION = $login_user;
    // session時刻の更新
    $_SESSION['time'] = time();
} else {
    header('Location: ../auth/login.php');
    exit;
}

/**
 * リクエストされた表示するページ数を変数 $page へ代入し、ページングする
 */
if (isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
} else {
    $page = 1;
}
$picture_book_model = new PictureBook;
$start_no = ($page - 1) * $picture_book_model::MAX_DISPLAY_BOOKS;
$stored_picture_books = $picture_book_model->displayStoredPictureBooks($login_user, $page);
$stored_picture_book_count = count($stored_picture_books);
$max_page = ceil($stored_picture_book_count / $picture_book_model::MAX_DISPLAY_BOOKS);


$title = '絵本棚-Yonde-よんで';
$content = __DIR__ . '/../views/bookshelf.php';
$delete_stored_picture_book = __DIR__ . '/../views/picture_books/delete_stored_picture_book.php';
include __DIR__ . '/../views/layout.php';
