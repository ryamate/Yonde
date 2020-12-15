<?php

require_once __DIR__ . '/lib/mysqli.php';

function createUser($link, $user)
{
    $sql = <<<EOT
INSERT INTO users (
    email,
    password
)VALUES (
    "{$user['email']}",
    "{$user['password']}"
)
EOT;
    $result = mysqli_query($link, $sql);
    if ($result) {
        // echo '登録が完了しました' . PHP_EOL;
    } else {
        echo 'Error: データの追加に失敗しました' . PHP_EOL;
        echo 'Debugging Error:' . mysqli_error($link) . PHP_EOL;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        echo '入力された値が不正です。';
        return false;
    }

    if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    } else {
        echo 'パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。';
        return false;
    }

    $user = [
        'email' => $email,
        'password' => $password
    ];

    $link = dbConnect();
    createUser($link, $user);
    mysqli_close($link);
    include __DIR__ . '/index.php';
}
