<?php

declare(strict_types=1); // 厳密な型付けを宣言

require_once __DIR__ . '/../../lib/escape.php';
require_once __DIR__ . '/../../lib/user.php';

session_start(); // 新しいセッションを開始、あるいは既存のセッションを再開する

/**
 * 新規登録フォーム画面から POST されたら、バリデーション処理し、エラーがなければ、新規登録確認画面へ遷移する。
 * もしくは、
 * 初めて index.php から遷移してきた場合、新規でフォーム画面を表示する。
 * もしくは、
 * 新規登録確認画面から「修正する」ボタンで戻ってきた場合、値が残った状態でフォーム画面を表示する。
 */
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
        $_SESSION['join'] = $_POST;
        // プロフィール画像選択ありの場合、名前をつけてアップロードする
        if (!empty($file_name)) {
            $image = date('Ymd') . $user['user_name'] . '_' . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../assets/images/user_icon/' . $image);
            $_SESSION['join']['image'] = $image;
        }
        // 新規登録確認画面へ遷移する
        header("Location: check_signup.php");
        exit();
    }
} elseif (!isset($_REQUEST['action'])) {
    // views/auth/signup.php での未定義エラー防止のため、$user、$errors のカラ配列を用意する
    $user = [
        'email' => '',
        'user_name' => '',
        'password' => ''
    ];
    $errors = [];
} elseif ($_REQUEST['action'] === 'rewrite' && isset($_SESSION['join'])) {
    $_POST = $_SESSION['join'];
    $user = [
        'email' => $_POST['email'],
        'user_name' => $_POST['user_name'],
        'password' => $_POST['password']
    ];
}


$title = 'よんで-Yonde-新規登録';
$content = __DIR__ . '/../../views/auth/signup.php';
include __DIR__ . '/../../views/layout_before_login.php';
