<?php

declare(strict_types=1);

require_once __DIR__ . '/../../lib/escape.php';
require_once __DIR__ . '/../../lib/user.php';

session_start(); // 既存のセッションを再開

/**
 * 設定ボタンを押したら、プロフィール画像をバリデーション処理し、OKだったらプロフィール画像に設定する。
 * もしくは、
 * 削除ボタンを押したら、プロフィール画像を削除する（テーブル及びディレクトリからの削除）。
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_REQUEST['action'] === 'update') {
    $login_user = [
        'id' => $_SESSION['id'], // usersテーブルへの追加時に使用する
        'user_name' => $_SESSION['user_name'], // プロフィール画像のファイル名に使用する
    ];
    $upload_file_name = $_FILES['image']['name'];
    $user_model = new User;
    $errors = $user_model->validateUserIconUpdate($upload_file_name);
    // バリデーション処理がOKだったら、テーブルのuser_icon カラムに追加する
    if (!count($errors)) {
        // ファイル名を変更して、ディレクトリへ保存する
        $uploaded_file_name = date('Ymd') . $login_user['user_name'] . '_' . $upload_file_name;
        move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../assets/images/user_icon/' . $uploaded_file_name);
        $user_model->updateUserIcon($login_user, $uploaded_file_name); //テーブルのuser_icon カラムに追加
        $_SESSION['user_icon'] = $uploaded_file_name; // session の内容を上書きする
        header("Location: profile_setting.php"); // プロフィール設定画面へ遷移する
        exit();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $_REQUEST['action'] === 'delete') {

    $login_user = [ // ディレクトリ及びテーブルからの削除に使用する
        'id' => $_SESSION['id'],
        'user_icon' => $_SESSION['user_icon'],
    ];
    // ディレクトリの画像ファイルを削除する
    if (file_exists(__DIR__ . '/../assets/images/user_icon/' . $login_user['user_icon'])) {
        unlink(__DIR__ . '/../assets/images/user_icon/' . $login_user['user_icon']);
    }
    $user_model = new User;
    $user_model->deleteUserIcon($login_user); // users テーブルの user_icon を削除する
    $_SESSION['user_icon'] = ""; // session の内容を削除する
    header("Location: profile_setting.php"); // プロフィール設定画面へ遷移する
    exit();
}

// viewで表示、及び、if文（uploaded or not uploaded）に使用する
$login_user = [
    'user_icon' => $_SESSION['user_icon'],
];

$title = 'プロフィール画像設定-Yonde-よんで';
$content = __DIR__ . '/../../views/users/modify_user_icon.php';
include __DIR__ . '/../../views/layout.php';
