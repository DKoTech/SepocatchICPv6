<?php

$title = "修改域名";
$is_creator = false;

session_start(); // 启动会话，以便使用 $_SESSION 变量
if (isset($_SESSION['user'])) { // 检查会话中是否存在 'user' 键
    $is_loggedin = true; // 如果存在，表示用户已登录，设置 $is_loggedin 为 true
}
else {
    $is_loggedin = false; // 如果不存在，表示用户未登录，设置 $is_loggedin 为 false
    header("Location: ../index.php"); // 如果用户已登录，重定向到 ../index.php 页面
    exit(); // 终止脚本执行，确保重定向立即生效
}

if (!isset($_GET['domain'])) {
    header("Location: ./list.php");
    exit();
}

if (isset($_GET['mode'])) {
    include '../../dataManager/DataManager.php';
    $dm = new DataManager();
    $dm->changeInfo($_GET['name'], $_GET['domain'], $_GET['description'],$_GET['number']);
    header("Location: ../manage.php");
}

include '../../templates/default/header.html';
include '../../templates/default/nav.html';
?>

<div class="container">
    <h1>控制台</h1>
    <h2>欢迎回到控制台，<?php echo $_SESSION['user'];?>。</h2>
    <br>
    <h3>您正在：修改 <?php echo $_GET ['domain'];?></h3>
    <!--
    /* 
    保存以下数据：
    Name: 名称
    Domain: 域名
    Description: 介绍
    Creator: 创建者
    CreateTime: 创建时间
    Status: 当前状态
    IsTakingLink: 是否带有备案链接
    Number: 号码
    */
    -->
    <form action="/edit.php" method="get" style="width: 200px;">
        <mdui-text-field label="名称" style="margin-top: 27px;" name="name" type="text" required></mdui-text-field>
        <mdui-text-field label="域名" style="margin-top: 27px;" name="domain" type="text" required></mdui-text-field>
        <mdui-text-field label="介绍" style="margin-top: 27px;" name="description" type="text" required></mdui-text-field>
        <input type="text" name="number" value="<?php echo $_GET['number'];?>" hidden>
        <input type="text" name="mode" value="real-edit" hidden>
        <mdui-button variant="elevated" style="margin-top: 27px; width: 200px;" type="submit">修改</mdui-button>
    </form>
    <mdui-button variant="elevated" style="margin-top: 27px; width: 200px;" href="./delete.php?domain=<?php echo $_GET['domain'];?>">删除</mdui-button>
</div>