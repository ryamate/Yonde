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
    $dbc = new Dbc;
    $login_user = $dbc->getLoginUser($user);
    $_SESSION = $login_user;
    $_SESSION['time'] = time();

    $stored_picture_books = $dbc->listStoredPictureBooks($login_user);
} else {
    header('Location: login.php');
    exit;
}

// var_export($stored_picture_books);

$title = 'よんで-Yonde-絵本棚';
$content = __DIR__ . '/views/bookshelf.php';
include __DIR__ . '/views/layout.php';
