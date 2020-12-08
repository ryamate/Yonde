<?php

$title = '詳細登録';

$stored_picture_book = [
    'isbn_13' => $picture_book['isbn_13'],
    'picture_book_id' => '',
    'five_star_rating' => '',
    'read_status' => 'よみたい',
    'review' => ''
];

$errors = [];

$content = __DIR__ . '/views/register_details.php';
include __DIR__ . '/views/layout.php';
