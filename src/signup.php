<?php

require_once __DIR__ . '/lib/escape.php';
require_once __DIR__ . '/lib/mysqli.php';

$user = [
    'email' => '',
    'user_name' => '',
    'password' => ''
];

$errors = [];

session_start();
//ログイン済みの場合
// if (isset($_SESSION['user_name'])) {
//     echo 'ようこそ' .  escape($_SESSION['user_name']) . "さん<br>";
//     echo "<a href='/logout.php'>ログアウトはこちら。</a>";
//     exit;
// }

if (!isset($_REQUEST['action'])) {
    $_REQUEST = ['action' => ''];
}
if ($_REQUEST['action'] === 'rewrite' && isset($_SESSION['join'])) {
    $_POST = $_SESSION['join'];
    $user = [
        'email' => $_POST['email'],
        'user_name' => $_POST['user_name'],
        'password' => $_POST['password']
    ];
}

$title = 'よんで-Yonde-新規登録';
$content = __DIR__ . '/views/signup.php';
include __DIR__ . '/views/layout_before_login.php';
