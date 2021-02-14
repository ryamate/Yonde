<?php

declare(strict_types=1); // 厳密な型付けを宣言

require_once __DIR__ . '/../../lib/escape.php';
require_once __DIR__ . '/../../lib/picture_book.php';

session_start(); // 新しいセッションを開始、あるいは既存のセッションを再開する

/**
 * 登録済み絵本を削除する
 */
if (isset($_SESSION['id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $login_user = [
        'id' => $_SESSION['id'],
    ];
    $stored_picture_book = [
        'id' => $_POST['stored_picture_book_id'],
    ];
    $picture_book_model = new PictureBook;
    $picture_book_model->deleteStoredPictureBook($login_user, $stored_picture_book);
    header("Location: ../bookshelf.php");
    exit();
}
