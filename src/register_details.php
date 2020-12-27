<?php

require_once __DIR__ . '/lib/escape.php';

$stored_picture_book = [
    'isbn_13' => $picture_book['isbn_13'],
    'picture_book_id' => '',
    'five_star_rating' => '',
    'read_status' => 'よみたい',
    'summary' => ''
];

$errors = [];

$title = 'よんで-Yonde-詳細登録';
$content = __DIR__ . '/views/register_details.php';
include __DIR__ . '/views/layout.php';
