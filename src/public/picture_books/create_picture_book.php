<?php

declare(strict_types=1);

require_once __DIR__ . '/../../lib/db_connect.php';
require_once __DIR__ . '/../../lib/picture_book.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $picture_book = $_POST;
    // バリデーションする
    $picture_book_model = new PictureBook;
    $picture_book_model->createPictureBook($picture_book);
    // include __DIR__ . '/store_picture_book.php';
    header("Location: store_picture_book.php");
}
