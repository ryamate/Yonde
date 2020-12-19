<?php
session_start();
require_once __DIR__ . '/lib/mysqli.php';
require_once __DIR__ . '/lib/escape.php';

function createUser($link, $user)
{
    $sql = <<<EOT
INSERT INTO users (
    user_name,
    email,
    password,
    user_image_path,
    created_at
)VALUES (
    "{$user['user_name']}",
    "{$user['email']}",
    "{$user['password']}",
    "{$user['user_image_path']}",
    NOW()
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
    if (!isset($_SESSION['join']['image'])) {
        $_SESSION['join']['image'] = '';
    }
    $user = [
        'email' => $_SESSION['join']['email'],
        'user_name' => $_SESSION['join']['user_name'],
        'password' => password_hash($_SESSION['join']['password'], PASSWORD_DEFAULT),
        'user_image_path' => $_SESSION['join']['image']
    ];
    $link = dbConnect();
    createUser($link, $user);
    unset($_SESSION['join']);
    mysqli_close($link);
    header("Location: complete_registration.php");
    exit();
}

$title = 'よんで-Yonde-新規登録';
$content = __DIR__ . '/views/check_signup.php';
include __DIR__ . '/views/layout_before_login.php';
