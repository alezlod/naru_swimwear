<?php

//input {"id":"OOO", "userState":"y"}

$data = file_get_contents("php://input","r");
$mydata = array();
$mydata = json_decode($data, true); 

if(isset($mydata["id"])&&isset($mydata["userState"])){
    if($mydata["id"]!= "" && $mydata["userState"]!= ""){
        $p_id = $mydata["id"];
        $p_userState = $mydata["userState"];
        
        require_once("dbtools.php");
        $link = create_connect();
        $sql = "UPDATE members SET UserState = '$p_userState' WHERE ID = '$p_id'";
        if (execute_sqli($link,"naru_db",$sql)){
            echo '{"state":true, "message":"更新會員狀態成功"}';
        }else{
            echo '{"state":false, "message":"更新會員狀態失敗"}'; 
        }
        mysqli_close($link);
    }else{
        echo '{"state":false, "message":"欄位不得為空白"}';
    }
}else{
    echo '{"state":false, "message":"缺少規定欄位"}';
}



?>