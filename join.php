<?php
/* 
Sepocatch ICP v6.

author: DKoTechnology
*/

$title = "加入";
$is_creator = false;

// 判断是否登录，session
session_start();
if (!isset($_SESSION['user'])) {
    $is_loggedin = true;
    include './templates/default/header.html';
    include './templates/default/nav.html';
    echo '<h1 style="margin-left: 27px;">请登录后再加入。</h1>';
    include './templates/default/footer.html';
    exit();
}
else {
    $is_loggedin = false;
    
}

if (!isset($_GET["page"])) {
    header("Location: /join.php?page=1");
}

if ($_GET["page"] == "4") {
    include './dataManager/DataManager.php';
    $dm = new DataManager();
    if (ctype_digit($_GET['name']) || ctype_digit($_GET['domain']) || ctype_digit($_GET['description'])) {
        include './templates/default/header.html';
        include './templates/default/nav.html';
        echo '<h1 style="margin-left: 27px;">名称、域名和描述不能为纯数字。</h1>';
        include './templates/default/footer.html';
        exit();
    }
    $dm->addRecord($_GET['name'], $_SESSION['user'], $_GET['domain'], $_GET['description'], $_GET['number']);
}

include './templates/default/header.html';
include './templates/default/nav.html';
include './templates/default/join_page'. $_GET["page"] .'.html';
include './templates/default/footer.html';