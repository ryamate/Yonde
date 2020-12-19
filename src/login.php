<?php

require_once __DIR__ . '/lib/escape.php';
require_once __DIR__ . '/lib/mysqli.php';

function getEmail($link, $entered_email)
{
    $sql = "SELECT * from users where email = '$entered_email'";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);

    mysqli_free_result($result);

    return $row;
}

session_start();
//POSTのvalidate
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    echo '入力された値が不正です。';
    return false;
}
//DB内でPOSTされたメールアドレスを検索
$entered_email = $_POST['email'];
$link = dbConnect();
$row = getEmail($link, $entered_email);

//emailがDB内に存在しているか確認
if (!isset($row['email'])) {
    echo 'メールアドレス又はパスワードが間違っています。';
    return false;
}
//パスワード確認後sessionにメールアドレスを渡す
if (password_verify($_POST['password'], $row['password'])) {
    session_regenerate_id(true); //session_idを新しく生成し、置き換える
    $_SESSION['EMAIL'] = $row['email'];
    echo 'ログインしました';
} else {
    echo 'メールアドレス又はパスワードが間違っています。';
    return false;
}
