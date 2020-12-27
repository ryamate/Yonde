<?php
session_start();
require_once __DIR__ . '/lib/escape.php';
require_once __DIR__ . '/lib/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['join']['image'])) {
        $_SESSION['join']['image'] = '';
    }
    $user = [
        'email' => $_SESSION['join']['email'],
        'user_name' => $_SESSION['join']['user_name'],
        'password' => sha1($_SESSION['join']['password']),
        'user_image_path' => $_SESSION['join']['image']
    ];
    $dbc = new Dbc;
    $dbc->createUser($user);
    unset($_SESSION['join']);
    header("Location: complete_signup.php");
    exit();
}

$title = 'よんで-Yonde-新規登録';
$content = __DIR__ . '/views/check_signup.php';
include __DIR__ . '/views/layout_before_login.php';
