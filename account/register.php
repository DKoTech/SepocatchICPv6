<?php

$title = "注册";
$is_creator = false;

session_start(); // 启动会话，以便使用 $_SESSION 变量
if (isset($_SESSION['user'])) { // 检查会话中是否存在 'user' 键
    $is_loggedin = true; // 如果存在，表示用户已登录，设置 $is_loggedin 为 true
}
else {
    $is_loggedin = false; // 如果不存在，表示用户未登录，设置 $is_loggedin 为 false
}

if ($is_loggedin) { // 检查 $is_loggedin 的值
    header("Location: ../index.php"); // 如果用户已登录，重定向到 ../index.php 页面
    exit(); // 终止脚本执行，确保重定向立即生效
}

include '../templates/default/header.html';
include '../templates/default/nav.html';
include '../templates/default/register.html';
include '../templates/default/footer.html';
?>