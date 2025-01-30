<?php
$username = $_GET['username'];
$password = $_GET['password'];
$email = $_GET['email'];

include '../../dataManager/DataManager.php';

$dm = new DataManager();
$dm->setDataPath("../../dataManager/data/data.json");

include '../../templates/default/header.html';
include '../../templates/default/nav.html';

if ($dm->addUser($username, $password, $email)) {
    session_start();
    $_SESSION['user'] = $username; // 设置session
    header("Location: /index.php");
}
else {
    echo "注册失败，您要求的用户名已被注册.";
}

include '../../templates/default/footer.html';