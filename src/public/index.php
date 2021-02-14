<?php

declare(strict_types=1); // 厳密な型付けを宣言

session_start(); // 新しいセッションを開始、あるいは既存のセッションを再開する
$_SESSION = array(); // 全てのセッション変数を削除する
session_destroy(); // セッションに登録されたデータを全て破棄する

$title = '-Yonde-よんで';
$content = __DIR__ . '/../views/index.php';
include __DIR__ . '/../views/layout_before_login.php';
