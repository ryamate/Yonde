<?php
const MAX = 10;

if (!isset($_SESSION)) {
    session_start();
}

require_once __DIR__ . '/lib/escape.php';
require_once __DIR__ . '/lib/db_connect.php';

if (isset($_SESSION['user_name']) && $_SESSION['time'] + 60 * 60 > time()) {
    $user = [
        'user_name' => $_SESSION['user_name'],
    ];
    $dbc = new Dbc;
    $login_user = $dbc->getLoginUser($user);
    $_SESSION = $login_user;
    $_SESSION['time'] = time();

    $stored_picture_books = $dbc->listStoredPictureBooks($login_user);

    if (isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) {
        $page = $_REQUEST['page'];
    } else {
        $page = 1;
    }

    $start_no = ($page - 1) * MAX;
    $display_data = array_slice($stored_picture_books, $start_no, MAX, true);

    $stored_picture_book_count = count($stored_picture_books);
    $max_page = ceil($stored_picture_book_count / MAX);
} else {
    header('Location: login.php');
    exit;
}

$title = 'よんで-Yonde-絵本棚';
$content = __DIR__ . '/views/bookshelf.php';
include __DIR__ . '/views/layout.php';
