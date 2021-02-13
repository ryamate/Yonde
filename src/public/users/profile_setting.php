<?php

declare(strict_types=1);

require_once __DIR__ . '/../../lib/escape.php';
require_once __DIR__ . '/../../lib/user.php';

session_start(); // 既存のセッションを再開

/**
 * 「プロフィール設定」フォーム画面から POST されたら、バリデーション処理し、エラーがなければ、DBに接続・変更し、プロフィール設定画面へ遷移する。
 * もしくは、
 * 各画面から遷移してきたら、新規で「プロフィール設定」フォーム画面を表示する。
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login_user = [
        'id' => $_SESSION['id'],
        'new_introduction' => $_POST['new_introduction'],
    ];
    $user_model = new User;
    $errors = $user_model->validateModifyIntroduction($login_user);
    if (!count($errors)) {
        $user_model->modifyIntroduction($login_user);
        // introduction を上書きする
        $_SESSION['introduction'] = $login_user['new_introduction'];

        // プロフィール設定画面へ遷移
        header("Location: profile_setting.php");
        exit();
    }
} else {
    $errors = [];
}

// HTMLで表示する
$login_user = [
    'user_name' => $_SESSION['user_name'],
    'nickname' => $_SESSION['nickname'],
    'user_icon' => $_SESSION['user_icon'],
    'introduction' => $_SESSION['introduction'],
];

$title = 'プロフィール設定-Yonde-よんで';
$content = __DIR__ . '/../../views/users/profile_setting.php';
include __DIR__ . '/../../views/layout.php';
