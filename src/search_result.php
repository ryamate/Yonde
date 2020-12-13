<?php

// エラーをnullにする（@$item["volumeInfo"]['authors']などに使用）
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $search_input = $_POST['search'];
    // バリデーションする
    $data = "https://www.googleapis.com/books/v1/volumes?q='$search_input'&maxResults=40";
    $json = file_get_contents($data);
    // trueを第二引数にすると配列型、falseだとオブジェクト型
    $searched_books_array = json_decode($json, true);

    $searched_books = $searched_books_array["items"];
}
$title = '絵本検索';
$content = __DIR__ . '/views/search_result.php';
include __DIR__ . '/views/layout.php';
