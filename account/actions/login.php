<?php
$username = $_GET['username'];
$password = $_GET['password'];

include '../../dataManager/DataManager.php';

$dm = new DataManager();
$dm->setDataPath("../../dataManager/data/data.json");


include '../../templates/default/header.html';
include '../../templates/default/nav.html';

if ($dm->checkUser($username, $password)) {
    $title = "登录成功";
    $is_loggedin = true;
    $is_creator = false;
    session_start();
    $_SESSION['user'] = $username; // 设置session
    include '../../templates/default/loginsuccess.html';
} else {
    $title = "登录失败";
    $is_loggedin = false;
    $is_creator = false;
    include '../../templates/default/loginfail.html';
}

include '../../templates/default/footer.html';