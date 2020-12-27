<?php

session_start();

require_once __DIR__ . '/lib/escape.php';
require_once __DIR__ . '/lib/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_REQUEST['action'])) {
        $_REQUEST = ['action' => ''];
    }
    if ($_REQUEST['action'] === 'test_user_login') {
        $user = [
            'email' => 'test@test',
            'user_name' => 'てすと',
            'password' => 'test_user'
        ];
        $errors = [];
    } else {
        $user = [
            'user_name' => $_POST['user_name'],
            'password' => $_POST['password']
        ];
        $encoded_password = sha1($user['password']);
        $dbc = new Dbc;
        $errors = $dbc->validateUserLogin($user, $encoded_password);
    }
    if (!count($errors)) {
        session_regenerate_id(true);
        $_SESSION['user_name'] = $user['user_name'];
        $_SESSION['time'] = time();
        if ($_POST['save'] === 'on') {
            setcookie('user_name', $_POST['user_name'], time() + 60 * 60 * 24 * 14);
        }
        header("Location: bookshelf.php");
        exit();
    }
}

$title = 'よんで-Yonde-ログイン';
$content = __DIR__ . '/views/login.php';
include __DIR__ . '/views/layout_before_login.php';
