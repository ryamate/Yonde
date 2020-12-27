<?php

require_once __DIR__ . '/lib/escape.php';

session_start();
if (!isset($_SESSION['join'])) {
    header('Location: index.php');
    exit();
}

$title = 'よんで-Yonde-新規登録';
$content = __DIR__ . '/views/check_signup.php';
include __DIR__ . '/views/layout_before_login.php';
