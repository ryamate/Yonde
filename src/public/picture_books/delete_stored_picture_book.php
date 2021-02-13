<?php

declare(strict_types=1);

require_once __DIR__ . '/../../lib/escape.php';
require_once __DIR__ . '/../../lib/picture_book.php';

session_start();

if (isset($_SESSION['id'])) {
    $login_user_id = $_SESSION['id'];
    $stored_picture_book_id = $_POST['stored_picture_book_id'];
    $picture_book_model = new PictureBook;
    $picture_book_model->deleteStoredPictureBook($login_user_id, $stored_picture_book_id);
    header("Location: ../bookshelf.php");
    exit();
}
