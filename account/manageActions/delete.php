<?php

$title = "删除域名";
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

if (isset($_GET['confirmed'])) {
    include '../../dataManager/DataManager.php';
    $dm = new DataManager();
    $dm->removeRecord($_GET['domain']);
}

include '../../templates/default/header.html';
include '../../templates/default/nav.html';
?>

<div class="container">
    <h1>控制台</h1>
    <h2>欢迎回到控制台，<?php echo $_SESSION['user'];?>。</h2>
    <br>
    <h3 style="color: red;">您正在：删除 <?php echo $_GET ['domain'];?></h3>
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
    <p>每个用户删除备案前，系统不会备份所有信息。</p>
    <p style="color: red;">虽然人工会手动备份，但是若回档将会影响所有新的操作，若操作过多，我们将拒绝回档。因此，请慎重！</p>
    <mdui-button variant="elevated" style="margin-top: 27px; width: 200px;" href="./delete.php?domain=<?php echo $_GET['domain'];?>&confirmed=true">确认删除</mdui-button>
</div>