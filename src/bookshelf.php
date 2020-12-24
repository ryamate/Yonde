<?php

if (!isset($_SESSION)) {
    session_start();
}

require_once __DIR__ . '/lib/escape.php';
require_once __DIR__ . '/lib/mysqli.php';

function getUser($link, $user)
{
    $sql = "SELECT * FROM users WHERE user_name = '{$user['user_name']}' ";
    $result = mysqli_query($link, $sql);
    $login_user = mysqli_fetch_assoc($result);

    mysqli_free_result($result);

    return $login_user;
}

function listStoredPictureBooks($link, $login_user)
{

    $stored_picture_books = [];
    $sql = "SELECT s.id, s.picture_book_id, s.five_star_rating, s.read_status, s.possession, s.summary, p.title, p.authors, p.thumbnail_uri, p.published_date FROM stored_picture_books s JOIN picture_books p ON s.picture_book_id = p.id WHERE user_id = '{$login_user['id']}'";
    $results = mysqli_query($link, $sql);

    while ($stored_picture_book = mysqli_fetch_assoc($results)) {
        $stored_picture_books[] = $stored_picture_book;
    }

    mysqli_free_result($results);

    return $stored_picture_books;
}

if (isset($_SESSION['user_name']) && $_SESSION['time'] + 60 * 60 > time()) {
    $user = [
        'user_name' => $_SESSION['user_name'],
    ];
    $link = dbConnect();
    $login_user = getUser($link, $user);
    $_SESSION = $login_user;
    $_SESSION['time'] = time();
    $stored_picture_books = listStoredPictureBooks($link, $login_user);
} else {
    header('Location: login.php');
    exit;
}

$title = 'よんで-Yonde-絵本棚';
$content = __DIR__ . '/views/bookshelf.php';
include __DIR__ . '/views/layout.php';
