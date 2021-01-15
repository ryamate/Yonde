<?php

require_once __DIR__ . '/lib/escape.php';
require_once __DIR__ . '/lib/db_connect.php';
require_once __DIR__ . '/lib/user.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = [
        'email' => $_POST['email'],
        'user_name' => $_POST['user_name'],
        'password' => $_POST['password']
    ];
    $file_name = $_FILES['image']['name'];
    $user_model = new User;
    $errors = $user_model->validateUserSignup($user, $file_name);
    if (!count($errors)) {
        session_start();
        $_SESSION['join'] = $_POST;
        if (!empty($file_name)) {
            $image = date('Ymd') . $user['user_name'] . '_' . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/images/user_picture/' . $image);
            $_SESSION['join']['image'] = $image;
        }
        header("Location: check_signup.php");
        exit();
    }
} else {

    $user = [
        'email' => '',
        'user_name' => '',
        'password' => ''
    ];
    $errors = [];

    session_start();

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
}

$title = 'よんで-Yonde-新規登録';
$content = __DIR__ . '/views/signup.php';
include __DIR__ . '/views/layout_before_login.php';
