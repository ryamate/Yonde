<?php

require_once __DIR__ . '/lib/escape.php';
require_once __DIR__ . '/lib/mysqli.php';

function listStoredPictureBooks($link)
{

    $stored_picture_books = [];
    $sql = "SELECT s.stored_picture_book_id, s.isbn_13, s.five_star_rating, s.read_status, s.review, p.title, p.authors, p.thumbnail_uri, p.published_date FROM stored_picture_books s JOIN picture_books p ON s.isbn_13 = p.isbn_13";
    $results = mysqli_query($link, $sql);

    while ($stored_picture_book = mysqli_fetch_assoc($results)) {
        $stored_picture_books[] = $stored_picture_book;
    }

    mysqli_free_result($results);

    return $stored_picture_books;
}

$link = dbConnect();
$stored_picture_books = listStoredPictureBooks($link);

$title = '読書ログ一覧';
$content = __DIR__ . '/views/index.php';
include __DIR__ . '/views/layout.php';
