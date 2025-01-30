<?php
$username = $_GET['username'];
$password = $_GET['password'];

include '../../dataManager/DataManager.php';

$dm = new DataManager();
$dm->setDataPath("../../dataManager/data/data.json");

$title = "登录";
$is_loggedin = true;
$is_creator = false;


include '../../templates/default/header.html';
include '../../templates/default/nav.html';
if ($dm->checkUser($username, $password)) {
    session_start();
    $_SESSION['user'] = $username; // 设置session
    include '../../templates/default/loginsuccess.html';
} else {
    $is_loggedin = false;
    $is_creator = false;
    include '../../templates/default/loginfail.html';
}
include '../../templates/default/footer.html';