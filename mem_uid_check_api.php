<?php

$data = file_get_contents("php://input", "r");
$mydata = array();
$mydata = json_decode($data, true);

if(isset($mydata["uid01"]) && isset($mydata["uid02"])){
    if($mydata["uid01"]!= "" && $mydata["uid02"]!= ""){

        $uid01 = $mydata["uid01"];
        $uid02 = $mydata["uid02"];
        
        require_once("dbtools.php");
        $link = create_connect();
        $sql = "SELECT Username, Password, Email FROM members WHERE UID01 = '$uid01' AND UID02 = '$uid02'";
        $result = execute_sqli($link, "naru_db", $sql);
        if(mysqli_num_rows($result)==1){
            // UID合法
            $userData = array();
            $row = mysqli_fetch_assoc($result);
            $userData[] = $row;
            echo '{"state": true, "message":"登入狀態確認成功!",  "data" : '.json_encode($userData).'}';
        }else{
            //UID非法
            echo '{"state": false, "message":"登入狀態確認失敗!'.mysqli_error($link).'"}';
        }
        mysqli_close($link);
    }else{
        echo '{"state": false, "message":"欄位不得為空白!"}';
    }
}else{
    echo '{"state": false, "message":"缺少規定欄位!"}';
}



?>