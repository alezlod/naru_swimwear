<?php

$data = file_get_contents("php://input","r");
$mydata = array();
$mydata = json_decode($data,true);

if(isset($mydata["username"])){
    if($mydata["username"]!= ""){

        $username = $mydata["username"];

        require_once("dbtools.php");
        $link = create_connect();
        $sql = "SELECT Username FROM members WHERE Username = '$username'";
        $result = execute_sqli($link, "naru_db", $sql);
        if(mysqli_num_rows($result)==1){
            echo '{"state":false,"message":"帳號已註冊過"}';
        }else{
            echo '{"state":true,"message":"帳號可使用"}';
        }
        
        mysqli_close($link);
    }else{
        echo '{"state":false,"message":"欄位不得為空白"}';
    }
}else{
    echo '{"state":false,"message":"缺少規定欄位"}';
}


?>