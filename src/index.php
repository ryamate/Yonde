<?php
session_start();
$_SESSION = array();
session_destroy();

$title = 'よんで-Yonde-';
$content = __DIR__ . '/views/index.php';
include __DIR__ . '/views/layout_before_login.php';
