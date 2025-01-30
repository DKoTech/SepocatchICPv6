<?php
/* 
Sepocatch Virtual ICP v6

DataManager

用于管理备案和登录数据.
only using json.
*/


class DataManager 
{
    public string $dataFile = "./dataManager/data/data.json";

    public function __construct()
    {
        if (!file_exists($this->dataFile)) {
            mkdir(dirname($this->dataFile), 0777, true);
            $this->initData();
        }
    }

    public function initData()
    {
        $data = array(
            "users" => array(),
            "records" => array()
        );
        $this->saveData($data);
    }

    public function saveData($data)
    {
        file_put_contents($this->dataFile, json_encode($data));
    }

    public function loadData()
    {
        return json_decode(file_get_contents($this->dataFile), true);
    }

    public function addUser($username, $password, $email)
    {
        $data = $this->loadData();
        // password 用 md5
        $data["users"][$username] = array(
            "password" => md5($password),
            "email" => $email
        );
        $this->saveData($data);
    }

    public function addRecord($name, $username, $domain, $description, $number)
    {
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
        $data = $this->loadData();
        $data["records"][] = array(
            "Name" => $name,
            "Domain" => $domain,
            "Description" => $description,
            "Creator" => $username,
            "CreateTime" => date("Y-m-d H:i:s"),
            "Status" => "正常",
            "IsTakingLink" => false,
            "Number" => $number,
        );
        $this->saveData($data);
    }

    public function checkUser($username, $password){
        $data = $this->loadData();
        if (isset($data["users"][$username]) && $data["users"][$username] == md5($password)) {
            return true;
        } else {
            return false;
        }
    }

    public function getRecords($domain_or_number){
        // 判断是域名还是号码，号码纯数字
        $isnumber = false;
        if (ctype_digit($domain_or_number)) {
            $isnumber = true;
        }
        $data = $this->loadData();
        $records = array();
        foreach ($data["records"] as $record) {
            if ($isnumber) {
                if ($record["Number"] == $domain_or_number) {
                    $records[] = $record;
                }
            } else {
                if ($record["Domain"] == $domain_or_number) {
                    $records[] = $record;
                }
            }
        }
        return $records;
    }

    public function getAllRecords() {
        $data = $this->loadData();
        return $data["records"];
    }

    public function changeInfo($name = "", $domain = "", $description = "", $number) {
        $data = $this->loadData();
        foreach ($data["records"] as $key => $record) {
            if ($record["Number"] == $number) {
                if ($name != "") {
                    $data["records"][$key]["Name"] = $name;
                }
                if ($domain != "") {
                    $data["records"][$key]["Domain"] = $domain;
                }
                if ($description != "") {
                    $data["records"][$key]["Description"] = $description;
                }
                $this->saveData($data);
                return true;
            }
        }
    }

    public function setTakingLink($number, $isTakingLink) {
        $data = $this->loadData();
        foreach ($data["records"] as $key => $record) {
            if ($record["Number"] == $number) {
                $data["records"][$key]["IsTakingLink"] = $isTakingLink;
                $this->saveData($data);
                return true;
            }
        }
    }

    public function setRecordStatus($number, $status) {
        $data = $this->loadData();
        foreach ($data["records"] as $key => $record) {
            if ($record["Number"] == $number) {
                $data["records"][$key]["Status"] = $status;
                $this->saveData($data);
                return true;
            }
        }
    }

    public function checkAvalibleName($name) {
        $data = $this->loadData();
        if (in_array($name, $data["users"])) {
            return false;
        }
        return true;
    }

    public function checkAvalibleNumber($name) {
        $data = $this->loadData();
        foreach ($data["records"] as $record) {
            if ($record["Number"] == $name) {
                return false;
            }
        }
        return true;
    }

    public function getAllRecordsByCreator($creator) {
        $data = $this->loadData();
        $records = array();
        foreach ($data["records"] as $record) {
            if ($record["Creator"] == $creator) {
                $records[] = $record;
            }
        }
        return $records;
    }

    public function setDataPath($path) {
        $this->dataFile = $path;
    }

    public function getDataPath() {
        return $this->dataFile;
    }

    public function removeRecord($domain) {
        $data = $this->loadData();
        foreach ($data["records"] as $key => $record) {
            if ($record["Domain"] == $domain) {
                unset($data["records"][$key]);
                $this->saveData($data);
                return true;
            }
        }
    }
}