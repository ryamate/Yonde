<?php

declare(strict_types=1); // 厳密な型付けを宣言

require_once __DIR__ . '/../../lib/escape.php';
require_once __DIR__ . '/../../lib/user.php';

session_start(); // 新しいセッションを開始、あるいは既存のセッションを再開する

/**
 * 「ニックネームの変更」フォーム画面から POST されたら、バリデーション処理し、エラーがなければ、DBに接続・変更し、プロフィール設定画面へ遷移する。
 * もしくは、
 * profile_setting.php から遷移してきたら、新規で「ニックネームの変更」フォーム画面を表示する。
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $check_user = [
        'id' => $_SESSION['id'],
        'nickname' => $_SESSION['nickname'],
        'new_nickname' => $_POST['new_nickname'],
    ];
    $user_model = new User;
    $errors = $user_model->validateModifyNickname($check_user);
    if (!count($errors)) {
        $checked_user = $check_user;
        $user_model->modifyNickname($checked_user);
        // nickname を上書きする
        $_SESSION['nickname'] = $checked_user['new_nickname'];

        // プロフィール設定画面へ遷移
        header("Location: profile_setting.php");
        exit();
    }
} else {
    // 未定義エラーを防止する
    $check_user = [
        'new_nickname' => '',
    ];
    $errors = [];
}

// HTMLで表示する
$login_user = [
    'user_name' => $_SESSION['user_name'],
    'nickname' => $_SESSION['nickname'],
    'email' => $_SESSION['email'],
    'user_icon' => $_SESSION['user_icon'],
];

$title = 'ニックネーム変更-Yonde-よんで';
$content = __DIR__ . '/../../views/users/modify_nickname.php';
include __DIR__ . '/../../views/layout.php';
