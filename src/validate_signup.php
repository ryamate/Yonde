<?php

require_once __DIR__ . '/lib/escape.php';
require_once __DIR__ . '/lib/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = [
        'email' => $_POST['email'],
        'user_name' => $_POST['user_name'],
        'password' => $_POST['password']
    ];
    $file_name = $_FILES['image']['name'];
    $dbc = new Dbc;
    $errors = $dbc->validateUserSignup($user, $file_name);
    if (!count($errors)) {
        session_start();
        $_SESSION['join'] = $_POST;
        if (!empty($file_name)) {
            $image = date('YmdHis') . $_FILES['image']['name'];
            //DB接続できたら $image = $_FILES['id']['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/images/user_picture/' . $image);
            $_SESSION['join']['image'] = $image;
        }
        header("Location: check_signup.php");
        exit();
    }
}

$title = 'よんで-Yonde-新規登録';
$content = __DIR__ . '/views/signup.php';
include __DIR__ . '/views/layout_before_login.php';
