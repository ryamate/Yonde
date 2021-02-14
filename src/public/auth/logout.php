<?php

declare(strict_types=1); // 厳密な型付けを宣言

session_start(); // 新しいセッションを開始、あるいは既存のセッションを再開する

$_SESSION = array(); // 全てのセッション変数を削除する
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}
session_destroy(); // セッションに登録されたデータを全て破棄する

setcookie('user_name', '', time() - 60 * 60);

$title = 'よんで-Yonde-ログイン';
$content = __DIR__ . '/../../views/auth/logout.php';
include __DIR__ . '/../../views/layout_before_login.php';
