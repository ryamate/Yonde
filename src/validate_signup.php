<?php

require_once __DIR__ . '/lib/escape.php';
require_once __DIR__ . '/lib/mysqli.php';

function validateUser($link, $user, $file_name, $entered_email)
{
    $sql = "SELECT * FROM users WHERE email = '{$user['email']}'";
    $result = mysqli_query($link, $sql);
    $registered_email = mysqli_fetch_assoc($result);

    $sql = "SELECT * from users where user_name = '{$user['user_name']}'";
    $result = mysqli_query($link, $sql);
    $registered_user_name = mysqli_fetch_assoc($result);

    mysqli_free_result($result);

    $errors = [];

    if (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = '*メールアドレス：入力された値が正しくありません。';
    } elseif (isset($registered_email['email'])) {
        $errors['email'] = '*メールアドレス：登録済みのメールアドレスです。';
    }

    if (!strlen($user['user_name'])) {
        $errors['user_name'] = '*よんでID：入力願います。';
    } elseif (strlen($user['user_name']) > 16) {
        $errors['user_name'] = '*よんでID：16文字以内 で入力願います。';
    } elseif (isset($registered_user_name['user_name'])) {
        $errors['user_name'] = '*よんでID："' . $registered_user_name['user_name'] . '"は、使用されています。';
    }

    if (!preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $user['password'])) {
        $errors['password'] =  '*パスワード：半角英数字をそれぞれ1文字以上含んだ8文字以上で設定願います。';
    }

    if (!empty($file_name)) {
        $ext = substr($file_name, -3);
        if ($ext !== 'gif' && $ext !== 'jpg' && $ext !== 'png') {
            $errors['image'] = '* プロフィール画像：「.gif」または「.jpg」「.png」のファイルをアップロード願います。';
        }
    }

    return $errors;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = [
        'email' => $_POST['email'],
        'user_name' => $_POST['user_name'],
        'password' => $_POST['password']
    ];
    $file_name = $_FILES['image']['name'];
    $entered_email = $user['email'];
    $link = dbConnect();
    $errors = validateUser($link, $user, $file_name, $entered_email);
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
