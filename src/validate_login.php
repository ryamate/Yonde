<?php

session_start();

require_once __DIR__ . '/lib/escape.php';
require_once __DIR__ . '/lib/mysqli.php';

function validateUserLogin($link, $user, $encoded_password)
{
    $sql = "SELECT * FROM users WHERE user_name = '{$user['user_name']}' AND password = '{$encoded_password}'";
    $result = mysqli_query($link, $sql);
    $registered_user = mysqli_fetch_assoc($result);

    mysqli_free_result($result);

    $errors = [];

    if (!strlen($user['user_name'])) {
        $errors['user_name'] = '*よんでID：入力願います。';
    }

    if (!strlen($user['password'])) {
        $errors['password'] = '*パスワード：入力願います。';
    }

    if (!$registered_user) {
        $errors['user'] = '*よんでID、パスワードを正しく入力願います。';
    }

    return $errors;
}

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
        $link = dbConnect();
        $errors = validateUserLogin($link, $user, $encoded_password);
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
