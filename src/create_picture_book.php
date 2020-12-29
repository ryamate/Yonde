<?php

session_start();

require_once __DIR__ . '/lib/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $picture_book = $_POST;
    // バリデーションする
    $dbc = new Dbc;
    $dbc->createPictureBook($picture_book);
    // include __DIR__ . '/store_picture_book.php';
    header("Location: store_picture_book.php");
}
