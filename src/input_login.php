<?php

require_once __DIR__ . '/lib/escape.php';
require_once __DIR__ . '/lib/mysqli.php';

session_start();
//ログイン済みの場合
if (isset($_SESSION['EMAIL'])) {
    echo 'ようこそ' .  escape($_SESSION['EMAIL']) . "さん<br>";
    echo "<a href='/logout.php'>ログアウトはこちら。</a>";
    exit;
}

$title = 'よんで-Yonde-ログイン';
$content = __DIR__ . '/views/input_login.php';
include __DIR__ . '/views/layout_before_login.php';
