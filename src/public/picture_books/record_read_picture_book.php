<?php

declare(strict_types=1); // 厳密な型付けを宣言

require_once __DIR__ . '/../../lib/escape.php';
require_once __DIR__ . '/../../lib/user.php';
require_once __DIR__ . '/../../lib/picture_book.php';

session_start(); // 新しいセッションを開始、あるいは既存のセッションを再開する

$user = [
    'user_name' => $_SESSION['user_name'],
];

/**
 * 「よみきかせの記録」フォーム画面から POST されたら、バリデーション処理し、エラーがなければ、DBに接続・変更し、本棚画面へ遷移する。
 * もしくは、
 * 本棚 から遷移してきたら、新規で「よみきかせの記録」フォーム画面を表示する。
 */
if (isset($_REQUEST['action'])) {
    if ($_REQUEST['action'] === 'modify' && $_SERVER['REQUEST_METHOD'] === 'POST') {

        $read_picture_book = [
            'stored_picture_book_id' => $_POST['stored_picture_book_id'],
            'family_id' => $_SESSION['family_id'],
            'user_id' => $_POST['user_id'],
            'child_id' => $_POST['child_id'],
            'read_date' => $_POST['read_date'],
            'memo' => $_POST['memo'],
        ];
        $picture_book_model = new PictureBook;
        $errors = $picture_book_model->validateRecordRead($read_picture_book);
        if (!count($errors)) {
            $picture_book_model->recordReadPictureBook($read_picture_book);
            // 絵本棚画面へ遷移
            header("Location: ../bookshelf.php");
            exit();
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    $read_picture_book = [
        'stored_picture_book_id' => $_POST['stored_picture_book_id'],
        'title' => $_POST['title'],
        'authors' => $_POST['authors'],
        'published_date' => $_POST['published_date'],
        'thumbnail_uri' => $_POST['thumbnail_uri'],
        'five_star_rating' => $_POST['five_star_rating'],
        'read_status' => $_POST['read_status'],
        'summary' => $_POST['summary'],
        'memo' => '',
    ];
    // ダミー値
    $family_members = [
        [
            'user_id' => $_SESSION['id'],
            'user_name' => $_SESSION['user_name'],
            'nickname' => $_SESSION['nickname'],
        ],
        [
            'user_id' => '2',
            'user_name' => 'partner',
            'nickname' => 'ゲストパートナー',
        ],
    ];
    // ダミー値
    $children = [
        [
            'child_id' => '1',
            'family_id' => '1',
            'child_name' => 'ゲストチャイルド',
            'child_birthday' => '',
        ],
        [
            'child_id' => '2',
            'family_id' => '1',
            'child_name' => 'ゲストチャイルド2',
            'child_birthday' => '',
        ],
    ];
}

// HTMLで表示する（layout.phpで使用）
$login_user = [
    'user_icon' => $_SESSION['user_icon'],
];

$title = 'よんで-Yonde-詳細編集';
$content = __DIR__ . '/../../views/picture_books/record_read_picture_book.php';
include __DIR__ . '/../../views/layout.php';
