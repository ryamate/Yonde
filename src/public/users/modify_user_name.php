<?php

declare(strict_types=1);

require_once __DIR__ . '/../../lib/escape.php';
require_once __DIR__ . '/../../lib/user.php';

session_start(); // 既存のセッションを再開する


/**
 * 「よんでIDの変更」フォーム画面から POST されたら、バリデーション処理し、エラーがなければ、DBに接続・変更し、プロフィール設定画面へ遷移する。
 * もしくは、
 * profile_setting.php から遷移してきたら、新規で「よんでIDの変更」フォーム画面を表示する。
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $check_user = [
        'id' => $_SESSION['id'],
        'user_name' => $_SESSION['user_name'],
        'new_user_name' => $_POST['new_user_name'],
        'password' => $_POST['password']
    ];
    $user_model = new User;
    $errors = $user_model->validateModifyUsername($check_user);
    if (!count($errors)) {
        $checked_user = $check_user;
        $user_model->modifyUsername($checked_user);
        // user_name を上書きする
        $_SESSION['user_name'] = $checked_user['new_user_name'];

        // プロフィール設定画面へ遷移
        header("Location: profile_setting.php");
        exit();
    }
} else {
    // 未定義エラーを防止する
    $check_user = [
        'new_user_name' => '',
    ];
    $errors = [];
}

// HTMLで表示する
$login_user = [
    'user_name' => $_SESSION['user_name'],
    'user_image_path' => $_SESSION['user_image_path'],
];

$title = 'よんでID変更-Yonde-よんで';
$content = __DIR__ . '/../../views/users/modify_user_name.php';
include __DIR__ . '/../../views/layout.php';
