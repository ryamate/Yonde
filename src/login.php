<?php

require_once __DIR__ . '/lib/escape.php';
require_once __DIR__ . '/lib/db_connect.php';

$user = [
    'email' => '',
    'user_name' => '',
    'password' => ''
];

$errors = [];

if (isset($_COOKIE['user_name'])) {
    $user['user_name'] = $_COOKIE['user_name'];
}

session_start();
//ログイン済みの場合
// if (isset($_SESSION['EMAIL'])) {
//     echo 'ようこそ' .  escape($_SESSION['EMAIL']) . "さん<br>";
//     echo "<a href='/logout.php'>ログアウトはこちら。</a>";
//     exit;
// }

$title = 'よんで-Yonde-ログイン';
$content = __DIR__ . '/views/login.php';
include __DIR__ . '/views/layout_before_login.php';
