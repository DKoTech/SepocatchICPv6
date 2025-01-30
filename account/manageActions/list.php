<?php

$title = "列出域名";
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

include '../../templates/default/header.html';
include '../../templates/default/nav.html';
?>

<div class="container">
    <h1>控制台</h1>
    <h2>欢迎回到控制台，<?php echo $_SESSION['user'];?>。</h2>
    <br>
    <h3>您正在：列出注册的域名</h3>
    <mdui-list>
        <?php
        include '../../dataManager/DataManager.php';
        $dm = new DataManager();
        $dm->setDataPath("../../dataManager/data/data.json");
        $results = $dm->getAllRecordsByCreator($_SESSION['user']);
        foreach ($results as $result) {
            echo '<mdui-list-item headline="'. $result ['Domain'] .'" description="点击编辑" href="./edit.php?domain=' . $result ['Domain'] . '&number='. $result ['Number'] .'"></mdui-list-item>';
        }
        ?>
    </mdui-list>
</div>
<!-- 妈的 mdui 怎么这么好看 -->

<?php include '../../templates/default/footer.html'; ?>