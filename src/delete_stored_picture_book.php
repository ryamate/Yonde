<?php

session_start();

require_once __DIR__ . '/lib/escape.php';
require_once __DIR__ . '/lib/db_connect.php';

if (isset($_SESSION['id'])) {
    $login_user_id = $_SESSION['id'];
    $stored_picture_book_id = $_POST['stored_picture_book_id'];
    $dbc = new Dbc;
    $dbc->deleteStoredPictureBook($login_user_id, $stored_picture_book_id);
    header("Location: bookshelf.php");
    exit();
}
