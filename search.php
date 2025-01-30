<?php
/* 
Sepocatch ICP v6.

author: DKoTechnology
*/

$title = "搜索";
$is_creator = false;

// 判断是否登录，session
session_start();
if (isset($_SESSION['user'])) {
    $is_loggedin = true;
}
else {
    $is_loggedin = false;
}

// 再判断有没有 keyword
if (isset($_GET['keyword'])) {
    
    include './dataManager/DataManager.php';
    $dm = new DataManager();
    $data = $dm->getRecords($_GET['keyword']) [0];
    if ($data == null) {
        $data = [];

    }
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
    $Name = $data['Name'];
    $Domain = $data['Domain'];
    $Description = $data['Description'];
    $Creator = $data['Creator'];
    $CreateTime = $data['CreateTime'];
    $Status = $data['Status'];
    // 初始化cURL
    $ch = curl_init();

    // 设置cURL选项
    curl_setopt($ch, CURLOPT_URL, "https://". $domain ."");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // 执行cURL请求
    $content = curl_exec($ch);
    if(curl_errno($ch)) {
        $isTakingLink = "<font style='color: red;'>网页不可达</font>";
    }

    // 创建一个新的DOMDocument实例
    $dom = new DOMDocument;

    // 加载网页内容
    libxml_use_internal_errors(true); // 禁用libxml错误，避免HTML中的不规范标签导致的警告
    set_time_limit(30);
    try {
        $dom->loadHTMLFile("https://". $domain ."/");
    }
    catch (Exception $e) {
        $isTakingLink = "<font style='color: red;'>网页不可达</font>";
    }

    // 查找所有的<a>标签
    $links = $dom->getElementById("SepocatchICPv5Link");


    // 检查是否找到了<a>标签
    if ($links) {
        $isTakingLink = "已携带链接";
    }
    else {
        $isTakingLink = "<font style='color: red;'>未携带链接</font>";
    }

    curl_close($ch);
    $Number = $data['Number'];
}
else {
    $data = []; // 没有数据
}

include './templates/default/header.html';
include './templates/default/nav.html';
if ($data == [] && !isset($_GET['keyword'])) {
    include './templates/default/search.html';
}
else if ($data != []) {
    include './templates/default/result.html';
}
else {
    include './templates/default/noresult.html';
}
include './templates/default/footer.html';