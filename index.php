<?php
/* 
Sepocatch ICP v6.

author: DKoTechnology
*/

$title = "首页";
$is_creator = false;

// 判断是否登录，session
session_start();
if (isset($_SESSION['user'])) {
    $is_loggedin = true;
}
else {
    $is_loggedin = false;
}

include './templates/default/header.html';
include './templates/default/nav.html';
include './templates/default/index.html';
include './templates/default/footer.html';