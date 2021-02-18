<?php

declare(strict_types=1); // 厳密な型付けを宣言

require_once __DIR__ . '/../../lib/escape.php';
require_once __DIR__ . '/../../lib/user.php';
require_once __DIR__ . '/../../lib/picture_book.php';

session_start(); // 新しいセッションを開始、あるいは既存のセッションを再開する

$user = [
    'user_name' => $_SESSION['user_name'],
];
$errors = [];
$user_model = new User;
$login_user = $user_model->getLoginUser($user);

/**
 * 「登録情報の編集」フォーム画面から POST されたら、バリデーション処理し、エラーがなければ、DBに接続・変更し、本棚画面へ遷移する。
 * もしくは、
 * 本棚 から遷移してきたら、新規で「登録情報の編集」フォーム画面を表示する。
 */
if (isset($_REQUEST['action'])) {
    if ($_REQUEST['action'] === 'modify' && $_SERVER['REQUEST_METHOD'] === 'POST') {

        $stored_picture_book = [
            'id' => $_POST['stored_picture_book_id'],
            'five_star_rating' => $_POST['five_star_rating'],
            'read_status' => $_POST['read_status'],
            'summary' => $_POST['summary'],
        ];
        // issue: バリデーション処理
        $picture_book_model = new PictureBook;
        $picture_book_model->modifyStorePictureBook($stored_picture_book);
        header("Location: ../bookshelf.php");
        exit();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $read_picture_book = [
        'id' => $_POST['stored_picture_book_id'],
        'title' => $_POST['title'],
        'authors' => $_POST['authors'],
        'published_date' => $_POST['published_date'],
        'thumbnail_uri' => $_POST['thumbnail_uri'],
        'five_star_rating' => $_POST['five_star_rating'],
        'read_status' => $_POST['read_status'],
        'summary' => $_POST['summary'],
        'memo' => '',
    ];
}

$title = 'よんで-Yonde-詳細編集';
$content = __DIR__ . '/../../views/picture_books/record_read_picture_book.php';
include __DIR__ . '/../../views/layout.php';
