<?php

declare(strict_types=1);

require_once __DIR__ . '/../../lib/escape.php';
require_once __DIR__ . '/../../lib/user.php';

session_start(); // 既存のセッションを再開

// HTMLで表示する
$login_user = $_SESSION;

$title = 'プロフィール設定-Yonde-よんで';
$content = __DIR__ . '/../../views/users/profile_setting.php';
include __DIR__ . '/../../views/layout.php';
