<?php

if (!isset($_SESSION)) {
    session_start();
}

require_once __DIR__ . '/lib/escape.php';
require_once __DIR__ . '/lib/db_connect.php';

if (isset($_SESSION['user_name']) && $_SESSION['time'] + 60 * 60 > time()) {
    $user = [
        'user_name' => $_SESSION['user_name'],
    ];
    $dbc = new User;
    $login_user = $dbc->getLoginUser($user);
    $_SESSION = $login_user;
    $_SESSION['time'] = time();

    if (isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) {
        $page = $_REQUEST['page'];
    } else {
        $page = 1;
    }
    $start_no = ($page - 1) * $dbc::MAX_DISPLAY_BOOKS;
    $stored_picture_books = $dbc->displayStoredPictureBooks($login_user, $page);
    $stored_picture_book_count = count($stored_picture_books);
    $max_page = ceil($stored_picture_book_count / $dbc::MAX_DISPLAY_BOOKS);
} else {
    header('Location: login.php');
    exit;
}

$title = 'よんで-Yonde-絵本棚';
$content = __DIR__ . '/views/bookshelf.php';
include __DIR__ . '/views/layout.php';
