<?php

declare(strict_types=1); // 厳密な型付けを宣言

require_once __DIR__ . '/../../lib/escape.php';
require_once __DIR__ . '/../../lib/user.php';

session_start(); // 新しいセッションを開始、あるいは既存のセッションを再開する

/**
 * 「メールアドレスの変更」フォーム画面から POST されたら、バリデーション処理し、エラーがなければ、DBに接続・変更し、プロフィール設定画面へ遷移する。
 * もしくは、
 * 遷移してきたら、新規で「メールアドレスの変更」フォーム画面を表示する。
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $check_user = [
        'id' => $_SESSION['id'],
        'user_name' => $_SESSION['user_name'],
        'email' => $_SESSION['email'],
        'new_email' => $_POST['new_email'],
        'password' => $_POST['password']
    ];
    $user_model = new User;
    $errors = $user_model->validateModifyEmail($check_user);
    if (!count($errors)) {
        $checked_user = $check_user;
        $user_model->modifyEmail($checked_user);
        // email を上書きする
        $_SESSION['email'] = $checked_user['new_email'];

        // プロフィール設定画面へ遷移
        header("Location: modify_nickname.php");
        exit();
    }
} else {
    // 未定義エラーを防止する
    $check_user = [
        'new_email' => '',
    ];
    $errors = [];
}

// HTMLで表示する
$login_user = [
    'email' => $_SESSION['email'],
    'user_icon' => $_SESSION['user_icon'],
];

$title = 'メールアドレス変更-Yonde-よんで';
$content = __DIR__ . '/../../views/users/modify_email.php';
include __DIR__ . '/../../views/layout.php';
