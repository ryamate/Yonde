<?php

session_start();

require_once __DIR__ . '/lib/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $read_status = '';
    if (array_key_exists('read_status', $_POST)) {
        $read_status = $_POST['read_status'];
    }

    $stored_picture_book = [
        'isbn_13' => $_POST['isbn_13'],
        'five_star_rating' => (int)$_POST['five_star_rating'],
        'read_status' => $read_status,
        'summary' => $_POST['summary'],
    ];
    // バリデーションする
    $dbc = new Dbc;
    $picture_book_id = $dbc->getPictureBookId($stored_picture_book);
    $stored_picture_book = array_merge($picture_book_id, $stored_picture_book);

    $user_id = $_SESSION['id'];
    $dbc->storePictureBook($stored_picture_book, $user_id);
    header("Location: bookshelf.php");
    exit();
}
