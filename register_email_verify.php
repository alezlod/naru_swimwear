<?php

$data = file_get_contents("php://input","r");
$mydata = array();
$mydata = json_decode($data,true);

if(isset($mydata["email"])){
    if($mydata["email"] != ""){

        $email = $mydata["email"];

        require_once("dbtools.php");
        $link = create_connect();
        $sql = "SELECT Email From members WHERE Email = '$email'";
        $result = execute_sqli($link, "naru_db", $sql);
        if(mysqli_num_rows($result)==1){
            echo '{"state":false,"message":"信箱已註冊過"}';
        }else{
            echo '{"state":true,"message":"信箱可使用"}';
        }
        mysqli_close($link);
    }else{
         echo '{"state":false,"message":"欄位不得空白"}';
    }
}else{
    echo '{"state":false,"message":"缺少欄位"}';
}


?>