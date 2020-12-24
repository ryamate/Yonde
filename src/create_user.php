<?php
session_start();
require_once __DIR__ . '/lib/mysqli.php';
require_once __DIR__ . '/lib/escape.php';

function createFamily($link)
{
    $sql = <<<EOT
    INSERT INTO families (
        created_at
    )VALUES (
        NOW()
    )
    EOT;
    $result = mysqli_query($link, $sql);
    if ($result) {
        echo '追加完了 test_family' . PHP_EOL;
    } else {
        echo 'Error: 追加失敗 test_family' . PHP_EOL;
        echo 'Debugging Error:' . mysqli_error($link) . PHP_EOL;
    }
}

function createUser($link, $user)
{

    $sql = "SELECT id FROM users WHERE user_name = '{$user['user_name']}'";
    $result = mysqli_query($link, $sql);
    $family_id = mysqli_fetch_assoc($result);

    mysqli_free_result($result);

    $sql = <<<EOT
INSERT INTO users (
    family_id,
    user_name,
    email,
    password,
    user_image_path,
    created_at
)VALUES (
    "{$family_id}",
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
        'password' => sha1($_SESSION['join']['password']),
        'user_image_path' => $_SESSION['join']['image']
    ];
    $link = dbConnect();
    createFamily($link);
    createUser($link, $user);
    unset($_SESSION['join']);
    mysqli_close($link);
    header("Location: complete_signup.php");
    exit();
}

$title = 'よんで-Yonde-新規登録';
$content = __DIR__ . '/views/check_signup.php';
include __DIR__ . '/views/layout_before_login.php';
