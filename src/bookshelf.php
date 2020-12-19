<?php

require_once __DIR__ . '/lib/escape.php';
require_once __DIR__ . '/lib/mysqli.php';

function listStoredPictureBooks($link)
{

    $stored_picture_books = [];
    $sql = "SELECT s.id, s.picture_book_id, s.five_star_rating, s.read_status, s.review, p.title, p.authors, p.thumbnail_uri, p.published_date FROM stored_picture_books s JOIN picture_books p ON s.picture_book_id = p.id";
    $results = mysqli_query($link, $sql);

    while ($stored_picture_book = mysqli_fetch_assoc($results)) {
        $stored_picture_books[] = $stored_picture_book;
    }

    mysqli_free_result($results);

    return $stored_picture_books;
}

$link = dbConnect();
$stored_picture_books = listStoredPictureBooks($link);

$title = 'よんで-Yonde-絵本棚';
$content = __DIR__ . '/views/bookshelf.php';
include __DIR__ . '/views/layout.php';
