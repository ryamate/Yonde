<?php
session_start();
$_SESSION = array();
session_destroy();
var_export($_SESSION);

$title = 'よんで-Yonde-';
$content = __DIR__ . '/views/index.php';
include __DIR__ . '/views/layout_before_login.php';
