<?php
session_start();
require_once __DIR__ . '/lib/mysqli.php';

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
    if (!count($errors)) {
        $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
        $link = dbConnect();
        createUser($link, $user);
        mysqli_close($link);
        header("Location: bookshelf.php");
    }
}

$title = 'よんで-Yonde-新規登録';
$content = __DIR__ . '/views/create_user.php';
include __DIR__ . '/views/layout_before_login.php';
