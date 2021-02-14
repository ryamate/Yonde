<?php

declare(strict_types=1); // 厳密な型付けを宣言

require_once __DIR__ . '/../../lib/db_connect.php';
require_once __DIR__ . '/../../lib/picture_book.php';

session_start(); // 新しいセッションを開始、あるいは既存のセッションを再開する

/**
 * 絵本を追加する
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $picture_book = $_POST;
    // issue: バリデーションする
    $picture_book_model = new PictureBook;
    $picture_book_model->createPictureBook($picture_book);
    header("Location: store_picture_book.php");
}
