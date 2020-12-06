<?php

$title = '詳細登録';
$picture_book = $_POST;

$stored_picture_book = [
    'stored_picture_books_id' => '',
    'picture_book_id' => '',
    'five_star_rating' => '',
    'read_status' => 'よみたい',
    'review' => ''
];

$errors = [];
$content = __DIR__ . '/views/register_details.php';
include __DIR__ . '/views/layout.php';
