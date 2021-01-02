<?php

session_start();

$_SESSION = array();
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
session_destroy();

setcookie('user_name', '', time() - 60 * 60);

$title = 'よんで-Yonde-ログイン';
$content = __DIR__ . '/views/logout.php';
include __DIR__ . '/views/layout_before_login.php';
