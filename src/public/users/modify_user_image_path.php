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
    // プロフィール画像のファイル名に使用する
    $login_user = [
        'user_name' => $_SESSION['user_name'],
    ];
    $file_name = $_FILES['image']['name'];
    $user_model = new User;
    $errors = $user_model->validateUserImageUpdate($file_name);
    // バリデーション処理がOKだったら、テーブルのuser_image_path カラムに追加する
    if (!count($errors)) {
        // ファイル名を変更して、ディレクトリへ保存する
        $image = date('Ymd') . $login_user['user_name'] . '_' . $file_name;
        move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../assets/images/user_picture/' . $image);
        $_SESSION['user_image_path'] = $image;
        header("Location: profile_setting.php"); // プロフィール設定画面へ遷移する
        exit();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $_REQUEST['action'] === 'delete') {

    $login_user = [ // テーブル及びディレクトリからの削除に使用する
        'id' => $_SESSION['id'],
        'user_image_path' => $_SESSION['user_image_path'],
    ];

    $user_model = new User;
    $user_model->deleteUserImage($login_user); // users テーブルの user_image_path を削除する
    // ディレクトリの画像ファイルを削除する
    if (file_exists(__DIR__ . '/../assets/images/user_picture/' . $login_user['user_image_path'])) {
        unlink(__DIR__ . '/../assets/images/user_picture/' . $login_user['user_image_path']);
    }
    $_SESSION['user_image_path'] = ""; // session の内容を削除する
    header("Location: profile_setting.php"); // プロフィール設定画面へ遷移する
    exit();
}

// viewで表示、及び、if文（uploaded or not uploaded）に使用する
$login_user = [
    'user_image_path' => $_SESSION['user_image_path'],
];

$title = 'プロフィール画像設定-Yonde-よんで';
$content = __DIR__ . '/../../views/users/modify_user_image_path.php';
include __DIR__ . '/../../views/layout.php';
