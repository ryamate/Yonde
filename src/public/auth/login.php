<?php

declare(strict_types=1);

require_once __DIR__ . '/../../lib/escape.php';
require_once __DIR__ . '/../../lib/db_connect.php';
require_once __DIR__ . '/../../lib/user.php';

session_start();

/**
 * ログインフォーム画面からのPOSTであれば、入力内容でログイン処理、
 * それ以外は、ログインフォーム画面を表示する
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_REQUEST['action'])) {
        $_REQUEST = ['action' => ''];
    }
    /**
     * ゲストユーザー情報を配列にいれる、
     * もしくは、POSTされたユーザー情報を配列にいれ、バリデーション処理する
     */
    if ($_REQUEST['action'] === 'guest_user_login') {
        $user = [
            'email' => 'guest@guest',
            'user_name' => 'Guest',
            'password' => 'guest_user1'
        ];
    } else {
        $user = [
            'user_name' => $_POST['user_name'],
            'password' => $_POST['password']
        ];
        $encoded_password = sha1($user['password']);
        $dbc = new User;
        $errors = $dbc->validateUserLogin($user, $encoded_password);
    }

    /**
     * バリデーションエラーがなければ、本棚ページへ遷移し、
     * エラーがあれば、ログインフォーム画面にとどまる
     */
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
