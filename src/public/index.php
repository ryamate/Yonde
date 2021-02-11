<?php

declare(strict_types=1);

session_start();
$_SESSION = array();
session_destroy();

$title = '-Yonde-よんで';
$content = __DIR__ . '/../views/index.php';
include __DIR__ . '/../views/layout_before_login.php';
