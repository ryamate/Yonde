<?php

declare(strict_types=1); // 厳密な型付けを宣言

require_once __DIR__ . '/../../lib/escape.php';
require_once __DIR__ . '/../../lib/user.php';

session_start(); // 新しいセッションを開始、あるいは既存のセッションを再開する

/**
 * ログインフォーム画面からのPOSTであれば、入力内容でログイン処理、
 * それ以外は、ログインフォーム画面を表示する。
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_REQUEST['action'])) {
        $_REQUEST = ['action' => ''];
    }
    /**
     * ゲストユーザー情報を配列にいれ、ゲストユーザーでログイン処理する。
     * もしくは、
     * POSTされたユーザー情報を配列にいれ、バリデーション処理し、エラーがなければ、ログイン処理する。
     */
    if ($_REQUEST['action'] === 'guest_user_login') {
        $user = [
            'email' => 'guest@guest',
            'user_name' => 'guest',
            'password' => 'guest_user1'
        ];
        $errors = [];
    } else {
        $user = [
            'user_name' => $_POST['user_name'],
            'password' => $_POST['password']
        ];
        $user_model = new User;
        $errors = $user_model->validateUserLogin($user);
    }

    // エラーがなければ、本棚ページへ遷移し、エラーがあれば、ログインフォーム画面にとどまる。
    if (!count($errors)) {
        session_regenerate_id(true);
        $_SESSION['user_name'] = $user['user_name'];
        $_SESSION['time'] = time();
        if ($_POST['save'] === 'on') {
            setcookie('user_name', $_POST['user_name'], time() + 60 * 60 * 24 * 14);
        }
        header("Location: ../bookshelf.php");
        exit();
    }
} else {
    // 未定義エラーを防止する
    $user = [
        'email' => '',
        'user_name' => '',
        'password' => ''
    ];
    $errors = [];

    /**
     * 新規登録後、はじめてのログイン時、ID入力済みの状態にする
     * もしくは、ログイン情報記録のCOOKIEがあれば、COOKIEのID入力済みの状態にする
     */
    if (isset($_SESSION['first_login']['user_name'])) {
        $user['user_name'] = $_SESSION['first_login']['user_name'];
    } elseif (isset($_COOKIE['user_name'])) {
        $user['user_name'] = $_COOKIE['user_name'];
    }
}

$title = 'よんで-Yonde-ログイン';
$content = __DIR__ . '/../../views/auth/login.php';
include __DIR__ . '/../../views/layout_before_login.php';
