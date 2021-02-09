<?php

declare(strict_types=1);

require_once __DIR__ . '/../lib/escape.php';
require_once __DIR__ . '/../lib/db_connect.php';
require_once __DIR__ . '/../lib/user.php';
require_once __DIR__ . '/../lib/picture_book.php';

//
if (!isset($_SESSION)) {
    session_start();
}
/**
 *
 */
if (isset($_SESSION['user_name']) && $_SESSION['time'] + 60 * 60 > time()) {
    $user = [
        'user_name' => $_SESSION['user_name'],
    ];
    $user_model = new User;
    $login_user = $user_model->getLoginUser($user);
    $_SESSION = $login_user;
    $_SESSION['time'] = time();

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
} else {
    header('Location: ../auth/login.php');
    exit;
}

$title = 'よんで-Yonde-絵本棚';
$content = __DIR__ . '/../views/bookshelf.php';
include __DIR__ . '/../views/layout.php';
