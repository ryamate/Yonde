<?php

declare(strict_types=1); // 厳密な型付けを宣言

require_once __DIR__ . '/../../lib/escape.php';
require_once __DIR__ . '/../../lib/user.php';

session_start(); // 新しいセッションを開始、あるいは既存のセッションを再開する

//新規会員登録フォームからの遷移ではない直接アクセスなどの場合、index.phpへ送る
if (!isset($_SESSION['join'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // フォーム画面からのPOSTであれば、処理開始
    if (!isset($_SESSION['join']['image'])) {
        $_SESSION['join']['image'] = '';
    }
    $user = [
        'email' => $_SESSION['join']['email'],
        'user_name' => $_SESSION['join']['user_name'],
        'nickname' => $_SESSION['join']['user_name'], // nickname の初期設定は、user_nameにする
        'password' => password_hash($_SESSION['join']['password'], PASSWORD_BCRYPT),
        'user_icon' => $_SESSION['join']['image']
    ];
    $user_model = new User;
    $user_model->createUser($user);
    unset($_SESSION['join']);
    $_SESSION['first_login']['user_name'] = $user['user_name'];
    header("Location: login.php");
    exit();
}

$title = 'よんで-Yonde-新規登録';
$content = __DIR__ . '/../../views/auth/check_signup.php';
include __DIR__ . '/../../views/layout_before_login.php';
