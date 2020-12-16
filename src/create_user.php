<?php

require_once __DIR__ . '/lib/mysqli.php';

function validateUser($user)
{
    $errors = [];

    if (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'メールアドレス：入力された値が正しくありません。';
    }

    if (!strlen($user['user_name'])) {
        $errors['user_name'] = 'よんでID：未入力です。';
    } elseif (strlen($user['user_name']) > 16) {
        $errors['user_name'] = 'よんでID：16文字以内 で入力願います。';
    }

    if (!preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $user['password'])) {
        $errors['password'] =  'パスワード：半角英数字をそれぞれ1文字以上含んだ8文字以上で設定願います。';
    }

    return $errors;
}


function createUser($link, $user)
{
    $sql = <<<EOT
INSERT INTO users (
    email,
    user_name,
    password
)VALUES (
    "{$user['email']}",
    "{$user['user_name']}",
    "{$user['password']}"
)
EOT;
    $result = mysqli_query($link, $sql);
    if ($result) {
        echo '登録が完了しました' . PHP_EOL;
    } else {
        echo 'Error: データの追加に失敗しました' . PHP_EOL;
        echo 'Debugging Error:' . mysqli_error($link) . PHP_EOL;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = [
        'email' => $_POST['email'],
        'user_name' => $_POST['user_name'],
        'password' => $_POST['password']
    ];
    $errors = validateUser($user);
    if (!count($errors)) {
        $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
        $link = dbConnect();
        createUser($link, $user);
        mysqli_close($link);
        header("Location: bookshelf.php");
    }
}

$title = 'よんで-Yonde-新規登録';
$content = __DIR__ . '/views/signup.php';
include __DIR__ . '/views/layout_before_login.php';
